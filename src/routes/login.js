const router = require('express').Router()
const loginController = require('../controllers/loginController')

router.post('/', async (req, res) => loginController.authenticate(req, res))

module.exports = router