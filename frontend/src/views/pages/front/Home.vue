<template>
		<FrontLayout>
				<v-container fluid>
						<v-row>
								<v-col cols="12">
										<v-carousel
												cycle                                                
												show-arrows-on-hover>
												<v-carousel-item
														v-for="(slide, i) in slides"
														:key="i"
														:src="$api.url+'/'+slide.src">                            
												</v-carousel-item>
										</v-carousel>
								</v-col>
						</v-row>
				</v-container>
				<v-container>
						<v-row>
								<v-col cols="12">
										<h3>INFO KAMPUS</h3>
										<v-divider />
								</v-col>								
						</v-row>
						<v-row v-for="item in daftar_info_kampus" v-bind:key="item.id">
							<v-col cols="12">
								<card-post :data="item" />
							</v-col>
						</v-row>
				</v-container>
		</FrontLayout>
</template>
<script>
	import FrontLayout from "@/views/layouts/FrontLayout";
	import CardPost from "@/components/blog/CardPost";
	export default {
		name: "Home",
		created() {
			this.fetchInfoKampus();
		},	
		data: () => ({
			slides: [
				{
					src:'storage/images/sliders/slider1.jpg',
				},
				{
					src:'storage/images/sliders/slider2.jpg',
				}
			],
			daftar_info_kampus: [],
		}),
		methods: {
			async fetchInfoKampus() {
				await this.$ajax
					.post("/blog/pages/infokampus/all")
					.then(({ data }) => {
						this.daftar_info_kampus = data.post;
					});
			}
		},
		components: {
			FrontLayout,
			'card-post': CardPost,
		},
	};
</script>
