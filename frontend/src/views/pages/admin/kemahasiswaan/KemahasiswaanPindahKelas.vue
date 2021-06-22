<template>
	<KemahasiswaanLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-arrow-right-bold-box-outline
			</template>
			<template v-slot:name>
				PINDAH KELAS
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} - {{ nama_prodi }}
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
					Halaman untuk memindahkan kelas dari seorang mahasiswa dilakukan di setiap awal semester sebelum daftar ulang dan memulai pengisian KRS.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter6
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeSemesterAkademik="changeSemesterAkademik"
				v-on:changeProdi="changeProdi"
				ref="filter6"
			/>
		</template>
	</KemahasiswaanLayout>
</template>
<script>
	import KemahasiswaanLayout from "@/views/layouts/KemahasiswaanLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter6 from "@/components/sidebar/FilterMode6";
	export default {
		name: "KemahasiswaanPindahKelas",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "KEMAHASISWAAN",
					disabled: false,
					href: "/kemahasiswaan",
				},
				{
					text: "PINDAH KELAS",
					disabled: true,
					href: "#",
				},
			];
			
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
			this.initialize();
		},
		mounted() {
			this.firstloading = false;
			this.$refs.filter6.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			daftar_ta: [],
			tahun_akademik: null,
			semester_akademik: null,
		}),
		methods: {
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			changeSemesterAkademik(semester) {
				this.semester_akademik = semester;
			},
			changeProdi(id) {
				this.prodi_id = id;
			},
			async initialize() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/kemahasiswaan/pindahkelas",
						{
							prodi_id: this.prodi_id,
							ta: this.tahun_akademik,
							semester_akademik: this.semester_akademik,
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable = data.daftar_khs;
						this.datatableLoading = false;						
					})
					.catch(() => {
						this.datatableLoading = false;
					});
			},
		},
		watch: {
			tahun_akademik() {
				if (!this.firstloading) {
					this.initialize();
				}
			},
			semester_akademik() {
				if (!this.firstloading) {
					this.initialize();
				}
			},
			prodi_id(val) {
				if (!this.firstloading) {
					this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](val);
					this.initialize();
				}
			},
		},
		components: {
			KemahasiswaanLayout,
			ModuleHeader,
			Filter6,
		},
	};
</script>
