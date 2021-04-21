
<template>
	<v-form v-model="form_valid" ref="frmpersyaratan" lazy-validation>
		<v-file-input
			accept="application/pdf,image/jpeg,image/png"
			label="(.pdf, .png,  atau .jpg)"
			:rules="rule_foto"
			show-size
			v-model="filepersyaratan[index]"
		>
		</v-file-input>
		<v-btn
			color="orange"
			text
			@click="upload(index,item)"																			
			:disabled="btnLoading"			
		>
			UPLOAD
		</v-btn>
	</v-form>
</template>
<script>
	export default {
		props: {
			persyaratan_ujian_munaqasah_id: {
				type: String,
				required: true,
			},
			index: {
				type: Number,
				required: true,
			},
			item: {
				type: Object,
				required: true,
			},
    },
		data: () => ({
			//form
			btnLoading: false,
			form_valid: true,
			filepersyaratan: [],
			//form rules  
			rule_foto: [
				value => !!value || "Mohon pilih foto !!!",  
				value =>  !value || value.size < 2000000 || 'File foto harus kurang dari 2MB.'                
			],
		}),
		methods: {
			async upload (index,item) {
				if (this.$refs.frmpersyaratan.validate()) {
					if (typeof this.filepersyaratan[index] !== 'undefined') {
						this.btnLoading = true;
						var formdata = new FormData();						
						formdata.append("filepersyaratan", this.filepersyaratan[index]);
						await this.$ajax
							.post(
								"/akademik/perkuliahan/ujianmunaqasah/upload/" + item.id, formdata,                    
								{
									headers: {
										Authorization: this.$store.getters["auth/Token"],
										"Content-Type": "multipart/form-data",
									}
								}
							)
							.then(() => {                                                   
								this.$router.go();
							})
							.catch(() => {
								this.btnLoading = false;
						});
					}
				}
			},
		}
	};
</script>
