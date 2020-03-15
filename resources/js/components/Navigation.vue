<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <div v-for="menu in navMenus">
                <li class="nav-item" v-if="menu.children==null && menu.route!=null">
                    <a :href="menu.route" class="nav-link" v-bind:class="{ active: isActive(menu) }">
                        <i :class="menu.icon" class="nav-icon"></i>
                        <p>{{menu.title}}</p>
                    </a>
                </li>
                <li class="nav-item has-treeview" v-bind:class="{ 'menu-open': hasActiveChildren(menu) }" v-else-if="menu.children!=null">
                    <a href="#" class="nav-link">
                        <i class="nav-icon" :class="menu.icon"></i>
                        <p>{{menu.title}}<i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item" v-for="menu2 in menu.children">
                            <a :href="menu2.route" class="nav-link" v-bind:class="{ active: isActive(menu2) }">
                                <i class="nav-icon" :class="menu2.icon"></i>
                                <p>{{menu2.title}}</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </div>

        </ul>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
                navMenus:[],
            };
        },
        methods: {
            getSidebar:function() {
                let self = this;
                axios.get('/navigation')
                    .then(function (response) {
                        self.navMenus = Object.values(response.data);
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },

            isActive:function(menu){
                let currentPage = window.location.href.replace(/^(.+?)\/*?$/, "$1");
                let routes = menu.routes_to_active.split("|");
                let res = routes.indexOf(currentPage);
                return res>=0;
            },

            hasActiveChildren: function(menu){
                let currentPage = window.location.href.replace(/^(.+?)\/*?$/, "$1");
                let res = false;
                for(var i=0;i<menu.children.length;i++){
                    if(menu.children[i].route==currentPage){
                        res = true;
                    }
                }
                return res;
            }
        },
        mounted() {
            this.getSidebar();
        }
    }
</script>