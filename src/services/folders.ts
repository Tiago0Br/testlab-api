import { Prisma } from "@prisma/client"
import { prisma } from "../lib/prisma"

type FolderCreateData = Prisma.Args<typeof prisma.folder, 'create'>['data']
export const create = async (data: FolderCreateData) => {
    try {
        return await prisma.folder.create({ data })
    } catch (error) {
        return false
    }
}

type FolderUpdateData = Prisma.Args<typeof prisma.folder, 'update'>['data']
export const update = async (id: number, data: FolderUpdateData) => {
    try {
        return await prisma.folder.update({ data, where: { id } })
    } catch (error) {
        return false
    }
}

export const remove = async (id: number) => {
    try {
        return await prisma.folder.delete({ where: { id } })
    } catch (error) {
        return false
    }
}