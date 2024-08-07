<template>
  <q-dialog
    v-model="dialogFrom"
    maximized
    transition-show="slide-down"
    transition-hide="slide-up"
    transition-duration="150"
  >
    <TestPage4
      v-model:modelStationInfo="journeyFrom"
      propTitle="Nereden bineceksiniz?"
      :propOptions="allStations"
    ></TestPage4>
  </q-dialog>

  <q-dialog
    v-model="dialogTo"
    maximized
    transition-show="slide-down"
    transition-hide="slide-up"
    transition-duration="150"
  >
    <TestPage4
      v-model:modelStationInfo="journeyTo"
      propTitle="Nerede ineceksiniz?"
      :propOptions="filteredStations"
    ></TestPage4>
  </q-dialog>

  <q-dialog
    v-model="dialogDate"
    maximized
    transition-show="slide-down"
    transition-hide="slide-up"
    transition-duration="150"
  >
    <TestPage3 v-model:selectDate="journeyDate"></TestPage3>
  </q-dialog>

  <q-page class="flex flex-center">
    <q-list style="width: 300px">
      <q-card
        class="bg-blue-5 text-center q-my-md text-white q-card--hover"
        @click="dialogFrom = !dialogFrom"
      >
        <q-card-section>
          <q-item-label class="text-white">Nereden?</q-item-label>
        </q-card-section>

        <q-card-section>
          <q-item-label class="text-h6 text-white" lines="2">{{
            journeyFrom.name
          }}</q-item-label>
        </q-card-section>
      </q-card>

      <q-card
        class="bg-blue-7 text-center q-my-md text-white q-card--hover"
        @click="dialogTo = !dialogTo"
      >
        <q-card-section>
          <q-item-label class="text-white">Nereye?</q-item-label>
        </q-card-section>

        <q-card-section>
          <q-item-label class="text-h6 text-white" lines="2">{{
            journeyTo.name
          }}</q-item-label>
        </q-card-section>
      </q-card>

      <q-card
        class="bg-blue-9 text-center q-my-md text-white q-card--hover"
        @click="dialogDate = !dialogDate"
      >
        <q-card-section>
          <q-item-label class="text-white">Tarih?</q-item-label>
        </q-card-section>

        <q-card-section>
          <q-item-label class="text-h6 text-white" lines="1">{{
            journeyDate
          }}</q-item-label>
        </q-card-section>
      </q-card>

      <q-card class="q-card--hover q-my-lg">
        <q-card-section class="q-pa-none">
          <q-btn
            size="xl"
            label="Listele"
            class="full-width bg-blue-10 text-white"
            icon="search"
            no-caps
            stack
          />
        </q-card-section>
      </q-card>
    </q-list>
  </q-page>
</template>

<style scoped>
.q-card--hover:hover {
  cursor: pointer;
  box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.5);
}
</style>

<script setup lang="ts">
import { ref, computed } from 'vue';
import TestPage3 from 'pages/TestPage3.vue';
import TestPage4 from 'pages/TestPage4.vue';

const dialogFrom = ref(false);
const dialogTo = ref(false);
const dialogDate = ref(false);

const defaultFrom = {
  id: 9,
  name: 'Ankara',
  city: 'Ankara',
  targets: [3, 6],
};
const defaultTo = {
  id: 2,
  name: 'Çankırı',
  city: 'Çankırı',
  targets: [3, 6, 1],
};

const journeyFrom = ref<IStation>(defaultFrom);
const journeyTo = ref<IStation>(defaultTo);
const journeyDate = ref<string | null>(null);

journeyDate.value = '2024/06/24';

interface IStation {
  id: number;
  name: string;
  city: string;
  targets: number[];
}

