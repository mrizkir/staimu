<template>
	<KemahasiswaanLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-arrow-right-bold-box-outline
			</template>
			<template v-slot:name>
				PINDAH KELAS
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} - {{ nama_prodi }}
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
					Halaman untuk memindahkan kelas dari seorang mahasiswa dilakukan di setiap awal semester sebelum daftar ulang dan memulai pengisian KRS.
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
								<v-toolbar-title>DAFTAR MAHASISWA PINDAH</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
								<v-tooltip bottom>
									<template v-slot:activator="{ on, attrs }">
										<v-btn
											color="primary"
											v-bind="attrs"
											v-on="on"
											small
											icon
											outlined
											class="ma-2"
											@click.stop="addItem"
										>
											<v-icon>mdi-plus</v-icon>
										</v-btn>
									</template>
									<span>Tambah Mahasiswa Pindah Kelas</span>
								</v-tooltip>
								<v-dialog v-model="dialogfrm" max-width="800px" persistent>
									<v-form ref="frmdata" v-model="form_valid" lazy-validation>
										<v-card>
											<v-card-title>
												<span class="headline">PINDAH KELAS</span>
											</v-card-title>
											<v-card-subtitle>
												Mahasiswa Program Studi {{ nama_prodi }}
											</v-card-subtitle>
											<v-card-text>
												<v-text-field
													v-model="formdata.nim"
													label="NOMOR INDUK MAHASISWA (NIM)"
													outlined
													append-outer-icon="mdi-send"
													@click:append-outer="cekNIM"
													:rules="rule_nim"
												>
												</v-text-field>
												<v-text-field
													v-model="formdata.nama_mhs"
													label="NAMA MAHASISWA"
													outlined
													:disabled="true"
												>
												</v-text-field>
												<v-alert
													color="red"
													dense
													dismissible
													icon="mdi-account"
													type="error"
													v-if="show_message_error"
												>
													Data Mahasiswa dengan NIM tersebut tidak ditemukan !!!
												</v-alert>
												<v-select
													v-model="formdata.idkelas_lama"
													:items="daftar_kelas"
													item-text="text"
													item-value="id"
													label="KELAS SAAT INI"
													outlined
													:disabled="true"
												/>
												<v-select
													v-model="formdata.idkelas_baru"
													:items="daftar_kelas"
													item-text="text"
													item-value="id"
													label="PINDAH KE KELAS"
													outlined
													:rules="rule_kelas_baru"
													:disabled="!is_mhs_checked"
												/>
												<v-textarea
													v-model="formdata.descr"
													label="KETERANGAN"
													outlined
													:disabled="!is_mhs_checked"
												>
												</v-textarea>
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
													:disabled="!form_valid || btnLoading || !is_mhs_checked"
												>
													SIMPAN
												</v-btn>
											</v-card-actions>
										</v-card>
									</v-form>
								</v-dialog>
								<v-dialog
									v-model="dialogdetailitem"
									max-width="750px"
									persistent
								>
									<v-card>
										<v-card-title>
											<span class="headline">DETAIL DATA</span>
										</v-card-title>
										<v-card-subtitle>
											Pindah kelas akan berlaku sejak Semester {{ $store.getters["uiadmin/getNamaSemester"](formdata.idsmt) }} T.A {{ formdata.tahun }}
										</v-card-subtitle>
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
														<v-card-title>KELAS LAMA :</v-card-title>
														<v-card-subtitle>
															{{ formdata.kelas_lama }}
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
														<v-card-title>NIM :</v-card-title>
														<v-card-subtitle>
															{{ formdata.nim }}
														</v-card-subtitle>
													</v-card>
												</v-col>
												<v-responsive
													width="100%"
													v-if="$vuetify.breakpoint.xsOnly"
												/>
												<v-col xs="12" sm="6" md="6">
													<v-card flat>
														<v-card-title>KELAS BARU :</v-card-title>
														<v-card-subtitle>
															{{ formdata.kelas_baru }}
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
														<v-card-title>NAMA MAHASISWA :</v-card-title>
														<v-card-subtitle>
															{{ formdata.nama_mhs }}
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
															}}
															/
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
						<template v-slot:item.id="{ item }">
							{{ item.id }}
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
								<span>Detail Tooltip</span>
							</v-tooltip>
							<v-tooltip bottom>
								<template v-slot:activator="{ on, attrs }">
									<v-icon
										v-bind="attrs"
										v-on="on"
										small
										class="mr-2"
										@click.stop="editItem(item)"
									>
										mdi-pencil
									</v-icon>
								</template>
								<span>Ubah Tooltip</span>
							</v-tooltip>
							<v-tooltip bottom>
								<template v-slot:activator="{ on, attrs }">
									<v-icon
										v-bind="attrs"
										v-on="on"
										small
										color="red darken-1"
										:disabled="btnLoading"
										@click.stop="deleteItem(item)"
									>
										mdi-delete
									</v-icon>
								</template>
								<span>Hapus Tooltip</span>
							</v-tooltip>
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
	</KemahasiswaanLayout>
