<template>
	<AkademikLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-account-network
			</template>
			<template v-slot:name>
				PPL / PKL
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER {{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} - {{ nama_prodi }}
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
					Halaman ini digunakan untuk mengelola PPL / PKL mahasiswa. Penentuan syarat matakuliah PPL / PPL ada di halaman Matakuliah.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
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
						sort-by="name"
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
								<v-toolbar-title>DAFTAR PESERTA PPL / PKL</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
								<v-tooltip bottom>
									<template v-slot:activator="{ on, attrs }">
										<v-btn
											color="primary"
											icon
											outlined
											small
											class="ma-2"
											v-bind="attrs"
											v-on="on"
											:disabled="false"
											@click.stop="addItem"
										>
											<v-icon>mdi-plus</v-icon>
										</v-btn>
									</template>
									<span>Tambah Peserta</span>
								</v-tooltip>
								<v-dialog v-model="dialogfrm" max-width="500px" persistent>									
									<v-form ref="frmdata" v-model="form_valid" lazy-validation>
										<v-card>
											<v-card-title>
												<span class="headline">{{ formTitle }}</span>
											</v-card-title>
											<v-card-text>
												<v-text-field
													v-model="formdata.nim"
													label="NIM"
													outlined
													:rules="rule_nim"
													:disabled="editedIndex > -1 || dashboard == 'mahasiswa'"													
												>
												</v-text-field>
												<v-text-field
													v-model="formdata.tempat_pplpkl"
													label="TEMPAT PPL/PKL"
													outlined
													:rules="rule_tempat"													
												>
												</v-text-field>
												<v-select
													label="PROVINSI"
													:items="daftar_provinsi"
													v-model="provinsi_id"
													item-text="nama"
													item-value="id"
													return-object
													:loading="btnLoadingProv"
													outlined
												/>
												<v-select
													label="KABUPATEN/KOTA"
													:items="daftar_kabupaten"
													v-model="kabupaten_id"
													item-text="nama"
													item-value="id"
													return-object
													:loading="btnLoadingKab"
													outlined
												/>
												<v-select
													label="KECAMATAN"
													:items="daftar_kecamatan"
													v-model="kecamatan_id"
													item-text="nama"
													item-value="id" 
													return-object                           
													outlined
												/>
												<v-select
													label="DESA/KELURAHAN"
													:items="daftar_desa"
													v-model="desa_id"
													item-text="nama"
													item-value="id"
													return-object
													:rules="rule_desa"
													outlined
												/>
												<v-text-field
													v-model="formdata.alamat_pplpkl"
													label="ALAMAT TEMPAT PPL / PKL"
													:rules="rule_alamat_pplpkl"
													outlined
												/>
												<v-select
													label="SIZE BAJU"
													:items="daftar_size_baju"
													v-model="formdata.size_baju"													
													outlined
												/>
												<v-autocomplete
													label="DOSEN PA:"
													v-model="formdata.pembimbing_1"
													:items="daftar_dosen"
													item-text="nama_dosen"
													item-value="id"
													:rules="rule_dosen_pembimbing"
													outlined
													v-if="editedIndex > -1"
												/>
												<v-textarea
													v-model="formdata.keterangan"
													label="CATATAN:"
													outlined
													hide-details
												/>
											</v-card-text>
											<v-card-actions>
												<v-spacer></v-spacer>
												<v-btn
													color="blue darken-1"
													text
													@click.stop="closedialogfrm"
												>
													TUTUP
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
								<v-dialog
									v-model="dialogdetailitem"
									max-width="800px"
									persistent
								>
									<v-card>
										<v-card-title>
											<span class="headline">DETAIL DATA</span>
										</v-card-title>
										<v-card-text>
											<v-row no-gutters>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>ID :</v-card-title>
														<v-card-subtitle>
															{{ formdata.id }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>DOSEN PEMBIMBING :</v-card-title>
														<v-card-subtitle>
															{{
																$date(formdata.created_at).format(
																	"DD/MM/YYYY HH:mm"
																)
															}}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
											</v-row>
											<v-row no-gutters>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>NIM / NAMA MAHASISWA :</v-card-title>
														<v-card-subtitle>
															{{ formdata.nim }} / {{ formdata.nama_mhs }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>UKURAN BAJU :</v-card-title>
														<v-card-subtitle>
															{{ formdata.size_baju }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
											</v-row>
											<v-row no-gutters>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>TEMPAT PPL / PKL :</v-card-title>
														<v-card-subtitle>
															{{ formdata.tempat_pplpkl }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>STATUS :</v-card-title>
														<v-card-subtitle>
															{{ formdata.status }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
											</v-row>
											<v-row no-gutters>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>ALAMAT PPL / PKL :</v-card-title>
														<v-card-subtitle>
															{{ formdata.alamat_pplpkl }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>CREATED / UPDATED :</v-card-title>
														<v-card-subtitle>
															{{
																$date(formdata.created_at).format(
																	"DD/MM/YYYY HH:mm"
																)
															}} /
															{{
																$date(formdata.updated_at).format(
																	"DD/MM/YYYY HH:mm"
																)
															}}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
											</v-row>
										</v-card-text>
										<v-card-actions>
											<v-spacer></v-spacer>
											<v-btn
												color="blue darken-1"
												text
												@click.stop="closedialogdetailitem"
											>
												TUTUP
											</v-btn>
										</v-card-actions>
									</v-card>
								</v-dialog>
							</v-toolbar>
						</template>
						<template v-slot:item.actions="{ item }">
							<v-tooltip bottom>
								<template v-slot:activator="{ on, attrs }">
									<v-icon
										v-bind="attrs"
										v-on="on"
										small
										class="mr-2"
										@click.stop="viewItem(item)"
									>
										mdi-eye
									</v-icon>
								</template>
								<span>Detail PPL / PKL</span>
							</v-tooltip>
							<v-tooltip bottom>
								<template v-slot:activator="{ on, attrs }">
									<v-icon
										v-bind="attrs"
										v-on="on"
										small
										class="mr-2"
										@click.stop="editItem(item)"
										:disabled="item.status == 1"
									>
										mdi-pencil
									</v-icon>
								</template>
								<span>Ubah PPL / PKL</span>
							</v-tooltip>
							<v-tooltip bottom>
								<template v-slot:activator="{ on, attrs }">
									<v-icon
										v-bind="attrs"
										v-on="on"
										small
										color="red darken-1"
										:disabled="btnLoading || item.status == 1"
										@click.stop="deleteItem(item)"
									>
										mdi-delete
									</v-icon>
								</template>
								<span>Hapus PPL / PKL</span>
							</v-tooltip>
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
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter6 from "@/components/sidebar/FilterMode6";
	export default {
		name: "PerkuliahanPPLPKL",
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
					text: "PPL / PKL",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters["uiadmin/getSemesterAkademik"];
			this.initialize();
		},
		mounted() {
			this.firstloading = false;
			this.$refs.filter6.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			dashboard: null,
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			semester_akademik: null,
			
			btnLoading: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "NIM", value: "nim", sortable: true, width: 100 },
				{ text: "NAMA", value: "nama_mhs", sortable: true, width: 200 },
				{ text: "ANGK.", value: "tahun_masuk", sortable: true, width: 100 },
				{ text: "TEMPAT PPL/PKL", value: "tempat_pplpkl", sortable: true, width: 170 },
				{ text: "SIZE BAJU", value: "size_baju", sortable: false, width: 100 },
				{ text: "PEMBIMBING", value: "dosen_pembimbing_1", sortable: true, width: 170 },
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			search: "",

			//dialog
			dialogfrm: false,
			dialogdetailitem: false,

			//form data
			form_valid: true,
			btnLoadingProv: false,
			btnLoadingKab: false,
			btnLoadingKec: false,
			daftar_provinsi: [],
			provinsi_id: 0,

			daftar_kabupaten: [],
			kabupaten_id: 0,

			daftar_kecamatan: [],
			kecamatan_id: 0,

			daftar_desa: [],
			desa_id: 0,

			daftar_size_baju: ["S", "M", "L", "XL", "XXL", "XXXL"],

			daftar_dosen: [],

			formdata: {
				id: null,
				nim: null,
				pembimbing_1: null,
				tempat_pplpkl: null,
				alamat_pplpkl: null,
				size_baju: 'M',
				keterangan: '',
			},
			formdefault: {
				id: null,
				nim: null,
				pembimbing_1: null,
				tempat_pplpkl: null,
				alamat_pplpkl: null,
				size_baju: 'M',
				keterangan: '',
			},
			editedIndex: -1,

			//form rules
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
			rule_tempat: [
				value => !!value || "Tempat PPL / PKL mohon untuk diisi !!!",
			],
			rule_desa: [
				value => !!value || "Mohon Desa mohon untuk diisi !!!"
			],
			rule_alamat_pplpkl: [
				value => !!value || "Alamat Tempat PPL / PKL mohon untuk diisi !!!"
			],
			rule_dosen_pembimbing: [
				value => !!value || "Mohon untuk di pilih dosen pembimbing ke 1 dan 2 !!!",				
			],
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
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/pplpk",
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
						this.datatable = data.daftar_pplpkl;
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
			async addItem() {
				if (this.dashboard == 'mahasiswa') {
					this.formdata.nim = this.$store.getters['auth/AttributeUser']('username');
				}
				await this.$ajax.get("/datamaster/provinsi").then(({ data }) => {
					this.daftar_provinsi = data.provinsi;					
				});

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
			viewItem(item) {
				this.formdata = item;
				this.dialogdetailitem = true;			
			},
			editItem(item) {
				this.editedIndex = this.datatable.indexOf(item);
				this.formdata = Object.assign({}, item);
				this.dialogfrm = true;

				this.$ajax.get("/datamaster/provinsi").then(({ data }) => {
					this.daftar_provinsi = data.provinsi;					
				});

				this.$ajax
					.get('/system/usersdosen',{
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.daftar_dosen = data.users;
					});

				this.$ajax
					.get("/akademik/perkuliahan/pplpk/" + this.formdata.id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {						
						this.formdata.nim = data.pplpkl.nim;
						this.formdata.pembimbing_1 = data.pplpkl.pembimbing_1;
						this.formdata.tempat_pplpkl = data.pplpkl.tempat_pplpkl;
						this.formdata.alamat_pplpkl = data.pplpkl.alamat_pplpkl;
						this.formdata.size_baju = data.pplpkl.size_baju;
						this.formdata.keterangan = data.pplpkl.keterangan;

						this.provinsi_id = {
							id: "" + data.pplpkl.address1_provinsi_id,
							nama: "" + data.pplpkl.address1_provinsi
						};
						this.kabupaten_id = {
							id: "" + data.pplpkl.address1_kabupaten_id,
							nama: "" + data.pplpkl.address1_kabupaten
						};
						this.kecamatan_id = {
							id: "" + data.pplpkl.address1_kecamatan_id,
							nama: "" + data.pplpkl.address1_kecamatan
						};
						this.desa_id = {
							id: "" + data.pplpkl.address1_desa_id,
							nama: "" + data.pplpkl.address1_kelurahan
						};
					})
					.catch(() => {
						this.btnLoading = false;
					});					
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					if (this.editedIndex > -1) {
						await this.$ajax
							.post(
								"/akademik/perkuliahan/pplpk/" + this.formdata.id,
								{
									_method: "PUT",
									pembimbing_1: this.formdata.pembimbing_1,
									tempat_pplpkl: this.formdata.tempat_pplpkl,
									address1_provinsi_id: this.provinsi_id.id,
									address1_provinsi: this.provinsi_id.nama,
									address1_kabupaten_id: this.kabupaten_id.id,
									address1_kabupaten: this.kabupaten_id.nama,
									address1_kecamatan_id: this.kecamatan_id.id,
									address1_kecamatan: this.kecamatan_id.nama,
									address1_desa_id: this.desa_id.id,
									address1_kelurahan: this.desa_id.nama,
									alamat_pplpkl: this.formdata.alamat_pplpkl,
									size_baju: this.formdata.size_baju,
									keterangan: this.formdata.keterangan,
								},
								{
									headers: {
										Authorization: this.$store.getters["auth/Token"],
									},
								}
							)
							.then(() => {
								this.initialize();
								this.closedialogfrm();
								this.btnLoading = false;
							})
							.catch(() => {
								this.btnLoading = false;
							});
					} else {
						await this.$ajax
							.post(
								"/akademik/perkuliahan/pplpk/store",
								{
									nim: this.formdata.nim,
									pembimbing_1: this.formdata.pembimbing_1,
									tempat_pplpkl: this.formdata.tempat_pplpkl,
									address1_provinsi_id: this.provinsi_id.id,
									address1_provinsi: this.provinsi_id.nama,
									address1_kabupaten_id: this.kabupaten_id.id,
									address1_kabupaten: this.kabupaten_id.nama,
									address1_kecamatan_id: this.kecamatan_id.id,
									address1_kecamatan: this.kecamatan_id.nama,
									address1_desa_id: this.desa_id.id,
									address1_kelurahan: this.desa_id.nama,
									alamat_pplpkl: this.formdata.alamat_pplpkl,
									size_baju: this.formdata.size_baju,
									keterangan: this.formdata.keterangan,
									ta: this.tahun_akademik,
									idsmt: this.semester_akademik,									
								},
								{
									headers: {
										Authorization: this.$store.getters["auth/Token"],
									},
								}
							)
							.then(() => {
								this.initialize();
								this.closedialogfrm();
								this.btnLoading = false;
							})
							.catch(() => {
								this.btnLoading = false;
							});
					}
				}
			},
			deleteItem(item) {
				this.$root.$confirm
					.open(
						"Delete",
						"Apakah Anda ingin menghapus data PPL / PKL dengan ID " + item.id + " ?",
						{ color: "red", width: "600px" }
					)
					.then(confirm => {
						if (confirm) {
							this.btnLoading = true;
							this.$ajax
								.post(
									"/akademik/perkuliahan/pplpk/" + item.id,
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
			closedialogdetailitem() {
				this.dialogdetailitem = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
				}, 300);
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
					this.$refs.frmdata.reset();
				}, 300);
			},
		},
		computed: {
			formTitle() {
				return this.editedIndex === -1 ? "DAFTAR PPL / PKL" : "UBAH DATA";
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
			provinsi_id(val) {
				if (val.id != null && val.id != "") {
					this.btnLoadingProv = true;
					this.$ajax
						.get("/datamaster/provinsi/" + val.id + "/kabupaten")
						.then(({ data }) => {
							this.daftar_kabupaten = data.kabupaten;
							this.btnLoadingProv = false;
						});
					this.daftar_kecamatan = [];
				}
			},
			kabupaten_id(val) {
				if (val.id != null && val.id != "") {
					this.btnLoadingKab = true;
					this.$ajax
						.get("/datamaster/kabupaten/" + val.id + "/kecamatan")
						.then(({ data }) => {
							this.daftar_kecamatan = data.kecamatan;
							this.btnLoadingKab = false;
						});
				}
			},
			kecamatan_id(val) {
				if (val.id != null && val.id != "") {
					this.btnLoadingKec = true;
					this.$ajax
						.get("/datamaster/kecamatan/" + val.id + "/desa")
						.then(({ data }) => {
							this.daftar_desa = data.desa;
							this.btnLoadingKec = false;
						});
				}
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			Filter6,
		},
	};
</script>
