<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. AKUN ADMIN PERPUSTAKAAN (PUSTAKAWAN)
        if (!User::where('email', 'admin@gmail.com')->exists()) {
            User::create([
                'name' => 'Pustakawan Kelompok 13',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'admin', // --- PERBAIKAN: Set role admin ---
            ]);
        }

        // --- TAMBAHAN: AKUN USER BIASA (Untuk Tes Login) ---
        if (!User::where('email', 'user@gmail.com')->exists()) {
            User::create([
                'name' => 'Mahasiswa Teladan',
                'email' => 'user@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'user', // --- Set role user ---
            ]);
        }

        // 2. KONTEN E-LIBRARY (21 Item: Buku, Event, Info)
        $posts = [
            // --- SLIDE UTAMA (Highlight) ---
            [
                'title'    => 'Selamat Datang di Portal E-Library Kelompok 13',
                'author'   => 'Kepala Pustakawan',
                'category' => 'Info Layanan',
                'excerpt'  => 'Akses ribuan koleksi buku digital, jurnal ilmiah, dan informasi literasi terkini langsung dari gadgetmu.',
                'body'     => 'Perpustakaan kini hadir dalam genggaman. Kami menyediakan katalog buku lengkap, ruang baca yang nyaman, dan akses jurnal internasional untuk mahasiswa. Mari budayakan membaca demi masa depan yang cerah. Gunakan fasilitas pencarian untuk menemukan buku favoritmu.',
                'image'    => 'https://picsum.photos/seed/library1/1000/600', 
            ],
            [
                'title'    => 'Bedah Buku: Filosofi Teras karya Henry Manampiring',
                'author'   => 'Nadine Ariesta',
                'category' => 'Event',
                'excerpt'  => 'Ikuti keseruan diskusi tentang Stoikisme dan mental yang tangguh menghadapi masalah hidup ala filsuf Romawi.',
                'body'     => 'Buku Filosofi Teras mengajarkan kita untuk fokus pada apa yang bisa kita kendalikan. Acara bedah buku ini akan menghadirkan narasumber ahli psikologi. Jangan sampai ketinggalan, kuota terbatas! Pendaftaran bisa dilakukan di meja sirkulasi.',
                'image'    => 'https://picsum.photos/seed/filosofi/1000/600',
            ],
            [
                'title'    => 'Koleksi Terbaru: Novel Best Seller Bulan Ini',
                'author'   => 'Ermas Muhammad',
                'category' => 'Koleksi Baru',
                'excerpt'  => 'Daftar novel fiksi dan non-fiksi yang baru saja mendarat di rak perpustakaan kami. Pinjam sekarang!',
                'body'     => 'Kami baru saja menambahkan koleksi dari penulis ternama seperti Tere Liye, Dee Lestari, dan J.K. Rowling. Segera cek ketersediaannya di katalog online sebelum dipinjam orang lain. Batas peminjaman adalah 7 hari.',
                'image'    => 'https://picsum.photos/seed/bookshelf/1000/600',
            ],

            // --- GRID BAWAH (18 Artikel Tambahan) ---
            [
                'title'    => '5 Tips Merawat Buku Agar Tidak Menguning',
                'author'   => 'Muhammad Yazid',
                'category' => 'Tips Literasi',
                'excerpt'  => 'Jangan biarkan koleksi bukumu rusak dan dimakan rayap. Simak cara menyimpannya dengan benar.',
                'body'     => 'Hindari paparan sinar matahari langsung dan gunakan silica gel di lemari buku. Sering-seringlah membersihkan debu agar buku tetap awet puluhan tahun. Jangan melipat halaman buku sebagai penanda, gunakan bookmark.',
                'image'    => 'https://picsum.photos/seed/oldbook/800/600',
            ],
            [
                'title'    => 'Resensi Novel: Laskar Pelangi',
                'author'   => 'Nadine Ariesta',
                'category' => 'Resensi',
                'excerpt'  => 'Kisah inspiratif perjuangan anak-anak Belitung dalam menggapai mimpi di tengah keterbatasan.',
                'body'     => 'Andrea Hirata berhasil memotret pendidikan di Indonesia dengan sangat apik. Buku ini mengajarkan kita arti pantang menyerah dan persahabatan yang tulus. Wajib dibaca oleh setiap mahasiswa.',
                'image'    => 'https://picsum.photos/seed/laskar/800/600',
            ],
            [
                'title'    => 'Cara Mendaftar Keanggotaan Perpustakaan',
                'author'   => 'Admin Perpus',
                'category' => 'Info Layanan',
                'excerpt'  => 'Syarat dan ketentuan pembuatan kartu anggota bagi mahasiswa baru angkatan tahun ini.',
                'body'     => 'Bawa KTM (Kartu Tanda Mahasiswa) dan pas foto 3x4. Pendaftaran gratis dan kartu bisa langsung jadi dalam 15 menit. Kartu ini bisa digunakan untuk meminjam buku dan akses wifi kencang.',
                'image'    => 'https://picsum.photos/seed/card/800/600',
            ],
            [
                'title'    => 'Mengenal Dewey Decimal Classification (DDC)',
                'author'   => 'Ermas Muhammad',
                'category' => 'Tips Literasi',
                'excerpt'  => 'Bingung mencari letak buku di rak? Pahami kode angka di punggung buku agar tidak tersesat.',
                'body'     => 'Sistem DDC mengelompokkan buku berdasarkan subjek. Misalnya, 000 untuk Komputer, 800 untuk Sastra, dan 900 untuk Sejarah. Memahami ini akan mempercepat pencarian referensimu.',
                'image'    => 'https://picsum.photos/seed/ddc/800/600',
            ],
            [
                'title'    => 'Review Buku: Atomic Habits',
                'author'   => 'Muhammad Yazid',
                'category' => 'Resensi',
                'excerpt'  => 'Perubahan kecil yang memberikan hasil luar biasa dalam hidup. Buku wajib pengembangan diri.',
                'body'     => 'James Clear menjelaskan bahwa kesuksesan bukan hasil dari perubahan drastis, melainkan akumulasi dari kebiasaan kecil yang dilakukan konsisten setiap hari. Sangat direkomendasikan untuk mahasiswa yang ingin produktif.',
                'image'    => 'https://picsum.photos/seed/atomic/800/600',
            ],
            [
                'title'    => 'Jam Operasional Selama Bulan Puasa',
                'author'   => 'Admin Perpus',
                'category' => 'Info Layanan',
                'excerpt'  => 'Perubahan jadwal buka dan tutup perpustakaan selama bulan suci Ramadan.',
                'body'     => 'Selama bulan puasa, perpustakaan buka mulai pukul 08.00 hingga 16.00 WIB. Layanan peminjaman mandiri tetap bisa diakses 24 jam melalui mesin kios. Selamat menunaikan ibadah puasa.',
                'image'    => 'https://picsum.photos/seed/clock/800/600',
            ],
            [
                'title'    => 'Manfaat Membaca bagi Kesehatan Otak',
                'author'   => 'Nadine Ariesta',
                'category' => 'Tips Literasi',
                'excerpt'  => 'Membaca bukan hanya menambah ilmu, tapi juga mencegah pikun dan stres.',
                'body'     => 'Penelitian menunjukkan bahwa membaca secara rutin dapat menurunkan risiko Alzheimer dan meningkatkan daya ingat serta konsentrasi. Luangkan waktu minimal 30 menit sehari untuk membaca.',
                'image'    => 'https://picsum.photos/seed/brain/800/600',
            ],
            [
                'title'    => 'Lomba Menulis Cerpen Mahasiswa',
                'author'   => 'Ermas Muhammad',
                'category' => 'Event',
                'excerpt'  => 'Tunjukkan bakat menulismu dan menangkan hadiah jutaan rupiah serta sertifikat.',
                'body'     => 'Tema cerpen tahun ini adalah "Teknologi dan Kemanusiaan". Naskah dikirim paling lambat akhir bulan ini via email perpustakaan. Karya terpilih akan dibukukan dalam antologi cerpen kampus.',
                'image'    => 'https://picsum.photos/seed/write/800/600',
            ],
            [
                'title'    => 'Rekomendasi Buku Programming untuk Pemula',
                'author'   => 'Muhammad Yazid',
                'category' => 'Koleksi Baru',
                'excerpt'  => 'Belajar coding mulai dari mana? Cek daftar buku wajib baca untuk anak IT.',
                'body'     => 'Mulai dari "Clean Code" hingga "The Pragmatic Programmer". Buku-buku ini tersedia di rak 005 (Ilmu Komputer). Sangat membantu untuk memahami logika pemrograman dasar hingga lanjut.',
                'image'    => 'https://picsum.photos/seed/codebook/800/600',
            ],
            [
                'title'    => 'Fasilitas Ruang Diskusi Baru',
                'author'   => 'Admin Perpus',
                'category' => 'Info Layanan',
                'excerpt'  => 'Ruang kedap suara untuk kerja kelompok kini sudah bisa dipesan gratis.',
                'body'     => 'Dilengkapi dengan Smart TV, papan tulis, dan AC. Reservasi dapat dilakukan melalui aplikasi E-Library maksimal H-1. Jagalah kebersihan dan ketertiban selama menggunakan ruangan.',
                'image'    => 'https://picsum.photos/seed/room/800/600',
            ],
            [
                'title'    => 'Sejarah Perpustakaan Alexandria',
                'author'   => 'Nadine Ariesta',
                'category' => 'Resensi',
                'excerpt'  => 'Mengenang perpustakaan terbesar di dunia kuno yang hilang ditelan sejarah.',
                'body'     => 'Perpustakaan Alexandria di Mesir pernah menjadi pusat ilmu pengetahuan dunia sebelum hancur terbakar. Kini telah dibangun kembali dengan arsitektur modern yang memukau. Simbol keabadian ilmu pengetahuan.',
                'image'    => 'https://picsum.photos/seed/alexandria/800/600',
            ],
            [
                'title'    => 'Donasi Buku: Berbagi Jendela Dunia',
                'author'   => 'Ermas Muhammad',
                'category' => 'Event',
                'excerpt'  => 'Punya buku bekas layak baca? Sumbangkan untuk adik-adik di pelosok desa.',
                'body'     => 'Kami menerima donasi buku pelajaran, novel, dan cerita anak. Drop box tersedia di lobi perpustakaan setiap hari kerja. Satu buku darimu bisa mengubah masa depan mereka.',
                'image'    => 'https://picsum.photos/seed/donate/800/600',
            ],
            [
                'title'    => 'Review Novel: Cantik Itu Luka',
                'author'   => 'Muhammad Yazid',
                'category' => 'Resensi',
                'excerpt'  => 'Eka Kurniawan membawa realisme magis dalam sejarah Indonesia yang kelam namun indah.',
                'body'     => 'Novel ini menggabungkan sejarah, mitos, dan tragedi keluarga dengan gaya bahasa yang unik dan berani. Sebuah karya sastra Indonesia yang telah diterjemahkan ke berbagai bahasa dunia.',
                'image'    => 'https://picsum.photos/seed/cantik/800/600',
            ],
            [
                'title'    => 'Akses Jurnal Internasional Gratis',
                'author'   => 'Admin Perpus',
                'category' => 'Info Layanan',
                'excerpt'  => 'Kampus telah berlangganan IEEE dan ScienceDirect untuk mahasiswa tingkat akhir.',
                'body'     => 'Gunakan wifi kampus atau login SSO untuk mengakses jutaan jurnal ilmiah secara gratis demi menunjang skripsimu. Jangan sampai ketinggalan referensi terbaru.',
                'image'    => 'https://picsum.photos/seed/journal/800/600',
            ],
            [
                'title'    => 'Teknik Membaca Cepat (Speed Reading)',
                'author'   => 'Nadine Ariesta',
                'category' => 'Tips Literasi',
                'excerpt'  => 'Cara melahap satu buku tebal hanya dalam waktu 2 jam dengan pemahaman maksimal.',
                'body'     => 'Jangan mengeja setiap kata. Gunakan jari sebagai penunjuk dan fokus pada kata kunci. Latihan rutin akan meningkatkan kecepatan bacamu tanpa mengurangi pemahaman isi buku.',
                'image'    => 'https://picsum.photos/seed/speed/800/600',
            ],
            [
                'title'    => 'Biografi Tokoh: B.J. Habibie',
                'author'   => 'Ermas Muhammad',
                'category' => 'Resensi',
                'excerpt'  => 'Kisah Bapak Teknologi Indonesia yang menginspirasi jutaan anak bangsa untuk berkarya.',
                'body'     => 'Buku biografi ini menceritakan perjuangan Habibie muda di Jerman hingga menjadi Presiden RI dan membuat pesawat terbang. Sangat inspiratif untuk membangkitkan semangat belajar.',
                'image'    => 'https://picsum.photos/seed/habibie/800/600',
            ],
            [
                'title'    => 'Layanan Peminjaman Kindle',
                'author'   => 'Admin Perpus',
                'category' => 'Koleksi Baru',
                'excerpt'  => 'Ingin baca ebook tapi mata lelah? Pinjam perangkat Kindle di sini.',
                'body'     => 'Kami menyediakan 10 unit Kindle Paperwhite yang sudah terisi ratusan ebook populer. Syarat peminjaman sama dengan buku fisik, dengan jaminan KTM asli.',
                'image'    => 'https://picsum.photos/seed/kindle/800/600',
            ],
            [
                'title'    => 'Kenapa Buku Cetak Masih Relevan?',
                'author'   => 'Muhammad Yazid',
                'category' => 'Tips Literasi',
                'excerpt'  => 'Di era digital, sensasi membalik halaman kertas tak tergantikan oleh layar gadget.',
                'body'     => 'Buku fisik memberikan pengalaman sensorik (bau kertas, tekstur) yang membantu otak menyerap informasi lebih dalam dibanding layar. Selain itu, buku fisik tidak butuh baterai.',
                'image'    => 'https://picsum.photos/seed/paper/800/600',
            ],
        ];

        // Looping Insert ke Database
        foreach ($posts as $post) {
            DB::table('posts')->insert([
                'title'      => $post['title'],
                'author'     => $post['author'],
                'category'   => $post['category'],
                'excerpt'    => $post['excerpt'],
                'body'       => $post['body'],
                'image'      => $post['image'],
                'created_at' => Carbon::now()->subDays(rand(1, 30)),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}