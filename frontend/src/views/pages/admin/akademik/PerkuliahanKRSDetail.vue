<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-format-columns
            </template>
            <template v-slot:name>
                KARTU RENCANA STUDI
            </template>
            <template v-slot:subtitle v-if="Object.keys(datakrs).length">
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
                    Halaman untuk melihat detail krs mahasiswa 
                </v-alert>
            </template>
        </ModuleHeader>   
        <v-container fluid v-if="Object.keys(datakrs).length">   
            <v-row>   
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            <span class="headline">DATA KRS</span>
                        </v-card-title>
                        <v-card-text>
                            <v-row no-gutters>
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>ID KRS:</v-card-title>
                                        <v-card-subtitle>
                                            {{datakrs.id}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>SAH :</v-card-title>
                                        <v-card-subtitle>
                                            {{datakrs.sah}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>NIM:</v-card-title>
                                        <v-card-subtitle>
                                            {{datakrs.nim}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>JUMLAH MATKUL / SKS :</v-card-title>
                                        <v-card-subtitle>
                                            {{jumlah_matkul}} / {{jumlah_sks}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>NAMA MAHASISWA:</v-card-title>
                                        <v-card-subtitle>
                                            {{datakrs.nama_mhs}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                <v-col xs="12" sm="6" md="6">
                                    <v-card flat>
                                        <v-card-title>CREATED / UPDATED :</v-card-title>
                                        <v-card-subtitle>
                                            {{$date(datakrs.created_at).format('DD/MM/YYYY HH:mm')}} / {{$date(datakrs.updated_at).format('DD/MM/YYYY HH:mm')}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                            </v-row>            
                        </v-card-text>
                    </v-card>
                </v-col>                
            </v-row>
            <v-row>
                <v-col cols="12">           
                    <v-card>
                        <v-card-title>
                            DAFTAR MATAKULIAH
                        </v-card-title>
                        <v-card-text>
                            <v-data-table                                
                                :headers="headers"
                                :items="datatable"                                
                                item-key="id"                                                        
                                :disable-pagination="true"
                                :hide-default-footer="true"                                                                
                                :loading="datatableLoading"
                                loading-text="Loading... Please wait">
                                <template v-slot:item.is_ketua="{ item }">                                    
                                    <v-switch
                                        v-model="item.is_ketua"
                                        :label="item.is_ketua == 1?'YA':'TIDAK'"
                                        @change="updateketua(item)">
                                    </v-switch>  
                                </template>
                                <template v-slot:item.actions="{ item }">                                    
                                    <v-btn
                                        small
                                        icon
                                        :loading="btnLoading"
                                        :disabled="btnLoading"
                                        @click.stop="deleteItem(item)">
                                        <v-icon>
                                            mdi-delete
                                        </v-icon>
                                    </v-btn>   
                                </template>    
                                <template v-slot:no-data>
                                    Data dosen pengampu penyelenggaraan matakuliah ini belum tersedia
                                </template>
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name: 'PerkuliahanKRSDetail',
    created () {
        this.krs_id=this.$route.params.krsid;        
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
                disabled:false,
                href:'/akademik/perkuliahan/krs/daftar'
            },
            {
                text:'DETAIL',
                disabled:true,
                href:'#'
            },
        ];
        this.fetchKRS();               
    },  
    data: () => ({ 
        firstloading:true,        
        nama_prodi:null,
        tahun_akademik:null,        
        semester_akademik:null,
    
        btnLoading:false, 
        
        //formdata
        krs_id:null,
        datakrs:{},
        jumlah_matkul:0,
        jumlah_sks:0,

        //table        
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:true,width:120  },   
            { text: 'NAMA MATAKULIAH', value: 'nmatkul',sortable:true },               
            { text: 'SKS', value: 'is_ketua', sortable:false,width:120 },                           
            { text: 'SMT', value: 'is_ketua', sortable:false,width:120 },                           
            { text: 'AKSI', value: 'actions', sortable:false,width:120 },                           
        ],  
    }),
    methods: {          
        async fetchKRS()
        {
            await this.$ajax.get('/akademik/perkuliahan/krs/'+this.krs_id,                        
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                                               
                this.datakrs=data.krs;
                if (Object.keys(this.datakrs).length)
                {
                    console.log(this.datakrs);
                    let prodi_id=this.datakrs.kjur;                    
                    this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);                
                    this.tahun_akademik=this.datakrs.tahun;                                                      
                    this.semester_akademik=this.datakrs.idsmt;                        
                }
            })  
        },        
    },
    components:{
        AkademikLayout,
        ModuleHeader,            
    },
}
</script>