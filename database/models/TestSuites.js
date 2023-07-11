const Sequelize = require('sequelize')
const Folder = require('./Folders')
const connection = require('../index')

const TestSuite = connection.define('testSuites', {
    title: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Título da Suíte de testes'
    },
    folderId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: Folder,
            key: 'id'
        },
        comment: 'ID da pasta em que a suíte de testes foi criada'
    }
})

module.exports = TestSuite