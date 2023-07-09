const router = require('express').Router()
const UserModel = require('../database/models/Users')

router.route('/').post(async (req, res) => {
    const { name, email, password } = req.body
    try {
        if (!name || !email || !password) {
            res.status(400).json({
                error: 'Os campos "name", "email" e "password" são obrigatórios.'
            })
        } else {
            const user = await UserModel.create({
                name,
                email,
                password
            })

            res.status(201).json({
                user,
                message: 'Usuário criado com sucesso.'
            })
        }

    } catch (error) {
        if (error.name === 'SequelizeUniqueConstraintError') {
            res.status(400).json({
                error: 'O campo "email" não pode ser repetido.'
            })
        }
        else {
            res.status(500).json({
                error
            })
        }
    }
})

module.exports = router