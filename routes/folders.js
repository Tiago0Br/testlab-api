const router = require('express').Router()
const folderController = require('../controllers/folderController')
const { checkToken } = require('../utils')

router.post('/', checkToken, async (req, res) => folderController.create(req, res))
router.get('/:id/testSuites', checkToken, async (req, res) => folderController.getFolderTestSuites(req, res))

module.exports = router