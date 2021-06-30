<template>
	<AkademikLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-format-float-left
			</template>
			<template v-slot:name>
				PERUBAHAN KARTU RENCANA STUDI
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
					Halaman untuk melakukan melakukan perubahan krs
				</v-alert>
			</template>
		</ModuleHeader>
		<v-container fluid>
			<v-row class="mb-4" no-gutters>
				<v-col cols="12">
					<v-form ref="frmdata" v-model="form_valid" lazy-validation>
						<v-card>
							<v-card-text>
								<v-alert type="info">
									Silahkan masukan nim, pastikan mahasiswa tersebut telah
									melakukan KRS dan disahkan oleh Dosen Wali.
								</v-alert>
								<v-text-field
									v-model="formdata.nim"
									label="NIM"
									:rules="rule_nim"
									outlined
									append-outer-icon="mdi-send"
									@click:append-outer="cekNIM"
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
		name: "PerkuliahanKRSTambah",
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
					text: "PKRS",
					disabled: false,
					href: "/akademik/perkuliahan/pkrs/daftar",
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
			this.tahun_akademik = this.$store.getters["uiadmin/getTahunAkademik"];
			this.daftar_semester = this.$store.getters["uiadmin/getDaftarSemester"];
			this.semester_akademik = this.$store.getters[
				"uiadmin/getSemesterAkademik"
			];
			if (this.$store.getters["uiadmin/getDefaultDashboard"] == "mahasiswa") {
				this.formdata.nim = this.$store.getters["auth/AttributeUser"](
					"username"
				);
				this.fetchDulang();
			}
		},
		data: () => ({
			firstloading: true,
			prodi_id: null,
			nama_prodi: null,
			tahun_akademik: null,
			semester_akademik: null,

			btnLoading: false,

			//formdata
			form_valid: true,
			daftar_dulang: [],
			dulang_id: null,
			formdata: {
				nim: "",
			},
			rule_nim: [
				value => !!value || "Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
				value =>
					/^[0-9]+$/.test(value) ||
					"Nomor Induk Mahasiswa (NIM) hanya boleh angka",
			],
		}),
		methods: {
			async cekNIM() {
				if (this.formdata.nim.length > 0) {
					let nim = this.formdata.nim;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/krs/cekkrs",
							{
								nim: nim,
								ta: this.tahun_akademik,
								idsmt: this.semester_akademik,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							if (data.iskrs) {
								this.$router.push(
									"/akademik/perkuliahan/pkrs/" + data.data_krs.id + "/detail"
								);
							}
						})
						.catch(() => {
							this.btnLoading = false;
						});
				}
			},
			save: async function() {
				if (this.$refs.frmdata.validate()) {
					this.btnLoading = true;
					await this.$ajax
						.post(
							"/akademik/perkuliahan/pkrs/store",
							{
								nim: this.formdata.nim,
								dulang_id: this.dulang_id.value,
							},
							{
								headers: {
									Authorization: this.$store.getters["auth/Token"],
								},
							}
						)
						.then(({ data }) => {
							this.$router.push(
								"/akademik/perkuliahan/pkrs/" + data.krs.id + "/detail"
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
					this.$router.push("/akademik/perkuliahan/pkrs/daftar");
				}, 300);
			},			
		},
		components: {
			AkademikLayout,
			ModuleHeader,
		},
	};
</script>
