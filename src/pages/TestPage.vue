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
    <TestPage3
      v-model:modelSelectedDate="journeyDate"
      propTitle="Seyahat Tarihiniz?"
    ></TestPage3>
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
            journeyFrom?.name
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
            journeyTo?.name
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
import { ref, computed, onMounted, watch } from 'vue';
import TestPage3 from 'pages/TestPage3.vue';
import TestPage4 from 'pages/TestPage4.vue';

const dialogFrom = ref(false);
const dialogTo = ref(false);
const dialogDate = ref(false);

const journeyFrom = ref<IStation | null>(null);
const journeyTo = ref<IStation | null>(null);

// Watcher to update journeyTo whenever journeyFrom changes
watch(journeyFrom, () => {
  journeyTo.value = computedJourneyTo.value;
});

const computedJourneyTo = computed(() => {
  if (!journeyFrom.value || allStations.value.length === 0) {
    return null;
  }
  return (
    allStations.value.find(
      (station) => station.id === journeyFrom.value?.targets[0]
    ) || null
  );
});

const journeyDate = ref<string | null>(null);

journeyDate.value = '2024/06/24';

interface IStation {
  id: number;
  name: string;
  city: string;
  targets: number[];
}

const allStations = ref<IStation[]>([]);

onMounted(async () => {
  const response = await fetch('src/data/duraklar.json');
  if (response.ok) {
    allStations.value = await response.json();

    journeyFrom.value = allStations.value[0];

    journeyTo.value =
      allStations.value.find(
        (station) => station.id == journeyFrom.value?.targets[0]
      ) || null;
  } else {
    console.error('Veriler yüklenemedi:', response.statusText);
  }
});

const filteredStations = computed<IStation[]>(() => {
  if (journeyFrom.value?.id) {
    const filtered = allStations.value.filter((item) => {
      return journeyFrom.value?.targets.includes(item.id);
    });
    return filtered;
  } else {
    return []; // Eğer journeyFrom.value.id yoksa boş dizi döndür
  }
});
</script>
