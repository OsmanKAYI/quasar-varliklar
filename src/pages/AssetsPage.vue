<template>
  <q-page padding>
    <h3>Tarih Dene</h3>
    <SelectDate v-model="myDate" />
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
const myDate = ref('2024/01/25');
import SelectDate from 'src/components/SelectDate.vue';
</script>
