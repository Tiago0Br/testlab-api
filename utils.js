const jwt = require('jsonwebtoken')

function checkToken(req, res, next) {
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]

    if (!token) {
        return res.status(401).json({
            error: 'Acesso negado'
        })
    }

    try {
        const { SECRET } = process.env
        jwt.verify(token, SECRET)

        next()
    } catch (error) {
        res.status(400).json({
            error: 'Token inválido'
        })
    }
}

module.exports = {
    checkToken
}