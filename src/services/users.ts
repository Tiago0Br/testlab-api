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

export const getByProjectId = async (projectId: number) => {
    try {
        return await prisma.user.findMany({
            where: { 
                projects: { 
                    every: { id: projectId } 
                } 
            },
            select: {
                id: true,
                fullname: true,
                email: true
            }
        })
    } catch (error) {
        return false
    }
}

export const getUserProjects = async (id: number) => {
    try {
        const user = await prisma.user.findFirst({
            where: { id },
            select: {
                projects: {
                    select: {
                        id: true,
                        name: true,
                        description: true,
                        Folder: {
                            select: {
                                id: true,
                                title: true,
                                TestCase: {
                                    select: {
                                        id: true,
                                        title: true
                                    }
                                }
                            }
                        }
                    }
                }
            }
        })

        if (!user) return null

        return user?.projects
    } catch (error) {
        return false
    }
}