</template>
<script>
	import KemahasiswaanLayout from "@/views/layouts/KemahasiswaanLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter6 from "@/components/sidebar/FilterMode6";
	export default {
		name: "KemahasiswaanPindahKelas",
		created() {
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
					text: "PINDAH KELAS",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];

			this.initialize();
		},
		mounted() {
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

			btnLoading: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "NIM", value: "nim", sortable: true, width: 100 },
				{ text: "NAMA", value: "nama_mhs", sortable: true, width: 250 },
				{ text: "KELAS LAMA", value: "kelas_lama", sortable: false, width: 100 },
				{ text: "KELAS BARU", value: "kelas_baru", sortable: false, width: 100 },
				{ text: "KET.", value: "descr", sortable: false, width: 100 },
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			search: "",

			//dialog
			dialogfrm: false,
			dialogdetailitem: false,

			//form data
			form_valid: true,
			show_message_error: false,
			is_mhs_checked: false,
			daftar_kelas: [],
			formdata: {
				id: "",
				user_id: "",
				nim: "",
				idkelas_lama: "",
				kelas_lama: "",
				idkelas_baru: "",
				kelas_baru: "",
				idsmt: "",
				tahun: "",
				descr: "",
				created_at: "",
				updated_at: "",
			},
			formdefault: {
				id: "",
				user_id: "",
				nim: "",
				idkelas_lama: "",
				kelas_lama: "",
				idkelas_baru: "",
				kelas_baru: "",
				idsmt: "",
				tahun: "",
				descr: "",
				created_at: "",
				updated_at: "",
			},
			editedIndex: -1,

			//form rules
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value => /^[0-9]+$/.test(value) || "Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
			rule_kelas_baru: [
				value => !!value || "Pilih kelas baru mahasiswa mohon untuk dipilih !!!",
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
						"/kemahasiswaan/pindahkelas",
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
						this.datatable = data.pindahkelas;
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
			addItem() {
				this.dialogfrm = true;
				this.daftar_kelas = this.$store.getters["uiadmin/getDaftarKelas"];
			},
			viewItem(item) {
				this.formdata = item;
				this.dialogdetailitem = true;
			},
			editItem(item) {
				this.editedIndex = this.datatable.indexOf(item);
				this.daftar_kelas = this.$store.getters["uiadmin/getDaftarKelas"];
				this.formdata = Object.assign({}, item);
				
				this.show_message_error = false;
				this.is_mhs_checked = true;
				this.dialogfrm = true;
			},
			async cekNIM() {
				if (this.formdata.nim.length > 0) {
					let nim = this.formdata.nim;
					await this.$ajax
						.post(
							"/kemahasiswaan/profil/bynim",
							{
								nim: nim,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							if (data.profil == null) {
								this.show_message_error = true;
								this.is_mhs_checked = false;
								this.formdata = Object.assign({}, this.formdefault);
								this.formdata.nim = nim;
							} else {
								this.show_message_error = false;
								this.is_mhs_checked = true;
								this.formdata.user_id = data.profil.user_id;
								this.formdata.nama_mhs = data.profil.nama_mhs;
								this.formdata.idkelas_lama = data.profil.idkelas;
								this.formdata.kelas_lama = data.profil.nkelas;
								this.formdata.kelas_lama = data.profil.nkelas;
							}
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					if (this.editedIndex > -1) {
						await this.$ajax
							.post(
								"/kemahasiswaan/pindahkelas/" + this.formdata.id,
								{
									_method: "PUT",
									idkelas_baru: this.formdata.idkelas_baru,
									descr: this.formdata.descr,
								},
								{
									headers: {
										Authorization: this.$store.getters["auth/Token"],
									},
								}
							)
							.then(({ data }) => {
								Object.assign(this.datatable[this.editedIndex], data.pindahkelas);
								this.closedialogfrm();
								this.btnLoading = false;
							})
							.catch(() => {
								this.btnLoading = false;
							});
					} else {
						await this.$ajax
							.post(
								"/kemahasiswaan/pindahkelas/store",
								{
									user_id: this.formdata.user_id,
									nim: this.formdata.nim,
									idkelas_lama: this.formdata.idkelas_lama,
									idkelas_baru: this.formdata.idkelas_baru,
									idsmt: this.semester_akademik,
									tahun: this.tahun_akademik,
									descr: this.formdata.descr,
								},
								{
									headers: {
										Authorization: this.$store.getters["auth/Token"],
									},
								}
							)
							.then(({ data }) => {
								this.datatable.push(data.pindahkelas);
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
						"Hapus Pindah Kelas",
						"Apakah Anda ingin menghapus data dengan ID " + item.id + " ?",
						{
							color: "red",
							width: "600px",
							desc: "Kelas akan dikembalikan ke awal saat sebelum pindah",
						}
					)
					.then(confirm => {
						if (confirm) {
							this.btnLoading = true;
							this.$ajax
								.post(
									"/kemahasiswaan/pindahkelas/" + item.id,
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
		},
		components: {
			KemahasiswaanLayout,
			ModuleHeader,
			Filter6,
		},
	};
</script>
