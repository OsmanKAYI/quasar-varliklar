<template>
  <q-card>
    <q-card-section>
      <q-btn @click="oncekiAy()">Önceki Ay</q-btn>
      <q-btn @click="sonrakiAy()">Sonraki Ay</q-btn>
      <br /><br />
      <q-btn @click="setToToday">Bugünü Göster</q-btn>
      <br /><br />
      <q-btn @click="setToSpecificDate">2028/07 Tarihini Göster</q-btn>
      <br /><br />
      <q-date v-model="selectedDate" ref="datePicker" />
      <br /><br />
      <pre>{{ selectedDate }}</pre>
      <pre>{{ datePicker }}</pre>
    </q-card-section>
  </q-card>
</template>

<script setup>
import { ref } from 'vue';

const ay = ref(6);
const selectedDate = ref('2024/06/26'); // Initial selected date format: 'YYYY-MM-DD'
const datePicker = ref(null); // Ref for accessing QDate component

const setToToday = () => {
  datePicker.value.setToday(); // Set calendar to today
  console.log('setToToday');
};
const oncekiAy = () => {
  ay.value--;
  if (datePicker.value) {
    datePicker.value.setCalendarTo(2024, ay.value); // Set calendar to yesterday
  }
};
const sonrakiAy = () => {
  ay.value++;
  if (datePicker.value) {
    datePicker.value.setCalendarTo(2024, ay.value); // Set calendar to yesterday
  }
};
const setToSpecificDate = () => {
  if (datePicker.value) {
    datePicker.value.setCalendarTo(2028, 7); // Set calendar to a specific date
  }
};
</script>
