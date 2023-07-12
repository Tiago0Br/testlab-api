const UserModel = require('../database/models/Users')
const bcrypt = require('bcrypt')
const JWT = require('jsonwebtoken')
const { SECRET } = process.env

const loginController = {
    authenticate: async (req, res) => {
        const { email, password } = req.body
        try {
            if (!email || !password) {
                return res.status(400).json({
                    error: 'Os campos "email" e "password" são obrigatórios.'
                })
            }

            const user = await UserModel.findOne({
                where: { email }
            })

            if (!user) {
                return res.status(404).json({
                    error: 'Usuário não encontrado.'
                })
            }

            const checkPassword = await bcrypt.compare(password, user.password)

            if (!checkPassword) {
                return res.status(400).json({
                    error: 'Senha inválida.'
                })
            }

            const token = JWT.sign({ id: user.id }, SECRET)
            const userResponse = { id: user.id, name: user.name, email: user.email }
            res.status(201).json({
                message: 'Login efetuado com sucesso',
                user: userResponse,
                token
            })

        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = loginController