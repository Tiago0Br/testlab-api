import { RequestHandler } from 'express'
import jwt from 'jsonwebtoken'
import { ZodError } from 'zod'

export const checkToken: RequestHandler = (req, res, next) => {
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

export const showZodErrors = (error: ZodError) => {
    const errors = error.errors.map(error => error.message)
    return errors[0]
}

export enum TestCaseStatus {
    NAO_EXECUTADO = 'Não executado',
    EM_EXECUCAO = 'Em execução',
    PASSOU = 'Passou',
    COM_FALHA = 'Com falha',
    BLOQUEADO = 'Bloqueado',
    CANCELADO = 'Cancelado',
    LIBERADO = 'Liberado'
}