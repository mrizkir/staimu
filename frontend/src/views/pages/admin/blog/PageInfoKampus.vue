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
				<v-alert color="cyan" border="left" colored-border type="info">
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
							>
							</v-text-field>
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
						sort-by="post_title"
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
									>
									</v-divider>
									<v-spacer></v-spacer>
									<v-btn color="primary" icon outlined small class="ma-2" @click.stop="$router.push('/blog/pages/infokampus/tambah')">
										<v-icon>mdi-plus</v-icon>
									</v-btn>
								</v-toolbar>
							</template>
							<template v-slot:item.created_at="{ item }">
								{{ $date(item.created_at).format('DD/MM/YYYY') }}
							</template>
							<template v-slot:item.actions="{ item }">						
								<v-icon
										small
										class="mr-2"
										@click.stop="editItem(item)">
										mdi-pencil
								</v-icon>
								<v-icon
									small
									
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

	export default {
		name: "PageInfoKampus",
		created() {
			this.fetchConfig();
			this.breadcrumbs = [
				{
					text:"HOME",
					disabled: false,
					href:"/dashboard/" + this.ACCESS_TOKEN,
				},
				{
					text: "BLOG",
					disabled: false,
					href: "/blog",
				},
				{
						text:"INFO KAMPUS",
						disabled: true,
						href:"#",
				},
			];
			this.fetchPost();
		},
		data: () => ({
				firstloading: true,				
				btnLoading: false,
				datatableLoading: false,
				expanded: [],
				datatable: [],
				headers: [
						{ text: "JUDUL", value: "post_title", width:300 },
						{ text: "PENULIS", value: "username", width:150 },
						{ text: "TANGGAL", value: "created_at", width:150 },
						{ text: "AKSI", value: "actions", sortable: false, width: 100 },
				],
				search: "",

				//page config
				daftar_category: [],
				INFO_KAMPUS_TERM_ID: null,
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
					.then(({ data }) => {
						this.INFO_KAMPUS_TERM_ID = data.config.INFO_KAMPUS_TERM_ID;		
					});
					this.firstloading = false;
			},
			async fetchPost() {
				await this.$ajax
					.get("/blog/pages/infokampus",
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.post;
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
				this.$router.push("/blog/pages/infokampus/" + item.id + "/edit");
			},
			deleteItem(item) {
				this.$root.$confirm
					.open(
						"Delete",
						"Apakah Anda ingin menghapus informasi dengan ID " + item.id + " ?",
						{ color: "red" }
					)
					.then(confirm => {
						if (confirm) {
							this.btnLoading = true;
							this.$ajax
								.post(
									"/blog/pages/infokampus/" + item.id,
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
		},
		components: {
			BlogLayout,
			ModuleHeader,
		},
	};
</script>
