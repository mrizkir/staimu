<template>
				<DataMasterLayout>
					<ModuleHeader>
						<template v-slot:icon>
							mdi-format-list-checks
						</template>
						<template v-slot:name>
							PERSYARATAN UJIAN MUNAQASAH
						</template>
						<template v-slot:breadcrumbs>
							<v-breadcrumbs :items="breadcrumbs" class="pa-0">
								<template v-slot:divider>
									<v-icon>mdi-chevron-right</v-icon>
								</template>
							</v-breadcrumbs>
						</template>
						<template v-slot:desc>
							<v-alert                                        
								color="cyan"
								border="left"                    
								colored-border
								type="info"
							>
									Halaman untuk mengelola persyaratan Ujian Munaqasah setiap tahun pendaftaran.
							</v-alert>
						</template>
					</ModuleHeader>   
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
												loading-text="Loading... Please wait">

												<template v-slot:top>
														<v-toolbar flat color="white">
																<v-toolbar-title>DAFTAR PERSYARATAN</v-toolbar-title>
																<v-divider
																		class="mx-4"
																		inset
																		vertical
																></v-divider>
																<v-spacer></v-spacer>
																<v-dialog v-model="dialogfrm" max-width="500px" persistent>
																		<v-form ref="frmdata" v-model="form_valid" lazy-validation>
																				<v-card>
																						<v-card-title>
																								<span class="headline">UBAH PERSYARATAN UJIAN MUNAQASAH</span>
																						</v-card-title>
																						<v-card-text>                                                          
																								<v-text-field 
																										v-model="formdata.nama_persyaratan" 
																										label="NAMA PERSYARATAN"
																										outlined
																										:rules="rule_nama_persyaratan">
																								</v-text-field>
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
																							<v-dialog v-model="dialogdetailitem" max-width="750px" persistent>
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
																														{{formdata.id}}
																													</v-card-subtitle>
																												</v-card>
																											</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
																								<v-col xs="12" sm="6" md="6">
																										<v-card flat>
																												<v-card-title>TAHUN PENDAFTARAN :</v-card-title>
																												<v-card-subtitle>
																														{{formdata.ta}}
																												</v-card-subtitle>
																										</v-card>
																								</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
																						</v-row>
																						<v-row no-gutters>
																								<v-col xs="12" sm="6" md="6">
																										<v-card flat>
																												<v-card-title>NAMA PERSYARATAN :</v-card-title>
																												<v-card-subtitle>
																														{{formdata.nama_persyaratan}}
																												</v-card-subtitle>
																										</v-card>
																								</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
																								<v-col xs="12" sm="6" md="6">
																										<v-card flat>
																												<v-card-title>CREATED :</v-card-title>
																												<v-card-subtitle>
																														{{ $date(formdata.created_at).format("DD/MM/YYYY HH:mm") }}
																												</v-card-subtitle>
																										</v-card>
																								</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
																						</v-row>
																						<v-row no-gutters>
																								<v-col xs="12" sm="6" md="6">
																										<v-card flat>
																												<v-card-title>PROSES :</v-card-title>
																												<v-card-subtitle>
																														{{formdata.proses}}
																												</v-card-subtitle>
																										</v-card>
																								</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
																								<v-col xs="12" sm="6" md="6">
																										<v-card flat>
																												<v-card-title>UPDATED :</v-card-title>
																												<v-card-subtitle>
																														{{ $date(formdata.updated_at).format("DD/MM/YYYY HH:mm") }}
																												</v-card-subtitle>
																										</v-card>
																								</v-col>
																								<v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
																						</v-row>                                                                                                     
																				</v-card-text>
																				<v-card-actions>
																						<v-spacer></v-spacer>
																						<v-btn color="blue darken-1" text @click.stop="closedialogdetailitem">KELUAR</v-btn>
																				</v-card-actions>
																		</v-card>
																</v-dialog>											
														</v-toolbar>
												</template>
												<template v-slot:item.actions="{ item }">
														<v-icon
																small
																class="mr-2"
																@click.stop="viewItem(item)">
																mdi-eye
														</v-icon>
														<v-icon
															small
															class="mr-2"
															@click.stop="editItem(item)">
															mdi-pencil
														</v-icon>									
												</template>
												<template v-slot:expanded-item="{ headers, item }">
														<td :colspan="headers.length" class="text-center">
																<v-col cols="12">  
																		<strong>ID:</strong>{{ item.id }} 
																		<strong>created_at:</strong>{{ $date(item.created_at).format("DD/MM/YYYY HH:mm") }}
																		<strong>updated_at:</strong>{{ $date(item.updated_at).format("DD/MM/YYYY HH:mm") }}
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
		</DataMasterLayout>
</template>
<script>
	import { mapGetters } from "vuex";
	import DataMasterLayout from "@/views/layouts/DataMasterLayout";
	import ModuleHeader from "@/components/ModuleHeader";	
	export default {
		name: "PersyaratanUjianMunaqasah",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.ACCESS_TOKEN,
				},
				{
					text: "DATA MASTER",
					disabled: false,
					href: "/dmaster",
				},
				{
					text: "PERSYARATAN UJIAN MUNAQASAH",
					disabled: true,
					href: "#",
				}
			];
			this.tahun_pendaftaran = this.$store.getters["uiadmin/getTahunPendaftaran"];
			this.initialize();
		},
		data: () => ({ 
			firstloading: true,
			btnLoading: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "ID", value: "id", sortable: true, width: 200  },
				{ text: "PROSES", value: "proses", sortable: true, width: 200  },
				{ text: "NAMA PERSYARATAN", value: "nama_persyaratan", sortable: true },					
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			search: "",

			//dialog
			dialogfrm: false,		
			dialogdetailitem: false,

			//form data   
			form_valid: true, 			
			formdata: {
					id: "",
					proses: "ujian-munaqasah",
					nama_persyaratan: null,
					prodi_id: null, 
					ta: "",
			},
			formdefault: {
				id: "",
				proses: "ujian-munaqasah",
				nama_persyaratan: null,
				prodi_id: null, 
				ta: "",
			},
			editedIndex: -1,
		}),
		methods: {			
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/datamaster/persyaratan",
					{
						TA: this.tahun_pendaftaran,
						proses: "ujian-munaqasah",
					},
					{
						headers: {
							Authorization: this.TOKEN,
						}
					})
					.then(({ data }) => {
						this.datatable = data.persyaratan;
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
			tambahItem: async function() {
				this.dialogfrm = true;
			},
			viewItem(item) {
					this.formdata = item; 
					this.dialogdetailitem = true;
			},
			editItem: async function(item) {
				this.editedIndex = this.datatable.indexOf(item);
				this.formdata = item;
				this.dialogfrm = true;
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					if (this.editedIndex > -1) {
						await this.$ajax
							.post(
								"/datamaster/persyaratan/" + this.formdata.id,
								{
									_method: "PUT",
									nama_persyaratan: this.formdata.nama_persyaratan,
								},
								{
									headers: {
										Authorization: this.TOKEN,
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
			closedialogdetailitem() {
				this.dialogdetailitem = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
				},300);
			},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.$refs.frmdata.resetValidation();
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
				},300);
			},
		},
		computed: {
			...mapGetters("auth", {
				ACCESS_TOKEN: "AccessToken",
				TOKEN: "Token",
			}),
		},
		components: {
			DataMasterLayout,
			ModuleHeader,
		},
	};
</script>
