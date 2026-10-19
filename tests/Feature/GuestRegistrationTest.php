<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\GuestVisit;
use App\Models\Host;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestRegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_can_be_rendered(): void
    {
        $department = Department::create([
            'name' => 'Tata Usaha & Kurikulum',
            'code' => 'TU',
            'description' => 'Layanan administrasi dan kurikulum',
        ]);

        $host = Host::create([
            'department_id' => $department->id,
            'name' => 'Ahmad Fauzi, S.Pd.',
            'position' => 'Kepala Tata Usaha',
            'email' => 'ahmad@smkpesat.sch.id',
            'phone' => '08123456789',
            'status' => 'available',
        ]);

        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertSee('Formulir Pendaftaran Kunjungan Tamu');
        $response->assertSee('Tata Usaha & Kurikulum');
        $response->assertSee('Ahmad Fauzi, S.Pd.');
    }

    public function test_guest_can_register_a_visit_successfully(): void
    {
        $department = Department::create([
            'name' => 'Hubungan Industri & BKK',
            'code' => 'HUBIN',
        ]);

        $host = Host::create([
            'department_id' => $department->id,
            'name' => 'Budi Raharjo, M.Kom.',
            'position' => 'Koordinator Kerjasama Industri',
            'email' => 'budi@smkpesat.sch.id',
            'phone' => '08987654321',
            'status' => 'available',
        ]);

        $postData = [
            'guest_name' => 'Rina Wijaya',
            'phone' => '081298765432',
            'email' => 'rina@astra.co.id',
            'purpose' => 'Koordinasi Penjajakan MoU PKL Siswa',
            'department_id' => $department->id,
            'host_id' => $host->id,
            'has_appointment' => '1',
            'visit_date' => date('Y-m-d'),
            'scheduled_time' => '09:30',
            'guest_count' => 2,
            'notes' => 'Membawa dokumen draf nota kesepahaman',
        ];

        $response = $this->post('/register', $postData);

        $visit = GuestVisit::where('guest_name', 'Rina Wijaya')->first();
        $this->assertNotNull($visit);
        $this->assertNull($visit->institution);
        $this->assertNull($visit->vehicle_number);
        $this->assertEquals('081298765432', $visit->phone);
        $this->assertEquals($department->id, $visit->department_id);
        $this->assertEquals($host->id, $visit->host_id);
        $this->assertEquals(2, $visit->guest_count);
        $this->assertEquals('pending', $visit->status);

        $response->assertRedirect(route('ticket.show', $visit->ticket_code));
        $response->assertSessionHas('success');
    }

    public function test_registration_validation_fails_when_required_fields_are_missing(): void
    {
        $response = $this->post('/register', []);

        $response->assertSessionHasErrors([
            'guest_name',
            'phone',
            'purpose',
            'department_id',
            'visit_date',
            'scheduled_time',
            'guest_count',
        ]);
    }

    public function test_api_hosts_by_department_returns_hosts(): void
    {
        $department = Department::create([
            'name' => 'Teknik Komputer & Jaringan',
            'code' => 'TKJ',
        ]);

        Host::create([
            'department_id' => $department->id,
            'name' => 'Guru TKJ 1',
            'position' => 'Guru Kejuruan TKJ',
            'status' => 'available',
        ]);

        $response = $this->getJson("/api/departments/{$department->id}/hosts");

        $response->assertStatus(200);
        $response->assertJsonFragment(['name' => 'Guru TKJ 1']);
    }
}
