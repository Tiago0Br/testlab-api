const { Sequelize } = require('sequelize')
require('dotenv').config()

const { DB_USER, DB_PASSWORD } = process.env

const connection = new Sequelize('testlab', DB_USER, DB_PASSWORD, {
    host: 'localhost',
    dialect: 'mysql'
})

module.exports = connection