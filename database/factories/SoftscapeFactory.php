<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Softscape;
use App\Model\SoftscapeRecord;
use Faker\Generator as Faker;

$factory->define(Softscape::class, function (Faker $faker) {


    $array = [
        ["jenis" => "Pokok Renek", "nama_tempatan" => "Spider Lily, White Spice", "nama_keluarga" => "Hymenocallis speciosa"],
        ["jenis" => "Pokok Palma", "nama_tempatan" => "Solitaire Palm", "nama_keluarga" => "Ptychosperma elegans"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Chengal Pasir", "nama_keluarga" => "Hopea odorata"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Rain Tree, Pukul Lima, Cow Tamarind", "nama_keluarga" => "Samanea saman"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Chekring, Coral Bean", "nama_keluarga" => "Erythrina fusca"],
        ["jenis" => "Pokok Renek", "nama_tempatan" => "Chinese fringe flower", "nama_keluarga" => "Loropetalum chinense var. rubrum"],
        ["jenis" => "Pokok Renek", "nama_tempatan" => "Anahaw Palm", "nama_keluarga" => "Livistona rotundifolia"],
        ["jenis" => "Pokok Renek", "nama_tempatan" => "Spider Lily, White Spice", "nama_keluarga" => "Hymenocallis speciosa"],
        ["jenis" => "Pokok Renek", "nama_tempatan" => "Chinese fringe flower", "nama_keluarga" => "Loropetalum chinense var. rubrum"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Rain Tree, Pukul Lima, Cow Tamarind", "nama_keluarga" => "Samanea saman"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Broad-Leaved Mahogany", "nama_keluarga" => "Swietenia macrophylla"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Tembusu", "nama_keluarga" => "Fagraea fragrans"],
        ["jenis" => "Pokok Ameniti", "nama_tempatan" => "Fern Tree, Fern-Leaf Tree", "nama_keluarga" => "Filicium decipiens"]
    ];

    $ran = $faker->randomElement([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12]);
    $year = $faker->randomElement(['2018', '2019']);
    return [
        'kod_tag' => $faker->unique()->numberBetween(1000, 5000),
        'no_rujukan' => $faker->unique()->isbn10(),
        'lat' => $faker->latitude(3.147900, 3.148899),
        'lng' => $faker->longitude(101.632100, 101.632399),
        'jenis' => $array[$ran]['jenis'], //$faker->word(),
        'nama_botani' => $array[$ran]['nama_keluarga'], //$faker->randomElement(['2018', '2019']),
        'nama_tempatan' => $array[$ran]['nama_tempatan'], //$faker->randomElement(['2018', '2019']),
        'nama_keluarga' => $array[$ran]['nama_keluarga'], //$faker->randomElement(['2018', '2019']),
        'keadaan_semasa' => 'Baik',
        'tarikh' => $faker->date($year . '-m-d h:i:s'),
        'tahun_tanam' => $year,
        'kos_perolehan' => $faker->randomFloat(2, 100, 500),
        'keterangan' => $array[$ran]['nama_tempatan'] . ' merupakan sejenis pokok dalam genus Acacia yang malar hijau yang tumbuh di Asia. Nama saintifiknya adalah Acacia auriculiformis. Pokok Akasiac("Acacia auriculiformis"), biasanya dikenali sebagai Auri, Earleaf acacia, Earpod wattle, Wattle hitam utara, Wattle Papua, Wattle Tan, merupakan pokok bengkok cepat tumbuh dalam keluarga Fabaceae. Ia tempatah di Australia, Indonesia, dan Papua New Guinea. Ia tumbuh sehingga ketinggian 30 meter. Acacia auriculiformis has about 47 000 seeds/kg.',
    ];
});
