import { z } from 'zod'

export const authenticate = z.object({
    email: z.string({
        required_error: 'O campo "email" deve ser enviado',
        invalid_type_error: 'O campo "email" deve ser do tipo string'
    })
    .trim()
    .email('O campo "email" deve ser um e-mail válido'),
    password: z.string({
        required_error: 'O campo "password" deve ser enviado',
        invalid_type_error: 'O campo "password" deve ser do tipo string'
    }).trim()
})