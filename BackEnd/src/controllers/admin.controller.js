const AdminService = require('../services/admin.service')
const ApiError = require('../api-error')

exports.create = async (req, res, next) => {
    if (!req.body?.name) {
        return next(new ApiError(400, 'Name can not be empty'))
    }

    try {
        const adminService = new AdminService()
        const admin = await adminService.create(req.body)
        return res.send(admin)
    } catch(error) {
        console.log(error)
        return next(
            new ApiError(500, 'An error occurred while creating the admin')
        )
    }
}
