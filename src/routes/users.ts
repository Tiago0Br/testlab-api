import { Router } from 'express'
import { checkToken } from '../middlewares'
import * as user from '../controllers/users'
const router = Router()

router.post('/', user.create)
router.get('/:id', checkToken, user.getById)
router.get('/:id/projects', checkToken, user.getUserProjects)

export default router