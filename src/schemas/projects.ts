import { z } from 'zod'

export const create = z.object({
    name: z.string({
        required_error: 'O campo "name" deve ser enviado',
        invalid_type_error: 'O campo "name" deve ser do tipo string'
    }).trim(),
    description: z.string({
        required_error: 'O campo "description" deve ser enviado',
        invalid_type_error: 'O campo "description" deve ser do tipo string'
    }).trim(),
    ownerUserId: z.number({
        required_error: 'O campo "ownerUserId" deve ser enviado',
        invalid_type_error: 'O campo "ownerUserId" deve ser do tipo número'
    })
})

export const get = z.object({
    id: z.number({
        required_error: 'O campo "id" deve ser enviado',
        invalid_type_error: 'O campo "id" deve ser do tipo número'
    })
})

export const update = z.object({
    name: z.string({
        required_error: 'O campo "name" deve ser enviado'
    }).trim().optional(),
    description: z.string({
        required_error: 'O campo "description" deve ser enviado'
    }).trim().optional(),
    ownerUserId: z.number({
        required_error: 'O campo "ownerUserId" deve ser enviado'
    }).optional()
})

export const addUser = z.object({
    email: z.string({
        required_error: 'O campo "email" deve ser enviado',
        invalid_type_error: 'O campo "email" deve ser do tipo string'
    })
    .trim()
    .email('O campo "email" deve ser um e-mail válido')
})