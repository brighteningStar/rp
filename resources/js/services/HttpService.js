export class HttpService {
    constructor() {
        this.cancelTokenSource = null // to control pending requests
        this.errors = {}
    }


    get($uri, $params) {
        this.loading = true
        if (this.cancelTokenSource) {
            this.cancelTokenSource.cancel()
        }

        this.cancelTokenSource = axios.CancelToken.source()

        return new Promise((resolve, reject) => {
            axios.get($uri, {
                params: $params,
                cancelToken: this.cancelTokenSource.token,
                headers: {
                },
            })
            .then(response => {
                resolve(response.data);
            })
            .catch(errors => {
                
                this.onFail(errors.response)
                reject(errors.response)
            })
        });
    }

    onFail(response) {
        if( response.status === 500) {
            this.errors = {
                message: 'Something went wrong'
            }
        } else {
            this.errors = response.data
        }
    }
}
