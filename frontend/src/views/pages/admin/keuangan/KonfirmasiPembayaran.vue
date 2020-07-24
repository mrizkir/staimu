<template>
    <SPMBLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-account-cash
            </template>
            <template v-slot:name>
                KONFIRMASI PEMBAYARAN
            </template>
            <template v-slot:subtitle>
                
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
                        Halaman ini berisi informasi konfirmasi pembayaran mahasiswa.
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
                        :headers="headers"
                        :items="datatable"
                        :search="search"
                        item-key="id"
                        sort-by="name"
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait"
                    >
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR KONFIRMASI PEMBAYARAN</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn 
                                    color="primary" 
                                    class="mb-2"
                                    @click.stop="addItem">
                                        TAMBAH
                                </v-btn>
                            </v-toolbar>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
    </SPMBLayout>
</template>
<script>
import {mapGetters} from 'vuex';
import SPMBLayout from '@/views/layouts/SPMBLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name: 'KonfirmasiPembayaran', 
    created () {
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.ACCESS_TOKEN
            },
            {
                text:'KEUANGAN',
                disabled:false,
                href:'/keuangan'
            },
            {
                text:'KONFIRMASI PEMBAYARAN',
                disabled:true,
                href:'#'
            }
        ];
        this.initialize()
    },   
    data: () => ({ 
        breadcrumbs:[],        
        dashboard:null,
        
        datatableLoading:false,
        btnLoading:false,              
        //tables
        headers: [                                                
            { text: 'NAMA MAHASISWA', value: 'name',width:350,sortable:true },
            { text: 'TANGGAL TRANSFER', value: 'email',sortable:true },     
            { text: 'BANK TUJUAN', value: 'nomor_hp',sortable:true },     
            { text: 'JUMLAH', value: 'created_at',sortable:true,width:150 },     
            { text: 'NAMA PENGIRIM/PEMILIK REKENING', value: 'created_at',sortable:true,width:150 },     
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],
        expanded:[],
        search:'',
        datatable:[],
    }),
    methods: {
        initialize:async function () 
        {

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
        addItem ()
        {
            
        }
    },
    computed: {
        ...mapGetters('auth',{            
            ACCESS_TOKEN:'AccessToken',          
            TOKEN:'Token',                                  
        }), 
        TahunPendaftaran()
        {
            return this.$store.getters['uiadmin/getTahunPendaftaran'];
        }
    },
    components:{
        SPMBLayout,
        ModuleHeader,        
    },
}
</script>