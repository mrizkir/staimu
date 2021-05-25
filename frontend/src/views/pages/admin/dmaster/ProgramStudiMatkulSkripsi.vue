<template>
	<DataMasterLayout :showrightsidebar="false" v-if="data_prodi">
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
		<v-container fluid>
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
								path: '/dmaster/programstudi/' + data_prodi.id + '/skslulus',
							}"
						>
							<span>SKS LULUS</span>
							<v-icon>mdi-google-street-view</v-icon>
						</v-btn>
						<v-btn :disabled="true">
							<span>MATAKULIAH SKRIPSI</span>
							<v-icon>mdi-concourse-ci</v-icon>
						</v-btn>
						<v-btn
							@click.stop="
								$router.push(
									'/dmaster/programstudi/' + data_prodi.id + '/detail'
								)
							"
						>
							<span>KELUAR</span>
							<v-icon>mdi-close</v-icon>
						</v-btn>
					</v-bottom-navigation>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-data-table
						:headers="headers"
						:items="datatable"
						item-key="id"
						show-expand
						:expanded.sync="expanded"
						:single-expand="true"
						@click:row="dataTableRowClicked"
						class="elevation-1"
						:loading="datatableLoading"
						loading-text="Loading... Please wait"
					>
						<template v-slot:top>
							<v-toolbar flat color="white">
								<v-toolbar-title>DAFTAR MATAKULIAH SKRIPSI</v-toolbar-title>
								<v-divider class="mx-4" inset vertical></v-divider>
								<v-spacer></v-spacer>
								<v-btn
									color="primary"
									class="mb-2"
									:disabled="btnLoading"
									@click.stop="loadmatkulskripsi"
								>
									GENERATE T.A
								</v-btn>
								<v-dialog v-model="dialogfrm" max-width="500px" persistent>
									<v-form ref="frmdata" v-model="form_valid" lazy-validation>
										<v-card>
											<v-card-title>
												<span class="headline">UPDATE MATAKULIAH SKRIPSI</span>
											</v-card-title>
											<v-card-text>
												<v-autocomplete
													label="MATAKULIAH SKRIPSI"
													v-model="formdata.matkul_id"
													:items="daftar_matkul"
													item-text="nmatkul"
													item-value="id"
													outlined
												/>
											</v-card-text>
											<v-card-actions>
												<v-spacer></v-spacer>
												<v-btn
													color="blue darken-1"
													text
													@click.stop="closedialogfrm"
												>
													BATAL
												</v-btn>
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
								</v-dialog>
							</v-toolbar>
						</template>
						<template v-slot:item.actions="{ item }">
							<v-icon
								small
								class="mr-2"
								@click.stop="editItem(item)"
								:disabled="btnLoading"
							>
								mdi-pencil
							</v-icon>
						</template>
						<template v-slot:expanded-item="{ headers, item }">
							<td :colspan="headers.length" class="text-center">
								<v-col cols="12">
									<strong>ID:</strong>{{ item.id }}
									<strong>created_at:</strong>
									{{ $date(item.created_at).format("DD/MM/YYYY HH:mm") }}
									<strong>updated_at:</strong>
									{{ $date(item.updated_at).format("DD/MM/YYYY HH:mm") }}
								</v-col>
							</td>
						</template>
						<template v-slot:no-data>
							Data belum tersedia
						</template>
					</v-data-table>
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
		name: "ProgramStudiSMatkulkripsi",
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
					disabled: false,
					href: "/dmaster/programstudi/" + this.prodi_id + "/detail",
				},
				{
					text: "MATAKULIAH SKRIPSI",
					disabled: true,
					href: "#",
				},
			];
			this.fetchDataProdi();
		},
		data: () => ({
			breadcrumbs: [],
			prodi_id: null,
			data_prodi: null,
			btnLoading: false,
			firstloading: true,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "TAHUN AKADEMIK", value: "ta", sortable: true },
				{
					text: "MATKUL SKRIPSI",
					value: "matkul_skripsi",
					width: 200,
					sortable: false,
				},
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			//form data
			dialogfrm: false,
			daftar_matkul: [],
			formdata: {
				id: null,
				matkul_id: null,
			},
		}),
		mounted() {
			this.fetchMatkulSkripsi();
		},
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
					});
			},
			async fetchMatkulSkripsi() {
				this.datatableLoading = true;
				await this.$ajax
					.get("/datamaster/programstudi/matkulskripsi/" + this.prodi_id, {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.datatable = data.matkulskripsi;
						this.datatableLoading = false;
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
			dataTableRowClicked(item) {
				if (item === this.expanded[0]) {
					this.expanded = [];
				} else {
					this.expanded = [item];
				}
			},
			loadmatkulskripsi: async function() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/datamaster/programstudi/loadmatkulskripsi",
						{
							prodi_id: this.data_prodi.id,
						},
						{
							headers: {
								Authorization: this.TOKEN,
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.matkulskripsi;
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			async editItem(item) {
				await this.$ajax
					.post(
						"/akademik/matakuliah",
						{
							prodi_id: this.data_prodi.id,
							ta:item.ta,
						},
						{
							headers: {
								Authorization: this.TOKEN,
							},
						}
					)
					.then(({ data }) => {
						this.daftar_matkul = data.matakuliah;
						this.formdata = item;
						this.btnLoading = false;
						this.dialogfrm = true;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			async save() {
				if (this.$refs.frmdata.validate()) {
					await this.$ajax
						.post(
							"/datamaster/programstudi/updatematkulskripsi",
							{
								id: this.formdata.id,
								matkul_id: this.formdata.matkul_id,
							},
							{
								headers: {
									Authorization: this.TOKEN,
								},
							}
						)
						.then(() => {
							this.closedialogfrm();
							this.fetchMatkulSkripsi();
						});
				}
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.$refs.frmdata.reset();
					this.matkul_id = null;
				}, 300);
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
