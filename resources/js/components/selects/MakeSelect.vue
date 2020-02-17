<template>
        <loading  v-if="load" ></loading>
        <label style="width:100%;" v-else="">Select Make
            <select class="form-control" v-model="makeSelected">
                <option value="">Please Select</option>
                <option v-for="item in items" :value="item.id">{{item.name}}</option>
            </select>
        </label>
</template>

<script>
    module.exports = {
        data(){
            return{
                load: false,
                items:[],
                makeSelected: ''
            }
        },
        mounted() {
            this.load = true;
            axios.get('/forms/makes/get')
                .then(function (response) {
                    this.load = false;
                    this.items = response.data.items.data;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })

        },
        watch: {
            makeSelected: function() {
                this.$emit('input', this.makeSelected);
            }
        }
    }
</script>