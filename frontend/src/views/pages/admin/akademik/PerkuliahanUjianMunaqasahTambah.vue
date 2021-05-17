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
					Halaman untuk melakukan tambah ujian munaqasah
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								CEK PERSYARATAN
							</v-card-title>
							<v-card-text>
								<v-alert type="info">
									sebelum menambah ujian munaqasah sistem akan melakukan
									pengecekan persyaratan. Silahkan masukan NIM, kemudian tekan
									tombol <v-icon>mdi-send</v-icon> untuk memproses.
								</v-alert>
								<v-text-field
									v-model="nim"
									label="NIM"
									:rules="rule_nim"
									outlined
									:disabled="dashboard == 'mahasiswa'"
								/>
								<v-btn
									@click.stop="cekPersyaratan"
									:disabled="!form_valid || btnLoading"
									color="primary"
									icon
									class="ma-2"
								>
									<v-icon>mdi-send</v-icon>
								</v-btn>
							</v-card-text>
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
																item.persyaratan_id == '2021-ujian-munaqasah-5' ||
																item.persyaratan_id == '2021-ujian-munaqasah-6'||
																item.persyaratan_id == '2021-ujian-munaqasah-7'||
																item.persyaratan_id == '2021-ujian-munaqasah-8'||
																item.persyaratan_id == '2021-ujian-munaqasah-9'
															"
														>
															<FileUpload
																:persyaratan_ujian_munaqasah_id="item.id"
																:item="item"
																:index="index"
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
																item.persyaratan_id == '2021-ujian-munaqasah-6' ||
																item.persyaratan_id == '2021-ujian-munaqasah-7' ||
																item.persyaratan_id == '2021-ujian-munaqasah-8' ||
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
													</td>
													<td v-else>
														N.A
													</td>
												</tr>
											</tbody>
										</table>
										<v-dialog v-model="dialogfrm" max-width="700px" persistent>						
											<v-form ref="frmdata" v-model="form_valid" lazy-validation>
												<v-card>
													<v-card-title>
														<span class="headline">TAMBAH DATA SKRIPSI</span>
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
														<v-btn color="blue darken-1" text @click.stop="closedialogfrm">BATAL</v-btn>
														<v-btn
															color="blue darken-1"
															text
															@click.stop="save"															
															:disabled="!form_valid || btnLoading">
																SIMPAN
														</v-btn>
													</v-card-actions>
												</v-card>
											</v-form>
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
									@click.stop="addItem"
									:disabled="!form_valid || btnLoading || !iscomplete"
								>
									BUAT
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
		name: "PerkuliahanUjianMunaqasahTambah",
		created() {
			this.dashboard = this.$store.getters["uiadmin/getDefaultDashboard"];
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
					text: "TAMBAH",
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
				this.nim = this.$store.getters["auth/AttributeUser"](
					"username"
				);
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
			this.fetchPersyaratanMhs();
		},
		data: () => ({
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
			headers: [
				{
					text: "NAMA PERSYARATAN",
					value: "nama_persyaratan",
					sortable: true,
					width: 400,
				},
				{
					text: "KETERANGAN",
					value: "keterangan",
					sortable: false,
					width: 120,
				},
				{
					text: "STATUS",
					value: "status",
					sortable: false,
					width: 120,
				},
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			slides: [],
			dialogpreviewpersyaratan: false,

			//formdata
			nim: "",
			dialogfrm: false,
			data_mhs: [],
			form_valid: true,
			iscomplete: true,
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
				value => !!value || "Mohon untuk di pilih dosen pembimbing ke 1 dan 2 !!!",				
			],
		}),
		methods: {
			async fetchPersyaratanMhs() {
				if (typeof this.data_mhs.nim !== "undefined") {
					this.datatableLoading = true;
					await this.$ajax
						.get("/akademik/perkuliahan/ujianmunaqasah/" + this.data_mhs.nim, {
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						})
						.then(({ data }) => {
							this.datatable = data.daftar_persyaratan;
							this.datatableLoading = false;
							this.iscomplete = data.iscomplete;
						});
				}
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
							"/akademik/perkuliahan/ujianmunaqasah/store",
							{
								user_id: this.data_mhs.user_id,
								judul_skripsi: this.formdata.judul_skripsi,
								abstrak: this.formdata.abstrak,
								pembimbing_1: this.formdata.pembimbing_1,
								pembimbing_2: this.formdata.pembimbing_2,
								ta: this.tahun_akademik
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.$router.push(
								"/akademik/perkuliahan/ujianmunaqasah/" +
									data.ujian.id +
									"/detail"
							);
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
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
			async addItem() {
				await this.$ajax
					.get('/system/usersdosen',{
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.daftar_dosen = data.users;
						this.dialogfrm = true;
					});			
			},
			closedialogfrm() {
				this.dialogfrm = false; 
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
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
		components: {
			AkademikLayout,
			ModuleHeader,
			FileUpload,
		},
	};
</script>
