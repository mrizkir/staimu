<template>
	<KepegawaianLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-monitor-dashboard
			</template>
			<template v-slot:name>
				KEPEGAWAIAN
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
					dashboard untuk memperoleh ringkasan informasi kepegawaian perguruan
					tinggi.
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row dense>
				<v-col xs="12" sm="4" md="3">
					<v-card
						class="clickable green darken-1"
						color="#385F73"
						@click.native="$router.push('/kepegawaian/dosen')"
						dark
					>
						<v-card-title class="headline">
							TOTAL DOSEN
						</v-card-title>
						<v-card-subtitle>
							Total dosen keseluruhan
						</v-card-subtitle>
						<v-card-text>
							{{ total_dosen }}
						</v-card-text>
					</v-card>
				</v-col>
				<v-col xs="12" sm="4" md="3" v-for="item in daftar_stat_dosen" v-bind:key="item.id_jabatan">
					<v-card
						class="clickable green darken-1"
						color="#385F73"
						@click.native="$router.push('/kepegawaian/dosen')"
						dark
					>
						<v-card-title class="headline">
							JUMLAH DOSEN
						</v-card-title>
						<v-card-subtitle>
							{{ item.nama_jabatan }}
						</v-card-subtitle>
						<v-card-text>
							{{ item.jumlah_dosen }}
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
		</v-container>
	</KepegawaianLayout>
</template>
<script>
	import KepegawaianLayout from "@/views/layouts/KepegawaianLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	export default {
		name: "Kepegawaian",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "KEPEGAWAIAN",
					disabled: true,
					href: "#",
				},
			];
		},
		mounted() {
			this.initialize();
		},
		data: () => ({
			breadcrumbs: [],
			//statistik
			total_dosen: 0,
			daftar_stat_dosen: [],
		}),
		methods: {
			async initialize() {
				await this.$ajax
					.get("/kepegawaian", {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.total_dosen = data.total_dosen;
						this.daftar_stat_dosen = data.statistik_dosen;
					});
			},
		},
		components: {
			KepegawaianLayout,
			ModuleHeader,
		},
	};
</script>
