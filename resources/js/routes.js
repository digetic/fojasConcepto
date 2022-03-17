import Vue from 'vue'
import Router from 'vue-router'
Vue.use(Router)

export default new Router ({
    mode: 'history',
    linkActiveClass: 'active',
    routes: [
        {
            path: '*',
            component: require('./components/Notfound.vue').default
        },
        {
            path: '/',
            component: require('./components/Bienvenida.vue').default
        },
        /**
         * RUTAS PARA LA CREACION DE UNA NUEVA EVALUACION
         */
        {
            path: '/listaEvaluaciones',
            name: 'ListaEvaluaciones',
            component: require('./components/Evaluacion/ListaEvaluaciones.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-eval') && per.includes('create-evalu')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        {
            path: '/nuevaEvaluacion',
            name: 'NuevaEvaluacion',
            component: require('./components/Evaluacion/NuevaEvaluacion.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-eval') && per.includes('create-evalu')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * Ruta para la vista principal para acceder a la vista 
         * de designacion de evaluadores a los diferentes destinos de la 
         * Fuerza Aerea
         */
        {
            path: '/listaUnidadesDesignaciones/:e',
            name: 'ListaUnidadesDesignaciones',
            component: require('./components/Evaluadores/ListaUnidadesDesignacion.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-eval') && per.includes('create-evalu')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        //Vista para realizar la designacion de jurados        
        {
            path: '/designacionJurado/:des1/:des2/:des3/:e',
            name: 'DesignacionJurado',
            component: require('./components/Evaluadores/DesignacionJurado.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-eval') && per.includes('create-evalu')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /***
         * Calificacion de foja de concepto
         */
        /**
         * Rutas para la evaluacion 
         */
        //Index Evaluador
        {
            path: '/indexEvaluacion',
            name: 'IndexEvaluacion',
            component: require('./components/Evaluaciones/IndexFoja.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-cali') && per.includes('index-cali')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * Ruta para la pantalla principal de lista de evaluaciones por 
         * destino4 designado
         */

         {
            path: '/fojasDestList/:e',
            name: 'FojasDestList',
            component: require('./components/Evaluaciones/FojasDestList.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-cali') && per.includes('index-cali')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * Ruta para la pantalla donde se lista el personal a ser evaluado
         */
         {
            path: '/personalFoja/:d4/:e/:id',
            name: 'PersonalFoja',
            component: require('./components/Evaluaciones/PersonalFoja.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-cali') && per.includes('index-cali')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * Ruta para la pantalla de foja de calificacion 
         */
         {
            path: '/foja/:perCod/:d4/:e/:id/:jpid',
            name: 'Foja',
            component: require('./components/foja/Foja.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-cali') && per.includes('index-cali')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
         /**
         * Ruta para la impresionde las evaluaciones
         */
          {
            path: '/reporte',
            name: 'Reporte',
            component: require('./components/ImpresionFoja/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('vist-cali') && per.includes('index-cali')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * ACCESO AL SISTEMA
         */

        /**
         * Ruta para creacion de usuarios
         */
         {
            path: '/usuarios',
            name: 'Usuarios',
            component:  require('./components/Usuarios/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-user')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        {
            path: '/datosUser',
            name: 'DatosUser',
            component:  require('./components/Usuarios/DatosUser.vue').default
        },
        /**
         * Rutas para cracion de roles
         */
        {
            path: '/roles',
            name: 'Roles',
            component:  require('./components/Roles/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-rol')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        {
            path: '/nuevoRol',
            name: 'NuevoRol',
            component:  require('./components/Roles/Create.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        {
            path: '/editarRol/:id',
            name: 'EditarRol',
            component:  require('./components/Roles/Editar.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
        /**
         * Rutas para los permisos
         */
         {
            path: '/permisos',
            name: 'Permisos',
            component:  require('./components/Permisos/Index.vue').default,
            beforeEnter: (to, from, next) => {
                let per = window.user.permissions.map(permission=>permission.name);
                if (per.includes('view-rolper') && per.includes('view-permi')) {
                    next();
                } else {
                    next(from.path);
                }                
            }
        },
    ]


})
