<template>
  <q-layout view="hHh lpR fFf" class="q-ma-none bg-white">
    <q-header class="bg-primary text-white shadow-3">
      <q-toolbar>
        <q-avatar>
          <img src="/logos/OzlemLogo_64x64.svg" />
        </q-avatar>
        <q-toolbar-title>{{ myProps.propTitle }}</q-toolbar-title>
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
            :key="item.id"
            clickable
            v-ripple
            @click="handleSelect(item)"
            v-close-popup="closePopup"
          >
            <q-item-section side>
              <q-icon
                name="place"
                :color="modelStationInfo.id == item.id ? 'green' : 'primary'"
                size="md"
                rounded
              />
            </q-item-section>
            <q-item-section>
              <q-item-label class="text-grey-10 text-weight-medium text-h6">{{
                titleCase(item.name)
              }}</q-item-label>
              <q-item-label class="text-grey-8">{{
                sentenceCase(item.city)
              }}</q-item-label>
            </q-item-section>
          </q-item>
        </q-list>
      </q-page>
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

const closePopup = ref(false);

const modelStationInfo = defineModel<IStation>('modelStationInfo', {
  default: null,
});

// IStation arayüzü
interface IStation {
  id: number;
  name: string;
  city: string;
  targets: number[];
}

// Props tanımlaması
const myProps = defineProps<{
  propTitle: string;
  propOptions: IStation[];
}>();

// myOptions değişkeni
//const myOptions = ref<IStation[]>([]);
//myOptions.value = myProps.propOptions;

const myFilter = ref<string | null>(null);

const filteredOptions = computed(() => {
  const filterValue = myFilter.value ? turkishToLower(myFilter.value) : '';

  if (filterValue === '') {
    return myProps.propOptions;
  }

  return myProps.propOptions.filter((item) => {
    return (
      turkishToLower(item.name).includes(filterValue) ||
      turkishToLower(item.city).includes(filterValue)
    );
  });
});

function turkishToLower(str: string): string {
  return str
    .replace(/I/g, 'ı')
    .replace(/İ/g, 'i')
    .replace(/Ğ/g, 'ğ')
    .replace(/Ü/g, 'ü')
    .replace(/Ş/g, 'ş')
    .replace(/Ö/g, 'ö')
    .replace(/Ç/g, 'ç')
    .toLowerCase();
}

function turkishToUpper(str: string): string {
  return str
    .replace(/ı/g, 'I')
    .replace(/i/g, 'İ')
    .replace(/ğ/g, 'Ğ')
    .replace(/ü/g, 'Ü')
    .replace(/ş/g, 'Ş')
    .replace(/ö/g, 'Ö')
    .replace(/ç/g, 'Ç')
    .toUpperCase();
}

function sentenceCase(str: string): string {
  let lowerCaseStr = turkishToLower(str);
  return (
    turkishToUpper(lowerCaseStr.charAt(0)) +
    turkishToLower(lowerCaseStr.slice(1))
  );
}

function titleCase(str: string): string {
  // İlk olarak tüm string'i küçük harfe çevir
  const lowerCaseStr = turkishToLower(str);

  // Kelimeleri ayır
  const words = lowerCaseStr.split(' ');

  // Her kelimenin baş harfini büyük yap
  const titleCasedWords = words.map(
    (word) => turkishToUpper(word.charAt(0)) + turkishToLower(word.slice(1))
  );

  // Kelimeleri tekrar birleştir
  return titleCasedWords.join(' ');
}

const handleSelect = (item: IStation) => {
  modelStationInfo.value = item;
  closePopup.value = true;
};
</script>

<style scoped>
.big-text {
  font-size: 25px;
}
</style>
