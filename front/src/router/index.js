import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import( '../views/Dashboard.vue')
  },
  {
    path: '/:pathMatch(.*)*',
    name: 'Katman',
    component: () => import('../views/Layer.vue'),
    meta: {
      katman: true
    }
  },
  {
    path: '/liste',
    name: 'Liste',
    component: () => import( '../views/List.vue')
  },
  {
    path: '/layer',
    name: 'Layer',
    component: () => import( '../views/Layer.vue')
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
