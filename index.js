const express = require('express')
const app = express()
const cors = require('cors')
const bodyParser = require('body-parser')
const connection = require('./database')
const router = require('./routes/router')

connection.authenticate().then(() => {
    console.log('Conexão com o banco de dados efetuada com sucesso!')
}).catch(err => {
    console.log('Erro ao tentar conectar no banco', err)
})

app.use(cors())
app.use(express.json())
app.use(bodyParser.urlencoded({ extended: false }));
app.use('/', router)

app.get('/', (_, res) => {
    res.status(200).json({
        message: 'A API está online!'
    })
})

app.listen(8080, () => {
    console.log('Servidor rodando!')
})