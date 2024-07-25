<template>
  <q-dialog
    v-model="var1"
    maximized
    transition-show="slide-down"
    transition-hide="slide-up"
    transition-duration="150"
  >
    <TestPage1 v-model:stationInfo="stationFrom"></TestPage1>
  </q-dialog>

  <q-dialog
    v-model="var2"
    maximized
    transition-show="slide-down"
    transition-hide="slide-up"
    transition-duration="150"
  >
    <TestPage2 v-model:stationInfo="stationTo"></TestPage2>
  </q-dialog>

  <q-dialog
    v-model="var3"
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
        class="bg-teal text-center q-my-sm text-white"
        @click="var1 = !var1"
      >
        <q-card-section>
          <div class="text-subtitle1 text-white">Nereden?</div>
        </q-card-section>

        <q-card-section>
          <q-item-label class="text-h5 text-white" lines="2">{{
            stationFrom
          }}</q-item-label>
        </q-card-section>
      </q-card>

      <q-card
        class="bg-primary text-center q-my-sm text-white"
        @click="var2 = !var2"
      >
        <q-card-section>
          <div class="text-subtitle1 text-white">Nereye?</div>
        </q-card-section>

        <q-card-section>
          <div class="text-h5 text-white" lines="1">{{ stationTo }}</div>
        </q-card-section>
      </q-card>

      <q-card
        class="bg-secondary text-white text-center q-my-sm"
        @click="var3 = !var3"
      >
        <q-item>
          <q-item-section>
            <q-item-label><b>Tarih?</b></q-item-label>
          </q-item-section>
        </q-item>
        <q-item>
          <q-item-section>
            <q-item-label class="text-h5">{{ journeyDate }}</q-item-label>
          </q-item-section>
        </q-item>
      </q-card>

      <div>
        <q-btn
          size="lg"
          color="primary"
          label="SEFER BUL"
          class="inline-block"
        />
      </div>
    </q-list>
  </q-page>
</template>

<style scoped>
.q-pa-md {
  max-width: 400px;
  margin: auto;
}
</style>

<script setup lang="ts">
import { ref } from 'vue';
import TestPage1 from 'pages/TestPage1.vue';
import TestPage2 from 'pages/TestPage2.vue';
import TestPage3 from 'pages/TestPage3.vue';

const var1 = ref(false);
const var2 = ref(false);
const var3 = ref(false);
const stationFrom = ref<string | null>(null);
const stationTo = ref<string | null>(null);
const journeyDate = ref<string | null>(null);

stationFrom.value = 'Ankara';
stationTo.value = 'Çankırı';
journeyDate.value = '2024/06/24';
</script>
