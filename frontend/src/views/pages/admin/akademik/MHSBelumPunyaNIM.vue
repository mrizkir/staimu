<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-book
            </template>
            <template v-slot:name>
                MAHASISWA BELUM PUNYA NIM
            </template>
            <template v-slot:subtitle>
                TAHUN AKADEMIK {{tahun_akademik}} - {{nama_prodi}}
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
                    Halaman untuk melihat daftar calon mahasiswa yang sudah melakukan pembayaran daftar ulang tetapi belum memiliki NIM.
                </v-alert>
            </template>
        </ModuleHeader>   
        <template v-slot:filtersidebar>
            <Filter18 v-on:changeTahunAkademik="changeTahunAkademik" v-on:changeProdi="changeProdi" ref="filter18" />	
        </template>
    </AkademikLayout>
</template>
<script>

import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter18 from '@/components/sidebar/FilterMode18';
export default {
    name:'MHSBelumPunyaNIM',
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
                text:'DAFTAR ULANG',
                disabled:false,
                href:'#'
            },
            {
                text:'MAHASISWA BARU BELUM PUNYA NIM',
                disabled:true,
                href:'#'
            }
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.initialize()
    },  
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        tahun_akademik:null,        

        btnLoading:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:true,width:120  },   
            { text: 'NAMA MATAKULIAH', value: 'nmatkul',sortable:true },               
            { text: 'KELOMPOK', value: 'group_alias', sortable:true,width:120 },               
            { text: 'SKS', value: 'sks',sortable:true,width:80, align:'center' },               
            { text: 'SMT', value: 'semester', sortable:true,width:80 },               
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'',    
    }),
    methods: {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
        initialize:async function () 
        {

        }
    },
    components:{
        AkademikLayout,
        ModuleHeader,
        Filter18        
    },
}
</script>