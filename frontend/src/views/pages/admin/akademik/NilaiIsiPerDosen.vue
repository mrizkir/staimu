<template>
	<AkademikLayout>
		<ModuleHeader>
			<template v-slot:icon>
				mdi-monitor-dashboard
			</template>
			<template v-slot:name>
				ISI NILAI PER DOSEN
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
					Halaman untuk melakukan pengisian nilai berdasarkan kelas yang diampu
					oleh Dosen berdasarkan kelas yang telah dibentuk pada pembagian kelas.
				</v-alert>
			</template>
		</ModuleHeader>
		<template v-slot:filtersidebar>
			<Filter2
				v-on:changeTahunAkademik="changeTahunAkademik"
				v-on:changeSemesterAkademik="changeSemesterAkademik"
				ref="filter2"
			/>
		</template>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-text>
							<v-text-field
								v-model="search"
								append-icon="mdi-database-search"
								label="Search"
								single-line
								hide-details
							></v-text-field>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-alert type="info">
						Bila tombol isi nilai TIDAK AKTIF disebabkan oleh waktu pengisian nilai belum ditentukan oleh PUSLAHTA.
					</v-alert>
					<v-data-table
						:headers="headers"
						:items="datatable"
						:search="search"
						item-key="id"
						show-expand
						:expanded.sync="expanded"
						:single-expand="true"
						:disable-pagination="true"
						:hide-default-footer="true"
						@click:row="dataTableRowClicked"
						class="elevation-1"
						:loading="datatableLoading"
						loading-text="Loading... Please wait"
					>
						<template v-slot:top>
							<v-toolbar flat color="white">
								<v-toolbar-title>DAFTAR KELAS</v-toolbar-title>
								<v-divider class="mx-4" inset vertical />
								<v-spacer></v-spacer>
							</v-toolbar>
						</template>
						<template v-slot:item.nmatkul="{ item }">
							{{ item.nmatkul }} -
							{{ $store.getters["uiadmin/getNamaKelas"](item.idkelas) }}
						</template>
						<template v-slot:item.jam_masuk="{ item }">
							{{ item.jam_masuk }} - {{ item.jam_keluar }}
						</template>
						<template v-slot:item.actions="{ item }">
							<v-btn
								small
								icon
								@click.stop="isiperdosen(item)"
								:disabled="waktuIsiNilai(item) == 'N.A'"
								v-if="item.jumlah_mhs > 0"
							>
								<v-icon>
									mdi-video-input-svideo
								</v-icon>
							</v-btn>
							<span v-else>
								N.A
							</span>
							<v-btn
								small
								icon
								:disabled="btnLoading"
								@click.stop="printtoexcel(item)"
								v-if="item.jumlah_mhs > 0"								
							>
								<v-icon>
									mdi-printer
								</v-icon>
							</v-btn>
						</template>
						<template v-slot:expanded-item="{ headers, item }">
							<td :colspan="headers.length" class="text-center">
								<v-col cols="12">
									<strong>ID:</strong>{{ item.id }}
									<strong>WAKTU ISI NILAI:</strong>
									{{ waktuIsiNilai(item) }}
									<strong>CREATED AT:</strong>
									{{ $date(item.created_at).format("DD/MM/YYYY HH:mm") }}
									<strong>UPDATED AT:</strong>
									{{ $date(item.updated_at).format("DD/MM/YYYY HH:mm") }}
								</v-col>
							</td>
						</template>
						<template v-slot:no-data>
							Data belum tersedia
						</template>
					</v-data-table>
				</v-col>
			</v-row>
		</v-container>
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	import Filter2 from "@/components/sidebar/FilterMode2";

	import { mapGetters } from "vuex";

	export default {
		name: "NilaiIsiPerKelasMHS",
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
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
		},
		mounted() {
			this.initialize();
			this.firstloading = false;
			this.$refs.filter2.setFirstTimeLoading(this.firstloading);
		},
		data: () => ({
			firstloading: true,
			daftar_ta: [],
			tahun_akademik: null,
			semester_akademik: null,

			btnLoadingTable: false,
			btnLoading: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "KODE", value: "kmatkul", sortable: true, width: 100 },
				{
					text: "NAMA MATAKULIAH/KELAS",
					value: "nmatkul",
					sortable: true,
					width: 250,
				},
				{ text: "NAMA DOSEN", value: "nama_dosen", sortable: true, width: 250 },
				{ text: "HARI", value: "nama_hari", sortable: true, width: 70 },
				{ text: "JAM", value: "jam_masuk", sortable: true, width: 70 },
				{ text: "RUANG", value: "namaruang", sortable: true, width: 100 },
				{
					text: "JUMLAH PESERTA",
					value: "jumlah_mhs",
					sortable: true,
					width: 100,
				},
				{ text: "AKSI", value: "actions", sortable: false, width: 120 },
			],
			search: "",
		}),
		methods: {
			changeTahunAkademik(tahun) {
				this.tahun_akademik = tahun;
			},
			changeSemesterAkademik(semester) {
				this.semester_akademik = semester;
			},
			initialize: async function() {
				this.datatableLoading = true;
				await this.$ajax
					.post(
						"/akademik/perkuliahan/pembagiankelas",
						{
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
						this.datatable = data.pembagiankelas;
						this.datatableLoading = false;
					})
					.catch(() => {
						this.datatableLoading = false;
					});				
			},
			dataTableRowClicked(item) {
				if (item === this.expanded[0]) {
					this.expanded = [];
				} else {
					this.expanded = [item];
				}
			},
			waktuIsiNilai(item) {
				if (item.waktu_mulai_isi_nilai == null || item.waktu_selesai_isi_nilai == null) {
					return "N.A";
				} else {
					let waktu = this.$date(item.waktu_mulai_isi_nilai).format("DD/MM/YYYY HH:mm") + " - " + this.$date(item.waktu_selesai_isi_nilai).format("DD/MM/YYYY HH:mm");
					return waktu;
				}
			},
			isiperdosen(item) {
				this.$router.push(
					"/akademik/nilai/matakuliah/isiperdosen/" + item.id
				)
			},
			async printtoexcel(item) {
				this.btnLoading = true;
				await this.$ajax
					.post(
						"/akademik/nilai/matakuliah/perdosen/printtoexcel1/" + item.id,
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
		},
		computed: {
			...mapGetters("auth", {
				CAN_ACCESS: "can",
			}),
		},
		components: {
			AkademikLayout,
			ModuleHeader,
			Filter2,
		},
	};
</script>
