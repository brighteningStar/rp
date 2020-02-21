

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// element components
Vue.component('app-navigation', require('./components/Navigation.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('loading', require('./components/Loading.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('table-vue', require('./components/Table.vue').default);

// form components
Vue.component('color-component', require('./components/forms/ColorComponent.vue').default);
Vue.component('capacity-component', require('./components/forms/CapacityComponent.vue').default);
Vue.component('make-component', require('./components/forms/MakeComponent.vue').default);
Vue.component('grade-component', require('./components/forms/GradeComponent.vue').default);
Vue.component('fault-type-component', require('./components/forms/FaultTypeComponent.vue').default);
Vue.component('customer-component', require('./components/forms/CustomerComponent.vue').default);
Vue.component('supplier-component', require('./components/forms/SupplierComponent.vue').default);
Vue.component('region-component', require('./components/forms/RegionComponent.vue').default);
Vue.component('make-model-component', require('./components/forms/MakeModelComponent.vue').default);

//selects
Vue.component('make-select', require('./components/selects/MakeSelect.vue').default);
Vue.component('role-select', require('./components/selects/RoleSelect.vue').default);

// app components
Vue.component('stock-component', require('./components/stock/StockComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('update-profile-component', require('./components/Profile.vue').default);
Vue.component('update-password-component', require('./components/ChangePassword.vue').default);



