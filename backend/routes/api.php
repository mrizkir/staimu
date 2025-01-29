<?php
$router->get('/', function () use ($router) {
  return 'PortalEkampus API';
});

$router->group(['prefix'=>'v3'], function () use ($router)
{

  //blog - categories    
  $router->get('/blog/categories',['uses'=>'Blog\CategoriesController@index','as'=>'blog-categories.index']);

  //blog - infokampus
  $router->get('/blog/pages/infokampus',['uses'=>'Blog\PageInfoKampusController@index','as'=>'blog-infokampus.index']);
  $router->post('/blog/pages/infokampus/all',['uses'=>'Blog\PageInfoKampusController@all','as'=>'blog-infokampus.all']);

  //dmaster - provinsi
  $router->get('/datamaster/provinsi',['uses'=>'DMaster\ProvinsiController@index','as'=>'provinsi.index']);
  $router->get('/datamaster/provinsi/{id}/kabupaten',['uses'=>'DMaster\ProvinsiController@kabupaten','as'=>'provinsi.kabupaten']);

  //dmaster - kabupaten
  $router->get('/datamaster/kabupaten',['uses'=>'DMaster\KabupatenController@index','as'=>'kabupaten.index']);
  $router->get('/datamaster/kabupaten/{id}/kecamatan',['uses'=>'DMaster\KabupatenController@kecamatan','as'=>'kabupaten.kecamatan']);

  //dmaster - kecamatan
  $router->get('/datamaster/kecamatan',['uses'=>'DMaster\KecamatanController@index','as'=>'kecamatan.index']);
  $router->get('/datamaster/kecamatan/{id}/desa',['uses'=>'DMaster\KecamatanController@desa','as'=>'kecamatan.desa']);

  //dmaster - tahun akademik
  $router->get('/datamaster/tahunakademik',['uses'=>'DMaster\TahunAkademikController@index','as'=>'tahunakademik.index']);
  $router->get('/datamaster/tahunakademik/{id}/daftarbulan',['uses'=>'DMaster\TahunAkademikController@daftarbulan','as'=>'tahunakademik.daftarbulan']);

  //data master - persyaratan
  $router->post('/datamaster/persyaratan',['uses'=>'DMaster\PersyaratanController@index','as'=>'persyaratan.index']);
  //id disini adalah tahun pendaftaran saat ini
  $router->post('/datamaster/persyaratan/store',['uses'=>'DMaster\PersyaratanController@store','as'=>'persyaratan.store']);
  $router->post('/datamaster/persyaratan/salin/{id}',['uses'=>'DMaster\PersyaratanController@salin','as'=>'persyaratan.salin']);
  $router->put('/datamaster/persyaratan/{id}',['uses'=>'DMaster\PersyaratanController@update','as'=>'persyaratan.update']);
  $router->post('/datamaster/persyaratan/{id}/proses',['uses'=>'DMaster\PersyaratanController@proses','as'=>'persyaratan.proses']);

  //data master - fakultas
  $router->get('/datamaster/fakultas',['uses'=>'DMaster\FakultasController@index','as'=>'fakultas.index']);
  $router->get('/datamaster/fakultas/{id}/programstudi',['uses'=>'DMaster\FakultasController@programstudi','as'=>'fakultas.programstudi']);

  //data master - program studi
  $router->get('/datamaster/programstudi',['uses'=>'DMaster\ProgramStudiController@index','as'=>'programstudi.index']);
  $router->get('/datamaster/programstudi/jenjangstudi',['uses'=>'DMaster\ProgramStudiController@jenjangstudi','as'=>'programstudi.jenjangstudi']);

  //data master - kelas
  $router->get('/datamaster/kelas',['uses'=>'DMaster\KelasController@index','as'=>'kelas.index']);

  //pendaftaran mahasiswa baru
  $router->post('/spmb/pmb/store',['uses'=>'SPMB\PMBController@store','as'=>'pmb.store']);
  $router->post('/spmb/pmb/konfirmasi',['uses'=>'SPMB\PMBController@konfirmasi','as'=>'pmb.konfirmasi']);

  //keuangan - channel pembayaran
  $router->get('/keuangan/channelpembayaran',['uses'=>'Keuangan\ChannelPembayaranController@index','as'=>'channelpembayaran.index']);

  //akademik - matakuliah
  $router->post('/akademik/matakuliah/',['uses'=>'Akademik\MatakuliahController@index','as'=>'matakuliah.index']);

  //system - daftar dosen
  $router->get('/system/usersdosen/pengampu',['uses'=>'System\UsersDosenController@pengampu','as'=>'usersdosen.pengampu']);

  //untuk uifront
  $router->get('/system/setting/uifront',['uses'=>'System\UIController@frontend','as'=>'uifront.frontend']);

  //auth login
  $router->post('/auth/login',['uses'=>'AuthController@login','as'=>'auth.login']);
});

