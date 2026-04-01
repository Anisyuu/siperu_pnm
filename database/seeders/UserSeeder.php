<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            'kasubag',
            'sarpras',
            'pimpinan',
            'ormawa',
            'dosen',
            'karyawan',
            'mahasiswa',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'nama' => $role,
            ]);
        }


        User::firstOrCreate(
            ['nomor_induk' => '123654789'],
            [
                'nama_lengkap' => 'Kasubag',
                'email' => 'kasubag@mail.com',
                'password' => Hash::make('aniscantik'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '987456321'],
            [
                'nama_lengkap' => 'Pimpinan',
                'email' => 'pimpinan@mail.com',
                'password' => Hash::make('aniscantik'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '654129871'],
            [
                'nama_lengkap' => 'Sarana (Gedung)',
                'email' => 'sarpras@mail.com',
                'password' => Hash::make('aniscantik'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '233307094'],
            [
                'nama_lengkap' => 'Mahasiswa',
                'email' => 'mahasiswa@mail.com',
                'password' => Hash::make('aniscantikbanget'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '233307095'],
            [
                'nama_lengkap' => 'Ormawa',
                'email' => 'ormawa@mail.com',
                'password' => Hash::make('aniscantikbanget'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '233307096'],
            [
                'nama_lengkap' => 'Dosen',
                'email' => 'dosen@mail.com',
                'password' => Hash::make('aniscantikbanget'),
                'is_active' => 'active',
            ]
        );

        User::firstOrCreate(
            ['nomor_induk' => '233307097'],
            [
                'nama_lengkap' => 'Karyawan',
                'email' => 'karyawan@mail.com',
                'password' => Hash::make('aniscantikbanget'),
                'is_active' => 'active',
            ]
        );


        $superadmin = User::where('nomor_induk', '123654789')->first();
        $pimpinan  = User::where('nomor_induk', '987456321')->first();
        $mahasiswa  = User::where('nomor_induk', '233307094')->first();
        $ormawa     = User::where('nomor_induk', '233307095')->first();
        $dosen      = User::where('nomor_induk', '233307096')->first();
        $karyawan   = User::where('nomor_induk', '233307097')->first();
        $sarpras    = User::where('nomor_induk', '654129871')->first();


        if ($superadmin) {
            $superadmin->syncRoles(['kasubag']);
        }

        if ($pimpinan) {
            $pimpinan->syncRoles(['pimpinan']);
        }

        if ($mahasiswa) {
            $mahasiswa->syncRoles(['mahasiswa']);
        }

        if ($ormawa) {
            $ormawa->syncRoles(['ormawa']);
        }

        if ($dosen) {
            $dosen->syncRoles(['dosen']);
        }

        if ($karyawan) {
            $karyawan->syncRoles(['karyawan']);
        }

        if ($sarpras) {
            $sarpras->syncRoles(['sarpras']);
        }
    }
}
