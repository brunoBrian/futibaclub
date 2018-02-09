const express = require('express')
const app = express('app')
const mysql = require('mysql2/promise')
const bodyParser = require('body-parser')
const session = require('express-session')
const account = require('./account')

app.use(express.static('public'))
app.use(bodyParser.urlencoded({ extended: true}))
app.use(session({
	secret: 'fullstack',
	resave: true,
	saveUninitialized : true
}))
app.set('view engine', 'ejs')

const init = async() => {
	const connection = await mysql.createConnection({
		host: '127.0.0.1',
		user: 'root',
		password: 'Cabelera10',
		database: 'futibaclub'
	})

	app.use((req, res, next) => {
		if(req.session.user) {
			res.locals.user = req.session.user
		}else {
			res.locals.user = false
		}
		console.log(req.session)
		next()
	})

	app.use(account(connection))

	app.listen(3000, err => {
		console.log('Servidor futiba rodando')
	})
}

init()
