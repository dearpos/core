# Core Testing

## Deskripsi
Modul ini berisi daftar test yang diperlukan untuk memastikan package berjalan dengan benar.

## Unit Tests

### Models

#### CurrencyTest

```php
class CurrencyTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $currency = Currency::factory()->create();
        
        $this->assertIsString($currency->id);
        $this->assertTrue(Str::isUuid($currency->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $currency = Currency::factory()->create([
            'code' => 'IDR',
            'name' => 'Indonesian Rupiah',
            'exchange_rate' => 1.0000,
        ]);

        $this->assertEquals('IDR', $currency->code);
        $this->assertEquals('Indonesian Rupiah', $currency->name);
        $this->assertEquals(1.0000, $currency->exchange_rate);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        Currency::factory()->create(['code' => 'IDR']);

        $this->expectException(QueryException::class);
        Currency::factory()->create(['code' => 'IDR']);
    }
}
```

#### UnitOfMeasureTest

```php
class UnitOfMeasureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $unit = UnitOfMeasure::factory()->create();
        
        $this->assertIsString($unit->id);
        $this->assertTrue(Str::isUuid($unit->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $unit = UnitOfMeasure::factory()->create([
            'code' => 'PCS',
            'name' => 'Pieces',
        ]);

        $this->assertEquals('PCS', $unit->code);
        $this->assertEquals('Pieces', $unit->name);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        UnitOfMeasure::factory()->create(['code' => 'PCS']);

        $this->expectException(QueryException::class);
        UnitOfMeasure::factory()->create(['code' => 'PCS']);
    }
}
```

#### LocationTest

```php
class LocationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_uses_uuid_as_primary_key()
    {
        $location = Location::factory()->create();
        
        $this->assertIsString($location->id);
        $this->assertTrue(Str::isUuid($location->id));
    }

    /** @test */
    public function it_has_required_attributes()
    {
        $location = Location::factory()->create([
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'is_active' => true,
        ]);

        $this->assertEquals('HO-JKT', $location->code);
        $this->assertEquals('Head Office Jakarta', $location->name);
        $this->assertEquals('Jl. Sudirman No. 1', $location->address);
        $this->assertEquals('Jakarta', $location->city);
        $this->assertEquals('Indonesia', $location->country);
        $this->assertEquals('12190', $location->postal_code);
        $this->assertTrue($location->is_active);
    }

    /** @test */
    public function it_enforces_unique_code()
    {
        Location::factory()->create(['code' => 'HO-JKT']);

        $this->expectException(QueryException::class);
        Location::factory()->create(['code' => 'HO-JKT']);
    }

    /** @test */
    public function it_enforces_unique_email_when_provided()
    {
        Location::factory()->create(['email' => 'test@example.com']);

        $this->expectException(QueryException::class);
        Location::factory()->create(['email' => 'test@example.com']);
    }
}
```

## Feature Tests

### API Endpoints

#### CurrencyControllerTest

```php
class CurrencyControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_currencies()
    {
        Currency::factory()->count(3)->create();

        $response = $this->getJson('/api/currencies');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'code', 'name', 'exchange_rate', 'created_at', 'updated_at']
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_currency()
    {
        $data = [
            'code' => 'USD',
            'name' => 'US Dollar',
            'exchange_rate' => 15500.0000,
        ];

        $response = $this->postJson('/api/currencies', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'code', 'name', 'exchange_rate', 'created_at', 'updated_at']
            ]);
        
        $this->assertDatabaseHas('currencies', $data);
    }

    /** @test */
    public function it_validates_currency_code_format()
    {
        $data = [
            'code' => 'INVALID',
            'name' => 'Invalid Currency',
            'exchange_rate' => 1.0000,
        ];

        $response = $this->postJson('/api/currencies', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }
}
```

#### UnitOfMeasureControllerTest

```php
class UnitOfMeasureControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_units()
    {
        UnitOfMeasure::factory()->count(3)->create();

        $response = $this->getJson('/api/units');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'code', 'name', 'created_at', 'updated_at']
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_unit()
    {
        $data = [
            'code' => 'KG',
            'name' => 'Kilogram',
        ];

        $response = $this->postJson('/api/units', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => ['id', 'code', 'name', 'created_at', 'updated_at']
            ]);
        
        $this->assertDatabaseHas('units_of_measures', $data);
    }

    /** @test */
    public function it_validates_unit_code_length()
    {
        $data = [
            'code' => 'TOOLONGCODE',
            'name' => 'Invalid Unit',
        ];

        $response = $this->postJson('/api/units', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['code']);
    }
}
```

#### LocationControllerTest

```php
class LocationControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_locations()
    {
        Location::factory()->count(3)->create();

        $response = $this->getJson('/api/locations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'code', 'name', 'address', 'city', 'state', 'country',
                        'postal_code', 'phone', 'email', 'is_active', 'created_at', 'updated_at'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_location()
    {
        $data = [
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'id', 'code', 'name', 'address', 'city', 'country',
                    'postal_code', 'is_active', 'created_at', 'updated_at'
                ]
            ]);
        
        $this->assertDatabaseHas('locations', $data);
    }

    /** @test */
    public function it_validates_email_format()
    {
        $data = [
            'code' => 'HO-JKT',
            'name' => 'Head Office Jakarta',
            'address' => 'Jl. Sudirman No. 1',
            'city' => 'Jakarta',
            'country' => 'Indonesia',
            'postal_code' => '12190',
            'email' => 'invalid-email',
            'is_active' => true,
        ];

        $response = $this->postJson('/api/locations', $data);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
```

## Filament Tests

### ResourceTests

#### CurrencyResourceTest

```php
class CurrencyResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_render_currency_index_page()
    {
        $this->get(CurrencyResource::getUrl('index'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_render_currency_create_form()
    {
        $this->get(CurrencyResource::getUrl('create'))
            ->assertSuccessful();
    }

    /** @test */
    public function it_can_create_currency()
    {
        $response = Livewire::test(CurrencyResource\Pages\CreateCurrency::class)
            ->fillForm([
                'code' => 'USD',
                'name' => 'US Dollar',
                'exchange_rate' => 15500.0000,
            ])
            ->call('create');

        $response->assertHasNoErrors();
        $this->assertDatabaseHas('currencies', [
            'code' => 'USD',
            'name' => 'US Dollar',
        ]);
    }
}
```

## Catatan
- Semua test menggunakan trait `RefreshDatabase` untuk memastikan database bersih setiap test
- Unit test fokus pada model dan validasi data
- Feature test mencakup endpoint API dan response format
- Filament test memastikan halaman admin dapat diakses dan berfungsi dengan benar
- Gunakan factory untuk membuat data test
- Validasi mencakup:
  - Format kode mata uang (ISO 4217)
  - Panjang maksimum field
  - Unique constraint
  - Format email
  - Required fields