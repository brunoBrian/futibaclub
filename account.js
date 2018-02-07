const express = require('express')
const app = express.Router()

const init = connection => {
	app.get('/', async(req, res) => {
		const [rows, fields] = await connection.execute('select * from users')
		console.log(rows)

		res.render('home')
	})
	return app
}



module.exports = init