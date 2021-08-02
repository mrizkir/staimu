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
						<v-btn :disabled="true">
							<span>SKS LULUS</span>
							<v-icon>mdi-google-street-view</v-icon>
						</v-btn>
						<v-btn
							:to="{
								path:
									'/dmaster/programstudi/' + data_prodi.id + '/matkulskripsi',
							}"
						>
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
								<v-toolbar-title>DAFTAR JUMLAH SKS LULUS</v-toolbar-title>
								<v-divider class="mx-4" inset vertical></v-divider>
								<v-spacer></v-spacer>
								<v-btn
									color="primary"
									class="mb-2"
									:disabled="btnLoading"
									@click.stop="loadskslulus"
								>
									GENERATE T.A
								</v-btn>
							</v-toolbar>
						</template>
						<template v-slot:item.jumlah_sks="props">
							<v-edit-dialog
								:return-value.sync="props.item.jumlah_sks"
								large
								@save="
									saveItem({
										id: props.item.id,
										jumlah_sks: props.item.jumlah_sks,
									})
								"
								@cancel="cancelItem"
								@open="openItem"
								@close="closeItem"
							>
								{{ props.item.jumlah_sks }}
								<template v-slot:input>
									<div class="mt-4 title">Update Jumlah SKS</div>
									<v-text-field
										label="JUMLAH SKS"
										outlined
										autofocus
										v-model="props.item.jumlah_sks"
									>
									</v-text-field>
								</template>
							</v-edit-dialog>
						</template>
						<template v-slot:expanded-item="{ headers, item }">
							<td :colspan="headers.length" class="text-center">
								<v-col cols="12">
									<strong>ID:</strong>{{ item.id }}
									<strong>CREATED AT:</strong>
									{{ $date(item.created_at).format("DD/MM/YYYY HH:mm") }}
									<strong>UPDATED AT:</strong>
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
		name: "ProgramStudiSKSLulus",
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
					text: "SKS LULUS",
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
					text: "JUMLAH SKS",
					value: "jumlah_sks",
					width: 150,
					sortable: false,
				},
			],
			//form data
			daftar_dosen: [],
			dosen_id: null,
		}),
		mounted() {
			this.fetchSKSLulus();
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
			async fetchSKSLulus() {
				this.datatableLoading = true;
				await this.$ajax
					.get("/datamaster/programstudi/skslulus/" + this.prodi_id, {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.datatable = data.skslulus;
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
			loadskslulus: async function() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/datamaster/programstudi/loadskslulus",
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
						this.datatable = data.skslulus;
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			saveItem: async function({ id, jumlah_sks }) {
				await this.$ajax
					.post(
						"/datamaster/programstudi/updateskslulus",
						{
							id: id,
							jumlah_sks: jumlah_sks,
						},
						{
							headers: {
								Authorization: this.TOKEN,
							},
						}
					)
					.then(() => {
						this.fetchSKSLulus();
					});
			},
			cancelItem() {},
			openItem() {},
			closeItem() {},
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
		watch: {
			async dosen_id(val) {
				if (!this.firstloading) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/datamaster/programstudi/updateconfig/" + this.data_prodi.id,
							{
								_method: "PUT",
								config: JSON.stringify({
									kaprodi: val,
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
		components: {
			DataMasterLayout,
			ModuleHeader,
		},
	};
</script>
