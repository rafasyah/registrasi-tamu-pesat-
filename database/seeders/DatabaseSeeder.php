<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\GuestVisit;
use App\Models\Host;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::updateOrCreate(
            ['email' => 'admin@pesat.sch.id'],
            [
                'name' => 'Administrator Buku Tamu',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'resepsionis@pesat.sch.id'],
            [
                'name' => 'Petugas Frontdesk PESAT',
                'password' => Hash::make('password'),
                'role' => 'receptionist',
            ]
        );

        // Departments
        $deptData = [
            ['name' => 'Kepala Sekolah', 'code' => 'KS', 'description' => 'Kantor Kepala SMK PESAT'],
            ['name' => 'Bidang Kurikulum', 'code' => 'KUR', 'description' => 'Akademik & Kurikulum Pembelajaran'],
            ['name' => 'Bidang Kesiswaan', 'code' => 'KSW', 'description' => 'Kedisiplinan, Ekstrakurikuler & Karakter'],
            ['name' => 'Humas & Hubungan Industri', 'code' => 'HMS', 'description' => 'Kemitraan Perusahaan, PKL & BKK'],
            ['name' => 'Tata Usaha & Keuangan', 'code' => 'TU', 'description' => 'Administrasi, Keuangan & Surat Menyurat'],
            ['name' => 'Tim IT & Laboratorium', 'code' => 'IT', 'description' => 'Infrastruktur Komputer & Sistem Informasi'],
            ['name' => 'Perpustakaan & Learning Center', 'code' => 'LIB', 'description' => 'Layanan Literasi & Sumber Belajar'],
            ['name' => 'Dewan Guru / Program Keahlian', 'code' => 'PROG', 'description' => 'Kaprog RPL, TKJ, DKV, Broadcast'],
        ];

        $departments = [];
        foreach ($deptData as $data) {
            $departments[$data['code']] = Department::updateOrCreate(['code' => $data['code']], $data);
        }

        // Hosts
        $hostsData = [
            ['dept' => 'KS', 'nip' => '197508122001', 'name' => 'Drs. H. Ahmad Fauzi, M.Pd', 'position' => 'Kepala Sekolah', 'email' => 'kepsek@pesat.sch.id', 'phone' => '081234567890', 'status' => 'available'],
            ['dept' => 'KUR', 'nip' => '198203152008', 'name' => 'Siti Aminah, S.Kom', 'position' => 'Wakasek Bidang Kurikulum', 'email' => 'siti.aminah@pesat.sch.id', 'phone' => '081298765432', 'status' => 'available'],
            ['dept' => 'KSW', 'nip' => '198511202010', 'name' => 'Rahmat Hidayat, S.T', 'position' => 'Wakasek Bidang Kesiswaan', 'email' => 'rahmat.h@pesat.sch.id', 'phone' => '081311223344', 'status' => 'busy'],
            ['dept' => 'HMS', 'nip' => '198804052014', 'name' => 'Hendra Wijaya, S.Pd', 'position' => 'Kepala Humas & Hubin', 'email' => 'humas@pesat.sch.id', 'phone' => '081555667788', 'status' => 'available'],
            ['dept' => 'TU', 'nip' => '197901102005', 'name' => 'Dewanto, S.E', 'position' => 'Kepala Tata Usaha', 'email' => 'tu@pesat.sch.id', 'phone' => '081799887766', 'status' => 'available'],
            ['dept' => 'PROG', 'nip' => '199009182018', 'name' => 'Budi Santoso, S.Kom', 'position' => 'Kaprog PPLG / RPL', 'email' => 'budi.rpl@pesat.sch.id', 'phone' => '081822334455', 'status' => 'available'],
            ['dept' => 'PROG', 'nip' => '199212012020', 'name' => 'Eka Putri, S.Ds', 'position' => 'Kaprog Desain Komunikasi Visual (DKV)', 'email' => 'eka.dkv@pesat.sch.id', 'phone' => '081933445566', 'status' => 'away'],
            ['dept' => 'IT', 'nip' => '199107142019', 'name' => 'Rizky Pratama, M.Kom', 'position' => 'Koordinator IT & Network Admin', 'email' => 'it@pesat.sch.id', 'phone' => '081122334455', 'status' => 'available'],
        ];

        $hosts = [];
        foreach ($hostsData as $h) {
            $dept = $departments[$h['dept']];
            $hosts[] = Host::updateOrCreate(
                ['nip_nik' => $h['nip']],
                [
                    'department_id' => $dept->id,
                    'name' => $h['name'],
                    'position' => $h['position'],
                    'email' => $h['email'],
                    'phone' => $h['phone'],
                    'status' => $h['status'],
                ]
            );
        }

        // Demo Visits
        $today = date('Y-m-d');

        GuestVisit::updateOrCreate(
            ['ticket_code' => 'JTT-'.date('Ymd').'-0001'],
            [
                'guest_name' => 'Ir. Bambang Sugiarto',
                'institution' => 'PT Telkom Indonesia Tbk',
                'phone' => '081288990011',
                'email' => 'bambang@telkom.co.id',
                'purpose' => 'Vendor / Kerjasama',
                'department_id' => $departments['HMS']->id,
                'host_id' => $hosts[3]->id, // Hendra Wijaya
                'visit_date' => $today,
                'scheduled_time' => '09:00:00',
                'guest_count' => 2,
                'vehicle_number' => 'B 1234 TKM',
                'notes' => 'Pembahasan MoU Prakerin & Sponsorship Lab Fiber Optic',
                'status' => 'checked_in',
                'check_in_at' => now()->subHours(1),
            ]
        );

        GuestVisit::updateOrCreate(
            ['ticket_code' => 'JTT-'.date('Ymd').'-0002'],
            [
                'guest_name' => 'Dra. Endang Susilowati',
                'institution' => 'Dinas Pendidikan Kota Bogor',
                'phone' => '081377889900',
                'email' => 'endang@disdik.bogor.go.id',
                'purpose' => 'Dinas / Kedinasan',
                'department_id' => $departments['KS']->id,
                'host_id' => $hosts[0]->id, // Drs. H. Ahmad Fauzi
                'visit_date' => $today,
                'scheduled_time' => '10:30:00',
                'guest_count' => 3,
                'vehicle_number' => 'F 1002 DIS',
                'notes' => 'Monitoring Asesmen Nasional & Supervisi Sekolah',
                'status' => 'approved',
            ]
        );

        GuestVisit::updateOrCreate(
            ['ticket_code' => 'JTT-'.date('Ymd').'-0003'],
            [
                'guest_name' => 'Maya Kartika, S.Pd',
                'institution' => 'Orang Tua Siswa (Wali Murid XI RPL 1)',
                'phone' => '085711223344',
                'email' => 'maya.k@gmail.com',
                'purpose' => 'Wali Murid',
                'department_id' => $departments['KSW']->id,
                'host_id' => $hosts[2]->id, // Rahmat Hidayat
                'visit_date' => $today,
                'scheduled_time' => '11:00:00',
                'guest_count' => 1,
                'notes' => 'Konsultasi Perkembangan Belajar & Kedisiplinan Siswa',
                'status' => 'pending',
            ]
        );

        GuestVisit::updateOrCreate(
            ['ticket_code' => 'JTT-'.date('Ymd').'-0004'],
            [
                'guest_name' => 'Fikri Ardiansyah',
                'institution' => 'Alumni Angkatan 2023',
                'phone' => '089600112233',
                'email' => 'fikri.dev@gmail.com',
                'purpose' => 'Alumni',
                'department_id' => $departments['TU']->id,
                'host_id' => $hosts[4]->id, // Dewanto
                'visit_date' => $today,
                'scheduled_time' => '08:15:00',
                'guest_count' => 1,
                'notes' => 'Pengambilan Ijazah & Legalisir Berkas',
                'status' => 'checked_out',
                'check_in_at' => now()->subHours(3),
                'check_out_at' => now()->subHours(2),
                'rating' => 5,
                'feedback_comment' => 'Pelayanan cepat dan ramah sekali di bagian TU. Terima kasih PESAT!',
            ]
        );
    }
}
