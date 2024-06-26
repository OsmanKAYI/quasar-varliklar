<template>
  <div class="flex flex-center">
    <q-list style="max-width: 500px">
      <q-item class="col-12">
        <q-item-section>
          <SelectStation
            label="Nereden"
            icon-name="place"
            icon-color="green"
            :options="getItemsFrom"
            v-model="stationFrom"
            @input="handleSelection"
          />
        </q-item-section>
      </q-item>

      <q-item class="col-12">
        <q-item-section>
          <SelectStation
            label="Nereye"
            icon-name="place"
            icon-color="black"
            :options="getItemsTo"
            v-model="stationTo"
          />
        </q-item-section>
      </q-item>
    </q-list>

    <br />
    <div>
      <b>stationFrom:</b> {{ stationFrom }}<br />
      <b>stationTo:</b> {{ stationTo }} <br />
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import SelectStation from 'src/components/SelectStation.vue';

interface Station {
  id: string;
  name: string;
  targets: number[];
}

interface StationItem {
  id: string;
  name: string;
}

const allStations: Station[] = [
  { id: '9', name: 'ANKARA AŞTİ', targets: [3, 25, 12, 19, 11] },
  { id: '2', name: 'İSTANBUL( AVRUPA )', targets: [25, 12, 19, 11] },
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

const getItemsFrom = computed<StationItem[]>(() => {
  return allStations.map((station) => ({
    id: station.id,
    name: station.name,
  }));
});

const stationFrom = ref<StationItem | null>(null);
const stationTo = ref<StationItem | null>(null);
// stationFrom.value = getItemsFrom.value[0] || null;

import { watchEffect } from 'vue';

watchEffect(() => {
  if (stationFrom.value) {
    stationTo.value = null;
  }
});

/*
watchEffect(() => {
  stationTo.value = null;
});

watchEffect(() => {
  if (!stationFrom.value) {
    stationTo.value = null;
  }
});
*/
const getItemsTo = computed<StationItem[]>(() => {
  // Eğer stationFrom seçildiyse devam et
  if (stationFrom.value) {
    // Seçilen istasyonun id ve name bilgilerini al
    const fromId = stationFrom.value.id;
    const fromName = stationFrom.value.name;

    // Seçilen istasyonu allStations dizisinden bul
    const fromStation = allStations.find(
      (station) => station.id === fromId && station.name === fromName
    );

    // Eğer istasyon bulunduysa devam et
    if (fromStation) {
      // Seçilen istasyonun targets dizisindeki her bir id için
      return fromStation.targets
        .map((targetId) => {
          // id'ye göre allStations dizisinde istasyonu bul
          const targetStation = allStations.find(
            (station) => station.id === String(targetId)
          );
          // Eğer istasyon bulunduysa id ve name bilgileriyle birlikte diziye ekle
          return targetStation
            ? { id: targetStation.id, name: targetStation.name }
            : null;
        })
        .filter(Boolean) as StationItem[]; // null değerleri filtrele
    }
  }
  // Eğer stationFrom seçilmemişse boş bir dizi döndür
  return [];
});

/*
const getItemsTo = computed<StationItem[]>(() => {
  if (stationFrom.value) {
    const targets = stationFrom.value.targets;
    return allStations
      .filter((station) => targets.includes(Number(station.id)))
      .map((station) => ({
        id: station.id,
        name: station.name,
      }));
  }
  return [];
});
*/

const handleSelection = (value: string | null) => {
  // Handle selection
  console.log('Handle selection', value);
  stationTo.value = null;
};
</script>

<style scoped>
.q-pa-md {
  max-width: 400px;
  margin: auto;
}
</style>
