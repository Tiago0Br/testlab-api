import { Router } from 'express'
import loginRouter from './login'
import usersRouter from './users'
import projectsRouter from './projects'
import foldersRouter from './folders'
import testCasesRouter from './testCases'

const router = Router()

router.use('/login', loginRouter)
router.use('/users', usersRouter)
router.use('/projects', projectsRouter)
router.use('/folders', foldersRouter)
router.use('/testCases', testCasesRouter)

export default router