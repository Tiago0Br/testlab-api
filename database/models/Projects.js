const Sequelize = require('sequelize')
const User = require('./Users')
const connection = require('../index')

const Project = connection.define('projects', {
    name: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Nome do projeto'
    },
    description: {
        type: Sequelize.TEXT('medium'),
        allowNull: true,
        comment: 'Descrição do projeto'
    },
    ownerUserId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: User,
            key: 'id'
        },
        comment: 'ID do usuário criador do projeto'
    }
})

module.exports = Project