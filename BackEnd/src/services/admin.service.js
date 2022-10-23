const knex = require('../database/knex')
class AdminService {
    constructor() {
        this.banks = knex('banks')
    }

}

module.exports = AdminService
