import Vue from 'vue'

import VueRouter from 'vue-router'

Vue.use(VueRouter)

import Dashboard from '../components/dashboard/container'
import Tickets from '../components/tickets/container'
import Sales from "../components/sales/container"
import Clients from "../components/clients/container"
import Login from "../components/Login"
import Mainboard from "../components/MainComponent"
import Admin from "../components/admin/container"
import Reports from "../components/reports/container"
import axios from 'axios'

const routes = [

    {
        component: Mainboard,
        name: 'homepage',
        path: '/welcome',
        beforeEnter: (to, from, next) => {
            axios.get('/api/authenticated').then(() => {
                next(
               
                );
            }).catch(() => {
                next({ name: 'login' });
            })
        },
        children: [
            {
                component: Tickets,
                name: 'tickets',
                path: '/tickets',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        next({ name: 'login' });
                    })
                },
            },
            {
                component: Sales,
                name: 'sales',
                path: '/sales',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        next ({ name: 'login' });
                    })
                },
            },
            {
                component: Clients,
                name: 'clients',
                path: '/clients',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        next ({ name: 'login' });
                    })
                },
            },
            {
                component: Reports,
                name: 'reports',
                path: '/reports',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        next ({ name: 'login' });
                    })
                },
            },
            {
                component: Admin,
                name: 'admin',
                path: '/admin',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        next ({ name: 'login' });
                    })
                },
            },
            {
                component: Dashboard,
                name: 'dashboard',
                path: '/dashboard',
                beforeEnter: (to, from, next) => {
                    axios.get('/api/authenticated').then(() => {
                        next();
                    }).catch(() => {
                        return ({ name: 'login' });
                    })
                },
            },
        ]
    },
    {
        component: Login,
        name: 'login',
        path: '/'
    },
    {
        component: Login,
        path: '*'
    },

];



export default new VueRouter(
    {
        mode: 'history',
        routes
    }
);

// const router = new VueRouter(
//     {
//         mode: 'history',
//         routes
//     }
// );

// router.beforeEach((to, from, next) => {
//     if (to.name !== 'login') {
//       next({ name: 'login' });
//     } else {
//       next();
//     }
//   });


//   export default router;