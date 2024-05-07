import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('src/pages/IndexPage.vue'),
        meta: { title: 'Home - MyApp' },
      },
      {
        path: 'login',
        component: () => import('src/pages/LoginPage.vue'),
        meta: { title: 'login - MyApp' },
      },
      {
        path: 'about',
        component: () => import('src/pages/AboutPage.vue'),
        meta: { title: 'about - MyApp' },
      },
      {
        path: 'asset-types',
        component: () => import('src/pages/AssetTypesPage.vue'),
        meta: { title: 'Asset Types - MyApp' },
      },
      {
        path: 'assets',
        component: () => import('src/pages/AssetsPage.vue'),
        meta: { title: 'Assets - MyApp' },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('src/pages/404Page.vue'),
    meta: { title: '404 Error - MyApp' },
  },
];

export default routes;
