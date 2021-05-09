<template>	
	<v-card flat id="card-post">
		<div class="d-flex justify-between">
			<div>
				<v-card-title class="title">
					{{data.post_title}}
				</v-card-title>
				<v-card-text class="subtitle-1 mt-2">
					<div v-html="data.post_content"></div>
				</v-card-text>
				<v-card-actions>
					<v-icon class="mr-1" color="cyan lighten-3" small>mdi-calendar</v-icon>
					<span class="body-2 mr-2">{{ $date(data.created_at).format("DD/MM/YYYY HH:mm") }}</span>
					<span class="mr-1"></span>
					<v-icon class="mr-1" color="blue-grey lighten-2" small>mdi-account</v-icon>
					<span class="body-2 mr-2">{{data.username}}</span>
				</v-card-actions>
			</div>	
		</div>
	</v-card>
</template>
<script>
	export default {
		name: "CardPost",
		props: {
			data: {
				type: Object,
				default: Object,
				required: true,
			},
		},
	};
</script>
<style>
	#card-post {
		background-color: bisque;
		font-family: "Roboto", sans-serif;
	}
	#card-post:hover {
		background-color: burlywood;
		cursor: pointer;
	}
</style>
