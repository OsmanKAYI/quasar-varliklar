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
      v-model:stationInfo="journeyTo"
      propTitle="Nerede ineceksiniz?"
      :propOptions="allStations"
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
          <q-item-label class="text-h4 text-white" lines="1">{{
            journeyFrom
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
          <q-item-label class="text-h4 text-white" lines="1">{{
            journeyTo
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
          <q-item-label class="text-h4 text-white" lines="1">{{
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
import { ref } from 'vue';
import TestPage3 from 'pages/TestPage3.vue';
import TestPage4 from 'pages/TestPage4.vue';

const dialogFrom = ref(false);
const dialogTo = ref(false);
const dialogDate = ref(false);

const defaultFrom = {
  id: '1',
  name: 'Ankara',
  targets: [],
};
const defaultTo = {
  id: '2',
  name: 'Çankırı',
  targets: [],
};

const journeyFrom = ref<IStation>(defaultFrom);
const journeyTo = ref<IStation>(defaultTo);
const journeyDate = ref<string | null>(null);

// Değişkenlere ilk değer verilmesi
journeyFrom.value.id = '3';
journeyFrom.value.name = 'ÇANKIRI';
journeyFrom.value.targets = [];

journeyTo.value.id = '9';
journeyTo.value.name = 'ANKARA';
journeyTo.value.targets = [];

journeyDate.value = '2024/06/24';

interface IStation {
  id: string;
  name: string;
  city?: string;
  targets: number[];
}

const allStations: IStation[] = [
  {
    id: '9',
    name: 'ANKARA AŞTİ',
    city: 'Ankara',
    targets: [3, 25, 12, 19, 11],
  },
  {
    id: '2',
    name: 'İSTANBUL( AVRUPA )',
    city: 'Istanbul',
    targets: [25, 12, 19, 11],
  },
  { id: '4', name: 'İSTANBUL( DUDULLU )', targets: [12, 19, 11] },
  { id: '3', name: 'ÇANKIRI OTOGAR', targets: [19, 11] },
  { id: '6', name: 'KASTAMONU OTOGAR', targets: [3, 25, 12, 19, 11] },
  { id: '25', name: 'ALİBEYKÖY', targets: [3, 25, 12, 19, 11] },
  { id: '20', name: 'ARAÇ', targets: [3, 25, 12, 19, 11] },
  { id: '16', name: 'ATKARACALAR', targets: [3, 25, 12, 19, 11] },
  { id: '15', name: 'ÇERKEŞ', targets: [3, 25, 12, 19, 11] },
  { id: '14', name: 'DEVREKANİ', targets: [3, 25, 12, 19, 11] },
  { id: '17', name: 'GEBZE OTOGAR', targets: [3, 25, 12, 19, 11] },
  { id: '24', name: 'GÜZELYALI', targets: [3, 25, 12, 19, 11] },
  { id: '7', name: 'HAREM TERMİNALİ', targets: [3, 25, 12, 19, 11] },
  { id: '12', name: 'ILGAZ DOĞRUYOL', targets: [3, 25, 12, 19, 11] },
  { id: '28', name: 'ILGAZ AKBAK', targets: [3, 25, 12, 19, 11] },
  { id: '27', name: 'ILGAZ KAYAK MERKEZİ', targets: [3, 25, 12, 19, 11] },
  { id: '18', name: 'İZMİT ( KOCAELİ )', targets: [3, 25, 12, 19, 11] },
  { id: '21', name: 'KARABÜK OTOGAR', targets: [3, 25, 12, 19, 11] },
  { id: '46', name: 'SAFRANBOLU', targets: [3, 25, 12, 19, 11] },
  { id: '23', name: 'KAYNARCA', targets: [3, 25, 12, 19, 11] },
  { id: '10', name: 'KORGUN', targets: [3, 25, 12, 19, 11] },
  { id: '5', name: 'KURŞUNLU', targets: [3, 25, 12, 19, 11] },
  { id: '22', name: 'SOĞUKSU IŞIKDAĞI', targets: [3, 25, 12, 19, 11] },
  { id: '26', name: 'OLUKBAŞI', targets: [3, 25, 12, 19, 11] },
  { id: '8', name: 'PURSAKLAR', targets: [3, 25, 12, 19, 11] },
  { id: '19', name: 'SAKARYA ( ADAPAZARI )', targets: [3, 25, 12, 19, 11] },
  { id: '13', name: 'SEYDİLER', targets: [3, 25, 12, 19, 11] },
  { id: '1', name: 'TÜNEY ', targets: [3, 25, 12, 19, 11] },
  { id: '11', name: 'YAMUÇLAR', targets: [3, 25, 12, 19, 11] },
  { id: '29', name: 'İĞDİR', targets: [3, 25, 12, 19, 11] },
  { id: '30', name: 'BOLU', targets: [3, 25, 12, 19, 11] },
  { id: '31', name: 'DÜZCE', targets: [3, 25, 12, 19, 11] },
];
</script>
