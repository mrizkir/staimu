<template>
	<BlogLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-google-classroom
			</template>
			<template v-slot:name>
				INFO KAMPUS
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
					Halaman untuk mengelola informasi seputar kampus
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
				<v-list-item>		
					<v-list-item-icon class="mr-2">
						<v-icon>mdi-menu-open</v-icon>
					</v-list-item-icon>			
					<v-list-item-content>									
						<v-list-item-title class="title">
							OPTIONS
						</v-list-item-title>
					</v-list-item-content>
				</v-list-item>
				<v-divider></v-divider>
				<v-list-item class="teal lighten-5 mb-5">
						<v-list-item-icon class="mr-2">
							<v-icon>mdi-filter</v-icon>
						</v-list-item-icon>
						<v-list-item-content>								
							<v-list-item-title>Kategori</v-list-item-title>
						</v-list-item-content>		
				</v-list-item>            
			<v-list-item>
				<v-list-item-content>                     
					<v-select
							v-model="INFO_KAMPUS_TERM_ID" 
							:items="daftar_category"                
							label="KATEGORI"							
							item-value="id"
							item-text="name"
							outlined />
				</v-list-item-content>
			</v-list-item>
		</template>
			<v-container fluid v-if="INFO_KAMPUS_TERM_ID">
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
											sort-by="nama_prodi"
											show-expand
											:expanded.sync="expanded"
											:single-expand="true"
											@click:row="dataTableRowClicked"
											class="elevation-1"
											:loading="datatableLoading"
											loading-text="Loading... Please wait">

											<template v-slot:top>
													<v-toolbar flat color="white">
															<v-toolbar-title>DAFTAR INFORMASI</v-toolbar-title>
															<v-divider
																	class="mx-4"
																	inset
																	vertical
															></v-divider>
															<v-spacer></v-spacer>                                
															<v-btn color="primary" icon outlined small class="ma-2" @click.stop="tambahItem">
																	<v-icon>mdi-plus</v-icon>
															</v-btn>                                        
															<v-dialog v-model="dialogfrm" max-width="700px" persistent>                                    
																	<v-form ref="frmdata" v-model="form_valid" lazy-validation>
																			<v-card>
																					<v-card-title>
																							<span class="headline">{{ formTitle }}</span>
																					</v-card-title>
																					<v-card-text>
																							<v-text-field                                                     
																									v-model="formdata.judul" 
																									label="JUDUL INFORMASI"
																									outlined
																									:rules="rule_judul"
																							/>
																							<tiptap-vuetify
																									v-model="formdata.content"
																									:extensions="extensions"                                                    
																									:rules="rule_content"
																							/>
																					</v-card-text>
																					<v-card-actions>
																							<v-spacer></v-spacer>
																							<v-btn color="blue darken-1" text @click.stop="closedialogfrm">BATAL</v-btn>
																							<v-btn 
																									color="blue darken-1" 
																									text 
																									@click.stop="save" 
																									:loading="btnLoading"
																									:disabled="!form_valid||btnLoading">
																											SIMPAN
																							</v-btn>
																					</v-card-actions>
																			</v-card>
																	</v-form>
															</v-dialog>
															<v-dialog v-if="dialogdetailitem" v-model="dialogdetailitem" max-width="700px" persistent>
																	<v-card>
																			<v-card-title>
																					<span class="headline">DETAIL INFORMASI</span>
																			</v-card-title>
																			<v-card-text>
																					{{formdata.content}}
																			</v-card-text>
																			<v-card-actions>
																					<v-spacer></v-spacer>
																					<v-btn color="blue darken-1" text @click.stop="closedialogdetailitem">KELUAR</v-btn>
																			</v-card-actions>
																	</v-card>                                    
															</v-dialog>
													</v-toolbar>
											</template>
											<template v-slot:item.config="{ item }">
													{{kaprodi(item)}}
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
													<v-icon
															small
															:loading="btnLoading"
															:disabled="btnLoading"
															@click.stop="deleteItem(item)">
															mdi-delete
													</v-icon>
											</template>
											<template v-slot:expanded-item="{ headers, item }">
													<td :colspan="headers.length" class="text-center">
															<v-col cols="12">
																	<strong>ID:</strong>{{ item.id }}                                                                                                       
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
			<v-container fluid v-else>
					<v-alert type="info">
							KATEGORI untuk Info Kampus belum disetting.
					</v-alert>
			</v-container>
	</BlogLayout>
