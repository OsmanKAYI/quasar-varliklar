import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      { path: '', component: () => import('src/pages/IndexPage.vue') },
      {
        path: 'login',
        component: () => import('src/pages/LoginPage.vue'),
      },
      {
        path: 'about',
        component: () => import('src/pages/AboutPage.vue'),
      },
      {
        path: 'asset-types',
        component: () => import('src/pages/AssetTypesPage.vue'),
      },
      {
        path: 'assets',
        component: () => import('src/pages/AssetsPage.vue'),
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('src/pages/404Page.vue'),
  },
];

export default routes;
