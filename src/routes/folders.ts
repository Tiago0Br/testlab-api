import { Router } from 'express'
import { checkToken } from '../utils'
import * as folder from '../controllers/folders'
const router = Router()

router.post('/', checkToken, folder.create)
router.put('/:id', checkToken, folder.update)
router.delete('/:id', checkToken, folder.remove)

export default router