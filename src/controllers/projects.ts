import { RequestHandler } from 'express'
import * as project from '../services/projects'
import { z } from 'zod'
import { getByProjectId as getUserByProject } from '../services/users'

export const create: RequestHandler = async (req, res) => {
    const projectSchema = z.object({
        name: z.string(),
        description: z.string(),
        ownerUserId: z.number()
    })

    const body = projectSchema.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const createdProject = await project.create(body.data)
    if (!createdProject) {
        return res.status(500).json({ error: 'Erro ao tentar cadastrar o projeto' })
    }

    res.status(201).json({
        project: createdProject
    })
}

export const getById: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo numérico' })
    }

    const projectFound = await project.getById(params.data.id)

    if (!projectFound) {
        return res.status(404).json({ error: 'Projeto não encontrado' })
    }

    res.json({
        project: projectFound
    })
}

export const update: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const projectSchema = z.object({
        name: z.string().optional(),
        description: z.string().optional(),
        ownerUserId: z.number().optional()
    })

    const params = paramsSchema.safeParse({
        id: parseInt(req.params.id) 
    })

    const body = projectSchema.safeParse(req.body)

    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    if (!body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const updatedProject = await project.update(params.data.id, body.data);
    if (!updatedProject) {
        return res.status(500).json({ error: 'Não foi possível editar o projeto' })
    }

    res.status(200).json({
        project: updatedProject
    })
}

export const remove: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const deletedProject = await project.remove(params.data.id)
    if (!deletedProject) {
        return res.status(500).json({ error: 'Erro ao tentar excluir o projeto' })
    }

    res.status(200).json({ message: 'Projeto excluído com sucesso' })
}

export const addUserToProject: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({
        id: parseInt(req.params.id) 
    })

    const addUserSchema = z.object({
        email: z.string()
    })

    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const body = addUserSchema.safeParse(req.body)

    if (!body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const addedUser = await project.addUserToProject(params.data.id, body.data.email)
    if (!addedUser) {
        return res.status(500).json({ error: 'Não foi possível adicionar o usuário' })
    }

    res.status(201).json({ message: 'Usuário adicionado com sucesso' })
}

export const getProjectUsers: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const users = await getUserByProject(params.data.id)

    if (!users) {
        return res.status(500).json({ error: 'Erro ao tentar buscar os usuários do projeto' })
    }

    res.status(200).json({
        users
    })
}