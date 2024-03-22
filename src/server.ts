import 'dotenv/config'
import express from 'express'
import cors from 'cors'
import http from 'node:http'
import https from 'node:https'
import fs from 'node:fs'
import folderRoutes from './routes/folders'
import userRoutes from './routes/users'
import loginRoutes from './routes/login'

const app = express()

app.use(cors())
app.use(express.json())
app.use(express.urlencoded({ extended: true }))
app.use('/', loginRoutes)
app.use('/users', userRoutes)
app.use('/folders', folderRoutes)

const runServer = (port: number, server: http.Server) => {
    server.listen(port, () => {
        console.log(`Running at PORT ${port}`)
    })
}

const regularServer = http.createServer(app)
if (process.env.NODE_ENV === 'production') {
    const options = {
        key: fs.readFileSync(process.env.SSL_KEY as string),
        cert: fs.readFileSync(process.env.SSL_CERTIFICATE as string)
    }

    const securityServer = https.createServer(options, app)
    runServer(80, regularServer)
    runServer(443, securityServer)
} else {
    const serverPort: number = process.env.PORT ? parseInt(process.env.PORT) : 9000
    runServer(serverPort, regularServer)
}