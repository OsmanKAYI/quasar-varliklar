<template>
  <q-card class="q-ma-lg">
    <div>
      <q-date
        v-model="dateSelect"
        mask="YYYY/MM/DD"
        subtitle="Seçili Tarih:"
        :title="dateSelect"
        years-in-month-view
        :max="dateSelectLimit"
        today-btn
        :options="dateOptions"
        @update:model-value="updateJourneyDate"
        no-unset
      >
        <q-btn label="Vazgeç" color="primary" v-close-popup /><br />
        <q-btn label="Tamam" color="primary" @click="saveDate" v-close-popup />
      </q-date>
    </div>
  </q-card>
</template>

<style scoped>
.xq-pa-md {
  max-width: 400px;
  margin: auto;
}
</style>

<script setup lang="ts">
import { ref } from 'vue';
import { date } from 'quasar';
let todaysDate = new Date();

const dateSelect = ref(date.formatDate(todaysDate, 'YYYY/MM/DD'));

const dateSelectLimit = ref(
  date.formatDate(
    date.addToDate(todaysDate, {
      days: 70,
      months: 0,
    }),
    'YYYY/MM/DD'
  )
);

function dateOptions(calendarDate: string): boolean {
  const timeStamp = Date.now();
  const minDate = date.formatDate(timeStamp, 'YYYY/MM/DD');

  const timeStamp70 = date.addToDate(timeStamp, { days: 70, months: 0 });
  const maxDate = date.formatDate(timeStamp70, 'YYYY/MM/DD');
  return calendarDate >= minDate && calendarDate <= maxDate;
}

const journeyDate = ref<string | null>(null);

function updateJourneyDate() {
  journeyDate.value = dateSelect.value;
}

function saveDate() {
  dateSelect.value == journeyDate.value;
}
</script>
