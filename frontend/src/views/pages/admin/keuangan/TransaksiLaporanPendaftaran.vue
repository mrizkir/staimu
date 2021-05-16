<template>
	<KeuanganLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-video-input-component
			</template>
			<template v-slot:name>
				LAPORAN PENERIMAAN PENDAFTARAN MHS BARU
			</template>
			<template v-slot:subtitle>TAHUN AKADEMIK {{ tahun_akademik }}</template>
			<template v-slot:breadcrumbs>
				<v-breadcrumbs :items="breadcrumbs" class="pa-0">
					<template v-slot:divider>
						<v-icon>mdi-chevron-right</v-icon>
					</template>
				</v-breadcrumbs>
			</template>
			<template v-slot:desc>
				<v-alert color="cyan" border="left" colored-border type="info">
					Halaman ini digunakan untuk memperoleh laporan penerimaan PENDAFTARAN
					mahasiswa baru.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter1 v-on:changeTahunAkademik="changeTahunAkademik" ref="filter1" />
		</template>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<div class="v-data-table theme--light v-data-table--has-top">
						<header
							class="v-sheet theme--light v-toolbar v-toolbar--flat white"
							style="height: 64px"
						>
							<div class="v-toolbar__content" style="height: 64px;">
								<div class="v-toolbar__title">
									REKAPITULASI PENERIMAAN PENDAFTARAN MHS BARU
								</div>
								<hr
									role="separator"
									aria-orientation="vertical"
									class="mx-4 v-divider v-divider--inset v-divider--vertical theme--light"
								/>
								<div class="spacer"></div>
								<v-btn
									color="primary"
									icon
									outlined
									small
									class="ma-2"
									@click.stop="printtoexcel"
									:disabled="btnLoading"
								>
									<v-icon>mdi-printer</v-icon>
								</v-btn>
							</div>
						</header>
						<div class="v-data-table__wrapper">
							<table>
								<thead class="v-data-table-header">
									<tr>
										<th
											class="text-start"
											style="width: 70px; min-width: 70px;"
										>
											NO
										</th>
										<th
											class="text-start"
											style="width: 150px; min-width: 150px;"
										>
											BULAN
										</th>
										<th class="text-end">
											JUMLAH
										</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="item in datatable" v-bind:key="item.no_bulan">
										<td class="text-start">{{ item.no_bulan }}</td>
										<td class="text-start">{{ item.nama_bulan }}</td>
										<td>
											<table width="100%">
												<tr
													v-for="item2 in item.data_prodi"
													v-bind:key="item2.prodi_id"
												>
													<td>{{ item2.nama_prodi }}</td>
													<td class="text-end">
														{{ item2.jumlah | formatUang }}
													</td>
												</tr>
												<tr class="font-weight-medium">
													<td>SUB TOTAL</td>
													<td colspan="2" class="text-end">
														{{ item.sub_total | formatUang }}
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr colspan="2" class="text-end font-weight-medium">
										<td colspan="2">
											TOTAL KESELURUHAN
										</td>
										<td>
											{{ total_keseluruhan | formatUang }}
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</v-col>
			</v-row>
		</v-container>
	</KeuanganLayout>
</template>
<script>
	import KeuanganLayout from "@/views/layouts/KeuanganLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter1 from "@/components/sidebar/FilterMode1";
	export default {
		name: "TransaksiLaporanPendaftaran",
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
					text: "LAPORAN PENERIMAAN PENDAFTARAN MHS BARU",
					disabled: true,
					href: "#",
				},
			];
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
		},
		mounted() {
			this.initialize();
		},
		data: () => ({
			firstloading: true,
			breadcrumbs: [],
			tahun_akademik: 0,
			btnLoading: false,

			//tables
			datatableLoading: false,
			datatable: [],
			headers: [
				{
					text: "NO",
					value: "no_bulan",
					width: 70,
					sortable: false,
				},
				{
					text: "BULAN",
					value: "nama_bulan",
					width: 200,
					sortable: false,
				},
				{
					text: "JUMLAH",
					value: "jumlah",
					align: "end",
					sortable: true,
				},
			],
			total_keseluruhan: 0,
		}),
		methods: {
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanpendaftaran",
						{
							TA: this.tahun_akademik,
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
						this.total_keseluruhan = data.total_keseluruhan;
					});
				this.firstloading = false;
				this.$refs.filter1.setFirstTimeLoading(this.firstloading);
			},
			printtoexcel: async function() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanpendaftaran/printtoexcel1",
						{
							TA: this.tahun_akademik,
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
						link.setAttribute("download", "pendaftaran_" + Date.now() + ".xlsx");
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
			totaltransaksi() {
				var total = 0;
				this.datatable.forEach(item => {
					total += item.jumlah;
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
			prodi_id(val) {
				if (!this.firstloading) {
					this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](val);
					this.initialize();
				}
			},
		},
		components: {
			KeuanganLayout,
			ModuleHeader,
			Filter1,
		},
	};
</script>
<style scoped>
	.v-text-field--outlined >>> fieldset {
		border-color: #fb8c01;
	}
</style>
