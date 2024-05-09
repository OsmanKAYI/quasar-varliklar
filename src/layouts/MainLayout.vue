<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title> Quasar ile Varlık Hesabı </q-toolbar-title>

        <q-btn
          flat
          dense
          @click="$q.fullscreen.toggle()"
          :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
          :label="$q.fullscreen.isActive ? 'TamEkran:Kapat' : 'TamEkran:Aç'"
          :no-caps="true"
          class="q-mr-sm"
        />

        <q-btn
          flat
          dense
          @click="$q.dark.toggle()"
          :icon="$q.dark.isActive ? 'light_mode' : 'dark_mode'"
          :label="$q.fullscreen.isActive ? 'Dark' : 'Light'"
          :no-caps="true"
          class="q-mr-sm"
        />

        <div>Quasar v{{ $q.version }}</div>
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-list>
        <q-item-label header>Yapabileceğiniz İşlemler </q-item-label>
        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import EssentialLink, {
  EssentialLinkProps,
} from 'src/components/EssentialLink.vue';

const essentialLinks: EssentialLinkProps[] = [
  {
    title: 'Ana Sayfa',
    caption: 'Ana sayfa',
    icon: 'home',
    link: '/',
  },
  {
    title: 'Tanımlar',
    caption: 'Varlık türleri',
    icon: 'settings',
    link: '/asset-types',
  },
  {
    title: 'Varlıklarım',
    caption: 'Varlıklarım',
    icon: 'work',
    link: '/assets',
  },
];

const leftDrawerOpen = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}
</script>
