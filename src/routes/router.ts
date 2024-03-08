const router = require('express').Router()
const loginRouter = require('./login')
const usersRouter = require('./users')
const projectsRouter = require('./projects')
const foldersRouter = require('./folders')
const testSuitesRouter = require('./testSuites')
const testCasesRouter = require('./testCases')

router.use('/login', loginRouter)
router.use('/users', usersRouter)
router.use('/projects', projectsRouter)
router.use('/folders', foldersRouter)
router.use('/testSuites', testSuitesRouter)
router.use('/testCases', testCasesRouter)

export default router