import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CadastroView from '../views/CadastroView.vue'
import LoginView from '../views/LoginView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
      meta: {
        requiresAuth: true,
      },
    },
    {
      path: '/cadastro',
      name: 'cadastro',
      component: CadastroView
    },
    {
      path: '/login',
      name: 'login',
      component: LoginView
    },
    {
/*       path: '/about',
      name: 'about', */
      // route level code-splitting
      // this generates a separate chunk (About.[hash].js) for this route
      // which is lazy-loaded when the route is visited.
     /*  component: () => import('../views/AboutView.vue') */
    }
  ]
})

router.beforeEach(async (to, from, next) => {
  // Verifica se a rota requer autenticação
  if (to.matched.some(record => record.meta.requiresAuth)) {
    try {
      // Substitua esta lógica pela verificação real de autenticação
      const isAuthenticated = await checkAuthentication();
      if (isAuthenticated) {
        // Se estiver autenticado, permita o acesso à rota
        next();
      } else {
        // Se não estiver autenticado, redirecione para a página de login
        next('/login');
      }
    } catch (error) {
      console.error('Erro ao verificar autenticação:', error);
      // Em caso de erro, redirecione para a página de login
      next('/login');
    }
  } else {
    // Se a rota não requer autenticação, permita o acesso
    next();
  }
});

// Função para verificar autenticação usando token do localStorage
async function checkAuthentication() {
  // Obtenha o token do localStorage
  const token = localStorage.getItem('token');

  // Verifique se o token está presente
  if (token) {
    // Implemente sua lógica para verificar a validade do token (por exemplo, chamada de API)
    // Esta função deve retornar uma Promise que resolve para true se o token for válido, false se não for válido
    return new Promise((resolve, reject) => {
      // Lógica de exemplo: assumindo que o token é válido
      resolve(true);
    });
  } else {
    // Se o token não estiver presente, considere o usuário como não autenticado
    return Promise.resolve(false);
  }
}


export default router
