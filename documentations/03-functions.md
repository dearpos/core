# Core Functions

## Deskripsi
Modul ini berisi daftar fungsi-fungsi helper yang dapat digunakan dalam sistem untuk membantu pengelolaan data pada tabel-tabel inti.

## Currency Functions

### `formatCurrency(float $amount, string $currencyCode = null): string`
Memformat angka menjadi format mata uang.

#### Parameters
- `$amount`: Nilai nominal yang akan diformat
- `$currencyCode`: Kode mata uang (opsional, default menggunakan pengaturan sistem)

#### Return
String yang telah diformat sesuai dengan mata uang yang dipilih

#### Contoh Penggunaan
```php
formatCurrency(15000); // Output: "Rp 15.000,00"
formatCurrency(100, 'USD'); // Output: "$ 100.00"
```

### `convertCurrency(float $amount, string $fromCurrency, string $toCurrency): float`
Mengkonversi nilai mata uang dari satu jenis ke jenis lainnya.

#### Parameters
- `$amount`: Nilai nominal yang akan dikonversi
- `$fromCurrency`: Kode mata uang asal
- `$toCurrency`: Kode mata uang tujuan

#### Return
Float nilai hasil konversi

#### Contoh Penggunaan
```php
convertCurrency(100, 'USD', 'IDR'); // Output: 1550000.00
```

## Unit of Measure Functions

### `convertUOM(float $value, string $fromUOM, string $toUOM): float`
Mengkonversi nilai dari satu unit pengukuran ke unit pengukuran lainnya.

#### Parameters
- `$value`: Nilai yang akan dikonversi
- `$fromUOM`: Kode unit pengukuran asal
- `$toUOM`: Kode unit pengukuran tujuan

#### Return
Float nilai hasil konversi

#### Contoh Penggunaan
```php
convertUOM(1, 'KG', 'G'); // Output: 1000.00
```

### `formatUOM(float $value, string $uomCode): string`
Memformat nilai dengan unit pengukurannya.

#### Parameters
- `$value`: Nilai yang akan diformat
- `$uomCode`: Kode unit pengukuran

#### Return
String yang telah diformat dengan unit pengukuran

#### Contoh Penggunaan
```php
formatUOM(5, 'KG'); // Output: "5 KG"
```

## Location Functions

### `getActiveLocations(): Collection`
Mendapatkan daftar lokasi yang aktif.

#### Return
Collection dari lokasi yang aktif

#### Contoh Penggunaan
```php
$activeLocations = getActiveLocations();
```

### `validateLocationEmail(string $email): bool`
Memvalidasi format email lokasi.

#### Parameters
- `$email`: Alamat email yang akan divalidasi

#### Return
Boolean hasil validasi

#### Contoh Penggunaan
```php
validateLocationEmail('ho.jakarta@dearpos.com'); // Output: true
```

### `generateLocationCode(string $city): string`
Menghasilkan kode lokasi berdasarkan nama kota.

#### Parameters
- `$city`: Nama kota

#### Return
String kode lokasi yang dihasilkan

#### Contoh Penggunaan
```php
generateLocationCode('Jakarta'); // Output: "JKT-001"
```

## Config Functions

### `getCoreConfig(string $key, mixed $default = null): mixed`
Mendapatkan nilai konfigurasi dari plugin core.

#### Parameters
- `$key`: Kunci konfigurasi
- `$default`: Nilai default jika konfigurasi tidak ditemukan

#### Return
Mixed nilai konfigurasi

#### Contoh Penggunaan
```php
getCoreConfig('default_currency', 'IDR');
```

### `setCoreConfig(string $key, mixed $value): void`
Mengatur nilai konfigurasi untuk plugin core.

#### Parameters
- `$key`: Kunci konfigurasi
- `$value`: Nilai yang akan disimpan

#### Contoh Penggunaan
```php
setCoreConfig('default_currency', 'IDR');
```