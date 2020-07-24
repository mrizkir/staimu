<template>
    <SPMBLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-calendar-account
            </template>
            <template v-slot:name>
                PASSING GRADE NILAI UJIAN
            </template>
            <template v-slot:subtitle>
                {{jadwal_ujian.nama_kegiatan}} - TAHUN PENDAFTARAN {{jadwal_ujian.ta}} SEMESTER {{$store.getters['uiadmin/getNamaSemester'](jadwal_ujian.idsmt)}}
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
                    Berisi informasi passing grade nilai dari sebuah jadwal ujian
                </v-alert>
            </template>
        </ModuleHeader>
        <v-container>             
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
                    <v-data-table
                        :search="search"
                        item-key="id"
                        sort-by="nama_prodi"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait"
                        class="elevation-1"
                        :disable-pagination="true"
                        :hide-default-footer="true"
                        :headers="headers"
                        :items="datatable">
                        <template v-slot:no-data>                                                        
                            <v-btn
                                class="ma-2"
                                :loading="btnLoading"
                                :disabled="showBtnLoadDataUraian || btnLoading"
                                color="primary"             
                                @click.stop="loaddatapassinggradefirsttime">
                                    LOAD DATA PRODI
                                <template v-slot:loader>
                                    <span>LOADING DATA ...</span>
                                </template>
                            </v-btn>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
    </SPMBLayout>
</template>
<script>
import SPMBLayout from '@/views/layouts/SPMBLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name:'PassingGrade',
    created () {
        this.jadwal_ujian_id = this.$route.params.idjadwalujian;     
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.$store.getters['auth/AccessToken']
            },
            {
                text:'SPMB',
                disabled:false,
                href:'#'
            },
            {
                text:'JADWAL UJIAN PMB',
                disabled:false,
                href:'/spmb/jadwalujianpmb'
            },
            {
                text:'PASSING GRADE',
                disabled:true,
                href:'#'
            }
        ]; 
        this.initialize();    
    },
    data:()=>({
        jadwal_ujian_id:null,
        jadwal_ujian:{
            id:0,                        
            nama_kegiatan:'',            
            ta:'',                        
            idsmt:'',                                    
        },
        breadcrumbs:[],        
        dashboard:null,

        btnLoading:false,
        datatableLoading:false,
        datatableLoaded:false,
        expanded:[],
        datatable:[],
        headers: [                                        
            { text: 'PROGRAM STUDI', value: 'nama_prodi', sortable: true},
            { text: 'NILAI', value: 'nilai', sortable: false,width:100 },            
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],
        search:'',
    }),
    methods: {
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.post('/spmb/passinggrade',
            {
                jadwal_ujian_id:this.jadwal_ujian_id,                
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{ 
                this.datatableLoaded=true;
                this.datatableLoading=false;
                this.jadwal_ujian=data.jadwal_ujian;                     
                console.log(data);
            }).catch(()=>{
                this.datatableLoading=false;
                this.datatableLoaded=true;
            });  
        },
        loaddatapassinggradefirsttime:async function ()
        {
            this.btnLoading=true;
            await this.$ajax.post('/spmb/passinggrade/loaddatapassinggradefirsttime',
                {
                    RKAID:this.datakegiatan.RKAID,                       
                },
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    }
                }
            ).then(({data})=>{             
                console.log(data);     
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });        
        }
    },
    computed: {        
        showBtnLoadDataUraian()
        {
            var bool = false;
            if (this.datatableLoaded == true)
            {
                bool = this.datatable.length > 0;
             
            }
            return bool;
            
        },
    },
    components:{
        SPMBLayout,
        ModuleHeader,        
    },
}
</script>