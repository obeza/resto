
import * as VueRouter from 'vue-router'
//import store from './store/index'
import useAuthStore from './store/auth'

import Home from './Home.vue'

//import Restos from './dash/resto/Restos.vue'
const Restos = ()=> import('./dash/resto/Restos.vue')
// import RestoCreate from './dash/resto/RestoCreate.vue'
const RestoCreate = ()=> import('./dash/resto/RestoCreate.vue')
// import RestoUpdate from './dash/resto/RestoUpdate.vue'
const RestoUpdate = ()=> import('./dash/resto/RestoUpdate.vue')
// import Utilisateurs from './dash/utilisateur/Utilisateurs.vue'
const Utilisateurs = ()=> import('./dash/utilisateur/Utilisateurs.vue')
//import Login from './dash/Login.vue'
const Login = ()=> import('./dash/Login.vue')
// import Rubriques from './dash/menu/Rubriques.vue'
const Rubriques = ()=> import('./dash/menu/Rubriques.vue')
// import Articles from './dash/menu/articles.vue'
const Articles = ()=> import('./dash/menu/articles.vue')
// import ArticlesCreate from './dash/menu/ArticlesCreate.vue'
const ArticlesCreate = ()=> import('./dash/menu/ArticlesCreate.vue')
// import ArticlesUpdate from './dash/menu/ArticlesUpdate.vue'
const ArticlesUpdate = ()=> import('./dash/menu/ArticlesUpdate.vue')

//
//  Reseto : Karaoke
//
//const ShopKaraokeHome = ()=> import('./shop/karaoke/Home.vue')

//
import Logout from './dash/Logout.vue'

import NotFound from './NotFound.vue'


const routes = [
  { 
    // home page guest
    path: '/', 
    name: 'home',   
    component: Home
  },
  // { 
  //   // App Karaoke Bar
  //   path: '/restos/karaoke/home', 
  //   name: 'shop-karaoke',   
  //   component: ShopKaraokeHome,
  // },
  { 
    // liste des restos
    // home de l'admin : dash
    path: '/dash', 
    name: 'restos',   
    component: Restos,
    meta: {requiresAuth: true}
  },
  { 
    // liste des rubriques dans un menu
    path: '/menu/:restoId', 
    name: 'menu',   
    component: Rubriques,
    props: true,
    meta: {requiresAuth: true}
  },
  { 
    // liste des articles dans une rubrique
    path: '/menu/:restoId/articles/:rubriqueId', 
    name: 'articles',   
    component: Articles,
    props: true,
    meta: {requiresAuth: true}
  },
  { 
    // formulaire pour ajouter un article
    path: '/menu/:restoId/articles/:rubriqueId/create', 
    name: 'article-create',   
    component: ArticlesCreate,
    props: true,
    meta: {requiresAuth: true}
  },
  { 
    // formulaire pour modifier un article
    path: '/menu/:restoId/articles/:rubriqueId/update/:articleId', 
    name: 'article-update',  
    component: ArticlesUpdate,
    props: true,
    meta: {requiresAuth: true}
  },
  { 
    name: 'restos-create', 
    path: '/restos/create', 
    component: RestoCreate,
    meta: {requiresAuth: true}
  },
  { 
    name: 'restos-update', 
    path: '/restos/:restoId/update', 
    component: RestoUpdate,
    props: true,
    meta: {requiresAuth: true}
  },
  { name: 'utilisateurs', path: '/utilisateurs', component: Utilisateurs},
  { name: 'login', path: '/dash/login', component: Login },
  { name: 'logout', path: '/dash/logout', component: Logout },
  {
    name: 'PageNotFound',
    path: '/404',
    component: NotFound
  },
  {
    path: '/:catchAll(.*)',
    redirect: '/404'
  }
]

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes, // short for 'routes:routes
});

router.beforeEach((to, from, next) => {
  const authStore = useAuthStore()
  authStore.checkLocalStore()

  if (to.meta.requiresAuth && !authStore.isLoggedIn) //return '/login'
  {
    next({name: 'login'});
  } else {
    next();
  }
});

export default router