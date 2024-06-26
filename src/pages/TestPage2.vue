<template>
  <q-card class="q-ma-sm">
    <q-toolbar class="bg-primary text-white">
      <q-avatar>
        <img src="/logos/OzlemLogo_64x64.svg" />
      </q-avatar>
      <q-toolbar-title>Seyahat Tarihi?</q-toolbar-title>
      <q-btn flat round dense icon="close" size="lg" v-close-popup />
    </q-toolbar>

    <q-card class="q-py-sm q-ma-none">
      <TestDate></TestDate>
    </q-card>
  </q-card>
</template>

<script setup lang="ts">
import TestDate from 'components/TestDate.vue';
</script>
