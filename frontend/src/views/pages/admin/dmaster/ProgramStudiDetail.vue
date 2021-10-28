<template>
	<DataMasterLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-home-assistant
			</template>
			<template v-slot:name>
				PROGRAM STUDI
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
					Halaman untuk mengelola nama-nama program studi pada perguruan tinggi.
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid v-if="data_prodi">
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-toolbar elevation="2">
							<v-toolbar-title>DATA PROGRAM STUDI</v-toolbar-title>
						</v-toolbar>
						<v-card-text>
							<v-row no-gutters>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>ID / KODE:</v-card-title>
										<v-card-text>
											{{ data_prodi.id }} / {{ data_prodi.kode_prodi }}
										</v-card-text>
									</v-card>
								</v-col>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>JENJANG:</v-card-title>
										<v-card-subtitle>
											{{ data_prodi.nama_jenjang }}
										</v-card-subtitle>
									</v-card>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>NAMA PRODI:</v-card-title>
										<v-card-text>
											{{ data_prodi.nama_prodi }}
											[{{ data_prodi.nama_prodi_alias }}]
										</v-card-text>
									</v-card>
								</v-col>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>KETUA PROGRAM STUDI:</v-card-title>
										<v-card-subtitle>
											{{ kaprodi(data_prodi) }}
										</v-card-subtitle>
									</v-card>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-bottom-navigation color="purple lighten-1">
						<v-btn
							:to="{
								path:'/dmaster/programstudi/' + data_prodi.id + '/skslulus',
							}"
						>
							<span>SKS LULUS</span>
							<v-icon>mdi-google-street-view</v-icon>
						</v-btn>
						<v-btn
							:to="{
								path:'/dmaster/programstudi/' + data_prodi.id + '/matkulskripsi',
							}"
						>
							<span>MATAKULIAH SKRIPSI</span>
							<v-icon>mdi-concourse-ci</v-icon>
						</v-btn>
						<v-btn @click.stop="$router.push('/dmaster/programstudi/')">
							<span>KELUAR</span>
							<v-icon>mdi-close</v-icon>
						</v-btn>
					</v-bottom-navigation>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-text>
								<v-autocomplete
									label="KETUA PROGRAM STUDI"
									v-model="dosen_id"
									:items="daftar_dosen"
									item-text="nama_dosen"
									item-value="id"
									return-object
									:disabled="btnLoading"
									outlined
								/>
								<v-text-field
									v-model="nama_jabatan"
									label="NAMA JABATAN"
									outlined
									:rules="rule_nama_jabatan"
								/>
							</v-card-text>
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
	</DataMasterLayout>
</template>
<script>
	import { mapGetters } from "vuex";
	import DataMasterLayout from "@/views/layouts/DataMasterLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	export default {
		name: "ProgramStudiDetail",
		created() {
			this.prodi_id = this.$route.params.prodi_id;
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.ACCESS_TOKEN,
				},
				{
					text: "DATA MASTER",
					disabled: false,
					href: "#",
				},
				{
					text: "PROGRAM STUDI",
					disabled: false,
					href: "/dmaster/programstudi",
				},
				{
					text: "DETAIL",
					disabled: true,
					href: "#",
				},
			];
			this.fetchDataProdi();
		},
		mounted() {
			this.fetchDaftarDosen();
		},
		data: () => ({
			breadcrumbs: [],
			prodi_id: null,
			data_prodi: null,
			btnLoading: false,
			firstloading: true,

			//form data
			form_valid: true,
			daftar_dosen: [],
			dosen_id: null,
			nama_jabatan: null,
			rule_ketua_prodi: [
				value => !!value || "Mohon Ketua Prodi ini untuk dipilih !!!",
			],
			rule_nama_jabatan: [
				value => !!value || "Mohon Nama Jabatan ini untuk diisi !!!",
			],
		}),
		methods: {
			async fetchDataProdi() {
				await this.$ajax
					.get("/datamaster/programstudi/" + this.prodi_id, {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.data_prodi = data.prodi;
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
			async fetchDaftarDosen() {
				this.btnLoading = true;
				await this.$ajax
					.get("/system/usersdosen", {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.daftar_dosen = data.users;
						var config = JSON.parse(this.data_prodi.config);
						this.dosen_id = config.kaprodi;
						this.nama_jabatan = this.dosen_id.nama_jabatan;
						this.btnLoading = false;
					});
				this.firstloading = false;
			},
			kaprodi(item) {
				var message = "N.A";
				if (item.config) {
					var config = JSON.parse(item.config);
					if (config.kaprodi) {
						message = config.kaprodi.name;
					}
				}
				return message;
			},
			save() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					this.dosen_id.nama_jabatan = this.nama_jabatan;
					this.$ajax
						.post(
							"/datamaster/programstudi/updateconfig/" + this.data_prodi.id,
							{
								_method: "PUT",
								config: JSON.stringify({
									kaprodi: this.dosen_id,
								}),
							},
							{
								headers: {
									Authorization: this.TOKEN,
								},
							}
						)
						.then(() => {
							this.btnLoading = false;
							this.$router.go();
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
		},
		computed: {
			...mapGetters("auth", {
				ACCESS_TOKEN: "AccessToken",
				TOKEN: "Token",
			}),
		},		
		components: {
			DataMasterLayout,
			ModuleHeader,
		},
	};
</script>
