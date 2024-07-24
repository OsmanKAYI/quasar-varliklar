<template>
  <div>
    <q-date
      v-model="selectedDate"
      ref="refSelectedDate"
      @navigation="onCalenderNavigation"
      :events="holidaysFn"
      :event-color="eventsColor"
    >
      <div class="row xxflex-justify-between">
        <div class="col-6">
          <q-btn
            no-caps
            color="primary"
            @click="prevMonth"
            style="width: 110px"
            class="q-mb-sm"
            Xrounded
            outline
            Xdense
            no-wrap
            icon="skip_previous"
            >Önceki Ay</q-btn
          >
        </div>
        <div class="col-6">
          <q-btn
            no-caps
            color="primary"
            @click="nextMonth"
            style="width: 110px"
            class="q-mb-sm"
            Xrounded
            outline
            Xdense
            no-wrap
            icon-right="skip_next"
            >Sonraki Ay</q-btn
          >
        </div>
        <div class="col-6">
          <q-btn
            no-caps
            color="positive"
            @click="setToday"
            style="width: 110px"
            class="q-mb-sm"
            Xrounded
            outline
            Xdense
            no-wrap
            >Bugün</q-btn
          >
        </div>
        <div class="col-6">
          <q-btn
            no-caps
            color="primary"
            @click="setTomorrow"
            style="width: 110px"
            class="q-mb-sm"
            Xrounded
            outline
            Xdense
            no-wrap
            >Yarın</q-btn
          >
        </div>
      </div>
    </q-date>

    <q-item v-if="holidayName">
      <q-banner rounded class="bg-orange text-black">
        {{ holidayName }}
      </q-banner>
    </q-item>

    <pre><b>takvimAy: </b>{{ takvimAy }}</pre>
    <pre><b>takvimYil: </b>{{ takvimYil }}</pre>
    <pre><b>selectedDate: </b>{{ selectedDate }}</pre>
    <pre><b>refSelectedDate: </b>refSelectedDate </pre>
    <p>
      <b>NOT: </b> refSelectedDate içeriğini ekrana yazdırmak şu uyarıyı konsola
      düşürür:<br /><i
        >[Vue warn]: Avoid app logic that relies on enumerating keys on a
        component instance. The keys will be empty in production mode to avoid
        performance overhead.</i
      >
    </p>
  </div>
</template>

<script setup lang="ts">
import { onMounted, ref, computed, watchEffect } from 'vue';
import { date } from 'quasar';
import { QDate } from 'quasar';

const refSelectedDate = ref<QDate | null>(null);
const selectedDate = ref<string>('');

const todaysDate = computed<string>(() => {
  return date.formatDate(Date.now(), 'YYYY/MM/DD');
});

const takvimAy = ref<number>(0);
const takvimYil = ref<number>(0);

selectedDate.value = todaysDate.value;

onMounted(() => {
  updateYilAndAy();
});

const updateYilAndAy = () => {
  takvimAy.value = parseInt(date.formatDate(selectedDate.value, 'M'));
  takvimYil.value = parseInt(date.formatDate(selectedDate.value, 'YYYY'));
};

const setToday = () => {
  selectedDate.value = todaysDate.value;
  updateYilAndAy();
  updateDatePicker();
};

const setTomorrow = () => {
  let tmpDate = date.addToDate(todaysDate.value, {
    days: 1,
  });
  selectedDate.value = date.formatDate(tmpDate, 'YYYY/MM/DD');
  updateYilAndAy();
  updateDatePicker();
};

const nextMonth = () => {
  takvimAy.value++;
  if (takvimAy.value > 12) {
    takvimAy.value = 1;
    takvimYil.value++;
  }
  updateDatePicker();
};

const prevMonth = () => {
  takvimAy.value--;
  if (takvimAy.value == 0) {
    takvimAy.value = 12;
    takvimYil.value--;
  }
  updateDatePicker();
};

const setToSpecificDate = () => {
  if (refSelectedDate.value) {
    refSelectedDate.value.setCalendarTo(2028, 7);
  }
};

const updateDatePicker = () => {
  if (refSelectedDate.value) {
    refSelectedDate.value.setCalendarTo(takvimYil.value, takvimAy.value);
  }
};

interface CalendarView {
  month: number;
  year: number;
}

const onCalenderNavigation = (view: CalendarView) => {
  takvimAy.value = view.month;
  takvimYil.value = view.year;
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
  holidayName.value = getHolidayName(selectedDate.value);
});
</script>

<style xscoped>
.q-date__navigation {
  display: nonex;
}
</style>
