const router = require('express').Router()
const folderController = require('../controllers/folderController')

router.post('/', async (req, res) => folderController.create(req, res))
router.get('/:id/testSuites', async (req, res) => folderController.getFolderTestSuites(req, res))

module.exports = router