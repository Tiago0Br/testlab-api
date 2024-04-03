import { RequestHandler } from 'express'
import * as testCases from '../services/testCases'
import * as testCasesSchema from '../schemas/testCases'
import { TestCaseStatus, showZodErrors } from '../utils'

export const create: RequestHandler = async (req, res) => {
    const body = testCasesSchema.create.safeParse(req.body)

    if (!body.success) return res.status(400).json({ error: showZodErrors(body.error) })

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
    const params = testCasesSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
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
    const params = testCasesSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const body = testCasesSchema.update.safeParse(req.body)
    if (!body.success) return res.status(400).json({ error: showZodErrors(body.error) })

    const updatedTestCase = await testCases.update(params.data.id, body.data)

    if (!updatedTestCase) {
        return res.status(500).json({ error: 'Não foi possível atualizar o caso de testes' })
    }

    res.status(200).json({
        testCase: updatedTestCase
    })
}

export const remove: RequestHandler = async (req, res) => {
    const params = testCasesSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const deletedTestCase = await testCases.remove(params.data.id)
    if (!deletedTestCase) {
        return res.status(500).json({ error: 'Não foi possível deletar o caso de teste.' })
    }

    res.status(200).json({ message: 'Caso de teste deletado com sucesso!' })
}

export const getStatus: RequestHandler = async (req, res) => {
    const params = testCasesSchema.get.safeParse({ 
        id: parseInt(req.params.id) 
    })

    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const testCaseStatus = await testCases.getStatus(params.data.id)
    if (!testCaseStatus) {
        return res.status(500).json({ error: 'Não foi possível buscar o status do caso de teste' })
    }

    res.status(200).json({ testCaseStatus })
}

export const changeStatus: RequestHandler = async (req, res) => {
    const params = testCasesSchema.get.safeParse({ id: parseInt(req.params.id) })
    if (!params.success) {
        return res.status(400).json({ error: showZodErrors(params.error) })
    }

    const testCaseStatus = await testCases.getStatus(params.data.id)
    if (!testCaseStatus) {
        return res.status(500).json({ error: 'Não foi possível buscar o status do caso de teste' })
    }

    res.status(200).json({ testCaseStatus })
}