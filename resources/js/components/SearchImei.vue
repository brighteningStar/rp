<template>
    <form class="form-inline ml-3" @submit.prevent="searchImei">
        <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" v-model="imei" placeholder="Search" aria-label="Search">
            <div class="input-group-append">
                <i v-if="loading" class="spinner-border spinner-grow-sm"></i>
                <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
    </form>
</template>

<script>
    export default {
        data() {
            return {
                imei: '',
                loading:false,
            }
        },
        methods: {
            searchImei(){
                this.loading = true;
                axios.get('/search-by-imei', {
                    params: {
                        imei: this.imei
                    }
                })
                    .then(function (response) {

                    }.bind(this))
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        this.loading = false;
                    }.bind(this));
            }
        },

        mounted() {

        }
    }
</script>
