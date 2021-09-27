<template>
  <div>
    <v-system-bar app dark class="brown darken-2 white--text">
			<strong>No. Peserta :</strong> {{ this.peserta.no_peserta }}
			<v-divider class="mx-4" inset vertical />
			<strong>Mulai Ujian :</strong>
			{{ $date(this.peserta.mulai_ujian).format("DD/MM/YYYY HH:mm") }}
			<v-divider class="mx-4" inset vertical></v-divider>
		</v-system-bar>
    <v-main>

    </v-main>
  </div>
</template>
<script>
  export default {
    created() {
			var page = this.$store.getters["uiadmin/Page"]("ujianonline");
			this.jadwal_ujian = page.data_ujian;
			this.peserta = page.data_peserta;
			this.initialize();
		},
    methods: {
			initialize: async function() {
        await this.$ajax
					.get("/spmb/ujianonline/jawaban/" + this.peserta.user_id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
            console.log(data);
					})
					.catch(() => {
						console.log("test");
					});
      }
    },
  };
</script>