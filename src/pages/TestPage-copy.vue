<template>
  <q-page>
    <q-btn
      @click="goToNextMonth"
      label="Sonraki Ay Görünümü"
      color="primary"
      class="q-mb-md"
    />
    <q-date
      v-model="selectedDate"
      @navigation="handleNavigation"
      bordered
      today-btn
    />
    <div class="q-mt-md">
      <q-card>
        <q-card-section>
          <div>Selected Date: {{ selectedDate }}</div>
          <div>Current View: {{ currentView }}</div>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script setup>
import { ref } from 'vue';
import { date } from 'quasar';

const selectedDate = ref(date.formatDate(new Date(), 'YYYY-MM-DD'));
const currentView = ref('');

const handleNavigation = (view) => {
  console.log(view);
  currentView.value = view;
};

const goToNextMonth = () => {
  const current = new Date(selectedDate.value);
  current.setMonth(current.getMonth() + 1);
  selectedDate.value = date.formatDate(current, 'YYYY-MM-DD');
};
</script>
