<template>
	<AkademikLayout>
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
					Halaman untuk melihat daftar mahasiswa yang mengikuti ujian munaqasah.
				</v-alert>
			</template>
		</ModuleHeader>
		<template
			v-slot:filtersidebar
			v-if="$store.getters['uiadmin/getDefaultDashboard'] != 'mahasiswa'"
		>
			<Filter18
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeProdi="changeProdi"
				ref="Filter18"
			/>
		</template>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-text>
							<v-text-field
								v-model="search"
								append-icon="mdi-database-search"
								label="Search"
								single-line
								hide-details
							>
							</v-text-field>
							<v-switch
								v-model="filter_ignore"
								label="ABAIKAN FILTER"
								class="font-weight-bold"
							>
							</v-switch>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-data-table
						:headers="headers"
						:items="datatable"
						:search="search"
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
								<v-toolbar-title>
									DAFTAR PESERTA UJIAN MUNAQASAH
								</v-toolbar-title>
								<v-divider class="mx-4" inset vertical></v-divider>
								<v-spacer></v-spacer>
								<v-btn
									color="primary"
									icon
									outlined
									small
									class="ma-2"
									to="/akademik/perkuliahan/ujianmunaqasah/tambah"
									v-if="
										$store.getters['auth/can'](
											'AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_STORE'
										)
									"
								>
									<v-icon>mdi-plus</v-icon>
								</v-btn>
							</v-toolbar>
							<v-dialog v-model="dialogprintpdf" max-width="500px" persistent>
								<v-card>
									<v-card-title>
										<span class="headline">Print to PDF</span>
									</v-card-title>
									<v-card-text>
										<v-btn color="green" text :href="$api.url + '/' + file_pdf">
											Download
										</v-btn>
									</v-card-text>
									<v-card-actions>
										<v-spacer></v-spacer>
										<v-btn
											color="blue darken-1"
											text
											@click.stop="closedialogprintpdf"
										>
											CLOSE
										</v-btn>
									</v-card-actions>
								</v-card>
							</v-dialog>
						</template>
						<template v-slot:item.sah="{ item }">
							<v-chip
								:color="item.sah == 1 ? 'green' : 'warning'"
								text-color="white"
								small
							>
								{{ item.sah == 1 ? "YA" : "TIDAK" }}
							</v-chip>
						</template>
						<template v-slot:item.actions="{ item }">
							<v-btn
								small
								icon
								:disabled="btnLoading"
								@click.stop="printpdf(item)"
							>
								<v-icon>
									mdi-printer
								</v-icon>
							</v-btn>
							<v-btn
								small
								icon
								@click.stop="
									$router.push(
										'/akademik/perkuliahan/ujianmunaqasah/' +
											item.id +
											'/detail'
									)
								"
							>
								<v-icon>
									mdi-eye
								</v-icon>
							</v-btn>
							<v-btn
								small
								icon
								:loading="btnLoadingTable"
								:disabled="btnLoadingTable"
								@click.stop="deleteItem(item)"
							>
								<v-icon>
									mdi-delete
								</v-icon>
							</v-btn>
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
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter18 from "@/components/sidebar/FilterMode18";
	export default {
		name: "PerkuliahanUjianMunaqasah",
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
					disabled: true,
					href: "#",
				},
			];
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.initializeMhs();
				
				let prodi_id = this.$store.getters["uiadmin/getProdiID"];
				this.prodi_id = prodi_id;
				this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
				this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			} else {
				let prodi_id = this.$store.getters["uiadmin/getProdiID"];
				this.prodi_id = prodi_id;
				this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
				this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			}
		},
		mounted() {
			if (this.$store.getters["uiadmin/getDefaultDashboard"] != "mahasiswa") {
				this.initialize();
			}
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			daftar_ta: [],
			tahun_akademik: null,
			filter_ignore: false,
			awaiting_search: false,

			btnLoading: false,
			btnLoadingTable: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "NIM", value: "nim", sortable: true, width: 100 },
				{ text: "NAMA", value: "nama_mhs", sortable: true, width: 250 },
				{ text: "ANGK.", value: "tahun_masuk", sortable: true, width: 100 },
				{
					text: "JUMLAH MATKUL/SKS",
					value: "jumlah_matkul",
					sortable: true,
					width: 100,
				},				
				{ text: "JUDUL SKRIPSI", value: "tasmt", sortable: true, width: 200 },
				{ text: "DOSEN PEMBIMBING", value: "sah", sortable: true, width: 100 },
				{ text: "AKSI", value: "actions", sortable: false, width: 140 },
			],
			search: "",

			dialogprintpdf: false,
			file_pdf: null,
		}),
		methods: {
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			changeProdi(id) {
				this.prodi_id = id;
			},
			async initializeMhs() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/ujianmunaqasah",
						{
							prodi_id: this.prodi_id,
							ta: this.tahun_akademik,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_ujian;
						this.datatableLoading = false;
						this.firstloading = false;
						this.$refs.Filter18.setFirstTimeLoading(this.firstloading);
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/ujianmunaqasah",
						{
							prodi_id: this.prodi_id,
							ta: this.tahun_akademik,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_ujian;
						this.datatableLoading = false;
						this.firstloading = false;
						this.$refs.Filter18.setFirstTimeLoading(this.firstloading);
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
			deleteItem(item) {
				this.$root.$confirm
					.open(
						"Delete",
						"Apakah Anda ingin menghapus ujian dengan NIM (" + item.nim + ") ?",
						{
							color: "red",
							width: 600,
							desc:
								"proses ini juga menghapus seluruh data yang berkaitan dengan ujian ini.",
						}
					)
					.then(confirm => {
						if (confirm) {
							this.btnLoadingTable = true;
							this.$ajax
								.post(
									"/akademik/perkuliahan/ujianmunaqasah/" + item.id,
									{
										_method: "DELETE",
									},
									{
										headers: {
											Authorization: this.$store.getters["auth/Token"],
										},
									}
								)
								.then(() => {
									const index = this.datatable.indexOf(item);
									this.datatable.splice(index, 1);
									this.btnLoadingTable = false;
								})
								.catch(() => {
									this.btnLoadingTable = false;
								});
						}
					});
			},
			async printpdf(item) {
				this.btnLoading = true;
				await this.$ajax
					.get("/akademik/perkuliahan/ujianmunaqasah/printpdf/" + item.id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.file_pdf = data.pdf_file;
						this.dialogprintpdf = true;
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			closedialogprintpdf() {
				setTimeout(() => {
					this.file_pdf = null;
					this.dialogprintpdf = false;
				}, 300);
			},
		},
		watch: {
			tahun_akademik() {
				if (!this.firstloading) {
					this.initialize();
				}
			},
			prodi_id(val) {
				if (!this.firstloading) {
					this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](val);
					this.initialize();
				}
			},
			search() {
				if (!this.awaiting_search) {
					setTimeout(async () => {
						if (this.search.length > 0 && this.filter_ignore) {
							this.datatableLoading = true;
							await this.$ajax
								.post(
									"/akademik/perkuliahan/ujianmunaqasah",
									{
										prodi_id: this.prodi_id,
										ta: this.tahun_akademik,
										search: this.search,
									},
									{
										headers: {
											Authorization: this.$store.getters["auth/Token"],
										},
									}
								)
								.then(({ data }) => {
									this.datatable = data.daftar_ujian;
									this.datatableLoading = false;
								});
						}
						this.awaiting_search = false;
					}, 1000); // 1 sec delay
				}
				this.awaiting_search = true;
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			Filter18,
		},
	};
</script>
