import { RouteRecordRaw } from 'vue-router';

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: () => import('layouts/MainLayout.vue'),
    children: [
      {
        path: '',
        component: () => import('pages/IndexPage.vue'),
        meta: { title: 'Home' },
      },
      {
        path: 'login',
        component: () => import('pages/LoginPage.vue'),
        meta: { title: 'login' },
      },
      {
        path: 'about',
        component: () => import('pages/AboutPage.vue'),
        meta: { title: 'about' },
      },
      {
        path: 'asset-types',
        component: () => import('pages/AssetTypesPage.vue'),
        meta: { title: 'Asset Types' },
      },
      {
        path: 'assets',
        component: () => import('pages/AssetsPage.vue'),
        meta: { title: 'Assets' },
      },
      {
        path: 'test',
        component: () => import('pages/TestPage.vue'),
        meta: { title: 'Assets' },
      },
      {
        path: 'bilgi/:slug',
        component: () => import('pages/BilgiPage.vue'),
        meta: { title: 'Bilgi' },
      },
    ],
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/404Page.vue'),
    meta: { title: '404 Error' },
  },
];

export default routes;
