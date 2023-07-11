const router = require('express').Router()
const testSuiteController = require('../controllers/testSuiteController')

router.post('/', async (req, res) => testSuiteController.create(req, res))
router.get('/:id/testCases', async (req, res) => testSuiteController.getSuiteTestCases(req, res))

module.exports = router