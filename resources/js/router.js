
import * as VueRouter from 'vue-router'
import store from './store'

import Restos from './resto/Restos.vue'
import RestoCreate from './resto/RestoCreate.vue'
import RestoUpdate from './resto/RestoUpdate.vue'
import Utilisateurs from './utilisateur/Utilisateurs.vue'
import Login from './Login.vue'
import Rubriques from './menu/Rubriques.vue'
import Articles from './menu/articles.vue'
import ArticlesCreate from './menu/ArticlesCreate.vue'
import ArticlesUpdate from './menu/ArticlesUpdate.vue'
import NotFound from './NotFound.vue'

const routes = [
  //{ name: 'home', path: '/', component: Home},
  { 
    // liste des restos accessible par l'utilisateur
    path: '/', 
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
  { name: 'login', path: '/login', component: Login },
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
  if (to.meta.requiresAuth && !store.state.user.token){
    next({name: 'login'});
  } else {
    next();
  }
});

export default router