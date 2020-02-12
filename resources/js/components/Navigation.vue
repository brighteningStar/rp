<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                 with font-awesome or any other icon font library -->
            <div v-for="menu in navMenus">
                <li class="nav-item" v-if="menu.children==null && menu.route!=null">
                    <a :href="menu.route" class="nav-link" v-bind:class="{ active: isActive(menu) }">
                        <i :class="menu.icon" class="nav-icon"></i>
                        <p>{{menu.title}}</p>
                    </a>
                </li>

                <li class="nav-item has-treeview" v-bind:class="{ 'menu-open': hasActiveChildren(menu) }" v-else="">
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






<!--            <li class="nav-item has-treeview menu-open">-->
<!--                <a href="#" class="nav-link active">-->
<!--                    <i class="nav-icon fas fa-tachometer-alt"></i>-->
<!--                    <p>-->
<!--                        Dashboard-->
<!--                        <i class="right fas fa-angle-left"></i>-->
<!--                    </p>-->
<!--                </a>-->
<!--                <ul class="nav nav-treeview">-->
<!--                    <li class="nav-item">-->
<!--                        <a href="./index.html" class="nav-link active">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Dashboard v1</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="./index2.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Dashboard v2</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="./index3.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Dashboard v3</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->
<!--            <li class="nav-item has-treeview">-->
<!--                <a href="#" class="nav-link">-->
<!--                    <i class="nav-icon fas fa-copy"></i>-->
<!--                    <p>-->
<!--                        Layout Options-->
<!--                        <i class="fas fa-angle-left right"></i>-->
<!--                        <span class="badge badge-info right">6</span>-->
<!--                    </p>-->
<!--                </a>-->
<!--                <ul class="nav nav-treeview">-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/top-nav.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Top Navigation</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/top-nav-sidebar.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Top Navigation + Sidebar</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/boxed.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Boxed</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/fixed-sidebar.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Fixed Sidebar</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/fixed-topnav.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Fixed Navbar</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/fixed-footer.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Fixed Footer</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                    <li class="nav-item">-->
<!--                        <a href="pages/layout/collapsed-sidebar.html" class="nav-link">-->
<!--                            <i class="far fa-circle nav-icon"></i>-->
<!--                            <p>Collapsed Sidebar</p>-->
<!--                        </a>-->
<!--                    </li>-->
<!--                </ul>-->
<!--            </li>-->



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
                return menu.route==currentPage
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