<template>
  <q-list>
    <q-item>
      <q-item-section class="col-6">
        <q-input
          readonly
          class="q-mb-md"
          label="Kalkış Tarihi"
          v-model="myDate"
          filled
          type="text"
          :rules="[dateValidator]"
        >
          <template v-slot:before>
            <q-icon name="calendar_month" color="pink" />
          </template>
        </q-input>
      </q-item-section>

      <q-item-section class="col-3">
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
      </q-item-section>
      <q-item-section class="col-3"></q-item-section>
    </q-item>

    <q-item>
      <q-date
        ref="journeyDatePickerRef"
        class="q-mb-md"
        v-model="myDate"
        subtitle="Seyahat Tarihi"
        title="Tarih Seçiniz"
        :navigation-min-year-month="minYearMonth"
        :navigation-max-year-month="maxYearMonth"
        :options="dateOptionsFn"
        :events="holidaysFn"
        :event-color="eventsColor"
      />
      myDateLimit: {{ myDateLimit }} minYearMonth: {{ minYearMonth }}
    </q-item>
    <q-item v-if="holidayName">
      <q-banner rounded class="bg-orange text-black">
        {{ holidayName }}
      </q-banner>
    </q-item>
  </q-list>
</template>

<script setup lang="ts">
import { ref, watchEffect } from 'vue';
import { date } from 'quasar';

let todaysDate = new Date();

// myDate'in tarih formatını güncelleyin
const myDate = ref(date.formatDate(todaysDate, 'YYYY/MM/DD'));

const MAX_SELECTABLE_DAY = 500;

const myDateLimit = date.addToDate(todaysDate, { days: MAX_SELECTABLE_DAY });

const minYearMonth = date.formatDate(todaysDate, 'YYYY/MM');
const maxYearMonth = date.formatDate(myDateLimit, 'YYYY/MM');

// Takvimden seçilebilecek tarihler için sınır belirleme
const dateOptionsFn = (date: string) => {
  const currentDate = new Date(date);
  return currentDate <= myDateLimit && currentDate >= todaysDate;
};

// Tarih doğrulama fonksiyonu
function dateValidator(val: string) {
  const yearPattern = '(19|20)\\d\\d'; // 1900-2099 arası yıllar
  const monthPattern = '(0[1-9]|1[0-2])'; // 01-12 arası aylar
  const dayPattern = '(0[1-9]|[12][0-9]|3[01])'; // 01-31 arası günler
  const datePattern = `^${yearPattern}\\/${monthPattern}\\/${dayPattern}$`; // yyyy/aa/gg formatı

  const regex = new RegExp(datePattern);
  return regex.test(val) || 'Geçerli bir tarih girin (yyyy/aa/gg)';
}

// TAKVİMDE NAVİGASYON
// TAKVİMDE NAVİGASYON
const setToday = () => {
  myDate.value = date.formatDate(new Date(), 'YYYY/MM/DD');
};

const setTomorrow = () => {
  let tmpDate = date.addToDate(new Date(), {
    days: 1,
  });
  myDate.value = date.formatDate(tmpDate, 'YYYY/MM/DD');
};

// TATİL GÜNLERİ AYARLARI
// TATİL GÜNLERİ AYARLARI
const holidayName = ref('');
const holidays: Record<string, string> = {
  '2024/01/01': 'Yılbaşı',
  '2024/04/23': 'Ulusal Egemenlik ve Çocuk Bayramı',
  '2024/05/01': 'Emek ve Dayanışma Günü',
  '2024/05/19': 'Atatürkü Anma, Gençlik ve Spor Bayramı',
  '2024/07/15': 'Demokrasi ve Milli Birlik Günü',
  '2024/08/30': 'Zafer Bayramı',
  '2024/10/29': 'Cumhuriyet Bayramı',
};

function isHoliday(dateString: string) {
  return holidays.hasOwnProperty(dateString);
}

const holidaysFn = (date: string): boolean => {
  return isHoliday(date);
};

const eventsColor = (dateString: string) => {
  return isHoliday(dateString) ? 'pink' : '';
};

function getHolidayName(dateString: string) {
  return holidays[dateString] || ''; // Verilen tarihe karşılık gelen tatil ismini veya boş string döndürür
}

watchEffect(() => {
  holidayName.value = getHolidayName(myDate.value);
});
</script>
