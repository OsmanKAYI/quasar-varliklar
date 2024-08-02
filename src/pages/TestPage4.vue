<template>
  <q-layout view="hHh lpR fFf" class="q-ma-none bg-white">
    <q-header class="bg-primary text-white shadow-3">
      <q-toolbar>
        <q-avatar>
          <img src="/logos/OzlemLogo_64x64.svg" />
        </q-avatar>
        <q-toolbar-title>Bineceğiniz yer?</q-toolbar-title>
        <q-btn flat round dense icon="close" size="lg" v-close-popup />
      </q-toolbar>

      <div class="q-pa-sm q-ma-none text-black bg-white">
        <!-- ################## Input Filter ##################### -->
        <q-input
          v-model="myFilter"
          type="search"
          filled
          outlined
          debounce="0"
          placeholder="Arayınız..."
          clearable
          :class="{ 'big-text': myFilter }"
          style="min-width: 80%"
          ref="quasarSearchInput"
        >
          <template v-slot:prepend>
            <q-icon name="search" size="lg" color="primary" />
          </template>
        </q-input>
      </div>
    </q-header>
    <!-- /header -->

    <!-- ################## Filtered Items ##################### -->
    <q-page-container>
      <q-page>
        <q-card
          class="q-pa-none q-ma-none q-mb-lg no-shadow"
          v-if="filteredOptions.length == 0"
        >
          <q-card-section class="text-center">
            <q-icon
              name="search"
              color="negative"
              style="font-size: 150px; opacity: 0.5"
            />
            <div class="text-h6">Aradığınız yer bulunamadı</div>
          </q-card-section>
        </q-card>

        <q-list separator class="q-ma-sm">
          <q-item
            v-for="item in filteredOptions"
            :key="item"
            clickable
            v-ripple
            @click="handleSelect(item)"
            v-close-popup
          >
            <q-item-section side>
              <q-icon name="place" color="primary" size="md" rounded />
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-grey-10 text-weight-medium text-h6"
                >Durak Adı {{ item }}</q-item-label
              >
              <q-item-label class="text-grey-8"
                >{{ item }} için şehir adı</q-item-label
              >
            </q-item-section>
          </q-item>
        </q-list>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

const myFilter = ref<string | null>(null);
// const myOptions = ref([...Array(100).keys()]); // Örnek öğeler
const myOptions = ref([
  'Option 1',
  'Option 2',
  'Option 3',
  'Option 4',
  'Option 5',
  'Option 6',
  'Option 7',
  'Option 8',
  'Option 9',
  'Option 10',
  'Option 11',
  'Option 12',
  'Option 13',
  'Option 14',
  'Option 15',
  'Option 16',
  'Option 17',
  'Option 18',
  'Option 19',
  'Option 20',
]);

const filteredOptions = computed(() => {
  const filter = myFilter.value;
  const options = myOptions.value;

  if (!filter || filter == null) return options;

  return options.filter((option) =>
    option.toLowerCase().includes(filter.toLowerCase())
  );
});

const handleSelect = (option: string) => {
  stationInfo.value = option;
  console.log(option);
};

const stationInfo = defineModel<string | null>('stationInfo', {
  type: String,
  default: null,
});

const quasarSearchInput = ref(null);
</script>

<style scoped>
.big-text {
  font-size: 25px;
}
</style>
