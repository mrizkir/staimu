<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-run-fast
			</template>
			<template v-slot:name>
				UJIAN MUNAQASAH
			</template>
			<template
				v-slot:subtitle
				v-if="$store.getters['uiadmin/getDefaultDashboard'] != 'mahasiswa'"
			>
				TAHUN AKADEMIK {{ tahun_akademik }} - {{ nama_prodi }}
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
					Halaman untuk melakukan tambah ujian munaqasah
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								CEK PERSYARATAN
							</v-card-title>
							<v-card-text>
								<v-alert type="info">
									sebelum menambah ujian munaqasah sistem akan melakukan
									pengecekan persyaratan. Silahkan masukan NIM, kemudian tekan
									tombol <v-icon>mdi-send</v-icon> untuk memproses.
								</v-alert>
								<v-text-field
									v-model="formdata.nim"
									label="NIM"
									:rules="rule_nim"
									outlined
								/>
								<v-btn
									@click.stop="cekPersyaratan"
									:disabled="!form_valid || btnLoading"
									color="primary"
									icon
									class="ma-2"
								>
									<v-icon>mdi-send</v-icon>
								</v-btn>
								<v-data-table
									:headers="headers"
									:items="datatable"
									item-key="id"
									:disable-pagination="true"
									:hide-default-footer="true"
								>
								</v-data-table>
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
									:disabled="!form_valid || btnLoading || iscomplete"
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
		name: "PerkuliahanUjianMunaqasahTambah",
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
					text: "UJIAN MUNAQASAH",
					disabled: false,
					href: "/akademik/perkuliahan/ujianmunaqasah",
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
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.formdata.nim = this.$store.getters["auth/AttributeUser"](
					"username"
				);
			}
			var page = this.$store.getters['uiadmin/Page']('perkuliahanujianmunaqasah');
			if (typeof page === "undefined") {
				this.$store.dispatch("uiadmin/addToPages", {
					name: "perkuliahanujianmunaqasah",
					data_mhs: {
						nim: this.formdata.nim,
					},
				});
			} else if (Object.keys(page.data_mhs).length > 1) {
				this.data_mhs = page.data_mhs;
				this.formdata.nim = page.data_mhs.nim;
				this.fetchPersyaratanMhs();
			}			
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			ta_matkul: null,
			btnLoading: false,

			//table
			datatableLoading: false,
			dialogdetailitem: false,
			datatable: [],
			headers: [
				{
					text: "NAMA PERSYARATAN",
					value: "nama_persyaratan",
					sortable: true,
					width: 400,
				},
				{
					text: "KETERANGAN",
					value: "group_alias",
					sortable: true,
					width: 120,
				},
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			search: "",

			//formdata
			data_mhs: [],
			form_valid: true,
			iscomplete: true,
			formdata: {
				nim: "",
				persyaratan: [],
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
		}),
		methods: {
			async fetchPersyaratanMhs() {
				this.datatableLoading = true;
				await this.$ajax
					.get(
						"/akademik/perkuliahan/ujianmunaqasah/" + this.data_mhs.nim,						
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_persyaratan;
						this.datatableLoading = false;
					});
			},
			async cekPersyaratan() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					this.datatableLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/ujianmunaqasah/cekpersyaratan",
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
							var page = this.$store.getters['uiadmin/Page']('perkuliahanujianmunaqasah');
							this.data_mhs = data.mahasiswa;
							page.data_mhs = this.data_mhs;
							this.$store.dispatch('uiadmin/updatePage', page);
							this.datatable = data.daftar_persyaratan;
							this.btnLoading = false;
							this.datatableLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
							this.datatableLoading = false;
						});
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/ujianmunaqasah/store",
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
							this.$router.push(
								"/akademik/perkuliahan/ujianmunaqasah/" +
									data.ujian.id +
									"/detail"
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
					var page = this.$store.getters['uiadmin/Page']('perkuliahanujianmunaqasah');
					page.data_mhs = {
						nim: "",
					};
					this.$store.dispatch("uiadmin/updatePage", page);
					this.$router.push("/akademik/perkuliahan/ujianmunaqasah");
				}, 300);
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
		},
	};
</script>
