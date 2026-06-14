# 📊 Cheatsheet Status Gizi Balita
> Berdasarkan standar WHO yang diimplementasikan di `GiziKalkulator.php`

---

## 🧠 Cara Sistem Menentukan Status (Urutan Prioritas)

```
1️⃣ Cek TB dulu → jika TB terlalu pendek → STUNTING (langsung, tidak cek BB)
2️⃣ Kalau TB normal, baru cek BB:
   → BB sangat kurang  : GIZI KURANG
   → BB normal         : GIZI NORMAL  ✅ (ini yang disebut "Gizi Baik")
   → BB berlebih       : GIZI LEBIH
```

### Rumus Z-Score:
```
Z = (Nilai Anak - Median WHO) / SD WHO
```

### Batas Z-Score per Status:

| Status Gizi   | Kondisi                          |
|---------------|----------------------------------|
| **Stunting**  | Z-score TB/U < -2                |
| **Gizi Kurang** | Z-score BB/U < -2 (dan TB normal)|
| **Gizi Normal** | -2 ≤ Z-score BB/U ≤ 2 (dan TB normal) |
| **Gizi Lebih**  | Z-score BB/U > 2 (dan TB normal) |

---

## 👦 LAKI-LAKI — Rentang BB (kg) per Status Gizi

> Syarat tambahan: TB juga harus dalam batas normal agar tidak masuk Stunting

| Umur | BB Gizi Kurang | BB Gizi Normal ✅ | BB Gizi Lebih | Median BB |
|------|---------------|-------------------|--------------|-----------|
| 0 bln | < 2.4 kg | 2.4 – 4.2 kg | > 4.2 kg | 3.3 kg |
| 1 bln | < 3.4 kg | 3.4 – 5.6 kg | > 5.6 kg | 4.5 kg |
| 2 bln | < 4.4 kg | 4.4 – 6.8 kg | > 6.8 kg | 5.6 kg |
| 3 bln | < 5.1 kg | 5.1 – 7.7 kg | > 7.7 kg | 6.4 kg |
| 4 bln | < 5.6 kg | 5.6 – 8.4 kg | > 8.4 kg | 7.0 kg |
| 5 bln | < 6.0 kg | 6.0 – 9.0 kg | > 9.0 kg | 7.5 kg |
| 6 bln | < 6.3 kg | 6.3 – 9.5 kg | > 9.5 kg | 7.9 kg |
| 7 bln | < 6.7 kg | 6.7 – 9.9 kg | > 9.9 kg | 8.3 kg |
| 8 bln | < 6.9 kg | 6.9 – 10.3 kg | > 10.3 kg | 8.6 kg |
| 9 bln | < 7.2 kg | 7.2 – 10.6 kg | > 10.6 kg | 8.9 kg |
| 10 bln | < 7.4 kg | 7.4 – 11.0 kg | > 11.0 kg | 9.2 kg |
| 11 bln | < 7.6 kg | 7.6 – 11.2 kg | > 11.2 kg | 9.4 kg |
| 12 bln | < 7.7 kg | 7.7 – 11.5 kg | > 11.5 kg | 9.6 kg |
| 15 bln | < 8.3 kg | 8.3 – 12.3 kg | > 12.3 kg | 10.3 kg |
| 18 bln | < 8.8 kg | 8.8 – 13.0 kg | > 13.0 kg | 10.9 kg |
| 24 bln | < 9.8 kg | 9.8 – 14.6 kg | > 14.6 kg | 12.2 kg |
| 30 bln | < 10.7 kg | 10.7 – 15.9 kg | > 15.9 kg | 13.3 kg |
| 36 bln | < 11.4 kg | 11.4 – 17.2 kg | > 17.2 kg | 14.3 kg |
| 42 bln | < 12.2 kg | 12.2 – 18.4 kg | > 18.4 kg | 15.3 kg |
| 48 bln | < 13.0 kg | 13.0 – 19.6 kg | > 19.6 kg | 16.3 kg |
| 54 bln | < 13.8 kg | 13.8 – 21.0 kg | > 21.0 kg | 17.4 kg |
| 60 bln | < 14.5 kg | 14.5 – 22.1 kg | > 22.1 kg | 18.3 kg |

