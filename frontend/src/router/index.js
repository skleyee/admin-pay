import { createRouter, createWebHistory } from 'vue-router'
import UsersView from '../views/UsersView.vue'
import PaymentsView from "@/views/PaymentsView";
import RegisterView from "@/views/RegisterView";
import LoginView from "@/views/LoginView";
import CreatePayment from "@/views/CreatePayment";
import store from '../store';

const routes = [
  {
    path: '/',
    name: 'users',
    component: UsersView,
    meta: { requiresAuth: true }
  },
  {
    path: '/payments',
    name: 'payments',
    component: PaymentsView,
    meta: { requiresAuth: true }
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView
  },
  {
    path: '/payment',
    name: 'payment',
    component: CreatePayment,
    meta: { requiresAuth: true }
  },

]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!store.getters.authToken; // Проверка наличия токена
  if (to.meta.requiresAuth && !isAuthenticated) {
    next({ name: 'login' });
  } else {
    next();
  }
});

export default router
