<template>
  <div class="q-pa-md">
    <div class="q-gutter-md">
      <h3>{{ myDate }}</h3>
      <q-date
        v-model="myDate"
        no-unset
        :events="holidaysFn"
        :event-color="eventsColor"
      />

      <q-banner rounded class="bg-orange text-black" v-if="holidayName">
        {{ holidayName }}
      </q-banner>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, watchEffect } from 'vue';
const myDate = ref('2024/01/01');
const holidayName = ref('');

function isHoliday(dateString: string) {
  return holidays.hasOwnProperty(dateString);
}

const holidaysFn = (date: string): boolean => {
  return isHoliday(date);
};

const eventsColor = (dateString: string) => {
  return isHoliday(dateString) ? 'orange' : '';
};

function getHolidayName(dateString: string) {
  return holidays[dateString] || ''; // Verilen tarihe karşılık gelen tatil ismini veya 'Tatil değil' mesajını döndürür
}

const holidays: Record<string, string> = {
  '2024/01/01': 'Yılbaşı',
  '2024/01/23': 'Ulusal Egemenlik ve Çocuk Bayramı',
  '2024/01/05': 'Emek ve Dayanışma Günü',
  '2024/01/19': 'Atatürkü Anma, Gençlik ve Spor Bayramı',
  '2024/01/15': 'Demokrasi ve Milli Birlik Günü',
  '2024/01/30': 'Zafer Bayramı',
  '2024/01/29': 'Cumhuriyet Bayramı',
};

watchEffect(() => {
  holidayName.value = getHolidayName(myDate.value);
});
</script>
