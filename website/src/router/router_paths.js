export default [
  {
    path: '/page',
    component: () => import('@/views/pages/Index'),
    children: [
      {
        name: 'Login',
        path: 'login',
        meta: { authRequired: false },
        component: () => import('@/views/pages/Login'),
      },
      {
        name: 'request_password_reset',
        path: '/password/reset',
        meta: { authRequired: false },
        component: () => import('@/views/pages/RequestPasswordReset'),
      },
      {
        name: 'password_reset',
        path: '/password/reset/:id',
        meta: { authRequired: false },
        component: () => import('@/views/pages/PasswordReset'),
      },
    ],
  },
  {
    path: '/',
    component: () => import('@/views/dashboard/Index'),
    children: [
      // Admin
      // {
      //   name: 'admin',
      //   path: 'admin/',
      //   meta: { authRequired: true, admin: true },
      //   component: () => import('@/views/dashboard/admin/Index'),
      //   children: [
      //     {
      //       name: 'organization',
      //       path: 'organization',
      //       meta: { authRequired: true, admin: true, display_name: 'page.admin.organization' },
      //       component: () => import('@/views/dashboard/admin/organization/All'),
      //     }
      //   ],
      // },
      {
        name: 'users',
        path: '/users',
        meta: { authRequired: false },
        component: () => import('@/views/dashboard/pages/Users'),
      },
      {
        name: 'trades',
        path: '/trades',
        meta: { authRequired: false },
        component: () => import('@/views/dashboard/pages/Trades'),
      },
      {
        name: 'log',
        path: '/log/',
        component: () => import('@/views/dashboard/pages/logs/Index'),
        meta: { authRequired: true, admin: true },
        children: [

          {
            name: 'sell',
            path: 'sell',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Sell'),
          },
          {
            name: 'buy',
            path: 'buy',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Buy'),
          },
          {
            name: 'craft',
            path: 'craft',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Craft'),
          },
          {
            name: 'harvest',
            path: 'harvest',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Harvest'),
          },
          {
            name: 'pickup',
            path: 'pickup',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Pickup'),
          },
          {
            name: 'place',
            path: 'place',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Place'),
          },
          {
            name: 'play',
            path: 'play',
            meta: { authRequired: false },
            component: () => import('@/views/dashboard/pages/logs/Play'),
          }
        ],
      },
      // Dashboard
      {
        name: 'dashboard',
        path: '',
        meta: { authRequired: true },
        component: () => import('@/views/dashboard/Dashboard'),
      }
    ],
  },
  {
    path: '*',
    component: () => import('@/views/pages/Index'),
    children: [
      {
        name: '404 Error',
        path: '',
        meta: { authRequired: false },
        component: () => import('@/views/pages/Error'),
      },
    ],
  },
]
