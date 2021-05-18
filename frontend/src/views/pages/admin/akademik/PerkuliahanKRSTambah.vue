<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-format-columns
			</template>
			<template v-slot:name>
				KARTU RENCANA STUDI
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
					Halaman untuk melakukan tambah krs
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
									Silahkan pilih tahun dan semester daftar ulang. Bila tidak ada
									disebabkan belum melakukan pembayaran atau status daftar ulang
									dinyatakan tidak aktif
								</v-alert>
								<v-text-field
									v-model="formdata.nim"
									label="NIM"
									:rules="rule_nim"
									outlined
									append-outer-icon="mdi-send"
									@click:append-outer="cekNIM"
									:disabled="
										this.$store.getters['uiadmin/getDefaultDashboard'] == 'mahasiswa'
									"
								/>
								<v-select
									v-model="dulang_id"
									:items="daftar_dulang"
									label="DAFTAR ULANG"
									class="mr-2"
									:rules="rule_dulang"
									outlined
									return-object
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
					<v-dialog v-model="dialogfrmupdateinfo" max-width="700px" persistent>
						<v-form
							ref="frmdataupdateinfo"
							v-model="form_valid_updateinfo"
							lazy-validation
						>
							<v-card>
								<v-card-title>UPDATE BIODATA</v-card-title>
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
											>
											</v-text-field>
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
								<v-card-actions>
									<v-spacer></v-spacer>
									<v-btn
										color="blue darken-1"
										text
										@click.stop="closedialogfrmupdateinfo"
									>
										BATAL
									</v-btn>
									<v-btn
										color="blue darken-1"
										text
										@click.stop="save_biodata"
										:disabled="!form_valid_updateinfo || btnLoading"
									>
										SIMPAN
									</v-btn>
								</v-card-actions>
							</v-card>
						</v-form>
					</v-dialog>
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
					text: "KRS",
					disabled: false,
					href: "/akademik/perkuliahan/krs/daftar",
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
			this.daftar_ta = this.$store.getters["uiadmin/getDaftarTA"];
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.ta_matkul = this.tahun_akademik;
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
			ta_matkul: null,
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
			//formdata update info
			dialogfrmupdateinfo: false,
			form_valid_updateinfo: true,
			formdataupdateinfo: {},
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
		}),
		methods: {
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
			cekNIM() {
				if (this.formdata.nim.length > 0) {
					this.fetchDulang();
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/krs/store",
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
								"/akademik/perkuliahan/krs/" + data.krs.id + "/detail"
							);
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			async save_biodata() {

			},
			closedialogfrm() {
				setTimeout(() => {
					this.formdata = Object.assign({}, {});
					this.$router.push("/akademik/perkuliahan/krs/daftar");
				}, 300);
			},
			closedialogfrmupdateinfo() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.$refs.frmdataupdateinfo.resetValidation();
					this.frmdataupdateinfo = Object.assign({}, {});
				}, 300);
			},
		},
		watch: {
			dulang_id(val) {
				if (val.update_info == 0) {
					this.dialogfrmupdateinfo = true;
				}
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
		},
	};
</script>
