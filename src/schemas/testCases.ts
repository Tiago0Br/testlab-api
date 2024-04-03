import { z } from 'zod'

export const create = z.object({
    title: z.string({
        required_error: 'O campo "title" deve ser enviado',
        invalid_type_error: 'O campo "title" deve ser do tipo string'
    }).trim(),
    summary: z.string({
        required_error: 'O campo "summary" deve ser enviado',
        invalid_type_error: 'O campo "summary" deve ser do tipo string'
    }).trim(),
    preconditions: z.string({
        invalid_type_error: 'O campo "preconditions" deve ser do tipo string'
    }).trim().optional(),
    testSuiteId: z.number({
        required_error: 'O campo "testSuiteId" deve ser enviado',
        invalid_type_error: 'O campo "testSuiteId" deve ser do tipo número'
    })
})

export const get = z.object({
    id: z.number({
        required_error: 'O campo "id" deve ser enviado',
        invalid_type_error: 'O campo "id" deve ser do tipo número'
    })
})

export const update = z.object({
    title: z.string({
        invalid_type_error: 'O campo "title" deve ser do tipo string'
    }).trim().optional(),
    summary: z.string({
        invalid_type_error: 'O campo "summary" deve ser do tipo string'
    }).trim().optional(),
    preconditions: z.string({
        invalid_type_error: 'O campo "preconditions" deve ser do tipo string'
    }).trim().optional(),
    testSuiteId: z.number({
        invalid_type_error: 'O campo "testSuiteId" deve ser do tipo número'
    }).optional()
})