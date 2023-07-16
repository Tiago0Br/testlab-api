const router = require('express').Router()
const folderController = require('../controllers/folderController')
const { checkToken } = require('../utils')

router.post('/', checkToken, async (req, res) => folderController.create(req, res))
router.put('/:id', checkToken, async (req, res) => folderController.update(req, res))
router.delete('/:id', checkToken, async (req, res) => folderController.delete(req, res))
router.get('/:id/testSuites', checkToken, async (req, res) => folderController.getFolderTestSuites(req, res))

module.exports = router