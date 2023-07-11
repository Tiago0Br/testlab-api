const router = require('express').Router()
const projectController = require('../controllers/projectController')

router.post('/', async (req, res) => projectController.create(req, res))
router.post('/addUser', async (req, res) => projectController.addUserToProject(req, res))
router.get('/:id', async (req, res) => projectController.getById(req, res))
router.get('/:id/users', async (req, res) => projectController.getProjectUsers(req, res))
router.get('/:id/folders', async (req, res) => projectController.getProjectFolders(req, res))

module.exports = router