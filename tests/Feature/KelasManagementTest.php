<?php

namespace Tests\Feature;

use App\Livewire\KelasManagement\KelasForm;
use App\Livewire\KelasManagement\KelasTable;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class KelasManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create admin user
        $this->admin = User::factory()->create([
            'role' => 'admin',
            'status' => 'active'
        ]);
    }

    public function test_admin_can_view_kelas_table()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/kelas');
        
        $response->assertStatus(200);
        $response->assertSeeLivewire('kelas-management.kelas-table');
    }

    public function test_admin_can_view_create_kelas_form()
    {
        $this->actingAs($this->admin);

        $response = $this->get('/kelas/create');
        
        $response->assertStatus(200);
        $response->assertSeeLivewire('kelas-management.kelas-form');
    }

    public function test_admin_can_create_kelas()
    {
        $this->actingAs($this->admin);

        Livewire::test(KelasForm::class)
            ->set('nama_kelas', 'I A')
            ->set('tingkat', 'I')
            ->set('deskripsi', 'Kelas I A dengan fokus dasar')
            ->set('status', 'aktif')
            ->call('save')
            ->assertRedirect('/kelas');

        $this->assertDatabaseHas('kelas', [
            'nama_kelas' => 'I A',
            'tingkat' => 'I',
            'status' => 'aktif'
        ]);
    }

    public function test_admin_can_edit_kelas()
    {
        $this->actingAs($this->admin);

        $kelas = Kelas::create([
            'nama_kelas' => 'I A',
            'tingkat' => 'I',
            'deskripsi' => 'Kelas I A',
            'status' => 'aktif'
        ]);

        $response = $this->get("/kelas/{$kelas->id}/edit");
        
        $response->assertStatus(200);
        $response->assertSeeLivewire('kelas-management.kelas-form');
    }

    public function test_admin_can_update_kelas()
    {
        $this->actingAs($this->admin);

        $kelas = Kelas::create([
            'nama_kelas' => 'X IPA 1',
            'tingkat' => 'X',
            'jurusan' => 'IPA',
            'deskripsi' => 'Kelas X IPA 1',
            'status' => 'aktif'
        ]);

        Livewire::test(KelasForm::class, ['kelasId' => $kelas->id])
            ->set('nama_kelas', 'I A Updated')
            ->call('save')
            ->assertRedirect('/kelas');

        $this->assertDatabaseHas('kelas', [
            'id' => $kelas->id,
            'nama_kelas' => 'I A Updated'
        ]);
    }

    public function test_admin_can_delete_kelas()
    {
        $this->actingAs($this->admin);

        $kelas = Kelas::create([
            'nama_kelas' => 'I A',
            'tingkat' => 'I',
            'deskripsi' => 'Kelas I A',
            'status' => 'aktif'
        ]);

        Livewire::test(KelasTable::class)
            ->call('delete', $kelas->id)
            ->assertDispatchedBrowserEvent('confirm');

        $this->assertDatabaseMissing('kelas', ['id' => $kelas->id]);
    }

    public function test_kelas_validation_works()
    {
        $this->actingAs($this->admin);

        Livewire::test(KelasForm::class)
            ->set('nama_kelas', '') // Empty nama_kelas
            ->set('tingkat', '') // Empty tingkat
            ->call('save')
            ->assertHasErrors(['nama_kelas', 'tingkat']);
    }

    public function test_kelas_search_works()
    {
        $this->actingAs($this->admin);

        // Create test data
        Kelas::create([
            'nama_kelas' => 'I A',
            'tingkat' => 'I',
            'status' => 'aktif'
        ]);

        Kelas::create([
            'nama_kelas' => 'II A',
            'tingkat' => 'II',
            'status' => 'aktif'
        ]);

        Livewire::test(KelasTable::class)
            ->set('search', 'I')
            ->assertSee('I A')
            ->assertDontSee('II A');
    }

    public function test_kelas_filter_works()
    {
        $this->actingAs($this->admin);

        // Create test data
        Kelas::create([
            'nama_kelas' => 'I A',
            'tingkat' => 'I',
            'status' => 'aktif'
        ]);

        Kelas::create([
            'nama_kelas' => 'II A',
            'tingkat' => 'II',
            'status' => 'aktif'
        ]);

        Livewire::test(KelasTable::class)
            ->set('tingkatFilter', 'I')
            ->assertSee('I A')
            ->assertDontSee('II A');
    }

    public function test_kelas_pagination_works()
    {
        $this->actingAs($this->admin);

        // Create more than 10 classes to test pagination
        for ($i = 1; $i <= 15; $i++) {
            Kelas::create([
                'nama_kelas' => "I {$i}",
                'tingkat' => 'I',
                'status' => 'aktif'
            ]);
        }

        Livewire::test(KelasTable::class)
            ->assertSee('I 1')
            ->assertSee('I 10')
            ->assertDontSee('I 11'); // Should be on next page
    }
}
