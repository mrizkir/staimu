<template>
    <AkademikLayout :showrightsidebar="false">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-book-open-outline
            </template>
            <template v-slot:name>
                KONVERSI NILAI 
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
                    Halaman ini digunakan untuk mengelola konversi nilai mahasiswa pindahan/ampulan 
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>                         
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">
                    <v-card>
                        <v-card-title>
                            Data Konversi
                        </v-card-title>
                        <v-card-text>
                            <v-text-field
                                v-model="formdata.nim_asal"                                
                                label="NIM ASAL"
                                outlined                                
                            ></v-text-field>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="datatable"
                        :search="search"
                        item-key="id"                                                                        
                        :disable-pagination="true"
                        :hide-default-footer="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>KURIKULUM MATAKULIAH T.A {{tahun_pendaftaran}}</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>                                  
                            </v-toolbar>
                        </template>     
                        <template v-slot:item.n_kual="props">                                
                            <v-select 
                                :items="$store.getters['uiadmin/getSkalaNilai']"  
                                v-model="props.item.n_kual"
                                style="width:65px"                                
                                dense>
                            </v-select>
                        </template>                                                                                
                        <template v-slot:no-data>
                            Data belum tersedia
                        </template>   
                    </v-data-table>
                </v-col>
            </v-row>            
        </v-container>
        <v-dialog v-model="dialogprintpdf" max-width="500px" persistent>                
            <v-card>
                <v-card-title>
                    <span class="headline">Print to PDF</span>
                </v-card-title>
                <v-card-text>
                    <v-btn
                        color="green"
                        text
                        :href="$api.url+'/'+file_pdf">                            
                        Download
                    </v-btn>                           
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click.stop="closedialogprintpdf">CLOSE</v-btn>                            
                </v-card-actions>
            </v-card>            
        </v-dialog>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name: 'NilaiKonversiTambah',
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
                text:'NILAI',
                disabled:false,
                href:'#'
            },            
            {
                text:'KONVERSI MAHASISWA PINDAHAN/AMPULAN',
                disabled:false,
                href:'/akademik/nilai/konversi'
            },
            {
                text:'TAMBAH',
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
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        tahun_pendaftaran:null,

        btnLoading:false,
        btnLoadingTable:false,
        datatableLoading:false,        
        datatable:[],      
        headers: [            
            { text: 'KODE', value: 'kmatkul', sortable:false, width:120  },               
            { text: 'NAMA', value: 'nmatkul', sortable:false, width:250  },               
            { text: 'SKS', value: 'sks',sortable:false, width:70 },                           
            { text: 'SMT', value: 'semester',sortable:true,width:70, },                           
            { text: 'KODE MATKUL ASAL', value: 'kmatkul_asal',sortable:false },                           
            { text: 'MATAKULIAH ASAL', value: 'matkul_asal',sortable:false },                           
            { text: 'SKS ASAL', value: 'sks_asal',sortable:false},                           
            { text: 'NILAI', value: 'n_kual',sortable:false},                                       
        ],  
        search:'', 

        dialogprintpdf:false,
        file_pdf:null,

        formdata:{
            nim_asal:''
        }
    }),
    methods: {        
        initialize:async function () 
        {      
            this.datatableLoading=true;
            await this.$ajax.post('/akademik/nilai/konversi/matakuliah',
            {
                prodi_id:this.prodi_id,
                ta:this.tahun_pendaftaran
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.matakuliah;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });          
        },        
        viewItem(item)
        {
            this.$router.push('/akademik/nilai/transkripkurikulum/'+item.user_id);
        },
        async printpdf2(item)
        {
            this.btnLoading=true;
            await this.$ajax.get('/akademik/nilai/transkripkurikulum/printpdf2/'+item.user_id,                
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    },
                    
                }
            ).then(({data})=>{                              
                this.file_pdf=data.pdf_file;
                this.dialogprintpdf=true;
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });                 
        },
        closedialogprintpdf () {                  
            setTimeout(() => {
                this.file_pdf=null;
                this.dialogprintpdf = false;      
                }, 300
            );
        }, 
    },
    watch:{
        tahun_pendaftaran()
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
    },
}
</script>