<template>
  <div class="dialog-content q-ma-none bg-white">
    <q-toolbar class="bg-primary text-white">
      <q-avatar>
        <img src="/logos/OzlemLogo_64x64.svg" />
      </q-avatar>
      <q-toolbar-title>Bineceğiniz yer?</q-toolbar-title>
      <q-btn flat round dense icon="close" size="lg" v-close-popup />
    </q-toolbar>

    <q-card class="first-card q-pa-none q-ma-none q-my-md">
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

    <!-- ################## Filtered Items ##################### -->

    <q-card class="second-card q-pa-none q-ma-none" :bordered="false">
      <q-card-section v-if="filteredOptions.length == 0">
        <div class="text-h6">Aradığınız yer bulunamadı</div>
      </q-card-section>

      <q-card-section>
        <q-list bordered separator>
          <q-item
            v-for="option in filteredOptions"
            :key="option"
            clickable
            v-ripple
            @click="handleSelect(option)"
            v-close-popup
          >
            <q-item-section side>
              <q-icon name="place" color="primary" size="md" rounded />
            </q-item-section>
            <q-item-section>
              <q-item-label>{{ option }}</q-item-label>
              <q-item-label caption>{{ option }} için şehir adı</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
    </q-card>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';

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

const filteredOptions = computed(() => {
  // console.log(quasarSearchInput.value);

  if (!myFilter.value) return myOptions.value;
  return myOptions.value.filter((option) =>
    option.toLowerCase().includes(myFilter.value.toLowerCase())
  );
});

const handleSelect = (option) => {
  stationInfo.value = option;
};

const stationInfo = defineModel('stationInfo', { type: String, default: null });

const quasarSearchInput = ref(null);
</script>

<style scoped>
.big-text {
  font-size: 25px;
}

.dialog-content {
  display: flex;
  flex-direction: column;
  height: 100%; /* Bütün pencere yüksekliği */
}

.first-card {
  position: sticky;
  top: 0;
  z-index: 1;
  background-color: white; /* İstenirse arka plan rengi */
  margin-bottom: 10px; /* İhtiyaca bağlı olarak ayarlanabilir */
}

.second-card {
  flex: 1; /* Tüm alanı kaplasın */
  overflow-y: auto; /* İçeriği fazla olursa scrollbar göster */
  padding-bottom: 100px;
}
</style>
