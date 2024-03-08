const router = require('express').Router()
const testSuiteController = require('../controllers/testSuiteController')
const { checkToken } = require('../utils')

router.post('/', checkToken, async (req, res) => testSuiteController.create(req, res))
router.get('/:id/testCases', checkToken, async (req, res) => testSuiteController.getSuiteTestCases(req, res))

module.exports = router