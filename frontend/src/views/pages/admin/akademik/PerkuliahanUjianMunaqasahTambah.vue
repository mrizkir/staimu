<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-run-fast
			</template>
			<template v-slot:name>
				UJIAN MUNAQASAH
			</template>
			<template
				v-slot:subtitle
				v-if="$store.getters['uiadmin/getDefaultDashboard'] != 'mahasiswa'"
			>
				TAHUN AKADEMIK {{ tahun_akademik }} SEMESTER
				{{ $store.getters["uiadmin/getNamaSemester"](semester_akademik) }} -
				{{ nama_prodi }}
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
					Halaman untuk melakukan tambah ujian munaqasah
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-title>
								CEK PERSYARATAN
							</v-card-title>
							<v-card-text>
								<v-alert type="info">
									sebelum menambah ujian munaqasah sistem akan melakukan
									pengecekan persyaratan. Silahkan masukan NIM, kemudian tekan
									tombol <v-icon>mdi-send</v-icon> untuk memproses.
								</v-alert>
								<v-text-field
									v-model="formdata.nim"
									label="NIM"
									:rules="rule_nim"
									outlined
									append-outer-icon="mdi-send"
									@click:append-outer="cekPersyaratan"
									:disabled="
										this.$store.getters['uiadmin/getDefaultDashboard'] ==
											'mahasiswa'
									"
								/>
							</v-card-text>
							<v-card-actions>
								<v-spacer></v-spacer>
								<v-btn color="blue darken-1" text @click.stop="closedialogfrm">
									BATAL
								</v-btn>
								<v-btn
									color="blue darken-1"
									text
									@click.stop="save"
									:disabled="!form_valid || btnLoading || iscomplete"
								>
									BUAT
								</v-btn>
							</v-card-actions>
						</v-card>
					</v-form>
				</v-col>
			</v-row>
		</v-container>
	</AkademikLayout>
</template>
<script>
	import AkademikLayout from "@/views/layouts/AkademikLayout";
	import ModuleHeader from "@/components/ModuleHeader";
	export default {
		name: "PerkuliahanUjianMunaqasahTambah",
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
					text: "PERKULIAHAN",
					disabled: false,
					href: "#",
				},
				{
					text: "UJIAN MUNAQASAH",
					disabled: false,
					href: "/akademik/perkuliahan/ujianmunaqasah",
				},
				{
					text: "TAMBAH",
					disabled: true,
					href: "#",
				},
			];
			let prodi_id = this.$store.getters["uiadmin/getProdiID"];
			this.prodi_id = prodi_id;
			this.nama_prodi = this.$store.getters["uiadmin/getProdiName"](prodi_id);
			this.daftar_ta = this.$store.getters["uiadmin/getDaftarTA"];
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.ta_matkul = this.tahun_akademik;
			this.daftar_semester = this.$store.getters["uiadmin/getDaftarSemester"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.formdata.nim = this.$store.getters["auth/AttributeUser"](
					"username"
				);
			}
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			ta_matkul: null,
			semester_akademik: null,

			btnLoading: false,

			//table
			dialogdetailitem: false,
			datatableLoading: false,
			expanded: [],
			datatable: [],
			headers: [
				{ text: "KODE", value: "kmatkul", sortable: true, width: 120 },
				{ text: "NAMA MATAKULIAH", value: "nmatkul", sortable: true },
				{ text: "KELOMPOK", value: "group_alias", sortable: true, width: 120 },
				{
					text: "SKS",
					value: "sks",
					sortable: true,
					width: 80,
					align: "center",
				},
				{ text: "SMT", value: "semester", sortable: true, width: 80 },
				{ text: "AKSI", value: "actions", sortable: false, width: 100 },
			],
			search: "",

			//formdata
			form_valid: true,
			iscomplete: true,
			formdata: {
				nim: "",
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya bolehangka",
			],
			rule_dulang: [
				value =>
					!!value || "Mohon dipilih Daftar Ulang yang telah dilakukan !!!",
			],
		}),
		methods: {
			cekPersyaratan() {
				if (this.formdata.nim.length > 0) {
					console.log(this.formdata.nim);
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/krs/store",
							{
								nim: this.formdata.nim,
								dulang_id: this.formdata.dulang_id,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.$router.push(
								"/akademik/perkuliahan/ujianmunaqasah/" +
									data.ujian.id +
									"/detail"
							);
							this.btnLoading = false;
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			closedialogfrm() {
				setTimeout(() => {
					this.formdata = Object.assign({}, {});
					this.$router.push("/akademik/perkuliahan/ujianmunaqasah");
				}, 300);
			},
		},
		components: {
			AkademikLayout,
			ModuleHeader,
		},
	};
</script>
