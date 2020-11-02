<template>
    <AkademikLayout :showrightsidebar="false">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                PEMBAGIAN KELAS
            </template>
            <template v-slot:subtitle>
                TAHUN AKADEMIK {{tahun_akademik}} SEMESTER {{$store.getters['uiadmin/getNamaSemester'](semester_akademik)}}
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
                    Halaman untuk melakukan menambah peserta pada kelas terpilih.
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>                                    
            
        </v-container>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';

export default {
    name: 'PerkuliahanPembagianKelasTambah',
    created () {
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
                text:'PERKULIAHAN',
                disabled:false,
                href:'#'
            },
            {
                text:'PEMBAGIAN KELAS',
                disabled:false,
                href:'/akademik/perkuliahan/pembagiankelas/daftar'
            },
            {
                text:'PESERTA',
                disabled:true,
                href:'#'
            }
        ];        
        this.kelas_mhs_id=this.$route.params.kelas_mhs_id;        
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        this.initialize()
    },  
    data: () => ({ 
        kelas_mhs_id:null,
        data_kelas_mhs:null,
        tahun_akademik:null,
        semester_akademik:null,

        datatableLoading:false,
        btnLoading:false,  

        datatable:[],          

        //formdata
        form_valid:true,         
    }),
    methods: {        
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/perkuliahan/pembagiankelas/'+this.kelas_mhs_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                               
                console.log(data);  
            })       
        },
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
            }            
        },        
    },
    watch:{
        
    },    
    components:{
        AkademikLayout,
        ModuleHeader,            
    },
}
</script>