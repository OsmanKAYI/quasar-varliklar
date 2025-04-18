<template>
  <q-layout view="hHh lpR fFf" class="q-ma-none bg-white">
    <q-header elevated>
      <q-toolbar>
        <q-avatar>
          <img src="/logos/OzlemLogo_64x64.svg" />
        </q-avatar>
        <q-toolbar-title>{{ myProps.propTitle }}</q-toolbar-title>
        <q-btn flat round dense icon="close" size="lg" v-close-popup />
      </q-toolbar>
      <div class="hidden q-ma-none q-pa-sm bg-white text-black">
        Sayfa üst mesajı
      </div>
    </q-header>

    <q-page-container>
      <q-page class="flex justify-around">
        <div style="max-width: max-content">
          <q-date
            v-touch-swipe.mouse.left.right="handleSwipe"
            class="custom-date q-mt-sm q-mb-xl full-width full-height no-shadow"
            v-model="selectedDate"
            ref="refSelectedDate"
            @navigation="onCalenderNavigation"
            :events="holidaysFn"
            :event-color="eventsColor"
            XXminimal
            no-unset
            :subtitle="subtitleMessage"
            :title="formatDateCustom"
          >
            <div class="row q-col-gutter-xs">
              <div class="col-12">
                <q-btn
                  @click="handleSelect"
                  v-close-popup="closePopup"
                  no-caps
                  color="primary"
                  class="full-width"
                  size="lg"
                  style="font-size: 1.5rem !important"
                  outline
                  no-wrap
                  icon-right="send"
                  label="Devam Et"
                />
              </div>

              <div class="col-6">
                <q-btn
                  no-caps
                  size="md"
                  color="primary"
                  @click="prevMonth"
                  class="full-width"
                  outline
                  no-wrap
                  icon="skip_previous"
                  label="Önceki Ay"
                />
              </div>
              <div class="col-6">
                <q-btn
                  no-caps
                  size="md"
                  color="primary"
                  @click="nextMonth"
                  class="full-width"
                  outline
                  no-wrap
                  icon-right="skip_next"
                  label="Sonraki Ay"
                />
              </div>
              <div class="col-6">
                <q-btn
                  no-caps
                  size="md"
                  color="positive"
                  @click="setToday"
                  class="full-width"
                  outline
                  no-wrap
                  >Bugün</q-btn
                >
              </div>
              <div class="col-6">
                <q-btn
                  no-caps
                  size="md"
                  color="primary"
                  @click="setTomorrow"
                  class="full-width"
                  outline
                  no-wrap
                  >Yarın</q-btn
                >
              </div>
            </div>
          </q-date>
          <p v-for="i in 0" :key="i">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Excepturi
            maiores vitae rem eaque aperiam ipsam minima esse provident aut,
            maxime cum beatae voluptates harum sint dolorem error reiciendis ad
            eum.
          </p>
        </div>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { onMounted, ref, computed, watchEffect } from 'vue';
import { date as qDateUtils } from 'quasar';
import { QDate } from 'quasar';

const refSelectedDate = ref<QDate | null>(null);
const selectedDate = ref<string>('');

const todaysDate = computed<string>(() => {
  return qDateUtils.formatDate(Date.now(), 'YYYY/MM/DD');
});

const formatDateCustom = computed<string>(() => {
  // Tarih nesnesi oluşturma
  const dateObj = new Date(selectedDate.value);

  let day: string | number = dateObj.getDate();
  // Tek haneli gün ve ayları iki haneli hale getirme
  day = day < 10 ? `0${day}` : day;

  let month = dateObj
    .toLocaleString('tr-TR', { month: 'short' })
    .substring(0, 3);

  let year = dateObj.getFullYear();

  let weekday = dateObj
    .toLocaleString('tr-TR', { weekday: 'short' })
    .substring(0, 3);

  // Biçimlendirilmiş tarih döndürme
  return `${day} ${month} ${year}, ${weekday}`;
});

const takvimAy = ref<number>(0);
const takvimYil = ref<number>(0);
const subtitleMessage = ref<string>('');

selectedDate.value = todaysDate.value;

onMounted(() => {
  selectedDate.value = modelSelectedDate.value || '';
  updateYilAndAy();
});

const updateYilAndAy = () => {
  takvimAy.value = parseInt(qDateUtils.formatDate(selectedDate.value, 'M'));
  takvimYil.value = parseInt(qDateUtils.formatDate(selectedDate.value, 'YYYY'));
};

const setToday = () => {
  selectedDate.value = todaysDate.value;
  updateYilAndAy();
  updateDatePicker();
};

