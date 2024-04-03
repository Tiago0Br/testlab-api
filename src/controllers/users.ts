import { RequestHandler } from 'express'
import * as user from '../services/users'
import * as userSchema from '../schemas/users'
import bcrypt from 'bcrypt'
import { showZodErrors } from '../utils'

export const create: RequestHandler = async (req, res) => {
    const body = userSchema.create.safeParse(req.body)
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
    const params = userSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const userFound = await user.getById(params.data.id)
    if (!userFound) return res.status(404).json({ error: 'Usuário não encontrado' })

    res.status(200).json({
        user: userFound
    })
}

export const getUserProjects: RequestHandler = async (req, res) => {
    const params = userSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const userProjects = await user.getUserProjects(params.data.id)
    if (!userProjects) return res.status(404).json({ error: 'Usuário não encontrado' })

    res.status(200).json({
        data: userProjects
    })
}