<template>
	<ProfilMahasiswaLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-monitor-dashboard
			</template>
			<template v-slot:name>
				BIODATA MAHASISWA
			</template>
			<template v-slot:subtitle v-if="formdata.user_id">
				[{{data_mhs.nim}}] {{data_mhs.nama_mhs}}
			</template>
			<template v-slot:breadcrumbs>
				<v-breadcrumbs :items="breadcrumbs" class="pa-0">
					<template v-slot:divider>
						<v-icon>mdi-chevron-right</v-icon>
					</template>
				</v-breadcrumbs>
			</template>
		</ModuleHeader>
		<v-container fluid v-if="formdata.user_id">
      <v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card class="mb-4">
							<v-card-title>
								IDENTITAS DIRI
							</v-card-title>
							<v-card-text>
								<v-text-field
									label="NAMA LENGKAP"  
									v-model="formdata.nama_mhs"  
									:rules="rule_nama_mhs"
									filled
								/>
								<v-text-field
									label="TEMPAT LAHIR"
									v-model="formdata.tempat_lahir"
									:rules="rule_tempat_lahir" 
									filled
								/>
								<v-menu
									ref="menuTanggalLahir"
									v-model="menuTanggalLahir"
									:close-on-content-click="false"
									:return-value.sync="formdata.tanggal_lahir"
									transition="scale-transition"
									offset-y
									max-width="290px"
									min-width="290px"
								>
									<template v-slot:activator="{ on }">
										<v-text-field
											v-model="formdata.tanggal_lahir"
											label="TANGGAL LAHIR"
											readonly
											filled
											v-on="on"
											:rules="rule_tanggal_lahir"
										></v-text-field>
									</template>
									<v-date-picker
										v-model="formdata.tanggal_lahir"
										no-title                                
										scrollable
										>
										<v-spacer></v-spacer>
										<v-btn text color="primary" @click="menuTanggalLahir = false">Cancel</v-btn>
										<v-btn text color="primary" @click="$refs.menuTanggalLahir.save(formdata.tanggal_lahir)">OK</v-btn>
									</v-date-picker>
								</v-menu>
								<v-radio-group v-model="formdata.jk" row>
									JENIS KELAMIN : 
									<v-radio label="LAKI-LAKI" value="L"></v-radio>
									<v-radio label="PEREMPUAN" value="P"></v-radio>
								</v-radio-group>
								<v-text-field
									label="NOMOR HP"
									v-model="formdata.nomor_hp"
									filled
									:rules="rule_nomorhp"
								/>
								<v-text-field
									label="EMAIL"
									v-model="formdata.email"
									:rules="rule_email"
									filled
								/>
								<v-text-field
									label="NAMA IBU KANDUNG"
									v-model="formdata.nama_ibu_kandung"
									:rules="rule_nama_ibu_kandung"
									filled
								/>
							</v-card-text>
						</v-card>
						<v-card class="mb-4">
							<v-card-title>
								ALAMAT
							</v-card-title>
							<v-card-text>
								<v-select
									label="PROVINSI"
									:items="daftar_provinsi"
									v-model="provinsi_id"
									item-text="nama"
									item-value="id"
									return-object
									:loading="btnLoadingProv"
									filled
								/>
								<v-select
									label="KABUPATEN/KOTA"
									:items="daftar_kabupaten"
									v-model="kabupaten_id"
									item-text="nama"
									item-value="id"
									return-object
									:loading="btnLoadingKab"
									filled
								/>
								<v-select
									label="KECAMATAN"
									:items="daftar_kecamatan"
									v-model="kecamatan_id"
									item-text="nama"
									item-value="id" 
									return-object                           
									filled
								/>
								<v-select
									label="DESA/KELURAHAN"
									:items="daftar_desa"
									v-model="desa_id"
									item-text="nama"
									item-value="id"
									return-object
									:rules="rule_desa"
									filled
								/>
								<v-text-field
									v-model="formdata.alamat_rumah"
									label="ALAMAT RUMAH"
									:rules="rule_alamat_rumah"
									filled
								/>
							</v-card-text>
						</v-card>
						<v-card class="mb-4">
							<v-card-title>
								RENCANA STUDI
							</v-card-title>
							<v-card-text>
								<v-select
									v-model="kode_fakultas"
									label="FAKULTAS"
									filled
									:rules="rule_fakultas"
									:items="daftar_fakultas"
									item-text="nama_fakultas"
									item-value="kode_fakultas"
									:loading="btnLoadingFakultas"
									v-if="$store.getters['uifront/getBentukPT'] == 'universitas'"
								/>
								<v-select
									label="PROGRAM STUDI"
									v-model="formdata.kjur"
									:items="daftar_prodi"
									item-text="nama_prodi2"
									item-value="id"
									:rules="rule_prodi"
									:disabled="true"
									filled
								/>
								<v-select
									label="KELAS"
									v-model="formdata.idkelas"
									:items="daftar_kelas"
									item-text="nkelas"
									item-value="idkelas"
									:rules="rule_kelas"
									:disabled="true"
									filled
								/>
								<v-select
									v-model="formdata.tahun"
									:items="daftar_ta"
									label="TAHUN PENDAFTARAN"									
									outlined
								/>
							</v-card-text>
						</v-card>
						<v-card class="mb-4">
							<v-card-actions>								
								<v-spacer></v-spacer>
								<v-btn 
									color="blue darken-1" 
									text 
									@click.stop="save"									
									:disabled="!form_valid || btnLoading"
								>
									SIMPAN
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-form>
				</v-col>
			</v-row>
		</v-container>
	</ProfilMahasiswaLayout>
