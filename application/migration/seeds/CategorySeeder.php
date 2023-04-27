<?php


use Phinx\Seed\AbstractSeed;

class CategorySeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = 
        [
            [
                'category_name'     => 'Pendidikan',
                'parent_category'   => NULL
            ],
            [
                'category_name'     => 'Buku Bimbingan Belajar',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Buku SD Kelas 1',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Buku SD Kelas 2',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Buku SD Kelas 3',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Buku SD Kelas 4',
                'parent_category'   => 1
            ],
            [
                'category_name'     => 'Buku SD Kelas 5',
                'parent_category'   => 1
            ],
			[
				'category_name'     => 'Buku SD Kelas 6',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMP Kelas 1',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMP Kelas 2',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMP Kelas 3',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMA Kelas 1',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMA Kelas 2',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Buku SMA Kelas 3',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Ensiklopedia',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Kumpulan Soal SD',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Kumpulan Soal SMP',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Kumpulan Soal SMA',
				'parent_category'   => 1
			],
			[
				'category_name'     => 'Religi & Spiritualitas',
				'parent_category'   => NULL
			],
			[
				'category_name'     => 'Agama Islam',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Kristen',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Katolik',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Hindu',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Budha',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Konghucu',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Agama Lainnya',
				'parent_category'   => 19
			],
			[
				'category_name'     => 'Teknik & Sains',
				'parent_category'   => NULL
			],
			[
				'category_name'     => 'Buku Astronomi & Luar Angkasa',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Biologi',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Elektro',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Fisika',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Geografi',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Geologi',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Kimia',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Robotika',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Buku Sipil',
				'parent_category'   => 27
			],
			[
				'category_name'     => 'Arsitektur & Desain',
				'parent_category'   => null
			],
			[
				'category_name'     => 'Buku Bangunan',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Dekorasi Dan Ornamen',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Desain Grafis',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Desain Interior',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Desain Produk',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Desain Web',
				'parent_category'   => 37
			],
			[
				'category_name'     => 'Buku Remaja & Anak',
				'parent_category'   => null
			],
			[
				'category_name'     => 'Buku Aktivitas',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Buku Cerita Anak',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Buku Dongeng',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Buku Dunia Pengetahuan',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Buku Fabel',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Buku Islami Anak',
				'parent_category'   => 44
			],
			[
				'category_name'     => 'Hobi & Keterampilan',
				'parent_category'   => null
			],
			[
				'category_name'     => 'Buku Alam',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Fotografi',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Hewan',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Keterampilan',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Koleksi',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Musik',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Olahraga',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Permainan',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Seni',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Teknologi',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Transportasi',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Wisata',
				'parent_category'   => 51
			],
			[
				'category_name'     => 'Buku Kesehatan',
				'parent_category'   => null
			],
			[
				'category_name'     => 'Buku Kedokteran',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Anak',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Mental',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Wanita',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Umum',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Keluarga',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Lingkungan',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Gigi',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Hewan',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Jiwa',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Olahraga',
				'parent_category'   => 64
			],
			[
				'category_name'     => 'Buku Kesehatan Seksual',
				'parent_category'   => 64
			],

        ];

        $table = $this->table('categories');
        $table->insert($data)->saveData();
    }
}
