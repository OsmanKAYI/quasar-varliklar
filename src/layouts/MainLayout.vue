<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="toggleLeftDrawer"
        />

        <q-toolbar-title>
          Quasar ile Varlık Hesabı v{{ $q.version }}</q-toolbar-title
        >
        <q-space />

        <q-btn
          flat
          dense
          rounded
          @click="$q.fullscreen.toggle()"
          :icon="$q.fullscreen.isActive ? 'fullscreen_exit' : 'fullscreen'"
          :xlabel="$q.fullscreen.isActive ? 'TamEkran:Kapat' : 'TamEkran:Aç'"
          :no-caps="true"
          class="q-mr-sm"
        />

        <q-btn
          flat
          dense
          rounded
          @click="$q.dark.toggle()"
          :icon="$q.dark.isActive ? 'light_mode' : 'dark_mode'"
          :xlabel="$q.fullscreen.isActive ? 'Dark' : 'Light'"
          class="q-mr-sm"
        />

        <template v-for="item in topMenuItems" :key="item.title">
          <q-separator dark vertical />

          <q-btn-dropdown stretch no-caps glossy flat :label="item.page_name">
            <q-list>
              <q-item
                v-for="subItem in item.sub_menu"
                :key="`x.${subItem.page_slug}`"
                clickable
                outline
                v-close-popup
                tabindex="0"
                bordered
                :to="'/page/' + item.page_slug"
              >
                <q-item-section>
                  <q-item-label>
                    <q-icon name="chevron_right" color="dark" size="md" />
                    {{ subItem.page_name }}</q-item-label
                  >
                </q-item-section>
              </q-item>
            </q-list>
          </q-btn-dropdown>
        </template>

        <q-separator dark vertical />
        <q-btn
          flat
          round
          dense
          icon="apps"
          size="lg"
          class="q-mr-xs"
          @click="showMenu = !showMenu"
        />
      </q-toolbar>
    </q-header>

    <q-drawer v-model="leftDrawerOpen" show-if-above bordered>
      <q-scroll-area class="fit">
        <q-list>
          <q-item-label header>Yapabileceğiniz İşlemler </q-item-label>
          <EssentialLink
            v-for="item in leftDrawerItems"
            :key="item.title"
            v-bind="item"
          />
        </q-list>

        <q-list v-if="pages.length > 0">
          <q-item v-for="page in getParents()" :key="page.id">
            <q-item-section>
              <q-item-label @click="toggleSubMenu(page)" class="cursor-pointer">
                {{ page.page_name }}
              </q-item-label>

              <template v-if="page.showSubMenu">
                <q-item
                  class="cursor-pointer"
                  v-for="subPage in getChildren(page.id)"
                  :key="subPage.id"
                >
                  <q-item-section @click.prevent="navigate(subPage)">
                    &nbsp;&nbsp;{{ subPage.page_name }}
                  </q-item-section>
                </q-item>
              </template>
            </q-item-section>
          </q-item>
        </q-list>
      </q-scroll-area>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import EssentialLink, {
  EssentialLinkProps,
} from 'src/components/EssentialLink.vue';

const leftDrawerItems: EssentialLinkProps[] = [
  {
    title: 'Ana Sayfa',
    caption: 'Ana sayfa',
    icon: 'home',
    link: '/',
  },
  {
    title: 'Tanımlar',
    caption: 'Varlık türleri',
    icon: 'settings',
    link: '/asset-types',
  },
  {
    title: 'Varlıklarım',
    caption: 'Varlıklarım',
    icon: 'work',
    link: '/assets',
  },
];

const leftDrawerOpen = ref(false);
const showMenu = ref(false);

function toggleLeftDrawer() {
  leftDrawerOpen.value = !leftDrawerOpen.value;
}

const topMenuItems = [
  {
    page_name: 'Kurumsal',
    page_slug: 'kurumsal',
    sub_menu: [
      {
        page_name: 'İlkelerimiz',
        page_slug: 'ilkelerimiz',
      },
      {
        page_name: 'Vizyonumuz',
        page_slug: 'vizyonumuz',
      },
      {
        page_name: 'Misyonumuz',
        page_slug: 'misyonumuz',
      },
      {
        page_name: 'Kalite Politikamız',
        page_slug: 'kalite-politikamiz',
      },
      {
        page_name: 'Belgelerimiz',
        page_slug: 'belgelerimiz',
      },
      {
        page_name: 'Filomuz',
        page_slug: 'filomuz',
      },
      {
        page_name: 'Gizlilik Bildirimimiz',
        page_slug: 'gizlilik-bildirimimiz',
      },
      {
        page_name: 'İnsan Kaynakları',
        page_slug: 'insan-kaynaklari',
      },
    ],
  },

  {
    page_name: 'Seyahat',
    page_slug: 'seyahat',
    sub_menu: [
      { page_name: 'Bagaj İşlemleri', page_slug: 'bagaj-islemleri' },
      {
        page_name: 'Yolcu Taşıma Sözleşmesi',
        page_slug: 'yolcu-tasima-sozlesmesi',
      },
      {
        page_name: 'Sıkça Sorulan Sorular',
        page_slug: 'sikca-sorulan-sorular',
      },
      { page_name: 'Neden Özlem Seyahat?', page_slug: 'neden-ozlem-seyahat' },
      { page_name: '444 18 18', page_slug: '444-18-18' },
      { page_name: 'Peronlar', page_slug: 'peronlar' },
      { page_name: 'Zaman Tarifesi', page_slug: 'zaman-tarifesi' },
      { page_name: 'Ücret Tarifesi', page_slug: 'ucret-tarifesi' },
      { page_name: 'Açık Bilet', page_slug: 'acik-bilet' },
    ],
  },

  {
    page_name: 'İletişim',
    page_slug: 'iletisim',
    sub_menu: [
      { page_name: 'Telefonlar / Şubeler', page_slug: 'telefonlar-subeler' },
      { page_name: 'İletişim', page_slug: 'iletisim' },
      { page_name: 'e-Bilet', page_slug: 'e-bilet' },
    ],
  },
];

// MENU
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';
const router = useRouter();

const pages = ref([]);

onMounted(() => {
  fetchPages();
});

async function fetchPages() {
  try {
    const response = await axios.get(
      'http://localhost/quasar/varliklar/public/api/menu.php'
    );
    pages.value = response.data.map((page) => ({
      ...page,
      showSubMenu: false, // Gelen içerikteki her bir elemana "showSubMenu: false" özelliği ekleyelim
    }));
  } catch (error) {
    console.error('Error fetching pages:', error);
  }
}

function toggleSubMenu(page) {
  page.showSubMenu = !page.showSubMenu;
}

function navigate(page) {
  router.push({ path: '/bilgi/' + page.page_slug });
}

function getChildren(parentId) {
  return pages.value.filter((page) => page.parent_id == parentId);
}

function getParents() {
  return pages.value.filter((page) => page.parent_id == 0);
}
</script>
