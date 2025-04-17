import { defineStore } from 'pinia';

import { IAsset } from 'src/types/IAsset';

export const useStoreAssetTypes = defineStore({
  id: 'assetTypes',
  state: () => ({
    // BOŞ olarak tanımlamak için:
    // assetTypes: [] as IAsset[],
    emptyAsset: {
      id: -1,
      name: '',
      value: '',
      currency: 'TL',
    } as IAsset,

    // DOLU olarak tanımlamak için:
    assetTypes: [
      { id: 0, name: 'Dolar', value: '32.54', currency: 'TL' },
      { id: 1, name: 'Çeyrek Altın', value: '4523', currency: 'TL' },
      { id: 2, name: 'Gram Altın', value: '2506', currency: 'TL' },
      { id: 3, name: '22 Ayar Bilezik', value: '2203', currency: 'TL' },
      { id: 4, name: 'Nakit', value: '1', currency: 'TL' },
    ] as IAsset[],
  }),

  actions: {
    getAssets(): IAsset[] {
      return this.assetTypes;
    },
    addAsset(newAsset: IAsset) {
      this.assetTypes.push(newAsset);
    },
    removeAsset(index: number) {
      this.assetTypes.splice(index, 1);
    },
    updateAsset(updatedAsset: IAsset) {
      this.assetTypes[updatedAsset.id] = updatedAsset;
    },
  },
});
