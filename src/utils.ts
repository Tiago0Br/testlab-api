import { NextFunction, Request, Response } from 'express'
import jwt from 'jsonwebtoken'

function checkToken(req: Request, res: Response, next: NextFunction) {
    const authHeader = req.headers['authorization']
    const token = authHeader && authHeader.split(' ')[1]

    if (!token) {
        return res.status(401).json({
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

export {
    checkToken
}