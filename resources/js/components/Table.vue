<template>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <loading v-if="loading"></loading>
                <div class="card-header">
                    <h3 class="card-title">{{title}}</h3>
                    <div class="card-tools">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control float-right input-lg" placeholder="Search" @keyup="search()" v-model="q">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div :id="uri" class="card-body table-responsive p-0" style="max-height: 500px;">
                    <table class="table table-head-fixed text-nowrap table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col" v-for="(column, index) in columns" :key="index"> {{capitalize(column)}}</th>
                            <th v-show="! showEditIcon">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in items" :key="index">
                            <td v-for="(column, indexColumn) in columns" :key="indexColumn">{{item[column]}}</td>
                            <td v-show="! showEditIcon" v-if="editUrl==null"><a href="#" data-toggle="modal" data-target="#modal-xl" @click.prevent="openModal(item.id)"><i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i></a></td>
                            <td v-else=""><a :href="updateEditUrl(item.id)"><i class="fas fa-pencil-alt mr-1" aria-hidden="true"></i></a></td>
                        </tr>
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example" style="margin-top: 16px; margin-right: 10px;">
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
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['uri', 'title', 'editUrl', 'showEditIcon'],

        data() {
            return {
                items: [],
                columns: [],
                loading: false,
                q: '',
                previousPage: '',
                nextPage: '',
                currentPage: 1,
            };
        },

        methods: {
            openModal(itemId) {
                Event.$emit('editModal', {itemId});
            },

            loadTable() {
                this.loading = true;
                axios.get(this.formUrl())
                    .then(function (response) {
                        this.loading = false;
                        this.items = response.data.items.data;
                        this.columns = response.data.columns;
                        this.nextPage = this.getPageNumber('page', response.data.items.next_page_url);
                        this.previousPage = this.getPageNumber('page', response.data.items.prev_page_url);
                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
            },

            search() {
                if (this.validateSearchQuery(this.q)) {
                    this.loadTable();
                }
            },

            moveForward() {
                this.currentPage = (this.nextPage) ? this.nextPage : this.currentPage;

                this.loadTable();
            },

            moveBack() {
                this.currentPage = (this.previousPage) ? this.previousPage : this.currentPage;

                this.loadTable();
            },

            getPageNumber(param, url) {
                let href = url;
                //this expression is to get the query strings
                let reg = new RegExp('[?&]' + param + '=([^&#]*)', 'i');
                let queryString = reg.exec(href);
                return queryString ? queryString[1] : null;
            },

            validateSearchQuery(q) {
                return !(q && q.length < 3);
            },

            formUrl() {
                let queryString = this.q;

                if( queryString && queryString.length < 3 ) {
                    return this.uri + '/?q=&page=' + this.currentPage;
                }

                return this.uri + '/?q=' + this.q + '&page=' + this.currentPage;
            },

            capitalize(s){
                return s[0].toUpperCase() + s.slice(1);
            },

            updateEditUrl(id){
                return this.editUrl.replace("id", id);
            }
        },

        created() {
            let self = this;
            Event.$on('reloadTable', (data) => {
                self.loadTable();
            });
        },

        mounted() {
            this.loadTable();
        }
    }
</script>
