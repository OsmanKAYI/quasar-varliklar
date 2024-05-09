import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('src/pages/IndexPage.vue'),
        meta: { title: 'Home' },
      },
      {
        path: 'login',
        component: () => import('src/pages/LoginPage.vue'),
        meta: { title: 'login' },
      },
      {
        path: 'about',
        component: () => import('src/pages/AboutPage.vue'),
        meta: { title: 'about' },
      },
      {
        path: 'asset-types',
        component: () => import('src/pages/AssetTypesPage.vue'),
        meta: { title: 'Asset Types' },
      },
      {
        path: 'assets',
        component: () => import('src/pages/AssetsPage.vue'),
        meta: { title: 'Assets' },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('src/pages/404Page.vue'),
    meta: { title: '404 Error' },
  },
];

export default routes;
