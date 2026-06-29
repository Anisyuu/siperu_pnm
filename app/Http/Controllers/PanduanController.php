<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index(Request $request)
    {
        $panduan = [
            'kasubag' => [
                'label' => 'Kasubag',
                'icon' => 'fa-user-tie',
                'menus' => [
                    'login' => [
                        'title' => 'Login Sistem',
                        'icon' => 'fa-key',
                        'description' => 'Panduan login digunakan oleh Kasubag untuk masuk ke sistem sebelum mengelola data utama sistem.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Halaman Login',
                                'description' => 'Langkah pertama adalah membuka halaman login melalui browser.',
                                'steps' => [
                                    'Buka browser pada perangkat yang digunakan.',
                                    'Masukkan alamat website pada kolom URL.',
                                    'Sistem akan menampilkan halaman login.',
                                ],
                                'images' => [
                                    'kasubag_login.webp',
                                ],
                                'image_captions' => [
                                    'Tampilan halaman login Sistem Peminjaman Ruangan',
                                ],
                            ],
                            [
                                'title' => 'B. Mengisi Data Akun',
                                'description' => 'Kasubag harus memasukkan akun yang sudah terdaftar di sistem.',
                                'steps' => [
                                    'Masukkan email akun Kasubag.',
                                    'Masukkan password akun dengan benar.',
                                    'Pastikan email dan password tidak kosong.',
                                ],
                                'images' => [
                                    'kasubag_login2.webp',
                                ],
                                'image_captions' => [
                                    'Form pengisian email dan password',
                                ],
                                'note' => 'Jika email atau password salah, sistem tidak akan mengizinkan pengguna masuk.',
                            ],
                            [
                                'title' => 'C. Masuk ke Dashboard',
                                'description' => 'Setelah data akun benar, sistem akan mengarahkan Kasubag ke halaman dashboard.',
                                'steps' => [
                                    'Klik tombol Login.',
                                    'Tunggu proses autentikasi akun.',
                                    'Jika berhasil, sistem menampilkan dashboard Kasubag.',
                                ],
                                'images' => [
                                    'kasubag_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Dashboard setelah login berhasil',
                                ],
                            ],
                        ],
                    ],

                    'dashboard' => [
                        'title' => 'Dashboard Kasubag',
                        'icon' => 'fa-chart-line',
                        'description' => 'Dashboard digunakan untuk melihat ringkasan data penting pada sistem peminjaman ruangan.',
                        'sections' => [
                            [
                                'title' => 'A. Melihat Ringkasan Data',
                                'description' => 'Dashboard menampilkan informasi utama agar Kasubag dapat memantau kondisi sistem secara cepat.',
                                'steps' => [
                                    'Setelah login, sistem otomatis menampilkan halaman dashboard.',
                                    'Perhatikan kartu ringkasan yang berisi jumlah data peminjaman, pengguna, ruangan, dan jadwal.',
                                    'Gunakan informasi tersebut untuk memantau aktivitas sistem.',
                                ],
                                'images' => [
                                    'kasubag_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Tampilan dashboard Kasubag',
                                ],
                            ],
                            [
                                'title' => 'B. Fungsi Dashboard',
                                'description' => 'Dashboard tidak digunakan untuk menginput data, tetapi untuk melihat gambaran umum sistem.',
                                'steps' => [
                                    'Kasubag dapat mengetahui data sistem secara ringkas.',
                                    'Kasubag dapat memantau aktivitas peminjaman ruangan.',
                                    'Kasubag dapat menentukan menu berikutnya yang perlu dikelola.',
                                ],
                                'images' => [],
                                'note' => 'Jika data pada dashboard tidak sesuai, periksa data pada menu pengguna, ruangan, jadwal, atau peminjaman.',
                            ],
                        ],
                    ],

                    'kelola-pengguna' => [
                        'title' => 'Kelola Pengguna',
                        'icon' => 'fa-users',
                        'description' => 'Fitur Kelola Pengguna digunakan Kasubag untuk mengatur akun pengguna yang dapat mengakses sistem.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Menu Kelola Pengguna',
                                'description' => 'Menu ini digunakan untuk melihat seluruh pengguna yang terdaftar pada sistem.',
                                'steps' => [
                                    'Pilih menu Kelola Pengguna pada sidebar.',
                                    'Sistem menampilkan daftar pengguna yang sudah terdaftar.',
                                    'Data pengguna dapat dicari atau diperiksa melalui halaman ini.',
                                ],
                                'images' => [
                                    'kasubag_kelola_pengguna1.webp',
                                ],
                                'image_captions' => [
                                    'Halaman daftar pengguna',
                                ],
                            ],
                            [
                                'title' => 'B. Menambah Pengguna',
                                'description' => 'Kasubag dapat menambahkan akun baru sesuai kebutuhan sistem.',
                                'steps' => [
                                    'Klik tombol Tambah Pengguna.',
                                    'Isi nomor induk, nama lengkap, email, password, role, dan status pengguna.',
                                    'Pastikan email dan nomor induk belum digunakan oleh akun lain.',
                                    'Klik Simpan untuk menyimpan data pengguna.',
                                ],
                                'images' => [
                                    'kasubag_kelola_pengguna2.webp',
                                ],
                                'image_captions' => [
                                    'Form tambah pengguna',
                                ],
                                'note' => 'Email dan nomor induk harus unik. Kalau sama dengan pengguna lain, data tidak boleh disimpan.',
                            ],
                            [
                                'title' => 'C. Mengubah dan Menonaktifkan Pengguna',
                                'description' => 'Data pengguna dapat diperbarui jika terjadi perubahan identitas, role, atau status akun.',
                                'steps' => [
                                    'Pilih pengguna yang ingin diubah.',
                                    'Klik tombol Edit untuk mengubah data pengguna.',
                                    'Ubah data yang diperlukan saja.',
                                    'Gunakan fitur status untuk mengaktifkan atau menonaktifkan akun pengguna.',
                                ],
                                'images' => [
                                    'kasubag_kelola_pengguna3.webp',
                                ],
                                'image_captions' => [
                                    'Form ubah pengguna',
                                ],
                                'note' => 'Menonaktifkan akun lebih aman daripada menghapus data jika pengguna masih memiliki riwayat peminjaman.',
                            ],
                        ],
                    ],

                    'kelola-ruangan' => [
                        'title' => 'Kelola Ruangan',
                        'icon' => 'fa-door-open',
                        'description' => 'Fitur Kelola Ruangan digunakan untuk mengatur data jenis ruangan dan lokasi ruangan yang dipakai dalam proses pengajuan peminjaman.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Menu Ruangan',
                                'description' => 'Kasubag dapat membuka fitur pengelolaan ruangan melalui menu Ruangan pada sidebar.',
                                'steps' => [
                                    'Pilih menu Ruangan pada sidebar.',
                                    'Sistem menampilkan submenu Jenis Ruangan dan Lokasi.',
                                    'Pilih submenu sesuai data yang ingin dikelola.',
                                ],
                            ],
                            [
                                'title' => 'B. Mengelola Jenis Ruangan',
                                'description' => 'Submenu Jenis Ruangan digunakan untuk mengatur kategori ruangan, misalnya kelas, laboratorium, aula, atau ruang rapat.',
                                'steps' => [
                                    'Pilih submenu Jenis Ruangan.',
                                    'Sistem menampilkan daftar jenis ruangan yang sudah tersimpan.',
                                    'Isi nama jenis ruangan pada kolom yang tersedia.',
                                    'Klik tombol Tambah untuk menyimpan jenis ruangan baru.',
                                    'Jika data berhasil ditambahkan, jenis ruangan akan tampil pada daftar jenis ruangan.',
                                    'Gunakan tombol Edit atau Hapus jika data jenis ruangan perlu diperbarui.',
                                ],
                                'images' => [
                                    'kasubag_kelola_jenis_ruangan.webp',
                                ],
                                'image_captions' => [
                                    'Halaman kelola jenis ruangan',
                                ],
                                'note' => 'Jenis ruangan membantu sistem mengelompokkan ruangan saat pemohon melakukan pengajuan.',
                            ],
                            [
                                'title' => 'C. Melihat Daftar Kampus',
                                'description' => 'Halaman daftar kampus digunakan untuk menampilkan seluruh data kampus yang sudah tersimpan pada sistem.',
                                'steps' => [
                                    'Pilih submenu Lokasi.',
                                    'Sistem menampilkan halaman daftar kampus.',
                                    'Pada halaman ini, Kasubag dapat melihat data kampus yang sudah tersedia.',
                                    'Kasubag dapat menggunakan halaman ini untuk memilih data kampus yang akan ditambah, diubah, atau dilanjutkan ke pengelolaan gedung.',
                                ],
                                'images' => [
                                    'kasubag_kelola_kampus.webp',
                                ],
                                'image_captions' => [
                                    'Halaman daftar kampus',
                                ],
                                'note' => 'Data kampus sebaiknya dibuat lebih dahulu karena menjadi induk bagi data gedung. Kampus tidak sebaiknya dihapus jika sudah memiliki gedung yang terhubung.',
                            ],

                            [
                                'title' => 'D. Menambah dan Mengubah Kampus',
                                'description' => 'Kasubag dapat menambahkan kampus baru atau memperbarui data kampus yang sudah ada.',
                                'steps' => [
                                    'Pada halaman daftar kampus, klik tombol Tambah Kampus untuk menambahkan data baru.',
                                    'Isi data kampus sesuai form yang tersedia, seperti nama kampus dan informasi lain yang dibutuhkan.',
                                    'Klik tombol Simpan untuk menyimpan data kampus baru.',
                                    'Jika ingin mengubah atau menghapus data kampus, pilih data kampus pada daftar lalu klik tombol Edit atau Hapus.',
                                    'Perbarui data kampus yang diperlukan, kemudian klik tombol Simpan Perubahan.',
                                ],
                                'images' => [
                                    'kasubag_tambah_kampus.webp',
                                    'kasubag_edit_kampus.webp',
                                ],
                                'image_captions' => [
                                    'Form tambah kampus',
                                    'Form edit kampus',
                                ],
                                'note' => 'Perubahan data kampus harus dilakukan hati-hati. Jika kampus sudah memiliki gedung, hindari mengubah data pokok secara sembarangan karena akan memengaruhi data di bawahnya.',
                            ],

                            [
                                'title' => 'E. Melihat Daftar Gedung',
                                'description' => 'Setelah memilih kampus, Kasubag dapat melihat daftar gedung yang berada pada kampus tersebut.',
                                'steps' => [
                                    'Pilih salah satu kampus pada halaman daftar kampus.',
                                    'Sistem menampilkan halaman daftar gedung sesuai kampus yang dipilih.',
                                    'Pada halaman ini, Kasubag dapat melihat gedung yang sudah tersedia pada kampus tersebut.',
                                    'Kasubag juga dapat melanjutkan ke proses tambah gedung, edit gedung, atau memilih gedung untuk melihat lantai dan ruangan di dalamnya.',
                                ],
                                'images' => [
                                    'kasubag_kelola_gedung.webp',
                                ],
                                'image_captions' => [
                                    'Halaman daftar gedung',
                                ],
                                'note' => 'Gedung selalu terhubung ke kampus tertentu. Gedung tidak sebaiknya dihapus jika sudah memiliki ruangan atau masih digunakan dalam data lokasi ruangan.',
                            ],

                            [
                                'title' => 'F. Menambah, Mengubah, dan Menghapus Gedung',
                                'description' => 'Kasubag dapat menambahkan gedung baru pada kampus tertentu atau memperbarui data gedung yang sudah ada. Form tambah gedung berisi data kampus, nama gedung, manager atau PIC sarpras, jumlah lantai, dan foto gedung.',
                                'steps' => [
                                    'Pada halaman daftar gedung, klik tombol Tambah Gedung.',
                                    'Sistem menampilkan form tambah gedung sesuai kampus yang sedang dipilih.',
                                    'Periksa field Kampus yang sudah terisi otomatis.',
                                    'Isi Nama Gedung pada kolom yang tersedia.',
                                    'Pilih Manager atau PIC Sarpras gedung.',
                                    'Isi Jumlah Lantai sesuai kondisi gedung sebenarnya.',
                                    'Unggah Foto Gedung jika diperlukan.',
                                    'Klik tombol Simpan Gedung untuk menyimpan data.',
                                    'Jika ingin mengubah data gedung, pilih data gedung pada daftar lalu klik tombol Edit.',
                                    'Perbarui data gedung yang dibutuhkan, kemudian klik Simpan Perubahan.',
                                    'Jika ingin menghapus data gedung, pilih data gedung pada daftar lalu klik tombol Hapus.',
                                ],
                                'images' => [
                                    'kasubag_tambah_gedung.webp',
                                    'kasubag_edit_gedung.webp',
                                ],
                                'image_captions' => [
                                    'Form tambah gedung',
                                    'Form edit gedung',
                                ],
                                'note' => 'Jumlah lantai pada gedung akan menentukan pilihan lantai saat menambah ruangan. Jika jumlah lantai diubah, pastikan penyesuaian tersebut tidak menimbulkan ketidaksesuaian pada data ruangan yang sudah ada.',
                            ],

                            [
                                'title' => 'G. Memilih Lantai dalam Gedung',
                                'description' => 'Setelah memilih gedung, Kasubag dapat memilih lantai untuk melihat ruangan yang berada pada lantai tersebut.',
                                'steps' => [
                                    'Pilih salah satu gedung pada daftar gedung.',
                                    'Sistem menampilkan pilihan lantai berdasarkan jumlah lantai pada gedung tersebut.',
                                    'Klik salah satu lantai yang ingin dibuka.',
                                    'Sistem akan menampilkan daftar ruangan yang berada pada lantai tersebut.',
                                ],
                                'images' => [
                                    'kasubag_kelola_lantai.webp',
                                ],
                                'image_captions' => [
                                    'Halaman pilihan lantai dalam gedung',
                                ],
                                'note' => 'Pilihan lantai muncul mengikuti jumlah lantai pada data gedung. Jika jumlah lantai pada gedung belum sesuai, daftar lantai yang tampil juga ikut tidak sesuai.',
                            ],

                            [
                                'title' => 'H. Melihat Daftar Ruangan',
                                'description' => 'Setelah memilih lantai, Kasubag dapat melihat daftar ruangan yang tersedia pada lantai tersebut.',
                                'steps' => [
                                    'Pilih salah satu lantai pada gedung.',
                                    'Sistem menampilkan daftar ruangan pada lantai yang dipilih.',
                                    'Pada halaman ini, Kasubag dapat melihat data ruangan yang sudah tersimpan.',
                                    'Kasubag dapat melanjutkan ke proses tambah ruangan, edit ruangan, atau pemeriksaan detail ruangan.',
                                ],
                                'images' => [
                                    'kasubag_kelola_ruangan.webp',
                                ],
                                'image_captions' => [
                                    'Halaman daftar ruangan',
                                ],
                                'note' => 'Ruangan yang ditampilkan merupakan ruangan pada lantai yang sedang dipilih. Pastikan kampus, gedung, dan lantai yang dibuka sudah benar sebelum menambah atau mengubah data ruangan.',
                            ],

                            [
                                'title' => 'I. Menambah, Mengubah, dan Menghapus Ruangan',
                                'description' => 'Kasubag dapat menambahkan ruangan baru, memperbarui data ruangan, atau menghapus data ruangan yang sudah ada pada lantai tertentu. Pada form ruangan, pengisian data menyesuaikan jenis ruangan yang dipilih.',
                                'steps' => [
                                    'Pada halaman daftar ruangan, klik tombol Tambah Ruangan.',
                                    'Sistem menampilkan form tambah ruangan sesuai kampus, gedung, dan lantai yang sedang dipilih.',
                                    'Isi nama ruangan sesuai nama ruangan sebenarnya.',
                                    'Pilih jenis ruangan yang sesuai, misalnya kelas, aula, ruang rapat, atau laboratorium.',
                                    'Isi form sesuai dengan jenis ruangan yang dipilih.',
                                    'Jika jenis ruangan yang dipilih adalah LAB, sistem akan menampilkan pilihan PIC Ruangan. Pilih PIC Ruangan LAB yang bertanggung jawab terhadap ruangan tersebut.',
                                    'Jika jenis ruangan yang dipilih bukan LAB, field PIC Ruangan tidak perlu diisi atau tidak ditampilkan oleh sistem.',
                                    'Lengkapi informasi lain yang tersedia pada form, seperti foto ruangan jika diperlukan.',
                                    'Pastikan data kampus, gedung, lantai, jenis ruangan, dan PIC ruangan sudah sesuai.',
                                    'Klik tombol Simpan untuk menyimpan data ruangan baru.',
                                    'Jika ingin mengubah data ruangan, pilih data ruangan pada daftar lalu klik tombol Edit.',
                                    'Perbarui data ruangan yang diperlukan. Jika jenis ruangan diubah menjadi LAB, pastikan PIC Ruangan juga dipilih.',
                                    'Jika jenis ruangan diubah dari LAB menjadi bukan LAB, maka PIC Ruangan tidak lagi diperlukan.',
                                    'Klik Simpan Perubahan untuk menyimpan hasil perubahan data ruangan.',
                                    'Jika ingin menghapus data ruangan, pilih data ruangan pada daftar lalu klik tombol Hapus.',
                                ],
                                'images' => [
                                    'kasubag_tambah_ruangan.webp',
                                    'kasubag_edit_ruangan.webp',
                                ],
                                'image_captions' => [
                                    'Form tambah ruangan',
                                    'Form edit ruangan',
                                ],
                                'note' => 'PIC Ruangan hanya digunakan untuk ruangan berjenis LAB. Jika ruangan bukan LAB, PIC Ruangan tidak perlu diisi. Data ruangan tidak sebaiknya diubah atau dihapus sembarangan jika sudah digunakan pada jadwal atau peminjaman, karena perubahan jenis ruangan, lokasi, PIC, atau penghapusan data dapat memengaruhi proses pengajuan dan riwayat peminjaman.',
                            ],

                            [
                                'title' => 'J. Hubungan Data Lokasi dengan Pengajuan Peminjaman',
                                'description' => 'Data kampus, gedung, lantai, dan ruangan yang sudah dikelola akan dipakai saat proses pengajuan peminjaman.',
                                'steps' => [
                                    'Pemohon memilih tanggal dan jam peminjaman.',
                                    'Sistem menampilkan ruangan berdasarkan data lokasi dan data ruangan yang sudah tersedia.',
                                    'Ruangan yang sedang dipakai atau tidak tersedia pada waktu tersebut tidak ditampilkan sebagai pilihan.',
                                    'Dengan demikian, data lokasi yang lengkap akan membantu proses pengajuan berjalan lebih akurat.',
                                ],
                                'images' => [],
                                'note' => 'Urutan data jangan dibalik. Kampus dibuat dulu, lalu gedung, kemudian lantai, dan terakhir ruangan.',
                            ],
                            [
                                'title' => 'K. Pengaruh Data Ruangan pada Pengajuan',
                                'description' => 'Data ruangan yang dikelola Kasubag akan digunakan oleh pemohon saat melakukan pengajuan peminjaman.',
                                'steps' => [
                                    'Pemohon memilih tanggal dan jam peminjaman.',
                                    'Sistem menampilkan ruangan yang tersedia berdasarkan data ruangan dan jadwal.',
                                    'Ruangan yang sudah dipakai atau sudah diajukan pada waktu tersebut tidak ditampilkan sebagai pilihan.',
                                ],
                                'images' => [],
                                'note' => 'Bagian ini penting karena sistem mencegah bentrok dari pilihan ruangan yang tampil di form pengajuan.',
                            ],
                        ],
                    ],

                    'kelola-jadwal' => [
                        'title' => 'Kelola Jadwal',
                        'icon' => 'fa-calendar-days',
                        'description' => 'Fitur Kelola Jadwal digunakan untuk mengatur jadwal penggunaan ruangan agar ketersediaan ruangan dapat dipantau oleh sistem.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Menu Kelola Jadwal',
                                'description' => 'Kasubag dapat melihat seluruh jadwal penggunaan ruangan melalui menu Kelola Jadwal.',
                                'steps' => [
                                    'Pilih menu Kelola Jadwal pada sidebar.',
                                    'Sistem menampilkan daftar jadwal penggunaan ruangan.',
                                    'Gunakan filter pencarian jika ingin melihat jadwal berdasarkan ruangan, tanggal, kampus, atau gedung.',
                                ],
                                'images' => [
                                    'kasubag_kelola_jadwal.webp',
                                ],
                                'image_captions' => [
                                    'Halaman kelola jadwal',
                                ],
                            ],
                            [
                                'title' => 'B. Menambah, Mengubah, dan Menghapus Jadwal',
                                'description' => 'Kasubag dapat menambahkan, mengubah, atau menghapus jadwal penggunaan ruangan. Data jadwal ini digunakan sistem untuk menentukan ketersediaan ruangan saat pemohon mengajukan peminjaman.',
                                'steps' => [
                                    'Pada halaman Kelola Jadwal, klik tombol Tambah Jadwal untuk menambahkan jadwal baru.',
                                    'Isi form jadwal ruangan sesuai data yang dibutuhkan, seperti ruangan, tanggal, jam, dan keterangan penggunaan.',
                                    'Klik tombol Simpan untuk menyimpan jadwal baru.',
                                    'Jika data berhasil disimpan, jadwal akan tampil pada daftar jadwal penggunaan ruangan.',

                                    'Jika ingin mengubah jadwal, pilih data jadwal pada daftar lalu klik tombol Edit.',
                                    'Perbarui form jadwal ruangan sesuai perubahan yang diperlukan.',
                                    'Klik tombol Simpan untuk menyimpan perubahan jadwal.',
                                    'Jika perubahan berhasil, data jadwal pada daftar akan diperbarui.',

                                    'Jika ingin menghapus jadwal, pilih data jadwal pada daftar lalu klik tombol Hapus.',
                                    'Konfirmasi penghapusan jika sistem menampilkan pesan konfirmasi.',
                                    'Jika berhasil, jadwal tidak lagi tampil pada daftar jadwal penggunaan ruangan.',
                                ],
                                'images' => [
                                    'kasubag_tambah_jadwal.webp',
                                    'kasubag_edit_jadwal.webp',
                                ],
                                'image_captions' => [
                                    'Form tambah jadwal',
                                    'Form ubah jadwal',
                                ],
                                'note' => 'Jadwal yang tersimpan akan memengaruhi daftar ruangan yang tersedia pada form pengajuan peminjaman. Jika ruangan sudah memiliki jadwal pada tanggal dan jam tertentu, ruangan tersebut tidak ditampilkan sebagai pilihan. Mengubah atau menghapus jadwal harus dilakukan hati-hati agar data ketersediaan ruangan tetap sesuai.',
                            ],
                            [
                                'title' => 'D. Hubungan Jadwal dengan Ketersediaan Ruangan',
                                'description' => 'Jadwal digunakan sistem untuk membantu menentukan ruangan yang tersedia saat pemohon mengajukan peminjaman.',
                                'steps' => [
                                    'Sistem membaca data jadwal ruangan.',
                                    'Jika ruangan sudah memiliki jadwal pada tanggal dan jam tertentu, ruangan tersebut tidak ditampilkan sebagai pilihan.',
                                    'Pemohon hanya dapat memilih ruangan yang tersedia.',
                                ],
                            ],
                        ],
                    ],

                    'alur-verifikasi' => [
                                'title' => 'Kelola Alur Verifikasi',
                                'icon' => 'fa-code-branch',
                                'description' => 'Fitur Kelola Alur Verifikasi digunakan untuk mengatur urutan role verifikator yang akan memproses pengajuan peminjaman ruangan berdasarkan jenis pemohon. Alur ini menentukan siapa yang pertama kali menerima pengajuan, siapa yang memproses berikutnya, sampai pengajuan selesai diverifikasi.',
                                'sections' => [
                                    [
                                        'title' => 'A. Membuka Menu Alur Verifikasi',
                                        'description' => 'Kasubag dapat membuka menu Alur Verifikasi untuk melihat aturan verifikasi yang sudah dibuat pada sistem.',
                                        'steps' => [
                                            'Pilih menu Alur Verifikasi pada sidebar.',
                                            'Sistem menampilkan daftar alur verifikasi yang sudah tersimpan.',
                                            'Setiap data alur menampilkan jenis pemohon dan urutan role verifikator.',
                                            'Kasubag dapat melihat apakah setiap jenis pemohon sudah memiliki alur verifikasi yang sesuai.',
                                        ],
                                        'images' => [
                                            'kasubag_alur_verifikasi.webp',
                                        ],
                                        'image_captions' => [
                                            'Halaman kelola alur verifikasi',
                                        ],
                                        'note' => 'Setiap jenis pemohon sebaiknya memiliki alur verifikasi sendiri agar proses persetujuan pengajuan tidak salah arah.',
                                    ],

                                    [
                                        'title' => 'B. Menambah, Mengubah, dan Menghapus Alur Verifikasi',
                                        'description' => 'Kasubag dapat menambahkan alur verifikasi baru, mengubah alur yang sudah ada, atau menghapus alur jika sudah tidak digunakan. Alur ini berisi jenis pemohon dan urutan role verifikator yang akan memproses pengajuan.',
                                        'steps' => [
                                            'Klik tombol Tambah Alur untuk membuat alur verifikasi baru.',
                                            'Pilih jenis pemohon yang akan diatur, misalnya mahasiswa, dosen, karyawan, atau ormawa.',
                                            'Klik Tambah Step untuk menambahkan role verifikator.',
                                            'Pilih role verifikator sesuai urutan proses verifikasi.',
                                            'Urutan pertama sebaiknya diawali dengan role Kalab.',
                                            'Tambahkan role verifikator berikutnya sesuai kebutuhan, misalnya sarpras, kasubag, atau pimpinan.',
                                            'Klik Simpan untuk menyimpan alur verifikasi.',
                                            'Jika ingin mengubah alur, pilih data alur pada daftar lalu klik tombol Edit.',
                                            'Perbarui jenis pemohon atau susunan role verifikator sesuai kebutuhan.',
                                            'Klik Simpan untuk menyimpan perubahan alur.',
                                            'Jika ingin menghapus alur, pilih data alur pada daftar lalu klik tombol Hapus.',
                                            'Konfirmasi penghapusan jika sistem menampilkan pesan konfirmasi.',
                                        ],
                                        'images' => [
                                            'kasubag_tambah_alur_verifikasi.webp',
                                            'kasubag_edit_alur_verifikasi.webp',
                                        ],
                                        'image_captions' => [
                                            'Form tambah alur verifikasi',
                                            'Form edit alur verifikasi',
                                        ],
                                        'note' => 'Saat mengubah alur, sistem akan mengganti susunan alur lama dengan susunan alur baru. Jadi pastikan urutannya sudah benar sebelum disimpan.',
                                    ],

                                    [
                                        'title' => 'C. Ketentuan Urutan Verifikator',
                                        'description' => 'Urutan verifikator harus dibuat sesuai alur kerja sistem. Role Kalab sebaiknya diletakkan di awal karena Kalab berperan sebagai pihak yang memeriksa ruangan LAB terlebih dahulu.',
                                        'steps' => [
                                            'Letakkan role Kalab pada urutan pertama dalam alur verifikasi.',
                                            'Kalab diperlukan pada awal alur karena ruangan LAB memiliki PIC atau penanggung jawab laboratorium.',
                                            'Jika peminjaman menggunakan ruangan LAB, pengajuan akan diperiksa oleh Kalab terlebih dahulu.',
                                            'Jika peminjaman menggunakan ruangan bukan LAB, proses verifikasi dapat lanjut ke role verifikator berikutnya sesuai alur sistem.',
                                            'Setelah Kalab, tambahkan role verifikator lain sesuai kebutuhan proses, seperti sarpras, kasubag, atau pimpinan.',
                                            'Pastikan tidak ada urutan role yang terbalik agar pengajuan tidak masuk ke verifikator yang salah.',
                                        ],
                                        'note' => 'Jangan menaruh Kalab di tengah atau akhir alur jika alur tersebut juga digunakan untuk peminjaman ruangan LAB. Kalau Kalab tidak berada di awal, pemeriksaan LAB bisa terlambat atau alurnya jadi tidak sesuai dengan logika sistem.',
                                    ],

                                    [
                                        'title' => 'D. Dampak Alur Verifikasi pada Pengajuan',
                                        'description' => 'Setiap pengajuan peminjaman akan mengikuti alur verifikasi sesuai jenis pemohon dan jenis ruangan yang dipilih.',
                                        'steps' => [
                                            'Pemohon mengirim pengajuan peminjaman ruangan.',
                                            'Sistem membaca jenis pemohon dari akun yang mengajukan.',
                                            'Sistem membaca jenis ruangan yang dipilih pada pengajuan.',
                                            'Sistem mencocokkan pengajuan dengan alur verifikasi yang sudah dibuat oleh Kasubag.',
                                            'Pengajuan akan masuk ke role verifikator sesuai urutan alur.',
                                            'Jika satu role sudah menyetujui, pengajuan dilanjutkan ke role berikutnya.',
                                            'Jika salah satu role menolak pengajuan, proses verifikasi berhenti dan status pengajuan menjadi ditolak.',
                                            'Pengajuan dinyatakan selesai jika seluruh role dalam alur sudah memproses pengajuan.',
                                        ],
                                        'images' => [],
                                        'note' => 'Alur verifikasi yang salah dapat membuat pengajuan tidak sampai ke verifikator yang seharusnya.',
                                    ],
                                ],
                    ],

                    'verifikasi-peminjaman' => [
                                        'title' => 'Verifikasi Peminjaman',
                                        'icon' => 'fa-list-check',
                                        'description' => 'Fitur Verifikasi Peminjaman digunakan Kasubag untuk memproses pengajuan peminjaman ruangan yang masuk sesuai alur verifikasi.',
                                        'sections' => [
                                            [
                                                'title' => 'A. Membuka Menu Verifikasi Peminjaman',
                                                'description' => 'Kasubag dapat melihat daftar pengajuan peminjaman yang perlu diverifikasi.',
                                                'steps' => [
                                                    'Pilih menu Verifikasi Peminjaman pada sidebar.',
                                                    'Sistem menampilkan daftar pengajuan peminjaman yang menunggu proses verifikasi.',
                                                    'Pengajuan yang tampil disesuaikan dengan alur verifikasi yang berlaku.',
                                                    'Kasubag dapat memilih salah satu pengajuan untuk melihat detailnya.',
                                                ],
                                                'images' => [
                                                    'kasubag_verifikasi_peminjaman.webp',
                                                ],
                                                'image_captions' => [
                                                    'Halaman verifikasi peminjaman Kasubag',
                                                ],
                                            ],
                                            [
                                                'title' => 'B. Memproses Pengajuan Peminjaman',
                                                'description' => 'Kasubag dapat menyetujui atau menolak pengajuan setelah memeriksa detail peminjaman.',
                                                'steps' => [
                                                    'Klik detail pada pengajuan yang ingin diperiksa.',
                                                    'Periksa data pemohon, ruangan, tanggal, jam, dan keperluan peminjaman.',
                                                    'Jika data sudah sesuai, klik tombol Setujui.',
                                                    'Jika pengajuan tidak sesuai, klik tombol Tolak.',
                                                    'Isi catatan verifikasi jika diperlukan.',
                                                    'Simpan keputusan verifikasi.',
                                                ],
                                                'images' => [
                                                    'kasubag_detail_verifikasi_peminjaman.webp',
                                                ],
                                                'image_captions' => [
                                                    'Detail pengajuan peminjaman',
                                                ],
                                                'note' => 'Kasubag harus memeriksa data pengajuan sebelum memberi keputusan. Jika pengajuan ditolak, catatan sebaiknya diisi agar pemohon mengetahui alasan penolakan.',
                                            ],
                                        ],
                                    ],

                                    'riwayat-verifikasi' => [
                                    'title' => 'Riwayat Verifikasi',
                                    'icon' => 'fa-clock-rotate-left',
                                    'description' => 'Fitur Riwayat Verifikasi digunakan Kasubag untuk melihat dan mengunduh data pengajuan yang sudah pernah diverifikasi.',
                                    'sections' => [
                                        [
                                            'title' => 'A. Membuka Menu Riwayat Verifikasi',
                                            'description' => 'Kasubag dapat melihat daftar pengajuan peminjaman yang sudah diproses melalui menu Riwayat Verifikasi.',
                                            'steps' => [
                                                'Pilih menu Riwayat Verifikasi pada sidebar.',
                                                'Sistem menampilkan daftar pengajuan yang sudah diproses oleh Kasubag.',
                                                'Kasubag dapat melihat informasi pemohon, ruangan, tanggal, jam, status verifikasi, waktu verifikasi, dan catatan verifikasi.',
                                                'Gunakan fitur pencarian atau filter untuk mencari data riwayat verifikasi tertentu.',
                                            ],
                                            'images' => [
                                                'kasubag_riwayat_verifikasi.webp',
                                            ],
                                            'image_captions' => [
                                                'Halaman riwayat verifikasi Kasubag',
                                            ],
                                        ],
                                        [
                                            'title' => 'B. Melihat dan Mengunduh Riwayat Verifikasi',
                                            'description' => 'Kasubag dapat melihat detail riwayat verifikasi dan mengunduh data riwayat verifikasi sebagai arsip.',
                                            'steps' => [
                                                'Pilih salah satu data riwayat verifikasi yang ingin diperiksa.',
                                                'Klik tombol Detail untuk melihat informasi pengajuan dan hasil verifikasi secara lengkap.',
                                                'Klik tombol Unduh untuk mengunduh data riwayat verifikasi.',
                                                'Gunakan hasil unduhan sebagai arsip atau bahan dokumentasi proses verifikasi peminjaman ruangan.',
                                            ],
                                            'images' => [
                                                'kasubag_detail_riwayat_verifikasi.webp',
                                            ],
                                            'image_captions' => [
                                                'Detail riwayat verifikasi',
                                            ],
                                            'note' => 'Riwayat verifikasi digunakan untuk melihat kembali data pengajuan yang sudah diproses. Data ini tidak digunakan untuk mengubah keputusan verifikasi.',
                                        ],
                                    ],
                                ],

                                'riwayat-peminjaman' => [
                                    'title' => 'Riwayat Peminjaman',
                                    'icon' => 'fa-file-lines',
                                    'description' => 'Fitur Riwayat Peminjaman digunakan Kasubag untuk melihat dan mengunduh seluruh data pengajuan peminjaman ruangan yang sudah masuk ke sistem.',
                                    'sections' => [
                                        [
                                            'title' => 'A. Membuka Menu Riwayat Peminjaman',
                                            'description' => 'Kasubag dapat memantau seluruh data peminjaman ruangan melalui menu Riwayat Peminjaman.',
                                            'steps' => [
                                                'Pilih menu Riwayat Peminjaman pada sidebar.',
                                                'Sistem menampilkan daftar pengajuan peminjaman ruangan.',
                                                'Kasubag dapat melihat informasi pemohon, ruangan, tanggal, jam, keperluan, dan status pengajuan.',
                                                'Gunakan fitur pencarian atau filter untuk mencari data peminjaman tertentu.',
                                            ],
                                            'images' => [
                                                'kasubag_riwayat_peminjaman.webp',
                                            ],
                                            'image_captions' => [
                                                'Halaman riwayat peminjaman Kasubag',
                                            ],
                                        ],
                                        [
                                            'title' => 'B. Melihat dan Mengunduh Riwayat Peminjaman',
                                            'description' => 'Kasubag dapat melihat detail riwayat peminjaman dan mengunduh data riwayat peminjaman sebagai arsip.',
                                            'steps' => [
                                                'Pilih salah satu data riwayat peminjaman yang ingin diperiksa.',
                                                'Klik tombol Detail untuk melihat informasi peminjaman secara lengkap.',
                                                'Klik tombol Unduh untuk mengunduh data riwayat peminjaman.',
                                                'Gunakan hasil unduhan sebagai arsip atau bahan pemeriksaan penggunaan ruangan.',
                                            ],
                                            'images' => [
                                                'kasubag_detail_riwayat_peminjaman.webp',
                                            ],
                                            'image_captions' => [
                                                'Detail riwayat peminjaman',
                                            ],
                                            'note' => 'Riwayat peminjaman berfungsi sebagai arsip data pengajuan. Data ini membantu Kasubag memantau penggunaan ruangan dan status pengajuan peminjaman.',
                                        ],
                                    ],
                                ],
                ],
            ],

            'verifikator' => [
                'label' => 'Verifikator',
                'icon' => 'fa-user-check',
                'menus' => [
                    'login' => [
                        'title' => 'Login Akun Verifikator',
                        'icon' => 'fa-key',
                        'description' => 'Panduan login verifikator digunakan oleh pengguna yang bertugas memproses pengajuan peminjaman ruangan.',
                        'sections' => [
                            [
                                'title' => 'A. Masuk ke Sistem',
                                'description' => 'Verifikator harus login terlebih dahulu sebelum memproses pengajuan.',
                                'steps' => [
                                    'Buka halaman login Sistem Peminjaman Ruangan.',
                                    'Masukkan email akun verifikator.',
                                    'Masukkan password akun.',
                                    'Klik tombol Login.',
                                ],
                                'images' => [
                                    'verifikator_login.webp',
                                ],
                                'image_captions' => [
                                    'Halaman login verifikator',
                                ],
                            ],
                            [
                                'title' => 'B. Berhasil Masuk',
                                'description' => 'Jika akun benar, sistem menampilkan dashboard sesuai role verifikator.',
                                'steps' => [
                                    'Sistem memeriksa data akun.',
                                    'Jika berhasil, verifikator diarahkan ke dashboard.',
                                    'Menu yang tampil disesuaikan dengan role pengguna.',
                                ],
                                'images' => [
                                    'verifikator_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Dashboard verifikator',
                                ],
                            ],
                        ],
                    ],

                    'dashboard' => [
                        'title' => 'Dashboard Verifikator',
                        'icon' => 'fa-chart-line',
                        'description' => 'Dashboard Verifikator digunakan untuk melihat ringkasan pengajuan yang perlu diproses.',
                        'sections' => [
                            [
                                'title' => 'A. Melihat Ringkasan Pengajuan',
                                'description' => 'Verifikator dapat melihat jumlah pengajuan masuk dan status proses verifikasi.',
                                'steps' => [
                                    'Setelah login, buka halaman dashboard.',
                                    'Periksa ringkasan pengajuan yang perlu diverifikasi.',
                                    'Gunakan informasi dashboard untuk menentukan pengajuan yang perlu segera diproses.',
                                ],
                                'images' => [
                                    'verifikator_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Dashboard verifikator',
                                ],
                            ],
                        ],
                    ],

                    'jadwal' => [
                    'title' => 'Jadwal Ruangan',
                    'icon' => 'fa-calendar-days',
                    'description' => 'Menu Jadwal Ruangan digunakan verifikator untuk melihat jadwal penggunaan ruangan secara lengkap. Melalui menu ini, verifikator dapat memantau ruangan yang sudah memiliki jadwal dan menggunakan filter untuk mencari jadwal sesuai kebutuhan.',
                    'sections' => [
                        [
                            'title' => 'A. Membuka Menu Jadwal Ruangan',
                            'description' => 'Verifikator dapat membuka menu Jadwal Ruangan untuk melihat daftar jadwal penggunaan ruangan.',
                            'steps' => [
                                'Pilih menu Jadwal Ruangan pada sidebar.',
                                'Sistem menampilkan daftar jadwal penggunaan ruangan.',
                                'Verifikator dapat melihat informasi ruangan, tanggal, jam, lokasi, dan keterangan penggunaan.',
                            ],
                            'images' => [
                                'verifikator_jadwal_ruangan.webp',
                            ],
                            'image_captions' => [
                                'Halaman jadwal ruangan verifikator',
                            ],
                        ],
                        [
                            'title' => 'B. Memfilter Jadwal Ruangan',
                            'description' => 'Filter jadwal digunakan untuk membantu verifikator mencari jadwal ruangan secara lebih cepat dan sesuai kebutuhan.',
                            'steps' => [
                                'Gunakan filter yang tersedia pada halaman jadwal.',
                                'Pilih filter sesuai kebutuhan, seperti ruangan, tanggal, kampus, atau gedung.',
                                'Sistem menampilkan jadwal berdasarkan filter yang dipilih.',
                                'Gunakan hasil filter untuk memeriksa ketersediaan atau penggunaan ruangan sebelum memproses pengajuan.',
                            ],
                            'images' => [
                                'verifikator_filter_jadwal.webp',
                            ],
                            'image_captions' => [
                                'Filter jadwal ruangan verifikator',
                            ],
                            'note' => 'Menu Jadwal Ruangan hanya digunakan untuk melihat data jadwal. Verifikator tidak mengubah jadwal dari menu ini.',
                        ],
                    ],
                ],

                    'verifikasi-peminjaman' => [
                        'title' => 'Verifikasi Peminjaman',
                        'icon' => 'fa-check-circle',
                        'description' => 'Fitur Verifikasi Peminjaman digunakan verifikator untuk menyetujui atau menolak pengajuan peminjaman ruangan.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Daftar Pengajuan',
                                'description' => 'Verifikator dapat melihat daftar pengajuan yang menunggu proses verifikasi.',
                                'steps' => [
                                    'Pilih menu Verifikasi Peminjaman.',
                                    'Sistem menampilkan daftar pengajuan yang menunggu verifikasi.',
                                    'Pengajuan yang tampil disesuaikan dengan role dan urutan verifikator.',
                                ],
                                'images' => [
                                    'verifikator_verifikasi_peminjaman.webp',
                                ],
                                'image_captions' => [
                                    'Daftar pengajuan menunggu verifikasi',
                                ],
                            ],
                            [
                                'title' => 'B. Melihat Detail Pengajuan',
                                'description' => 'Detail pengajuan digunakan untuk memeriksa informasi sebelum mengambil keputusan.',
                                'steps' => [
                                    'Klik detail pada salah satu pengajuan.',
                                    'Periksa data pemohon, ruangan, tanggal, jam, dan keperluan.',
                                    'Pastikan informasi pengajuan sudah jelas sebelum diverifikasi.',
                                ],
                                'images' => [
                                    'verifikator_verifikasi_peminjaman2.webp',
                                ],
                                'image_captions' => [
                                    'Detail data pengajuan',
                                ],
                            ],
                            [
                                'title' => 'C. Menyetujui atau Menolak Pengajuan',
                                'description' => 'Verifikator dapat memproses pengajuan sesuai hasil pemeriksaan.',
                                'steps' => [
                                    'Pilih Setujui jika pengajuan layak diterima.',
                                    'Pilih Tolak jika pengajuan tidak dapat diterima.',
                                    'Tambahkan catatan jika diperlukan.',
                                    'Simpan keputusan verifikasi.',
                                ],
                                'note' => 'Catatan verifikasi sebaiknya diisi dengan alasan yang jelas, terutama saat pengajuan ditolak.',
                            ],
                        ],
                    ],

                    'riwayat-verifikasi' => [
                        'title' => 'Riwayat Verifikasi',
                        'icon' => 'fa-clock-rotate-left',
                        'description' => 'Riwayat Verifikasi digunakan untuk melihat pengajuan yang sudah pernah diproses oleh verifikator.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Riwayat Verifikasi',
                                'description' => 'Menu ini menampilkan daftar keputusan verifikasi yang pernah dilakukan.',
                                'steps' => [
                                    'Pilih menu Riwayat Verifikasi.',
                                    'Sistem menampilkan pengajuan yang sudah diproses.',
                                    'Verifikator dapat melihat status keputusan, catatan, dan waktu verifikasi.',
                                    'Gunakan fitur pencarian atau filter untuk menemukan data riwayat tertentu.',
                                    'Gunakan fitur unduh untuk menyimpan data riwayat verifikasi sebagai arsip ataupun dokumentasi.',
                                ],
                                'images' => [
                                    'verifikator_riwayat_verifikasi.webp',
                                ],
                                'image_captions' => [
                                    'Halaman riwayat verifikasi',
                                ],
                            ],
                            [
                                'title' => 'B. Melihat Detail Riwayat',
                                'description' => 'Detail riwayat membantu verifikator memeriksa kembali keputusan yang sudah diberikan.',
                                'steps' => [
                                    'Pilih salah satu data riwayat.',
                                    'Lihat detail pengajuan dan keputusan verifikasi.',
                                ],
                                'images' => [
                                    'verifikator_detail_riwayat_verifikasi.webp',
                                ],
                                'image_captions' => [
                                    'Detail riwayat verifikasi',
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'pemohon' => [
                'label' => 'Pemohon',
                'icon' => 'fa-user',
                'menus' => [
                    'login' => [
                        'title' => 'Login Akun Pemohon',
                        'icon' => 'fa-key',
                        'description' => 'Panduan login pemohon digunakan oleh mahasiswa, dosen, karyawan, atau ormawa sebelum melakukan pengajuan peminjaman ruangan.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Halaman Login',
                                'description' => 'Pemohon harus masuk ke sistem menggunakan akun yang sudah terdaftar.',
                                'steps' => [
                                    'Buka halaman login Sistem Peminjaman Ruangan.',
                                    'Masukkan email akun pemohon.',
                                    'Masukkan password akun.',
                                    'Klik tombol Login.',
                                ],
                                'images' => [
                                    'pemohon_login.webp',
                                ],
                                'image_captions' => [
                                    'Halaman login pemohon',
                                ],
                            ],
                            [
                                'title' => 'B. Masuk ke Dashboard Pemohon',
                                'description' => 'Setelah login berhasil, sistem menampilkan dashboard pemohon.',
                                'steps' => [
                                    'Sistem memeriksa email dan password.',
                                    'Jika data benar, pemohon diarahkan ke dashboard.',
                                    'Pemohon dapat mulai mengakses menu pengajuan atau riwayat peminjaman.',
                                ],
                                'images' => [
                                    'pemohon_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Dashboard pemohon setelah login',
                                ],
                            ],
                        ],
                    ],

                    'dashboard' => [
                        'title' => 'Dashboard Pemohon',
                        'icon' => 'fa-chart-line',
                        'description' => 'Dashboard Pemohon digunakan untuk melihat ringkasan pengajuan peminjaman ruangan.',
                        'sections' => [
                            [
                                'title' => 'A. Melihat Ringkasan Peminjaman',
                                'description' => 'Pemohon dapat memantau jumlah pengajuan berdasarkan statusnya.',
                                'steps' => [
                                    'Setelah login, pemohon masuk ke halaman dashboard.',
                                    'Dashboard menampilkan ringkasan pengajuan yang menunggu, disetujui, atau ditolak.',
                                    'Gunakan ringkasan ini untuk memantau pengajuan yang sudah dibuat.',
                                ],
                                'images' => [
                                    'pemohon_dashboard.webp',
                                ],
                                'image_captions' => [
                                    'Dashboard pemohon',
                                ],
                            ],
                        ],
                    ],

                    'jadwal' => [
                    'title' => 'Jadwal Ruangan',
                    'icon' => 'fa-calendar-days',
                    'description' => 'Menu Jadwal Ruangan digunakan pemohon untuk melihat jadwal penggunaan ruangan secara lengkap sebelum melakukan pengajuan peminjaman.',
                    'sections' => [
                        [
                            'title' => 'A. Membuka Menu Jadwal Ruangan',
                            'description' => 'Pemohon dapat membuka menu Jadwal Ruangan untuk melihat daftar penggunaan ruangan yang sudah terjadwal.',
                            'steps' => [
                                'Pilih menu Jadwal Ruangan pada sidebar.',
                                'Sistem menampilkan daftar jadwal penggunaan ruangan.',
                                'Pemohon dapat melihat informasi ruangan, tanggal, jam, lokasi, dan keterangan penggunaan.',
                            ],
                            'images' => [
                                'pemohon_jadwal_ruangan.webp',
                            ],
                            'image_captions' => [
                                'Halaman jadwal ruangan pemohon',
                            ],
                        ],
                        [
                            'title' => 'B. Memfilter Jadwal Ruangan',
                            'description' => 'Filter jadwal digunakan untuk membantu pemohon mencari jadwal ruangan sesuai kebutuhan sebelum mengajukan peminjaman.',
                            'steps' => [
                                'Gunakan filter yang tersedia pada halaman jadwal.',
                                'Pilih filter sesuai kebutuhan, seperti ruangan, tanggal, kampus, atau gedung.',
                                'Sistem menampilkan jadwal berdasarkan filter yang dipilih.',
                                'Gunakan informasi jadwal tersebut sebagai pertimbangan sebelum mengajukan peminjaman ruangan.',
                            ],
                            'images' => [
                                'pemohon_filter_jadwal.webp',
                            ],
                            'image_captions' => [
                                'Filter jadwal ruangan pemohon',
                            ],
                            'note' => 'Menu Jadwal Ruangan membantu pemohon melihat penggunaan ruangan yang sudah terjadwal. Pada saat pengajuan, sistem tetap hanya menampilkan ruangan yang tersedia sesuai tanggal dan jam yang dipilih.',
                        ],
                    ],
                ],

                    'pengajuan-peminjaman' => [
                        'title' => 'Pengajuan Peminjaman',
                        'icon' => 'fa-file-circle-plus',
                        'description' => 'Fitur Pengajuan Peminjaman digunakan pemohon untuk mengajukan penggunaan ruangan sesuai tanggal, jam, dan keperluan.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Form Pengajuan',
                                'description' => 'Pemohon dapat membuka form pengajuan melalui menu Pengajuan Peminjaman.',
                                'steps' => [
                                    'Pilih menu Pengajuan Peminjaman.',
                                    'Sistem menampilkan halaman list peminjaman.',
                                    'Klik tombol Ajukan Peminjaman untuk membuka form pengajuan.',
                                    'Pemohon mulai mengisi data peminjaman.',
                                ],
                                'images' => [
                                    'pemohon_pengajuan_list_peminjaman.webp',
                                ],
                                'image_captions' => [
                                    'Halaman list peminjaman',
                                ],
                            ],
                            [
                                'title' => 'B. Mengisi Data Peminjaman',
                                'description' => 'Data peminjaman harus diisi lengkap agar pengajuan dapat diproses.',
                                'steps' => [
                                    'Pilih Lokasi Kampus, Gedung, dan Lantai sesuai kebutuhan.',
                                    'Pilih tanggal peminjaman.',
                                    'Isi jam mulai dan jam selesai.',
                                    'Pilih ruangan yang tersedia.',
                                    'Isi keperluan peminjaman.',
                                    'Lengkapi data pendukung lain jika diperlukan.',
                                ],
                                'images' => [
                                    'pemohon_form_pengajuan_peminjaman.webp',
                                ],
                                'image_captions' => [
                                    'Form peminjaman',
                                ],
                                'note' => 'Sistem hanya menampilkan ruangan yang tersedia pada tanggal dan jam yang dipilih.',
                            ],
                            [
                                'title' => 'C. Mengirim Pengajuan',
                                'description' => 'Setelah data lengkap, pemohon dapat mengirim pengajuan untuk diproses oleh verifikator.',
                                'steps' => [
                                    'Periksa kembali data pengajuan.',
                                    'Klik tombol Ajukan Peminjaman.',
                                    'Sistem menyimpan pengajuan.',
                                    'Pengajuan masuk ke proses verifikasi sesuai alur yang sudah ditentukan.',
                                ],
                            ],
                        ],
                    ],

                    'riwayat-peminjaman' => [
                        'title' => 'Riwayat Peminjaman',
                        'icon' => 'fa-clock-rotate-left',
                        'description' => 'Riwayat Peminjaman digunakan pemohon untuk melihat daftar pengajuan yang pernah dibuat.',
                        'sections' => [
                            [
                                'title' => 'A. Membuka Riwayat Peminjaman',
                                'description' => 'Pemohon dapat melihat semua pengajuan yang pernah dibuat melalui menu Riwayat Peminjaman.',
                                'steps' => [
                                    'Pilih menu Riwayat Peminjaman.',
                                    'Sistem menampilkan daftar pengajuan peminjaman.',
                                    'Pemohon dapat melihat status pengajuan pada daftar tersebut.',
                                    'Gunakan fitur pencarian atau filter untuk menemukan pengajuan tertentu.',
                                    'Gunakan fitur unduh untuk menyimpan data riwayat peminjaman sebagai arsip atau dokumentasi.',
                                ],
                                'images' => [
                                    'pemohon_riwayat_peminjaman.webp',
                                ],
                                'image_captions' => [
                                    'Halaman riwayat peminjaman',
                                ],
                            ],
                            [
                                'title' => 'B. Melihat Detail dan Catatan',
                                'description' => 'Detail riwayat digunakan untuk melihat informasi pengajuan dan catatan dari verifikator.',
                                'steps' => [
                                    'Pilih salah satu data riwayat.',
                                    'Lihat detail ruangan, tanggal, jam, status, dan keperluan.',
                                    'Periksa catatan verifikator jika pengajuan ditolak atau membutuhkan perhatian.',
                                ],
                                'images' => [
                                    'pemohon_detail_riwayat_peminjaman.webp',
                                ],
                                'image_captions' => [
                                    'Detail riwayat peminjaman',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $role = $request->query('role', 'kasubag');

        if (!array_key_exists($role, $panduan)) {
            $role = 'kasubag';
        }

        $menus = $panduan[$role]['menus'];

        $menu = $request->query('menu', array_key_first($menus));

        if (!array_key_exists($menu, $menus)) {
            $menu = array_key_first($menus);
        }

        $activeItem = $menus[$menu];

        return view('layouts.panduan.panduan', compact(
            'panduan',
            'role',
            'menu',
            'menus',
            'activeItem'
        ));
    }
}
