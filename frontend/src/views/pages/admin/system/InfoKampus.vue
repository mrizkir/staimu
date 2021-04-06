<template>
		<SystemConfigLayout>
		<ModuleHeader>
						<template v-slot:icon>
								mdi-blogger
						</template>
						<template v-slot:name>
								BLOG INFO KAMPUS
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
										Setting untuk halaman info kampus
										</v-alert>
						</template>
				</ModuleHeader>
				<v-container fluid>
						<v-row class="mb-4" no-gutters>
								<v-col cols="12">
										<v-form ref="frmdata" v-model="form_valid" lazy-validation>
												<v-card>                            
														<v-card-text>
																<v-select
																		v-model="formdata.term_id" 
																		:items="daftar_category"                
																		label="KATEGORI"
																		item-value="id"
																		item-text="name"
																		outlined
																		:rules="rule_term_id" />
														</v-card-text>
														<v-card-actions>
																<v-spacer></v-spacer>
																<v-btn
																		color="blue darken-1"
																		text
																		@click.stop="save"
																		
																		:disabled="!form_valid||btnLoading">SIMPAN</v-btn>
														</v-card-actions>
												</v-card>
										</v-form>
								</v-col>
						</v-row>
				</v-container>
		</SystemConfigLayout>
</template>
<script>
import { mapGetters } from "vuex";
import SystemConfigLayout from '@/views/layouts/SystemConfigLayout';
import ModuleHeader from "@/components/ModuleHeader";
export default {
		name: 'InfoKampus',
		created()
		{
				this.breadcrumbs = [
						{
								text: "HOME",
								disabled: false,
								href: '/dashboard/'+this.ACCESS_TOKEN
						},
						{
								text: 'KONFIGURASI SISTEM',
								disabled: false,
								href: '/system-setting'
						},  
						{
								text: 'BLOG - HALAMAN INFO KAMPUS',
								disabled: true,
								href: "#"
						}
				];
				this.initialize();
		},
		data: () => ({
				breadcrumbs: [],        
				btnLoading: false,
				//form
				form_valid: true,
				daftar_category: [],
				formdata: {
						term_id: null            
				},        
				//form rules        
				rule_term_id: [
						value => !!value || "Mohon untuk dipilih Kategori untuk Halaman Info Kampus !!!",             
				], 
		}),
		methods: {
				initialize: async function()
				{
						await this.$ajax.get('/blog/categories',
						{
								headers: {
										Authorization: this.TOKEN,
								},
						}).then(({ data }) => {
								this.daftar_category=data.categories;
						});

						await this.$ajax.get('/system/setting/variables',
						{
								headers: {
										Authorization: this.TOKEN
								}
						}).then(({ data }) => {
								let setting = data.setting;
								this.formdata.term_id=setting.INFO_KAMPUS_TERM_ID;                
						});

				},
				save () {
						if (this.$refs.frmdata.validate())
						{
								this.btnLoading = true;
								this.$ajax.post('/system/setting/variables',
										{
												'_method': 'PUT',
												'pid': 'blog',
												setting:JSON.stringify({
														601: this.formdata.term_id,                            
												}),
										},
										{
												headers: {
														Authorization: this.TOKEN
												}
										}
								).then(() => {
										this.btnLoading = false;
								}).catch(() => {
										this.btnLoading = false;
								});
						}
				}
		},
		computed: {
				...mapGetters('auth',{
						ACCESS_TOKEN: 'AccessToken',
						TOKEN: 'Token',
				}),
		},
		components: {
		SystemConfigLayout,
				ModuleHeader,
	}
}
</script>
