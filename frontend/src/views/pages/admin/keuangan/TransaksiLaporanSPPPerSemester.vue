<template>
	<KeuanganLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-video-input-component
			</template>
			<template v-slot:name>
				LAPORAN TRANSAKSI SPP PER SEMESTER
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER {{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} - {{ nama_prodi }} TAHUN PENDAFTARAN {{ tahun_pendaftaran }} <br />
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
					Halaman ini digunakan untuk melihat laporan transaksi SPP per semester.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter8
				v-on:changeTahunPendaftaran="changeTahunPendaftaran"
				v-on:changeTahunAkademik="changeTahunAkademik"
        v-on:changeSemesterAkademik="changeSemesterAkademik"
				v-on:changeProdi="changeProdi"
				ref="filter8"
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
						item-key="user_id"
						sort-by="nama_mhs"
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
								<v-toolbar-title>DAFTAR TRANSAKSI</v-toolbar-title>
								<v-divider class="mx-4" inset vertical></v-divider>
								<v-spacer></v-spacer>
								<v-btn
									color="primary"
									icon
									outlined
									small
									class="ma-2"
									@click.stop="printtoexcel1"
									:disabled="true"
								>
									<v-icon>mdi-printer</v-icon>
								</v-btn>
							</v-toolbar>
						</template>
						<template v-slot:item.tanggal="{ item }">
							{{ $date(item.tanggal).format("DD/MM/YYYY") }}
						</template>
						<template v-slot:item.sub_total="{ item }">
							{{ item.sub_total | formatUang }}
						</template>
						<template v-slot:item.idsmt="{ item }">
							{{ item.ta }}
							{{ $store.getters["uiadmin/getNamaSemester"](item.idsmt) }}
						</template>
						<template v-slot:item.nama_status="{ item }">
							<v-chip :color="item.style" dark>
								{{ item.nama_status }}
							</v-chip>
						</template>
						<template v-slot:item.actions="{ item }">
							<v-icon small class="mr-2" @click.stop="viewItem(item)" :disabled="true">
								mdi-eye
							</v-icon>
						</template>
						<template v-slot:body.append v-if="datatable.length > 0">
							<tr class="grey lighten-4 font-weight-black">
								<td class="text-right" colspan="3">TOTAL TRANSAKSI</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									0
								</td>
								<td class="text-right">
									{{ totaltransaksi_paid | formatUang }}
								</td>
								<td></td>
							</tr>							
						</template>
						<template v-slot:no-data>
							Data transaksi SPP belum tersedia
						</template>
					</v-data-table>
				</v-col>
			</v-row>
		</v-container>
	</KeuanganLayout>
</template>
<script>
	import KeuanganLayout from "@/views/layouts/KeuanganLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter8 from "@/components/sidebar/FilterMode8";
	export default {
		name: "TransaksiLaporanSPPPerSemester",
		created() {
			this.dashboard = this.$store.getters["uiadmin/getDefaultDashboard"];
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "KEUANGAN",
					disabled: false,
					href: "/keuangan",
				},
				{
					text: "LAPORAN SPP PER SEMESTER",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.tahun_pendaftaran = this.$store.getters[
				"uiadmin/getTahunPendaftaran"
			];
      this.semester_akademik = this.$store.getters["uiadmin/getSemesterAkademik"];
		},
		mounted() {
			this.initialize();
		},
		data: () => ({
			firstloading: true,
			breadcrumbs: [],
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: 0,
			tahun_pendaftaran: null,
      semester_akademik: null,
			filter_ignore: false,
			awaiting_search: false,

			btnLoading: false,

			//tables
			datatableLoading: false,
			datatable: [],
			expanded: [],
			search: "",

			dialogfrm: false,

			//form data
			form_valid: true,
			daftar_semester: [],
			formdata: {
				nim: "",
				semester_akademik: "",
			},
			formdefault: {
				nim: "",
				semester_akademik: "",
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
			rule_semester: [
				value => !!value || "Mohon dipilih Semester untuk transaksi ini !!!",
			],
		}),
		methods: {
			changeProdi(id) {
				this.prodi_id = id;
			},
			changeTahunPendaftaran(tahun) {
				this.tahun_pendaftaran = tahun;
			},
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
      changeSemesterAkademik(semester) {
        this.semester_akademik = semester; 
      },
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanspppersemester",
						{
							prodi_id: this.prodi_id,
							TA: this.tahun_akademik,
							tahun_pendaftaran: this.tahun_pendaftaran,
							semester_akademik: this.semester_akademik,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.transaksi;
						this.datatableLoading = false;
					});
				this.firstloading = false;
				this.$refs.filter8.setFirstTimeLoading(this.firstloading);
			},
			dataTableRowClicked(item) {
				if (item === this.expanded[0]) {
					this.expanded = [];
				} else {
					this.expanded = [item];
				}
			},
			viewItem(item) {
				this.$router.push("/keuangan/transaksi-laporanspppersemester/" + item.transaksi_id);
			},
			printtoexcel1: async function() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanspppersemester/printtoexcel1",
						{
							TA: this.tahun_akademik,
							PRODI_ID: this.prodi_id,
							NAMA_PRODI: this.nama_prodi,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
							responseType: "arraybuffer",
						}
					)
					.then(({ data }) => {
						const url = window.URL.createObjectURL(new Blob([data]));
						const link = document.createElement("a");
						link.href = url;
						link.setAttribute("download", "spp_" + Date.now() + ".xlsx");
						link.setAttribute("id", "download_laporan");
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
			printtoexcel3: async function() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanspppersemester/printtoexcel3",
						{
							TA: this.tahun_akademik,
							PRODI_ID: this.prodi_id,
							NAMA_PRODI: this.nama_prodi,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
							responseType: "arraybuffer",
						}
					)
					.then(({ data }) => {
						const url = window.URL.createObjectURL(new Blob([data]));
						const link = document.createElement("a");
						link.href = url;
						link.setAttribute("download", "spp_" + Date.now() + ".xlsx");
						link.setAttribute("id", "download_laporan");
						document.body.appendChild(link);
						link.click();
						document.body.removeChild(link);
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
		},
		computed: {
			headers() {				
				if (this.semester_akademik == 1) {
					return [				
						{
							text: "NIM",
							value: "nim",
							sortable: true,
							width: 100,
						},
						{
							text: "NAMA MAHASISWA",
							value: "nama_mhs",
							sortable: true,
							width: 250,
						},
						{
							text: "SEP " + this.tahun_akademik,
							value: "bulan9",
							width: 80,
							sortable: true,
							align: "right",
						},
						{
							text: "OKT " + this.tahun_akademik,
							value: "bulan10",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "NOV " + this.tahun_akademik,
							value: "bulan11",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "DES " + this.tahun_akademik,
							value: "bulan12",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "JAN " + (this.tahun_akademik + 1),
							value: "bulan1",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "FEB " + (this.tahun_akademik + 1),
							value: "bulan2",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "JUMLAH",
							value: "sub_total",
							width: 80,
							sortable: false,
							align: "right",
						},					
						{
							text: "AKSI",
							value: "actions",
							sortable: false,
							width: 100,
						},
					];
				} else {
					return [				
						{
							text: "NIM",
							value: "nim",
							sortable: true,
							width: 100,
						},
						{
							text: "NAMA MAHASISWA",
							value: "nama_mhs",
							sortable: true,
							width: 250,
						},
						{
							text: "MAR " + (this.tahun_akademik + 1),
							value: "bulan3",
							width: 80,
							sortable: true,
							align: "right",
						},
						{
							text: "APR " + (this.tahun_akademik + 1),
							value: "bulan4",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "MEI " + (this.tahun_akademik + 1),
							value: "bulan5",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "JUN " + (this.tahun_akademik + 1),
							value: "bulan6",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "JUL " + (this.tahun_akademik + 1),
							value: "bulan7",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "AGU " + (this.tahun_akademik + 1),
							value: "bulan8",
							width: 80,
							sortable: false,
							align: "right",
						},
						{
							text: "JUMLAH",
							value: "sub_total",
							width: 80,
							sortable: false,
							align: "right",
						},					
						{
							text: "AKSI",
							value: "actions",
							sortable: false,
							width: 100,
						},
					];
				}
			},
			totaltransaksi_paid() {
				var total = 0;
				this.datatable.forEach(item => {
					if (item.status == 1) {
						total += item.sub_total;
					}
				});
				return total;
			},
		},
		watch: {
			tahun_akademik() {
				if (!this.firstloading) {
					this.initialize();
				}
			},
			tahun_pendaftaran() {
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
									"/keuangan/transaksi-laporanspppersemester",
									{
										prodi_id: this.prodi_id,
										TA: this.tahun_akademik,
										search: this.search,
									},
									{
										headers: {
											Authorization: this.$store.getters["auth/Token"],
										},
									}
								)
								.then(({ data }) => {
									this.datatable = data.transaksi;
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
			KeuanganLayout,
			ModuleHeader,
			Filter8,
		},
	};
</script>
<style scoped>
	.v-text-field--outlined >>> fieldset {
		border-color: #fb8c01;
	}
</style>
