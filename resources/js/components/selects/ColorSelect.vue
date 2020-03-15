<template>
    <loading  v-if="load" ></loading>
    <div v-else="">
        <v-select :value="color" :reduce="name => name.id" label="name" :options="items" @input="updateValue"></v-select>
    </div>
</template>

<script>
    module.exports = {
        props: ['value'],
        data(){
            return{
                load: false,
                items:[],
                makeSelected: '',
                color:'',
            }
        },
        methods: {
            updateValue(value) {
                this.color = value;
                this.$emit('input', this.color);
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
            axios.get('/forms/colors/get')
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
                this.color = val;
            }
        }
    }
</script>