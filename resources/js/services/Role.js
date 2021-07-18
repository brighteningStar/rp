import { HttpService } from "./HttpService";

export class Role extends HttpService{
    constructor() {
        super()
    }

    async getRoles() {
        const url = '/get/roles'
        const {data} = await this.get(url)
        return data
    }
}
