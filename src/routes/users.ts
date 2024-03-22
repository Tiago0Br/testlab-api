import { Router } from 'express'
import { checkToken } from '../utils'
import * as user from '../controllers/users'
const router = Router()

router.post('/', user.create)
router.get('/:id', checkToken,  user.getById)
router.get('/:id/projects', checkToken, user.getUserProjects)

export default router