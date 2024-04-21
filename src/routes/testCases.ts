import { Router } from 'express'
import * as testCases from '../controllers/testCases'
import { checkToken } from '../middlewares'

const router = Router()

router.post('/', checkToken, testCases.create)
router.get('/:id', checkToken, testCases.getById)
router.put('/:id', checkToken, testCases.update)
router.delete('/:id', checkToken, testCases.remove)
router.get('/:id/status', testCases.getStatus)
router.post('/:id/status', checkToken, testCases.changeStatus)

export default router