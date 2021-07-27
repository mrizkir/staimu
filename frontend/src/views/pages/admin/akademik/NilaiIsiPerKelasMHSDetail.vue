<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-monitor-dashboard
			</template>
			<template v-slot:name>
				ISI NILAI PER KELAS
			</template>
			<template v-slot:subtitle>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }}
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
					Halaman untuk melakukan pengisian nilai berdasarkan kelas mahasiswa
					yang telah dibentuk pada pembagian kelas.
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid v-if="data_kelas_mhs">
			<v-row>
				<v-col cols="12">
					<DataKelasMHS :datakelas="data_kelas_mhs" />
				</v-col>
			</v-row>
			<v-row>
				<v-col cols="12">
					<v-alert type="info">
						Catatan: Pilihlah mahasiswa yang di isi nilainya. Untuk meningkatkan
						performance bila jumlah peserta lebih dari 10; maka disarankan
						mengisi nilai per 10 mahasiswa.
					</v-alert>
				</v-col>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-data-table
							v-model="daftar_nilai"
							:headers="headers_peserta"
							:items="datatable_peserta"
							item-key="id"
							show-select
							:disable-pagination="true"
							:hide-default-footer="true"
							class="elevation-1"
							:loading="datatableLoading"
							loading-text="Loading... Please wait"
							dense
						>
							<template v-slot:top>
								<v-toolbar flat color="white">
									<v-toolbar-title>DAFTAR PESERTA</v-toolbar-title>
									<v-divider class="mx-4" inset vertical />
									<v-spacer></v-spacer>
									<v-btn
										small
										icon
										:disabled="btnLoading"
										@click.stop="printtoexcel()"
										v-if="datatable_peserta.length > 0"
									>
										<v-icon>
											mdi-printer
										</v-icon>
									</v-btn>
								</v-toolbar>
							</template>
							<template v-slot:item.idkelas="{ item }">
								{{ $store.getters["uiadmin/getNamaKelas"](item.idkelas) }}
							</template>
							<template v-slot:item.kjur="{ item }">
								{{ $store.getters["uiadmin/getProdiName"](item.kjur) }}
							</template>
							<template v-slot:item.n_kuan="props">
								<v-numeric
									v-model="props.item.n_kuan"
									text
									:min="0"
									:max="100"
									locale="en-US"
									:useGrouping="false"
									precision="2"
									dense
									:useCalculator="false"
									:calcIcon="null"
									style="width:65px"
								>
								</v-numeric>
								<v-chip
									color="primary"
									class="ma-2"
									outlined
									label
									v-if="props.item.n_kuan != null"
								>
									{{ props.item.n_kuan }}
								</v-chip>
							</template>
							<template v-slot:item.n_kual="props">
								<v-select
									:items="$store.getters['uiadmin/getSkalaNilai']"
									v-model="props.item.n_kual"
									style="width:65px"
									dense
								>
								</v-select>
							</template>
							<template v-slot:body.append v-if="datatable_peserta.length > 0">
								<tr>
									<td class="text-right" colspan="8">
										<v-btn
											class="primary mt-2 mb-2"
											@click.stop="save"
											:disabled="btnLoading"
										>
											SIMPAN
										</v-btn>
									</td>
								</tr>
							</template>
							<template v-slot:no-data>
								Data belum tersedia
							</template>
						</v-data-table>
					</v-form>
				</v-col>
			</v-row>
		</v-container>
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import DataKelasMHS from "@/components/DataKelasMHS";
	export default {
		name: "NilaiIsiPerKelasMHSDetail",
		created() {
			this.breadcrumbs = [
				{
					text: "HOME",
					disabled: false,
					href: "/dashboard/" + this.$store.getters["auth/AccessToken"],
				},
				{
					text: "AKADEMIK",
					disabled: false,
					href: "/akademik",
				},
				{
					text: "ISI NILAI",
					disabled: false,
					href: "#",
				},
				{
					text: "PER KELAS MAHASISWA",
					disabled: true,
					href: "#",
				},
			];
			this.kelas_mhs_id = this.$route.params.kelas_mhs_id;
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
		},
		mounted() {
			this.initialize();
		},
		data: () => ({
			kelas_mhs_id: null,
			data_kelas_mhs: null,
			tahun_akademik: null,
			semester_akademik: null,

			btnLoadingTable: false,
			datatableLoading: false,
			btnLoading: false,
			datatable: [],
			datatable_peserta: [],
			headers_peserta: [
				{ text: "NIM", value: "nim", sortable: false, width: 100 },
				{ text: "NAMA", value: "nama_mhs", sortable: false },
				{ text: "PROGRAM STUDI", value: "kjur", sortable: false },
				{ text: "KELAS", value: "idkelas", sortable: false },
				{ text: "TAHUN MASUK", value: "tahun", sortable: false },
				{ text: "NILAI ANGKA (0 s.d 100)", value: "n_kuan", sortable: false },
				{ text: "NILAI HURUP", value: "n_kual", sortable: false },
			],
			//formdata
			form_valid: true,
			daftar_nilai: [],
		}),
		methods: {
			initialize: async function() {
				await this.$ajax
					.get("/akademik/perkuliahan/pembagiankelas/" + this.kelas_mhs_id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.data_kelas_mhs = data.pembagiankelas;
					});
				this.datatableLoading = true;
				await this.$ajax
					.get("/akademik/nilai/matakuliah/pesertakelas/" + this.kelas_mhs_id, {
						headers: {
							Authorization: this.$store.getters["auth/Token"],
						},
					})
					.then(({ data }) => {
						this.datatableLoading = false;
						this.datatable_peserta = data.peserta;
					});
			},
			async fetchPeserta() {
				this.datatableLoading = true;
				await this.$ajax
					.get(
						"/akademik/perkuliahan/pembagiankelas/peserta/" + this.kelas_mhs_id,
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(({ data }) => {
						this.datatable_peserta = data.peserta;
						this.datatableLoading = false;
					});
			},
			async save() {
				this.btnLoadingTable = true;
				var daftar_nilai = [];

				this.datatable_peserta.forEach(item => {
					daftar_nilai.push({
						krsmatkul_id: item.krsmatkul_id,
						n_kuan: item.n_kuan,
						n_kual: item.n_kual,
					});
				});
				await this.$ajax
					.post(
						"/akademik/nilai/matakuliah/perkelas/storeperkelas",
						{
							kelas_mhs_id: this.kelas_mhs_id,
							daftar_nilai: JSON.stringify(Object.assign({}, daftar_nilai)),
						},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
						}
					)
					.then(() => {
						this.$router.go();
					})
					.catch(() => {
						this.btnLoadingTable = false;
					});
			},
			async printtoexcel() {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/akademik/nilai/matakuliah/perdosen/printtoexcel1/" + this.kelas_mhs_id,
						{},
						{
							headers: {
								Authorization: this.$store.getters["auth/Token"],
							},
							responseType: "arraybuffer",
						}
					)
					.then(({ data, status }) => {
						if (status == 200) {
							const url = window.URL.createObjectURL(new Blob([data]));
							const link = document.createElement("a");
							link.href = url;
							link.setAttribute("download", "daftar_nilai_" + Date.now() + ".xlsx");
							link.setAttribute("id", "download_laporan");
							document.body.appendChild(link);
							link.click();
							document.body.removeChild(link);							
						}
						this.btnLoading = false;
					})
					.catch(() => {
						this.btnLoading = false;
					});
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			DataKelasMHS,
		},
	};
</script>
