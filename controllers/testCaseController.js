const TestCaseModel = require('../database/models/TestCases')
const TestCaseStatusModel = require('../database/models/TestCaseStatusHistory')

const availableStatus = [
    'Passou',
    'Com falha',
    'Em execução',
    'Cancelado',
    'Liberado'
]

const testCaseController = {
    create: async (req, res) => {
        const { title, summary, preconditions, testSuiteId, userId } = req.body
        try {
            if (!title || !summary || !testSuiteId || !userId) {
                res.status(400).json({
                    error: 'Os campos "title", "summary", "testSuiteId" e "userId" são obrigatórios.'
                })
            } else {
                const testCase = await TestCaseModel.create({
                    title,
                    summary,
                    preconditions,
                    testSuiteId
                })

                await TestCaseStatusModel.create({
                    testCaseId: testCase.id,
                    userId,
                    status: 'Não executado'
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
    },

    getStatus: async (_, res) => {
        res.status(200).json({
            status: availableStatus
        })
    },

    changeStatus: async (req, res) => {
        const { id } = req.params
        const { userId, status, note } = req.body
        try {
            const testCase = await TestCaseModel.findOne({
                where: { id }
            })

            if (!userId || !status) {
                return res.status(400).json({
                    error: 'Os campos "userId" e "status" são obrigatórios.'
                })
            }

            if (!availableStatus.includes(status)) {
                return res.status(400).json({
                    error: `Status "${status}" inválido.`
                })
            }

            if (!testCase) {
                return res.status(404).json({
                    error: 'Caso de teste não encontrado'
                })
            }

            const testCaseStatusHistory = await TestCaseStatusModel.create({
                testCaseId: id,
                userId,
                status,
                note
            })

            res.status(201).json({
                testCaseStatusHistory,
                message: 'Status alterado com sucesso.'
            })
        } catch (error) {
            if (error.name === 'SequelizeForeignKeyConstraintError') {
                res.status(400).json({
                    error: `Não foi encontrado um usuário com o ID ${userId}`
                })
            } else {
                res.status(500).json({
                    error
                })
            }
        }
    },

    getStatusHistory: async (req, res) => {
        const { id } = req.params
        try {
            const testCase = await TestCaseModel.findOne({
                where: { id }
            })

            if (!testCase) {
                return res.status(404).json({
                    error: 'Caso de teste não encontrado'
                })
            }

            const testCaseStatusHistory = await TestCaseStatusModel.findAll({
                where: { testCaseId: id }
            })

            res.status(200).json({
                testCaseStatusHistory
            })
        } catch (error) {
            res.status(500).json({
                error
            })
        }
    }
}

module.exports = testCaseController