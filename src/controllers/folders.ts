import { RequestHandler } from 'express'
import * as folder from '../services/folders'
import * as folderSchema from '../schemas/folders'
import { showZodErrors } from '../utils'

export const create: RequestHandler = async (req, res) => {
    const body = folderSchema.create.safeParse(req.body)
    if (!body.success) {
        return res.status(400).json({ error: showZodErrors(body.error) })
    }

    const createdFolder = await folder.create(body.data)
    if (!createdFolder) return res.status(500).json({ error: 'Não foi possível criar a pasta' })

    res.status(201).json({
        folder: createdFolder
    })
}

export const update: RequestHandler = async (req, res) => {
    const params = folderSchema.get.safeParse({ id: parseInt(req.params.id) })
    const body = folderSchema.update.safeParse(req.body)

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    if (!body.success) {
        return res.status(400).json({ error: showZodErrors(body.error) })
    }

    const updatedFolder = await folder.update(params.data.id, body.data)
    if (!updatedFolder) return res.status(500).json({ error: 'Não foi possível atualizar a pasta' })

    res.status(200).json({
        folder: updatedFolder
    })
}

export const remove: RequestHandler = async (req, res) => {
    const params = folderSchema.get.safeParse(req.params)
    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const updatedFolder = await folder.remove(params.data.id)
    if (!updatedFolder) return res.status(500).json({ error: 'Não foi possível excluir a pasta' })

    res.status(200).json({ message: 'Pasta removida com sucesso' })
}