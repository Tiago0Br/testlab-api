const Sequelize = require('sequelize')
const Project = require('./Projects')
const connection = require('../index')

const Folder = connection.define('folders', {
    name: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Nome da pasta'
    },
    projectId: {
        type: Sequelize.INTEGER,
        allowNull: false,
        references: {
            model: Project,
            key: 'id'
        },
        comment: 'ID do projeto em que essa pasta foi criada'
    }
})

module.exports = Folder