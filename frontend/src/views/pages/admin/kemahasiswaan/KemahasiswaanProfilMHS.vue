<template>
  <ProfilMahasiswaLayout :showrightsidebar="false" :temporaryleftsidebar="true">
    <ModuleHeader>
      <template v-slot:icon>
        mdi-monitor-dashboard
      </template>
      <template v-slot:name>
        PROFIL MAHASISWA
      </template>
      <template v-slot:subtitle v-if="datamhs.hasOwnProperty('user_id')">
        [{{datamhs.nim}}] {{datamhs.nama_mhs}}
      </template>
      <template v-slot:breadcrumbs>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0">
          <template v-slot:divider>
            <v-icon>mdi-chevron-right</v-icon>
          </template>
        </v-breadcrumbs>
      </template>
    </ModuleHeader>
    <v-container fluid v-if="datamhs.hasOwnProperty('user_id')">
      <v-row> 
        <v-col cols="12">
          <ProfilMahasiswa :datamhs="datamhs" url="/kemahasiswaan" />
        </v-col>
      </v-row>
      <v-row dense class="mb-4">
        <v-col xs="12" sm="6" md="3">
          <v-card                         
            class="green darken-1"
            color="#385F73"
            dark>
            <v-card-title class="headline">
              IPK
            </v-card-title>
            <v-card-subtitle>
              indeks Prestasi Kumulatif
            </v-card-subtitle>
            <v-card-text>
              {{ipk}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly" />
        <v-col xs="12" sm="6" md="3">
          <v-card                         
            class="green darken-1"
            color="#385F73"
            dark>
            <v-card-title class="headline">
              SKS
            </v-card-title>
            <v-card-subtitle>
              Total SKS
            </v-card-subtitle>
            <v-card-text>
              {{totalSKS}}
            </v-card-text>
          </v-card>
        </v-col>
        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly" />
      </v-row>
    </v-container>
  </ProfilMahasiswaLayout>
</template>
<script>
  import ProfilMahasiswaLayout from '@/views/layouts/ProfilMahasiswaLayout';
  import ModuleHeader from "@/components/ModuleHeader";
  import ProfilMahasiswa from '@/components/ProfilMahasiswaLama';
  export default {
    name: 'Kemahasiswaan',
    created()
    {
      this.user_id = this.$route.params.user_id;
      this.breadcrumbs = [
        {
          text: "HOME",
          disabled: false,
          href: "/dashboard/" + this.$store.getters["auth/AccessToken"]
        },
        {
          text: 'KEMAHASISWAAN',
          disabled: false,
          href: '/kemahasiswaan'
        },
        {
          text: 'PROFIL',
          disabled: true,
          href: "#"
        }
      ];
    },
    mounted()
    {
      this.initialize();
    },
    data: () => ({ 
      firstloading: true,
      breadcrumbs: [],
      
      //profil mahasiswa      
      user_id: null,
      datamhs: {
        nama_mhs: ""
      },
      totalSKS: 0, 
      totalM: 0, 
      totalAM: 0, 
      ipk: 0.00, 

      //tables
      datatableLoading: false,
      datatable: [],
      headers: [           
        { text: "KODE BILLING", value: "no_transaksi", width: 100, sortable: true },
        { text: 'TANGGAL', value: 'tanggal', width: 100, sortable: true },
        { text: "NIM", value: "nim", width: 100, sortable: true },
        { text: "NAMA MAHASISWA", value: "nama_mhs", sortable: true, width: 250 },
        { text: 'T.A/SMT', value: 'idsmt', width: 100, sortable: true },
        { text: 'TOTAL', value: 'total', width: 100, sortable: true },
        { text: "STATUS", value: "nama_status", width: 50, sortable: true }, 
        { text: "AKSI", value: "actions", sortable: false, width: 50 },
      ],
      expanded: [],
      search: "", 
      //form data
      dialogdetailitem: false,
      data_transaksi: {},
      data_transaksi_detail: {},
    }),
    methods: {
      initialize: async function()
      {	
        await this.$ajax.get('/akademik/nilai/transkripkurikulum/'+this.user_id,
        {
          headers: {
            Authorization: this.$store.getters["auth/Token"]
          }
        }).then(({ data }) => {
          this.datamhs=data.mahasiswa;
          
          this.totalSKS=data.jumlah_sks;
          this.totalM=data.jumlah_m;
          this.totalAM=data.jumlah_am;
          this.ipk=data.ipk;
        });
      },
    },
    components: {
      ProfilMahasiswaLayout,
      ModuleHeader,
      ProfilMahasiswa            
    },
  };
</script>
