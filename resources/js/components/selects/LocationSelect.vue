<template>
    <loading  v-if="load" ></loading>
    <div v-else="">
        <v-select :value="location" :reduce="name => name.id" label="name" :options="items" @input="updateValue"></v-select>
    </div>
</template>

<script>
    module.exports = {
        props: ['value'],
        data(){
            return{
                load: false,
                items:[],
                location:'',
            }
        },
        methods: {
            updateValue(value) {
                this.location = value;
                this.$emit('input', this.location);
            },

            transformData(data){
                let myarr = [];
                for(let i=0;i<data.length;i++){
                    let myobj = {};
                    myobj.name = data[i].name;
                    myobj.id = data[i].id;
                    myarr.push(myobj);
                }
                return myarr;
            },
        },
        mounted() {
            this.load = true;
            axios.get('/forms/locations/get')
                .then(function (response) {
                    this.load = false;
                    this.items = this.transformData(response.data.items.data);
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })

        },
        watch: {
            value: function(val) {
                this.location = val;
            }
        }
    }
</script>