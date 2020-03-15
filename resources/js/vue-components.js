import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker';

Vue.component('v-select', vSelect);
Vue.component('datepicker', Datepicker);

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
Vue.component('shipping-billing-component', require('./components/forms/ShippingBillingComponent.vue').default);
Vue.component('bank-deal-component', require('./components/forms/BankDealComponent.vue').default);

//selects
Vue.component('make-select', require('./components/selects/MakeSelect.vue').default);
Vue.component('role-select', require('./components/selects/RoleSelect.vue').default);
Vue.component('customer-select', require('./components/selects/CustomerSelect.vue').default);

// app components
Vue.component('stock-component', require('./components/stock/StockComponent.vue').default);
Vue.component('stock-edit-component', require('./components/stock/StockEditComponent.vue').default);
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);
Vue.component('update-profile-component', require('./components/Profile.vue').default);
Vue.component('update-password-component', require('./components/ChangePassword.vue').default);

//sales components
Vue.component('sales-component', require('./components/sales/SalesComponent.vue').default);
Vue.component('create-sales-item', require('./components/sales/CreateSalesItem.vue').default);

//rma components
Vue.component('rma-component', require('./components/rma/RMAComponent.vue').default);
Vue.component('create-rma-item', require('./components/rma/CreateRMAItem.vue').default);


