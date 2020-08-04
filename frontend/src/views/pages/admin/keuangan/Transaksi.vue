<template>
    <KeuanganLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-account-cash
            </template>
            <template v-slot:name>
                TRANSAKSI
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
                        Transaksi
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
                                <v-dialog v-model="dialogdetailitem" max-width="700px" persistent v-if="dialogdetailitem">
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">DETAIL TRANSAKSI</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>KODE PRODI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.kode_prodi}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAMA PRODI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.nama_prodi}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>                                            
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAMA SINGKAT PRODI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.nama_prodi_alias}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                                                
                                            </v-row>                                            
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click.stop="closedialogdetailitem">KELUAR</v-btn>
                                        </v-card-actions>
                                    </v-card>                                    
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.tanggal="{ item }">    
                            {{$date(item.tanggal).format('DD/MM/YYYY')}}
                        </template>
                        <template v-slot:item.total="{ item }">    
                            {{item.total|formatUang}}
                        </template>
                        <template v-slot:item.nama_status="{ item }">    
                            <v-chip :color="item.style" dark>{{item.nama_status}}</v-chip>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click.stop="viewItem(item)">
                                mdi-eye
                            </v-icon>                           
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
import Filter1 from '@/components/sidebar/FilterMode1';
export default {
    name: 'Transaksi',
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
                text:'DAFTAR TRANSAKSI',
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
        breadcrumbs:[],     
        tahun_akademik:0,
        btnLoading:false,       

        //tables
        datatableLoading:false,       
        datatable:[], 
        headers: [                                                
            { text: 'KODE BILLING', value: 'no_transaksi',width:100,sortable:true },
            { text: 'TANGGAL', value: 'tanggal',width:120,sortable:true },
            { text: 'NAMA MAHASISWA', value: 'nama_mhs',sortable:true },
            { text: 'TOTAL', value: 'total',width:100,sortable:true },
            { text: 'STATUS', value: 'nama_status',width:100,sortable:true },            
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],        
        expanded:[],
        search:'', 

        //dialog        
        dialogdetailitem:false,

        //form data
        formdata: {
            
        },
    }),
    methods: {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
        initialize:async function () 
        {
            this.datatableLoading=true;            
            await this.$ajax.post('/keuangan/transaksi',            
            {
                TA:2020,
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
        viewItem (item) {
            this.formdata=item;      
            this.dialogdetailitem=true;                        
        },
        closedialogdetailitem () {
            this.dialogdetailitem = false;            
            setTimeout(() => {
                this.formdata = Object.assign({}, {})
                this.editedIndex = -1
                }, 300
            );
        },
    },
    components:{
        KeuanganLayout,
        ModuleHeader,    
        Filter1    
    },
}
</script>