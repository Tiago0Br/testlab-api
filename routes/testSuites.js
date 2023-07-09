const router = require('express').Router()
const TestSuiteModel = require('../database/models/TestSuites')

router.route('/').post(async (req, res) => {
    const { title, folderId } = req.body
    try {
        if (!title || !folderId) {
            res.status(400).json({
                error: 'Os campos "title" e "folderId" são obrigatórios.'
            })
        } else {
            const testSuite = await TestSuiteModel.create({
                title,
                folderId
            })

            res.status(201).json({
                testSuite,
                message: 'Suíte de testes criada com sucesso.'
            })
        }
    } catch (error) {
        if (error.name === 'SequelizeForeignKeyConstraintError') {
            res.status(400).json({
                error: `Não foi encontrada uma pasta com o ID ${folderId}`
            })
        } else {
            res.status(500).json({
                error
            })
        }
    }
})

module.exports = router