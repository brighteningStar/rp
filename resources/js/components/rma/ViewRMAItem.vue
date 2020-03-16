<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="form.loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">RMA Form</h3>
                        </div>
                        <div>
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>RMA Date</label>
                                                <datepicker :format="dateFormatter" class="v-datepicker-custom" name="rma_date" v-model="form.rma_date" disabled></datepicker>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>RMA Number</label>
                                                <input type="text" v-model="form.rma_no" class="form-control" placeholder="RMA Number" disabled>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Select Customer</label>
                                                <customer-select v-model.sync="form.customer_id" disabled="true"></customer-select>
                                            </div>
                                        </div>
                                    </div>
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
                                                    <v-select :value="row.imei" :options="row.imeis" v-on:input="setImeiDetails($event, row)" :disabled="true">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                        </template>
                                                    </v-select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Sale Price</label>
                                                    <input type="text" disabled class="form-control" v-model="row.sale_price">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Fault Type</label>
                                                    <fault-type-select v-model.sync="row.fault_type_id" disabled="true"></fault-type-select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Fault Description</label>
                                                    <input type="text" disabled class="form-control" v-model="row.fault">
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Location</label>
                                                    <location-select v-model.sync="row.location_id" disabled="true"></location-select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                    customer_id: null,
                    rma_date: '',
                    rma_no: '',
                    loading:false,
                    details:[{
                        detail_id:'',
                        imei:'',
                        fault_type_id:'',
                        fault:'',
                        location_id:'',
                        sale_price:'',
                        imeis:[],
                        spinner:false,
                    }],
                }),
            };
        },
        computed: {
            isDisabled(){
                if(this.form.customer_id==null)
                    return true;
                else
                    return false;
            }
        },

        methods: {
            dateFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },

            getData(){
                this.form.loading = true;
                axios.get('/rma/'+this.id,{
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
                this.form.customer_id = data.customer_id;
                this.form.rma_no = data.rma_number;
                this.form.rma_date = data.rma_date;
                this.form.details = [];
                data.stock_details.forEach(function(entry) {
                    let newobj = {
                        detail_id:entry.id,
                        fault_type_id:entry.pivot.fault_type_id,
                        fault:entry.pivot.fault,
                        location_id: entry.pivot.location_id,
                        sale_price:entry.pivot.sale_price,
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