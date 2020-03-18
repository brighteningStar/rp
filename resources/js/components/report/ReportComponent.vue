<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <loading v-if="loading"></loading>
                        <div class="card-header">
                            <h3 class="card-title">Report</h3>
                        </div>
                        <form v-if="! showSelectionForm" role="form" @submit.prevent="onGenerateReport">
                            <div class="card-body">
                                <div class="head-section">
                                    <h4>Selectors</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Report Type</label>
                                                <v-select label="title" :options="report_type.options" v-model="report_type.selected">
                                                    <template #search="{attributes, events}">
                                                        <input class="vs__search" v-bind="attributes" v-on="events"/>
                                                    </template>
                                                </v-select>
                                                <span class="error invalid-feedback"></span>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>Start Date</label>
                                                <datepicker class="v-datepicker-custom" :format="dateFormatter" v-model="start_date"></datepicker>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label>End Date</label>
                                                <datepicker class="v-datepicker-custom" :format="dateFormatter" v-model="end_date"></datepicker>
                                            </div>
                                        </div>
                                    </div>
                                    <h4>Columns</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="tracking_number" v-model="checkedNames"> Tracking Number</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="supplier_id" v-model="checkedNames"> Supplier</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="so_number" v-model="checkedNames"> SO Number</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="so_date" v-model="checkedNames"> So Date</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="declaration_number" v-model="checkedNames"> Declaration Number</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="bill_to" v-model="checkedNames"> Bill To</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="ship_to" v-model="checkedNames"> Ship To</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="make_id" v-model="checkedNames"> Maker</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="model_id" v-model="checkedNames"> Model</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="capacity_id" v-model="checkedNames"> Capacity</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="grade_id" v-model="checkedNames"> Grade</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="price_usd" v-model="checkedNames"> Price (USD)</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="price_aed" v-model="checkedNames"> Price (AED)</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="total_cost" v-model="checkedNames"> Total Cost</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="local_imported" v-model="checkedNames"> Local/Imported</label>
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkbox">
                                                <label><input type="checkbox" value="stock_number" v-model="checkedNames"> Stock Number</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Generate Report</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div v-if="showSelectionForm" class="card-body table-responsive p-0" style="max-height: 500px;">
                <table v-if="tableHasData" class="table table-head-fixed text-nowrap table-striped table-bordered">
                    <thead>
                    <tr>
                        <th scope="col" v-for="(column, index) in columns" :key="index"> {{column}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in items" :key="index">
                        <td v-for="(column, indexColumn) in columns" :key="indexColumn">{{item[column]}}</td>
                    </tr>
                    </tbody>
                </table>
                <!-- <nav aria-label="Page navigation example" style="margin-top: 16px; margin-right: 10px;">
                    <ul class="pagination justify-content-center pagination-md">
                        <li class="page-item">
                            <button @click="moveBack()" :class="{ 'disable-link' : ! previousPage, 'page-link' : previousPage }" href="#" aria-label="Previous" name="previousPage" v-model="previousPage" :disabled="! this.previousPage">
                                <span aria-hidden="true"><i class="fas fa-angle-double-left"></i></span>
                                <span class="sr-only">Previous</span>
                            </button>
                        </li>
                        <li class="page-item">
                            <button @click="moveForward()" :class="{ 'disable-link' : ! nextPage, 'page-link' : nextPage }" href="#" aria-label="Next" name="nextPage" v-model="nextPage" :disabled="! this.nextPage">
                                <span aria-hidden="true"><i class="fas fa-angle-double-right"></i></span>
                                <span class="sr-only">Next</span>
                            </button>
                        </li>
                    </ul>
                </nav> -->
                <div v-if="! tableHasData" class="alert alert-danger">
                    <span v-text="errorMessage"></span>
                </div>
                <button type="button" class="btn btn-primary mt-2" @click="loadForm">View More Report</button>
            </div>
        </div>

    </section>
</template>

<script>
export default {
    data() {
        return {
            loading          : false,
            showSelectionForm: false,
            tableHasData     : true,
            errorMessage     : '',
            checkedNames     : [],
            items            : [],
            columns          : [],
            start_date       : moment('2020-01-01').startOf('month').format('YYYY-MM-DD'),
            end_date         : moment().endOf('month').format('YYYY-MM-DD'),
            report_type      : {
                options: [{'title': 'In Stock', 'id': 'in_stock'}, {'title': 'Sold', 'id': 'sold'}, {'title': 'RMA', 'id': 'rma'}, {'title': 'Supplier Credit', 'id': 'supplier_credit'}],
                selected: [{'title': 'In Stock', 'id': 'in_stock'}]
            }
        }
    },

    methods : {

        dateFormatter(date) {
            return moment(date).format('YYYY-MM-DD');
        },

        loadForm() {
            this.showSelectionForm = false;
        },

        onGenerateReport() {
            this.loading           = true;
            this.showSelectionForm = true;
            axios.get('/fetch-report', {'params': {
                    'check_list' : this.checkedNames,
                    'report_type': this.report_type.selected.id,
                    'start_date' : moment(this.start_date).format('YYYY-MM-DD'),
                    'end_date'   : moment(this.end_date).format('YYYY-MM-DD'),
                } 
            })
            .then(response => {
                this.loading      = false;
                this.tableHasData = true;
                this.items        = response.data.items;
                this.columns      = response.data.columns;
            })
            .catch(function (errors) {
                this.loading      = false;
                this.tableHasData = false;
                this.errorMessage = errors.response.data.message;
            }.bind(this))
        }
    },
}
</script>