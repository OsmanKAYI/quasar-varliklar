<template>
  <q-card class="q-ma-lg">
    <div>
      <q-date
        v-model="departureDate"
        mask="YYYY/MM/DD"
        subtitle="Seçili Tarih:"
        :title="departureDate"
        years-in-month-view
        :max="departureDateLimit"
        today-btn
        :options="dateOptions"
        @update:model-value="updateJourneyDate"
        no-unset
      >
        <template v-slot:today-btn="scope">
          <q-btn
            flat
            dense
            @click="scope.today"
            icon="event"
            label="Today"
            color="primary"
          />
        </template>
        <q-btn
          class="q-ml-md q-mb-sm"
          color="primary"
          label="Bugün"
          @click="setToday"
        />
        <q-btn
          class="q-ml-md"
          color="primary"
          label="Yarın"
          @click="setTomorrow"
        />
        <q-btn
          class="q-ml-md q-mb-sm"
          color="secondary"
          label="Bu Ay"
          @click="setCurrentMonth"
        />
        <q-btn
          class="q-ml-md"
          color="secondary"
          label="Gelecek Ay"
          @click="setNextMonth"
          no-wrap
        />

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

const departureDate = ref(date.formatDate(todaysDate, 'YYYY/MM/DD'));

const departureDateLimit = ref(
  date.formatDate(
    date.addToDate(todaysDate, {
      days: 70,
      months: 0,
    }),
    'YYYY/MM/DD'
  )
);

const setToday = () => {
  let myDate = new Date();
  departureDate.value = date.formatDate(myDate, 'YYYY/MM/DD');
};

const setTomorrow = () => {
  let myDate = new Date();
  let tmpDate = date.addToDate(myDate, {
    days: 1,
  });
  departureDate.value = date.formatDate(tmpDate, 'YYYY/MM/DD');
};

const setCurrentMonth = () => {
  let myDate = new Date();
  departureDate.value = date.formatDate(myDate, 'YYYY/MM/DD');
};

const setNextMonth = () => {
  let myDate = new Date();
  myDate.setMonth(myDate.getMonth() + 1);
  myDate.setDate(1);
  departureDate.value = date.formatDate(myDate, 'YYYY/MM/DD');
};

function dateOptions(calendarDate: string): boolean {
  const timeStamp = Date.now();
  const minDate = date.formatDate(timeStamp, 'YYYY/MM/DD');

  const timeStamp70 = date.addToDate(timeStamp, { days: 70, months: 0 });
  const maxDate = date.formatDate(timeStamp70, 'YYYY/MM/DD');
  return calendarDate >= minDate && calendarDate <= maxDate;
}

const journeyDate = ref<string | null>(null);

function updateJourneyDate() {
  journeyDate.value = departureDate.value;
}

function saveDate() {
  departureDate.value == journeyDate.value;
}
</script>
