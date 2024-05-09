export interface IAsset {
  id: number;
  name: string;
  value: string | number;
  currency: string;
}

export enum EAppEnums {
  //formAction sadece bu değerleri alabilir
  New = 'new',
  Update = 'update',
}
