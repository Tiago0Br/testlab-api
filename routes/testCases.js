const router = require('express').Router()
const testCaseController = require('../controllers/testCaseController')

router.post('/', async (req, res) => testCaseController.create(req, res))

module.exports = router