import vSelect from 'vue-select'
import Datepicker from 'vuejs-datepicker';

Vue.component('v-select', vSelect);
Vue.component('datepicker', Datepicker);

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

// base
Vue.component('error-boundry', require('./components/ErrorBoundry.vue').default);

// auth
Vue.component('login-component', require('./components/LoginComponent.vue').default);
Vue.component('register-component', require('./components/RegisterComponent.vue').default);


// element components
Vue.component('app-navigation', require('./components/Navigation.vue').default);
Vue.component('user-component', require('./components/UserComponent.vue').default);
Vue.component('loading', require('./components/Loading.vue').default);
Vue.component('modal', require('./components/Modal.vue').default);
Vue.component('table-vue', require('./components/Table.vue').default);
Vue.component('search-imei', require('./components/SearchImei.vue').default);

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
Vue.component('location-component', require('./components/forms/LocationComponent.vue').default);

//selects
Vue.component('make-select', require('./components/selects/MakeSelect.vue').default);
Vue.component('role-select', require('./components/selects/RoleSelect.vue').default);
Vue.component('customer-select', require('./components/selects/CustomerSelect.vue').default);
Vue.component('model-select', require('./components/selects/ModelSelect.vue').default);
Vue.component('color-select', require('./components/selects/ColorSelect.vue').default);
Vue.component('capacity-select', require('./components/selects/CapacitySelect.vue').default);
Vue.component('grade-select', require('./components/selects/GradeSelect.vue').default);
Vue.component('fault-type-select', require('./components/selects/FaultTypeSelect.vue').default);
Vue.component('location-select', require('./components/selects/LocationSelect.vue').default);
Vue.component('supplier-select', require('./components/selects/SupplierSelect.vue').default);

// app components
Vue.component('stock-component', require('./components/stock/StockComponent.vue').default);
Vue.component('stock-edit-component', require('./components/stock/StockEditComponent.vue').default);
Vue.component('update-profile-component', require('./components/Profile.vue').default);
Vue.component('update-password-component', require('./components/ChangePassword.vue').default);

//sales components
Vue.component('sales-component', require('./components/sales/SalesComponent.vue').default);
Vue.component('create-sales-item', require('./components/sales/CreateSalesItem.vue').default);
Vue.component('view-sales-item', require('./components/sales/ViewSalesItem.vue').default);

//rma components
Vue.component('rma-component', require('./components/rma/RMAComponent.vue').default);
Vue.component('create-rma-item', require('./components/rma/CreateRMAItem.vue').default);
Vue.component('view-rma-item', require('./components/rma/ViewRMAItem.vue').default);

//report
Vue.component('report-component', require('./components/report/ReportComponent.vue').default);


//supplier credit components
Vue.component('supplier-credit-component', require('./components/supplier-credit/SupplierCreditComponent.vue').default);
Vue.component('create-supplier-credit-item', require('./components/supplier-credit/CreateSupplierCredit.vue').default);
Vue.component('view-supplier-credit-item', require('./components/supplier-credit/ViewSupplierCredit.vue').default);
