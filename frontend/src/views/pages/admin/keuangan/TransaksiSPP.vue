<template>
    <KeuanganLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-video-input-component
            </template>
            <template v-slot:name>
                TRANSAKSI SPP
            </template>
            <template v-slot:subtitle>
                TAHUN AKADEMIK {{tahun_akademik}}
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
                        Halaman ini digunakan untuk melakukan transaksi SPP mahasiswa baru dan lama.
                    </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter1 v-on:changeTahunAkademik="changeTahunAkademik" ref="filter1" />
        </template>
        <v-container fluid>
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
                        :headers="headers"
                        :items="datatable"
                        :search="search"
                        item-key="id"
                        sort-by="nama_mhs"
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR TRANSAKSI</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>                                
                            </v-toolbar>
                        </template>
                        <template v-slot:item.tanggal="{ item }">    
                            {{$date(item.tanggal).format('DD/MM/YYYY')}}
                        </template>
                        <template v-slot:item.sub_total="{ item }">    
                            {{item.sub_total|formatUang}}
                        </template>
                        <template v-slot:item.idsmt="{ item }">                                
                            {{$store.getters['uiadmin/getNamaSemester'](item.idsmt)}}
                        </template>
                        <template v-slot:item.nama_status="{ item }">    
                            <v-chip :color="item.style" dark>{{item.nama_status}}</v-chip>
                        </template>
                        <template v-slot:no-data>
                            Data transaksi SPP belum tersedia
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
import Filter1 from '@/components/sidebar/FilterMode1';
export default {
    name:'TransaksiBaru',
    created()
    {
        this.dashboard = this.$store.getters['uiadmin/getDefaultDashboard'];   
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
                text:'TRANSAKSI SPP',
                disabled:true,
                href:'#'
            }
        ];        
        this.tahun_akademik = this.$store.getters['uiadmin/getTahunAkademik'];                  
    },
    mounted()
    {
        this.initialize()
    },
    data: () => ({
        firstloading:true,
        breadcrumbs:[],     
        tahun_akademik:0,
        btnLoading:false,      

        //tables
        datatableLoading:false,       
        datatable:[], 
        headers: [                                                
            { text: 'KODE BILLING', value: 'no_transaksi',width:100,sortable:true },
            { text: 'TANGGAL', value: 'tanggal',width:120,sortable:true },
            { text: 'NIM', value: 'nim',sortable:true },
            { text: 'NAMA MAHASISWA', value: 'nama_mhs',sortable:true },
            { text: 'BULAN', value: 'bulan',width:100,sortable:true },
            { text: 'SMT', value: 'idsmt',width:100,sortable:false },
            { text: 'JUMLAH', value: 'sub_total',width:100,sortable:false },
            { text: 'STATUS', value: 'nama_status',width:100,sortable:false },            
            { text: 'AKSI', value: 'actions', sortable: false,width:50 },
        ],        
        expanded:[],
        search:'', 


    }),
    methods : {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
        initialize:async function () 
        {
            this.datatableLoading=true;            
            await this.$ajax.post('/keuangan/transaksi-spp',            
            {
                TA:this.tahun_akademik,
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.transaksi;                
                this.datatableLoading=false;
            });                     
            this.firstloading=false;
            this.$refs.filter1.setFirstTimeLoading(this.firstloading);       
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
    watch:{
        
        search (val)
        {
            console.log('saerch',val);
        }
    },
    components:{
        KeuanganLayout,
        ModuleHeader,     
        Filter1    
    },
}
</script>
