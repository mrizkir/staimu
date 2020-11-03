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
        <v-container fluid v-if="data_kelas_mhs">        
            <v-row>
                <v-col cols="12">                            
                    <DataKelasMHS :datakelas="data_kelas_mhs" />
                </v-col>
            </v-row>
            <v-row no-gutters>
                <v-col cols="12">                            
                    <v-data-table
                        :headers="headers"
                        :items="datatable"                        
                        item-key="id"                                                
                        :disable-pagination="true"
                        :hide-default-footer="true"                        
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR MATAKULIAH</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>                                                                
                            </v-toolbar>
                        </template>
                        <template v-slot:item.nmatkul="{item}">
                            {{item.nmatkul}} - TA {{item.ta}}
                        </template>
                        <template v-slot:item.jam_masuk="{item}">
                            {{item.jam_masuk}}-{{item.jam_keluar}}
                        </template>
                        <template v-slot:item.kjur="{item}">
                            {{$store.getters['uiadmin/getProdiName'](item.kjur)}}
                        </template>
                        <template v-slot:item.actions="{ item }">                              
                            <v-btn
                                small
                                icon
                                :loading="btnLoadingTable"
                                :disabled="btnLoadingTable"
                                @click.stop="deleteItem(item)">
                                <v-icon>
                                    mdi-delete
                                </v-icon>
                            </v-btn>   
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
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import DataKelasMHS from '@/components/DataKelasMHS';

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

        btnLoadingTable:false,
        datatableLoading:false,
        btnLoading:false,  

        datatable:[],          
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:false,width:100  },   
            { text: 'NAMA', value: 'nmatkul', sortable:false  },   
            { text: 'SKS', value: 'sks', sortable:false  },                           
            { text: 'PROGRAM STUDI', value: 'kjur', sortable:false, width:200 },                           
            { text: 'JUMLAH MHS DI KRS', value: 'jumlah_mhs', sortable:false, width:100 },                           
            { text: 'AKSI', value: 'actions', sortable: false,width:60 },
        ],  
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
                this.data_kelas_mhs=data.pembagiankelas;    
                this.datatable=data.penyelenggaraan;                                
                this.datatableLoading=false;
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
        DataKelasMHS       
    },
}
</script>