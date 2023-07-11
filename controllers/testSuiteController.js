const TestSuiteModel = require('../database/models/TestSuites')
const TestCaseModel = require('../database/models/TestCases')

const testSuiteController = {
    create: async (req, res) => {
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
    },

    getSuiteTestCases: async (req, res) => {
        const { id } = req.params
        try {
            const testSuite = await TestSuiteModel.findOne({
                where: { id }
            })
    
            if (testSuite) {
                const testCases = await TestCaseModel.findAll({
                    where: {
                        testSuiteId: id
                    }
                })
                res.status(200).json({
                    testCases
                })
            } else {
                res.status(404).json({
                    error: 'Suíte de testes não encontrada.'
                })
            }
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = testSuiteController