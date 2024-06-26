<template>
  <q-card class="q-ma-sm">
    <q-toolbar class="bg-primary text-white">
      <q-avatar>
        <img src="/logos/OzlemLogo_64x64.svg" />
      </q-avatar>
      <q-toolbar-title>Bineceğiniz yer?</q-toolbar-title>
      <q-btn flat round dense icon="close" size="lg" v-close-popup />
    </q-toolbar>

    <q-card class="q-pa-none q-ma-none">
      <!-- ################## Input Filter ##################### -->
      <q-card-section class="q-px-md q-ma-none">
        <q-input
          v-model="myFilter"
          filled
          outlined
          debounce="0"
          placeholder="Bulmak için buraya yazabilirsiniz"
          clearable
          :style="`font-size: ${fontSize}px`"
        >
          <template v-slot:prepend>
            <q-icon name="location_on" size="md" color="primary" />
          </template>
        </q-input>
      </q-card-section>
    </q-card>

    <!-- ################## Filtered Items ##################### -->
    <q-card class="q-pa-none q-ma-none">
      <q-card-section v-if="filteredOptions.length == 0">
        <div class="text-h6">Aradığınız yer bulunamadı</div>
      </q-card-section>

      <q-scroll-area
        :visible="false"
        :style="{ height: scrollHeight + 'px' }"
        v-if="filteredOptions.length > 0"
      >
        <q-card-section>
          <q-list bordered separator>
            <q-item
              v-for="option in filteredOptions"
              :key="option"
              clickable
              v-ripple
            >
              <q-item-section side>
                <q-icon name="place" color="primary" size="md" rounded />
              </q-item-section>
              <q-item-section @click="handleSelect(option)" v-close-popup>
                <q-item-label>{{ option }}</q-item-label>
                <q-item-label caption>{{ option }} için şehir adı</q-item-label>
              </q-item-section>
            </q-item>
          </q-list>
        </q-card-section>
      </q-scroll-area>
    </q-card>
  </q-card>
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const myFilter = ref(null);
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

const fontSize = computed(() => {
  if (myFilter.value == null) return 12;
  return myFilter.value.length == 0 ? 12 : 25;
});

const filteredOptions = computed(() => {
  if (!myFilter.value) return myOptions.value;
  return myOptions.value.filter((option) =>
    option.toLowerCase().includes(myFilter.value.toLowerCase())
  );
});

const scrollHeight = ref(0);

const updateScrollHeight = () => {
  scrollHeight.value = 500;
  /*
  const viewportHeight = window.innerHeight;
  const otherElementsHeight = document.querySelector('.q-pa-sm').offsetHeight;
  scrollHeight.value = viewportHeight - otherElementsHeight - 200; // 60 is an arbitrary value for padding/margin
  */
};

onMounted(() => {
  updateScrollHeight();
  window.addEventListener('resize', updateScrollHeight);
});

onBeforeUnmount(() => {
  window.removeEventListener('resize', updateScrollHeight);
});

const handleSelect = (option) => {
  console.log('handleSelect', option);
  stationInfo.value = option;
};
// const stationInfo = ref('boşşş');

const stationInfo = defineModel('stationInfo', { type: String, default: null });
</script>

<style scoped></style>
