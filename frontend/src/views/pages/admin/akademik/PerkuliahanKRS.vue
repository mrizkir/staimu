<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                KARTU RENCANA STUDI
            </template>
            <template v-slot:subtitle>
                TAHUN AKADEMIK {{tahun_akademik}} SEMESTER {{$store.getters['uiadmin/getNamaSemester'](semester_akademik)}} - {{nama_prodi}}
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
                    Halaman untuk melihat daftar kontrak matakuliah per tahun akademik, dan semester yang telah dilakukan.
                </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter6 v-on:changeTahunAkademik="changeTahunAkademik" v-on:changeSemesterAkademik="changeSemesterAkademik" v-on:changeProdi="changeProdi" ref="filter6" />	
        </template>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter6 from '@/components/sidebar/FilterMode6';
export default {
    name: 'PerkuliahanKRS',
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
                text:'KRS',
                disabled:true,
                href:'#'
            }
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        this.initialize()
    },  
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        daftar_ta:[],
        tahun_akademik:null,
        semester_akademik:null,
    }),
    methods: {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
        changeSemesterAkademik (semester)
        {
            this.semester_akademik=semester;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
        initialize:async function () 
        {

        },
    },
    watch:{
        tahun_akademik()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
        semester_akademik()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
        prodi_id(val)
        {
            if (!this.firstloading)
            {
                this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](val);
                this.initialize();
            }            
        }
    },
    components:{
        AkademikLayout,
        ModuleHeader,    
        Filter6               
    },
}
</script>