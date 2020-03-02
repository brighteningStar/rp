<template>
    <section class="content">
        <div v-if="showUploadForm" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card" v-if="uploadPercentage">
                        <div class="progress">
                            <div class="progress-bar bg-success" role="progressbar" :value.prop="uploadPercentage" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"
                                 :style="{width:uploadPercentage+'%'}"></div>
                        </div>
                    </div>
                    <div class="card card-primary">
                        <loading v-if="loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Upload Excel</h3>
                        </div>
                        <form role="form" method="post" @submit.prevent="uploadExcel()">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="file">File input</label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" ref="file" v-on:change="fileHandle()">
                                            <label class="custom-file-label" for="file" v-text="fileName"></label>
                                        </div>
                                    </div>
                                    <span class="error invalid-feedback" v-if="has('file')" v-text="get('file')"></span>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <table-vue uri="/get-stock" title="Stock" showEditIcon="false"></table-vue>
        </div>
        <div v-if="! showUploadForm" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="loadingForm"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Stock Form</h3>
                        </div>
                        <form role="form" @submit.prevent="onSubmitStock">
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Stock Head</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" class="form-control" placeholder="Invoice Number" v-model="stockHeading.invoice_no">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Declaration Number</label>
                                                <input type="text" class="form-control" placeholder="Declaration" v-model="stockHeading.declaration_no">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>SO Date</label>
                                                <datepicker class="v-datepicker-custom" :format="dateFormatter" :value="stockHeading.so_date" name="so_date"
                                                            v-model="stockHeading.so_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>SO Number</label>
                                                <input type="text" class="form-control" placeholder="So Number" v-model="stockHeading.so_number">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Region</label>
                                                <div v-show="regions.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <v-select :options="regions.options" v-model="stockHeading.region">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" :required="!stockHeading.region" v-bind="attributes" v-on="events"
                                                               @keypress="search('regions', $event.target.value)"/>
                                                    </template>
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Local/Imported</label>
                                                <v-select :options="local_imported.options" label="title" v-model="local_imported.selected">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span class="error invalid-feedback" v-if="has('heading.local_imported')" v-text="get('heading.local_imported')"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Invoice Date</label>
                                                <datepicker class="v-datepicker-custom" :format="dateFormatter" :value="stockHeading.invoice_date" name="invoice_date"
                                                            v-model="stockHeading.invoice_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Tracking Number</label>
                                                <input type="text" class="form-control" placeholder="Tracking Number" v-model="stockHeading.tracking_no">
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Bill To</label>
                                                <div v-show="bill_to.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <v-select :options="bill_to.options" v-model="stockHeading.bill_to">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" :required="!stockHeading.bill_to" v-bind="attributes" v-on="events"
                                                               @keypress="search('bill_to', $event.target.value)"/>
                                                    </template>
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>Ship To</label>
                                                <div v-show="ship_to.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <v-select :options="ship_to.options" v-model="stockHeading.ship_to">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" :required="!stockHeading.ship_to" v-bind="attributes" v-on="events"
                                                               @keypress="search('ship_to', $event.target.value)"/>
                                                    </template>
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Supplier</label>
                                                <div v-show="suppliers.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <v-select :options="suppliers.options" v-model="stockHeading.supplier">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" :required="!stockHeading.supplier" v-bind="attributes" v-on="events"
                                                               @keypress="search('suppliers', $event.target.value)"/>
                                                    </template>
                                                </v-select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>Quantity Per Invoice</label>
                                                <input type="text" class="form-control" placeholder="Quantity Per Invoice" v-model="stockHeading.quantity_per_inv" :disabled="true">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="detail-section mt-5">
                                    <h4>Stock Detail</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(item, serialNo) in detailSection" :key="serialNo">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Sys ID</label>
                                                    <input type="text" class="form-control" placeholder="Sys ID" v-model="detailSection[serialNo]['sys_id']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.sys_id')" v-text="get('detail.'+serialNo+'.sys_id')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>IMEI Number</label>
                                                    <input type="text" class="form-control" placeholder="IMEI Number" v-model="detailSection[serialNo]['imei']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.imei')" v-text="get('detail.'+serialNo+'.imei')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Serial Number</label>
                                                    <input type="text" class="form-control" placeholder="Serial Number" v-model="detailSection[serialNo]['serial_no']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.serial_no')" v-text="get('detail.'+serialNo+'.serial_no')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Make</label>
                                                    <div v-show="make[serialNo] ? make[serialNo].spinner : make.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="make[serialNo] ? make[serialNo].options: make.options" v-model="detailSection[serialNo]['make']" :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" :required="!detailSection[serialNo]['make']" v-bind="attributes" v-on="events"
                                                                   @keypress="search('make', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.make')" v-text="get('detail.'+serialNo+'.make')"></span>
                                                </div>

                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Model</label>
                                                    <div v-show="make_models[serialNo] ? make_models[serialNo].spinner : make_models.spinner" class="spinner-border v-select-spinner spinner-grow-sm"
                                                         role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="make_models[serialNo] ? make_models[serialNo].options: make_models.options" v-model="detailSection[serialNo]['model']"
                                                              :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" :required="!detailSection[serialNo]['model']" v-bind="attributes" v-on="events"
                                                                   @keypress="search('make_models', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.model')" v-text="get('detail.'+serialNo+'.model')"></span>
                                                </div>

                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Bank Deal#</label>
                                                    <div v-show="bank_deals[serialNo] ? bank_deals[serialNo].spinner : bank_deals.spinner" class="spinner-border v-select-spinner spinner-grow-sm"
                                                         role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="bank_deals[serialNo] ? bank_deals[serialNo].options: bank_deals.options" v-model="detailSection[serialNo]['bank_deal_no']"
                                                              :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"
                                                                   @keypress="search('bank_deals', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.bank_deal_no')" v-text="get('detail.'+serialNo+'.bank_deal_no')"></span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Color</label>
                                                    <div v-show="colors[serialNo] ? colors[serialNo].spinner : colors.spinner" class="spinner-border v-select-spinner spinner-grow-sm"
                                                         role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="colors[serialNo] ? colors[serialNo].options: colors.options" v-model="detailSection[serialNo]['color']"
                                                              :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" :required="!detailSection[serialNo]['color']" v-bind="attributes" v-on="events"
                                                                   @keypress="search('colors', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.color')" v-text="get('detail.'+serialNo+'.color')"></span>
                                                </div>

                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Grade</label>
                                                    <div v-show="grades[serialNo] ? grades[serialNo].spinner : grades.spinner" class="spinner-border v-select-spinner spinner-grow-sm"
                                                         role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="grades[serialNo] ? grades[serialNo].options: grades.options" v-model="detailSection[serialNo]['grade']"
                                                              :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" :required="!detailSection[serialNo]['grade']" v-bind="attributes" v-on="events"
                                                                   @keypress="search('grades', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.grade')" v-text="get('detail.'+serialNo+'.grade')"></span>
                                                </div>

                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Capacity</label>
                                                    <div v-show="capacities[serialNo] ? capacities[serialNo].spinner : capacities.spinner" class="spinner-border v-select-spinner spinner-grow-sm"
                                                         role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :options="capacities[serialNo] ? capacities[serialNo].options: capacities.options" v-model="detailSection[serialNo]['capacity']"
                                                              :key="serialNo">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" :required="!detailSection[serialNo]['capacity']" v-bind="attributes" v-on="events"
                                                                   @keypress="search('capacities', $event.target.value, serialNo)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.capacity')" v-text="get('detail.'+serialNo+'.capacity')"></span>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Part No</label>
                                                    <input type="text" class="form-control" placeholder="Make" v-model="detailSection[serialNo]['part_no']">
                                                </div>
                                                <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.part_no')" v-text="get('detail.'+serialNo+'.part_no')"></span>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Stock ID</label>
                                                    <input type="text" class="form-control" placeholder="Model" v-model="detailSection[serialNo]['stock_id']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.stock_id')" v-text="get('detail.'+serialNo+'.stock_id')"></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Price AED</label>
                                                    <input type="text" class="form-control" placeholder="Price AED" v-model="detailSection[serialNo]['price_aed']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.price_aed')" v-text="get('detail.'+serialNo+'.price_aed')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Price USD</label>
                                                    <input type="text" class="form-control" placeholder="Price USD" v-model="detailSection[serialNo]['price_usd']" :disabled="true">
                                                </div>
                                                <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.price_usd')" v-text="get('detail.'+serialNo+'.price_usd')"></span>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Custom Duty</label>
                                                    <input type="text" class="form-control" placeholder="Serial Number" v-model="detailSection[serialNo]['custom_duty']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.custom_duty')" v-text="get('detail.'+serialNo+'.custom_duty')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Freight</label>
                                                    <input type="text" class="form-control" placeholder="Make" v-model="detailSection[serialNo]['freight']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.freight')" v-text="get('detail.'+serialNo+'.freight')"></span>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Total Cost</label>
                                                    <input type="text" class="form-control" placeholder="Model" v-model="detailSection[serialNo]['total_cost']">
                                                    <span class="error invalid-feedback" v-if="has('detail.'+serialNo+'.total_cost')" v-text="get('detail.'+serialNo+'.total_cost')"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <button type="button" class="btn btn-default" @click.prevent="cancelForm">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    export default {

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
                stockHeading: {
                    invoice_no: '',
                    declaration_no: '',
                    supplier: '',
                    ship_to: '',
                    bill_to: '',
                    region: '',
                    tracking_no: '',
                    invoice_date: '',
                    so_number: '',
                    so_date: '',
                    quantity_per_inv: ''
                },
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
                console.log(search);
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

            uploadExcel() {
                this.loading = true;
                let formData = new FormData();
                formData.append('file', this.file);
                axios.post('/process-excel', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: function (progressEvent) {
                        this.uploadPercentage = parseInt(Math.round((progressEvent.loaded / progressEvent.total) * 100));
                    }.bind(this)
                })
                    .then(function (response) {
                        this.uploadPercentage = 0;
                        this.loading = false;
                        this.fileName = 'Choose File';
                        this.showUploadForm = false;
                        this.mapResponseToHeading(response.data.heading);
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
                        //console.log(makeModels);
                        this.make_models = Object.assign({}, this.make_models, makeModels);
                        this.make = Object.assign({}, this.make, make);
                        this.colors = Object.assign({}, this.colors, color);
                        this.grades = Object.assign({}, this.grades, grade);
                        this.capacities = Object.assign({}, this.capacities, capacity);
                        this.bank_deals = Object.assign({}, this.bank_deals, bankDeal);

                        this.detailSection = response.data.detail;
                    }.bind(this))
                    .catch(function (errors) {
                        console.log(this.errors);
                        this.loading = false;
                        this.uploadPercentage = 0;
                        this.errors = errors.response.data.errors;
                    }.bind(this));
            },

            has(field) {
                return this.errors.hasOwnProperty(field);
            },

            get(field) {
                console.log(field);
                if (this.errors[field]) {
                    return this.errors[field][0];
                }
            },

            onSubmitStock() {
                this.loadingForm = true;
                axios.post('/stock', {'heading': this.stockHeading, 'detail': this.detailSection, 'local_imported': this.local_imported})
                    .then(response => {
                        this.showUploadForm = true;
                        this.loadingForm = false;
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
        }
    }
</script>