---

## 👦 LAKI-LAKI — Batas TB (cm) untuk TIDAK Stunting

| Umur | TB Minimal (agar tidak Stunting) | Median TB |
|------|----------------------------------|-----------|
| 0 bln | ≥ 46.1 cm | 49.9 cm |
| 1 bln | ≥ 50.7 cm | 54.7 cm |
| 2 bln | ≥ 54.3 cm | 58.4 cm |
| 3 bln | ≥ 57.2 cm | 61.4 cm |
| 4 bln | ≥ 59.6 cm | 63.9 cm |
| 5 bln | ≥ 61.5 cm | 65.9 cm |
| 6 bln | ≥ 63.2 cm | 67.6 cm |
| 7 bln | ≥ 64.6 cm | 69.2 cm |
| 8 bln | ≥ 65.9 cm | 70.6 cm |
| 9 bln | ≥ 67.2 cm | 72.0 cm |
| 10 bln | ≥ 68.4 cm | 73.3 cm |
| 11 bln | ≥ 69.4 cm | 74.5 cm |
| 12 bln | ≥ 70.5 cm | 75.7 cm |
| 15 bln | ≥ 73.5 cm | 79.1 cm |
| 18 bln | ≥ 76.3 cm | 82.3 cm |
| 24 bln | ≥ 81.1 cm | 87.8 cm |
| 30 bln | ≥ 85.6 cm | 92.9 cm |
| 36 bln | ≥ 89.3 cm | 97.4 cm |
| 42 bln | ≥ 93.1 cm | 101.8 cm |
| 48 bln | ≥ 96.6 cm | 106.0 cm |
| 54 bln | ≥ 100.0 cm | 110.0 cm |
| 60 bln | ≥ 103.3 cm | 113.9 cm |

---

## 👧 PEREMPUAN — Rentang BB (kg) per Status Gizi

| Umur | BB Gizi Kurang | BB Gizi Normal ✅ | BB Gizi Lebih | Median BB |
|------|---------------|-------------------|--------------|-----------|
| 0 bln | < 2.3 kg | 2.3 – 4.1 kg | > 4.1 kg | 3.2 kg |
| 1 bln | < 3.2 kg | 3.2 – 5.2 kg | > 5.2 kg | 4.2 kg |
| 2 bln | < 3.9 kg | 3.9 – 6.3 kg | > 6.3 kg | 5.1 kg |
| 3 bln | < 4.5 kg | 4.5 – 7.1 kg | > 7.1 kg | 5.8 kg |
| 4 bln | < 5.1 kg | 5.1 – 7.7 kg | > 7.7 kg | 6.4 kg |
| 5 bln | < 5.5 kg | 5.5 – 8.3 kg | > 8.3 kg | 6.9 kg |
| 6 bln | < 5.8 kg | 5.8 – 8.8 kg | > 8.8 kg | 7.3 kg |
| 7 bln | < 6.0 kg | 6.0 – 9.2 kg | > 9.2 kg | 7.6 kg |
| 8 bln | < 6.3 kg | 6.3 – 9.5 kg | > 9.5 kg | 7.9 kg |
| 9 bln | < 6.5 kg | 6.5 – 9.9 kg | > 9.9 kg | 8.2 kg |
| 10 bln | < 6.8 kg | 6.8 – 10.2 kg | > 10.2 kg | 8.5 kg |
| 11 bln | < 7.0 kg | 7.0 – 10.5 kg | > 10.5 kg | 8.7 kg |
| 12 bln | < 7.1 kg | 7.1 – 10.7 kg | > 10.7 kg | 8.9 kg |
| 15 bln | < 7.6 kg | 7.6 – 11.6 kg | > 11.6 kg | 9.6 kg |
| 18 bln | < 8.1 kg | 8.1 – 12.3 kg | > 12.3 kg | 10.2 kg |
| 24 bln | < 9.1 kg | 9.1 – 13.9 kg | > 13.9 kg | 11.5 kg |
| 30 bln | < 10.1 kg | 10.1 – 15.3 kg | > 15.3 kg | 12.7 kg |
| 36 bln | < 11.0 kg | 11.0 – 16.8 kg | > 16.8 kg | 13.9 kg |
| 42 bln | < 11.8 kg | 11.8 – 18.2 kg | > 18.2 kg | 15.0 kg |
| 48 bln | < 12.6 kg | 12.6 – 19.6 kg | > 19.6 kg | 16.1 kg |
| 54 bln | < 13.3 kg | 13.3 – 21.1 kg | > 21.1 kg | 17.3 kg |
| 60 bln | < 14.4 kg | 14.4 – 22.6 kg | > 22.6 kg | 18.5 kg |

