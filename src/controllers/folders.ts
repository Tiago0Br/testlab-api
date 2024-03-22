import { RequestHandler } from 'express'
import { z } from 'zod'
import * as folder from '../services/folders'

export const create: RequestHandler = async (req, res) => {
    const folderSchema = z.object({
        title: z.string(),
        projectId: z.number(),
        folderId: z.number().optional()
    })

    const body = folderSchema.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const createdFolder = await folder.create(body.data)
    if (!createdFolder) return res.status(500).json({ error: 'Não foi possível criar a pasta' })

    res.status(201).json({
        folder: createdFolder
    })
}

export const update: RequestHandler = async (req, res) => {
    const folderParamsSchema = z.object({
        id: z.number()
    })

    const folderSchema = z.object({
        title: z.string().optional(),
        projectId: z.number().optional(),
        folderId: z.number().optional()
    })

    const params = folderParamsSchema.safeParse(req.params)
    const body = folderSchema.safeParse(req.body)
    if (!params.success || !body.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const updatedFolder = await folder.update(params.data.id, body.data)
    if (!updatedFolder) return res.status(500).json({ error: 'Não foi possível atualizar a pasta' })

    res.status(200).json({
        folder: updatedFolder
    })
}

export const remove: RequestHandler = async (req, res) => {
    const folderParamsSchema = z.object({
        id: z.number()
    })

    const params = folderParamsSchema.safeParse(req.params)
    if (!params.success) {
        return res.status(400).json({ error: 'Dados inválidos' })
    }

    const updatedFolder = await folder.remove(params.data.id)
    if (!updatedFolder) return res.status(500).json({ error: 'Não foi possível excluir a pasta' })

    res.status(200).json({ message: 'Pasta removida com sucesso' })
}