<template>
  <q-select
    :label="label"
    v-model="myModel"
    :options="filteredOptions"
    use-input
    @filter="filterItems"
    filled
    map-options
    option-value="id"
    option-label="name"
    input-debounce="0"
    XXemit-value
    XXclearable
    behavior="default"
  >
    <template v-slot:before>
      <q-icon :name="iconName" :color="iconColor" />
    </template>
    <template v-slot:no-option>
      <q-item>
        <q-item-section class="text-italic text-grey">
          Lütfen seçim yapınız
        </q-item-section>
      </q-item>
    </template>
  </q-select>
  myModel: {{ myModel }}
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';

const myModel = defineModel({
  type: String,
  required: true,
});

const myProps = defineProps({
  label: {
    type: String,
    required: true,
  },
  iconName: {
    type: String,
    default: 'place',
  },
  iconColor: {
    type: String,
    default: 'pink',
  },
  options: {
    type: Array,
    required: true,
  },
});

const filterText = ref('');

const filteredOptions = computed(() => {
  const needle = turkishToLower(filterText.value);
  return myProps.options.filter((item) =>
    turkishToLower(item.name).includes(needle)
  );
});

function filterItems(val: string, update: any) {
  update(() => {
    filterText.value = val;
  });
}

function turkishToLower(str: string): string {
  return str
    .replace(/İ/g, 'i')
    .replace(/I/g, 'ı')
    .replace(/Ğ/g, 'ğ')
    .replace(/Ü/g, 'ü')
    .replace(/Ş/g, 'ş')
    .toLowerCase();
}
</script>
