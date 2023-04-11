<?php
use Phinx\Seed\AbstractSeed;
use Faker\Factory as Faker;

class BookSeeder extends AbstractSeed
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
        $data = [];

        $faker = Faker::create('id_ID');

        for($i=0;$i<=4;$i++)
        {
            $data = [
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'Sinau Basa Jawa SD Kelas 6 K13 Revisi',
					'cover_img'    	=> '5f4c1c8a97fbbf9a6379d2a2d5d14eca.jpg',
					'author'       	=> 'Sri Wahyuni',
					'isbn'			=> '9786020310001',
					'publish_year'	=> '2018',
					'category_id'	=> 6,
					'publisher_id'	=> 1,
					'description'	=> 'Buku ini merupakan buku pelajaran yang dikhususkan untuk siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi. Buku ini berisi materi-materi yang dibagi menjadi 10 bab, yaitu: 1. Kata Kerja, 2. Kata Sifat, 3. Kata Benda, 4. Kata Ganti, 5. Kalimat, 6. Kalimat Tanya, 7. Kalimat Perintah, 8. Kalimat Sifat, 9. Kalimat Tanya Sifat, dan 10. Kalimat Perintah Sifat. Setiap bab diawali dengan materi yang berisi penjelasan tentang materi yang akan dipelajari, contoh-contoh, dan latihan soal. Setelah itu, siswa akan diberikan latihan soal yang lebih banyak dan lebih rumit. Setiap bab diakhiri dengan latihan soal yang lebih rumit lagi. Buku ini juga dilengkapi dengan kunci jawaban yang dapat digunakan untuk memeriksa jawaban siswa. Buku ini dapat digunakan oleh siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi.',
					'qty'			=> 5
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'Bhs. Indonesia 1 SMP/Mts Kelas VII Kur. Merdeka',
					'cover_img'    	=> '529af9ef9ae8d6dc362a024a7231cbbb.jpg',
					'author'       	=> 'E.B Devitta Ekawati, Indah Wukir Setiarini',
					'isbn'			=> '9786020310002',
					'publish_year'	=> '2022',
					'category_id'	=> 5,
					'publisher_id'	=> 1,
					'description'	=> 'Buku ini merupakan buku pelajaran yang dikhususkan untuk siswa kelas 7 SMP/MTs yang mengikuti kurikulum 2013 revisi. Buku ini berisi materi-materi yang dibagi menjadi 10 bab, yaitu: 1. Kata Kerja, 2. Kata Sifat, 3. Kata Benda, 4. Kata Ganti, 5. Kalimat, 6. Kalimat Tanya, 7. Kalimat Perintah, 8. Kalimat Sifat, 9. Kalimat Tanya Sifat, dan 10. Kalimat Perintah Sifat. Setiap bab diawali dengan materi yang berisi penjelasan tentang materi yang akan dipelajari, contoh-contoh, dan latihan soal. Setelah itu, siswa akan diberikan latihan soal yang lebih banyak dan lebih rumit. Setiap bab diakhiri dengan latihan soal yang lebih rumit lagi. Buku ini juga dilengkapi dengan kunci jawaban yang dapat digunakan untuk memeriksa jawaban siswa. Buku ini dapat digunakan oleh siswa kelas 7 SMP/MTs yang mengikuti kurikulum 2013 revisi.',
					'qty'			=> 4
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'Senang Belajar PPKn SD Kelas 6 K13 Revisi',
					'cover_img'    	=> '8419f965f5089e31e9719cf816840e31.jpg',
					'author'       	=> 'Sri Wahyuni',
					'isbn'			=> '9786020310003',
					'publish_year'	=> '2021',
					'category_id'	=> 6,
					'publisher_id'	=> 1,
					'description'	=> 'Buku ini merupakan buku pelajaran yang dikhususkan untuk siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi. Buku ini berisi materi-materi yang dibagi menjadi 10 bab, yaitu: 1. Kata Kerja, 2. Kata Sifat, 3. Kata Benda, 4. Kata Ganti, 5. Kalimat, 6. Kalimat Tanya, 7. Kalimat Perintah, 8. Kalimat Sifat, 9. Kalimat Tanya Sifat, dan 10. Kalimat Perintah Sifat. Setiap bab diawali dengan materi yang berisi penjelasan tentang materi yang akan dipelajari, contoh-contoh, dan latihan soal. Setelah itu, siswa akan diberikan latihan soal yang lebih banyak dan lebih rumit. Setiap bab diakhiri dengan latihan soal yang lebih rumit lagi. Buku ini juga dilengkapi dengan kunci jawaban yang dapat digunakan untuk memeriksa jawaban siswa. Buku ini dapat digunakan oleh siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi.',
					'qty'			=> 3
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'IPA 1 SMP/Mts Kelas VII Kur. Merdeka',
					'cover_img'    	=> '12405a0f13ff2a93edf8fc96383dda05.jpg',
					'author'		=> 'Dina Kurniawati dkk.',
					'isbn'			=> '9786020310004',
					'publish_year'	=> '2020',
					'category_id'	=> 5,
					'publisher_id'	=> 1,
					'description'	=> 'Buku ini merupakan buku pelajaran yang dikhususkan untuk siswa kelas 7 SMP/MTs yang mengikuti kurikulum 2013 revisi. Buku ini berisi materi-materi yang dibagi menjadi 10 bab, yaitu: 1. Kata Kerja, 2. Kata Sifat, 3. Kata Benda, 4. Kata Ganti, 5. Kalimat, 6. Kalimat Tanya, 7. Kalimat Perintah, 8. Kalimat Sifat, 9. Kalimat Tanya Sifat, dan 10. Kalimat Perintah Sifat. Setiap bab diawali dengan materi yang berisi penjelasan tentang materi yang akan dipelajari, contoh-contoh, dan latihan soal. Setelah itu, siswa akan diberikan latihan soal yang lebih banyak dan lebih rumit. Setiap bab diakhiri dengan latihan soal yang lebih rumit lagi. Buku ini juga dilengkapi dengan kunci jawaban yang dapat digunakan untuk memeriksa jawaban siswa. Buku ini dapat digunakan oleh siswa kelas 7 SMP/MTs yang mengikuti kurikulum 2013 revisi.',
					'qty'			=> 2
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'Jelajah Sains SD Kelas 6 K13 Revisi',
					'cover_img'		=> 'fde0e522fa00da1468dbcc84e89f01e9.jpg',
					'author'		=> 'Dian Oki Valerina',
					'isbn'			=> '9786020310005',
					'publish_year'	=> '2019',
					'category_id'	=> 6,
					'publisher_id'	=> 1,
					'description'	=> 'Buku ini merupakan buku pelajaran yang dikhususkan untuk siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi. Buku ini berisi materi-materi yang dibagi menjadi 10 bab, yaitu: 1. Kata Kerja, 2. Kata Sifat, 3. Kata Benda, 4. Kata Ganti, 5. Kalimat, 6. Kalimat Tanya, 7. Kalimat Perintah, 8. Kalimat Sifat, 9. Kalimat Tanya Sifat, dan 10. Kalimat Perintah Sifat. Setiap bab diawali dengan materi yang berisi penjelasan tentang materi yang akan dipelajari, contoh-contoh, dan latihan soal. Setelah itu, siswa akan diberikan latihan soal yang lebih banyak dan lebih rumit. Setiap bab diakhiri dengan latihan soal yang lebih rumit lagi. Buku ini juga dilengkapi dengan kunci jawaban yang dapat digunakan untuk memeriksa jawaban siswa. Buku ini dapat digunakan oleh siswa kelas 6 SD yang mengikuti kurikulum 2013 revisi.',
					'qty'			=> 1
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'SD - Buku Teks Pendamping - Buku Siswa Tema 3: Kegiatanku Kelas I SD/MI',
					'cover_img'		=> 'Tema 3 Kegiatanku.jpg',
					'author'		=> 'Nuki Rusiyani, Ria Nita Fatimah',
					'isbn'			=> '-',
					'publish_year'	=> '2023',
					'category_id'	=> 2,
					'publisher_id'	=> 4,
					'description'	=> 'Buku siswa tematik kelas 1 ini merupakan buku panduan sekaligus buku aktivitas yang akan membantu siswa terlibat aktif dalam pembelajaran. Cara pembelajaran yang dianjurkan dalam Buku siswa tematik ini adalah berbasis kegiatan, bersifat interaktif, dan partisipatif. Buku ini juga dapat digunakan oleh orang tua secara mandiri untuk mendukung aktivitas belajar siswa di rumah. Orang tua diharapkan berdiskusi dan terlibat dalam aktivitas belajar kalian. Struktur buku siswa tematik untuk SD/MI Kelas I ini memfasilitasi pengalaman belajar yang bermakna dan diterjemahkan melalui rubrik berbasis aktivitas, sepertiayo amati, ayo bermain peran, ayo berlatih, ayo ceritakan, ayo berkreasi, ayo menulis, ayo membaca, ayo bernyanyi, ayo kerjakan, ayo berdiskusi, ayo memasangkan, ayo menghubungkan, ayo cari tahu, ayo menghitung, dan belajar bersama orang tua.',
					'qty'			=> 3
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'PR Kelas II Tema 1: Hidup Rukun',
					'cover_img'		=> 'I1PR7T21CD.jpg',
					'author'		=> 'Dewi Agustina, Dwi Martini Sari, Eis Puspita',
					'isbn'			=> '-',
					'publish_year'	=> '2023',
					'category_id'	=> 2,
					'publisher_id'	=> 4,
					'description'	=> 'Pembelajaran di SD sesuai dengan Kurikulum 2013 adalah pembelajaran tematik. Siswa tidak lagi belajar mata pelajaran per mata pelajaran. Oleh karena itu, siswa perlu dituntun. Salah satu sarananya adalah buku PR Tematik. PR Tematik Kelas II Tema 1: Hidup Rukun ini terdiri atas empat subtema. Pada bagian awal disajikan apersepsi berupa gambar dan percakapan. Materi dalam apersepsi akan dibahas pada buku ini. Kemudian, setiap subtema terdiri atas enam pembelajaran. Dalam setiap pembelajaran terdiri atas penanaman konsep, kegiatan, dan uji kompetensi. Pada setiap akhir pembelajaran disajikan Ulangan Harian sebagai sarana siswa untuk mengetes kemampuannya menyerap materi yang disajikan. Glosarium yang disajikan pada akhir buku dimaksudkan untuk membantu siswa memahami kata sulit atau kata-kata yang baru dikenalnya. Dengan begitu, siswa akan mudah memahami bacaan atau materi yang tersaji dalam buku ini.',
					'qty'			=> 5
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'PR Kelas III Tema 2: Menyayangi Hewan dan Tumbuhan',
					'cover_img'		=> 'I1PR9T32CD.jpg',
					'author'		=> 'Dewi Agustina, Dini Fima Udari, Dwi Martina Dewi',
					'isbn'			=> '-',
					'publish_year'	=> '2023',
					'category_id'	=> 4,
					'publisher_id'	=> 6,
					'description'	=> '',
					'qty'			=> 2
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title'	 		=> 'Buku Interaktif-PAI dan Budi Pekerti Kelas IV SD/MI',
					'cover_img'		=> 'I1MD2EPAI04.jpg',
					'author'		=> 'Azizah Niki Purnami, Ma\'sumatul Ni\'mah',
					'isbn'			=> '-',
					'publish_year'	=> '2023',
					'category_id'	=> 5,
					'publisher_id'	=> 6,
					'description'	=> '',
					'qty' 			=> 1
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title' 		=> 'Buku Interaktif-Pendidikan Pancasila Kelas IV SD/MI',
					'cover_img'		=> 'I1MD2EPKN04.jpg',
					'author'		=> 'Erni Fitri Astuti, Faizah Nur Diana',
					'isbn'			=> '-',
					'publish_year'	=> '2023',
					'category_id'	=> 5,
					'publisher_id'	=> 6,
					'description'	=> '',
					'qty'			=> 1
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title' 		=> 'Ilmu Pengetahuan Alam dan Sosial untuk SD Kelas 5',
					'cover_img'		=> 'mnuxu5vibvzbwnjflvudip.jpg',
					'author'		=> 'Amalia Fitri Ghaniem, Anggayudha A. Rasa, Ati H. Oktora, Miranda Yasella',
					'isbn'			=> '9786022446811',
					'publish_year'	=> '2023',
					'category_id'	=> 2,
					'publisher_id'	=> 6,
					'description'	=> 'Deskripsi Buku
					Pendidikan selayaknya berperan dalam membekali kalian dalam peranannya di masa yang akan datang. Untuk itu proses pembelajaran perlu dirancang agar mengasah kemampuan dan potensi dari segi akademik maupun non akademik. Semuanya bertujuan agar kalian memiliki keterampilan yang sesuai dengan kebutuhan abad 21. Hal ini selaras dengan program Merdeka Belajar dari Kementerian Pendidikan, Kebudayaan, Riset, dan Teknologi yang memberikan keleluasan bagi siswa dan guru untuk menentukan tujuan belajar sesuai dengan kebutuhan dan perkembangannya.
					
					Adanya buku ini diharapkan mendorong terjadinya revolusi pendidikan dan semangat merdeka belajar bagi guru dan siswa. Dalam buku ini kalian akan belajar:
					
					1. Melakukan penyelidikan ilmiah dan menganalisis hasilnya untuk memahami ilmu alam dan sosial dengan lebih baik.
					
					2. Berkolaborasi dengan teman dalam mencapai tujuan pembelajaran membuat proyek belajar secara mandiri.
					
					Komponen-komponen dalam buku ini akan membekali kalian untuk pembelajar yang percaya diri, kritis, dan menjadi pribadi yang menampilkan profil Pelajar Pancasila.
					
					Tantangan mempelajari bidang keilmuan IPAS senantiasa berkembang dari waktu ke waktu yang tentunya memengaruhi cara belajar peserta didik. Buku ini mengelaborasikan pemahaman-pemahaman esensial dengan ragam aktivitas yang diharapkan mampu menstimulus keingintahuan peserta didik terhadap topik-topik seputar fenomena alam dan sosial di sekitarnya sehingga peserta. didik termotivasi untuk belajar lebih lanjut secara mandiri. Semoga buku ini dapat memberikan kontribusi yang nyata dalam membantu peserta didik mencapai kompetensinya sehingga berdampak terhadap kemajuan pendidikan IPAS tingkat dasar di Indonesia. Penulis menantikan kritik dan masukan yang membangun untuk perbaikan buku ini di masa yang akan datang.
					
					Informasi Tambahan
					
					Cetakan 1, 2021',
					'qty'			=> 4
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title' 		=> 'Bahasa Indonesia : Keluargaku Unik untuk SD Kelas 2',
					'cover_img'		=> 'tzatrcm4uz7qd94ydkpwhs.jpg',
					'author'		=> 'Widjati Hartiningtyas, Eni Priyanti',
					'isbn'			=> '9786022446309',
					'publish_year'	=> '2023',
					'category_id'	=> 5,
					'publisher_id'	=> 7,
					'description'	=> 'Bahasa Indonesia Keluargaku Unik

					Di kelas dua, para peserta didik akan mempelajari hal-hal baru dan meningkatkan kemampuan berbahasa mereka dengan cara yang menyenangkan. Melalui buku Bahasa Indonesia Keluargaku Unik, peserta didik kelas dua akan melakukan kegiatan menyimak, membaca, berbicara, dan menulis melalui cerita, teks informasi, serta gambar-gambar yang menarik.
					
					Buku Siswa ini akan menemani peserta didik melatih cara berpikir kritis, mengemukakan pendapat secara lisan dan tertulis, berdiskusi, mendapatkan informasi melalui kegiatan menyimak, membaca, dan mengamati. Bacaan yang beragam di dalam buku ini diharapkan dapat menumbuhkan kecintaan membaca peserta didik.
					
					Tentu saja Buku Siswa ini tidak menjadi satu-satunya bahan mengajar. Guru disarankan untuk menggunakan perangkat ajar dan sumber bacaan lain yang menampilkan budaya dan keindahan alam setempat. Dengan begitu, peserta didik tak hanya memiliki keterampilan berbahasa terhadap budaya dan bangsa.
					Indonesia yang baik, tetapi juga kecintaan
					
					Pusat Perbukuan; Badan Standar, Kurikulum, dan Asesmen Pendidikan; Kementerian Pendidikan, Kebudayaan, Riset dan Teknologi sesuai tugas dan fungsinya mengembangkan kurikulum yang mengusung semangat merdeka belajar mulai dari satuan Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah. Kurikulum ini memberikan keleluasaan bagi satuan pendidikan dalam mengembangkan potensi yang dimiliki oleh peserta didik. Untuk mendukung pelaksanaan kurikulum tersebut, sesuai Undang-Undang Nomor 3 tahun 2017 tentang Sistem Perbukuan, pemerintah dalam hal ini Pusat Perbukuan memiliki tugas untuk menyiapkan Buku Teks Utama.
					
					Buku teks ini merupakan salah satu sumber belajar utama untuk digunakan pada satuan pendidikan. Adapun acuan penyusunan buku adalah Keputusan Menteri Pendidikan dan Kebudayaan Republik Indonesia Nomor 958/P/2020 tentang Capaian Pembelajaran pada Pendidikan Anak Usia Dini, Pendidikan Dasar, dan Pendidikan Menengah. Sajian buku dirancang dalam bentuk berbagai aktivitas pembelajaran untuk mencapai kompetensi dalam Capaian Pembelajaran tersebut. Penggunaan buku teks ini dilakukan secara bertahap pada Sekolah Penggerak, sesuai dengan Keputusan Menteri Pendidikan dan Kebudayaan Nomor 162/M/2021 tentang Program Sekolah Penggerak.
					
					Sebagai dokumen hidup, buku ini tentunya dapat diperbaiki dan disesuaikan dengan kebutuhan. Oleh karena itu, saran-saran dan masukan dari para guru, peserta didik, orang tua, dan masyarakat sangat dibutuhkan untuk penyempurnaan buku teks ini. Pada kesempatan ini, Pusat Perbukuan mengucapkan terima kasih kepada semua pihak yang telah terlibat dalam penyusunan buku ini mulai dari penulis, penelaah, penyunting, ilustrator, desainer, dan pihak terkait lainnya yang tidak dapat disebutkan satu per satu. Semoga buku ini dapat bermanfaat khususnya bagi peserta didik dan guru dalam meningkatkan mutu pembelajaran.',
					'qty'			=> 4
				],
				[
					'book_code'		=> bin2hex(random_bytes(4)),
					'title' 		=> 'Bank Soal + Soal Hots Superlengkap Matematika Sd/Mi Kelas 4,',
					'cover_img'		=> 'qk6dqv8usmbkk9f268dogp.jpg',
					'author'		=> 'Uly Amalia Dkk',
					'isbn'			=> '9786026725653',
					'publish_year'	=> '2023',
					'category_id'	=> 5,
					'publisher_id'	=> 7,
					'description'	=> 'BANK SOAL SOAL HOTS (HIGHER ORDER

					SUPERLENGKAP MATEMATIKA
					
					SD/MI KELAS 4, 5, & 6
					
					Membaca materi supaya tahu. berlatih mengerjakan soal supaya paham. Membaca dan berlatih adalah dua hal penting yang harus dilalui siswa untuk mendapatkan nilai terbaik. Pengetahuan dasar yang dibaca, apabila tidak lanjut digunakan dengan mengerjakan soal, akan sulit untuk tersimpan dalam pemahaman siswa. Dengan cara membaca dan mengerjakan soal, siswa diharapkan akan memiliki yang telah pengetahuan komprehensif karena menguasai kemampuan berpikir dan memahami materi sekaligus
					
					kemampuan memecahkan masalah yang dijabarkan pada soal.
					
					Buku Bank Soal Superlengkap Matematika SD/MI Kelas 4, 5, & 6 memberikan kesempatan bagi siswa untuk belajar dan berlatih memecahkan permasalahan yang diajukan pada soal. Buku ini menyajikan materi pelajaran Matematika berdasarkan poin-poin penting dari kelas 4, 5, & 6 yang disusun ringkas, disertai trik smart mengerjakan soal, contoh soal plus pembahasan, soal pendalaman materi, soal latihan plus kunci jawaban, paket soal-bahas US/M, dan paket prediksi soal-kunci jawaban US/M. Semoga dengan belajar dan berlatih, siswa yang membaca buku ini dapat sukses meraih nilai terbaik saat menghadapi ujian dan asesmen di kemudian hari.
					Untuk bisa mengerjakan soal-soal ujian, tentu siswa tidak hanya belajar menghafal atau memahami materinya saja, tapi diperlukan juga soal-soal latihan agar siswa terlatih dan terbiasa mengerjakan soal. Seperti peribahasa yang mengatakan "tajam pisau karena diasah" Peribahasa itu bisa diartikan jika kita berlatih mengerjakan soal terus-menerus, kita akan terlatih menyelesaikan soal dengan tepat dan semakin paham akan konsep materi yang sedang dipelajari.
					
					Buku Bank Soal Superlengkap Matematika SD/MI Kelas 4, 5, & 6 ini adalah buku yang tepat dijadikan pegangan bagi siswa untuk berlatih mengerjakan soal-soal, karena selain bervariasi tingkat kesulitannya, juga bervariasi sumber soalnya. Soal-soal dalam buku diambil dari soal-soal penilaian harian, penilaian akhir semester, penilaian akhir tahun, dan ujian sekolah/madrasah (US/M). Harapannya, dengan soal yang bervariasi, siswa siap menghadapi berbagai ujian di sekolah. Soal-soal dalam buku ini dibahas secara detail, lengkap, dan mudah dipahami. Selain cara yang biasa, ada juga cara cepat atau trik smart mengerjakan soal
					
					Buku ini dilengkapi juga dengan materi pelajaran matematika yang diringkas berdasarkan poin-poin penting yang harus dikuasai siswa. Sebagai bahan pemantapan dalam menghadapi US/M, dalam buku ini disajikan pula paket soal US/M beserta pemibahasannya.
					
					Selamat berlatih mengerjakan soal!',
					'qty'			=> 4
				]
            ];
        }

        $table = $this->table('books');
        $table->insert($data)->saveData();
    }
}
