import { RequestHandler } from 'express'
import * as testCases from '../services/testCases'
import { z } from 'zod'
import { TestCaseStatus } from '../utils'

export const create: RequestHandler = async (req, res) => {
    const testCaseSchema = z.object({
        title: z.string(),
        summary: z.string(),
        preconditions: z.string().optional(),
        testSuiteId: z.number()
    })

    const body = testCaseSchema.safeParse(req.body)

    if (!body.success) return res.status(400).json({ error: 'Dados inválidos' })

    const createdTestCase = await testCases.create(req.body)

    if (!createdTestCase) {
        return res.status(500).json({ error: 'Não foi possível criar o caso de teste' })
    }

    await testCases.addStatus(createdTestCase.id, TestCaseStatus.NAO_EXECUTADO)

    res.status(201).json({
        testCase: createdTestCase
    })
}

export const getById: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const testCase = await testCases.getById(params.data.id)
    if (!testCase) {
        return res.status(500).json({ error: 'Não foi possível buscar o caso de teste' })
    }

    res.status(200).json({
        testCase
    })
}

export const update: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const testCaseSchema = z.object({
        title: z.string().optional(),
        summary: z.string().optional(),
        preconditions: z.string().optional(),
        testSuiteId: z.number().optional()
    })

    const params = paramsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const body = testCaseSchema.safeParse(req.body)
    if (!body.success) return res.status(400).json({ error: 'Dados inválidos' })

    const updatedTestCase = await testCases.update(params.data.id, body.data)

    if (!updatedTestCase) {
        return res.status(500).json({ error: 'Não foi possível atualizar o caso de testes' })
    }

    res.status(200).json({
        testCase: updatedTestCase
    })
}

export const remove: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const deletedTestCase = await testCases.remove(params.data.id)
    if (!deletedTestCase) {
        return res.status(500).json({ error: 'Não foi possível deletar o caso de teste.' })
    }

    res.status(200).json({ message: 'Caso de teste deletado com sucesso!' })
}

export const getStatus: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const testCaseStatus = await testCases.getStatus(params.data.id)
    if (!testCaseStatus) {
        return res.status(500).json({ error: 'Não foi possível buscar o status do caso de teste' })
    }

    res.status(200).json({ testCaseStatus })
}

export const changeStatus: RequestHandler = async (req, res) => {
    const paramsSchema = z.object({
        id: z.number()
    })

    const params = paramsSchema.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: 'O id deve ser enviado e do tipo inteiro' })
    }

    const testCaseStatus = await testCases.getStatus(params.data.id)
    if (!testCaseStatus) {
        return res.status(500).json({ error: 'Não foi possível buscar o status do caso de teste' })
    }

    res.status(200).json({ testCaseStatus })
}