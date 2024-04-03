import { z } from 'zod'

export const create = z.object({
    title: z.string({
        invalid_type_error: 'O campo "title" deve ser do tipo string',
        required_error: 'O campo "title" deve ser enviado'
    }).trim(),
    projectId: z.number({
        invalid_type_error: 'O campo "projectId" deve ser do tipo número',
        required_error: 'O campo "projectId" deve ser enviado'
    }),
    folderId: z.number({
        invalid_type_error: 'O campo "folderId" deve ser do tipo número'
    }).optional()
})

export const update = z.object({
    title: z.string({
        invalid_type_error: 'O campo "title" deve ser do tipo string'
    }).trim().optional(),
    projectId: z.number({
        invalid_type_error: 'O campo "projectId" deve ser do tipo número',
    }).optional(),
    folderId: z.number({
        invalid_type_error: 'O campo "folderId" deve ser do tipo número'
    }).optional()
})

export const get = z.object({
    id: z.number({
        invalid_type_error: 'O campo "folderId" deve ser do tipo número',
        required_error: 'O campo "id" deve ser enviado'
    })
})