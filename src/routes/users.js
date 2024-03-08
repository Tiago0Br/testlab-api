const router = require('express').Router()
const userController = require('../controllers/userController')
const { checkToken } = require('../utils')

router.post('/', async (req, res) => userController.create(req, res))
router.get('/:id', checkToken,  async (req, res) => userController.getById(req, res))
router.get('/:id/projects', checkToken, async (req, res) => userController.getUserProjects(req, res))

module.exports = router