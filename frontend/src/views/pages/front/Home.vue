<template>
	<FrontLayout>
		<v-container fluid>
			<v-row>
				<v-col cols="12">
					<v-carousel cycle show-arrows-on-hover>
						<v-carousel-item
							v-for="(slide, i) in slides"
							:key="i"
							:src="$api.url + '/' + slide.src"
						>
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
			<v-row
				v-for="item in daftar_info_kampus.data"
				v-bind:key="item.id"
				class="mb-4"
			>
				<v-col cols="12">
					<card-post :data="item" />
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12">
					<v-col cols="12" class="text-center">
						<pagination
							:src="daftar_info_kampus"
							v-on:changePaginate="changePaginate"
						/>
					</v-col>
				</v-col>
			</v-row>
		</v-container>
	</FrontLayout>
</template>
<script>
	import FrontLayout from "@/views/layouts/FrontLayout";
	import CardPost from "@/components/blog/CardPost";
	import Pagination from "@/components/Pagination";
	export default {
		name: "Home",
		created() {
			this.fetchInfoKampus(1);
		},
		data: () => ({
			slides: [
				{
					src: "storage/images/sliders/slider1.jpg",
				},
				{
					src: "storage/images/sliders/slider2.jpg",
				},
			],
			daftar_info_kampus: {
				data: [],
			},
		}),
		methods: {
			changePaginate(newPageNumber) {				
				this.fetchInfoKampus(newPageNumber);
			},
			async fetchInfoKampus(pageNumber) {
				await this.$ajax
					.post("/blog/pages/infokampus/all?page=" + pageNumber)
					.then(({ data }) => {
						this.daftar_info_kampus = data.post;
						this.page = data.post.current_page;
					});
			},
		},
		components: {
			FrontLayout,
			"card-post": CardPost,
			pagination: Pagination,
		},
	};
</script>
