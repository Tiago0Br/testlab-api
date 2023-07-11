const UserModel = require('../database/models/Users')
const connection = require('../database')

const userController = {
    create: async (req, res) => {
        const { name, email, password } = req.body
        try {
            if (!name || !email || !password) {
                res.status(400).json({
                    error: 'Os campos "name", "email" e "password" são obrigatórios.'
                })
            } else {
                const user = await UserModel.create({
                    name,
                    email,
                    password
                })
    
                res.status(201).json({
                    user,
                    message: 'Usuário criado com sucesso.'
                })
            }
    
        } catch (error) {
            if (error.name === 'SequelizeUniqueConstraintError') {
                res.status(400).json({
                    error: 'O campo "email" não pode ser repetido.'
                })
            }
            else {
                res.status(500).json({
                    error
                })
            }
        }
    },
    
    getById: async (req, res) => {
        const { id } = req.params
        try {
            const user = await UserModel.findOne({
                where: { id }
            })
    
            if (user) {
                res.status(200).json({
                    user
                })
            } else {
                res.status(404).json({
                    error: 'Usuário não encontrado.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    },
    
    getUserProjects: async (req, res) => {
        const { id } = req.params
        try {
            const user = await UserModel.findOne({
                where: { id }
            })
    
            if (user) {
                const query = `
                    SELECT p.* FROM projects p
                    INNER JOIN usersProjects up
                    ON p.id = up.projectId
                    INNER JOIN users u
                    ON u.id = up.userId
                    WHERE u.id = ${id};
                `
                const [ projects ] = await connection.query(query)
    
                res.status(200).json({
                    projects
                })
            } else {
                res.status(404).json({
                    error: 'Usuário não encontrado.'
                })
            }
            
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = userController