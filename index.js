const express = require('express')
const app = express('app')
const mysql = require('mysql2/promise')

const account = require('./account')

app.use(express.static('public'))
app.set('view engine', 'ejs')

const init = async() => {
	const connection = await mysql.createConnection({
		host: '127.0.0.1',
		user: 'root',
		password: 'Cabelera10',
		database: 'futibaclub'
	})

	app.use(account(connection))

	app.listen(3000, err => {
		console.log('Servidor futiba rodando')
	})
}

init()
