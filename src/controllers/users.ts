import { RequestHandler } from 'express'
import { z } from 'zod'
import * as user from '../services/users'
import bcrypt from 'bcrypt'

export const create: RequestHandler = async (req, res) => {
    const userSchema = z.object({
        fullname: z.string(),
        email: z.string(),
        password: z.string()
    })

    const body = userSchema.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const salt = await bcrypt.genSalt(12)
    const passwordHash = await bcrypt.hash(body.data.password, salt)
    const data = {
        ...body.data,
        password: passwordHash
    }

    const createdUser = await user.create(data)
    if (!createdUser) return res.status(500).json({ error: 'Não foi possível criar o usuário' })

    res.status(201).json({
        user: createdUser
    })
}

export const getById: RequestHandler = async (req, res) => {
    const UserParamsSchema = z.object({
        id: z.number()
    })

    const params = UserParamsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O "id" deve ser enviado e do tipo numérico' })
    }

    const userFound = await user.getById(params.data.id)
    if (!userFound) return res.status(404).json({ error: 'Usuário não encontrado' })

    res.status(200).json({
        user: userFound
    })
}

export const getUserProjects: RequestHandler = async (req, res) => {
    const UserParamsSchema = z.object({
        id: z.number()
    })

    const params = UserParamsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O "id" deve ser enviado e do tipo numérico' })
    }

    const userProjects = await user.getUserProjects(params.data.id)
    if (!userProjects) return res.status(404).json({ error: 'Usuário não encontrado' })

    res.status(200).json({
        data: userProjects
    })
}