<template>
  <q-page padding>
    <div class="text-h4">Asset Types...</div>

    <q-list dense separator Xbordered padding style="max-width: 800px">
      <q-item-label header>Varlık türünü ve değerini giriniz.</q-item-label>

      <!-- Varlık Düzenleme Formu -->
      <q-form ref="form1" @submit.prevent.stop>
        <q-item>
          <q-item-section class="col-1" top>
            <q-input
              filled
              v-model="newAsset.id"
              label="Kayıt#"
              readonly
              disable
            />
          </q-item-section>
          <q-item-section class="col-5" top>
            <q-input
              filled
              v-model="newAsset.name"
              label="Varlık türü"
              lazy-rules="ondemand"
              :rules="[(val) => (val && val.length > 0) || 'Boş olamaz']"
            />
          </q-item-section>
          <q-item-section class="col-2" top>
            <q-input
              filled
              v-model="newAsset.value"
              label="Değeri"
              lazy-rules="ondemand"
              :rules="[(val) => (val && val.length > 0) || 'Boş olamaz']"
            />
          </q-item-section>
          <q-item-section class="col-2" top>
            <q-input
              filled
              v-model="newAsset.currency"
              label="Döviz Cinsi"
              lazy-rules="ondemand"
              :rules="[(val) => (val && val.length > 0) || 'Boş olamaz']"
            />
          </q-item-section>
          <q-item-section noWrap top>
            <q-btn
              @click="actionSave(EAppEnums.New)"
              size="md"
              color="primary"
              icon="add"
              label="Ekle"
              v-if="isNewItem"
            />
            <q-btn
              @click="actionSave(EAppEnums.Update)"
              size="md"
              color="positive"
              icon="send"
              label="Kaydet"
              v-if="!isNewItem"
            />
          </q-item-section>
        </q-item>
      </q-form>

      <!-- Tablo Üst Başlığı -->
      <q-toolbar class="bg-primary text-white shadow-2 q-my-md" align="center">
        <q-toolbar-title>Kayıtlı Varlık Türleri</q-toolbar-title>
      </q-toolbar>

      <!-- Tablo Başlığı -->
      <q-item class="bg-grey-3 text-black">
        <q-item-section class="col-1">
          <q-item-label> Kayıt# </q-item-label>
        </q-item-section>
        <q-item-section class="col-5">
          <q-item-label> Varlık Türü </q-item-label>
        </q-item-section>
        <q-item-section class="col-2">
          <q-item-label> Varlık Değeri </q-item-label>
        </q-item-section>
        <q-item-section class="col-2">
          <q-item-label> Döviz Türü </q-item-label>
        </q-item-section>
        <q-item-section> İşlem </q-item-section>
      </q-item>

      <!-- Varlık Listesi -->
      <q-item
        clickable
        v-ripple
        dense
        v-for="(assetType, index) in assetTypes"
        :key="assetType.id"
      >
        <q-item-section class="col-1">
          <q-item-label>{{ assetType.id }}</q-item-label>
        </q-item-section>
        <q-item-section class="col-5">
          <q-item-label>{{ assetType.name }}</q-item-label>
        </q-item-section>
        <q-item-section class="col-2">
          <q-item-label>{{ assetType.value }}</q-item-label>
        </q-item-section>
        <q-item-section class="col-2">
          <q-item-label>{{ assetType.currency }}</q-item-label>
        </q-item-section>
        <q-item-section noWrap>
          <div
            class="q-pa-sm q-gutter-md"
            data="Bu class sayesinde satır yüksekliği ayarlanıyor"
          >
            <q-btn
              size="sm"
              round
              color="positive"
              icon="edit"
              @click="actionEdit(assetType)"
            />
            <q-btn
              size="sm"
              round
              color="negative"
              icon="delete"
              @click="actionDelete(assetType, index)"
            />
          </div>
        </q-item-section>
      </q-item>
      <q-btn
        Xsize="md"
        color="primary"
        icon="add"
        label="Yeni Kayıt"
        @click="setNewAsset()"
        v-if="!isNewItem"
      />
    </q-list>
  </q-page>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { IAsset, EAppEnums } from 'src/types/IAsset';
import { useStoreAssetTypes } from 'src/stores/StoreAssetTypes';
import { QForm, useQuasar } from 'quasar';

