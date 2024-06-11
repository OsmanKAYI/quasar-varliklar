<template>
  <q-page class="q-pa-md">
    <q-date
      v-model="selectedDate"
      :options="isDayEnabled"
      :navigation-buttons="true"
      header-navigation
      minimal
      @navigation="onNavigation"
    >
      <template v-slot:default>
        <div class="row items-center justify-between q-my-sm">
          {{ scope }}
          <q-btn icon="chevron_left" @click="goToPreviousMonth" />
          <div class="q-ma-sm">{{ currentMonth }}</div>
          <q-btn icon="chevron_right" @click="goToNextMonth" />
        </div>
      </template>
    </q-date>
  </q-page>
</template>

<script setup>
import { ref } from 'vue';

const selectedDate = ref('');
const currentDate = ref(new Date());
const currentMonth = ref(
  currentDate.value.toLocaleString('default', { month: 'long' })
);

const isDayEnabled = (date) => {
  return true; // Tüm günler seçilebilir.
};

const goToPreviousMonth = () => {
  currentDate.value.setMonth(currentDate.value.getMonth() - 1);
  currentMonth.value = currentDate.value.toLocaleString('default', {
    month: 'long',
  });
};

const goToNextMonth = () => {
  currentDate.value.setMonth(currentDate.value.getMonth() + 1);
  currentMonth.value = currentDate.value.toLocaleString('default', {
    month: 'long',
  });
};

const onNavigation = (view) => {
  currentMonth.value = new Date(view.year, view.month - 1).toLocaleString(
    'default',
    { month: 'long' }
  );
};
</script>

<style scoped>
.q-date__navigation {
  display: none;
}
.q-date__actions {
  display: none;
}
</style>
