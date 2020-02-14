import {Errors} from './Errors';

export class Form {

    constructor(data) {

        this.originalData = data;

        this.copyDataToForm(data);

        this.errors = new Errors();

        this.loading = false;
    }


    reset() {

        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }


    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }


    post($uri) {
        this.loading = true;
        return new Promise((resolve, reject) => {
            axios.post($uri, this.data())
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(errors => {
                    this.onFail(errors.response.data.errors);

                    reject(errors.response.data.errors);
                })
        });
    }

    put($uri) {
        this.loading = true;
        return new Promise((resolve, reject) => {
            axios.put($uri, this.data())
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(errors => {
                    this.onFail(errors.response.data.errors);

                    reject(errors.response.data.errors);
                })
        });
    }


    onSuccess(data) {
        this.loading = false;
        this.reset();
    }


    onFail(errors) {
        this.loading = false;
        this.errors.record(errors)
    }

    copyDataToForm(data) {
        for (let field in data) {
            this[field] = data[field];
        }
    }

}
