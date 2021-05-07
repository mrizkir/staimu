<template>
	<v-pagination
		v-model="currentPage"
		:length="lastPage"
		:total-visible="7"
		prev-icon="mdi-menu-left"
		next-icon="mdi-menu-right"
	>
	</v-pagination>
</template>
<script>	
	export default {
		name: "Pagination",	
		props: {
			src: {
				type: Object,
				required: true,
			},
		},
		computed: {
			currentPage: {
				set(currentpage) {
					this.src.current_page = currentpage;
				},
				get() {					
					return this.src.current_page;
				}
			},
			lastPage: {
				get() {
					return this.src.last_page;
				}
			}
		},
		watch: {
			currentPage(val) {				
				this.$emit("changePaginate", val);
			}
		},
	};
</script>