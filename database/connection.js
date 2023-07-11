const connection = require('./index')
const User = require('./models/Users')
const Project = require('./models/Projects')
const UserProject = require('./models/UsersProjects')
const Folder = require('./models/Folders')
const TestSuite = require('./models/TestSuites')
const TestCase = require('./models/TestCases')
const TestCaseStatusHistory = require('./models/TestCaseStatusHistory')

async function main() {
    try {
        await connection.authenticate()

        await User.sync({ force: false })
        await Project.sync({ force: false })
        await UserProject.sync({ force: false })
        await Folder.sync({ force: false })
        await TestSuite.sync({ force: false })
        await TestCase.sync({ force: false })
        await TestCaseStatusHistory.sync({ force: false })
    } catch (error) {
        throw error
    }
}

module.exports = main