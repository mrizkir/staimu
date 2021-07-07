<template>
	<KemahasiswaanLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-account-box-multiple
			</template>
			<template v-slot:name>
				DAFTAR MAHASISWA AKTIF
			</template>
			<template v-slot:subtitle>				
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
					Halaman untuk melihat daftar mahasiswa yang aktif.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter4
				v-on:changeProdi="changeProdi"
				ref="Filter4"
			/>
		</template>
		<v-container fluid>
			<v-row dense class="mb-4">
				<v-col xs="12" sm="4" md="3">
					<v-card                         
						class="clickable green darken-1"
						color="#385F73" 
						@click.native="$router.push('/spmb/pendaftaranbaru')"
						dark>
						<v-card-title class="headline">
							TOTAL MAHASISWA
						</v-card-title>
						<v-card-subtitle>
							keseluruhan
						</v-card-subtitle>
						<v-card-text>
							{{ totalmahasiwa }}
						</v-card-text>
					</v-card>
				</v-col>
				<v-col xs="12" sm="4" md="4" v-for="item in daftar_prodi" v-bind:key="item.id">
					<v-card                         
						class="clickable green darken-1"
						color="#385F73" 
						@click.native="$router.push('/spmb/pendaftaranbaru')"
						dark>
						<v-card-title class="headline">
							{{ item.nama_prodi_alias }}
						</v-card-title>
						<v-card-subtitle>
							{{ item.nama_prodi }}
						</v-card-subtitle>
						<v-card-text>
							{{ item.total }}
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
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
						item-key="user_id"
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
								<v-toolbar-title>DAFTAR MAHASISWA</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
							</v-toolbar>
						</template>
						<template v-slot:item.idkelas="{ item }">
							{{ $store.getters["uiadmin/getNamaKelas"](item.idkelas) }}
						</template>
						<template v-slot:item.actions v-if="dashboard == 'mahasiswa'">
							N.A
						</template>
						<template v-slot:no-data>
							Data belum tersedia
						</template>
					</v-data-table>
				</v-col>
			</v-row>
		</v-container>
	</KemahasiswaanLayout>
</template>
<script>
	import KemahasiswaanLayout from "@/views/layouts/KemahasiswaanLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter4 from "@/components/sidebar/FilterMode4";
	export default {
		name: "KemahasiswaanStatusAktif",
		created() {
			this.dashboard = this.$store.getters["uiadmin/getDefaultDashboard"];
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "KEMAHASISWAAN",
					disabled: false,
					href: "/kemahasiswaan",
				},
				{
					text: "MAHASISWA AKTIF",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.initialize();
		},
		mounted() {
			this.firstloading = false;
			this.$refs.Filter4.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			dashboard: null,
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			
			btnLoading: false,
			btnLoadingTable: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{
					text: "NO. FORMULIR",
					value: "no_formulir",
					sortable: true,
					width: 100,
				},
				{ text: "NIM", value: "nim", sortable: true, width: 100 },
				{ text: "NIRM", value: "nirm", sortable: true, width: 100 },
				{
					text: "NAMA MAHASISWA",
					value: "nama_mhs",
					sortable: true,
					width: 250,
				},
				{ text: "KELAS", value: "idkelas", sortable: true, width: 120 },
				{ text: "DOSEN WALI", value: "dosen_wali", sortable: true, width: 200 },
			],
			search: "",

			//statistik
			totalmahasiwa: 0,
			daftar_prodi: [],
		}),
		methods: {
			changeProdi(id) {
				this.prodi_id = id;
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/kemahasiswaan/statusaktif",
						{
							prodi_id: this.prodi_id,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.mahasiswa;
						this.totalmahasiwa = data.total_mahasiswa;
						this.daftar_prodi = data.daftar_prodi;
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
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.data_mhs = Object.assign({}, {});
				}, 300);
			},
		},
		watch: {
			prodi_id(val) {
				if (!this.firstloading) {
					this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](val);
					this.initialize();
				}
			},
		},
		components: {
			KemahasiswaanLayout,
			ModuleHeader,
			Filter4,
		},
	};
</script>
