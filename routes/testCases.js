const router = require('express').Router()
const testCaseController = require('../controllers/testCaseController')
const { checkToken } = require('../utils')

router.post('/', checkToken, async (req, res) => testCaseController.create(req, res))
router.get('/status', async (req, res) => testCaseController.getStatus(req, res))
router.post('/:id/status', checkToken, async (req, res) => testCaseController.changeStatus(req, res))
router.get('/:id/history', checkToken, async (req, res) => testCaseController.getStatusHistory(req, res))

module.exports = router