const BankService = require('../services/bank.service')
const ApiError = require('../api-error')

exports.create = async (req, res, next) => {
    if (!req.body?.name) {
        return next(new ApiError(400, 'Name can not be empty'))
    }

    try {
        const bankService = new BankService()
        const bank = await bankService.create(req.body)
        return res.send(bank)
    } catch(error) {
        console.log(error)
        return next(
            new ApiError(500, 'An error occurred while creating the bank')
        )
    }
}

// exports.create = (req, res) => {
//     return res.send({ message: 'create handler'})
// }

exports.findAll = async (req, res, next) => {
    let banks = []

    try {
        const bankService = new BankService()
        const { name } = req.query
        if (name) {
            banks = await bankService.findByName(name)
        } else {
            banks = await bankService.all()
        }
    } catch (error) {
        console.log(error)
        return next(
            new ApiError( 500, 'An error occurred while retrieving banks')
        )
    }

    return res.send(banks)
}

exports.findOne = async (req, res, next) => {
    try {
        const bankService = new BankService()
        const bank = await bankService.findById(req.params.id)
        if (!bank) {
            return next(new ApiError(404, 'Bank not found'))
        }
        return res.send(bank)
    } catch (error) {
        console.log(error)
        return next(
            new ApiError(
                500,
                `Error retrieving bank with id=${req.params.id}`
            )
        )
    }
}

exports.update = async (req, res, next) => {
    if (Object.keys(req.body).length === 0){
        return next(new ApiError(400, 'Data to update can not be empty'))
    }

    try {
        const bankService = new BankService()
        const updated = await bankService.update(req.params.id, req.body)
        if (!updated) {
            return next(new ApiError(404, 'Bank not found'))
        }
        return res.send({message: 'Bank was updated successfully'})
    } catch (error) {
        console.log(error)
        return next(
            new ApiError(500, `Error updating bank with id=${req.params.id}`)
        )
    }
}

exports.delete = async (req, res, next) => {
    try {
        const bankService = new BankService()
        const deleted = await bankService.delete(req.params.id)
        if(!deleted){
            return next(new ApiError(404, 'Bank not found'))
        }
        return res.send({ message: 'Bank was deleted successfully'})
    } catch (error) {
        console.log(error)
        return next(
            new ApiError(
                500,
                `Could not delete bank with id=${req.params.id}`
            )
        )
    }
}

exports.deleteAll = async (req, res, next) => {
   try {
        const bankService = new BankService()
        const deleted = await bankService.deleteAll()
        return res.send({
            message: `${deleted} banks were deleted successfully`
        })
   } catch (error) {
        console.log(error)
        return next(
            new ApiError(500, 'An error occurred while removing all banks')
        )
   }
}

exports.findAllFavorite = async (req, res, next) => {
   try {
        const bankService = new BankService()
        const banks = await bankService.allFavorite()
        return res.send(banks)
   } catch (error) {
        console.log(error)
        return next(
            new ApiError(
                500,
                'An error occurred while retrieving favorite banks'
            )
        )
   }
}
