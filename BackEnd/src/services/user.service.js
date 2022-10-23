const knex = require('../database/knex')
class UserService {
    constructor() {
        this.banks = knex('banks')
    }

}

module.exports = UserService
