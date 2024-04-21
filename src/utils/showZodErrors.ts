import { ZodError } from 'zod'

export const showZodErrors = (error: ZodError) => {
    const errors = error.errors.map(error => error.message)
    return errors[0]
}