$router->group(['prefix'=>'v3','middleware'=>'auth:api'], function () use ($router)
{
  //authentication
  $router->post('/auth/logout',['uses'=>'AuthController@logout','as'=>'auth.logout']);
  $router->get('/auth/refresh',['uses'=>'AuthController@refresh','as'=>'auth.refresh']);
  $router->get('/auth/me',['uses'=>'AuthController@me','as'=>'auth.me']);

  // dashboard
  $router->post('/dashboard/pmb',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\SPMBController@index','as'=>'dashboardspmb.index']);
  $router->post('/dashboard/keuangan',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\KeuanganController@index','as'=>'dashboardkeuangan.index']);

  //blog - categories (term)
  $router->post('/blog/categories',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\CategoriesController@store','as'=>'blog-categories.store']);
  $router->put('/blog/categories/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\CategoriesController@update','as'=>'blog-categories.update']);
  $router->delete('/blog/categories/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\CategoriesController@destroy','as'=>'blog-categories.destroy']);
  
  //blog - pages
  $router->post('/blog/pages/infokampus/store',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\PageInfoKampusController@store','as'=>'blog-infokampus.store']);
  $router->get('/blog/pages/infokampus/config',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\PageInfoKampusController@config','as'=>'blog-infokampus.config']);
  $router->get('/blog/pages/infokampus/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\PageInfoKampusController@show','as'=>'blog-infokampus.show']);
  $router->put('/blog/pages/infokampus/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\PageInfoKampusController@update','as'=>'blog-infokampus.update']);
  $router->delete('/blog/pages/infokampus/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|pmb'],'uses'=>'Blog\PageInfoKampusController@destroy','as'=>'blog-infokampus.destroy']);
  
  //data master - kelas
  $router->post('/datamaster/kelas/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\KelasController@store','as'=>'kelas.store']);
  $router->put('/datamaster/kelas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\KelasController@update','as'=>'kelas.update']);
  $router->delete('/datamaster/kelas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\KelasController@destroy','as'=>'kelas.destroy']);

  //data master - ruangan kelas
  $router->get('/datamaster/ruangankelas',['middleware'=>['role:superadmin|pmb'],'uses'=>'DMaster\RuanganKelasController@index','as'=>'ruangankelas.index']);
  $router->post('/datamaster/ruangankelas/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\RuanganKelasController@store','as'=>'ruangankelas.store']);
  $router->get('/datamaster/ruangankelas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\RuanganKelasController@show','as'=>'ruangankelas.show']);
  $router->put('/datamaster/ruangankelas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\RuanganKelasController@update','as'=>'ruangankelas.update']);
  $router->delete('/datamaster/ruangankelas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\RuanganKelasController@destroy','as'=>'ruangankelas.destroy']);

  //data master - channel marketing pmb
  $router->get('/datamaster/channelmarketing',['middleware'=>['role:superadmin|pmb|mahasiswabaru|mahasiswa'],'uses'=>'DMaster\ChannelMarketingController@index','as'=>'channel-marketing.index']);
  $router->post('/datamaster/channelmarketing/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ChannelMarketingController@store','as'=>'channel-marketing.store']);
  $router->get('/datamaster/channelmarketing/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ChannelMarketingController@show','as'=>'channel-marketing.show']);
  $router->put('/datamaster/channelmarketing/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ChannelMarketingController@update','as'=>'channel-marketing.update']);
  $router->delete('/datamaster/channelmarketing/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ChannelMarketingController@destroy','as'=>'channel-marketing.destroy']);

  //data master - persyaratan
  $router->post('/datamaster/persyaratan/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\PersyaratanController@store','as'=>'persyaratan.store']);
  $router->put('/datamaster/persyaratan/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\PersyaratanController@update','as'=>'persyaratan.update']);
  $router->delete('/datamaster/persyaratan/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\PersyaratanController@destroy','as'=>'persyaratan.destroy']);

  //data master - tahun akademik
  $router->post('/datamaster/tahunakademik/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\TahunAkademikController@store','as'=>'tahunakademik.store']);
  $router->put('/datamaster/tahunakademik/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\TahunAkademikController@update','as'=>'tahunakademik.update']);
  $router->delete('/datamaster/tahunakademik/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\TahunAkademikController@destroy','as'=>'tahunakademik.destroy']);

  //data master - jabatan akademik
  $router->get('/datamaster/jabatanakademik',['uses'=>'DMaster\JabatanAkademikController@index','as'=>'jabatanakademik.index']);

  //data master - jenjang studi
  $router->get('/datamaster/jenjangstudi',['uses'=>'DMaster\JenjangStudiController@index','as'=>'jenjangstudi.index']);

  //data master - status mahasiswa
  $router->get('/datamaster/statusmahasiswa',['uses'=>'DMaster\StatusMahasiswaController@index','as'=>'statusmahasiswa.index']);

  //data master - fakultas
  $router->post('/datamaster/fakultas/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\FakultasController@store','as'=>'fakultas.store']);
  $router->put('/datamaster/fakultas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\FakultasController@update','as'=>'fakultas.update']);
  $router->delete('/datamaster/fakultas/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\FakultasController@destroy','as'=>'fakultas.destroy']);

  //data master - program studi
  $router->post('/datamaster/programstudi/store',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@store','as'=>'programstudi.store']);
  $router->get('/datamaster/programstudi/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@show','as'=>'programstudi.show']);
  $router->put('/datamaster/programstudi/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@update','as'=>'programstudi.update']);
  $router->put('/datamaster/programstudi/updateconfig/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@updateconfig','as'=>'programstudi.updateconfig']);
  $router->get('/datamaster/programstudi/skslulus/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@skslulus','as'=>'programstudi.skslulus']);
  $router->post('/datamaster/programstudi/loadskslulus',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@loadskslulus','as'=>'programstudi.loadskslulus']);
  $router->post('/datamaster/programstudi/updateskslulus',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@updateskslulus','as'=>'programstudi.updateskslulus']);
  
  $router->get('/datamaster/programstudi/matkulskripsi/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@matkulskripsi','as'=>'programstudi.matkulskripsi']);    
  $router->post('/datamaster/programstudi/loadmatkulskripsi',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@loadmatkulskripsi','as'=>'programstudi.loadmatkulskripsi']);
  $router->post('/datamaster/programstudi/updatematkulskripsi',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@updatematkulskripsi','as'=>'programstudi.updatematkulskripsi']);
  $router->delete('/datamaster/programstudi/{id}',['middleware'=>['role:superadmin'],'uses'=>'DMaster\ProgramStudiController@destroy','as'=>'programstudi.destroy']);

  //data master - kuesioner - kelompok pertanyaan
  $router->get('/dmaster/kuesioner/kelompokpertanyaan',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'DMaster\KelompokPertanyaanController@index','as'=>'kelompokpertanyaan.index']);
  $router->post('/dmaster/kuesioner/kelompokpertanyaan/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\KelompokPertanyaanController@store','as'=>'kelompokpertanyaan.store']);
  $router->get('/dmaster/kuesioner/kelompokpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\KelompokPertanyaanController@show','as'=>'kelompokpertanyaan.show']);
  $router->put('/dmaster/kuesioner/kelompokpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\KelompokPertanyaanController@update','as'=>'kelompokpertanyaan.update']);
  $router->delete('/dmaster/kuesioner/kelompokpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\KelompokPertanyaanController@destroy','as'=>'kelompokpertanyaan.destroy']);
  
  //data master - kuesioner - daftar pertanyaan
  $router->get('/dmaster/kuesioner/daftarpertanyaan',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'DMaster\DaftarPertanyaanController@index','as'=>'daftarpertanyaan.index']);
  $router->post('/dmaster/kuesioner/daftarpertanyaan/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\DaftarPertanyaanController@store','as'=>'daftarpertanyaan.store']);
  $router->get('/dmaster/kuesioner/daftarpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\DaftarPertanyaanController@show','as'=>'daftarpertanyaan.show']);
  $router->put('/dmaster/kuesioner/daftarpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\DaftarPertanyaanController@update','as'=>'daftarpertanyaan.update']);
  $router->delete('/dmaster/kuesioner/daftarpertanyaan/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'DMaster\DaftarPertanyaanController@destroy','as'=>'daftarpertanyaan.destroy']);

  //spmb - soal pmb
  $router->post('/spmb/soalpmb',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\SoalPMBController@index','as'=>'soalpmb.index']);
  $router->post('/spmb/soalpmb/store',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\SoalPMBController@store','as'=>'soalpmb.store']);
  $router->get('/spmb/soalpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\SoalPMBController@show','as'=>'soalpmb.show']);
  $router->put('/spmb/soalpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\SoalPMBController@update','as'=>'soalpmb.update']);
  $router->delete('/spmb/soalpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\SoalPMBController@destroy','as'=>'soalpmb.destroy']);

  //spmb - pendaftaran mahasiswa baru
  $router->post('/spmb/pmb',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PMBController@index','as'=>'pmb.index']);
  $router->post('/spmb/pmb/storependaftar',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBController@storependaftar','as'=>'pmb.storependaftar']);
  $router->post('/spmb/pmb/resend',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBController@resend','as'=>'pmb.resend']);
  $router->put('/spmb/pmb/updatependaftar/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBController@updatependaftar','as'=>'pmb.updatependaftar']);
  $router->delete('/spmb/pmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBController@destroy','as'=>'pmb.destroy']);

  //spmb - formulir pendaftaran
  $router->post('/spmb/formulirpendaftaran',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PMBController@formulirpendaftaran','as'=>'formulirpendaftaran.index']);
  $router->get('/spmb/formulirpendaftaran/{id}',['middleware'=>['role:superadmin|pmb|mahasiswabaru|mahasiswa'],'uses'=>'SPMB\PMBController@show','as'=>'formulirpendaftaran.show']);
  $router->get('/spmb/formulirpendaftaran/{id}/cekdulang',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBController@cekdulang','as'=>'formulirpendaftaran.cekdulang']);
  $router->put('/spmb/formulirpendaftaran/{id}',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBController@update','as'=>'formulirpendaftaran.update']);	

  //spmb - jadwal ujian pmb
  $router->post('/spmb/jadwalujianpmb',['middleware'=>['role:superadmin|pmb|mahasiswabaru|keuangan'],'uses'=>'SPMB\JadwalUjianPMBController@index','as'=>'jadwalujianpmb.index']);
  $router->post('/spmb/jadwalujianpmb/store',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\JadwalUjianPMBController@store','as'=>'jadwalujianpmb.store']);
  $router->get('/spmb/jadwalujianpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\JadwalUjianPMBController@show','as'=>'jadwalujianpmb.show']);
  $router->put('/spmb/jadwalujianpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\JadwalUjianPMBController@update','as'=>'jadwalujianpmb.update']);
  $router->put('/spmb/jadwalujianpmb/updatestatusujian/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\JadwalUjianPMBController@updatestatusujian','as'=>'jadwalujianpmb.updatestatusujian']);
  $router->delete('/spmb/jadwalujianpmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\JadwalUjianPMBController@destroy','as'=>'jadwalujianpmb.destroy']);

  //spmb - passing grade
  $router->post('/spmb/passinggrade',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBPassingGradeController@index','as'=>'passinggrade.index']);
  $router->post('/spmb/passinggrade/loadprodi',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBPassingGradeController@loadprodi','as'=>'passinggrade.loadprodi']);
  $router->put('/spmb/passinggrade/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBPassingGradeController@update','as'=>'passinggrade.update']);

  //spmb - ujianonline
  //spmb/ujianonline/jadwal, digunakan untuk mendapatkan daftar jadwal ujian dengan berbagai macam kriteria
  $router->post('/spmb/ujianonline/jadwal',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@jadwal','as'=>'spmbujianonline.jadwal']);
  //spmb/ujianonline/soal/{id}, id disini di isi dengan user_id. digunakan untuk mendapatkan daftar soal ujian
  $router->get('/spmb/ujianonline/soal/{id}',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@soal','as'=>'spmbujianonline.soal']);
  //spmb/ujianonline/jawaban/{id}, id disini di isi dengan user_id. digunakan untuk mendapatkan daftar jawaban ujian
  $router->get('/spmb/ujianonline/jawaban/{id}',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@jawaban','as'=>'spmbujianonline.jawaban']);
  //spmb/ujianonline/peserta/{id}, id disini di isi dengan user_id. digunakan untuk mendapatkan data kepersertaan dalam satu ujian
  $router->get('/spmb/ujianonline/peserta/{id}',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@peserta','as'=>'spmbujianonline.peserta']);
  //spmb/ujianonline/daftar, id disini di isi dengan user_id. digunakan untuk mendaftarkan calon mahasiswa ke jadwal ujian
  $router->post('/spmb/ujianonline/daftar',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@daftarujian','as'=>'spmbujianonline.daftar']);
   //spmb/ujianonline/daftar, id disini di isi dengan user_id. digunakan untuk menghapus / keluar calon mahasiswa dari jadwal ujian
   $router->delete('/spmb/ujianonline/keluar',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@keluar','as'=>'spmbujianonline.keluar']);
  //spmb/ujianonline/mulaiujian, digunakan untuk mendaftarkan memulai ujian
  $router->put('/spmb/ujianonline/mulaiujian',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@mulaiujian','as'=>'spmbujianonline.mulaiujian']);
  //spmb/ujianonline/store, digunakan untuk menyimpan jawaban soal ujian online
  $router->post('/spmb/ujianonline/store',['middleware'=>['role:mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@store','as'=>'spmbujianonline.store']);
  //spmb/ujianonline/selesaiujian, digunakan untuk selesai ujian
  $router->put('/spmb/ujianonline/selesaiujian',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBUjianOnlineController@selesaiujian','as'=>'spmbujianonline.selesaiujian']);

  //spmb - nilai ujian
  $router->post('/spmb/nilaiujian',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\NilaiUjianController@index','as'=>'nilaiujian.index']);
  //spmb/nilaiujian/{id}, id disini di is dengan user_id
  $router->get('/spmb/nilaiujian/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\NilaiUjianController@show','as'=>'nilaiujian.show']);
  $router->put('/spmb/nilaiujian/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\NilaiUjianController@update','as'=>'nilaiujian.update']);
  $router->delete('/spmb/nilaiujian/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\NilaiUjianController@destroy','as'=>'nilaiujian.destroy']);
  $router->post('/spmb/nilaiujian/store',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\NilaiUjianController@store','as'=>'nilaiujian.store']);

  //spmb - peserta lulus
  $router->post('/spmb/pesertalulus',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PesertaLulusController@index','as'=>'pesertalulus.index']);
  $router->post('/spmb/pesertalulus/printtoexcel',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PesertaLulusController@printtoexcel','as'=>'pesertalulus.printtoexcel']);
  
  //spmb - peserta dulang
  $router->post('/spmb/pesertadulang',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PesertaDulangController@index','as'=>'pesertadulang.index']);
  $router->post('/spmb/pesertadulang/printtoexcel',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\PesertaDulangController@printtoexcel','as'=>'pesertadulang.printtoexcel']);

  //spmb - report fakultas
  $router->post('/spmb/reportspmbfakultas',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\ReportSPMBFakultasController@index','as'=>'reportspmbfakultas.index']);
  $router->post('/spmb/reportspmbfakultas/printtoexcel',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\ReportSPMBFakultasController@printtoexcel','as'=>'reportspmbfakultas.printtoexcel']);

  //spmb - report prodi
  $router->post('/spmb/reportspmbprodi/printtoexcel',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\ReportSPMBProdiController@printtoexcel','as'=>'reportspmbprodi.printtoexcel']);

  //spmb - report report kelulusan
  $router->post('/spmb/reportspmbkelulusan',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\ReportKelulusanController@index','as'=>'reportspmbkelulusan.index']);
  $router->post('/spmb/reportspmbkelulusan/printtoexcel',['middleware'=>['role:superadmin|pmb|keuangan'],'uses'=>'SPMB\ReportKelulusanController@printtoexcel','as'=>'reportspmbkelulusan.printtoexcel']);

  //spmb - persyaratan
  $router->post('/spmb/pmbpersyaratan',['middleware'=>['role:superadmin|pmb|mahasiswabaru|keuangan'],'uses'=>'SPMB\PMBPersyaratanController@index','as'=>'pmbpersyaratan.index']);
  $router->get('/spmb/pmbpersyaratan/{id}',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBPersyaratanController@show','as'=>'pmbpersyaratan.show']);
  $router->post('/spmb/pmbpersyaratan/upload/{id}',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBPersyaratanController@upload','as'=>'pmbpersyaratan.upload']);
  $router->post('/spmb/pmbpersyaratan/verifikasipersyaratan/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'SPMB\PMBPersyaratanController@verifikasipersyaratan','as'=>'pmbpersyaratan.verifikasipersyaratan']);
  $router->delete('/spmb/pmbpersyaratan/hapusfilepersyaratan/{id}',['middleware'=>['role:superadmin|pmb|mahasiswabaru'],'uses'=>'SPMB\PMBPersyaratanController@hapusfilepersyaratan','as'=>'pmbpersyaratan.hapusfilepersyaratan']);

  //keuangan - status transaksi
  $router->get('/keuangan/statustransaksi',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\StatusTransaksiController@index','as'=>'statustransaksi.index']);
  $router->put('/keuangan/statustransaksi/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\StatusTransaksiController@update','as'=>'statustransaksi.update']);

  //keuangan - komponen biaya
  $router->get('/keuangan/komponenbiaya',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\KomponenBiayaController@index','as'=>'keuangan.index']);

  //keuangan - biaya komponen periode
  $router->post('/keuangan/biayakomponenperiode',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\BiayaKomponenPeriodeController@index','as'=>'biayakomponenperiode.index']);
  $router->post('/keuangan/biayakomponenperiode/loadkombiperiode',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\BiayaKomponenPeriodeController@loadkombiperiode','as'=>'biayakomponenperiode.loadkombiperiode']);
  $router->post('/keuangan/biayakomponenperiode/updatebiaya',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\BiayaKomponenPeriodeController@updatebiaya','as'=>'biayakomponenperiode.updatebiaya']);

  //keuangan - metode pembayaran [transfer bank]
  $router->get('/keuangan/transferbank',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransferBankController@index','as'=>'transferbank.index']);
  $router->post('/keuangan/transferbank/store',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransferBankController@store','as'=>'transferbank.store']);
  $router->get('/keuangan/transferbank/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransferBankController@show','as'=>'transferbank.show']);
  $router->put('/keuangan/transferbank/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransferBankController@update','as'=>'transferbank.update']);
  $router->delete('/keuangan/transferbank/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransferBankController@destroy','as'=>'transferbank.destroy']);

  //keuangan - transaksi
  $router->post('/keuangan/transaksi',['middleware'=>['role:superadmin|keuangan|mahasiswabaru|mahasiswa'],'uses'=>'Keuangan\TransaksiController@index','as'=>'transaksi.index']);
  $router->get('/keuangan/transaksi/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiController@show','as'=>'transaksi.show']);
  $router->post('/keuangan/transaksi/cancel',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiController@cancel','as'=>'transaksi.cancel']);
  $router->put('/keuangan/transaksi/verifikasi/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiController@verifikasi','as'=>'transaksi.verifikasi']);
  //digunakan untuk mendapatkan transaksi daftar ulang milik user_id mhs baru dengan status sudah bayar
  $router->post('/keuangan/transaksi/{id}/dulangmhsbaru',['uses'=>'Keuangan\TransaksiController@dulangmhsbaru','as'=>'transaksi.dulangmhsbaru']);
  //digunakan untuk mendapatkan spp milik user_id mhs baru dengan status sudah bayar
  $router->post('/keuangan/transaksi/{id}/sppmhsbaru',['uses'=>'Keuangan\TransaksiController@sppmhsbaru','as'=>'transaksi.sppmhsbaru']);
  $router->delete('/keuangan/transaksi/{$id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiController@cancel','as'=>'transaksi.cancel']);

  //keuangan - buka nilai
  $router->post('/keuangan/bukanilai',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\BukaNilaiController@index','as'=>'bukanilai.index']);
  $router->put('/keuangan/bukanilai/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\BukaNilaiController@update','as'=>'bukanilai.update']);

  //keuangan - transaksi spp
  $router->post('/keuangan/transaksi-spp',['middleware'=>['role:superadmin|keuangan|mahasiswabaru|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@index','as'=>'transaksi-spp.index']);
  $router->get('/keuangan/transaksi-spp/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@show','as'=>'transaksi-spp.show']);
  //id disini adalah user_id mhs
  $router->get('/keuangan/transaksi-spp/{id}/mhs',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@sppmahasiswa','as'=>'transaksi-spp.sppmahasiswa']);
  $router->post('/keuangan/transaksi-spp/new',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@newtransaction','as'=>'transaksi-spp.new']);
  $router->post('/keuangan/transaksi-spp/store',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@store','as'=>'transaksi-spp.store']);
  // id delete detail id
  $router->delete('/keuangan/transaksi-spp/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiSPPController@destroy','as'=>'transaksi-spp.destroy']);
  $router->post('/keuangan/transaksi-spp/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiSPPController@printtoexcel1','as'=>'transaksi-spp.printtoexcel1']);
  $router->post('/keuangan/transaksi-spp/printtoexcel3',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiSPPController@printtoexcel3','as'=>'transaksi-spp.printtoexcel3']);
  

  //keuangan - laporan pendaftaran mahasiswa baru
  $router->post('/keuangan/transaksi-laporanpendaftaran',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanPendaftaranController@index','as'=>'transaksi-laporanpendaftaran.index']);
  $router->post('/keuangan/transaksi-laporanpendaftaran/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanPendaftaranController@printtoexcel1','as'=>'transaksi-laporanpendaftaran.printtoexcel1']);
  
  //keuangan - laporan daftar ulang mahasiswa baru
  $router->post('/keuangan/transaksi-laporandulangmhsbaru',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanDulangMHSBaruController@index','as'=>'transaksi-laporandulangmhsbaru.index']);
  $router->post('/keuangan/transaksi-laporandulangmhsbaru/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanDulangMHSBaruController@printtoexcel1','as'=>'transaksi-laporandulangmhsbaru.printtoexcel1']);
  
  //keuangan - laporan penerimaan spp
  $router->post('/keuangan/transaksi-laporanspp',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanSPPController@index','as'=>'transaksi-laporanspp.index']);
  $router->post('/keuangan/transaksi-laporanspp/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanSPPController@printtoexcel1','as'=>'transaksi-laporanspp.printtoexcel1']);
  
  //keuangan - laporan penerimaan spp per semester
  $router->post('/keuangan/transaksi-laporanspppersemester',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanSPPPerSemesterController@index','as'=>'transaksi-laporanspppersemester.index']);
  $router->post('/keuangan/transaksi-laporanspppersemester/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanSPPPerSemesterController@printtoexcel1','as'=>'transaksi-laporanspppersemester.printtoexcel1']);
  
  //keuangan - laporan penerimaan registrasi krs
  $router->post('/keuangan/transaksi-laporanregistrasikrs',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanRegistrasiKRSController@index','as'=>'transaksi-laporanregistrasikrs.index']);
  $router->post('/keuangan/transaksi-laporanregistrasikrs/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanRegistrasiKRSController@printtoexcel1','as'=>'transaksi-laporanregistrasikrs.printtoexcel1']);
  
  //keuangan - laporan penerimaan ujian munaqasah
  $router->post('/keuangan/transaksi-laporanujianmunaqasah',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanUjianMunaqasahController@index','as'=>'transaksi-laporanujianmunaqasah.index']);
  $router->post('/keuangan/transaksi-laporanujianmunaqasah/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiLaporanUjianMunaqasahController@printtoexcel1','as'=>'transaksi-laporanujianmunaqasah.printtoexcel1']);

  //keuangan - transaksi daftar ulang mahasiswa baru
  $router->post('/keuangan/transaksi-dulangmhsbaru',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiDulangMHSBaruController@index','as'=>'transaksi-dulangmhsbaru.index']);
  $router->post('/keuangan/transaksi-dulangmhsbaru/store',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiDulangMHSBaruController@store','as'=>'transaksi-dulangmhsbaru.store']);
  $router->delete('/keuangan/transaksi-dulangmhsbaru/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiDulangMHSBaruController@destroy','as'=>'transaksi-dulangmhsbaru.destroy']);
  $router->post('/keuangan/transaksi-dulangmhsbaru/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiDulangMHSBaruController@printtoexcel1','as'=>'transaksi-dulangmhsbaru.printtoexcel1']);

  //keuangan - transaksi regisrasikrs
  $router->post('/keuangan/transaksi-registrasikrs',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiRegistrasiKRSController@index','as'=>'transaksi-registrasikrs.index']);
  $router->post('/keuangan/transaksi-registrasikrs/store',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiRegistrasiKRSController@store','as'=>'transaksi-registrasikrs.store']);
  $router->post('/keuangan/transaksi-registrasikrs/printtoexcel1',['middleware'=>['role:superadmin|keuangan'],'uses'=>'Keuangan\TransaksiRegistrasiKRSController@printtoexcel1','as'=>'transaksi-registrasikrs.printtoexcel1']);
  $router->delete('/keuangan/transaksi-registrasikrs/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiRegistrasiKRSController@destroy','as'=>'transaksi-registrasikrs.destroy']);
  
  //keuangan - transaksi kkn
  $router->post('/keuangan/transaksi-kkn',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiKKNController@index','as'=>'transaksi-kkn.index']);
  $router->post('/keuangan/transaksi-kkn/store',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiKKNController@store','as'=>'transaksi-kkn.store']);
  $router->delete('/keuangan/transaksi-kkn/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiKKNController@destroy','as'=>'transaksi-kkn.destroy']);
  
  //keuangan - transaksi ujian munaqasah
  $router->post('/keuangan/transaksi-ujianmunaqasah',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiUjianMunaqasahController@index','as'=>'transaksi-ujianmunaqasah.index']);
  $router->post('/keuangan/transaksi-ujianmunaqasah/store',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiUjianMunaqasahController@store','as'=>'transaksi-ujianmunaqasah.store']);
  $router->delete('/keuangan/transaksi-ujianmunaqasah/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiUjianMunaqasahController@destroy','as'=>'transaksi-ujianmunaqasah.destroy']);
  
  //keuangan - transaksi ppl / pkl
  $router->post('/keuangan/transaksi-pplpkl',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiPPLPKLController@index','as'=>'transaksi-pplpkl.index']);
  $router->post('/keuangan/transaksi-pplpkl/store',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiPPLPKLController@store','as'=>'transaksi-pplpkl.store']);
  $router->delete('/keuangan/transaksi-pplpkl/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa'],'uses'=>'Keuangan\TransaksiPPLPKLController@destroy','as'=>'transaksi-pplpkl.destroy']);

  //keuangan - konfirmasi pembayaran
  $router->post('/keuangan/konfirmasipembayaran',['middleware'=>['role:superadmin|keuangan|mahasiswa|mahasiswabaru'],'uses'=>'Keuangan\KonfirmasiPembayaranController@index','as'=>'konfirmasipembayaran.index']);
  $router->post('/keuangan/konfirmasipembayaran/store',['middleware'=>['role:superadmin|keuangan|mahasiswa|mahasiswabaru'],'uses'=>'Keuangan\KonfirmasiPembayaranController@store','as'=>'konfirmasipembayaran.store']);
  $router->get('/keuangan/konfirmasipembayaran/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa|mahasiswabaru'],'uses'=>'Keuangan\KonfirmasiPembayaranController@show','as'=>'konfirmasipembayaran.show']);
  $router->put('/keuangan/konfirmasipembayaran/{id}',['middleware'=>['role:superadmin|keuangan|mahasiswa|mahasiswabaru'],'uses'=>'Keuangan\KonfirmasiPembayaranController@update','as'=>'konfirmasipembayaran.update']);

  //akademik - dosen wali
  $router->get('/akademik/dosenwali',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DosenWaliController@index','as'=>'dosenwali.index']);
  $router->post('/akademik/dosenwali/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DosenWaliController@store','as'=>'dosenwali.store']);
  $router->get('/akademik/dosenwali/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DosenWaliController@show','as'=>'dosenwali.show']);
  $router->put('/akademik/dosenwali/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DosenWaliController@update','as'=>'dosenwali.update']);
  $router->delete('/akademik/dosenwali/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DosenWaliController@destroy','as'=>'dosenwali.destroy']);

  //akademik - group matakuliah
  $router->get('/akademik/groupmatakuliah/',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\GroupMatakuliahController@index','as'=>'groupmatakuliah.index']);

  //akademik - matakuliah
  $router->post('/akademik/matakuliah/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@store','as'=>'matakuliah.store']);
  $router->get('/akademik/matakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@show','as'=>'matakuliah.show']);
  $router->put('/akademik/matakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@update','as'=>'matakuliah.update']);
  $router->delete('/akademik/matakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@destroy','as'=>'matakuliah.destroy']);
  //id disini adalah tujuan salin matakuliah
  $router->post('/akademik/matakuliah/salinmatkul/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@salinmatkul','as'=>'matakuliah.salinmatkul']);
  //daftar matakuliah yang tidak ada di dalam penyelenggaraan
  $router->post('/akademik/matakuliah/penyelenggaraan',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\MatakuliahController@penyelenggaraan','as'=>'matakuliah.penyelenggaraan']);

  //akademik - dulang
  $router->post('/akademik/dulang/dulangnotinkrs',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\DulangController@dulangnotinkrs','as'=>'dulang.dulangnotinkrs']);
  $router->post('/akademik/dulang/cekdulangkrs',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\DulangController@cekdulangkrs','as'=>'dulang.cekdulangkrs']);
  //id disini adalah dulang_id
  $router->put('/akademik/dulang/{id}/updatebiodata',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\DulangController@updatebiodata','as'=>'dulang.updatebiodata']);


  //akademik - daftar ulang - mahasiswa belum punya nim
  $router->post('/akademik/dulang/mhsbelumpunyanim',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\MahasiswaBelumPunyaNIMController@index','as'=>'mhsbelumpunyanim.index']);
  $router->post('/akademik/dulang/mhsbelumpunyanim/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\MahasiswaBelumPunyaNIMController@store','as'=>'mhsbelumpunyanim.store']);

  //akademik - daftar ulang - mahasiswa baru
  $router->post('/akademik/dulang/mhsbaru',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaBaruController@index','as'=>'dulangmhsbaru.index']);
  $router->post('/akademik/dulang/mhsbaru/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaBaruController@store','as'=>'dulangmhsbaru.store']);
  $router->get('/akademik/dulang/mhsbaru/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaBaruController@show','as'=>'dulangmhsbaru.show']);
  $router->put('/akademik/dulang/mhsbaru/{id}',['middleware'=>['role:superadmin|akademik|pmb|mahasiswabaru'],'uses'=>'Akademik\DulangMahasiswaBaruController@update','as'=>'dulangmhsbaru.update']);
  $router->delete('/akademik/dulang/mhsbaru/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaBaruController@destroy','as'=>'dulangmhsbaru.destroy']);

  //akademik - daftar ulang - mahasiswa lama
  $router->post('/akademik/dulang/mhslama',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaLamaController@index','as'=>'dulangmhslama.index']);
  $router->post('/akademik/dulang/mhslama/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLamaController@store','as'=>'dulangmhslama.store']);
  $router->get('/akademik/dulang/mhslama/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLamaController@show','as'=>'dulangmhslama.show']);
  $router->put('/akademik/dulang/mhslama/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLamaController@update','as'=>'dulangmhslama.update']);
  $router->delete('/akademik/dulang/mhslama/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLamaController@destroy','as'=>'dulangmhslama.destroy']);
  
  //akademik - daftar ulang - mahasiswa aktif
  $router->post('/akademik/dulang/mhsaktif',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaAktifController@index','as'=>'dulangmhsaktif.index']);
  $router->post('/akademik/dulang/mhsaktif/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaAktifController@store','as'=>'dulangmhsaktif.store']);
  $router->get('/akademik/dulang/mhsaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaAktifController@show','as'=>'dulangmhsaktif.show']);
  $router->put('/akademik/dulang/mhsaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaAktifController@update','as'=>'dulangmhsaktif.update']);
  $router->delete('/akademik/dulang/mhsaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaAktifController@destroy','as'=>'dulangmhsaktif.destroy']);
  
  //akademik - daftar ulang - mahasiswa nonaktif
  $router->post('/akademik/dulang/mhsnonaktif',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@index','as'=>'dulangmhsnonaktif.index']);
  $router->post('/akademik/dulang/mhsnonaktif/cek',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@cek','as'=>'dulangmhsnonaktif.cek']);
  $router->post('/akademik/dulang/mhsnonaktif/massal',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@massal','as'=>'dulangmhsnonaktif.massal']);
  $router->post('/akademik/dulang/mhsnonaktif/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@store','as'=>'dulangmhsnonaktif.store']);
  $router->get('/akademik/dulang/mhsnonaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@show','as'=>'dulangmhsnonaktif.show']);
  $router->put('/akademik/dulang/mhsnonaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@update','as'=>'dulangmhsnonaktif.update']);
  $router->delete('/akademik/dulang/mhsnonaktif/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaNonAktifController@destroy','as'=>'dulangmhsnonaktif.destroy']);

  //akademik - daftar ulang - mahasiswa cuti
  $router->post('/akademik/dulang/mhscuti',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaCutiController@index','as'=>'dulangmhscuti.index']);
  $router->post('/akademik/dulang/mhscuti/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaCutiController@store','as'=>'dulangmhscuti.store']);
  $router->get('/akademik/dulang/mhscuti/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaCutiController@show','as'=>'dulangmhscuti.show']);
  $router->put('/akademik/dulang/mhscuti/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaCutiController@update','as'=>'dulangmhscuti.update']);
  $router->delete('/akademik/dulang/mhscuti/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaCutiController@destroy','as'=>'dulangmhscuti.destroy']);
  
  //akademik - daftar ulang - mahasiswa lulus
  $router->post('/akademik/dulang/mhslulus',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaLulusController@index','as'=>'dulangmhslulus.index']);
  $router->post('/akademik/dulang/mhslulus/cek',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLulusController@cek','as'=>'dulangmhslulus.cek']);
  $router->post('/akademik/dulang/mhslulus/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLulusController@store','as'=>'dulangmhslulus.store']);
  $router->get('/akademik/dulang/mhslulus/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLulusController@show','as'=>'dulangmhslulus.show']);
  $router->put('/akademik/dulang/mhslulus/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLulusController@update','as'=>'dulangmhslulus.update']);
  $router->delete('/akademik/dulang/mhslulus/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaLulusController@destroy','as'=>'dulangmhslulus.destroy']);
  
  //akademik - daftar ulang - mahasiswa keluar
  $router->post('/akademik/dulang/mhskeluar',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaKeluarController@index','as'=>'dulangmhskeluar.index']);    
  $router->post('/akademik/dulang/mhskeluar/cek',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaKeluarController@cek','as'=>'dulangmhskeluar.cek']);
  $router->post('/akademik/dulang/mhskeluar/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaKeluarController@store','as'=>'dulangmhskeluar.store']);
  $router->get('/akademik/dulang/mhskeluar/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaKeluarController@show','as'=>'dulangmhskeluar.show']);
  $router->put('/akademik/dulang/mhskeluar/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaKeluarController@update','as'=>'dulangmhskeluar.update']);
  $router->delete('/akademik/dulang/mhskeluar/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaKeluarController@destroy','as'=>'dulangmhskeluar.destroy']);
  
  //akademik - daftar ulang - mahasiswa do
  $router->post('/akademik/dulang/mhsdo',['middleware'=>['role:superadmin|akademik|keuangan|mahasiswa'],'uses'=>'Akademik\DulangMahasiswaDOController@index','as'=>'dulangmhsdo.index']);
  $router->post('/akademik/dulang/mhsdo/cek',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaDOController@cek','as'=>'dulangmhsdo.cek']);
  $router->post('/akademik/dulang/mhsdo/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaDOController@store','as'=>'dulangmhsdo.store']);
  $router->get('/akademik/dulang/mhsdo/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaDOController@show','as'=>'dulangmhsdo.show']);
  $router->put('/akademik/dulang/mhsdo/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaDOController@update','as'=>'dulangmhsdo.update']);
  $router->delete('/akademik/dulang/mhsdo/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'Akademik\DulangMahasiswaDOController@destroy','as'=>'dulangmhsdo.destroy']);
  
  //akademik - kemahasiswaan - daftar mahasiswa
  $router->put('/akademik/kemahasiswaan/updatestatus/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'Akademik\KemahasiswaanController@updatestatus','as'=>'kemahasiswaan.updatestatus']);
  $router->put('/kemahasiswaan/biodata/{id}/update',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|mahasiswa'],'uses'=>'Akademik\KemahasiswaanController@updatebiodata','as'=>'kemahasiswaan.updatebiodata']);
  $router->put('/akademik/kemahasiswaan/updatedw/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'Akademik\KemahasiswaanController@updatedw','as'=>'kemahasiswaan.updatedw']);
  $router->post('/kemahasiswaan/daftarmhs',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|keuangan'],'uses'=>'Akademik\KemahasiswaanDaftarMahasiswaController@index','as'=>'daftarmhs.index']);
  $router->post('/kemahasiswaan/daftarmhs/printtoexcel',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|keuangan'],'uses'=>'Akademik\KemahasiswaanDaftarMahasiswaController@printtoexcel','as'=>'daftarmhs.printtoexcel']);

  $router->get('/akademik/kemahasiswaan/biodatamhs1/{id}',['middleware'=>['role:superadmin|akademik|programstudi|keuangan|mahasiswa'],'uses'=>'Akademik\MahasiswaController@biodatamhs1','as'=>'mahasiswa.biodatamhs1']);
  //uri ini diakses bila mahasiswa tidak ada tetap mengembalikan nilai yaitu null atau status = 0
  $router->get('/akademik/kemahasiswaan/biodatamhs2/{id}',['middleware'=>['role:superadmin|akademik|programstudi|keuangan|mahasiswa'],'uses'=>'Akademik\MahasiswaController@biodatamhs2','as'=>'mahasiswa.biodatamhs2']);

  //akademik - perkuliahan - penyelenggaraan
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|puslahta'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@index','as'=>'penyelenggaraanmatakuliah.index']);
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@store','as'=>'penyelenggaraanmatakuliah.store']);
  $router->get('/akademik/perkuliahan/penyelenggaraanmatakuliah/member/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@member','as'=>'penyelenggaraanmatakuliah.member']);
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah/members',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@members','as'=>'penyelenggaraanmatakuliah.members']);
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah/pengampu',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@pengampu','as'=>'penyelenggaraanmatakuliah.pengampu']);
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah/matakuliah',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@matakuliah','as'=>'penyelenggaraanmatakuliah.matakuliah']);
  $router->post('/akademik/perkuliahan/penyelenggaraanmatakuliah/storedosenpengampu',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@storedosenpengampu','as'=>'penyelenggaraanmatakuliah.storedosenpengampu']);
  $router->get('/akademik/perkuliahan/penyelenggaraanmatakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@show','as'=>'penyelenggaraanmatakuliah.show']);
  $router->put('/akademik/perkuliahan/penyelenggaraanmatakuliah/updateketua/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@updateketua','as'=>'penyelenggaraanmatakuliah.updateketua']);
  $router->delete('/akademik/perkuliahan/penyelenggaraanmatakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@destroy','as'=>'penyelenggaraanmatakuliah.destroy']);
  $router->delete('/akademik/perkuliahan/penyelenggaraanmatakuliah/deletepengampu/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PenyelenggaraanMatakuliahController@destroypengampu','as'=>'penyelenggaraanmatakuliah.destroypengampu']);

  //akademik - perkuliahan - krs
  $router->post('/akademik/perkuliahan/krs',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@index','as'=>'krs.index']);
  $router->post('/akademik/perkuliahan/krs/store',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@store','as'=>'krs.store']);
  //digunakan untuk mendapatkan daftar matakuliah yang diselenggarakan dan belum terdaftar di krsnya mhs
  $router->post('/akademik/perkuliahan/krs/penyelenggaraan',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@penyelenggaraan','as'=>'krs.penyelenggaraan']);
  $router->post('/akademik/perkuliahan/krs/storematkul',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@storematkul','as'=>'krs.storematkul']);
  $router->get('/akademik/perkuliahan/krs/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@show','as'=>'krs.show']);
  $router->put('/akademik/perkuliahan/krs/{id}/verifikasi',['middleware'=>['role:superadmin|dosenwali'],'uses'=>'Akademik\KRSController@verifikasi','as'=>'krs.verifikasi']);
  $router->post('/akademik/perkuliahan/krs/cekkrs',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@cekkrs','as'=>'krs.cekkrs']);
  $router->put('/akademik/perkuliahan/krs/updatestatus/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@updatestatus','as'=>'krs.updatestatus']);
  $router->delete('/akademik/perkuliahan/krs/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@destroy','as'=>'krs.destroy']);
  $router->delete('/akademik/perkuliahan/krs/deletematkul/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali'],'uses'=>'Akademik\KRSController@destroymatkul','as'=>'krs.destroymatkul']);
  //id krs
  $router->get('/akademik/perkuliahan/krs/printpdf/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa|dosenwali|puslahta'],'uses'=>'Akademik\KRSController@printpdf','as'=>'krs.printpdf']);

  //akademik - perkuliahan - pkrs
  $router->post('/akademik/perkuliahan/pkrs',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|mahasiswa|dosenwali'],'uses'=>'Akademik\PKRSController@index','as'=>'pkrs.index']);
  $router->post('/akademik/perkuliahan/pkrs/store',['middleware'=>['role:superadmin|dosenwali'],'uses'=>'Akademik\PKRSController@store','as'=>'pkrs.store']);
  //digunakan untuk mendapatkan daftar matakuliah yang diselenggarakan dan belum terdaftar di krsnya mhs
  $router->post('/akademik/perkuliahan/pkrs/penyelenggaraan',['middleware'=>['role:superadmin||dosenwali'],'uses'=>'Akademik\PKRSController@penyelenggaraan','as'=>'pkrs.penyelenggaraan']);
  $router->post('/akademik/perkuliahan/pkrs/storematkul',['middleware'=>['role:superadmin||dosenwali'],'uses'=>'Akademik\PKRSController@storematkul','as'=>'pkrs.storematkul']);
  $router->get('/akademik/perkuliahan/pkrs/{id}',['middleware'=>['role:superadmin|dosenwali'],'uses'=>'Akademik\PKRSController@show','as'=>'pkrs.show']);    
  $router->put('/akademik/perkuliahan/pkrs/updatestatus/{id}',['middleware'=>['role:superadmin|dosenwali'],'uses'=>'Akademik\PKRSController@updatestatus','as'=>'pkrs.updatestatus']);    
  $router->delete('/akademik/perkuliahan/pkrs/deletematkul/{id}',['middleware'=>['role:superadmin|dosenwali'],'uses'=>'Akademik\PKRSController@destroymatkul','as'=>'pkrs.destroymatkul']);

  //akademik - perkuliahan - pembagian kelas
  $router->post('/akademik/perkuliahan/pembagiankelas',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|mahasiswa|dosen'],'uses'=>'Akademik\PembagianKelasController@index','as'=>'pembagiankelas.index']);
  $router->post('/akademik/perkuliahan/pembagiankelas/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@store','as'=>'pembagiankelas.store']);
  $router->post('/akademik/perkuliahan/pembagiankelas/pengampu',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@pengampu','as'=>'pembagiankelas.pengampu']);
  $router->get('/akademik/perkuliahan/pembagiankelas/matakuliah/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@matakuliah','as'=>'pembagiankelas.matakuliah']);
  $router->get('/akademik/perkuliahan/pembagiankelas/peserta/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|dosen'],'uses'=>'Akademik\PembagianKelasController@peserta','as'=>'pembagiankelas.peserta']);
  $router->post('/akademik/perkuliahan/pembagiankelas/storematakuliah',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@storematakuliah','as'=>'pembagiankelas.storematakuliah']);
  $router->post('/akademik/perkuliahan/pembagiankelas/storepeserta',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PembagianKelasController@storepeserta','as'=>'pembagiankelas.storepeserta']);
  $router->get('/akademik/perkuliahan/pembagiankelas/{id}',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|dosen'],'uses'=>'Akademik\PembagianKelasController@show','as'=>'pembagiankelas.show']);
  //digunakan untuk mendapatkan daftar kelas berdasarkan penyelenggaraan id di sini adalah penyelenggaraan_id
  $router->get('/akademik/perkuliahan/pembagiankelas/{id}/penyelenggaraan',['middleware'=>['role:superadmin|akademik|programstudi|puslahta|dosen|mahasiswa'],'uses'=>'Akademik\PembagianKelasController@penyelenggaraan','as'=>'pembagiankelas.penyelenggaraan']);
  $router->put('/akademik/perkuliahan/pembagiankelas/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@update','as'=>'pembagiankelas.update']);
  $router->delete('/akademik/perkuliahan/pembagiankelas/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@destroy','as'=>'pembagiankelas.destroy']);
  $router->delete('/akademik/perkuliahan/pembagiankelas/deletematkul/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@destroymatkul','as'=>'pembagiankelas.destroymatkul']);
  $router->delete('/akademik/perkuliahan/pembagiankelas/deletepeserta/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\PembagianKelasController@destroypeserta','as'=>'pembagiankelas.destroypeserta']);

  // store nilai maksudnya menyimpan komponen nilai
  $router->get('/akademik/perkuliahan/pembagiankelas/nilaikomponen/{id}',['uses'=>'Akademik\PembagianKelasController@nilaikomponen','as'=>'pembagiankelas.nilaikomponen']);
  $router->post('/akademik/perkuliahan/pembagiankelas/storenilai',['middleware'=>['role:dosen'],'uses'=>'Akademik\PembagianKelasController@storenilai','as'=>'pembagiankelas.storenilai']);

  //akademik - perkuliahan - ppl / pkl
  $router->post('/akademik/perkuliahan/pplpk',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PPLPKLController@index','as'=>'pplpkl.index']);
  $router->post('/akademik/perkuliahan/pplpk/store',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PPLPKLController@store','as'=>'pplpkl.store']);
  $router->get('/akademik/perkuliahan/pplpk/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PPLPKLController@show','as'=>'pplpkl.show']);
  $router->put('/akademik/perkuliahan/pplpk/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PPLPKLController@update','as'=>'pplpkl.update']);
  $router->delete('/akademik/perkuliahan/pplpk/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\PPLPKLController@destroy','as'=>'pplpkl.destroy']);

  //akademik - perkuliahan - ujian munaqasah
  $router->post('/akademik/perkuliahan/ujianmunaqasah',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@index','as'=>'ujianmunaqasah.index']);
  //id disini nim
  $router->get('/akademik/perkuliahan/ujianmunaqasah/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@show','as'=>'ujianmunaqasah.show']);
  //id disini ujian_munaqasah_id
  $router->get('/akademik/perkuliahan/ujianmunaqasah/detail/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@detail','as'=>'ujianmunaqasah.detail']);
  $router->post('/akademik/perkuliahan/ujianmunaqasah/cekpersyaratan',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@cekpersyaratan','as'=>'ujianmunaqasah.cekpersyaratan']);
  $router->post('/akademik/perkuliahan/ujianmunaqasah/upload/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@upload','as'=>'ujianmunaqasah.upload']);
  $router->post('/akademik/perkuliahan/ujianmunaqasah/store',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@store','as'=>'ujianmunaqasah.store']);
  $router->put('/akademik/perkuliahan/ujianmunaqasah/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@update','as'=>'ujianmunaqasah.update']);
  //id disinis persyaratan_ujian_munaqasah_id
  $router->put('/akademik/perkuliahan/ujianmunaqasah/{id}/updatepersyaratan',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\UjianMunaqasahController@updatepersyaratan','as'=>'ujianmunaqasah.updatepersyaratan']);
  //id disini ujian_munaqasah_id
  $router->put('/akademik/perkuliahan/ujianmunaqasah/{id}/verifikasi',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Akademik\UjianMunaqasahController@verifikasi','as'=>'ujianmunaqasah.verifikasi']);
  $router->delete('/akademik/perkuliahan/ujianmunaqasah/{id}',['middleware'=>['role:superadmin|akademik|programstudi|mahasiswa'],'uses'=>'Akademik\UjianMunaqasahController@destroy','as'=>'ujianmunaqasah.destroy']);
  
  //akademik - perkuliahan - nilai konversi
  $router->post('/akademik/nilai/konversi',['uses'=>'Akademik\NilaiKonversiController@index','as'=>'nilaikonversi.index']);
  $router->post('/akademik/nilai/konversi/matakuliah',['uses'=>'Akademik\NilaiKonversiController@matakuliah','as'=>'nilaikonversi.matakuliah']);        
  $router->post('/akademik/nilai/konversi/store',['uses'=>'Akademik\NilaiKonversiController@store','as'=>'nilaikonversi.store']);        
  $router->get('/akademik/nilai/konversi/{id}',['uses'=>'Akademik\NilaiKonversiController@show','as'=>'nilaikonversi.show']);        
  $router->put('/akademik/nilai/konversi/{id}',['uses'=>'Akademik\NilaiKonversiController@update','as'=>'nilaikonversi.update']);        
  $router->post('/akademik/nilai/konversi/plugtomhs',['uses'=>'Akademik\NilaiKonversiController@plugtomhs','as'=>'nilaikonversi.plugtomhs']);        
  $router->post('/akademik/nilai/konversi/unplugtomhs',['uses'=>'Akademik\NilaiKonversiController@unplugtomhs','as'=>'nilaikonversi.unplugtomhs']);        
  $router->delete('/akademik/nilai/konversi/{id}',['uses'=>'Akademik\NilaiKonversiController@destroy','as'=>'nilaikonversi.destroy']);        
  $router->get('/akademik/nilai/konversi/printpdf1/{id}',['uses'=>'Akademik\NilaiKonversiController@printpdf1','as'=>'nilaikonversi.printpdf1']);    

  //akademik - perkuliahan - nilai - waktu pengisian    
  $router->post('/akademik/nilai/waktupengisian',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiWaktuPengisianController@index','as'=>'waktupengisian.index']);
  $router->get('/akademik/nilai/waktupengisian/{id}',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiWaktuPengisianController@show','as'=>'waktupengisian.show']);
  $router->post('/akademik/nilai/waktupengisian/store',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiWaktuPengisianController@store','as'=>'waktupengisian.store']);	
  $router->put('/akademik/nilai/waktupengisian/{id}',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiWaktuPengisianController@update','as'=>'waktupengisian.update']);	
  $router->delete('/akademik/nilai/waktupengisian/{id}',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiWaktuPengisianController@destroy','as'=>'waktupengisian.destroy']);

  //akademik - perkuliahan - nilai
  $router->post('/akademik/nilai/matakuliah',['middleware'=>['role:superadmin|akademik|puslahta'],'uses'=>'Akademik\NilaiMatakuliahController@index','as'=>'nilaimatakuliah.index']);
  //id disini adalah kelas_mhs_id
  $router->get('/akademik/nilai/matakuliah/pesertakelas/{id}',['middleware'=>['role:puslahta|dosen'],'uses'=>'Akademik\NilaiMatakuliahController@pesertakelas','as'=>'nilaimatakuliah.pesertakelas']);
  $router->post('/akademik/nilai/matakuliah/perkelas/storeperkelas',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiMatakuliahController@storeperkelas','as'=>'nilaimatakuliah.storeperkelas']);
  $router->post('/akademik/nilai/matakuliah/perdosen/storeperdosen',['middleware'=>['role:dosen'],'uses'=>'Akademik\NilaiMatakuliahController@storeperdosen','as'=>'nilaimatakuliah.storeperdosen']);
  $router->post('/akademik/nilai/matakuliah/perdosen/impornilai',['middleware'=>['role:dosen'],'uses'=>'Akademik\NilaiMatakuliahController@impornilai','as'=>'nilaimatakuliah.impornilai']);
  $router->get('/akademik/nilai/matakuliah/perkrs/{id}',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiMatakuliahController@perkrs','as'=>'nilaimatakuliah.perkrs']);
  $router->post('/akademik/nilai/matakuliah/perkrs/storeperkrs',['middleware'=>['role:puslahta'],'uses'=>'Akademik\NilaiMatakuliahController@storeperkrs','as'=>'nilaimatakuliah.storeperkrs']);
  //id disini adalah kelas_mhs_id	
  $router->post('/akademik/nilai/matakuliah/perdosen/printtemplatenilai/{id}',['middleware'=>['role:puslahta|dosen'],'uses'=>'Akademik\NilaiMatakuliahController@printtemplatenilai','as'=>'nilaimatakuliah.printtemplatenilai']);
  $router->post('/akademik/nilai/matakuliah/perdosen/printtoexcel1/{id}',['middleware'=>['role:puslahta|dosen'],'uses'=>'Akademik\NilaiMatakuliahController@printtoexcelperdosen1','as'=>'nilaimatakuliah.printtoexcelperdosen1']);

  //khs kartu hasil studi
  $router->post('/akademik/nilai/khs',['uses'=>'Akademik\NilaiKHSController@index','as'=>'khs.index']);
  $router->get('/akademik/nilai/khs/{id}',['uses'=>'Akademik\NilaiKHSController@show','as'=>'khs.show']);
  // id == krs id
  $router->get('/akademik/nilai/khs/printpdf/{id}',['uses'=>'Akademik\NilaiKHSController@printpdf','as'=>'khs.printpdf']);
  $router->post('/akademik/nilai/khs/printtoexcel1',['uses'=>'Akademik\NilaiKHSController@printtoexcel1','as'=>'khs.printtoexcel1']);

  //transkrip kurikulum
  $router->post('/akademik/nilai/transkripkurikulum',['uses'=>'Akademik\TranskripKurikulumController@index','as'=>'transkripkurikulum.index']);
  $router->get('/akademik/nilai/transkripkurikulum/{id}',['uses'=>'Akademik\TranskripKurikulumController@show','as'=>'transkripkurikulum.show']);
  $router->post('/akademik/nilai/transkripkurikulum/{id}/history',['uses'=>'Akademik\TranskripKurikulumController@history','as'=>'transkripkurikulum.history']);
  $router->get('/akademik/nilai/transkripkurikulum/printpdf1/{id}',['uses'=>'Akademik\TranskripKurikulumController@printpdf1','as'=>'transkripkurikulum.printpdf1']);
  $router->get('/akademik/nilai/transkripkurikulum/printpdf2/{id}',['uses'=>'Akademik\TranskripKurikulumController@printpdf2','as'=>'transkripkurikulum.printpdf2']);
  $router->post('/akademik/nilai/transkripkurikulum/printtoexcel1',['uses'=>'Akademik\TranskripKurikulumController@printtoexcel1','as'=>'transkripkurikulum.printtoexcel1']);

  // kemahasiswaan - profil mahasiswa
  $router->post('/kemahasiswaan/profil/search',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@search','as'=>'profilmhs.search']);
  $router->post('/kemahasiswaan/profil/bynim',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@bynim','as'=>'profilmhs.bynim']);
  
  $router->post('/kemahasiswaan/profil/byuserid',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@byuserid','as'=>'profilmhs.byuserid']);
  $router->post('/kemahasiswaan/profil/searchnonampulan',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@searchnonampulan','as'=>'profilmhs.searchnonampulan']);
  $router->post('/kemahasiswaan/profil/resetpassword',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@resetpassword','as'=>'profilmhs.resetpassword']);

  $router->put('/kemahasiswaan/profil/updatebiodata/{id}',['uses'=>'Kemahasiswaan\KemahasiswaanProfilController@updatebiodata','as'=>'profilmhs.updatebiodata']);
  
  // kemahasiswaan - pindah kelas
  $router->post('/kemahasiswaan/pindahkelas',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\PindahKelasController@index','as'=>'pindahkelas.index']);
  $router->post('/kemahasiswaan/pindahkelas/store',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Kemahasiswaan\PindahKelasController@store','as'=>'pindahkelas.store']);        
  $router->put('/kemahasiswaan/pindahkelas/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Kemahasiswaan\PindahKelasController@update','as'=>'pindahkelas.update']);
  $router->delete('/kemahasiswaan/pindahkelas/{id}',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Kemahasiswaan\PindahKelasController@destroy','as'=>'pindahkelas.destroy']);
  $router->post('/kemahasiswaan/pindahkelas/paksa',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Kemahasiswaan\PindahKelasController@paksa','as'=>'pindahkelas.paksa']);

  // kemahasiswaan - status aktif
  $router->post('/kemahasiswaan/statusaktif',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusAktifController@index','as'=>'statusaktif.index']);    
  
  // kemahasiswaan - status non-aktif
  $router->post('/kemahasiswaan/statusnonaktif',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusNonAktifController@index','as'=>'statusnonaktif.index']);    
  
  // kemahasiswaan - status cuti
  $router->post('/kemahasiswaan/statuscuti',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusCutiController@index','as'=>'statuscuti.index']);    

  // kemahasiswaan - status keluar
  $router->post('/kemahasiswaan/statuskeluar',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusKeluarController@index','as'=>'statuskeluar.index']);    
  
  // kemahasiswaan - status do
  $router->post('/kemahasiswaan/statusdo',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusDOController@index','as'=>'statusdo.index']);    
  
  // kemahasiswaan - status lulus
  $router->post('/kemahasiswaan/statuslulus',['middleware'=>['role:superadmin|akademik|programstudi|puslahta'],'uses'=>'Kemahasiswaan\KemahasiswaanStatusLulusController@index','as'=>'statuslulus.index']);    

  //kepegawaian
  $router->get('/kepegawaian',['uses'=>'Kepegawaian\KepegawaianController@index','as'=>'kepegawaian.index']);

  //kepegawaian - dosen
  $router->get('/kepegawaian/dosen',['uses'=>'Kepegawaian\KepegawaianDosenController@index','as'=>'kepegawaiandosen.index']);
  $router->put('/kepegawaian/dosen/{id}',['middleware'=>['role:superadmin|akademik|programstudi|dosen'],'uses'=>'Kepegawaian\KepegawaianDosenController@update','as'=>'kepegawaiandosen.update']);

  //setting - permissions
  $router->get('/system/setting/permissions',['middleware'=>['role:superadmin|akademik|pmb'],'uses'=>'System\PermissionsController@index','as'=>'permissions.index']);
  $router->post('/system/setting/permissions/store',['middleware'=>['role:superadmin'],'uses'=>'System\PermissionsController@store','as'=>'permissions.store']);
  $router->delete('/system/setting/permissions/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\PermissionsController@destroy','as'=>'permissions.destroy']);

  //setting - roles
  $router->get('/system/setting/roles',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@index','as'=>'roles.index']);
  $router->post('/system/setting/roles/store',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@store','as'=>'roles.store']);
  $router->post('/system/setting/roles/storerolepermissions',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@storerolepermissions','as'=>'roles.storerolepermissions']);
  $router->post('/system/setting/roles/revokerolepermissions',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@revokerolepermissions','as'=>'users.revokerolepermissions']);
  $router->put('/system/setting/roles/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@update','as'=>'roles.update']);
  $router->delete('/system/setting/roles/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@destroy','as'=>'roles.destroy']);
  $router->get('/system/setting/roles/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@rolepermissions','as'=>'roles.permission']);
  $router->get('/system/setting/rolesbyname/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'System\RolesController@rolepermissionsbyname','as'=>'roles.permissionbyname']);

  //setting - variables
  $router->get('/system/setting/variables',['middleware'=>['role:superadmin'],'uses'=>'System\VariablesController@index','as'=>'variables.index']);
  $router->get('/system/setting/variables/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\VariablesController@show','as'=>'variables.show']);
  $router->put('/system/setting/variables',['middleware'=>['role:superadmin'],'uses'=>'System\VariablesController@update','as'=>'variables.update']);
  $router->post('/system/setting/variables/clear',['middleware'=>['role:superadmin'],'uses'=>'System\VariablesController@clear','as'=>'variables.clear']);

  //setting - users
  $router->get('/system/users',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@index','as'=>'users.index']);
  $router->post('/system/users/store',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@store','as'=>'users.store']);
  $router->put('/system/users/updatepassword/{id}',['uses'=>'System\UsersController@updatepassword','as'=>'users.updatepassword']);
  $router->post('/system/users/uploadfoto/{id}',['uses'=>'System\UsersController@uploadfoto','as'=>'users.uploadfoto']);
  $router->post('/system/users/resetfoto/{id}',['uses'=>'System\UsersController@resetfoto','as'=>'users.resetfoto']);
  $router->post('/system/users/syncallpermissions',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@syncallpermissions','as'=>'users.syncallpermissions']);
  $router->post('/system/users/storeuserpermissions',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@storeuserpermissions','as'=>'users.storeuserpermissions']);
  $router->post('/system/users/revokeuserpermissions',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@revokeuserpermissions','as'=>'users.revokeuserpermissions']);
  $router->put('/system/users/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@update','as'=>'users.update']);
  $router->get('/system/users/{id}',['uses'=>'System\UsersController@show','as'=>'users.show']);
  $router->delete('/system/users/{id}',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@destroy','as'=>'users.destroy']);
  //lokasi method userpermission ada di file UserController
  $router->get('/system/users/{id}/permission',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@userpermissions','as'=>'users.permission']);
  $router->get('/system/users/{id}/mypermission',['uses'=>'System\UsersController@mypermission','as'=>'users.mypermission']);
  $router->get('/system/users/{id}/prodi',['middleware'=>['role:superadmin'],'uses'=>'System\UsersController@usersprodi','as'=>'users.prodi']);
  $router->get('/system/users/{id}/roles',['uses'=>'System\UsersController@roles','as'=>'users.roles']);

  //setting - users keuangan
  $router->get('/system/userskeuangan',['middleware'=>['role:superadmin|keuangan'],'uses'=>'System\UsersKeuanganController@index','as'=>'userskeuangan.index']);
  $router->post('/system/userskeuangan/store',['middleware'=>['role:superadmin|keuangan'],'uses'=>'System\UsersKeuanganController@store','as'=>'userskeuangan.store']);
  $router->put('/system/userskeuangan/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'System\UsersKeuanganController@update','as'=>'userskeuangan.update']);
  $router->delete('/system/userskeuangan/{id}',['middleware'=>['role:superadmin|keuangan'],'uses'=>'System\UsersKeuanganController@destroy','as'=>'userskeuangan.destroy']);

  //setting - users pmb
  $router->get('/system/userspmb',['middleware'=>['role:superadmin|pmb'],'uses'=>'System\UsersPMBController@index','as'=>'userspmb.index']);
  $router->post('/system/userspmb/store',['middleware'=>['role:superadmin|pmb'],'uses'=>'System\UsersPMBController@store','as'=>'userspmb.store']);
  $router->put('/system/userspmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'System\UsersPMBController@update','as'=>'userspmb.update']);
  $router->delete('/system/userspmb/{id}',['middleware'=>['role:superadmin|pmb'],'uses'=>'System\UsersPMBController@destroy','as'=>'userspmb.destroy']);

  //setting - users akademik
  $router->get('/system/usersakademik',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersAkademikController@index','as'=>'usersakademik.index']);
  $router->post('/system/usersakademik/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersAkademikController@store','as'=>'usersakademik.store']);
  $router->put('/system/usersakademik/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersAkademikController@update','as'=>'usersakademik.update']);
  $router->delete('/system/usersakademik/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersAkademikController@destroy','as'=>'usersakademik.destroy']);

  //setting - users program studi
  $router->get('/system/usersprodi',['middleware'=>['role:superadmin|programstudi'],'uses'=>'System\UsersProdiController@index','as'=>'usersprodi.index']);
  $router->post('/system/usersprodi/store',['middleware'=>['role:superadmin|programstudi'],'uses'=>'System\UsersProdiController@store','as'=>'usersprodi.store']);
  $router->put('/system/usersprodi/{id}',['middleware'=>['role:superadmin|programstudi'],'uses'=>'System\UsersProdiController@update','as'=>'usersprodi.update']);
  $router->get('/system/usersprodi/{id}',['middleware'=>['role:superadmin|programstudi'],'uses'=>'System\UsersProdiController@show','as'=>'usersprodi.show']);
  $router->delete('/system/usersprodi/{id}',['middleware'=>['role:superadmin|programstudi'],'uses'=>'System\UsersProdiController@destroy','as'=>'usersprodi.destroy']);

  //setting - users puslahta
  $router->get('/system/userspuslahta',['middleware'=>['role:superadmin|puslahta'],'uses'=>'System\UsersPuslahtaController@index','as'=>'userspuslahta.index']);
  $router->post('/system/userspuslahta/store',['middleware'=>['role:superadmin|puslahta'],'uses'=>'System\UsersPuslahtaController@store','as'=>'userspuslahta.store']);
  $router->put('/system/userspuslahta/{id}',['middleware'=>['role:superadmin|puslahta'],'uses'=>'System\UsersPuslahtaController@update','as'=>'userspuslahta.update']);
  $router->get('/system/userspuslahta/{id}',['middleware'=>['role:superadmin|puslahta'],'uses'=>'System\UsersPuslahtaController@show','as'=>'userspuslahta.show']);
  $router->delete('/system/userspuslahta/{id}',['middleware'=>['role:superadmin|puslahta'],'uses'=>'System\UsersPuslahtaController@destroy','as'=>'userspuslahta.destroy']);

  //setting - users dosen
  $router->get('/system/usersdosen',['uses'=>'System\UsersDosenController@index','as'=>'usersdosen.index']);
  $router->post('/system/usersdosen/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersDosenController@store','as'=>'usersdosen.store']);
  $router->get('/system/usersdosen/biodatadiri/{id}',['middleware'=>['role:superadmin|akademik|programstudi|dosen'],'uses'=>'System\UsersDosenController@biodatadiri','as'=>'usersdosen.biodatadiri']);
  $router->put('/system/usersdosen/biodatadiri/{id}',['middleware'=>['role:superadmin|akademik|programstudi|dosen'],'uses'=>'System\UsersDosenController@updatebiodatadiri','as'=>'usersdosen.updatebiodatadiri']);
  $router->put('/system/usersdosen/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersDosenController@update','as'=>'usersdosen.update']);
  $router->delete('/system/usersdosen/{id}',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\UsersDosenController@destroy','as'=>'usersdosen.destroy']);

  //system-migration
  $router->post('/system/migration',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\SystemMigrationController@index','as'=>'systemmigration.index']);
  $router->post('/system/migration/store',['middleware'=>['role:superadmin|akademik'],'uses'=>'System\SystemMigrationController@store','as'=>'systemmigration.store']);
  $router->post('/system/migration/penyelenggaraan/store',['middleware'=>['role:superadmin'],'uses'=>'System\SystemMigrationController@penyelenggaraanstore','as'=>'systemmigration.penyelenggaraanstore']);

  //untuk ui admin
  $router->get('/system/setting/uiadmin',['uses'=>'System\UIController@admin','as'=>'ui.admin']);

});
$router->group(['prefix'=>'h2h'], function () use ($router)
{
  //auth login
  $router->post('/brk/auth/login',['uses'=>'Plugins\H2H\BankRiauKepriSyariah\AuthController@login','as'=>'brk.auth.login']);
});

//video conference [zoom]
$router->group(['prefix'=>'h2h/zoom','middleware'=>'auth:api'], function () use ($router)
{

  $router->get('/',['middleware'=>['role:superadmin|akademik|programstudi'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@index','as'=>'zoom.index']);
  $router->post('/store',['middleware'=>['role:superadmin'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@store','as'=>'zoom.store']);
  //sync ini digunakan untuk mensinkronkan data akun zoom
  $router->get('/sync/{id}',['middleware'=>['role:superadmin'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@testing','as'=>'zoom.sync']);
  $router->get('/{id}',['middleware'=>['role:superadmin'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@show','as'=>'zoom.show']);
  $router->put('/{id}',['middleware'=>['role:superadmin'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@update','as'=>'zoom.update']);
  $router->delete('/{id}',['middleware'=>['role:superadmin'],'uses'=>'Plugins\H2H\ZoomAPI\ZoomController@destroy','as'=>'zoom.destroy']);
});

//payment - [bank riau kepri]
$router->group(['prefix'=>'h2h/brk','middleware'=>'h2hbrk:api'], function () use ($router)
{
  //authentication        
  $router->get('/auth/me',['uses'=>'Plugins\H2H\BankRiauKepriSyariah\AuthController@me','as'=>'brk.auth.me']);

  //inquiry tagihan
  $router->post('/inquiry-tagihan',['uses'=>'Plugins\H2H\BankRiauKepriSyariah\TransaksiController@inquiryTagihan','as'=>'brk.transaksi.inquiry-tagihan']);
  //payment
  $router->post('/payment',['uses'=>'Plugins\H2H\BankRiauKepriSyariah\TransaksiController@payment','as'=>'brk.transaksi.payment']);
});
