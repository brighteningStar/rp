import {stockHeadingModel} from './stockHeadingModel';
export default {
    props: ['id'],
    
    data() {
        return {
            loadingForm: false,
            errors: {},
            showUploadForm: true,
            fileName: 'Choose file',
            file: '',
            uploadPercentage: 0,
            loading: false,
            detailSection: [],
            stockHeading: (new stockHeadingModel()).heading(),
            suppliers: {
                options: [],
                spinner: false,
            },
            regions: {
                options: [],
                spinner: false,
            },
            ship_to: {
                options: [],
                spinner: false,
            },
            bill_to: {
                options: [],
                spinner: false,
            },
            make_models: {
                options: [],
                spinner: false,
            },
            make: {
                options: [],
                spinner: false,
            },
            colors: {
                options: [],
                spinner: false,
            },
            grades: {
                options: [],
                spinner: false,
            },
            capacities: {
                options: [],
                spinner: false,
            },
            bank_deals: {
                options: [],
                spinner: false,
            },

            local_imported: {
                options: [{'title': 'Local', 'id': 'local'}, {'title': 'Imported', 'id': 'imported'}],
                selected: ''
            }
        }
    },

    methods: {

        calculateTotalPrice() {
            let customDuty = (this.stockHeading.quantity_per_inv / this.stockHeading.custom_duty);
            let freight    = (this.stockHeading.quantity_per_inv / this.stockHeading.freight);
            
            if( freight >= 0 && customDuty >= 0 && freight != 'Infinity' && customDuty != 'Infinity' ) {
                for( let i in this.detailSection ) {
                    this.detailSection[i].total_cost = (parseFloat(this.detailSection[i].price_aed) + parseFloat(customDuty) + parseFloat(freight)).toFixed(2);
                }
            }
        },

        dateFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },

        mapResponseToHeading(heading) {
            for (let field in this.stockHeading) {
                this.stockHeading[field] = heading[field];
            }
        },

        fileHandle() {
            this.file = this.$refs.file.files[0];
            this.fileName = this.file.name;
        },


        search(name, search, serialNo = false) {
            if (serialNo === false) {
                this[name].spinner = true;
            } else {
                this[name][serialNo].spinner = true;
            }

            this.fetchList(search, this, name, serialNo);
        },


        fetchList: _.throttle((search, vm, name, serialNo) => {
            fetch(
                `/search?q=${escape(search)}&table=${escape(name)}`
            ).then(res => {
                if (serialNo === false) {
                    res.json().then(json => (vm[name].options = json.items));
                    vm[name].spinner = false;
                } else {
                    res.json().then(json => (vm[name][serialNo].options = json.items));
                    vm[name][serialNo].spinner = false;
                }

            });
        }, 10),

        has(field) {
            return this.errors.hasOwnProperty(field);
        },

        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        },

        onSubmitStock() {
            this.loadingForm = true;
            axios.post(`/stock/${this.id}/update`, {'heading': this.stockHeading, 'detail': this.detailSection, 'local_imported': this.local_imported})
                .then(response => {
                    this.showUploadForm  = true;
                    this.loadingForm     = false;
                    window.location.href = '/stock';
                })
                .catch(function (errors) {
                    this.errors = Object.assign({}, this.errors, errors.response.data.errors);
                    this.loadingForm = false;
                }.bind(this))
        },

        cancelForm() {
            this.showUploadForm = true;
        },
    },

    mounted() {
        let id = this.id;
        axios.get(`/fetch-stock/${id}`)
            .then(function (response) {
                this.loading = false;
                this.fileName = 'Choose File';
                this.showUploadForm = false;
                this.mapResponseToHeading(response.data.heading);
                this.local_imported.selected = response.data.local_imported;
                let detailData = Object.keys(response.data.detail);
                let makeModels = [];
                let make = [];
                let color = [];
                let grade = [];
                let capacity = [];
                let bankDeal = [];

                for (let i = 0; i < detailData.length; i++) {
                    makeModels[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                    make[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                    color[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                    grade[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                    capacity[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                    bankDeal[detailData[i]] = {
                        options: [],
                        spinner: false,
                    };
                }
                this.make_models = Object.assign({}, this.make_models, makeModels);
                this.make        = Object.assign({}, this.make, make);
                this.colors      = Object.assign({}, this.colors, color);
                this.grades      = Object.assign({}, this.grades, grade);
                this.capacities  = Object.assign({}, this.capacities, capacity);
                this.bank_deals  = Object.assign({}, this.bank_deals, bankDeal);

                this.detailSection = response.data.detail;
            }.bind(this))
            .catch(function (errors) {
                this.loading = false;
                this.uploadPercentage = 0;
                this.errors = errors.response.data.errors;
            }.bind(this));
    }
}