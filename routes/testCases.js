const router = require('express').Router()
const TesteCaseModel = require('../database/models/TestCases')

router.post('/', async (req, res) => {
    const { title, summary, preconditions, testSuiteId } = req.body
    try {
        if (!title || !summary || !testSuiteId) {
            res.status(400).json({
                error: 'Os campos "title", "summary" e "testSuiteId" são obrigatórios.'
            })
        } else {
            const testCase = await TesteCaseModel.create({
                title,
                summary,
                preconditions,
                testSuiteId
            })

            res.status(201).json({
                testCase,
                message: 'Caso de testes criado com sucesso.'
            })
        }
    } catch (error) {
        if (error.name === 'SequelizeForeignKeyConstraintError') {
            res.status(400).json({
                error: `Não foi encontrada uma suíte de testes com o ID ${testSuiteId}`
            })
        } else {
            res.status(500).json({
                error
            })
        }
    }
})

module.exports = router