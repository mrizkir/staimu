<template>
	<AkademikLayout>
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
					Halaman untuk melakukan perubahan terhadap KRS yang telah disahkan
					oleh Dosen Wali.
				</v-alert>
			</template>
		</ModuleHeader>
		<template
			v-slot:filtersidebar
			v-if="$store.getters['uiadmin/getDefaultDashboard'] != 'mahasiswa'"
		>
			<Filter6
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeSemesterAkademik="changeSemesterAkademik"
				v-on:changeProdi="changeProdi"
				ref="filter6"
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
							></v-text-field>
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
								<v-toolbar-title>DAFTAR MAHASISWA YANG PKRS</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
								<v-btn
									color="primary"
									icon
									outlined
									small
									class="ma-2"
									to="/akademik/perkuliahan/pkrs/tambah"
									v-if="
										$store.getters['auth/can'](
											'AKADEMIK-PERKULIAHAN-PKRS_STORE'
										)
									"
								>
									<v-icon>mdi-plus</v-icon>
								</v-btn>
							</v-toolbar>
						</template>
						<template v-slot:expanded-item="{ headers, item }">
							<td :colspan="headers.length" class="text-center">
								<v-col cols="12">
									<strong>ID:</strong>
									{{ item.id }}
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
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter6 from "@/components/sidebar/FilterMode6";
	export default {
		name: "PerkuliahanPKRS",
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
					disabled: true,
					href: "#",
				},
			];
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.initializeMhs();
			} else {
				let prodi_id = this.$store.getters["uiadmin/getProdiID"];
				this.prodi_id = prodi_id;
				this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
				this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
				this.semester_akademik = this.$store.getters[
					"uiadmin/getSemesterAkademik"
				];
			}
		},
		mounted() {
			if (this.$store.getters["uiadmin/getDefaultDashboard"] != "mahasiswa") {
				this.initialize();
			}
			this.firstloading = false;
			this.$refs.filter6.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			daftar_ta: [],
			tahun_akademik: null,
			semester_akademik: null,
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
				{ text: "MATAKULIAH", value: "nmatkul", sortable: true, width: 100 },
				{ text: "SKS", value: "sks", sortable: true, width: 100 },
				{ text: "KET.", value: "ket", sortable: true, width: 100 },
			],
			search: "",
		}),
		methods: {
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			changeSemesterAkademik(semester) {
				this.semester_akademik = semester;
			},
			changeProdi(id) {
				this.prodi_id = id;
			},
			async initializeMhs() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/pkrs",
						{},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_pkrs;
						this.datatableLoading = false;
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/pkrs",
						{
							prodi_id: this.prodi_id,
							ta: this.tahun_akademik,
							semester_akademik: this.semester_akademik,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_pkrs;
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
		},
		watch: {
			tahun_akademik() {
				if (!this.firstloading) {
					this.initialize();
				}
			},
			semester_akademik() {
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
									"/akademik/perkuliahan/pkrs",
									{
										prodi_id: this.prodi_id,
										ta: this.tahun_akademik,
										semester_akademik: this.semester_akademik,
										search: this.search,
									},
									{
										headers: {
											Authorization: this.$store.getters["auth/Token"],
										},
									}
								)
								.then(({ data }) => {
									this.datatable = data.daftar_pkrs;
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
			Filter6,
		},
	};
</script>
