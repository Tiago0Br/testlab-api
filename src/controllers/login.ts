import { RequestHandler } from 'express'
import { getByEmail as getUserByEmail } from '../services/users'
import * as loginSchema from '../schemas/login'
import bcrypt from 'bcrypt'
import JWT from 'jsonwebtoken'
import 'dotenv/config'
import { showZodErrors } from '../utils'

export const authenticate: RequestHandler = async (req, res) => {
    const body = loginSchema.authenticate.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: showZodErrors(body.error) })
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