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

    protected function asAdmin(string $jabatan = 'Ketua Himpunan'): void
    {
        $this->withSession([
            'user' => [
                'nama' => 'Pengurus Admin',
                'jabatan' => $jabatan,
            ],
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/')->assertRedirect('/login');
        $this->get('/kalender')->assertRedirect('/login');
        $this->get('/tambah')->assertRedirect('/login');
    }

    public function test_logged_in_member_can_view_agenda_but_not_admin_tools(): void
    {
        $this->asUser();

        $this->get('/')->assertOk();
        $this->get('/kalender')->assertOk();
        $this->get('/akan-datang')->assertOk();
        $this->get('/selesai')->assertOk();
        $this->get('/semua-kegiatan')->assertOk();
        $this->get('/tambah')->assertForbidden();
        $this->get('/admin/dashboard')->assertForbidden();
    }

    public function test_member_dashboard_hides_add_agenda_cta(): void
    {
        $this->asUser();

        $this->get('/')
            ->assertOk()
            ->assertDontSee('Tambah Agenda');
    }

    public function test_admin_dashboard_is_available_to_allowed_roles(): void
    {
        foreach (['Ketua Himpunan', 'Wakil Ketua Himpunan', 'Ketua Divisi Sekretaris'] as $jabatan) {
            $this->asAdmin($jabatan);

            $this->get('/admin/dashboard')
                ->assertOk()
                ->assertSee('Dashboard Admin')
                ->assertSee('Tambah Agenda');
        }
    }

    public function test_non_admin_cannot_write_agenda_endpoints(): void
    {
        $this->asUser();
        $kegiatan = Kegiatan::create([
            'nama_kegiatan' => 'Kegiatan Terbatas',
            'tanggal' => '2026-11-25',
            'waktu' => '09:00:00',
            'lokasi' => 'Kampus',
            'divisi' => 'Bendahara',
            'pic' => 'Davi',
            'status' => 'akan datang',
        ]);

        $payload = [
            'nama_kegiatan' => 'Rapat Pleno',
            'tanggal' => '2026-11-20',
            'waktu' => '10:00:00',
            'lokasi' => 'Auditorium',
            'divisi' => 'Sekretaris',
            'pic' => 'Andavi',
        ];

        $this->post('/store', $payload)->assertForbidden();
        $this->get("/edit/{$kegiatan->id}")->assertForbidden();
        $this->put("/update/{$kegiatan->id}", $payload)->assertForbidden();
        $this->delete("/delete/{$kegiatan->id}")->assertForbidden();

        $this->assertDatabaseMissing('kegiatans', ['nama_kegiatan' => 'Rapat Pleno']);
        $this->assertDatabaseHas('kegiatans', ['id' => $kegiatan->id]);
    }

    public function test_admin_can_create_update_and_delete_kegiatan(): void
    {
        $this->asAdmin('Ketua Divisi Sekretaris');

        $this->post('/store', [
            'nama_kegiatan' => 'Rapat Pleno Diperbarui',
            'tanggal' => '2026-11-21',
            'waktu' => '11:00:00',
            'lokasi' => 'Ruang Sidang',
            'divisi' => 'Sekretaris',
            'pic' => 'Andavi',
        ])->assertRedirect('/');

        $kegiatan = Kegiatan::where('nama_kegiatan', 'Rapat Pleno Diperbarui')->firstOrFail();

        $this->get('/admin/dashboard')
            ->assertOk()
            ->assertSee('Rapat Pleno Diperbarui')
            ->assertSee('Edit')
            ->assertSee('Hapus');

        $this->put("/update/{$kegiatan->id}", [
            'nama_kegiatan' => 'Rapat Pleno',
            'tanggal' => '2026-11-22',
            'waktu' => '12:00:00',
            'lokasi' => 'Auditorium',
            'divisi' => 'Sekretaris',
            'pic' => 'Andavi',
        ])->assertRedirect();

        $this->assertDatabaseHas('kegiatans', ['id' => $kegiatan->id, 'nama_kegiatan' => 'Rapat Pleno']);

        $this->delete("/delete/{$kegiatan->id}")->assertRedirect();
        $this->assertDatabaseMissing('kegiatans', ['id' => $kegiatan->id]);
    }
}