const setTomorrow = () => {
  let tmpDate = qDateUtils.addToDate(todaysDate.value, {
    days: 1,
  });
  selectedDate.value = qDateUtils.formatDate(tmpDate, 'YYYY/MM/DD');
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

/*
const setToSpecificDate = () => {
  if (refSelectedDate.value) {
    refSelectedDate.value.setCalendarTo(2028, 7);
  }
};
*/

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

const closePopup = ref(false); // Tıklama ile kapatılacak düğmede: v-close-popup="closePopup" yazılmalıdır.

const handleSelect = () => {
  modelSelectedDate.value = selectedDate.value;
  closePopup.value = true;
};

// TATİL GÜNLERİ AYARLARI
// TATİL GÜNLERİ AYARLARI
const holidayName = ref('');
const holidays: Record<string, string> = {
  '2024/01/01': 'Yılbaşı',
  '2024/04/09': 'Ramazan Bayramı (Arefe)',
  '2024/04/10': 'Ramazan Bayramı (1. Gün)',
  '2024/04/11': 'Ramazan Bayramı (2. Gün)',
  '2024/04/12': 'Ramazan Bayramı (3. Gün)',
  '2024/04/23': 'Ulusal Egemenlik ve Çocuk Bayramı',
  '2024/05/01': 'Emek ve Dayanışma Günü',
  '2024/05/19': 'Atatürkü Anma, Gençlik ve Spor Bayramı',
  '2024/06/15': 'Kurban Bayramı (Arefe)',
  '2024/06/16': 'Kurban Bayramı (1. Gün)',
  '2024/06/17': 'Kurban Bayramı (2. Gün)',
  '2024/06/18': 'Kurban Bayramı (3. Gün)',
  '2024/06/19': 'Kurban Bayramı (4. Gün)',
  '2024/07/15': 'Demokrasi ve Milli Birlik Günü',
  '2024/08/30': 'Zafer Bayramı',
  '2024/10/29': 'Cumhuriyet Bayramı',

  '2025/01/01': 'Yılbaşı',
  '2025/03/29': 'Ramazan Bayramı (Arefe)',
  '2025/03/30': 'Ramazan Bayramı (1. Gün)',
  '2025/03/31': 'Ramazan Bayramı (2. Gün)',
  '2025/04/01': 'Ramazan Bayramı (3. Gün)',
  '2025/04/23': 'Ulusal Egemenlik ve Çocuk Bayramı',
  '2025/05/01': 'Emek ve Dayanışma Günü',
  '2025/05/19': 'Atatürkü Anma, Gençlik ve Spor Bayramı',
  '2025/06/05': 'Kurban Bayramı (Arefe)',
  '2025/06/06': 'Kurban Bayramı (1. Gün)',
  '2025/06/07': 'Kurban Bayramı (2. Gün)',
  '2025/06/08': 'Kurban Bayramı (3. Gün)',
  '2025/06/09': 'Kurban Bayramı (4. Gün)',
  '2025/07/15': 'Demokrasi ve Milli Birlik Günü',
  '2025/08/30': 'Zafer Bayramı',
  '2025/10/29': 'Cumhuriyet Bayramı',

  '2026/01/01': 'Yılbaşı',
  '2026/03/19': 'Ramazan Bayramı (Arefe)',
  '2026/03/20': 'Ramazan Bayramı (1. Gün)',
  '2026/03/21': 'Ramazan Bayramı (2. Gün)',
  '2026/03/22': 'Ramazan Bayramı (3. Gün)',
  '2026/04/23': 'Ulusal Egemenlik ve Çocuk Bayramı',
  '2026/05/01': 'Emek ve Dayanışma Günü',
  '2026/05/19': 'Atatürkü Anma, Gençlik ve Spor Bayramı',
  '2026/05/26': 'Kurban Bayramı (Arefe)',
  '2026/05/27': 'Kurban Bayramı (1. Gün)',
  '2026/05/28': 'Kurban Bayramı (2. Gün)',
  '2026/05/29': 'Kurban Bayramı (3. Gün)',
  '2026/05/30': 'Kurban Bayramı (4. Gün)',
  '2026/07/15': 'Demokrasi ve Milli Birlik Günü',
  '2026/08/30': 'Zafer Bayramı',
  '2026/10/29': 'Cumhuriyet Bayramı',
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
  let holidayName = holidays[dateString] || ''; // Verilen tarihe karşılık gelen tatil ismini veya boş string döndürür
  if (holidayName == '') {
    holidayName = 'Seçilen Tarih:';
  } else {
    holidayName = '⭐ ' + holidayName;
  }
  subtitleMessage.value = holidayName;
  return holidayName;
}

watchEffect(() => {
  holidayName.value = getHolidayName(selectedDate.value);
});

// Takvimde sağa ve sola çekme (swipe) işlemleri
interface TouchEvent {
  direction?: 'left' | 'right' | 'up' | 'down';
}

const handleSwipe = (event: TouchEvent) => {
  if (event.direction === 'left') {
    nextMonth();
  } else if (event.direction === 'right') {
    prevMonth();
  }
};

const modelSelectedDate = defineModel<string | null>('modelSelectedDate', {
  required: true,
});

// Props tanımlaması
const myProps = defineProps<{
  propTitle: string;
}>();
</script>

<style lang="scss" scoped>
/* q-date subtitle stilini değiştirmek için */
:deep(.q-date__navigation) {
  /* ay ve yıl'a tıklayınca çalışmasın */
  pointer-events: none;
  .q-date__arrow {
    /* ay ve yıl için okları göstermesin */
    display: none;
  }
}

:deep(.q-date__header-subtitle) {
  /* Subtitle ayarları */
  pointer-events: none;
  font-size: 1rem !important;
  color: white !important;
  opacity: 0.8 !important;
  transition: none !important;
  white-space: nowrap;
}

// Gün Adları
:deep(.q-date__calendar-item) {
  font-size: 1.2rem !important;
  font-weight: 400 !important;
}

// Bugün Günü
:deep(.q-date__today) {
  font-weight: text-weight-light !important;
}

// Takvim Günleri
:deep(.custom-date .q-btn) {
  font-size: 1.4rem !important;
  font-weight: 300 !important;
  width: 3rem;
}

// Takvim Altı Düğmeleri
.custom-date .q-btn {
  font-weight: 400;
  font-size: 1.2rem !important;
}
</style>
