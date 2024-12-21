# Core Routes

## Deskripsi
Modul ini berisi daftar routes yang akan digunakan untuk mengakses API endpoints dari controller-controller yang ada.

## Routes

### Currency Routes

```php
Route::prefix('api')->group(function () {
    Route::apiResource('currencies', CurrencyController::class);
});
```

#### Endpoints
| Method | URI                      | Action  | Route Name           |
|--------|--------------------------|---------|---------------------|
| GET    | `/api/currencies`        | index   | currencies.index    |
| POST   | `/api/currencies`        | store   | currencies.store    |
| GET    | `/api/currencies/{id}`   | show    | currencies.show     |
| PUT    | `/api/currencies/{id}`   | update  | currencies.update   |
| DELETE | `/api/currencies/{id}`   | destroy | currencies.destroy  |

### Unit of Measure Routes

```php
Route::prefix('api')->group(function () {
    Route::apiResource('units', UnitOfMeasureController::class);
});
```

#### Endpoints
| Method | URI                 | Action  | Route Name      |
|--------|-------------------|---------|----------------|
| GET    | `/api/units`      | index   | units.index    |
| POST   | `/api/units`      | store   | units.store    |
| GET    | `/api/units/{id}` | show    | units.show     |
| PUT    | `/api/units/{id}` | update  | units.update   |
| DELETE | `/api/units/{id}` | destroy | units.destroy  |

### Location Routes

```php
Route::prefix('api')->group(function () {
    Route::apiResource('locations', LocationController::class);
});
```

#### Endpoints
| Method | URI                     | Action  | Route Name         |
|--------|-------------------------|---------|-------------------|
| GET    | `/api/locations`        | index   | locations.index    |
| POST   | `/api/locations`        | store   | locations.store    |
| GET    | `/api/locations/{id}`   | show    | locations.show     |
| PUT    | `/api/locations/{id}`   | update  | locations.update   |
| DELETE | `/api/locations/{id}`   | destroy | locations.destroy  |

## Catatan
- Semua routes diawali dengan prefix `/api`
- Menggunakan Laravel API Resource routing untuk menghasilkan route RESTful secara otomatis
- Setiap route memiliki nama unik yang bisa digunakan untuk generate URL menggunakan `route()` helper
- Parameter `{id}` menggunakan UUID