<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create('id_ID');
        $jk = array('Pria', 'Wanita');
        $status = array('Menikah', 'Lajang');
        $agama = array('Islam', 'Kristen', 'Katholik', 'Buddha', 'Hindu', 'Protestan');
        $permissions = Permission::pluck('id', 'id')->all();

        for ($i = 0; $i <= 2; $i++) {
            // Custom ID generator compatible with existing format
            $prefix = date('ym');
            $lastId = DB::table('pegawai')->orderBy('id', 'desc')->value('id');
            $lastNumber = $lastId ? intval(substr($lastId, 4)) : 0;
            $newNumber = $lastNumber + 1;
            $id = $prefix . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
            $jkp = $faker->numberBetween(0, 1);
            $jbtn = $faker->numberBetween(1, 9);
            $relg = $faker->numberBetween(0, 5);
            $role = [1, 2, 3];
            $email = ['admin@gmail.com', 'hrd@gmail.com', 'staff@gmail.com'];
            $dvs = $faker->numberBetween(2, 4);

            $pegawai = Pegawai::create([
                'id' => $id,
                'id_role' => $role[$i],
                'nik' => $faker->nik(),
                'nama' => $faker->name,
                'jk' => $jk[$jkp],
                'agama' => $agama[$relg],
                'tempat_lahir' => $faker->city,
                'tgl_lahir' => $faker->date,
                'alamat_ktp' => $faker->streetAddress,
                'alamat_dom' => $faker->streetAddress,
                'status' => $status[$jkp],
                'jml_anak' => $relg,
                'no_hp' => $faker->phoneNumber,
                'email' => $email[$i],
                'password' => bcrypt('123456'),
                'tgl_masuk' => $faker->date,
                'id_atasan' => NULL,
                'id_jabatan' => $jbtn,
                'id_divisi' => $dvs,
                'path' => 'foto.jpg'
            ]);

            $pegawai->assignRole([$role[$i]]);
        }
    }
}
