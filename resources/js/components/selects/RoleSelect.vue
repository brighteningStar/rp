<template>
    <loading  v-if="load" ></loading>
    <label style="width:100%;" v-else="">Select Role
        <select class="form-control" ref="role" @input="updateValue()">
            <option value="">Please Select</option>
            <option v-for="item in items" :value="item.id">{{formattedName(item.name)}}</option>
        </select>
    </label>
</template>

<script>
    module.exports = {
        props: ['value'],
        data(){
            return{
                load: false,
                items:[],
            }
        },

        methods: {
            updateValue() {
                this.$emit('input', this.$refs.role.value);
            },

            formattedName(str){
                let name = str.replace("_", " ");
                return name.charAt(0).toUpperCase() + name.slice(1)
            },
        },
        mounted() {
            this.load = true;
            axios.get('/roles/get')
                .then(function (response) {
                    this.load = false;
                    this.items = response.data.items;
                }.bind(this))
                .catch(function (error) {
                    console.log(error);
                })

        },
        watch: {
            value: function(val) {
                this.$refs.role.value = val;
            }
        }
    }
</script>