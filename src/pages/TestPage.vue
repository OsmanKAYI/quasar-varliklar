<script setup lang="ts">
import { ref } from 'vue';
import { date } from 'quasar';
let todaysDate = new Date();

const departureDate = ref(date.formatDate(todaysDate, 'DD-MM-YYYY'));

const departureDateLimit = ref(
  date.formatDate(
    date.addToDate(todaysDate, {
      days: 70,
      months: 0,
    }),
    'DD-MM-YYYY'
  )
);

const items = [
  { id: '9', name: 'Ankara' },
  { id: '2', name: 'İstanbul' },
  { id: '1', name: 'Çankırı' },
  { id: '3', name: 'Ilgaz' },
];

const filteredItems = ref(items);

const setToday = () => {
  let myDate = new Date();
  departureDate.value = date.formatDate(myDate, 'DD-MM-YYYY');
};
const setTomorrow = () => {
  let myDate = new Date();
  let tmpDate = date.addToDate(myDate, {
    days: 1,
  });
  departureDate.value = date.formatDate(tmpDate, 'DD-MM-YYYY');
};
const setCurrentMonth = () => {
  let myDate = new Date();
  departureDate.value = date.formatDate(myDate, 'DD-MM-YYYY');
};
const setNextMonth = () => {
  let myDate = new Date();
  myDate.setMonth(myDate.getMonth() + 1);
  myDate.setDate(1);
  departureDate.value = date.formatDate(myDate, 'DD-MM-YYYY');
};
function dateOptions(calendarDate: string): boolean {
  const timeStamp = Date.now();
  const minDate = date.formatDate(timeStamp, 'YYYY/MM/DD');

  const timeStamp70 = date.addToDate(timeStamp, { days: 70, months: 0 });
  const maxDate = date.formatDate(timeStamp70, 'YYYY/MM/DD');
  return calendarDate >= minDate && calendarDate <= maxDate;
}

const journeyDate = ref(date as any);
function updateJourneyDate() {
  journeyDate.value = departureDate.value;
}

function saveDate() {
  departureDate.value == journeyDate.value;
}

function filterItems(val: string, update: any) {
  update(() => {
    const needle = turkishToLower(val);
    filteredItems.value = items.filter((item) =>
      turkishToLower(item.name).includes(needle)
    );
  });
}

function turkishToLower(str: string): string {
  return str
    .replace(/[\u0130]/g, 'i') // İ -> i
    .replace(/[\u0049]/g, 'ı') // I -> ı
    .replace(/[\u011e]/g, 'g') // Ğ -> ğ
    .replace(/[\u011f]/g, 'ğ') // ğ -> ğ
    .replace(/[\u00dc]/g, 'u') // Ü -> ü
    .replace(/[\u00fc]/g, 'ü') // ü -> ü
    .replace(/[\u015e]/g, 's') // Ş -> ş
    .replace(/[\u015f]/g, 'ş') // ş -> ş
    .toLowerCase();
}
</script>

<template>
  <div class="flex flex-center">
    <q-list style="max-width: 500px">
      <q-btn icon="event" round color="primary">
        <q-popup-proxy
          @before-show="updateJourneyDate"
          cover
          transition-show="scale"
          transition-hide="scale"
        >
          <q-date
            v-model="departureDate"
            mask="DD-MM-YYYY"
            :subtitle="departureDate"
            title="Tarih Seçiniz"
            years-in-month-view
            :max="departureDateLimit"
            today-btn
            :options="dateOptions"
            no-unset
          >
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

            <q-btn label="Cancel" color="primary" flat v-close-popup />
            <q-btn
              label="OK"
              color="primary"
              flat
              @click="saveDate"
              v-close-popup
            />
          </q-date>
        </q-popup-proxy>
      </q-btn>
    </q-list>

    <br />

    <div>
      <b>departureDate:</b> {{ departureDate }}<br />
      <b>departureDateLimit:</b> {{ departureDateLimit }}<br />
    </div>
  </div>
</template>

<style scoped>
.q-pa-md {
  max-width: 400px;
  margin: auto;
}
</style>
