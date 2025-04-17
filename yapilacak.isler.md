# Yapılacak İşler

q-select içinde options-cover özelliği güzel!

## "Nereden" Seçimi

- Selectable ile yapılmalı
  - `use-chips` ile seçilen yerin düzgün gösterimi sağlanmalı
  - `Options` tanımında label, value vb. sahalar da olmalı
  - `clearable` düğmesi (x/çarpı) olmalı
  - Masaüstü'nde: `behavior="menu"` olmalı
  - Cep'te: `behavior="dialog"` olmalı
  - `options-slot` ile ana duraklar, ara duraklar ayrı simgelerle gösterilmeli,
  - `options-slot` ile durak adı ve ikinci satırda şehir adı yazmalı
- Liste 10 satır olmalı
- İçinde arama/filtreleme yapılabilmeli
  - Filtreye uygun kayıt varsa ilk seçili gelmeli (Selecting option after filtering)
- Login olmuşsa: İlk 3 satır: Kullanıcının biletlerinden ilk 3 hedef seçilmeli
  - "Önceki biletlerinizden" ara başlığı ile listelenmeli
- İlk 3 satır: En çok gidilen hedefler (global ölçekte)
  - "Çok gidilen yerler" ara başlığıyla
- Sonraki satırlar, alfabetik liste
  - "Gidilebilecek yerler" ara başlığıyla
- Seçim yapılırsa, focus "Nereye" bölümüne gitmeli

## "Nereye" Seçimi

- Veri yoksa "No options slot" yazmalı

## Tarih Seçimi

- Takvim, Bugün ve 70 gün sonrası arasında çalışsın
- Dün ve öncesi tarihler seçilemez/pasif olarak görünmeli
- Belirtilen sınırdan sonraki tarihler seçilemez/pasif olarak görünmeli
- Tatil günleri ve önemli günler takvimde işaretlenmeli
  - Resmi tatiller, kırmızı
  - Önemli günler, turuncu (Örnek: Kandiller, Okulların kapanışı)
  - Önemli gün içeren tarih seçildiğinde takvimin altında bu günler listelenebilmeli
- Tarih, ilgili simgeye tıklandığında popup olarak açılmalı
- Popup içinde şu düğmeler olmalı:
- Buton: Bugün'ü Seç
- Buton: Yarın'ı Seç
- Buton: Bu Ayı göster
- Buton: Gelecek Ayı göster
- Buton: Vazgeç (datepicker'ı kapat)
- Buton: Seç (datepicker'ı tarihi seçip kapat)
- `<Ay>` ve `<Yıl>` seçimi satırı olmamalı (gizle)
- DatePicker üstündeki mavi alanda:
  - 1.Satırda "Tarih Seçini" yazısı olmalı
  - 2.Satırda açık tarih yazmalı (Örnek: 21 Mart 2024, Perşembe)
