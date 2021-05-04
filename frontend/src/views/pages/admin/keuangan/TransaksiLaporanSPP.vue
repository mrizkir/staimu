<template>
	<KeuanganLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-video-input-component
			</template>
			<template v-slot:name>
				LAPORAN PENERIMAAN SPP
			</template>
			<template v-slot:subtitle>
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
					Halaman ini digunakan untuk memperoleh laporan penerimaan SPP
					mahasiswa baru dan lama.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter18
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeProdi="changeProdi"
				ref="filter18"
			/>
		</template>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-data-table
						:headers="headers"
						:items="datatable"
						item-key="no_bulan"						
						class="elevation-1"
						:loading="datatableLoading"
						:disable-pagination="true"
						:hide-default-footer="true"
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
									@click.stop="printtoexcel"
									:disabled="btnLoading"
								>
									<v-icon>mdi-printer</v-icon>
								</v-btn>								
							</v-toolbar>
						</template>
						<template v-slot:item.jumlah="{ item }">
							{{ item.jumlah | formatUang }}
						</template>
						<template v-slot:body.append v-if="datatable.length > 0">
							<tr class="grey lighten-4 font-weight-black">
								<td class="text-right" colspan="2">TOTAL TRANSAKSI</td>
								<td class="text-right">
									{{ totaltransaksi | formatUang }}
								</td>
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
	import Filter18 from "@/components/sidebar/FilterMode18";
	export default {
		name: "TransaksiSPP",
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
					text: "LAPORAN PENERIMAAN SPP",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
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
		}),
		methods: {
			changeProdi(id) {
				this.prodi_id = id;
			},
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/keuangan/transaksi-laporanspp",
						{
							prodi_id: this.prodi_id,
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
					});
				this.firstloading = false;
				this.$refs.filter18.setFirstTimeLoading(this.firstloading);
			},
			async addItem() {
				this.daftar_semester = this.$store.getters["uiadmin/getDaftarSemester"];
				this.formdata.semester_akademik = this.semester_akademik;
				if (this.dashboard == "mahasiswa") {
					this.formdata.nim = this.$store.getters["auth/AttributeUser"](
						"username"
					);
				}
				this.dialogfrm = true;
			},
			viewItem(item) {
				this.$router.push("/keuangan/transaksi-spp/" + item.transaksi_id);
			},
			buatTransaksi: async function() {
				if (this.$refs.frmdata.validate()) {
					await this.$ajax
						.post(
							"/keuangan/transaksi-spp/new",
							{
								nim: this.formdata.nim,
								semester_akademik: this.formdata.semester_akademik,
								TA: this.tahun_akademik,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.btnLoading = false;
							this.$router.push(
								"/keuangan/transaksi-spp/tambah/" + data.transaksi.id
							);
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			deleteItem(item) {
				this.$root.$confirm
					.open(
						"Delete",
						"Apakah Anda ingin menghapus transaksi SPP dengan ID " +
							item.id +
							" ?",
						{ color: "red" }
					)
					.then(confirm => {
						if (confirm) {
							this.btnLoading = true;
							this.$ajax
								.post(
									"/keuangan/transaksi-spp/" + item.id,
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
									this.btnLoading = false;
								})
								.catch(() => {
									this.btnLoading = false;
								});
						}
					});
			},
			printtoexcel: async function() {
				this.btnLoading = false;
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.$refs.frmdata.reset();
				}, 300);
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
			Filter18,
		},
	};
</script>
<style scoped>
	.v-text-field--outlined >>> fieldset {
		border-color: #fb8c01;
	}
</style>
