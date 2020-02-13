<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <loading v-if="loading"></loading>
                <div class="card-header">
                    <h3 class="card-title">Users</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div :id="uri" class="card-body table-responsive p-0" style="height: 300px;">
                    <table class="table table-head-fixed text-nowrap table-striped">
                        <thead>
                        <tr>
                            <th scope="col" v-for="(column, index) in columns" :key="index"> {{column}}</th>
                            <th>action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                            <td v-for="(column, indexColumn) in columns" :key="indexColumn">{{item[column]}}</td>
                            <td><a href="#" data-toggle="modal" data-target="#modal-xl" @click.prevent="openModal(item.id)"><i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['uri'],

        data() {
            return {
                items: [],
                columns: [],
                loading: false
            };
        },

        methods: {
            openModal(itemId ) {
                Event.$emit('openModal', {itemId});
            }
        },


        mounted() {
            this.loading = true;
            axios.get(this.uri)
                .then(function (response) {
                    this.loading = false;
                    this.items = response.data.items;
                    this.columns = response.data.columns;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>
