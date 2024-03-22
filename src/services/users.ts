import { Prisma } from '@prisma/client'
import { prisma } from '../lib/prisma'

type UserCreateData = Prisma.Args<typeof prisma.user, 'create'>['data']
export const create = async (data: UserCreateData) => {
    try {
        return await prisma.user.create({ 
            data,
            select: {
                id: true,
                fullname: true,
                email: true,
                createdAt: true
            } 
        })
    } catch (error) {
        return false
    }
}

export const getById = async (id: number) => {
    try {
        return await prisma.user.findFirst({
            where: { id },
            select: {
                id: true,
                fullname: true,
                email: true,
                createdAt: true
            }
        })
    } catch (error) {
        return false
    }
}

export const getByEmail = async (email: string) => {
    try {
        return await prisma.user.findFirst({
            where: { email },
            select: {
                id: true,
                fullname: true,
                email: true,
                password: true
            }
        })
    } catch (error) {
        return false
    }
}

export const getUserProjects = async (id: number) => {
    try {
        return await prisma.user.findFirst({
            where: { id },
            select: {
                id: true,
                fullname: true,
                email: true,
                projects: true
            }
        })
    } catch (error) {
        return false
    }
}