import { Prisma } from '@prisma/client'
import { prisma } from '../lib/prisma'

type TestCaseCreateData = Prisma.Args<typeof prisma.testCase, 'create'>['data']
export const create = async (data: TestCaseCreateData) => {
    try {
        return await prisma.testCase.create({ data })
    } catch (error) {
        return false
    }
}

export const getById = async (id: number) => {
    try {
        const testCase = await prisma.testCase.findUnique({
            where: { id },
            select: {
                id: true,
                title: true,
                summary: true,
                preconditions: true,
                TestCaseStatus: {
                    select: {
                        status: true
                    },
                    orderBy: { id: 'desc' }
                }
            }
        })

        return {
            ...testCase,
            TestCaseStatus: undefined,
            status: testCase?.TestCaseStatus[0].status
        }
    } catch (error) {
        return false
    }
}

type TestCaseUpdateData = Prisma.Args<typeof prisma.testCase, 'update'>['data']
export const update = async (id: number, data: TestCaseUpdateData) => {
    try {
        return await prisma.testCase.update({ data, where: { id } })
    } catch (error) {
        return false
    }
}

export const remove = async (id: number) => {
    try {
        return await prisma.testCase.delete({ where: { id } })
    } catch (error) {
        return false
    }
}

export const addStatus = async (id: number, status: string) => {
    try {
        return await prisma.testCaseStatus.create({
            data: {
                status,
                testCaseId: id
            }
        })
    } catch (error) {
        return false
    }
}

export const getStatus = async (id: number) => {
    try {
        return await prisma.testCaseStatus.findMany({ 
            where: { testCaseId: id },
            select: {
                id: true,
                status: true,
                note: true,
                date: true
            }
        })
    } catch (error) {
        return false
    }
}