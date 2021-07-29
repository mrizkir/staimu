<template>
	<AkademikLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-av-timer
			</template>
			<template v-slot:name>
				WAKTU PENGISIAN NILAI DOSEN
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }}
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
					Halaman untuk mengatur waktu pengisian nilai oleh Dosen
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter2
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeSemesterAkademik="changeSemesterAkademik"
				ref="filter2"
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
						show-expand
						:expanded.sync="expanded"
						:single-expand="true"
						:disable-pagination="true"
						:hide-default-footer="true"
						@click:row="dataTableRowClicked"
						class="elevation-1"
						:loading="datatableLoading"
						loading-text="Loading... Please wait"
					>
						<template v-slot:top>
							<v-toolbar flat color="white">
								<v-toolbar-title>DAFTAR KELAS</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
								<v-dialog v-model="dialogfrm" max-width="700px" persistent>
									<v-form ref="frmdata" v-model="form_valid" lazy-validation>
										<v-card>
											<v-card-title>
												<span class="headline">ISI WAKTU PENGISIAN</span>
											</v-card-title>
											<v-card-text>
												<v-row no-gutters>
													<v-col xs="12" sm="6" md="6">
														<v-card flat>
															<v-card-title>KODE / SKS :</v-card-title>
															<v-card-subtitle>
																{{ formdata.kmatkul }} / {{ formdata.sks }}
															</v-card-subtitle>
														</v-card>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
													<v-col xs="12" sm="6" md="6">
														<v-card flat>
															<v-card-title>JUMLAH MHS :</v-card-title>
															<v-card-subtitle>
																{{ formdata.jumlah_mhs }}
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
															<v-card-title>NAMA MATAKULIAH:</v-card-title>
															<v-card-subtitle>
																{{ formdata.nmatkul }}
															</v-card-subtitle>
														</v-card>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
													<v-col xs="12" sm="6" md="6">
														<v-card flat>
															<v-card-title>DOSEN :</v-card-title>
															<v-card-subtitle>
																{{ formdata.nama_dosen }} [{{ formdata.nidn }}]
															</v-card-subtitle>
														</v-card>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
												</v-row>
												<v-row>
													<v-col xs="12" sm="6" md="6">
														<v-menu
															ref="menuTanggalMulai"
															v-model="menuTanggalMulai"
															:close-on-content-click="false"
															:return-value.sync="formdata.waktu_mulai_isi_nilai"
															transition="scale-transition"
															offset-y
															max-width="290px"
															min-width="290px"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																	v-model="formdata.waktu_mulai_isi_nilai"
																	label="TANGGAL MULAI ISI NILAI"
																	readonly
																	outlined
																	v-on="on"
																	hide-details
																	:rules="rule_waktu"
																>
																</v-text-field>
															</template>
															<v-date-picker
																v-model="formdata.waktu_mulai_isi_nilai"
																no-title                                
																scrollable>
																<v-spacer></v-spacer>
																<v-btn text color="primary" @click="menuTanggalMulai = false">Cancel</v-btn>
																<v-btn text color="primary" @click="$refs.menuTanggalMulai.save(formdata.waktu_mulai_isi_nilai)">OK</v-btn>
															</v-date-picker>
														</v-menu>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
													<v-col xs="12" sm="6" md="6">
														<v-menu
															ref="menuTanggalSelesai"
															v-model="menuTanggalSelesai"
															:close-on-content-click="false"
															:return-value.sync="formdata.waktu_selesai_isi_nilai"
															transition="scale-transition"
															offset-y
															max-width="290px"
															min-width="290px"
														>
															<template v-slot:activator="{ on }">
																<v-text-field
																	v-model="formdata.waktu_selesai_isi_nilai"
																	label="TANGGAL SELESAI ISI NILAI"
																	readonly
																	outlined
																	v-on="on"
																	hide-details
																	:rules="rule_waktu"
																>
																</v-text-field>
															</template>
															<v-date-picker
																v-model="formdata.waktu_selesai_isi_nilai"
																no-title                                
																scrollable>
																<v-spacer></v-spacer>
																<v-btn text color="primary" @click="menuTanggalSelesai = false">Cancel</v-btn>
																<v-btn text color="primary" @click="$refs.menuTanggalSelesai.save(formdata.waktu_selesai_isi_nilai)">OK</v-btn>
															</v-date-picker>
														</v-menu>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
												</v-row>
												<v-row>
													<v-col xs="12" sm="6" md="6">
														<v-menu
															ref="menuJamMulaiIsi"
															v-model="menuJamMulaiIsi"
															:close-on-content-click="false"
															:nudge-right="40"
															:return-value.sync="formdata.jam_mulai_isi"
															transition="scale-transition"
															offset-y
															max-width="290px"
															min-width="290px"
														>
															<template v-slot:activator="{ on, attrs }">
																<v-text-field
																	v-model="formdata.jam_mulai_isi"
																	label="JAM MULAI"            
																	readonly
																	outlined
																	v-bind="attrs"
																	v-on="on"
																	hide-details
																	:rules="rule_waktu"
																>
																</v-text-field>
															</template>
															<v-time-picker
																v-if="menuJamMulaiIsi"
																v-model="formdata.jam_mulai_isi"
																full-width
																format="24hr"
																@click:minute="$refs.menuJamMulaiIsi.save(formdata.jam_mulai_isi)"
															>
															</v-time-picker>
														</v-menu>
													</v-col>
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
													<v-col xs="12" sm="6" md="6">
														<v-menu
															ref="menuJamSelesaiIsi"
															v-model="menuJamSelesaiIsi"
															:close-on-content-click="false"
															:nudge-right="40"
															:return-value.sync="formdata.jam_selesai_isi"
															transition="scale-transition"
															offset-y
															max-width="290px"
															min-width="290px"
														>
															<template v-slot:activator="{ on, attrs }">
																<v-text-field
																	v-model="formdata.jam_selesai_isi"
																	label="JAM SELESAI"            
																	readonly
																	outlined
																	v-bind="attrs"
																	v-on="on"
																	hide-details
																	:rules="rule_waktu"
																>
																</v-text-field>
															</template>
															<v-time-picker
																v-if="menuJamSelesaiIsi"
																v-model="formdata.jam_selesai_isi"
																full-width
																format="24hr"
																@click:minute="$refs.menuJamSelesaiIsi.save(formdata.jam_selesai_isi)"
															></v-time-picker>
														</v-menu>
													</v-col>												
													<v-responsive
														width="100%"
														v-if="$vuetify.breakpoint.xsOnly"
													/>
												</v-row>
												<v-switch
													v-model="alldosen"
													label="SELURUH DOSEN"
                        >
												</v-switch>
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
							</v-toolbar>
						</template>
						<template v-slot:item.nmatkul="{ item }">
							{{ item.nmatkul }} -
							{{ $store.getters["uiadmin/getNamaKelas"](item.idkelas) }}
						</template>
						<template v-slot:item.waktu_mulai_isi_nilai="{ item }">
							<span v-if="item.waktu_mulai_isi_nilai">
								{{ $date(item.waktu_mulai_isi_nilai).format("DD/MM/YYYY HH:mm") }}
							</span>
							<span v-else>
								N.A
							</span>
						</template>
						<template v-slot:item.waktu_selesai_isi_nilai="{ item }">
							<span v-if="item.waktu_selesai_isi_nilai">
								{{ $date(item.waktu_selesai_isi_nilai).format("DD/MM/YYYY HH:mm") }}
							</span>
							<span v-else>
								N.A
							</span>							
						</template>						
						<template v-slot:item.actions="{ item }">
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
								<span>Ubah Waktu Pengisian</span>
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
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter2 from "@/components/sidebar/FilterMode2";

	import { mapGetters } from "vuex";

	export default {
		name: "NilaiWaktuPengisian",
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
					text: "NILAI",
					disabled: false,
					href: "#",
				},
				{
					text: "WAKTU PENGISIAN",
					disabled: true,
					href: "#",
				},
			];
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
		},
		mounted() {
			this.initialize();
			this.firstloading = false;
			this.$refs.filter2.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			firstloading: true,
			daftar_ta: [],
			tahun_akademik: null,
			semester_akademik: null,

			btnLoadingTable: false,
			btnLoading: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "KODE", value: "kmatkul", sortable: true, width: 100 },
				{
					text: "NAMA MATAKULIAH/KELAS",
					value: "nmatkul",
					sortable: true,
					width: 250,
				},
				{ text: "NAMA DOSEN", value: "nama_dosen", sortable: true, width: 250 },
				{
					text: "JUMLAH PESERTA",
					value: "jumlah_mhs",
					sortable: true,
					width: 100,
				},
				{
					text: "MULAI INPUT",
					value: "waktu_mulai_isi_nilai",
					sortable: true,
					width: 100,
				},
				{
					text: "SELESAI INPUT",
					value: "waktu_selesai_isi_nilai",
					sortable: true,
					width: 100,
				},
				{ text: "AKSI", value: "actions", sortable: false, width: 120 },
			],
			search: "",

			//form
			dialogfrm: false,
			form_valid: true,
			menuTanggalMulai: false,
			menuTanggalSelesai: false,
			menuJamMulaiIsi: false,
			menuJamSelesaiIsi: false,
			alldosen: false,
			formdata: {
				id: null,
				waktu_mulai_isi_nilai: null,
				waktu_selesai_isi_nilai: null,
				jam_mulai_isi: null,
				jam_selesai_isi: null,
			},
			formdefault: {
				id: null,
				waktu_mulai_isi_nilai: null,
				waktu_selesai_isi_nilai: null,
				jam_mulai_isi: null,
				jam_selesai_isi: null,
			},
			editedIndex: -1,

			//form rules      
			rule_waktu: [
				value => !!value || "Mohon untuk di isi !!!",
			],
		}),
		methods: {
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
						"/akademik/nilai/waktupengisian",
						{
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
						this.datatable = data.pembagiankelas;
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
			editItem(item) {
				this.editedIndex = this.datatable.indexOf(item);
				this.formdata = Object.assign({}, item);
				if (this.formdata.waktu_mulai_isi_nilai != null && this.formdata.waktu_selesai_isi_nilai != null) {
					this.formdata.waktu_mulai_isi_nilai = this.$date(item.waktu_mulai_isi_nilai).format("YYYY-MM-DD");
					this.formdata.waktu_selesai_isi_nilai = this.$date(item.waktu_selesai_isi_nilai).format("YYYY-MM-DD");
					this.formdata.jam_mulai_isi = this.$date(item.waktu_mulai_isi_nilai).format("HH:mm");
					this.formdata.jam_selesai_isi = this.$date(item.waktu_selesai_isi_nilai).format("HH:mm");
				}				
				this.alldosen = false;
				this.dialogfrm = true;
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					if (this.editedIndex > -1) {
						await this.$ajax.post("/akademik/nilai/waktupengisian/" + this.formdata.id,
							{
								_method: "PUT",
								waktu_mulai_isi_nilai: this.formdata.waktu_mulai_isi_nilai,
								waktu_selesai_isi_nilai: this.formdata.waktu_selesai_isi_nilai,
								jam_mulai_isi: this.formdata.jam_mulai_isi,
								jam_selesai_isi: this.formdata.jam_selesai_isi,								
								alldosen: this.alldosen,  
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(() => {
							this.initialize();
							this.btnLoading = false;
							this.closedialogfrm();
						})
						.catch(() => {
							this.btnLoading = false;
						});
					}					
				}
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.alldosen = false;
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
		},
		computed: {
			...mapGetters("auth", {
				CAN_ACCESS: "can",
			}),
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			Filter2,
		},
	};
</script>
