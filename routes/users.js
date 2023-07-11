const router = require('express').Router()
const userController = require('../controllers/userController')

router.post('/', async (req, res) => userController.create(req, res))
router.get('/:id', async (req, res) => userController.getById(req, res))
router.get('/:id/projects', async (req, res) => userController.getUserProjects(req, res))

module.exports = router