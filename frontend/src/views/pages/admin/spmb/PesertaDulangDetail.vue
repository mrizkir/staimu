<template>
	<SPMBLayout :showrightsidebar="false">
		<ModuleHeader>
			<template v-slot:icon>
				mdi-file-document-edit-outline
			</template>
			<template v-slot:name>
				BIODATA
			</template>
			<template v-slot:subtitle v-if="dashboard!='mahasiswabaru'">
				TAHUN PENDAFTARAN {{ tahun_pendaftaran }} - {{ nama_prodi }}
			</template>
			<template v-slot:breadcrumbs>
				<v-breadcrumbs :items="breadcrumbs" class="pa-0">
					<template v-slot:divider>
						<v-icon>mdi-chevron-right</v-icon>
					</template>
				</v-breadcrumbs>
			</template>
			<template v-slot:desc>
				<v-alert                                        
					color="cyan"
					border="left"  
					colored-border
					type="info"
					>
						Berisi kelengkapan biodata, silahkan melakukan filter tahun akademik dan program studi.
				</v-alert>
			</template>
		</ModuleHeader> 
		<v-container fluid>
			<v-row class="mb-2" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-title>
							IDENTITAS DIRI
						</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>NAMA LENGKAP</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nama_mhs }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>TEMPAT LAHIR</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.tempat_lahir }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>TANGGAL LAHIR</v-list-item-title>
											<v-list-item-subtitle>{{ $date(formdata.tanggal_lahir).format("DD/MM/YYYY") }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>JENIS KELAMIN</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.jk }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>NOMOR INDUK KEPENDUDUKAN (NIK)</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nik }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>UKURAN BAJU</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.ukuran_baju }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>NOMOR HP</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nomor_hp }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>EMAIL</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.email }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>NAMA IBU KANDUNG</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nama_ibu_kandung }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-2" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-title>
							ALAMAT DOMISILI
						</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>PROVINSI</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.address1_provinsi }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>KABUPATEN/KOTA</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.address1_kabupaten }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>KECAMATAN</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.address1_kecamatan }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>DESA/KELURAHAN</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.address1_desa }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>ALAMAT RUMAH</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.alamat_rumah }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
			<v-row class="mb-2" no-gutters>
				<v-col cols="12">
					<v-card>
						<v-card-title>
							RENCANA STUDI
						</v-card-title>
						<v-card-text>
							<v-row>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>PROGRAM STUDI</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nama_prodi }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
								<v-col cols="6">
									<v-list-item two-line>
										<v-list-item-content>
											<v-list-item-title>KELAS</v-list-item-title>
											<v-list-item-subtitle>{{ formdata.nkelas }}</v-list-item-subtitle>
										</v-list-item-content>
									</v-list-item>
								</v-col>
							</v-row>
						</v-card-text>
					</v-card>
				</v-col>
			</v-row>
		</v-container>
	</SPMBLayout>
</template>
<script>
import SPMBLayout from "@/views/layouts/SPMBLayout";
import ModuleHeader from "@/components/ModuleHeader";
export default {
	name: 'PesertaDulangDetail', 
	created()
	{
		this.user_id = this.$route.params.user_id;
		this.dashboard = this.$store.getters["uiadmin/getDefaultDashboard"];
		this.breadcrumbs = [
			{
				text: "HOME",
				disabled: false,
				href: "/dashboard/" + this.$store.getters["auth/AccessToken"]
			},
			{
				text: "SPMB",
				disabled: false,
				href: "/spmb"
			},
			{
				text: "DAFTAR ULANG",
				disabled: false,
				href: "/spmb/pesertadulang"
			},
			{
				text: "DETAIL",
				disabled: true,
				href: "#"
			}
		];
		this.initialize();
   },
	data: () => ({
		breadcrumbs: [],
		dashboard: null,

		tahun_pendaftaran: null,

		//form
		user_id: null,		
		formdata: {},
		errorMessage: null,
	}),
	methods: {
		initialize: async function() {				
			await this.$ajax.get('/spmb/formulirpendaftaran/'+this.user_id, 
				{
					headers: {
						Authorization: this.$store.getters["auth/Token"]
					}
				},
				
			).then(({ data }) => {
				this.formdata = data.formulir;				
			}); 
		},
	},
	components: {
		SPMBLayout,
		ModuleHeader,
   },
}
</script>