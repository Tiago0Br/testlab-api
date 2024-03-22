import { RequestHandler } from 'express'
import { z } from 'zod'
import { getByEmail as getUserByEmail } from '../services/users'
import bcrypt from 'bcrypt'
import JWT from 'jsonwebtoken'
import 'dotenv/config'

export const authenticate: RequestHandler = async (req, res) => {
    const loginSchema = z.object({
        email: z.string(),
        password: z.string()
    })

    const body = loginSchema.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: 'Os campos "email" e "password" são obrigatórios.' })
    }

    const user = await getUserByEmail(body.data.email)
    if (!user) {
        return res.status(400).json({ error: 'E-mail e/ou senha inválida.' })
    }

    const checkPassword = await bcrypt.compare(body.data.password, user.password)

    if (!checkPassword) {
        return res.status(400).json({ error: 'E-mail e/ou senha inválida.' })
    }

    const token = JWT.sign({ id: user.id }, process.env.SECRET!)
    const userResponse = { ...user, password: undefined }
    res.status(201).json({
        message: 'Login efetuado com sucesso',
        user: userResponse,
        token
    })
}