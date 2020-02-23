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
        </div>
        <div v-if="! showUploadForm" class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Stock Form</h3>
                        </div>
                        <form role="form" @submit.prevent="onSubmitStock">
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
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
                                                <label>So Date</label>
                                                <datepicker class="v-datepicker-custom" :format="dateFormatter" :value="stockHeading.so_date" name="so_date"
                                                            v-model="stockHeading.so_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <label>So Number</label>
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
                                                <select class="form-control select2" style="width: 100%;">
                                                    <option selected="selected" value="local">Local</option>
                                                    <option value="imported">Imported</option>
                                                </select>
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
                                                               @keypress="search('shipping_billings', $event.target.value)"/>
                                                    </template>
                                                </v-select>
                                            </div>
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <label>Ship To</label>
                                                <div v-show="ship_to.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                                <v-select :options="ship_to.options" v-model="stockHeading.ship_to">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" :required="!stockHeading.ship_to" v-bind="attributes" v-on="events"
                                                               @keypress="search('shipping_billings', $event.target.value)"/>
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
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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
                errors: {},
                showUploadForm: true,
                fileName: 'Choose file',
                file: '',
                uploadPercentage: 0,
                loading: false,
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


            search(name, search) {
                this[name].spinner = true;
                this.fetchList(search, this, name);
            },


            fetchList: _.debounce((search, vm, name) => {
                fetch(
                    `/search?q=${escape(search)}&table=${escape(name)}`
                ).then(res => {
                    res.json().then(json => (vm[name].options = json.items));
                    vm[name].spinner = false;
                });
            }, 350),

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
                        this.loading = false;
                        this.fileName = 'Choose File'; 
                        this.showUploadForm = false;
                        this.mapResponseToHeading(response.data.heading);
                    }.bind(this))
                    .catch(function (errors) {
                        this.loading = false;
                        this.uploadPercentage = 0;
                        this.errors = errors.response.data;
                    }.bind(this));
            },

            has(field) {
                return this.errors.hasOwnProperty(field);
            },

            get(field) {
                if (this.errors[field]) {
                    return this.errors[field];
                }
            },

            onSubmitStock() {
                axios.post('/stock', this.stockHeading)
                    .then(response => {
                        console.log(response);
                    })
                    .catch(errors => {
                        console.log(errors);
                    })
            }
        },

        mounted() {
        }
    }
</script>
