<template>
  <div class="bg-white">
    <div>
      <q-toolbar class="bg-primary text-white">
        <q-avatar>
          <img src="/logos/OzlemLogo_64x64.svg" />
        </q-avatar>
        <q-toolbar-title>Bineceğiniz yer?</q-toolbar-title>
        <q-btn flat round dense icon="close" size="lg" v-close-popup />
      </q-toolbar>

      <q-card>
        <!-- ################## Input Filter ##################### -->
        <q-card-section class="q-px-md q-ma-none">
          <q-input
            v-model="myFilter"
            type="search"
            filled
            outlined
            debounce="0"
            placeholder="Arayınız..."
            clearable
            :class="{ 'big-text': myFilter }"
            ref="quasarSearchInput"
          >
            <template v-slot:prepend>
              <q-icon name="search" size="lg" color="primary" />
            </template>
          </q-input>
        </q-card-section>
      </q-card>
    </div>
    <!-- /header -->

    <!-- ################## Filtered Items ##################### -->

    <q-card class="q-pa-none q-ma-none" :bordered="false">
      <q-card-section v-if="filteredOptions.length == 0" class="text-center">
        <q-icon
          name="search"
          color="negative"
          style="font-size: 150px; opacity: 0.5"
        />
        <div class="text-h6">Aradığınız yer bulunamadı</div>
      </q-card-section>

      <q-virtual-scroll
        type="list"
        :style="{ maxHeight: `calc(100vh - 170px)` }"
        :items="filteredOptions"
        :item-size="filteredOptions.length"
        separator
        v-slot="{ item }"
        :virtual-scroll-slice-size="100"
        :virtual-scroll-item-size="100"
        v-if="filteredOptions.length > 0"
      >
        <q-item
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
      </q-virtual-scroll>
    </q-card>
  </div>
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
