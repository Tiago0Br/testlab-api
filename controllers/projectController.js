const connection = require('../database')
const ProjectModel = require('../database/models/Projects')
const FolderModel = require('../database/models/Folders')
const UserProjectModel = require('../database/models/UsersProjects')

const projectController = {
    create: async (req, res) => {
        const { name, description, ownerUserId } = req.body
        try {
            if (!name || !ownerUserId) {
                res.status(400).json({
                    error: 'Os campos "name" e "ownerUserId" são obrigatórios.'
                })
            } else {
                const project = await ProjectModel.create({
                    name,
                    description,
                    ownerUserId
                })

                await UserProjectModel.create({
                    userId: ownerUserId,
                    projectId: project.id
                })

                res.status(201).json({
                    project,
                    message: 'Projeto criado com sucesso.'
                })
            }
        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: `Não foi encontrado um usuário com o ID ${ownerUserId}`
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    addUserToProject: async (req, res) => {
        const { projectId, userId } = req.body
        try {
            if (!projectId || !userId) {
                res.status(400).json({
                    error: 'Os campos "projectId" e "userId" são obrigatórios.'
                })
                return;
            }

            const result = await UserProjectModel.findAll({
                where: {
                    projectId,
                    userId
                }
            })

            if (result.length > 0) {
                res.status(400).json({
                    error: 'Usuário já faz parte do projeto'
                })
            } else {
                const userProject = await UserProjectModel.create({
                    userId,
                    projectId
                })

                res.status(201).json({
                    userProject,
                    message: 'Usuário adicionado no projeto.'
                })
            }

        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: 'Usuário e/ou projeto não encontrado(s).'
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    getById: async (req, res) => {
        const { id } = req.params
        try {
            const project = await ProjectModel.findOne({
                where: { id }
            })

            if (project) {
                res.status(200).json({
                    project
                })
            } else {
                res.status(404).json({
                    error: 'Projeto não encontrado.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    },

    getProjectUsers: async (req, res) => {
        const { id } = req.params
        try {
            const project = await ProjectModel.findOne({
                where: { id }
            })

            if (project) {
                const query = `
                SELECT u.* FROM users u
                INNER JOIN usersProjects up
                ON u.id = up.userId
                INNER JOIN projects p
                ON p.id = up.projectId
                WHERE p.id = ${id};
            `

                const [users] = await connection.query(query)
                res.status(200).json({
                    users
                })
            } else {
                res.status(404).json({
                    error: 'Projeto não encontrado.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    },

    getProjectFolders: async (req, res) => {
        const { id } = req.params
        try {
            const project = await ProjectModel.findOne({
                where: { id }
            })

            if (project) {
                const folders = await FolderModel.findAll({
                    where: {
                        projectId: id
                    }
                })
                res.status(200).json({
                    folders
                })
            } else {
                res.status(404).json({
                    error: 'Projeto não encontrado.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = projectController