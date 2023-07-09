const router = require('express').Router()
const ProjectModel = require('../database/models/Projects')

router.route('/').post(async (req, res) => {
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
})

module.exports = router