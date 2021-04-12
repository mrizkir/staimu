<template>
	<DataMasterLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-home-assistant
			</template>
			<template v-slot:name>
				PROGRAM STUDI
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
					Halaman untuk mengelola nama-nama program studi pada perguruan tinggi.
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid v-if="data_prodi">
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-toolbar elevation="2"> 
							<v-toolbar-title>DATA PROGRAM STUDI</v-toolbar-title>
						</v-toolbar>
						<v-card-text>
							<v-row no-gutters>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>ID / KODE:</v-card-title>  
										<v-card-text>
											{{ data_prodi.id }} / {{ data_prodi.kode_prodi }}
										</v-card-text>
									</v-card>									
								</v-col>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>JENJANG:</v-card-title>  
										<v-card-subtitle>
											{{ data_prodi.nama_jenjang }}
										</v-card-subtitle>
									</v-card>
								</v-col>
							</v-row>
							<v-row no-gutters>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>NAMA PRODI:</v-card-title>
										<v-card-text>
											{{ data_prodi.nama_prodi }} [{{ data_prodi.nama_prodi_alias }}]
										</v-card-text>
									</v-card>
								</v-col>
								<v-col xs="12" sm="6" md="6">
									<v-card flat>
										<v-card-title>KETUA PROGRAM STUDI:</v-card-title>  
										<v-card-subtitle>
											{{ kaprodi(data_prodi) }}
										</v-card-subtitle>
									</v-card>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-autocomplete
						label="KETUA PROGRAM STUDI"
						v-model="dosen_id"
						:items="daftar_dosen"
						item-text="nama_dosen"
						item-value="id"
						return-object
						:disabled="btnLoading"
						outlined
					/>
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
		name: "ProgramStudiDetail",		
		created() {
			this.prodi_id = this.user_id=this.$route.params.prodi_id;
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.ACCESS_TOKEN,
				},
				{
					text: "DATA MASTER",
					disabled: false,
					href: "#",
				},
				{
					text: "PROGRAM STUDI",
					disabled: false,
					href: "/dmaster/programstudi",
				},
				{
					text: "DETAIL",
					disabled: true,
					href: "#",
				},
			];
			this.fetchDataProdi();
		},
		mounted() {
			this.fetchDaftarDosen();			
		},
		data: () => ({
			prodi_id: null,
			data_prodi: null,
			btnLoading: false,
			firstloading: true,

			//form data
			daftar_dosen: [],
			dosen_id: null,
		}),
		methods: {
			async fetchDataProdi() {
				await this.$ajax
					.get("/datamaster/programstudi/" + this.prodi_id, {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.data_prodi = data.prodi;
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
			async fetchDaftarDosen() {
				this.btnLoading = true;
				await this.$ajax
					.get("/system/usersdosen", {
						headers: {
							Authorization: this.TOKEN,
						},
					})
					.then(({ data }) => {
						this.daftar_dosen = data.users;
						var config = JSON.parse(this.data_prodi.config);
						this.dosen_id = config.kaprodi;
						this.btnLoading = false;						
					});
					this.firstloading = false;
			},
			kaprodi(item) {
				var message = "N.A";
				if (item.config) {
					var config = JSON.parse(item.config);
					if (config.kaprodi) {
						message = config.kaprodi.name;
					}
				}
				return message;
			},
		},
		computed: {
			...mapGetters("auth", {
				ACCESS_TOKEN: "AccessToken",
				TOKEN: "Token",
			}),
		},
		watch: {
			async dosen_id(val) {
				if (!this.firstloading) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/datamaster/programstudi/updateconfig/" + this.data_prodi.id,
							{
								_method: "PUT",
								config: JSON.stringify({
									kaprodi: val,
								}),
							},
							{
								headers: {
									Authorization: this.TOKEN,
								},
							}
						)
						.then(() => {							
							this.btnLoading = false;
							this.$router.go();
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
		},
		components: {
			DataMasterLayout,
			ModuleHeader,
		},
	};
</script>
