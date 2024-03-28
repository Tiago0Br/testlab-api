import { Prisma } from '@prisma/client'
import { prisma } from '../lib/prisma'
import { getByEmail as getUserByEmail } from './users'

type ProjectCreateData = Prisma.Args<typeof prisma.project, 'create'>['data']
export const create = async (data: ProjectCreateData) => {
    try {
        return await prisma.project.create({ data })
    } catch (error) {
        return false
    }
}

export const getById = async (id: number) => {
    try {
        return await prisma.project.findUnique({ where: { id } })
    } catch (error) {
        return false
    }
}

type ProjectUpdateData = Prisma.Args<typeof prisma.project, 'update'>['data']
export const update = async (id: number, data: ProjectUpdateData) => {
    try {
        return await prisma.project.update({ where: { id }, data })
    } catch (error) {
        return false
    }
}

export const remove = async (id: number) => {
    try {
        return await prisma.project.delete({ where: { id } })
    } catch (error) {
        return false
    }
}

export const addUserToProject = async (id: number, userEmail: string) => {
    try {
        const user = await getUserByEmail(userEmail)
        if (!user) return false

        return await prisma.userProject.create({
            data: {
                projectId: id,
                userId: user.id
            }
        })
    } catch (error) {
        return false
    }
}