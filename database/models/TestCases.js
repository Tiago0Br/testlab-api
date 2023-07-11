const Sequelize = require('sequelize')
const TestSuite = require('./TestSuites')
const connection = require('../index')

const TestCase = connection.define('testCases', {
    title: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Título do caso de teste'
    },
    summary: {
        type: Sequelize.TEXT('medium'),
        allowNull: false,
        comment: 'Descrição do teste'
    },
    preconditions: {
        type: Sequelize.TEXT('medium'),
        allowNull: true,
        comment: 'Pré-condições do teste'
    },
    testSuiteId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: TestSuite,
            key: 'id'
        },
        comment: 'ID da suíte de testes a qual esse caso pertence'
    },
})

module.exports = TestCase