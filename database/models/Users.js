const Sequelize = require('sequelize')
const connection = require('../index')

const User = connection.define('users', {
    name: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Nome do usuário'
    },
    email: {
        type: Sequelize.STRING,
        allowNull: false,
        unique: true,
        comment: 'E-mail do usuário'
    },
    password: {
        type: Sequelize.STRING,
        allowNull: false,
        comment: 'Senha criptografada do usuário'
    }
})

User.sync({ force: false }).then(() => {})

module.exports = User