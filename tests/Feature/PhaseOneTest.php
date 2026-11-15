<?php

namespace Tests\Feature;

use App\Models\Kegiatan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseOneTest extends TestCase
{
    use RefreshDatabase;

    protected function asUser(): void
    {
        $this->withSession([
            'user' => [
                'nama' => 'Staff Pengurus',
                'jabatan' => 'Staff Ahli Sekretaris',
            ],
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->get('/kalender')->assertRedirect('/login');
        $this->get('/tambah')->assertRedirect('/login');
    }

    public function test_logged_in_user_can_access_dashboard_and_crud(): void
    {
        $this->asUser();

        $this->get('/')->assertOk();
        $this->get('/kalender')->assertOk();
        $this->get('/akan-datang')->assertOk();
        $this->get('/selesai')->assertOk();
        $this->get('/semua-kegiatan')->assertOk();
        $this->get('/tambah')->assertOk();
    }

    public function test_user_can_store_and_update_kegiatan(): void
    {
        $this->asUser();

        $response = $this->post('/store', [
            'nama_kegiatan' => 'Rapat Pleno',
            'tanggal' => '2026-11-20',
            'waktu' => '10:00:00',
            'lokasi' => 'Auditorium',
            'divisi' => 'Sekretaris',
            'pic' => 'Andavi',
        ]);

        $response->assertRedirect('/');
        $this->assertDatabaseHas('kegiatans', ['nama_kegiatan' => 'Rapat Pleno']);

        $kegiatan = Kegiatan::first();

        $this->put("/update/{$kegiatan->id}", [
            'nama_kegiatan' => 'Rapat Pleno Diperbarui',
            'tanggal' => '2026-11-21',
            'waktu' => '11:00:00',
            'lokasi' => 'Ruang Sidang',
            'divisi' => 'Sekretaris',
            'pic' => 'Andavi',
        ])->assertRedirect();

        $this->assertDatabaseHas('kegiatans', ['nama_kegiatan' => 'Rapat Pleno Diperbarui']);
    }

    public function test_user_can_delete_kegiatan(): void
    {
        $this->asUser();

        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Kegiatan Hapus',
            'tanggal' => '2026-11-25',
            'waktu' => '09:00:00',
            'lokasi' => 'Kampus',
            'divisi' => 'Bendahara',
            'pic' => 'Davi',
            'status' => 'akan datang',
        ]);

        $this->delete("/delete/{$kegiatan->id}")->assertRedirect();
        $this->assertDatabaseMissing('kegiatans', ['id' => $kegiatan->id]);
    }
}
