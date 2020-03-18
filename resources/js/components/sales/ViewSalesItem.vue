<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="form.loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Sales Form</h3>
                        </div>
                        <div>
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Select Customer</label>
                                                <customer-select v-model.sync="form.customer_id" disabled="1"></customer-select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Sales Date</label>
                                                <datepicker :format="dateFormatter" disabled class="v-datepicker-custom" name="sales_date" v-model="form.sale_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" disabled v-model="form.invoice_no" class="form-control" placeholder="Invoice Number">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <br>

                                <!-- filters for imei -->
                                <div class="head-section">
                                    <h4>Filters For IMEI</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(filter, index) in form.filters">
                                        <div class="row" >
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Select Model</label>
                                                    <model-select v-model.sync="filter.model" disabled="1"></model-select>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Select Color</label>
                                                    <color-select v-model.sync="filter.color" disabled="1"></color-select>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Select Capacity</label>
                                                    <capacity-select v-model.sync="filter.capacity" disabled="1"></capacity-select>
                                                </div>
                                            </div>

                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Select Grade</label>
                                                    <grade-select v-model.sync="filter.grade" disabled="1"></grade-select>
                                                </div>
                                            </div>

                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Quantity</label>
                                                    <input type="text" disabled class="form-control" v-model="filter.quantity">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <br>
                                </div>

                                <div class="detail-section mt-5">
                                    <h4>Detail Section</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(row, index) in form.details">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Search by IMEI</label>
                                                    <div  v-if="row.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :value="row.imei" :options="row.imeis" :disabled="true">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events" />
                                                        </template>
                                                    </v-select>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Price AED</label>
                                                    <input type="text" disabled class="form-control" v-model="row.price_aed">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Freight</label>
                                                    <input type="text" disabled class="form-control" v-model="row.freight">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>unit price</label>
                                                    <input type="text" disabled class="form-control" v-model="row.unit_price">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>discount</label>
                                                    <input type="text" disabled class="form-control" v-model="row.discount">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>amount</label>
                                                    <input type="text" disabled class="form-control" v-model="row.amount">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
    import {Form} from "../../Form"
    export default {
        props: ['id'],
        data() {
            return {
                form: new Form({
                    customer_id: '',
                    sale_date: '',
                    invoice_no: '',
                    loading:false,
                    details:[{
                        detail_id:'',
                        imei:'',
                        price_aed:'',
                        freight:'',
                        unit_price:'',
                        discount:'',
                        amount:'',
                        imeis:[],
                        spinner:false,
                        filter_id:null,
                    }],
                    filters:[{
                        'model' :null,
                        'capacity' :null,
                        'color' :null,
                        'grade' :null,
                        'quantity': 0,
                        'unique_key':Date.now()
                    }],
                }),
            };
        },


        methods: {
            dateFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getData(){
                this.form.loading = true;
                axios.get('/sales/'+this.id,{
                })
                    .then(function (response) {
                        this.loadData(response.data);

                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        this.form.loading = false;
                    }.bind(this));
            },

            loadData(data){
                let self = this;
                console.log(data);
                this.form.customer_id = data.customer_id;
                this.form.invoice_no = data.invoice_no;
                this.form.sale_date = data.sale_date;

                this.form.details = [];
                this.form.filters = [];

                data.filters.forEach(function(entry) {
                    let newobj = {
                        'model' :entry.search_model_id,
                        'capacity' :entry.search_capacity_id,
                        'color' :entry.search_color_id,
                        'grade' :entry.search_grade_id,
                        'quantity': entry.quantity,
                    }
                    self.form.filters.push(newobj);
                });

                data.stock_details.forEach(function(entry) {
                    let newobj = {
                        detail_id:entry.id,
                        price_aed:entry.price_aed,
                        freight:entry.stock_head.freight,
                        unit_price:entry.pivot.unit_price,
                        discount:entry.pivot.discount,
                        amount:entry.pivot.amount,
                        imeis:[{label:entry.imei_no, value:{id:entry.id, imei_no:entry.imei_no, price_aed:entry.price_aed , freight:entry.freight}}],
                        imei:entry.imei_no,
                        spinner:false,
                    }
                    self.form.details.push(newobj);
                });
            },

        },

        mounted() {
            if(this.id){
                this.getData();
            }
        }



    }
</script>
