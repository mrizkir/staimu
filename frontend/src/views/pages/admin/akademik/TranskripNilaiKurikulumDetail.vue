<template>
    <AkademikLayout :showrightsidebar="false" :temporaryleftsidebar="true">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                TRANSKRIP NILAI KURIKULUM 
            </template>
            <template v-slot:subtitle>
                TAHUN PENDAFTARAN {{tahun_pendaftaran}} - {{nama_prodi}}
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
                    Halaman berisi daftar transkrip nilai berdasarkan kurikulum. 
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>      
            <v-row> 
                <v-col cols="12">                  
                    <ProfilMahasiswa :datamhs="data_mhs" />
                </v-col>
            </v-row>
        </v-container>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import ProfilMahasiswa from '@/components/ProfilMahasiswaLama';

export default {
    name: 'DulangMahasiswaBaru',
    created () {
        this.user_id=this.$route.params.user_id;        
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.$store.getters['auth/AccessToken']
            },
            {
                text:'AKADEMIK',
                disabled:false,
                href:'/akademik'
            },
            {
                text:'NILAI',
                disabled:false,
                href:'#'
            },
            {
                text:'TRANSKRIP KURIKULUM',
                disabled:false,
                href:'/akademik/nilai/transkripkurikulum'
            },
            {
                text:'DETAIL',
                disabled:true,
                href:'#'
            }
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_pendaftaran=this.$store.getters['uiadmin/getTahunPendaftaran'];                
        this.initialize()
    },  
    data: () => ({ 
        user_id:null,
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        tahun_pendaftaran:null,

        btnLoading:false,
        btnLoadingTable:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [            
            { text: 'NIM', value: 'nim', sortable:true,width:100  },               
            { text: 'NAMA MAHASISWA', value: 'nama_mhs',sortable:true },                           
            { text: 'KELAS', value: 'idkelas',sortable:true,width:120, },                           
            { text: 'JUMLAH MATKUL', value: 'jumlah_matkul',sortable:false,width:100, },                           
            { text: 'JUMLAH SKS', value: 'jumlah_sks',sortable:false,width:100, },                           
            { text: 'IPK SEMENTARA', value: 'ipk',sortable:true,width:100, },                           
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'', 

        data_mhs:{}, 
    }),
    methods: {
        changeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/nilai/transkripkurikulum/'+this.user_id,           
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.data_mhs=data.mahasiswa;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });  
            this.firstloading=false;                        
        },
        dataTableRowClicked(item)
        {
            if ( item === this.expanded[0])
            {
                this.expanded=[];                
            }
            else
            {
                this.expanded=[item];
            }               
        },        
    },
    components:{
        AkademikLayout,
        ModuleHeader,          
        ProfilMahasiswa  
    },
}
</script>