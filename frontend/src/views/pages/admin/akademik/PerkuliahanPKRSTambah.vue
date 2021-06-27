<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-format-float-left
			</template>
			<template v-slot:name>
				PERUBAHAN KARTU RENCANA STUDI
			</template>
			<template
				v-slot:subtitle
				v-if="$store.getters['uiadmin/getDefaultDashboard'] != 'mahasiswa'"
			>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} -
				{{ nama_prodi }}
			</template>
			<template v-slot:breadcrumbs>
				<v-breadcrumbs :items="breadcrumbs" class="pa-0">
					<template v-slot:divider>
						<v-icon>mdi-chevron-right</v-icon>
					</template>
				</v-breadcrumbs>
			</template>
			<template v-slot:desc>
				<v-alert color="cyan" border="left" colored-border type="info">
					Halaman untuk melakukan melakukan perubahan krs
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								PILIH TAHUN & SEMESTER DAFTAR ULANG
							</v-card-title>
							<v-card-text>
								<v-alert type="info">
									Silahkan masukan nim, pastikan mahasiswa tersebut telah melakukan KRS dan disahkan oleh Dosen Wali.
								</v-alert>
								<v-text-field
									v-model="formdata.nim"
									label="NIM"
									:rules="rule_nim"
									outlined
									append-outer-icon="mdi-send"
									@click:append-outer="cekNIM"
									:disabled="
										this.$store.getters['uiadmin/getDefaultDashboard'] ==
											'mahasiswa'
									"
								/>								
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click.stop="closedialogfrm">
									BATAL
								</v-btn>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="save"
									:disabled="!form_valid || btnLoading"
								>
									BUAT
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-form>					
				</v-col>
			</v-row>
		</v-container>
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	export default {
		name: "PerkuliahanKRSTambah",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "AKADEMIK",
					disabled: false,
					href: "/akademik",
				},
				{
					text: "PERKULIAHAN",
					disabled: false,
					href: "#",
				},
				{
					text: "PKRS",
					disabled: false,
					href: "/akademik/perkuliahan/pkrs/daftar",
				},
				{
					text: "TAMBAH",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);			
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];			
			this.daftar_semester = this.$store.getters["uiadmin/getDaftarSemester"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.formdata.nim = this.$store.getters["auth/AttributeUser"](
					"username"
				);
				this.fetchDulang();
			}
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			semester_akademik: null,

			btnLoading: false,		

			//formdata
			form_valid: true,
			daftar_dulang: [],
			dulang_id: null,
			formdata: {
				nim: "",
				update_info: 0,
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
			rule_dulang: [
				value =>
					!!value || "Mohon dipilih Daftar Ulang yang telah dilakukan !!!",
			],

			//formdata update info
			dialogfrmupdateinfo: false,
			form_valid_updateinfo: true,
			menuTanggalLahir: false,

			daftar_provinsi: [],
			provinsi_id: 0,

			daftar_kabupaten: [],
			kabupaten_id: 0,

			daftar_kecamatan: [],
			kecamatan_id: 0,

			daftar_desa: [],
			desa_id: 0,

			daftar_fakultas: [],
			kode_fakultas: "",

			formdataupdateinfo: {
				nama_mhs: "",
				tempat_lahir: "",
				tanggal_lahir: "",
				jk: "L",
				nomor_hp: "",
				email: "",
				alamat_rumah: "",
				nama_ibu_kandung: "",
				kjur1: "",
				idkelas: "",
			},

			formdataupdateinfodefault: {
				nama_mhs: "",
				tempat_lahir: "",
				tanggal_lahir: "",
				jk: "L",
				nomor_hp: "",
				email: "",
				alamat_rumah: "",
				nama_ibu_kandung: "",
				kjur1: "",
				idkelas: "",
			},

			rule_nama_mhs: [
				value => !!value || "Nama Mahasiswa mohon untuk diisi !!!",
				value =>
					/^[A-Za-z\s\\,\\.]*$/.test(value) ||
					"Nama Mahasiswa hanya boleh string dan spasi",
			],
			rule_tempat_lahir: [
				value => !!value || "Tempat Lahir mohon untuk diisi !!!",
			],
			rule_tanggal_lahir: [
				value => !!value || "Tanggal Lahir mohon untuk diisi !!!",
			],
			rule_nomorhp: [
				value => !!value || "Nomor HP mohon untuk diisi !!!",
				value =>
					/^\+[1-9]{1}[0-9]{1,14}$/.test(value) ||
					"Nomor HP hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388",
			],
			rule_email: [
				value => !!value || "Email mohon untuk diisi !!!",
				value =>
					/.+@.+\..+/.test(value) || "Format E-mail mohon di isi dengan benar",
			],
			rule_nama_ibu_kandung: [
				value => !!value || "Nama Ibu Kandung mohon untuk diisi !!!",
				value =>
					/^[A-Za-z\s\\,\\.]*$/.test(value) ||
					"Nama Ibu Kandung hanya boleh string dan spasi",
			],
			rule_desa: [value => !!value || "Mohon Desa mohon untuk diisi !!!"],
			rule_alamat_rumah: [
				value => !!value || "Alamat Rumah mohon untuk diisi !!!",
			],
			rule_kelas: [value => !!value || "Kelas mohon untuk dipilih !!!"],
		}),
		methods: {
			async fetchBiodataMhs() {
				let bentukpt = this.$store.getters["uifront/getBentukPT"];
				await this.$ajax.get("/datamaster/provinsi").then(({ data }) => {
					this.daftar_provinsi = data.provinsi;
				});
				await this.$ajax
					.get("/spmb/formulirpendaftaran/" + this.dulang_id.user_id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.formdataupdateinfo.nama_mhs = data.formulir.nama_mhs;
						this.formdataupdateinfo.tempat_lahir = data.formulir.tempat_lahir;
						this.formdataupdateinfo.tanggal_lahir = data.formulir.tanggal_lahir;
						this.formdataupdateinfo.jk = data.formulir.jk;
						this.formdataupdateinfo.nomor_hp = "+" + data.formulir.nomor_hp;
						this.formdataupdateinfo.email = data.formulir.email;
						this.formdataupdateinfo.nama_ibu_kandung =
							data.formulir.nama_ibu_kandung;

						this.provinsi_id = {
							id: "" + data.formulir.address1_provinsi_id,
							nama: "" + data.formulir.address1_provinsi,
						};
						this.kabupaten_id = {
							id: "" + data.formulir.address1_kabupaten_id,
							nama: "" + data.formulir.address1_kabupaten,
						};
						this.kecamatan_id = {
							id: "" + data.formulir.address1_kecamatan_id,
							nama: "" + data.formulir.address1_kecamatan,
						};
						this.desa_id = {
							id: "" + data.formulir.address1_desa_id,
							nama: "" + data.formulir.address1_kelurahan,
						};
						this.formdataupdateinfo.alamat_rumah = data.formulir.alamat_rumah;
						if (
							bentukpt == "universitas" &&
							data.formulir.kode_fakultas != null
						) {
							this.kode_fakultas = data.formulir.kode_fakultas;
						}
					});
			},
			async fetchDulang() {
				await this.$ajax
					.post(
						"/akademik/dulang/dulangnotinkrs",
						{
							nim: this.formdata.nim,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.daftar_dulang = data.daftar_dulang;
					});
			},
			async cekNIM() {
				if (this.formdata.nim.length > 0) {					
					let nim = this.formdata.nim;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/krs/cekkrs",
							{
								nim: nim,
								ta: this.tahun_akademik,
								idsmt: this.semester_akademik,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							console.log(data);
						})
						.catch(() => {
							this.btnLoading = false;
						});
				
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/pkrs/store",
							{
								nim: this.formdata.nim,
								dulang_id: this.dulang_id.value,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.$router.push(
								"/akademik/perkuliahan/pkrs/" + data.krs.id + "/detail"
							);
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			closedialogfrm() {
				setTimeout(() => {
					this.formdata = Object.assign({}, {});
					this.$router.push("/akademik/perkuliahan/pkrs/daftar");
				}, 300);
			},
			closedialogfrmupdateinfo() {
				this.dialogfrmupdateinfo = false;
				setTimeout(() => {
					this.dulang_id = null;
					this.$refs.frmdataupdateinfo.resetValidation();
					this.frmdataupdateinfo = Object.assign(
						{},
						this.formdataupdateinfodefault
					);
				}, 300);
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
		},
	};
</script>
