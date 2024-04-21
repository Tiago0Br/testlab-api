import { RequestHandler } from 'express'
import jwt from 'jsonwebtoken'

export const checkToken: RequestHandler = (req, res, next) => {
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]

    if (!token) {
        return res.status(401).send({
            error: 'Acesso negado'
        })
    }

    try {
        const SECRET = process.env.SECRET!
        jwt.verify(token, SECRET)

        next()
    } catch (error) {
        res.status(400).json({
            error: 'Token inválido'
        })
    }
}