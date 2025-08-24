<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Siswa;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class SiswaImportTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user for testing
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'email' => 'admin@test.com',
        ]);
    }

    public function test_admin_can_access_import_page()
    {
        $response = $this->actingAs($this->admin)
                        ->get('/siswa/import');

        $response->assertStatus(200);
        $response->assertSee('Import Data Siswa');
    }

    public function test_import_requires_file()
    {
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', []);

        $response->assertSessionHasErrors(['file']);
    }

    public function test_import_accepts_valid_file_types()
    {
        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Should not have validation errors for file type
        $response->assertSessionDoesntHaveErrors(['file']);
    }

    public function test_import_rejects_invalid_file_types()
    {
        $file = UploadedFile::fake()->create('students.txt', 100, 'text/plain');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        $response->assertSessionHasErrors(['file']);
    }

    public function test_import_rejects_large_files()
    {
        $file = UploadedFile::fake()->create('students.xlsx', 3000); // 3MB
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        $response->assertSessionHasErrors(['file']);
    }

    public function test_import_creates_users_and_students()
    {
        // Mock Excel facade to return test data
        Excel::fake();
        
        $testData = [
            [
                'nis' => '2024001',
                'nama_lengkap' => 'Test Student',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Test City',
                'tanggal_lahir' => '2006-01-15',
                'agama' => 'Islam',
                'alamat' => 'Test Address',
                'desa_kelurahan' => 'Test Village',
                'kecamatan' => 'Test District',
                'kabupaten_kota' => 'Test City',
                'provinsi' => 'Test Province',
                'tanggal_masuk' => '2024-07-01',
            ]
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([$testData]);

        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Check if user was created
        $this->assertDatabaseHas('users', [
            'name' => 'Test Student',
            'role' => 'siswa',
            'nip_nis' => '2024001',
        ]);

        // Check if student was created
        $this->assertDatabaseHas('siswa', [
            'nis' => '2024001',
            'nama_lengkap' => 'Test Student',
            'jenis_kelamin' => 'L',
        ]);
    }

    public function test_import_handles_duplicate_nis()
    {
        // Create existing student
        $existingUser = User::factory()->create(['role' => 'siswa']);
        $existingStudent = Siswa::factory()->create([
            'user_id' => $existingUser->id,
            'nis' => '2024001',
        ]);

        // Mock Excel facade to return duplicate NIS
        Excel::fake();
        
        $testData = [
            [
                'nis' => '2024001', // Duplicate NIS
                'nama_lengkap' => 'Another Student',
                'jenis_kelamin' => 'P',
                'tempat_lahir' => 'Test City',
                'tanggal_lahir' => '2006-01-15',
                'agama' => 'Islam',
                'alamat' => 'Test Address',
                'desa_kelurahan' => 'Test Village',
                'kecamatan' => 'Test District',
                'kabupaten_kota' => 'Test City',
                'provinsi' => 'Test Province',
                'tanggal_masuk' => '2024-07-01',
            ]
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([$testData]);

        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Should not create duplicate student
        $this->assertDatabaseCount('siswa', 1);
    }

    public function test_import_generates_unique_emails()
    {
        // Mock Excel facade
        Excel::fake();
        
        $testData = [
            [
                'nis' => '2024001',
                'nama_lengkap' => 'Test Student',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Test City',
                'tanggal_lahir' => '2006-01-15',
                'agama' => 'Islam',
                'alamat' => 'Test Address',
                'desa_kelurahan' => 'Test Village',
                'kecamatan' => 'Test District',
                'kabupaten_kota' => 'Test City',
                'provinsi' => 'Test Province',
                'tanggal_masuk' => '2024-07-01',
            ]
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([$testData]);

        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Check if user was created with generated email
        $this->assertDatabaseHas('users', [
            'name' => 'Test Student',
            'email' => 'teststudent@example.com',
        ]);
    }

    public function test_import_validates_required_fields()
    {
        // Mock Excel facade with missing required fields
        Excel::fake();
        
        $testData = [
            [
                'nis' => '2024001',
                'nama_lengkap' => 'Test Student',
                // Missing required fields
                'jenis_kelamin' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => '',
                'agama' => '',
                'alamat' => '',
                'desa_kelurahan' => '',
                'kecamatan' => '',
                'kabupaten_kota' => '',
                'provinsi' => '',
                'tanggal_masuk' => '',
            ]
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([$testData]);

        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Should not create student due to validation errors
        $this->assertDatabaseCount('siswa', 0);
    }

    public function test_import_handles_invalid_date_formats()
    {
        // Mock Excel facade with invalid date format
        Excel::fake();
        
        $testData = [
            [
                'nis' => '2024001',
                'nama_lengkap' => 'Test Student',
                'jenis_kelamin' => 'L',
                'tempat_lahir' => 'Test City',
                'tanggal_lahir' => 'invalid-date', // Invalid date format
                'agama' => 'Islam',
                'alamat' => 'Test Address',
                'desa_kelurahan' => 'Test Village',
                'kecamatan' => 'Test District',
                'kabupaten_kota' => 'Test City',
                'provinsi' => 'Test Province',
                'tanggal_masuk' => '2024-07-01',
            ]
        ];

        Excel::shouldReceive('toArray')
            ->once()
            ->andReturn([$testData]);

        $file = UploadedFile::fake()->create('students.xlsx', 100, 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
        $response = $this->actingAs($this->admin)
                        ->post('/siswa/import', ['file' => $file]);

        // Should not create student due to invalid date
        $this->assertDatabaseCount('siswa', 0);
    }
}
