import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store/index";
import NotFoundComponent from "../components/NotFoundComponent";

Vue.use(VueRouter);

const routes = [
	{
		path: "/",
		name: "FrontDashboard",
		meta: {
			title: "DASHBOARD",
		},
		component: () => import("../views/pages/front/Home.vue"),
	},
	{
		path: "/pmb",
		name: "FrontPMB",
		meta: {
			title: "PENDAFTARAN MAHASISWA BARU",
		},
		component: () => import("../views/pages/front/PMB.vue"),
	},
	{
		path: "/login",
		name: "FrontLogin",
		meta: {
			title: "LOGIN",
		},
		component: () => import("../views/pages/front/Login.vue"),
	},
	{
		path: "/dashboard/:token",
		name: "AdminDashboard",
		meta: {
			title: "DASHBOARD",
		},
		component: () => import("../views/pages/admin/Dashboard.vue"),
	},
	//blog
	{
		path: "/blog",
		name: "Blog",
		meta: {
			title: "BLOG",
		},
		component: () => import("../views/pages/admin/blog/Blog.vue"),
	},
	//blog - pages - info kampus
	{
		path: "/blog/pages/infokampus",
		name: "BlogPageInfoKampus",
		meta: {
			title: "BLOG - PAGE - INFO KAMPUS",
		},
		component: () => import("../views/pages/admin/blog/PageInfoKampus.vue"),
	},
	//blog - pages - info kampus - tambah
	{
		path: "/blog/pages/infokampus/tambah",
		name: "BlogPageInfoKampusTambah",
		meta: {
			title: "BLOG - PAGE - INFO KAMPUS",
		},
		component: () =>
			import("../views/pages/admin/blog/PageInfoKampusTambah.vue"),
	},
	//blog - pages - info kampus - tambah
	{
		path: "/blog/pages/infokampus/:post_id/edit",
		name: "BlogPageInfoKampusEdit",
		meta: {
			title: "BLOG - PAGE - INFO KAMPUS",
		},
		component: () => import("../views/pages/admin/blog/PageInfoKampusEdit.vue"),
	},
	//dmaster
	{
		path: "/dmaster",
		name: "DMaster",
		meta: {
			title: "DATA MASTER",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/DMaster.vue"),
	},
	// dmaster - fasilitas
	{
		path: "/dmaster/ruangkelas",
		name: "DMasterRuangKelas",
		meta: {
			title: "DATA MASTER - RUANG KELAS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/RuangKelas.vue"),
	},
	{
		path: "/dmaster/kelas",
		name: "DMasterKelas",
		meta: {
			title: "DATA MASTER - KELAS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/Kelas.vue"),
	},
	// dmaster - pmb
	{
		path: "/dmaster/persyaratanpmb",
		name: "DMasterPersyaratanPMB",
		meta: {
			title: "DATA MASTER - PERSYARATAN PMB",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/PersyaratanPMB.vue"),
	},
	{
		path: "/dmaster/jabatanakademik",
		name: "DMasterJabatanAkademik",
		meta: {
			title: "DATA MASTER - JABATAN AKADEMIK",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/JabatanAkademik.vue"),
	},
	{
		path: "/dmaster/jenjangstudi",
		name: "DMasterJenjangStudi",
		meta: {
			title: "DATA MASTER - JENJANG STUDI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/JenjangStudi.vue"),
	},
	{
		path: "/dmaster/statusmahasiswa",
		name: "DMasterStatusMahasiswa",
		meta: {
			title: "DATA MASTER - STATUS MAHASISWA",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/StatusMahasiswa.vue"),
	},
	{
		path: "/dmaster/ta",
		name: "DMasterTahunAkademik",
		meta: {
			title: "DATA MASTER - TAHUN AKADEMIK",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/TahunAkademik.vue"),
	},
	{
		path: "/dmaster/persyaratanujianmunaqasah",
		name: "DMasterPersyaratanUjianMunaqasah",
		meta: {
			title: "DATA MASTER - PERSYARATAN UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/PersyaratanUjianMunaqasah.vue"),
	},
	{
		path: "/dmaster/fakultas",
		name: "DMasterFakultas",
		meta: {
			title: "DATA MASTER - FAKULTAS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/Fakultas.vue"),
		beforeEnter: (to, from, next) => {
			if(store.getters["uifront/getBentukPT"] == "sekolahtinggi") {
				next("/dashboard/" + store.getters["auth/AccessToken"]);
			} else {
				next();
			}
		},
	},
	{
		path: "/dmaster/programstudi",
		name: "DMasterProgramStudi",
		meta: {
			title: "DATA MASTER - PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/dmaster/ProgramStudi.vue"),
	},
	{
		path: "/dmaster/programstudi/:prodi_id/detail",
		name: "DMasterProgramStudiDetail",
		meta: {
			title: "DATA MASTER - PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/ProgramStudiDetail.vue"),
	},
	{
		path: "/dmaster/programstudi/:prodi_id/skslulus",
		name: "DMasterProgramStudiSKSLulus",
		meta: {
			title: "DATA MASTER - PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/ProgramStudiSKSLulus.vue"),
	},
	{
		path: "/dmaster/programstudi/:prodi_id/matkulskripsi",
		name: "DMasterProgramStudiMatkulSkripsi",
		meta: {
			title: "DATA MASTER - PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/ProgramStudiMatkulSkripsi.vue"),
	},
	{
		path: "/dmaster/kuesioner/kelompokpertanyaan",
		name: "DMasterKuesionerKelompokPertanyaaan",
		meta: {
			title: "DATA MASTER - KELOMPOK PERTANYAAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/KelompokPertanyaan.vue"),
	},
	{
		path: "/dmaster/kuesioner/daftarpertanyaan",
		name: "DMasterKuesionerDaftarPertanyaaan",
		meta: {
			title: "DATA MASTER - DAFTAR PERTANYAAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/dmaster/DaftarPertanyaan.vue"),
	},
	//spmb
	{
		path: "/spmb",
		name: "SPMB",
		meta: {
			title: "SPMB",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/SPMB.vue"),
	},
	{
		path: "/spmb/soalpmb",
		name: "SPMBSoal",
		meta: {
			title: "SPMB - SOAL PMB",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/SoalPMB.vue"),
	},
	{
		path: "/spmb/pendaftaranbaru",
		name: "SPMBPendaftaranBaru",
		meta: {
			title: "SPMB - PENDAFTARAN BARU",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PendaftaranBaru.vue"),
	},
	{
		path: "/spmb/formulirpendaftaran",
		name: "SPMBFormulirPendaftaran",
		meta: {
			title: "SPMB - FORMULIR PENDAFTARAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/spmb/FormulirPendaftaran.vue"),
	},
	{
		path: "/spmb/formulirpendaftaran/:user_id/edit",
		name: "SPMBFormulirPendaftaranEdit",
		meta: {
			title: "SPMB - FORMULIR PENDAFTARAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/spmb/FormulirPendaftaranEdit.vue"),
	},
	{
		path: "/spmb/persyaratan",
		name: "SPMBPersyaratan",
		meta: {
			title: "SPMB - PERSYARATAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PersyaratanPMB.vue"),
	},
	{
		path: "/spmb/jadwalujianpmb",
		name: "SPMBJadwalUjianPMB",
		meta: {
			title: "SPMB - JADWAL UJIAN PMB",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/JadwalUjianPMB.vue"),
	},
	{
		path: "/spmb/jadwalujianpmb/:jadwal_ujian_id/detail",
		name: "SPMBJadwalUjianPMBDetail",
		meta: {
			title: "SPMB - JADWAL UJIAN PMB",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/spmb/JadwalUjianPMBDetail.vue"),
	},
	{
		path: "/spmb/ujianonline",
		name: "SPMBUjianOnline",
		meta: {
			title: "SPMB - UJIAN ONLINE",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/UjianOnline.vue"),
	},
	{
		path: "/spmb/cekjawabanujianonline/:user_id",
		name: "SPMBCekJawabanUjianOnline",
		meta: {
			title: "SPMB - UJIAN ONLINE",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/CekJawabanUjianOnline.vue"),
	},
	{
		path: "/spmb/nilaiujian",
		name: "SPMBNilaiUjian",
		meta: {
			title: "SPMB - NILAI UJIAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/NilaiUjian.vue"),
	},
	{
		path: "/spmb/nilaiujian/:user_id/detail",
		name: "SPMBNilaiUjianHasil",
		meta: {
			title: "SPMB - NILAI UJIAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/NilaiUjianHasil.vue"),
	},
	{
		path: "/spmb/pesertalulus",
		name: "SPMBPesertaLulus",
		meta: {
			title: "SPMB - PESERTA LULUS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PesertaLulus.vue"),
	},
	{
		path: "/spmb/pesertadulang",
		name: "SPMBPesertaDulang",
		meta: {
			title: "SPMB - PESERTA DAFTAR ULANG",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PesertaDulang.vue"),
	},
	{
		path: "/spmb/pesertadulang/:user_id/detail",
		name: "SPMBPesertaDulangDetail",
		meta: {
			title: "SPMB - PESERTA DAFTAR ULANG",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PesertaDulangDetail.vue"),
	},
	{
		path: "/spmb/pesertadulang/:user_id/edit",
		name: "SPMBPesertaDulangEdit",
		meta: {
			title: "SPMB - PESERTA DAFTAR ULANG",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PesertaDulangEdit.vue"),
	},
	{
		path: "/spmb/jadwalujianpmb/passinggrade/:idjadwalujian",
		name: "SPMBPassingGrade",
		meta: {
			title: "SPMB - PASSING GRADE",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/PassingGrade.vue"),
	},
	{
		path: "/spmb/formulirdaftarulang/:user_id",
		name: "SPMBFormulirDaftarUlangMHSBaru",
		meta: {
			title: "SPMB - FORMULIR DAFTAR ULANG",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/spmb/FormulirDulangMahasiswaBaru.vue"),
	},
	{
		path: "/spmb/laporanfakultas",
		name: "SPMBReportFakultas",
		meta: {
			title: "SPMB - LAPORAN FAKULTAS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/ReportFakultas.vue"),
	},
	{
		path: "/spmb/laporanprodi",
		name: "SPMBReportProdi",
		meta: {
			title: "SPMB - LAPORAN PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/ReportProdi.vue"),
	},
	{
		path: "/spmb/laporankelulusan",
		name: "SPMBReportKelulusan",
		meta: {
			title: "SPMB - LAPORAN KELULUSAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/spmb/ReportKelulusan.vue"),
	},

	//keuangan
	{
		path: "/keuangan",
		name: "Keuangan",
		meta: {
			title: "KEUANGAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/Keuangan.vue"),
	},
	{
		path: "/keuangan/channelpembayaran",
		name: "KeuanganChanelPembayaran",
		meta: {
			title: "KEUANGAN - CHANNEL PEMBAYARAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/ChannelPembayaran.vue"),
	},
	{
		path: "/keuangan/statustransaksi",
		name: "KeuanganStatusTransaksi",
		meta: {
			title: "KEUANGAN - STATUS TRANSAKSI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/StatusTransaksi.vue"),
	},
	{
		path: "/keuangan/biayakomponen",
		name: "KeuanganBiayaKomponen",
		meta: {
			title: "KEUANGAN - BIAYA KOMPONEN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/BiayaKomponen.vue"),
	},
	{
		path: "/keuangan/biayakomponenperiode",
		name: "KeuanganBiayaKomponenPeriode",
		meta: {
			title: "KEUANGAN - BIAYA KOMPONEN PERIODE",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/BiayaKomponenPeriode.vue"),
	},
	{
		path: "/keuangan/transferbank",
		name: "KeuanganTransferBank",
		meta: {
			title: "KEUANGAN - TRANSFER BANK",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/TransferBank.vue"),
	},
	{
		path: "/keuangan/transaksi",
		name: "KeuanganTransaksi",
		meta: {
			title: "KEUANGAN - TRANSAKSI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/Transaksi.vue"),
	},
	{
		path: "/keuangan/bukanilai",
		name: "KeuanganBukaNilai",
		meta: {
			title: "KEUANGAN - BUKA NILAI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/BukaNilai.vue"),
	},
	{
		path: "/keuangan/transaksi-spp",
		name: "KeuanganTransaksiSPP",
		meta: {
			title: "KEUANGAN - TRANSAKSI SPP",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/TransaksiSPP.vue"),
	},
	{
		path: "/keuangan/transaksi-dulangmhsbaru",
		name: "KeuanganTransaksiDulangMHSBaru",
		meta: {
			title: "KEUANGAN - TRANSAKSI DAFTAR ULANG MAHASISWA BARU",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiDulangMHSBaru.vue"),
	},
	{
		path: "/keuangan/transaksi-dulangmhsbaru/:transaksi_id",
		name: "KeuanganTransaksiDulangMHSBaruDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI DAFTAR ULANG MAHASISWA BARU",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiInvoice.vue"),
	},
	{
		path: "/keuangan/transaksi-spp/:transaksi_id",
		name: "KeuanganTransaksiSPPDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI SPP",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiSPPDetail.vue"),
	},
	{
		path: "/keuangan/transaksi-spp/tambah/:transaksi_id",
		name: "KeuanganTransaksiSPPTambah",
		meta: {
			title: "KEUANGAN - TRANSAKSI SPP",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiSPPTambah.vue"),
	},
	{
		path: "/keuangan/transaksi-registrasikrs",
		name: "KeuanganTransaksiRegistrasiKRS",
		meta: {
			title: "KEUANGAN - TRANSAKSI REGISTRASI KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiRegistrasiKRS.vue"),
	},
	{
		path: "/keuangan/transaksi-registrasikrs/:transaksi_id",
		name: "KeuanganTransaksiRegistrasiKRSDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI REGISTRASI KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiInvoice.vue"),
	},
	{
		path: "/keuangan/transaksi-kkn",
		name: "KeuanganTransaksiKKN",
		meta: {
			title: "KEUANGAN - TRANSAKSI KKN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/keuangan/TransaksiKKN.vue"),
	},
	{
		path: "/keuangan/transaksi-kkn/:transaksi_id",
		name: "KeuanganTransaksiKKNDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI KKN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiInvoice.vue"),
	},
	{
		path: "/keuangan/transaksi-ujianmunaqasah",
		name: "KeuanganTransaksiUjianMunaqasah",
		meta: {
			title: "KEUANGAN - TRANSAKSI UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiUjianMunaqasah.vue"),
	},
	{
		path: "/keuangan/transaksi-ujianmunaqasah/:transaksi_id",
		name: "KeuanganTransaksiUjianMunaqasahDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiInvoice.vue"),
	},
	{
		path: "/keuangan/transaksi-pplpkl",
		name: "KeuanganTransaksiPPLPKL",
		meta: {
			title: "KEUANGAN - TRANSAKSI PPL / PKL",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiPPLPKL.vue"),
	},
	{
		path: "/keuangan/transaksi-pplpkl/:transaksi_id",
		name: "KeuanganTransaksiPPLPKLDetail",
		meta: {
			title: "KEUANGAN - TRANSAKSI PPL / PKL",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiInvoice.vue"),
	},
	{
		path: "/keuangan/konfirmasipembayaran",
		name: "KeuanganKonfirmasiPembayaran",
		meta: {
			title: "KEUANGAN - KONFIRMASI PEMBAYARAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/KonfirmasiPembayaran.vue"),
	},
	//keuangan - laporan transaksi
	{
		path: "/keuangan/transaksi-laporanspppersemester",
		name: "KeuanganTransaksiLaporanSPPPerSeemster",
		meta: {
			title: "KEUANGAN - LAPORAN SPP PER SEMESTER",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/keuangan/TransaksiLaporanSPPPerSemester.vue"
			),
	},
	//keuangan - laporan penerimaan
	{
		path: "/keuangan/transaksi-laporanpendaftaran",
		name: "KeuanganTransaksiLaporanPendaftaran",
		meta: {
			title: "KEUANGAN - LAPORAN PENERIMAAN PENDAFTARAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiLaporanPendaftaran.vue"),
	},
	{
		path: "/keuangan/transaksi-laporandulangmhsbaru",
		name: "KeuanganTransaksiLaporanDulangMHSBaru",
		meta: {
			title: "KEUANGAN - LAPORAN PENERIMAAN DULANG MAHASISWA BARU",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiLaporanDulangMHSBaru.vue"),
	},
	{
		path: "/keuangan/transaksi-laporanspp",
		name: "KeuanganTransaksiLaporanSPP",
		meta: {
			title: "KEUANGAN - LAPORAN PENERIMAAN SPP",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiLaporanSPP.vue"),
	},
	{
		path: "/keuangan/transaksi-laporanregistrasikrs",
		name: "KeuanganTransaksiLaporanRegistrasiKRS",
		meta: {
			title: "KEUANGAN - LAPORAN PENERIMAAN REGISTRASI KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/keuangan/TransaksiLaporanRegistrasiKRS.vue"),
	},
	{
		path: "/keuangan/transaksi-laporanujianmunaqasah",
		name: "KeuanganTransaksiLaporanUjianMunaqasah",
		meta: {
			title: "KEUANGAN - LAPORAN PENERIMAAN UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/keuangan/TransaksiLaporanUjianMunaqasah.vue"
			),
	},

	//akademik
	{
		path: "/akademik",
		name: "AKADEMIK",
		meta: {
			title: "AKADEMIK",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/Akademik.vue"),
	},
	{
		path: "/akademik/matakuliah",
		name: "AkademikMatakuliah",
		meta: {
			title: "AKADEMIK - MATAKULIAH",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/Matakuliah.vue"),
	},
	{
		path: "/akademik/dosenwali",
		name: "AkademikDosenWali",
		meta: {
			title: "AKADEMIK - DOSEN WALI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/DosenWali.vue"),
	},
	{
		path: "/akademik/dosenwali/:dosen_id",
		name: "AkademikDosenWaliDetail",
		meta: {
			title: "AKADEMIK - DOSEN WALI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DosenWaliDetail.vue"),
	},
	//akademik - daftar ulang
	{
		path: "/akademik/dulang/mhsbelumpunyanim",
		name: "AkademikDulangMHSBelumPunyaNIM",
		meta: {
			title: "AKADEMIK - MHS. BARU BELUM PUNYA NIM",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/MHSBelumPunyaNIM.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswabaru",
		name: "AkademikDulangMHSBaru",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA BARU",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaBaru.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswalama",
		name: "AkademikDulangMHSLama",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA LAMA",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaLama.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswaaktif",
		name: "AkademikDulangMHSAktif",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA AKTIF",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaAktif.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswanonaktif",
		name: "AkademikDulangMHSNonAktif",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA NON-AKTIF",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaNonAktif.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswacuti",
		name: "AkademikDulangMHSCuti",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA CUTI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaCuti.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswalulus",
		name: "AkademikDulangMHSLulus",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA LULUS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaLulus.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswakeluar",
		name: "AkademikDulangMHSKeluar",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA KELUAR",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaKeluar.vue"),
	},
	{
		path: "/akademik/dulang/mahasiswado",
		name: "AkademikDulangMHSDO",
		meta: {
			title: "AKADEMIK - DAFTAR ULANG MAHASISWA DROPOUT / PUTUS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/DulangMahasiswaDO.vue"),
	},
	//akademik - perkuliahan - penyelenggaraan
	{
		path: "/akademik/perkuliahan/penyelenggaraan/daftar",
		name: "PerkuliahanPenyelenggaraan",
		meta: {
			title: "AKADEMIK - PENYELENGGARAAN MATAKULIAH",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPenyelenggaraan.vue"),
	},
	{
		path: "/akademik/perkuliahan/penyelenggaraan/tambah",
		name: "PerkuliahanPenyelenggaraanTambah",
		meta: {
			title: "AKADEMIK - PENYELENGGARAAN MATAKULIAH",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanPenyelenggaraanTambah.vue"
			),
	},
	{
		path:
			"/akademik/perkuliahan/penyelenggaraan/:idpenyelenggaraan/dosenpengampu/",
		name: "PerkuliahanPenyelenggaraanDosenPengampu",
		meta: {
			title: "AKADEMIK - PENYELENGGARAAN MATAKULIAH",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanPenyelenggaraanDosenPengampu.vue"
			),
	},

	//akademik - perkuliahan - krs
	{
		path: "/akademik/perkuliahan/krs/daftar",
		name: "PerkuliahanKRS",
		meta: {
			title: "AKADEMIK - KRS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/PerkuliahanKRS.vue"),
	},
	{
		path: "/akademik/perkuliahan/krs/:krsid/detail",
		name: "PerkuliahanKRSDetail",
		meta: {
			title: "AKADEMIK - KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanKRSDetail.vue"),
	},
	{
		path: "/akademik/perkuliahan/krs/tambah",
		name: "PerkuliahanKRSTambah",
		meta: {
			title: "AKADEMIK - KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanKRSTambah.vue"),
	},
	{
		path: "/akademik/perkuliahan/krs/:krsid/tambahmatkul",
		name: "PerkuliahanKRSTambahMatkul",
		meta: {
			title: "AKADEMIK - KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanKRSTambahMatkul.vue"),
	},
	{
		path: "/akademik/perkuliahan/krs/verifikasi",
		name: "PerkuliahanKRSVerifikasi",
		meta: {
			title: "AKADEMIK - VERIFIKASI KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanVerifikasiKRS.vue"),
	},
	{
		path: "/akademik/perkuliahan/krs/verifikasi/:krsid/detail",
		name: "PerkuliahanVerifikasiKRSDetail",
		meta: {
			title: "AKADEMIK - VERIFIKASI KRS",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanVerifikasiKRSDetail.vue"
			),
	},
	//akademik - perkuliahan - pkrs
	{
		path: "/akademik/perkuliahan/pkrs/daftar",
		name: "PerkuliahanPKRS",
		meta: {
			title: "AKADEMIK - PKRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPKRS.vue"),
	},
	{
		path: "/akademik/perkuliahan/pkrs/:krsid/detail",
		name: "PerkuliahanPKRSDetail",
		meta: {
			title: "AKADEMIK - PKRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPKRSDetail.vue"),
	},
	{
		path: "/akademik/perkuliahan/pkrs/tambah",
		name: "PerkuliahanPKRSTambah",
		meta: {
			title: "AKADEMIK - PKRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPKRSTambah.vue"),
	},
	{
		path: "/akademik/perkuliahan/pkrs/:krsid/tambahmatkul",
		name: "PerkuliahanPKRSTambahMatkul",
		meta: {
			title: "AKADEMIK - PKRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPKRSTambahMatkul.vue"),
	},
	{
		path: "/akademik/perkuliahan/pkrs/verifikasi",
		name: "PerkuliahanPKRSVerifikasi",
		meta: {
			title: "AKADEMIK - VERIFIKASI PKRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanVerifikasiKRS.vue"),
	},
	//akademik - perkuliahan - pembagian kelas
	{
		path: "/akademik/perkuliahan/pembagiankelas/daftar",
		name: "PerkuliahanPembagianKelas",
		meta: {
			title: "AKADEMIK - PEMBAGIAN KELAS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPembagianKelas.vue"),
	},
	{
		path: "/akademik/perkuliahan/pembagiankelas/tambah",
		name: "PerkuliahanPembagianKelasTambah",
		meta: {
			title: "AKADEMIK - PEMBAGIAN KELAS",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanPembagianKelasTambah.vue"
			),
	},
	{
		path: "/akademik/perkuliahan/pembagiankelas/:kelas_mhs_id/ubah",
		name: "PerkuliahanPembagianKelasUbah",
		meta: {
			title: "AKADEMIK - PEMBAGIAN KELAS",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanPembagianKelasUbah.vue"
			),
	},
	{
		path: "/akademik/perkuliahan/pembagiankelas/:kelas_mhs_id/peserta",
		name: "PerkuliahanPembagianKelasPeserta",
		meta: {
			title: "AKADEMIK - PEMBAGIAN KELAS",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanPembagianKelasPeserta.vue"
			),
	},
	//akademik - perkuliahan - ppl/pkl
	{
		path: "/akademik/perkuliahan/pplpkl",
		name: "PerkuliahanPPLPKL",
		meta: {
			title: "AKADEMIK - PPL / PKL",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanPPLPKL.vue"),
	},
	//akademik - perkuliahan - ujian munaqasah
	{
		path: "/akademik/perkuliahan/ujianmunaqasah",
		name: "PerkuliahanUjianMunaqasah",
		meta: {
			title: "AKADEMIK - UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/PerkuliahanUjianMunaqasah.vue"),
	},
	{
		path: "/akademik/perkuliahan/ujianmunaqasah/tambah",
		name: "PerkuliahanUjianMunaqasahTambah",
		meta: {
			title: "AKADEMIK - UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanUjianMunaqasahTambah.vue"
			),
	},
	{
		path: "/akademik/perkuliahan/ujianmunaqasah/:ujian_munaqasah_id/detail",
		name: "PerkuliahanUjianMunaqasahDetail",
		meta: {
			title: "AKADEMIK - UJIAN MUNAQASAH",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/akademik/PerkuliahanUjianMunaqasahDetail.vue"
			),
	},
	//akademik - nilai
	{
		path: "/akademik/nilai/waktupengisian",
		name: "AkademikNilaiIsiWaktuPengisian",
		meta: {
			title: "AKADEMIK - WAKTU PENGISIAN NILAI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiWaktuPengisian.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperkelasmhs",
		name: "AkademikNilaiIsiPerKelasMHS",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER KELAS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiIsiPerKelasMHS.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperkelasmhs/:kelas_mhs_id",
		name: "AkademikNilaiIsiPerKelasMHSDetail",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER KELAS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiIsiPerKelasMHSDetail.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperdosen",
		name: "AkademikNilaiIsiPerDosen",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER DOSEN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiIsiPerDosen.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperdosen/:kelas_mhs_id",
		name: "AkademikNilaiIsiPerDosenDetail",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER DOSEN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiIsiPerDosenDetail.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperkrs",
		name: "AkademikNilaiIsiPerKRS",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER KRS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/NilaiIsiPerKRS.vue"),
	},
	{
		path: "/akademik/nilai/matakuliah/isiperkrs/:krsid",
		name: "AkademikNilaiIsiPerKRSMHSDetail",
		meta: {
			title: "AKADEMIK - ISI NILAI MATAKULIAH PER KRS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiIsiPerKRSDetail.vue"),
	},
	{
		path: "/akademik/nilai/khs",
		name: "NilaiKHS",
		meta: {
			title: "AKADEMIK - NILAI KHS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/NilaiKHS.vue"),
	},
	{
		path: "/akademik/nilai/khs/:krs_id",
		name: "NilaiKHSDetail",
		meta: {
			title: "AKADEMIK - NILAI KHS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/NilaiKHSDetail.vue"),
	},
	{
		path: "/akademik/nilai/transkripkurikulum",
		name: "TranskripNilaiKurikulum",
		meta: {
			title: "AKADEMIK - TRANSKRIP KURIKULUM",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/TranskripNilaiKurikulum.vue"),
	},
	{
		path: "/akademik/nilai/transkripkurikulum/:user_id",
		name: "TranskripNilaiKurikulumDetail",
		meta: {
			title: "AKADEMIK - TRANSKRIP KURIKULUM",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/TranskripNilaiKurikulumDetail.vue"),
	},
	{
		path: "/akademik/nilai/konversi",
		name: "NilaiKonversi",
		meta: {
			title: "AKADEMIK - KONVERSI NILAI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/akademik/NilaiKonversi.vue"),
	},
	{
		path: "/akademik/nilai/konversi/tambah",
		name: "NilaiKonversiTambah",
		meta: {
			title: "AKADEMIK - KONVERSI NILAI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiKonversiTambah.vue"),
	},
	{
		path: "/akademik/nilai/konversi/:nilai_konversi_id/detail",
		name: "NilaiKonversiDetail",
		meta: {
			title: "AKADEMIK - KONVERSI NILAI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiKonversiDetail.vue"),
	},
	{
		path: "/akademik/nilai/konversi/:nilai_konversi_id/edit",
		name: "NilaiKonversiEdit",
		meta: {
			title: "AKADEMIK - KONVERSI NILAI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/akademik/NilaiKonversiEdit.vue"),
	},

	//kemahasiswaan
	{
		path: "/kemahasiswaan",
		name: "Kemahasiswaan",
		meta: {
			title: "KEMAHASISWAAN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/Kemahasiswaan.vue"),
	},
	{
		path: "/kemahasiswaan/profil/:user_id",
		name: "KemahasiswaanProfilMHS",
		meta: {
			title: "KEMAHASISWAAN - PROFIL MAHASISWA",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanProfilMHS.vue"),
	},
	{
		path: "/kemahasiswaan/daftarmahasiswa",
		name: "KemahasiswaanDaftarMahasiswa",
		meta: {
			title: "KEMAHASISWAAN - DAFTAR MAHASISWA",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/kemahasiswaan/KemahasiswaanDaftarMahasiswa.vue"
			),
	},
	{
		path: "/kemahasiswaan/pindahkelas",
		name: "KemahasiswaanPindahKelas",
		meta: {
			title: "KEMAHASISWAAN - PINDAH KELAS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanPindahKelas.vue"),
	},
	{
		path: "/kemahasiswaan/pindahpaksakelas",
		name: "KemahasiswaanPindahPaksaKelas",
		meta: {
			title: "KEMAHASISWAAN - PINDAH PAKSA KELAS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanPindahPaksaKelas.vue"),
	},
	{
		path: "/kemahasiswaan/statusaktif",
		name: "KemahasiswaanStatusAktif",
		meta: {
			title: "KEMAHASISWAAN - STATUS AKTIF",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanStatusAktif.vue"),
	},
	{
		path: "/kemahasiswaan/statusnonaktif",
		name: "KemahasiswaanStatusNonAktif",
		meta: {
			title: "KEMAHASISWAAN - STATUS NON-AKTIF",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/kemahasiswaan/KemahasiswaanStatusNonAktif.vue"
			),
	},
	{
		path: "/kemahasiswaan/statuscuti",
		name: "KemahasiswaanStatusCuti",
		meta: {
			title: "KEMAHASISWAAN - STATUS CUTI",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanStatusCuti.vue"),
	},
	{
		path: "/kemahasiswaan/statusdo",
		name: "KemahasiswaanStatusDO",
		meta: {
			title: "KEMAHASISWAAN - STATUS DO",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanStatusDO.vue"),
	},
	{
		path: "/kemahasiswaan/statuskeluar",
		name: "KemahasiswaanStatusKeluar",
		meta: {
			title: "KEMAHASISWAAN - STATUS KELUAR",
			requiresAuth: true,
		},
		component: () =>
			import(
				"../views/pages/admin/kemahasiswaan/KemahasiswaanStatusKeluar.vue"
			),
	},
	{
		path: "/kemahasiswaan/statuslulus",
		name: "KemahasiswaanStatusLulus",
		meta: {
			title: "KEMAHASISWAAN - STATUS LULUS",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kemahasiswaan/KemahasiswaanStatusLulus.vue"),
	},
	//system
	{
		path: "/system-setting",
		name: "SystemSetting",
		meta: {
			title: "SETTING - SISTEM",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/SystemSetting.vue"),
	},
	{
		path: "/system-setting/identitasdiri",
		name: "IdentitasDiri",
		meta: {
			title: "SETTING - IDENTITAS DIRI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/IdentitasDiri.vue"),
	},
	{
		path: "/system-setting/variables",
		name: "Variables",
		meta: {
			title: "SETTING - VARIABLES",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Variables.vue"),
	},
	{
		path: "/system-setting/headerlaporan",
		name: "HeaderLaporan",
		meta: {
			title: "SETTING - HEADER LAPORAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/HeaderLaporan.vue"),
	},
	{
		path: "/system-setting/captcha",
		name: "SettingCaptcha",
		meta: {
			title: "SETTING - CAPTCHA",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Captcha.vue"),
	},
	{
		path: "/system-setting/email",
		name: "SettingEmail",
		meta: {
			title: "SETTING - EMAIL",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Email.vue"),
	},
	{
		path: "/system-setting/cache",
		name: "SettingCache",
		meta: {
			title: "SETTING - CACHE",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Cache.vue"),
	},
	//system - konfigurasi - blog
	{
		path: "/system-setting/blog-infokampus",
		name: "SettingBlogInfokampus",
		meta: {
			title: "SETTING - BLOG - INFO KAMPUS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/InfoKampus.vue"),
	},
	//plugins
	{
		path: "/system-setting/zoom",
		name: "SettingZoom",
		meta: {
			title: "SETTING - ZOOM",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Zoom.vue"),
	},
	//system - users
	{
		path: "/system-users",
		name: "SystemUsers",
		meta: {
			title: "SYSTEM - USERS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/SystemUsers.vue"),
	},
	{
		path: "/system-users/permissions",
		name: "UsersPermissions",
		meta: {
			title: "USERS - PERMISSIONS",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Permissions.vue"),
	},
	{
		path: "/system-users/mypermission",
		name: "MyPermissions",
		meta: {
			title: "USERS - MY PERMISSION",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/MyPermission.vue"),
	},
	{
		path: "/system-users/roles",
		name: "UsersRoles",
		meta: {
			title: "USERS - ROLES",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/Roles.vue"),
	},
	{
		path: "/system-users/superadmin",
		name: "UsersSuperadmin",
		meta: {
			title: "USERS - SUPER ADMIN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersSuperadmin.vue"),
	},
	{
		path: "/system-users/pmb",
		name: "UsersPMB",
		meta: {
			title: "USERS - PMB",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersPMB.vue"),
	},
	{
		path: "/system-users/akademik",
		name: "UsersAkademik",
		meta: {
			title: "USERS - AKADEMIK",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersAkademik.vue"),
	},
	{
		path: "/system-users/prodi",
		name: "UsersProdi",
		meta: {
			title: "USERS - PROGRAM STUDI",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersProdi.vue"),
	},
	{
		path: "/system-users/puslahta",
		name: "UsersPuslahta",
		meta: {
			title: "USERS - PUSLAHTA",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersPuslahta.vue"),
	},
	{
		path: "/system-users/dosen",
		name: "UsersDosen",
		meta: {
			title: "USERS - DOSEN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersDosen.vue"),
	},
	{
		path: "/system-users/keuangan",
		name: "UsersKeuangan",
		meta: {
			title: "USERS - KEUANGAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersKeuangan.vue"),
	},
	{
		path: "/system-users/profil",
		name: "UsersProfil",
		meta: {
			title: "USERS - PROFILE",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/UsersProfile.vue"),
	},
	//kepegawaian
	{
		path: "/kepegawaian",
		name: "Kepegawaian",
		meta: {
			title: "KEPEGAWAIAN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/kepegawaian/Kepegawaian.vue"),
	},
	{
		path: "/kepegawaian/dosen",
		name: "KepegawaianDosen",
		meta: {
			title: "KEPEGAWAIAN - DOSEN",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/kepegawaian/KepegawaianDosen.vue"),
	},
	//biodata dosen
	{
		path: "/system-users/biodatadiridosen",
		name: "BiodataDiriDosen",
		meta: {
			title: "USERS - BIODATA DIRI DOSEN",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/BiodataDiriDosen.vue"),
	},
	//biodata mahasiswa
	{
		path: "/system-users/biodatadirimahasiswa",
		name: "BiodataDiriMahasiswa",
		meta: {
			title: "USERS - BIODATA DIRI MAHASISWA",
			requiresAuth: true,
		},
		component: () =>
			import("../views/pages/admin/system/BiodataDiriMahasiswa.vue"),
	},
	{
		path: "/system-migration",
		name: "SystemMigration",
		meta: {
			title: "MIGRASI SISTEM",
			requiresAuth: true,
		},
		component: () => import("../views/pages/admin/system/SystemMigration.vue"),
	},
	{
		path: "/404",
		name: "NotFoundComponent",
		meta: {
			title: "PAGE NOT FOUND",
		},
		component: NotFoundComponent,
	},
	{
		path: "*",
		redirect: "/404",
	},
];

const router = new VueRouter({
	mode: "history",
	base: process.env.BASE_URL,
	routes,
});

router.beforeEach((to, from, next) => {
	document.title = to.meta.title;
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if (store.getters["auth/Authenticated"]) {
			next();
			return;
		}
		next("/login");
	} else {
		next();
	}
});
export default router;
