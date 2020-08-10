<template>
    <KeuanganLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-video-input-component
            </template>
            <template v-slot:name>
                BIAYA KOMPONEN PER PERIODE
            </template>
            <template v-slot:subtitle>
                TAHUN PENDAFTARAN/MASUK {{tahun_pendaftaran}} - KELAS {{nama_kelas}}
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
                        Halaman ini berisi informasi biaya komponen biaya per periode yang masing-masing.
                    </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter10 v-on:changeTahunPendaftaran="changeTahunPendaftaran" v-on:changeIDKelas="changeIDKelas" ref="filter10" />
        </template>
        <v-container fluid>
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">
                    <v-data-table
                        :headers="headers"
                        :items="datatable"                        
                        item-key="id"
                        sort-by="id"
                        show-expand
                        :disable-pagination="true"
                        :hide-default-footer="true"
                        :expanded.sync="expanded"
                        :single-expand="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">     
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR BIAYA KOMPONEN PER PERIODE</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn 
                                    color="primary" 
                                    class="mb-2" 
                                    :loading="btnLoading"
                                    :disabled="btnLoading"
                                    @click.stop="loadkombiperiode">
                                        GENERATE KOMPONEN BIAYA
                                </v-btn>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.biaya="props">
                            <v-edit-dialog
                                :return-value.sync="props.item.biaya"
                                large                                
                                @save="saveItem({id:props.item.id,biaya:props.item.biaya})"
                                @cancel="cancelItem"
                                @open="openItem"
                                @close="closeItem"> 
                                    {{ props.item.biaya|formatUang }}                                    
                                    <template v-slot:input>
                                        <div class="mt-4 title">Update Biaya</div>                                        
                                        <v-currency-field 
                                            label="BIAYA KOMPONEN" 
                                            :min="null"
                                            :max="null"                                            
                                            outlined
                                            autofocus
                                            v-model="props.item.biaya">                                        
                                        </v-currency-field>
                                    </template>
                            </v-edit-dialog>
                        </template>
                        <template v-slot:expanded-item="{ headers, item }">
                            <td :colspan="headers.length" class="text-center">
                                <v-col cols="12">                          
                                    <strong>ID:</strong>{{ item.id }}          
                                    <strong>created_at:</strong>{{ $date(item.created_at).format('DD/MM/YYYY HH:mm') }}
                                    <strong>updated_at:</strong>{{ $date(item.updated_at).format('DD/MM/YYYY HH:mm') }}
                                </v-col>                                
                            </td>
                        </template>
                        <template v-slot:no-data>
                            Data belum tersedia
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
    </KeuanganLayout>
</template>
<script>
import KeuanganLayout from '@/views/layouts/KeuanganLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter10 from '@/components/sidebar/FilterMode10';
export default {
    name:'BiayaKomponenPeriode',
    created()
    {
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.$store.getters['auth/AccessToken']
            },
            {
                text:'KEUANGAN',
                disabled:false,
                href:'/keuangan'
            },
            {
                text:'BIAYA KOMPONEN PER PERIODE',
                disabled:true,
                href:'#'
            }
        ];
        this.tahun_pendaftaran = this.$store.getters['uiadmin/getTahunPendaftaran'];         
        this.idkelas=this.$store.getters['uiadmin/getIDKelas']
        this.nama_kelas=this.$store.getters['uiadmin/getNamaKelas'](this.idkelas);
        this.initialize();
    },  
    data: () => ({
        firstloading:true,
        breadcrumbs:[],  
        tahun_pendaftaran:0,
        idkelas:null,
        nama_kelas:null,
        
        btnLoading:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],
        headers: [            
            { text: 'ID KOMPONEN', value: 'kombi_id',width:10,sortable:false },                                           
            { text: 'NAMA KOMPONEN', value: 'nama_kombi',sortable:false},
            { text: 'PERIODE', value: 'periode',width:150,sortable:false },            
            { text: 'BIAYA', value: 'biaya',width:150,sortable:false },            
        ],      
        
    }),
    methods : {
        changeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },
        changeIDKelas (idkelas)
        {
            this.idkelas=idkelas;
            this.nama_kelas=this.$store.getters['uiadmin/getNamaKelas'](idkelas);
        },
        initialize:async function()
		{
            this.datatableLoading=true;            
            await this.$ajax.post('/keuangan/biayakomponenperiode',            
            {
                TA:this.tahun_pendaftaran,
                idkelas:this.idkelas
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.kombi;                
                this.datatableLoading=false;
            });                     
            this.firstloading=false;            
            this.$refs.filter10.setFirstTimeLoading(this.firstloading); 
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
        loadkombiperiode:async function ()
        {
            this.btnLoading=true;            
            await this.$ajax.post('/keuangan/biayakomponenperiode/loadkombiperiode',            
            {
                TA:this.tahun_pendaftaran,
                idkelas:this.idkelas
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.kombi;                
                this.btnLoading=false;
            });   
        },
        saveItem:async function ({id,biaya})
        {
            await this.$ajax.post('/keuangan/biayakomponenperiode/updatebiaya',            
            {
                id:id,
                biaya:biaya
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(()=>{               
                this.initialize();                        
            });  
        },
        cancelItem()
        {

        },
        openItem()
        {

        },
        closeItem()
        {

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
        idkelas()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
    },
    components:{
        KeuanganLayout,
        ModuleHeader,    
        Filter10,       
    },
}
</script>