</template>
<script>
	import BlogLayout from "@/views/layouts/BlogLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import {
			// component
			TiptapVuetify,
			// extensions
			Heading,
			Bold,
			Italic,
			Strike,
			Underline,
			Code,
			CodeBlock,
			Paragraph,
			BulletList,
			OrderedList,
			ListItem,
			Link,
			Blockquote,
			HardBreak,
			HorizontalRule,
			History
	} from "tiptap-vuetify";

	export default {
		name: "PageInfoKampus",
		created() {
			this.breadcrumbs = [
				{
					text:"HOME",
					disabled:false,
					href:"/dashboard/"+this.ACCESS_TOKEN,
				},
				{
					text: "BLOG",
					disabled:false,
					href: "/blog",
				},
				{
						text:"INFO KAMPUS",
						disabled:true,
						href:"#"
				},
			];
			this.fetchConfig();
			this.fetchCategories();			
			this.fetchPost();
			this.firstloading = false;
		},
		data: () => ({      
				firstloading:true,  
				//tiptap extension
				extensions: [
						History,
						Blockquote,
						Link,
						Underline,
						Strike,
						Italic,
						ListItem,
						BulletList,
						OrderedList,
						[Heading, {
								options: {
								levels: [1, 2, 3]
								}
						}],
						Bold,
						Code,
						CodeBlock,
						HorizontalRule,
						Paragraph,
						HardBreak
				],

				btnLoading:false,
				datatableLoading:false,
				expanded:[],
				datatable: [],
				headers: [
						{ text: "JUDUL", value: "judul",width:150 },            
						{ text: "AKSI", value: "actions", sortable: false,width:100 },
				],
				search: "",

				//dialog
				dialogfrm:false,
				dialogdetailitem:false,

				//page config
				daftar_category:[],
				INFO_KAMPUS_TERM_ID:null,

				//form data
				form_valid:true,
				formdata: {
					judul: "",
					content:``,
				},
				formdefault: {
						judul: "",
						content:``,
				},
				editedIndex: -1,

				//form rules 
				rule_judul: [
						value => !!value || "Mohon judul informasi untuk di isi !!!",              
				], 
				rule_content: [
						value => !!value || "Mohon konten informasi untuk di isi !!!",              
				], 
		}),
		methods: {
			async fetchConfig() {
				await this.$ajax
					.get("/blog/pages/infokampus/config",
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({data})=>{
						this.INFO_KAMPUS_TERM_ID = data.config.INFO_KAMPUS_TERM_ID;						
					});
			},
			async fetchCategories() {
				await this.$ajax
					.get("/blog/categories",
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({data})=>{
						this.daftar_category=data.categories;
					});
			},
			async fetchPost() {},
			tambahItem: async function() {
				this.dialogfrm = true;
			},
			dataTableRowClicked(item) {
				if (item === this.expanded[0]) {
					this.expanded = [];
				} else {
					this.expanded = [item];
				}
			},
			save: async function() {},
			closedialogfrm() {
				this.dialogfrm = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.$refs.frmdata.reset();
					this.editedIndex = -1;
				}, 300);
			},
			closedialogdetailitem() {
				this.dialogdetailitem = false;
				setTimeout(() => {
					this.formdata = Object.assign({}, this.formdefault);
					this.editedIndex = -1;
					this.firstloading = true;
				}, 300);
			},
		},
		computed: {
			formTitle() {
				return this.editedIndex === -1 ? "TAMBAH INFO" : "UBAH INFO";
			},
		},
		watch: {
			async INFO_KAMPUS_TERM_ID(val) {
				if (!this.firstloading) {
					this.$ajax
						.post(
							"/system/setting/variables",
							{
								_method: "PUT",
								pid: "blog",
								setting: JSON.stringify({
									601: val,
								}),
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(() => {
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
		},
		components: {
			BlogLayout,
			TiptapVuetify,
			ModuleHeader,
		},
	};
</script>