---

## 👧 PEREMPUAN — Batas TB (cm) untuk TIDAK Stunting

| Umur | TB Minimal (agar tidak Stunting) | Median TB |
|------|----------------------------------|-----------|
| 0 bln | ≥ 45.4 cm | 49.1 cm |
| 1 bln | ≥ 49.8 cm | 53.7 cm |
| 2 bln | ≥ 53.1 cm | 57.1 cm |
| 3 bln | ≥ 55.7 cm | 59.8 cm |
| 4 bln | ≥ 57.9 cm | 62.1 cm |
| 5 bln | ≥ 59.7 cm | 64.0 cm |
| 6 bln | ≥ 61.2 cm | 65.7 cm |
| 7 bln | ≥ 62.7 cm | 67.3 cm |
| 8 bln | ≥ 64.0 cm | 68.7 cm |
| 9 bln | ≥ 65.3 cm | 70.1 cm |
| 10 bln | ≥ 66.6 cm | 71.5 cm |
| 11 bln | ≥ 67.7 cm | 72.8 cm |
| 12 bln | ≥ 68.8 cm | 74.0 cm |
| 15 bln | ≥ 71.9 cm | 77.5 cm |
| 18 bln | ≥ 74.8 cm | 80.7 cm |
| 24 bln | ≥ 79.8 cm | 86.4 cm |
| 30 bln | ≥ 84.3 cm | 91.6 cm |
| 36 bln | ≥ 88.4 cm | 96.4 cm |
| 42 bln | ≥ 92.4 cm | 100.9 cm |
| 48 bln | ≥ 95.8 cm | 105.1 cm |
| 54 bln | ≥ 99.2 cm | 109.2 cm |
| 60 bln | ≥ 102.4 cm | 113.0 cm |

---

## 🧪 Contoh Pengujian Black Box (Siap Pakai)

### Contoh untuk mendapat setiap status gizi (Laki-laki, 12 bulan):

| No | Status Target | BB | TB | Keterangan |
|----|--------------|----|----|------------|
| — | **Gizi Normal** ✅ | **9.6 kg** | **75.7 cm** | Tepat di median |
| — | **Gizi Normal** ✅ | **8.5 kg** | **73.0 cm** | Mendekati batas bawah |
| — | **Gizi Lebih** | **12.5 kg** | **75.7 cm** | BB > median + 2SD |
| — | **Gizi Kurang** | **7.0 kg** | **75.7 cm** | BB < median - 2SD |
| — | **Stunting** | **9.6 kg** | **68.0 cm** | TB < 70.5 cm |

### Contoh untuk mendapat setiap status gizi (Perempuan, 12 bulan):

| No | Status Target | BB | TB | Keterangan |
|----|--------------|----|----|------------|
| — | **Gizi Normal** ✅ | **8.9 kg** | **74.0 cm** | Tepat di median |
| — | **Gizi Lebih** | **11.5 kg** | **74.0 cm** | BB > median + 2SD |
| — | **Gizi Kurang** | **6.5 kg** | **74.0 cm** | BB < median - 2SD |
| — | **Stunting** | **8.9 kg** | **66.0 cm** | TB < 68.8 cm |

---

> **💡 Tips:** Kolom "Median BB" dan "Median TB" = nilai tengah/normal sempurna untuk anak seusia itu. Gunakan nilai ini sebagai input default tes untuk mendapat hasil **Gizi Normal**.
