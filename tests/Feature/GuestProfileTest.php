<?php

namespace Tests\Feature;

use App\Models\Department;
use App\Models\GuestVisit;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuestProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_profile_page_shows_info_and_ticket_history(): void
    {
        $department = Department::create([
            'name' => 'Hubungan Industri & BKK',
            'code' => 'HUBIN',
        ]);

        $currentVisit = $this->createVisit([
            'ticket_code' => 'JTT-20261019-0002',
            'purpose' => 'Koordinasi Penjajakan MoU PKL Siswa',
            'visit_date' => '2026-10-19',
            'status' => 'approved',
            'department_id' => $department->id,
        ]);

        $pastVisit = $this->createVisit([
            'ticket_code' => 'JTT-20260901-0001',
            'purpose' => 'Penyerahan Proposal PKL',
            'visit_date' => '2026-09-01',
            'status' => 'checked_out',
            'department_id' => $department->id,
            'meeting_result' => 'Proposal diterima untuk ditinjau.',
        ]);

        $otherGuest = $this->createVisit([
            'ticket_code' => 'JTT-20260815-0009',
            'guest_name' => 'Budi Santoso',
            'phone' => '089900112233',
            'email' => 'budi@example.com',
            'visit_date' => '2026-08-15',
            'department_id' => $department->id,
        ]);

        $response = $this->get(route('guest.profile', $currentVisit->ticket_code));

        $response->assertOk();
        $response->assertSee('Profil Tamu');
        $response->assertSee('Rina Wijaya');
        $response->assertSee('081298765432');
        $response->assertSee('Riwayat Tiket Kunjungan');
        $response->assertSee($currentVisit->ticket_code);
        $response->assertSee($pastVisit->ticket_code);
        $response->assertSee('Penyerahan Proposal PKL');
        $response->assertSee('2 Tiket');
        $response->assertDontSee($otherGuest->ticket_code);
    }

    public function test_history_includes_visits_sharing_the_same_email(): void
    {
        $department = Department::create([
            'name' => 'Tata Usaha & Kurikulum',
            'code' => 'TU',
        ]);

        $currentVisit = $this->createVisit([
            'ticket_code' => 'JTT-20261019-0003',
            'visit_date' => '2026-10-19',
            'department_id' => $department->id,
        ]);

        $sameEmailVisit = $this->createVisit([
            'ticket_code' => 'JTT-20260710-0004',
            'phone' => '081200000000',
            'visit_date' => '2026-07-10',
            'department_id' => $department->id,
        ]);

        $response = $this->get(route('guest.profile', $currentVisit->ticket_code));

        $response->assertOk();
        $response->assertSee($sameEmailVisit->ticket_code);
    }

    public function test_guest_profile_page_returns_not_found_for_unknown_ticket_code(): void
    {
        $this->get('/profil/JTT-TIDAK-ADA')->assertNotFound();
    }

    public function test_navbar_profile_button_links_to_last_opened_ticket(): void
    {
        $department = Department::create([
            'name' => 'Tata Usaha & Kurikulum',
            'code' => 'TU',
        ]);

        $visit = $this->createVisit([
            'ticket_code' => 'JTT-20261019-0007',
            'visit_date' => '2026-10-19',
            'department_id' => $department->id,
        ]);

        $this->get(route('guest.register'))
            ->assertOk()
            ->assertSee(route('ticket.lookup'), false);

        $this->get(route('ticket.show', $visit->ticket_code))
            ->assertSessionHas('guest_ticket_code', $visit->ticket_code);

        $this->get(route('guest.register'))
            ->assertOk()
            ->assertSee(route('guest.profile', $visit->ticket_code), false);
    }

    /**
     * @param  array<string, mixed>  $overrides
     */
    private function createVisit(array $overrides = []): GuestVisit
    {
        return GuestVisit::create(array_merge([
            'ticket_code' => 'JTT-20261019-0001',
            'guest_name' => 'Rina Wijaya',
            'institution' => 'PT Astra International',
            'phone' => '081298765432',
            'email' => 'rina@astra.co.id',
            'purpose' => 'Koordinasi PKL',
            'visit_date' => '2026-10-19',
            'scheduled_time' => '09:30',
            'guest_count' => 2,
            'status' => 'pending',
        ], $overrides));
    }
}
