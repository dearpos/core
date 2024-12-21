# Core Controllers

## Deskripsi
Modul ini berisi daftar controller yang akan digunakan untuk mengelola data pada tabel-tabel inti sistem.

## Controllers

### CurrencyController

#### Methods
- `index()` - Menampilkan daftar mata uang
- `store(Request $request)` - Menyimpan data mata uang baru
- `show(string $id)` - Menampilkan detail mata uang
- `update(Request $request, string $id)` - Memperbarui data mata uang
- `destroy(string $id)` - Menghapus data mata uang

#### Validasi
- `code`: Wajib diisi, string, panjang 3 karakter, unik, format ISO 4217
- `name`: Wajib diisi, string, maksimal 50 karakter
- `exchange_rate`: Wajib diisi, numeric, minimal 0

#### Response Format

##### Index Response
```json
{
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440000",
            "code": "IDR",
            "name": "Indonesian Rupiah",
            "exchange_rate": 1.0000,
            "created_at": "2024-12-21T15:19:21.000000Z",
            "updated_at": "2024-12-21T15:19:21.000000Z"
        }
    ],
    "links": {
        "first": "http://example.com/api/currencies?page=1",
        "last": "http://example.com/api/currencies?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://example.com/api/currencies",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

##### Show Response
```json
{
    "data": {
        "id": "550e8400-e29b-41d4-a716-446655440000",
        "code": "IDR",
        "name": "Indonesian Rupiah",
        "exchange_rate": 1.0000,
        "created_at": "2024-12-21T15:19:21.000000Z",
        "updated_at": "2024-12-21T15:19:21.000000Z"
    }
}
```

### UnitOfMeasureController

#### Methods
- `index()` - Menampilkan daftar unit pengukuran
- `store(Request $request)` - Menyimpan data unit pengukuran baru
- `show(string $id)` - Menampilkan detail unit pengukuran
- `update(Request $request, string $id)` - Memperbarui data unit pengukuran
- `destroy(string $id)` - Menghapus data unit pengukuran

#### Validasi
- `code`: Wajib diisi, string, maksimal 10 karakter, unik
- `name`: Wajib diisi, string, maksimal 50 karakter

#### Response Format

##### Index Response
```json
{
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440000",
            "code": "PCS",
            "name": "Pieces",
            "created_at": "2024-12-21T15:19:21.000000Z",
            "updated_at": "2024-12-21T15:19:21.000000Z"
        }
    ],
    "links": {
        "first": "http://example.com/api/units?page=1",
        "last": "http://example.com/api/units?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://example.com/api/units",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

##### Show Response
```json
{
    "data": {
        "id": "550e8400-e29b-41d4-a716-446655440000",
        "code": "PCS",
        "name": "Pieces",
        "created_at": "2024-12-21T15:19:21.000000Z",
        "updated_at": "2024-12-21T15:19:21.000000Z"
    }
}
```

### LocationController

#### Methods
- `index()` - Menampilkan daftar lokasi
- `store(Request $request)` - Menyimpan data lokasi baru
- `show(string $id)` - Menampilkan detail lokasi
- `update(Request $request, string $id)` - Memperbarui data lokasi
- `destroy(string $id)` - Menghapus data lokasi

#### Validasi
- `code`: Wajib diisi, string, maksimal 20 karakter, unik
- `name`: Wajib diisi, string, maksimal 100 karakter
- `address`: Wajib diisi, text
- `city`: Wajib diisi, string, maksimal 100 karakter
- `state`: Opsional, string, maksimal 100 karakter
- `country`: Wajib diisi, string, maksimal 100 karakter
- `postal_code`: Wajib diisi, string, maksimal 20 karakter
- `phone`: Opsional, string, maksimal 20 karakter
- `email`: Opsional, string, maksimal 100 karakter, format email, unik
- `is_active`: Wajib diisi, boolean

#### Response Format

##### Index Response
```json
{
    "data": [
        {
            "id": "550e8400-e29b-41d4-a716-446655440000",
            "code": "HO-JKT",
            "name": "Head Office Jakarta",
            "address": "Jl. Sudirman No. 1",
            "city": "Jakarta",
            "state": "DKI Jakarta",
            "country": "Indonesia",
            "postal_code": "12190",
            "phone": "021-5555555",
            "email": "ho.jakarta@dearpos.com",
            "is_active": true,
            "created_at": "2024-12-21T15:19:21.000000Z",
            "updated_at": "2024-12-21T15:19:21.000000Z"
        }
    ],
    "links": {
        "first": "http://example.com/api/locations?page=1",
        "last": "http://example.com/api/locations?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "path": "http://example.com/api/locations",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

##### Show Response
```json
{
    "data": {
        "id": "550e8400-e29b-41d4-a716-446655440000",
        "code": "HO-JKT",
        "name": "Head Office Jakarta",
        "address": "Jl. Sudirman No. 1",
        "city": "Jakarta",
        "state": "DKI Jakarta",
        "country": "Indonesia",
        "postal_code": "12190",
        "phone": "021-5555555",
        "email": "ho.jakarta@dearpos.com",
        "is_active": true,
        "created_at": "2024-12-21T15:19:21.000000Z",
        "updated_at": "2024-12-21T15:19:21.000000Z"
    }
}