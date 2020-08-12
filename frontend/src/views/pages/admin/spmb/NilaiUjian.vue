<template>
    <SPMBLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-file-document-edit-outline
            </template>
            <template v-slot:name>
                NILAI UJIAN
            </template>
            <template v-slot:subtitle v-if="dashboard!='mahasiswabaru'">
                TAHUN PENDAFTARAN {{tahun_pendaftaran}} - {{nama_prodi}}
            </template>
            <template v-slot:breadcrumbs>
                <v-breadcrumbs :items="breadcrumbs" class="pa-0">
                    <template v-slot:divider>
                        <v-icon>mdi-chevron-right</v-icon>
                    </template>
                </v-breadcrumbs>
            </template>
            <template v-slot:desc v-if="dashboard=='mahasiswabaru'">
                <v-alert                                        
                    color="cyan"
                    border="left"                    
                    colored-border
                    type="info"
                    >
                        Halaman ini berisi pengisian formulir pendaftaran, mohon diisi dengan lengkap dan benar.
                </v-alert>
            </template>
            <template v-slot:desc v-else>
                <v-alert                                        
                    color="cyan"
                    border="left"                    
                    colored-border
                    type="info"
                    >
                        Berisi nilai ujian PMB, dan juga bisa untuk penentuan nilai ujian dan kelulusan.
                </v-alert>
            </template>
        </ModuleHeader> 
        <v-container fluid v-if="dashboard=='mahasiswabaru'">
            <FormMhsBaru/>
        </v-container>
        <v-container fluid v-else>
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
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR MAHASISWA BARU</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-dialog v-model="dialogprofilmhsbaru" :fullscreen="true">                                    
                                    <ProfilMahasiswaBaru :item="datamhsbaru" v-on:closeProfilMahasiswaBaru="closeProfilMahasiswaBaru" />                                    
                                </v-dialog>
                                <v-dialog v-model="dialogfrm" max-width="750px" persistent v-if="dialogfrm">
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
                                                @click.stop="closedialogfrm()">
                                                mdi-close-thick
                                            </v-icon>
                                        </v-toolbar>
                                        <v-card-text>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>ID :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_nilai.id}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                                                
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAMA MAHASISWA :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_nilai.name}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>KODE BILLING :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_nilai.no_transaksi}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NOMOR FORMULIR :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_nilai.no_formulir}}
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
                                                            {{$date(data_nilai.tanggal).format('DD/MM/YYYY')}} {{$date(data_nilai.created_at).format('HH:mm:ss')}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NIM :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{data_nilai.nim}}
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
                                                            {{data_nilai.total|formatUang}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>STATUS :</v-card-title>
                                                        <v-card-subtitle>
                                                            <v-chip :color="data_nilai.style" dark>{{data_nilai.nama_status}}</v-chip>
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
                                                                <v-text-field 
                                                                    v-model="formdata.nilai"
                                                                    label="NILAI UJIAN:" 
                                                                    :rules="rule_nilai"
                                                                    outlined />  
                                                                <v-text-field 
                                                                    v-model="formdata.nama_rekening_pengirim"
                                                                    label="NAMA PENGIRIM:" 
                                                                    :rules="rule_nama_pengirim"
                                                                    outlined />  
                                                                <v-text-field 
                                                                    v-model="formdata.nama_bank_pengirim"
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
                                                                <v-img class="white--text align-end" :src="buktiBayar"></v-img>                                                                               
                                                            </v-card-text>
                                                            <v-card-actions>
                                                                <v-spacer></v-spacer>
                                                                <v-btn color="blue darken-1" text @click.stop="closedialogfrm">BATAL</v-btn>
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
                        <template v-slot:item.foto="{ item }">    
                            <v-badge
                                    bordered
                                    :color="badgeColor(item)"
                                    :icon="badgeIcon(item)"
                                    overlap
                                >                
                                    <v-avatar size="30">                                        
                                        <v-img :src="$api.url+'/'+item.foto" />                                                                     
                                    </v-avatar>                                                                                                  
                            </v-badge>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                @click.stop="viewItem(item)">
                                mdi-eye
                            </v-icon>
                            <v-icon
                                small
                                class="mr-2"
                                @click.stop="editItem(item)">
                                mdi-pencil
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
        <template v-slot:filtersidebar v-if="dashboard!='mahasiswabaru'">
            <Filter7 v-on:changeTahunPendaftaran="changeTahunPendaftaran" v-on:changeProdi="changeProdi" ref="filter7" />	
        </template>
    </SPMBLayout>
</template>
<script>
import SPMBLayout from '@/views/layouts/SPMBLayout';
import ModuleHeader from '@/components/ModuleHeader';
import FormMhsBaru from '@/components/FormMahasiswaBaru';
import ProfilMahasiswaBaru from '@/components/ProfilMahasiswaBaru';
import Filter7 from '@/components/sidebar/FilterMode7';
export default {
    name: 'NilaiUjian', 
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
                text:'SPMB',
                disabled:false,
                href:'/spmb'
            },
            {
                text:'NILAI UJIAN',
                disabled:true,
                href:'#'
            }
        ];
        this.breadcrumbs[1].disabled=(this.dashboard=='mahasiswabaru'||this.dashboard=='mahasiswa');
        
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_pendaftaran=this.$store.getters['uiadmin/getTahunPendaftaran'];                
        this.initialize()   
    },  
    data: () => ({
        firstloading:true,
        prodi_id:null,
        tahun_pendaftaran:null,
        nama_prodi:null,

        dialogprofilmhsbaru:false,
        dialogfrm:false,

        breadcrumbs:[],        
        dashboard:null,

        btnLoading:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],
        headers: [                        
            { text: '', value: 'foto', width:70 },               
            { text: 'NAMA MAHASISWA', value: 'name',width:350,sortable:true },
            { text: 'NOMOR HP', value: 'nomor_hp',width:100},
            { text: 'KELAS', value: 'nkelas',width:100,sortable:true },
            { text: 'NILAI', value: 'nilai',width:100,sortable:true },
            { text: 'STATUS', value: 'status',width:100,sortable:true },
            { text: 'AKSI', value: 'actions', sortable: false,width:50 },
        ],
        search:'',  
        
        datamhsbaru:{},

        //form data   
        form_valid:true,   

        data_nilai:{},
        formdata: {            
            user_id:0,            
            jadwal_ujian_id:1,            
            jumlah_soal:0,            
            jawaban_benar:0,            
            jawaban_salah:0,            
            soal_tidak_terjawab:0,            
            passing_grade_1:0,            
            passing_grade_2:0,            
            nilai:1,            
            ket_lulus:1,            
            kjur:1,            
            desc:1,            
            created_at:1,            
            updated_at:1,            
        },
        rule_nilai:[
            value => !!value||"Mohon diisi nomor rekening pengirim !!!",
            value => /^[0-9]+$/.test(value) || 'Nomor Rekening hanya boleh angka',
        ],
    }),
    methods : {
        changeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
		initialize:async function()
		{	
            switch(this.dashboard)
            {
                case 'mahasiswabaru':

                break;
                default :
                    this.datatableLoading=true;            
                    await this.$ajax.post('/spmb/nilaiujian',
                    {
                        TA:this.tahun_pendaftaran,
                        prodi_id:this.prodi_id,
                    },
                    {
                        headers: {
                            Authorization:this.$store.getters['auth/Token']
                        }
                    }).then(({data})=>{               
                        this.datatable = data.pmb;                
                        this.datatableLoading=false;
                    });         
                    this.firstloading=false;
                    this.$refs.filter7.setFirstTimeLoading(this.firstloading); 
            }
            
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
        badgeColor(item)
        {
            return item.active == 1 ? 'success':'error'
        },
        badgeIcon(item)
        {
            return item.active == 1 ? 'mdi-check-bold':'mdi-close-thick'
        },     
        viewItem(item)
        {
            this.datamhsbaru = item;
            this.dialogprofilmhsbaru = true;
        },
        editItem(item)
        {
            this.data_nilai=item;
            this.dialogfrm=true;        
        },
        closeProfilMahasiswaBaru ()
        {
            this.dialogprofilmhsbaru = false;                      
        }        
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
        SPMBLayout,
        ModuleHeader,        
        FormMhsBaru,
        ProfilMahasiswaBaru,
        Filter7    
    },
}
</script>