</template>
<script>
	import ProfilMahasiswaLayout from "@/views/layouts/ProfilMahasiswaLayout";
	import ModuleHeader from "@/components/ModuleHeader";	
	export default {
		name: "ProfilBiodataMHS",
		created()
		{
			this.user_id = this.$route.params.user_id;
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"]
				},
				{
					text: "KEMAHASISWAAN",
					disabled: false,
					href: "/kemahasiswaan"
				},
				{
					text: "PROFIL",
					disabled: false,
					href: "/kemahasiswaan/profil/" + this.user_id,
				},
				{
					text: "BIODATA",
					disabled: true,
					href: "#",
				},
			];
		},
		mounted() {
			this.initialize();
		},
		data: () => ({ 
			firstloading: true,
			breadcrumbs: [],
			
			//form data			
			btnLoading: false,
			btnLoadingProv: false,
			btnLoadingKab: false,
			btnLoadingKec: false,
			btnLoadingFakultas: false,

			user_id: null,
      form_valid: true,

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

      daftar_prodi: [],
      daftar_kelas: [],
			daftar_ta: [],
			data_mhs: {
				nim: null,
				nama_mhs: null,
			},
      formdata: {
        user_id: null,
        nim: null,
      },
      rule_nama_mhs: [
        value => !!value || "Nama Mahasiswa mohon untuk diisi !!!",
        value => /^[A-Za-z\s\\,\\.]*$/.test(value) || 'Nama Mahasiswa hanya boleh string dan spasi',
      ],
      rule_tempat_lahir: [
        value => !!value || "Tempat Lahir mohon untuk diisi !!!"
      ],
      rule_tanggal_lahir: [
        value => !!value || "Tanggal Lahir mohon untuk diisi !!!"
      ],
      rule_nomorhp: [
        value => !!value || "Nomor HP mohon untuk diisi !!!",
        value => /^\+[1-9]{1}[0-9]{1,14}$/.test(value) || 'Nomor HP hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388',
      ],
      rule_email: [
        value => !!value || "Email mohon untuk diisi !!!",
        value => /.+@.+\..+/.test(value) || 'Format E-mail mohon di isi dengan benar',
      ],
      rule_nama_ibu_kandung: [
        value => !!value || "Nama Ibu Kandung mohon untuk diisi !!!",
        value => /^[A-Za-z\s\\,\\.]*$/.test(value) || 'Nama Ibu Kandung hanya boleh string dan spasi',
      ],
      rule_desa: [
        value => !!value || "Mohon Desa mohon untuk diisi !!!"
      ],
      rule_alamat_rumah: [
        value => !!value || "Alamat Rumah mohon untuk diisi !!!"
      ],
      rule_fakultas: [
        value => !!value || "Fakultas mohon untuk dipilih !!!"
      ],
      rule_prodi: [
        value => !!value || "Program studi mohon untuk dipilih !!!"
      ],
      rule_kelas: [
        value => !!value || "Kelas mohon untuk dipilih !!!"
      ],
		}),
		methods: {
			initialize: async function() {
				this.daftar_ta = this.$store.getters["uiadmin/getDaftarTA"];
				let bentukpt = this.$store.getters['uifront/getBentukPT'];
				if (bentukpt == "universitas") {
					await this.$ajax.get('/datamaster/fakultas').then(({ data }) => {
						this.daftar_fakultas = data.fakultas;
					});
				} else {
					await this.$ajax.get('/datamaster/programstudi').then(({ data }) => {
						this.daftar_prodi = data.prodi;
					});
				}
				this.$ajax.get('/datamaster/provinsi').then(({ data }) => {
					this.daftar_provinsi = data.provinsi;
				});	
				this.$ajax.get('/datamaster/kelas').then(({ data }) => {
					this.daftar_kelas = data.kelas;
				});
				await this.$ajax
					.post(
						"/kemahasiswaan/profil/byuserid",
						{
							user_id: this.user_id,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.formdata = data.profil;
						console.log(this.formdata);
						this.data_mhs.nim = this.formdata.nim;
						this.data_mhs.nama_mhs = this.formdata.nama_mhs;
						this.formdata.nomor_hp = "+" + this.formdata.nomor_hp;

						if (this.formdata.this.formdata.address1_provinsi_id) {
							this.provinsi_id = {
								id: "" + this.formdata.address1_provinsi_id,
								nama: "" + this.formdata.address1_provinsi
							};
							this.kabupaten_id = {
								id: "" + this.formdata.address1_kabupaten_id,
								nama: "" + this.formdata.address1_kabupaten
							};
							this.kecamatan_id = {
								id: "" + this.formdata.address1_kecamatan_id,
								nama: "" + this.formdata.address1_kecamatan
							};
							this.desa_id = {
								id: "" + this.formdata.address1_desa_id,
								nama: "" + this.formdata.address1_kelurahan
							};
						}
						this.$refs.frmdata.resetValidation();
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			save: async function() {				
				if (this.$refs.frmdata.validate()) {					
					this.btnLoading = true;
					await this.$ajax.post("/kemahasiswaan/profil/updatebiodata/" + this.user_id, {
						_method: "put",
						nama_mhs: this.formdata.nama_mhs,
						tempat_lahir: this.formdata.tempat_lahir,
						tanggal_lahir: this.formdata.tanggal_lahir,
						jk: this.formdata.jk,
						nomor_hp: this.formdata.nomor_hp,
						email: this.formdata.email,
						nama_ibu_kandung: this.formdata.nama_ibu_kandung,
						address1_provinsi_id: this.provinsi_id.id,
						address1_provinsi: this.provinsi_id.nama,
						address1_kabupaten_id: this.kabupaten_id.id,
						address1_kabupaten: this.kabupaten_id.nama,
						address1_kecamatan_id: this.kecamatan_id.id,
						address1_kecamatan: this.kecamatan_id.nama,
						address1_desa_id: this.desa_id.id,
						address1_kelurahan: this.desa_id.nama,
						alamat_rumah: this.formdata.alamat_rumah,
						tahun: this.formdata.tahun,					
					},
					{
						headers: {
							Authorization: this.$store.getters["auth/Token"]
						}
					}
					)
					.then(() => {
						this.$router.go();
						this.btnLoading = false;
					}).catch(() => { 
						this.btnLoading = false;
					}); 
					this.form_valid = true; 
					this.$refs.frmdata.resetValidation(); 
				}
			},					
		},
		watch: {
			provinsi_id(val) {
				if (val.id != null && val.id != '') {
					this.btnLoadingProv = true;
					this.$ajax.get('/datamaster/provinsi/'+val.id+'/kabupaten').then(({ data }) => {
						this.daftar_kabupaten = data.kabupaten;
						this.btnLoadingProv = false;
					});
					this.daftar_kecamatan = [];
				}
			},
			kabupaten_id(val) {
				if (val.id != null && val.id != '') {
					this.btnLoadingKab = true;
					this.$ajax.get('/datamaster/kabupaten/'+val.id+'/kecamatan').then(({ data }) => {
						this.daftar_kecamatan = data.kecamatan;
						this.btnLoadingKab = false;
					});
				}
			},
			kecamatan_id(val) {
				if (val.id != null && val.id != '') {
					this.btnLoadingKec = true;
					this.$ajax.get('/datamaster/kecamatan/'+val.id+'/desa').then(({ data }) => {
						this.daftar_desa = data.desa;
						this.btnLoadingKec = false;
					});
				}
			},
			kode_fakultas(val) {
				this.btnLoadingFakultas = true;
				this.$ajax.get('/datamaster/fakultas/'+val+'/programstudi').then(({ data }) => {
					this.daftar_prodi = data.programstudi;
					this.btnLoadingFakultas = false;
				});
			},
		},
		components: {
			ProfilMahasiswaLayout,
			ModuleHeader,
		},
	};
</script>
