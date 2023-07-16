const FolderModel = require('../database/models/Folders')
const TestSuites = require('../database/models/TestSuites')

const folderController = {
    create: async (req, res) => {
        const { name, projectId } = req.body
        try {
            if (!name || !projectId) {
                res.status(400).json({
                    error: 'Os campos "name" e "projectId" são obrigatórios.'
                })
            } else {
                const folder = await FolderModel.create({
                    name,
                    projectId
                })
    
                res.status(201).json({
                    folder,
                    message: 'Pasta criada com sucesso.'
                })
            }
        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: `Não foi encontrado um projeto com o ID ${projectId}`
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    update: async (req, res) => {
        const { id } = req.params
        const { name, projectId } = req.body
        try {
            if (!name || !projectId) {
                return res.status(400).json({
                    error: 'Os campos "name" e "projectId" são obrigatórios.'
                })
            }

            let folder = await FolderModel.findOne({
                where: { id }
            })
    
            if (!folder) {
                return res.status(404).json({
                    error: 'Pasta não encontrada.'
                })
            }

            await FolderModel.update({
                name,
                projectId
            }, {
                where: { id }
            })

            folder = await FolderModel.findOne({
                where: { id }
            })

            res.status(200).json({
                folder
            })

        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: `Não foi encontrado um projeto com o ID ${projectId}`
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    delete: async (req, res) => {
        const { id } = req.params
        try {
            const folder = await FolderModel.findOne({
                where: { id }
            })
    
            if (!folder) {
                return res.status(404).json({
                    error: 'Pasta não encontrada.'
                })
            }

            await folder.destroy()

            res.status(200).json({
                message: 'Pasta excluída.'
            })
        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: 'A pasta possui conteúdo e não pode ser excluída'
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    getFolderTestSuites: async (req, res) => {
        const { id } = req.params
        try {
            const folder = await FolderModel.findOne({
                where: { id }
            })
    
            if (folder) {
                const testSuites = await TestSuites.findAll({
                    where: {
                        folderId: id
                    }
                })
                res.status(200).json({
                    testSuites
                })
            } else {
                res.status(404).json({
                    error: 'Pasta não encontrada.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = folderController