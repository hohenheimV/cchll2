<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Hardscape;
use App\Model\HardscapeRecord;
use Faker\Generator as Faker;

$factory->define(Hardscape::class, function (Faker $faker) {

    $array = [
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Air Pancur"],
        ["kategori" => "Perabut Taman", "jenis" => "Air Pancur"],
        ["kategori" => "Fasiliti Sukan & Rekreasi", "jenis" => "Alat Permainan"],
        ["kategori" => "Perabot Landskap", "jenis" => "Alat Permainan Kanak-Kanak"],
        ["kategori" => "Fasiliti Sukan & Rekreasi", "jenis" => "Alat Permainan Kanak-Kanak"],
        ["kategori" => "Fasiliti Sukan & Rekreasi", "jenis" => "Alat Senaman"],
        ["kategori" => "Landskap Kejur", "jenis" => "Alat Sukan Riang"],
        ["kategori" => "Landskap Kejur", "jenis" => "Alatan Permainan Kanak-Kanak"],
        ["kategori" => "Landskap Kejur", "jenis" => "Arca"],
        ["kategori" => "Fasiliti Hiasan", "jenis" => "Arca"],
        ["kategori" => "Perabut Taman", "jenis" => "Arca"],
        ["kategori" => "Monument - Antikuiti", "jenis" => "Arca"],
        ["kategori" => "Perabot Landskap", "jenis" => "Bangku"],
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Dewan"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Dewan Serbaguna"],
        ["kategori" => "Perabot Landskap", "jenis" => "Dogi Ball"],
        ["kategori" => "Perabot Landskap", "jenis" => "Downlight"],
        ["kategori" => "Infrastruktur & Prasarana", "jenis" => "Drain Sump"],
        ["kategori" => "Infrastruktur & Prasarana", "jenis" => "Elektrik Box"],
        ["kategori" => "Landskap Kejur", "jenis" => "Elemen Air"],
        ["kategori" => "Fasiliti Ruang Terbuka", "jenis" => "Foyer"],
        ["kategori" => "Perabut Taman", "jenis" => "Gazebo"],
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Gazebo"],
        ["kategori" => "Perabot Landskap", "jenis" => "Gazebo / Struktur Tensil"],
        ["kategori" => "Landskap Kejur", "jenis" => "Gelanggang Serbaguna"],
        ["kategori" => "Landskap Kejur", "jenis" => "Gelanggang Sukan & Rekreasi"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Gerai"],
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Gerai"],
        ["kategori" => "Fasiliti Hiasan", "jenis" => "Gerbang"],
        ["kategori" => "Monument - Antikuiti", "jenis" => "Gua"],
        ["kategori" => "Infrastruktur & Prasarana", "jenis" => "Jambatan"],
        ["kategori" => "Infrastruktur & Prasarana", "jenis" => "Jambatan"],
        ["kategori" => "Landskap Kejur", "jenis" => "Jambatan / Jejantas"],
        ["kategori" => "Landskap Kejur", "jenis" => "Kabel Elektrik"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Kafe / Kiosk"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Kaunter Pertanyaan / Maklumat"],
        ["kategori" => "Fasiliti Ruang Terbuka", "jenis" => "Kawasan Lapang"],
        ["kategori" => "Perabut Taman", "jenis" => "Kotak Tanaman"],
        ["kategori" => "Perabot Landskap", "jenis" => "Kotak Tanaman + Tempat Duduk"],
        ["kategori" => "Perabot Landskap", "jenis" => "Lampu Limpah"],
        ["kategori" => "Perabot Landskap", "jenis" => "Lampu Limpah / Uplight / Downlight"],
        ["kategori" => "Perabot Landskap", "jenis" => "Papan Tanda"],
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Papan Tanda"],
        ["kategori" => "Landskap Kejur", "jenis" => "Pasu-Pasuan"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Stesen Tolok Hujan"],
        ["kategori" => "Perabut Taman", "jenis" => "Stesen Trem"],
        ["kategori" => "Bangunan Kemudahan Awam", "jenis" => "Stesen Trem"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Stor"],
        ["kategori" => "Infrastruktur & Prasarana", "jenis" => "Telco"],
        ["kategori" => "Kemudahan Awam", "jenis" => "Tembok"],
        ["kategori" => "Fasiliti Hiasan", "jenis" => "Tembok"],
        ["kategori" => "Landskap Kejur", "jenis" => "Tembok Barbeku"],
        ["kategori" => "Perabot Landskap", "jenis" => "Tiang"],
        ["kategori" => "Perabot Landskap", "jenis" => "Tong Sampah"],
        ["kategori" => "Landskap Kejur", "jenis" => "Utility"],
        ["kategori" => "Perabot Landskap", "jenis" => "Wakaf"]
    ];

    $ran = $faker->numberBetween(0, 55);
    $year = $faker->randomElement(['2018', '2019']);

    return [
        'kod_tag' => $faker->unique()->numberBetween(1000, 5000),
        'no_rujukan' => $faker->unique()->isbn10(),
        'lat' => $faker->latitude(3.147900, 3.148899),
        'lng' => $faker->longitude(101.632100, 101.632399),
        'jenis_komponen' => $array[$ran]['kategori'],
        'nama_struktur' => $array[$ran]['jenis'],
        'gambar_lengkap' => 'gambar_lengkap.png',
        'keadaan_semasa' => 'Baik',
        'tarikh' => $faker->date($year . '-m-d h:i:s'),
        'tahun_bina' => $year,
        'kos_pembinaan' => $faker->randomFloat(2, 1000, 5000),
    ];
});
