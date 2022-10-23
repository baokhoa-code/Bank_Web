const UserService = require('../services/user.service')
const ApiError = require('../api-error')

exports.create = async (req, res, next) => {
    if (!req.body?.name) {
        return next(new ApiError(400, 'Name can not be empty'))
    }

    try {
        const userService = new UserService()
        const user = await userService.create(req.body)
        return res.send(user)
    } catch(error) {
        console.log(error)
        return next(
            new ApiError(500, 'An error occurred while creating the user')
        )
    }
}
