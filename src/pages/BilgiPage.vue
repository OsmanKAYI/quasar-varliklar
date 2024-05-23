<template>
  <q-page padding>
    <div v-if="pageLoading">Yükleniyor, bekleyiniz...</div>
    <div v-else-if="pageError" style="color: red">
      Hata Oluştu: {{ pageError }}
    </div>
    <div v-else>
      <h3>{{ pageData.page_name }}</h3>
      <pre>{{ pageData.md_content }}</pre>
    </div>
  </q-page>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { watchEffect } from 'vue';
import axios from 'axios';
import { useRoute } from 'vue-router';

const pageData = ref<any>({});
const pageLoading = ref<boolean>(true);
const pageError = ref<string | null>(null);
const route = useRoute();

let timeoutId: ReturnType<typeof setTimeout> | null = null;

watchEffect(async () => {
  const slug = route.params.slug;
  if (slug) {
    await fetchPage(slug);
  }
});

async function fetchPage(pageSlug: string) {
  // Yükleniyor durumunu gecikmeli olarak göstermek için 750ms bekle
  const loadingTicker = setTimeout(function () {
    pageLoading.value = true;
  }, 750);

  pageError.value = null;
  try {
    const response = await axios.get(
      `http://localhost/quasar/varliklar/public/api/menu.php?page_slug=${pageSlug}`
    );
    pageData.value = response.data;
  } catch (error) {
    pageError.value = 'Error fetching data';
    console.error(error);
  } finally {
    // Timeout hala aktifse iptal et ve yükleniyor durumunu güncelle
    clearTimeout(loadingTicker);

    pageLoading.value = false;
  }
}
</script>
