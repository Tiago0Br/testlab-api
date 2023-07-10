const router = require('express').Router()
const FolderModel = require('../database/models/Folders')

router.post('/', async (req, res) => {
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
})

module.exports = router