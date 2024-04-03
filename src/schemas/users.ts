import { z } from 'zod'

export const create = z.object({
    fullname: z.string({
        required_error: 'O campo "fullname" deve ser enviado',
        invalid_type_error: 'O campo "fullname" deve ser do tipo string'
    }).trim(),
    email: z.string({
        required_error: 'O campo "email" deve ser enviado',
        invalid_type_error: 'O campo "email" deve ser do tipo string'
    })
    .trim()
    .email('O campo "password" deve ser do tipo string'),
    password: z.string({
        required_error: 'O campo "password" deve ser enviado',
        invalid_type_error: 'O campo "password" deve ser do tipo string'
    }).trim()
})

export const get = z.object({
    id: z.number({
        required_error: 'O campo "id" deve ser enviado',
        invalid_type_error: 'O campo "id" deve ser do tipo número'
    })
})