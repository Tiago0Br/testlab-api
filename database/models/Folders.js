const Sequelize = require('sequelize')
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
        comment: 'ID do projeto em que essa pasta foi criada'
    }
})

Folder.sync({ force: false }).then(() => {})

module.exports = Folder