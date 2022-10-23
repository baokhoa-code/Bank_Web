const knex = require('../database/knex')
class BankService {
    constructor() {
        this.banks = knex('banks')
    }

    #getBank(payload) {
        const bank = { ...payload }
        const bankProperties = [
            "name", "email", "address", "phone", "favorite"
        ]

        Object.keys(bank).forEach(function (key) {
            if (bankProperties.indexOf(key) == -1) {
                delete bank[key]
            }
        })
        return bank
    }
    
    async create(payload) {
        const bank = this.#getBank(payload)
        const [id] = await this.banks.insert(bank)
        return { id, ...bank }
    }

    async all() {
        return await this.banks.select('*');
    }

    async findByName(name) {
        return await this.banks
            .where('name', 'like', `%${name}%`)
            .select('*');
    }

    async findById(id) {
        return await this.banks.where('id', id).select('*').first();
    }

    async update(id, payload) {
        const update = this.#getBank(payload);
        return await this.banks.where('id', id).update(update);
    }

    async delete(id) {
        return await this.banks.where('id', id).del();
    }

    async allFavorite() {
        return await this.banks.where('favorite', 1).select('*');
    }

    async deleteAll() {
        return await this.banks.del();
    }
}

module.exports = BankService
