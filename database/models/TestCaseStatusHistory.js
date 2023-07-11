const Sequelize = require('sequelize')
const User = require('./Users')
const TestCase = require('./TestCases')
const connection = require('../index')

const TestCaseStatusHistory = connection.define('testCaseStatusHistory', {
    testCaseId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: TestCase,
            key: 'id'
        },
        comment: 'ID do caso de teste'
    },
    userId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: User,
            key: 'id'
        },
        comment: 'ID do usuário que alterou o status do caso de teste'
    },
    status: {
        type: Sequelize.STRING(30),
        allowNull: false,
        comment: 'status do caso de teste'
    },
    note: {
        type: Sequelize.STRING,
        allowNull: true,
        comment: 'Comentário sobre a mudança de status do caso de teste'
    }
}, { updatedAt: false })

module.exports = TestCaseStatusHistory