const express = require('express')
const cors = require('cors')
const bankController = require('./controllers/bank.controller')
const adminController = require('./controllers/admin.controller')
const userController = require('./controllers/user.controller')
const ApiError = require('./api-error')

const app = express()

app.use(cors())
app.use(express.json())

app.get('/', (req, res) => {
    res.json({ message: 'Welcome to bank application'})
})

//Route for admin
app.route('/api/admin/login/:accnum')
    .get(adminController.findPass)

app.route('api/admin/personalInfor/:accnum')
    .get(adminController.findPersonalInfor)
    .put(adminController.updatePersonalInfor)

app.route('api/admin/accountInfor/:accnum')
    .get(adminController.findAccountInfor)
    .put(adminController.updateAccountInfor)

app.route('api/admin/trasaction/:accnum')
    .get(adminController.findTransactions)

app.route('api/admin/user/')
    .post(adminController.createUser)

app.route('api/admin/userAccount/')
    .get(adminController.findAllUserAccount)
    .post(adminController.createUserAccount)

app.route('api/admin/userAccount/:accnum&:id')
    .get(adminController.findUserAccount)


//Route for user
app.route('/api/user/:username')
    .get(userController.findPass)








app.route('/api/banks')
    .get(bankController.findAll)
    .post(bankController.create)
    .delete(bankController.deleteAll)

app.route('/api/banks/favorite').get(bankController.findAllFavorite)

app.route('/api/banks/:id')
    .get(bankController.findOne)
    .put(bankController.update)
    .delete(bankController.delete)

app.use((req, res, next) => {
    return next(new ApiError(404, 'Resource not found'))
})

app.use((err, req, res) => {
    return res.status(err.statusCode || 500).json({
        message: err.message || 'Internal Server Error',
    })
})

module.exports = app
