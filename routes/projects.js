const router = require('express').Router()
const projectController = require('../controllers/projectController')
const { checkToken } = require('../utils')

router.post('/', checkToken, async (req, res) => projectController.create(req, res))
router.post('/addUser', checkToken, async (req, res) => projectController.addUserToProject(req, res))
router.get('/:id', checkToken, async (req, res) => projectController.getById(req, res))
router.get('/:id/users', checkToken, async (req, res) => projectController.getProjectUsers(req, res))
router.get('/:id/folders', checkToken, async (req, res) => projectController.getProjectFolders(req, res))

module.exports = router