import { Router } from 'express'
import * as project from '../controllers/projects'
import { checkToken } from '../utils'

const router = Router()

router.post('/', checkToken, project.create)
router.get('/:id', checkToken, project.getById)
router.put('/:id', checkToken, project.update)
router.delete('/:id', checkToken, project.remove)
router.post('/:id/addUser', checkToken, project.addUserToProject)
router.get('/:id/users', checkToken, project.getProjectUsers)

export default router