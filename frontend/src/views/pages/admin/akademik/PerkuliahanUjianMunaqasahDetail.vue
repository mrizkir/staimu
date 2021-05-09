<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-run-fast
			</template>
			<template v-slot:name>
				UJIAN MUNAQASAH
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
					Halaman untuk melakukan detail ujian munaqasah
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid v-if="data_ujian_munaqasah">
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-title>
							DETAIL UJIAN MUNAQASAH
						</v-card-title>
						<v-card-text>
							<v-row no-gutters>
								<v-col xs="12" sm="12" md="12">
									<v-card flat>
										<v-card-title>NIM / NAMA:</v-card-title>
										<v-card-text>
											{{ data_mhs.nim }} /
											{{ data_mhs.nama_mhs }}
										</v-card-text>
									</v-card>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col xs="12" sm="12" md="12">
									<v-card flat>
										<v-card-title>JUDUL SKRIPSI :</v-card-title>
										<v-card-text>
											{{ data_ujian_munaqasah.judul_skripsi }}
										</v-card-text>
									</v-card>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col xs="12" sm="12" md="12">
									<v-card flat>
										<v-card-title>ABSTRAK :</v-card-title>
										<v-card-text>
											{{ data_ujian_munaqasah.abstrak }}
										</v-card-text>
									</v-card>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col xs="12" sm="12" md="12">
									<v-card flat>
										<v-card-title>PEMBIMBING :</v-card-title>
										<v-card-text>
											1. {{ data_ujian_munaqasah.dosen_pembimbing_1 }}<br />
											2. {{ data_ujian_munaqasah.dosen_pembimbing_2 }}
										</v-card-text>
									</v-card>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								PERSYARATAN
							</v-card-title>
							<v-card-text>
								<div class="v-data-table theme--light">
									<div class="v-data-table__wrapper">
										<table>
											<thead class="v-data-table-header">
												<tr>
													<th
														class="text-start"
														style="width: 400px; min-width: 400px;"
													>
														NAMA PERSYARATAN
													</th>
													<th
														class="text-start"
														style="width: 120px; min-width: 120px;"
													>
														KETERANGAN
													</th>
													<th
														class="text-start"
														style="width: 120px; min-width: 120px;"
													>
														STATUS
													</th>
													<th
														class="text-start"
														style="width: 100px; min-width: 100px;"
													>
														AKSI
													</th>
												</tr>
											</thead>
											<tbody>
												<tr
													v-for="(item, index) in datatable"
													v-bind:key="item.id"
												>
													<td class="text-start">
														{{ item.nama_persyaratan }}
														<div
															v-if="
																item.persyaratan_id ==
																	'2021-ujian-munaqasah-5' ||
																	item.persyaratan_id ==
																		'2021-ujian-munaqasah-6' ||
																	item.persyaratan_id ==
																		'2021-ujian-munaqasah-7' ||
																	item.persyaratan_id ==
																		'2021-ujian-munaqasah-8' ||
																	item.persyaratan_id ==
																		'2021-ujian-munaqasah-9'
															"
														>
															<FileUpload
																:persyaratan_ujian_munaqasah_id="item.id"
																:item="item"
																:index="index"
																v-if="item.status == 0"
															/>
														</div>
													</td>
													<td class="text-start">
														{{ item.keterangan }}
													</td>
													<td class="text-start">
														{{ item.nama_status }}
													</td>
													<td
														v-if="
															item.persyaratan_id == '2021-ujian-munaqasah-5' ||
																item.persyaratan_id ==
																	'2021-ujian-munaqasah-6' ||
																item.persyaratan_id ==
																	'2021-ujian-munaqasah-7' ||
																item.persyaratan_id ==
																	'2021-ujian-munaqasah-8' ||
																item.persyaratan_id == '2021-ujian-munaqasah-9'
														"
													>
														<v-btn
															small
															icon
															@click.stop="previewImagePersyaratan(item)"
															:disabled="!item.file"
														>
															<v-icon>
																mdi-eye
															</v-icon>
														</v-btn>
														<v-btn
															small
															icon															
															v-if="dashboard == 'mahasiswa'"
															:disabled="true"
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
														<v-btn
															small
															icon
															@click.stop="updateStatusPersyaratan(item)"
															:disabled="!item.file || item.status == 1 || btnLoading"
															v-else
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
													</td>
													<td v-else-if="item.persyaratan_id == '2021-ujian-munaqasah-1'">
														<v-btn
															small
															icon
															@click.stop="previewSPP()"
														>
															<v-icon>
																mdi-eye
															</v-icon>
														</v-btn>
														<v-btn
															small
															icon															
															v-if="dashboard == 'mahasiswa'"
															:disabled="true"
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
														<v-btn
															small
															icon
															@click.stop="updateStatusPersyaratan(item)"
															:disabled="item.status == 1 || btnLoading"
															v-else
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
													</td>
													<td v-else>
														<v-btn
															small
															icon															
															v-if="dashboard == 'mahasiswa'"
															:disabled="true"
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
														<v-btn
															small
															icon
															@click.stop="updateStatusPersyaratan(item)"
															:disabled="!['SUDAH BAYAR','ADA'].includes(item.keterangan) || item.status == 1"
															v-else
														>
															<v-icon v-if="item.status == 0">
																mdi-briefcase-remove
															</v-icon>
															<v-icon v-else-if="item.status == 1">
																mdi-briefcase-check
															</v-icon>
														</v-btn>
													</td>
												</tr>
											</tbody>
										</table>
										<v-dialog v-model="dialogfrm" max-width="700px" persistent>
											<v-form
												ref="frmdata"
												v-model="form_valid"
												lazy-validation
											>
												<v-card>
													<v-card-title>
														<span class="headline">UBAH DATA SKRIPSI</span>
													</v-card-title>
													<v-card-text>
														<v-text-field
															v-model="formdata.judul_skripsi"
															label="JUDUL SKRIPSI:"
															outlined
															:rules="rule_judul_skripsi"
														>
														</v-text-field>
														<v-textarea
															v-model="formdata.abstrak"
															label="ABSTRAK:"
															outlined
															:rules="rule_abstrak"
														/>
														<v-autocomplete
															label="DOSEN PEMBIMBING I:"
															v-model="formdata.pembimbing_1"
															:items="daftar_dosen"
															item-text="nama_dosen"
															item-value="id"
															:rules="rule_dosen_pembimbing"
															outlined
														/>
														<v-autocomplete
															label="DOSEN PEMBIMBING II:"
															v-model="formdata.pembimbing_2"
															:items="daftar_dosen"
															item-text="nama_dosen"
															item-value="id"
															:rules="rule_dosen_pembimbing"
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
										<v-dialog v-model="dialogpreviewspp" max-width="700px" persistent>
											<v-card>
												<v-card-title>
													<span class="headline">DAFTAR TRANSAKSI SPP</span>
												</v-card-title>
												<v-card-text>
													<v-data-table
														:headers="headers_spp"
														:items="datatable_spp"														
														item-key="id"														
														:single-expand="true"														
														class="elevation-1"
														:loading="datatableLoading"
														loading-text="Loading... Please wait"
													>
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
														<template v-slot:body.append v-if="datatable.length > 0">
															<tr class="grey lighten-4 font-weight-black">
																<td class="text-right" colspan="5">TOTAL TRANSAKSI PAID</td>
																<td class="text-right">
																	{{ totaltransaksi_paid | formatUang }}
																</td>
															</tr>
															<tr class="grey lighten-4 font-weight-black">
																<td class="text-right" colspan="5">TOTAL TRANSAKSI UNPAID</td>
																<td class="text-right">
																	{{ totaltransaksi_unpaid | formatUang }}
																</td>
															</tr>
															<tr class="grey lighten-4 font-weight-black">
																<td class="text-right" colspan="5">TOTAL TRANSAKSI CANCELED</td>
																<td class="text-right">
																	{{ totaltransaksi_canceled | formatUang }}
																</td>
															</tr>
															<tr class="grey lighten-4 font-weight-black">
																<td class="text-right" colspan="5">TOTAL TRANSAKSI</td>
																<td class="text-right">
																	{{
																		(totaltransaksi_canceled +
																			totaltransaksi_paid +
																			totaltransaksi_unpaid)
																			| formatUang
																	}}
																</td>
															</tr>
														</template>
														<template v-slot:no-data>
															Data transaksi SPP belum tersedia
														</template>
													</v-data-table>
												</v-card-text>
												<v-card-actions>
													<v-spacer></v-spacer>
													<v-btn
														color="blue darken-1"
														text
														@click.stop="closedialogspp"
													>
														TUTUP
													</v-btn>									
												</v-card-actions>
											</v-card>
										</v-dialog>
										<v-dialog v-model="dialogpreviewpersyaratan">
											<v-carousel height="auto">
												<v-carousel-item
													v-for="(slide, i) in slides"
													:key="i"
													:src="slide.path"
												>
													<v-row
														class="fill-height"
														align="center"
														justify="center"
													>
														<div class="display-3">
															{{ slide.nama_persyaratan }}
														</div>
													</v-row>
												</v-carousel-item>
											</v-carousel>
										</v-dialog>
									</div>
								</div>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click.stop="exit">
									BATAL
								</v-btn>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="verifikasi"
									:disabled="!form_valid || btnLoading || !isverified || this.data_ujian_munaqasah.status == 1"
								>
									VERIFIKASI
								</v-btn>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="editItem"
									:disabled="!form_valid || btnLoading || !iscomplete || this.data_ujian_munaqasah.status == 1"
								>
									UBAH
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
	import FileUpload from "@/components/FileUploadPersyaratanUjianMunaqasah";
	export default {
		name: "PerkuliahanUjianMunaqasahDetail",
		created() {
			this.dashboard = this.$store.getters["uiadmin/getDefaultDashboard"];
			this.ujian_munaqasah_id = this.$route.params.ujian_munaqasah_id;
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
					text: "DETAIL",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			if (this.dashboard == "mahasiswa") {
				this.data_mhs = this.$store.getters["auth/User"];
				this.data_mhs["user_id"] = this.data_mhs.id;
				this.data_mhs["nim"] = this.data_mhs.username;
				this.nim = this.$store.getters["auth/AttributeUser"]("username");
			}
			var page = this.$store.getters["uiadmin/Page"](
				"perkuliahanujianmunaqasah"
			);
			if (typeof page === "undefined") {
				this.$store.dispatch("uiadmin/addToPages", {
					name: "perkuliahanujianmunaqasah",
					data_mhs: {
						nim: this.nim,
					},
				});
			} else if (Object.keys(page.data_mhs).length > 1) {
				this.data_mhs = page.data_mhs;
				this.nim = page.data_mhs.nim;
			}
		},
		mounted() {
			this.fetchDetailUjianMunaqasah();
		},
		data: () => ({
			ujian_munaqasah_id: null,
			data_ujian_munaqasah: null,
			dashboard: null,
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			btnLoading: false,

			//table
			datatableLoading: false,
			dialogdetailitem: false,
			datatable: [],
			datatable_spp: [],
			headers_spp: [
				{
					text: "KODE BILLING",
					value: "no_transaksi",
					width: 100,
					sortable: true,
				},
				{
					text: "TANGGAL",
					value: "tanggal",
					width: 90,
					sortable: true,
				},
				{
					text: "BULAN",
					value: "nama_bulan",
					width: 100,
					sortable: true,
				},
				{
					text: "TA/SMT",
					value: "idsmt",
					width: 50,
					sortable: false,
				},
				{
					text: "JUMLAH",
					value: "sub_total",
					width: 100,
					sortable: false,
					align: "right",
				},
				{
					text: "STATUS",
					value: "nama_status",
					width: 100,
					sortable: false,
				},
			],
			slides: [],
			dialogpreviewspp: false,
			dialogpreviewpersyaratan: false,

			//formdata
			nim: "",
			dialogfrm: false,
			data_mhs: [],
			form_valid: true,
			iscomplete: true,
			isverified: true,
			daftar_dosen: [],
			formdata: {
				id: null,
				user_id: null,
				judul_skripsi: "",
				abstrak: "",
				pembimbing_1: null,
				pembimbing_2: null,
				keterangan: "",
			},
			formdefault: {
				id: null,
				user_id: null,
				judul_skripsi: "",
				abstrak: "",
				pembimbing_1: null,
				pembimbing_2: null,
				keterangan: "",
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
			rule_judul_skripsi: [
				value => !!value || "Mohon untuk di isi judul skrispi !!!",
			],
			rule_abstrak: [
				value => !!value || "Mohon untuk di isi abstrak skrispi !!!",
			],
			rule_dosen_pembimbing: [
				value =>
					!!value || "Mohon untuk di pilih dosen pembimbing ke 1 dan 2 !!!",
			],
		}),
		methods: {
			async fetchDetailUjianMunaqasah() {
				this.datatableLoading = true;
				await this.$ajax
					.get(
						"/akademik/perkuliahan/ujianmunaqasah/detail/" +
							this.ujian_munaqasah_id,
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.data_mhs = data.mahasiswa;
						this.data_ujian_munaqasah = data.ujian;
						this.formdata = this.data_ujian_munaqasah;
						this.datatable = data.daftar_persyaratan;
						this.datatableLoading = false;
						this.iscomplete = data.iscomplete;
						this.isverified = data.isverified;
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
								nim: this.nim,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.iscomplete = data.iscomplete;
							this.isverified = data.isverified;
							var page = this.$store.getters["uiadmin/Page"](
								"perkuliahanujianmunaqasah"
							);
							this.data_mhs = data.mahasiswa;
							page.data_mhs = this.data_mhs;
							this.$store.dispatch("uiadmin/updatePage", page);
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
							"/akademik/perkuliahan/ujianmunaqasah/" + this.ujian_munaqasah_id,
							{
								_method: "PUT",
								judul_skripsi: this.formdata.judul_skripsi,
								abstrak: this.formdata.abstrak,
								pembimbing_1: this.formdata.pembimbing_1,
								pembimbing_2: this.formdata.pembimbing_2,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(() => {
							this.$router.go();
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			async previewSPP() {
				await this.$ajax
					.get("/keuangan/transaksi-spp/" + this.data_mhs.user_id + "/mhs", {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.datatable_spp = data.transaksi;
						this.dialogpreviewspp = true;
					});			
			},
			previewImagePersyaratan(item) {
				if (item.file == null) {
					this.dialogpreviewpersyaratan = false;
				} else {
					this.slides.push({
						path: this.$api.url + "/" + item.file,
						nama_persyaratan:item.nama_persyaratan,
					});
					this.dialogpreviewpersyaratan = true;
				}
			},
			async updateStatusPersyaratan(item) {
				this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/ujianmunaqasah/" + item.id + "/updatepersyaratan",
							{
								_method: "PUT",
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(() => {
							this.$router.go();
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
			},
			async editItem() {
				await this.$ajax
					.get("/system/usersdosen", {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.daftar_dosen = data.users;
						this.dialogfrm = true;
					});
			},
			async verifikasi() {
				this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/ujianmunaqasah/" + this.ujian_munaqasah_id + "/verifikasi",
							{
								_method: "PUT",
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(() => {
							this.$router.go();
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
			},
			closedialogspp() {
				this.dialogpreviewspp = false;
				setTimeout(() => {
					this.datatable_spp = [];
				},300);
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.$refs.frmdata.reset();
				},300);
			},
			exit() {
				setTimeout(() => {
					var page = this.$store.getters["uiadmin/Page"](
						"perkuliahanujianmunaqasah"
					);
					page.data_mhs = {
						nim: "",
					};
					this.$store.dispatch("uiadmin/updatePage", page);
					this.$router.push("/akademik/perkuliahan/ujianmunaqasah");
				},300);
			},
		},
		computed: {
			totaltransaksi_paid() {
				var total = 0;
				this.datatable_spp.forEach(item => {
					if (item.status == 1) {
						total += item.sub_total;
					}
				});
				return total;
			},
			totaltransaksi_unpaid() {
				var total = 0;
				this.datatable_spp.forEach(item => {
					if (item.status == 0) {
						total += item.sub_total;
					}
				});
				return total;
			},
			totaltransaksi_canceled() {
				var total = 0;
				this.datatable_spp.forEach(item => {
					if (item.status == 2) {
						total += item.sub_total;
					}
				});
				return total;
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			FileUpload,
		},
	};
</script>
