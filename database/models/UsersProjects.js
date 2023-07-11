const Sequelize = require('sequelize')
const User = require('./Users')
const Project = require('./Projects')
const connection = require('../index')

const UserProject = connection.define('usersProjects', {
    userId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: User,
            key: 'id'
        },
        comment: 'ID do usuário'
    },
    projectId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: Project,
            key: 'id'
        },
        comment: 'ID do projeto'
    }
}, { timestamps: false })

module.exports = UserProject