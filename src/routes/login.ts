import { Router } from 'express'
import * as login from '../controllers/login'
const router = Router()

router.post('/login', login.authenticate)

export default router