// pinia store
const store = useStoreAssetTypes(); // Store nesnesini tanımlayalım
const assetTypes = ref<IAsset[]>(store.assetTypes); // Tüm kayıtları getir. Ekrana bunlar listeleniyor
const emptyAsset = ref(store.emptyAsset); // Boş veri seti. newAsset nesnemiz için gerekli

// computed properties
const isNewItem = computed<boolean>(() => newAsset.value.id == -1); // Yeni kayıt kontrolü yapalım
const getCount = computed<number>(() => store.assetTypes.length); // Kayıt sayısını alalım

// variables
const $q = useQuasar(); // Quasar Helper'leri olan $q.notify ve @q.confirm kullanımı için tanımladık
const newAsset = ref<IAsset>({ ...emptyAsset.value }); // Boş veri seti ile newAsset nesnemizi dolduralım

// methodes
const setNewAsset = () => {
  newAsset.value = { ...emptyAsset.value }; // Boş veri seti ile newAsset nesnemizi dolduralım
};

// Form Validation
// ================================
const form1 = ref<QForm>(); // q-form resnesine ref="form1" atamıştık. Form validasyonu için bunu kullanacağız
const isFormValidated = async () => {
  if (form1.value) {
    const isValid = await form1.value.validate(); // form validasyonunu manuel olarak tetikledik
    if (!isValid) {
      // Formun doldurulmaması durumunda validasyon hatası verecektir.
      // Bu hatanın sadece 1 sn ekranda görünüp kaybolmasını sağlayalım
      setTimeout(() => {
        form1.value?.resetValidation();
      }, 1000);
    }
    return isValid; // Validasyon sonucunu döndürelim
  }
  return false; // Eğer, ekranda form yoksa false döndürelim
}; // isFormValidated

// FORM ACTIONS
// ================================
const actionSave = async (formAction: EAppEnums) => {
  // Önce form validasyonu yapalım...
  if (!(await isFormValidated())) {
    return false;
  }

  if (formAction == EAppEnums.New) {
    // YENİ KAYIT
    newAsset.value.id = getCount.value + 1; // Yeni kayıt için ID belirleyelim
    store.addAsset({ ...newAsset.value }); // Store'a kaydedelim

    $q.notify({
      type: 'positive',
      icon: 'check_circle',
      message: 'Kayıt eklendi !',
      position: 'bottom-left',
      timeout: 1000,
      group: false,
    });
  } // yeni kayıt

  if (formAction == EAppEnums.Update) {
    // KAYIT GÜNCELLEME
    store.updateAsset({ ...newAsset.value }); // Store'u güncelleyelim

    $q.notify({
      type: 'positive',
      icon: 'check_circle',
      message: 'Kayıt güncellendi !',
      position: 'bottom-left',
      timeout: 1000,
      group: false,
    });
  } // kayıt güncelleme

  setNewAsset(); // Yeni kayıt için sahaları boşaltalım
}; // actionSave

const actionEdit = (item: IAsset) => {
  // Formda kullandığımız newAsset nesnesini aktif kayı ile dolduralım
  newAsset.value = { ...item };

  $q.notify({
    type: 'positive',
    icon: 'edit',
    message: 'Şimdi güncellemelerinizi yapabilirsiniz',
    position: 'bottom-left',
    timeout: 1000,
    group: false,
  });
}; // actionEdit

const actionDelete = async (item: IAsset, index: number) => {
  $q.dialog({
    title: 'Silmek istediğinize emin misiniz?',
    message: 'Bu kayıt silinecektir.',
    persistent: false,
    position: 'top',
    cancel: {
      push: true,
      color: 'info',
      label: 'Vazgeç',
      noCaps: false,
      icon: 'cancel',
    },
    ok: {
      push: true,
      color: 'negative',
      label: 'Sil',
      noCaps: false,
      icon: 'delete',
    },
  })
    .onOk(() => {
      store.removeAsset(index); // Kayıt silme metodunu çağıralım
      setNewAsset; // Yeni kayıt için sahaları boşaltalım

      $q.notify({
        type: 'positive',
        message: 'Silme başarılı',
        position: 'bottom-left',
        timeout: 1000,
        group: false,
      });
    })
    .onCancel(() => {
      $q.notify({
        type: '',
        color: 'secondary',
        icon: 'info',
        message: 'Vazgeçtiniz...',
        position: 'bottom-left',
        timeout: 1000,
        group: false,
      });
    });
}; // actionDelete
</script>
