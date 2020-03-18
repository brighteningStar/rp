<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="form.loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Supplier Credit Form</h3>
                        </div>
                        <form role="form" @submit.prevent="onSubmitForm">
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Head Section</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Supplier Credit Date</label>
                                                <datepicker :format="dateFormatter" class="v-datepicker-custom" name="supplier_credit_date" v-model="form.credit_date"></datepicker>
                                                <span class="error invalid-feedback" v-if="form.errors.has('credit_date')" v-text="form.errors.get('credit_date')"></span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Invoice Number</label>
                                                <input type="text" v-model="form.credit_invoice_no" class="form-control" placeholder="Invoice Number">
                                                <span class="error invalid-feedback" v-if="form.errors.has('credit_invoice_no')" v-text="form.errors.get('credit_invoice_no')"></span>
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Select Supplier</label>
                                                <supplier-select v-model.sync="form.supplier_id"></supplier-select>
                                                <span class="error invalid-feedback" v-if="form.errors.has('supplier_id')" v-text="form.errors.get('supplier_id')"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="detail-section mt-5">
                                    <h4>Detail Section</h4>
                                    <hr>
                                    <div class="detail-section-row mt-2" v-for="(row, index) in form.details">
                                        <div class="row">
                                            <a href="#" @click.prevent="deleteRow(index)" class="delete-detail-row"><i class="far fa-times-circle"></i></a>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>Search by IMEI</label>
                                                    <div  v-if="row.spinner" class="spinner-border v-select-spinner spinner-grow-sm" role="status">
                                                        <span class="sr-only">Loading...</span>
                                                    </div>
                                                    <v-select :value="row.imei" :options="row.imeis" v-on:input="setImeiDetails($event, row); addRow($event);" :disabled="isDisabled">
                                                        <template #search="{attributes, events}">
                                                            <input class="vs__search" v-bind="attributes" v-on="events" @keyup="searchImei(row, $event.target.value)"/>
                                                        </template>
                                                    </v-select>
                                                    <span class="error invalid-feedback" v-if="form.errors.has('details.'+index+'.imei')" v-text="form.errors.get('details.'+index+'.imei')"></span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label>USD Price</label>
                                                    <input type="text" disabled class="form-control" v-model="row.usd_price">
                                                </div>
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
    import {Form} from "../../Form"
    export default {
        props: ['id'],
        data() {
            return {
                form: new Form({
                    supplier_id: null,
                    credit_invoice_no: '',
                    credit_date: '',
                    loading:false,
                    details:[{
                        detail_id:'',
                        imei:'',
                        usd_price:'',
                        imeis:[],
                        spinner:false,
                    }],
                }),
            };
        },
        computed: {
            isDisabled(){
                if(this.form.supplier_id==null)
                    return true;
                else
                    return false;
            }
        },

        methods: {
            dateFormatter(date) {
                return moment(date).format('DD-MM-YYYY');
            },

            onSubmitForm(){
                if(this.id) {
                    this.form.put('/supplier-credit/'+this.id)
                        .then(function (response) {
                            window.location.replace("/supplier-credit");
                        })
                        .catch(errors => console.log(errors));
                } else {
                    this.form.post('/supplier-credit')
                        .then(function (response) {
                            window.location.replace("/supplier-credit");
                        })
                        .catch(errors => console.log(errors));
                }

            },

            addRow(event){
                if(event==null){
                    return;
                }
                this.form.details.push({
                    detail_id:'',
                    imei:'',
                    usd_price:'',
                    imeis:[],
                    spinner:false,
                });
            },

            deleteRow(index){
                this.form.details.splice(index, 1);
            },

            searchImei(row, imei){

                row.spinner=true;
                axios.get('/supplier-credit/search/imei',{
                    params: {
                        imei: imei,
                        supplier_id: this.form.supplier_id
                    },
                })
                    .then(function (response) {
                        row.imeis = response.data;

                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        row.spinner=false;
                    });

            },

            setImeiDetails(event, row){
                if(event==null){
                    row.imei = '';
                    row.detail_id ='';
                    row.usd_price ='';
                } else {
                    row.imei = event.value.imei_no;
                    row.detail_id = event.value.id;
                    row.usd_price =event.value.usd_price;
                }

            },

            // getData(){
            //     this.form.loading = true;
            //     axios.get('/rma/'+this.id,{
            //     })
            //         .then(function (response) {
            //             this.loadData(response.data);
            //
            //         }.bind(this))
            //         .catch(function (error) {
            //             console.log(error);
            //         })
            //         .then(function () {
            //             this.form.loading = false;
            //         }.bind(this));
            // },
            //
            // loadData(data){
            //     let self = this;
            //     this.form.customer_id = data.customer_id;
            //     this.form.rma_no = data.rma_number;
            //     this.form.rma_date = data.rma_date;
            //     this.form.details = [];
            //     data.stock_details.forEach(function(entry) {
            //         let newobj = {
            //             detail_id:entry.id,
            //             fault_type_id:entry.pivot.fault_type_id,
            //             fault:entry.pivot.fault,
            //             location_id: entry.pivot.location_id,
            //             sale_price:entry.pivot.sale_price,
            //             imeis:[{label:entry.imei_no, value:{id:entry.id, imei_no:entry.imei_no, price_aed:entry.price_aed , freight:entry.freight}}],
            //             imei:entry.imei_no,
            //             spinner:false,
            //         }
            //         self.form.details.push(newobj);
            //     });
            // },

        },

        mounted() {
            // if(this.id){
            //     this.getData();
            // }
        }



    }
</script>