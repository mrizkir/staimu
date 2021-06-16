<template>
	<v-list-item>
		<v-list-item-content>
			<v-select
				v-model="prodi_id"
				:items="daftar_prodi"
				item-text="text"
				item-value="id"
				label="PROGRAM STUDI"
				outlined
			/>
      <v-select
				v-model="tahun_pendaftaran"
				:items="daftar_ta"
				label="TAHUN PENDAFTARAN"
				outlined
			/>
			<v-select
				v-model="tahun_akademik"
				label="TAHUN AKADEMIK"
				:items="daftar_ta"
				outlined
			/>
			<v-select
				v-model="semester_akademik"
				:items="daftar_semester"
				item-text="text"
				item-value="id"
				label="SEMESTER"
				outlined
			/>
		</v-list-item-content>
	</v-list-item>
</template>
<script>
	export default {
		name: "FilterMode8",
		created() {
			this.daftar_prodi = this.$store.getters["uiadmin/getDaftarProdi"];
			this.prodi_id = this.$store.getters["uiadmin/getProdiID"];

			this.daftar_ta = this.$store.getters["uiadmin/getDaftarTA"];
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.daftar_semester = this.$store.getters["uiadmin/getDaftarSemester"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
			this.tahun_pendaftaran = this.$store.getters[
				"uiadmin/getTahunPendaftaran"
			];
		},
		data: () => ({
			firstloading: true,
			daftar_prodi: [],
			prodi_id: null,

			daftar_ta: [],
			tahun_akademik: null,
      tahun_pendaftaran: null,

			daftar_semester: [],
			semester_akademik: null,
		}),
		methods: {
			setFirstTimeLoading(bool) {
				this.firstloading = bool;
			},
		},
		watch: {
      tahun_pendaftaran(val) {
				if (!this.firstloading) {
					this.$store.dispatch("uiadmin/updateTahunPendaftaran", val);
					this.$emit("changeTahunPendaftaran", val);
				}
			},
			tahun_akademik(val) {
				if (!this.firstloading) {
					this.$store.dispatch("uiadmin/updateTahunAkademik", val);
					this.$emit("changeTahunAkademik", val);
				}
			},
			prodi_id(val) {
				if (!this.firstloading) {
					this.$store.dispatch("uiadmin/updateProdi", val);
					this.$emit("changeProdi", val);
				}
			},
			semester_akademik(val) {
				if (!this.firstloading) {
					this.$store.dispatch("uiadmin/updateSemesterAkademik", val);
					this.$emit("changeSemesterAkademik", val);
				}
			},
		},
	};
</script>
