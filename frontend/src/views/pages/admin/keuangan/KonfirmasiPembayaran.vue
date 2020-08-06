<template>
    <KeuanganLayout>
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
                        sort-by="no_transaksi"
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
                                    <v-card color="grey lighten-4">
                                        <v-toolbar elevation="2"> 
                                            <v-toolbar-title>KONFIRMASI !!!</v-toolbar-title>
                                            <v-divider
                                                class="mx-4"
                                                inset
                                                vertical
                                            ></v-divider>
                                            <v-spacer></v-spacer>
                                            <v-icon                
                                                @click.stop="closedialogdetailitem()">
                                                mdi-close-thick
                                            </v-icon>
                                        </v-toolbar>
                                        <v-card-text>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>ID :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.id}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>KODE BILLING :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.no_transaksi}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAMA MAHASISWA :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.nama_mhs}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NOMOR FORMULIR :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.no_formulir}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>TANGGAL TRANSAKSI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{$date(data_transaksi.tanggal).format('DD/MM/YYYY')}} {{$date(data_transaksi.created_at).format('HH:mm:ss')}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NIM :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.nim}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>TOTAL :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_transaksi.total|formatUang}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>STATUS :</v-card-title>
                                                        <v-card-subtitle>
                                                            <v-chip :color="data_transaksi.style" dark>{{data_transaksi.nama_status}}</v-chip>
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row>
                                                <v-col cols="12">
                                                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                                                        <v-card>                                                            
                                                            <v-card-text>  
                                                                <v-select
                                                                    label="PEMBAYARAN MELALUI :"
                                                                    v-model="formdata.id_channel"
                                                                    :items="daftar_channel"
                                                                    item-text="nama_channel"
                                                                    item-value="id_channel"
                                                                    :rules="rule_channel_pembayaran"
                                                                    outlined
                                                                />  
                                                                <v-currency-field 
                                                                    label="SEBESAR :" 
                                                                    :min="null"
                                                                    :max="null"                                            
                                                                    outlined                                                                    
                                                                    v-model="formdata.total_bayar">                                        
                                                                </v-currency-field>
                                                                <v-text-field 
                                                                    v-model="formdata.nama_pengirim"
                                                                    label="NOMOR REKENING PENGIRIM:" 
                                                                    :rules="rule_nomor_rekening"
                                                                    outlined />  
                                                                <v-text-field 
                                                                    v-model="formdata.nama_pengirim"
                                                                    label="NAMA PENGIRIM:" 
                                                                    :rules="rule_nama_pengirim"
                                                                    outlined />  
                                                                <v-text-field 
                                                                    v-model="formdata.bank_pengirim"
                                                                    label="BANK PENGIRIM:" 
                                                                    :rules="rule_nama_bank"
                                                                    outlined />                                                                  
                                                                <v-textarea 
                                                                    v-model="formdata.desc"
                                                                    label="CATATAN:"                                                                    
                                                                    outlined />
                                                                <v-file-input 
                                                                    accept="image/jpeg,image/png" 
                                                                    label="BUKTI BAYAR (MAKS. 2MB)"
                                                                    :rules="rule_bukti_bayar"
                                                                    show-size
                                                                    v-model="formdata.bukti_bayar"
                                                                    @change="previewImage">
                                                                </v-file-input> 
                                                                <v-img class="white--text align-end" height="200px" :src="photoPersyaratan"></v-img>                                                                               
                                                            </v-card-text>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click.stop="closedialogdetailitem">BATAL</v-btn>
                                                                <v-btn 
                                                                    color="blue darken-1" 
                                                                    text 
                                                                    @click.stop="save" 
                                                                    :loading="btnLoading"
                                                                    :disabled="!form_valid||btnLoading">
                                                                        SIMPAN
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-form>
                                                </v-col>
                                            </v-row>
                                        </v-card-text>
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
                                mdi-send
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
export default {
    name: 'KonfirmasiPembayaran', 
    created () {
        this.dashboard = this.$store.getters['uiadmin/getDefaultDashboard'];        
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
        this.breadcrumbs[1].disabled=(this.dashboard=='mahasiswabaru'||this.dashboard=='mahasiswa');
        this.initialize()
    },   
    data: () => ({         
        breadcrumbs:[],        
        dashboard:null,
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
            { text: 'AKSI', value: 'actions', sortable: false,width:70 },
        ],   
        expanded:[],
        search:'',

         //dialog        
        dialogdetailitem:false,
        
        //form data   
        form_valid:true,                 
        data_transaksi: {
            
        },   
        daftar_channel:[],
        formdata: {
            id_channel:1,
            total_bayar:0,
            nama_pengirim:'',
            bank_pengirim:'',
            desc:'',
            bukti_bayar:'',
        },
        formdefault: {
            id_channel:1,
            total_bayar:0,
            nama_pengirim:'',
            desc:'',
            bukti_bayar:'',
        },    
        //form rules  
        rule_channel_pembayaran:[
            value => !!value||"Mohon dipilih Channel Pembayaran mohon untuk dipilih !!!"
        ], 
        rule_nama_pengirim:[
            value => !!value||"Mohon diisi nama pengirim !!!"
        ], 
        rule_bukti_bayar:[
            value => !!value||"Mohon pilih foto !!!",  
            value =>  !value || value.size < 2000000 || 'File Bukti Bayar harus kurang dari 2MB.'                
        ],
    }),
    methods: {
        initialize:async function () 
        {
            this.datatableLoading=true;            
            await this.$ajax.post('/keuangan/konfirmasipembayaran',            
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
        async viewItem (item)
        {
            await this.$ajax.get('/keuangan/channelpembayaran',
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{   
                this.daftar_channel=data.channel;            
                this.data_transaksi=item;            
                this.dialogdetailitem=true;
            });            
            
        },
        closedialogdetailitem () {
            this.dialogdetailitem = false;            
            setTimeout(() => {
                this.data_transaksi = Object.assign({}, {})
                this.editedIndex = -1
                }, 300
            );
        },
    },
    computed: {
        TahunPendaftaran()
        {
            return this.$store.getters['uiadmin/getTahunPendaftaran'];
        }
    },
    components:{
        KeuanganLayout,
        ModuleHeader,        
    },
}
</script>