const allStations: IStation[] = [
  { id: 9, name: 'ANKARA AŞTİ', city: 'anKaRa', targets: [3, 25, 12, 19, 11] },
  {
    id: 2,
    name: 'İSTANBUL (AVRUPA)',
    city: 'istanbul',
    targets: [25, 12, 19, 11],
  },
  {
    id: 4,
    name: 'İSTANBUL (DUDULLU)',
    city: 'İSTANBUL',
    targets: [12, 19, 11],
  },
  { id: 3, name: 'ÇANKIRI OTOGAR', city: 'Çankırı', targets: [19, 11] },
  {
    id: 6,
    name: 'KASTAMONU OTOGAR',
    city: 'Kastamonu',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 25, name: 'ALİBEYKÖY', city: 'İstanbul', targets: [3, 25, 12, 19, 11] },
  { id: 20, name: 'ARAÇ', city: 'Kastamonu', targets: [3, 25, 12, 19, 11] },
  {
    id: 16,
    name: 'ATKARACALAR',
    city: 'Kastamonu',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 15, name: 'ÇERKEŞ', city: 'Çankırı', targets: [3, 25, 12, 19, 11] },
  {
    id: 14,
    name: 'DEVREKANİ',
    city: 'Kastamonu',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: 17,
    name: 'GEBZE OTOGAR',
    city: 'Kocaeli',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 24, name: 'GÜZELYALI', city: 'İstanbul', targets: [3, 25, 12, 19, 11] },
  {
    id: 7,
    name: 'HAREM TERMİNALİ',
    city: 'İstanbul',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: 12,
    name: 'ILGAZ DOĞRUYOL',
    city: 'Kastamonu',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: 28,
    name: 'ILGAZ AKBAK',
    city: 'Kastamonu',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: 27,
    name: 'ILGAZ KAYAK MERKEZİ',
    city: 'Kastamonu',
    targets: [3, 25, 12, 9, 6],
  },
  {
    id: 18,
    name: 'İZMİT (KOCAELİ)',
    city: 'Kocaeli',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: 21,
    name: 'KARABÜK OTOGAR',
    city: 'Karabük',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 46, name: 'SAFRANBOLU', city: 'Karabük', targets: [3, 25, 12, 19, 11] },
  { id: 23, name: 'KAYNARCA', city: 'Bolu', targets: [3, 25, 12, 19, 11] },
  { id: 10, name: 'KORGUN', city: 'Çankırı', targets: [3, 25, 12, 19, 11] },
  { id: 5, name: 'KURŞUNLU', city: 'Çankırı', targets: [3, 25, 12, 19, 11] },
  {
    id: 22,
    name: 'SOĞUKSU IŞIKDAĞI',
    city: 'Çankırı',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 26, name: 'OLUKBAŞI', city: 'Bolu', targets: [3, 25, 12, 19, 11] },
  { id: 8, name: 'PURSAKLAR', city: 'Ankara', targets: [3, 25, 12, 19, 11] },
  {
    id: 19,
    name: 'SAKARYA (ADAPAZARI)',
    city: 'Sakarya',
    targets: [3, 25, 12, 19, 11],
  },
  { id: 13, name: 'SEYDİLER', city: 'Çankırı', targets: [3, 25, 12, 19, 11] },
  { id: 1, name: 'TÜNEY', city: 'Ankara', targets: [3, 25, 12, 19, 11] },
  { id: 11, name: 'YAMUÇLAR', city: 'Ankara', targets: [3, 25, 12, 19, 11] },
  { id: 29, name: 'İĞDİR', city: 'Iğdır', targets: [3, 25, 12, 19, 11] },
  { id: 30, name: 'BOLU', city: 'Bolu', targets: [3, 25, 12, 19, 11] },
  { id: 31, name: 'DÜZCE', city: 'Düzce', targets: [3, 25, 12, 19, 11] },
];
const filteredStations = computed<IStation[]>(() => {
  if (journeyFrom.value.id) {
    const filtered = allStations.filter((item) => {
      return journeyFrom.value.targets.includes(item.id);
    });
    return filtered;
  } else {
    return []; // Eğer journeyFrom.value.id yoksa boş dizi döndür
  }
});
</script>
