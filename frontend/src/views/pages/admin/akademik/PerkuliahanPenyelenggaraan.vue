<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                PENYELENGGARAAN PERKULIAHAN
            </template>
            <template v-slot:subtitle>
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
                    Halaman untuk melakukan penyelenggaraan matakuliah per prodi, tahun akademik, dan semester.
                </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter6 v-on:changeTahunAkademik="changeTahunAkademik" v-on:changeSemesterAkademik="changeSemesterAkademik" v-on:changeProdi="changeProdi" ref="filter6" />	
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
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="true"
                        :disable-pagination="true"
                        :hide-default-footer="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR PENYELENGGARAAN</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" dark class="mb-2" to="/akademik/perkuliahan/penyelenggaraan/tambah">TAMBAH</v-btn>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.idkelas="{item}">
                            {{$store.getters['uiadmin/getNamaKelas'](item.idkelas)}}
                        </template>
                        <template v-slot:item.actions="{ item }">
                           <v-icon
                                small
                                :loading="btnLoading"
                                :disabled="btnLoading"
                                @click.stop="deleteItem(item)">
                                mdi-delete
                            </v-icon>    
                        </template>           
                        <template v-slot:expanded-item="{ headers, item }">
                            <td :colspan="headers.length" class="text-center">
                                <v-col cols="12">                          
                                    <strong>penyelenggaraan_id:</strong>{{ item.id }}          
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
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter6 from '@/components/sidebar/FilterMode6';
export default {
    name: 'PerkuliahanPenyelenggaraan',
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
                text:'PENYELENGGARAAN MATAKULIAH',
                disabled:true,
                href:'#'
            }
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        this.initialize()
    },  
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        daftar_ta:[],
        tahun_akademik:null,
        semester_akademik:null,

        btnLoading:false,
        btnLoadingTable:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:true,width:150  },   
            { text: 'NAMA MATAKULIAH', value: 'nmatkul', sortable:true  },   
            { text: 'SKS', value: 'sks', sortable:true, width:100  },               
            { text: 'SMT', value: 'semester', sortable:true, width:100  },               
            { text: 'TAHUN', value: 'ta_matkul', sortable:true, width:100 },               
            { text: 'JUMLAH DOSEN', value: 'jumlah_dosen',sortable:true, width:100 },                           
            { text: 'JUMLAH MHS', value: 'jumlah_mhs',sortable:true, width:100},                           
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'', 

        data_mhs:{},  

        //formdata
        form_valid:true,   
        dialogfrm:false, 
        daftar_dw:[],     

        formdata: {                        
            nim:'',
            nirm:'',
            dosen_id:''           
        },
        formdefault: {                        
            nim:'',
            nirm:'',
            dosen_id:''           
        },
        rule_nim:[
            value => !!value||"Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
            value => /^[0-9]+$/.test(value) || 'Nomor Induk Mahasiswa (NIM) hanya boleh angka',
        ], 
        rule_nirm:[
            value => !!value||"Nomor Induk Registrasi Masuk (NIRM) mohon untuk diisi !!!",
            value => /^[0-9]+$/.test(value) || 'Nomor Induk Registrasi Masuk (NIRM) hanya boleh angka',
        ], 
        rule_dw:[
            value => !!value||"Mohon dipilih Dosen Wali untuk Mahasiswa ini !!!"
        ],

    }),
    methods: {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
        changeSemesterAkademik (semester)
        {
            this.semester_akademik=semester;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.post('/akademik/perkuliahan/penyelenggaraanmatakuliah',
            {
                prodi_id:this.prodi_id,
                ta:this.tahun_akademik,
                semester_akademik:this.semester_akademik,
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.penyelenggaraan;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });  
            this.firstloading=false;
            this.$refs.filter6.setFirstTimeLoading(this.firstloading); 
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
        
        closedialogfrm () {            
            this.dialogfrm = false;            
            setTimeout(() => {       
                this.formdata = Object.assign({}, this.formdefault);                                
                this.data_mhs = Object.assign({}, {});   
                }, 300
            );
        },
        deleteItem (item)
        {
            this.$root.$confirm.open('Delete', 'Apakah Anda ingin menghapus penyelenggaraan matakuliah ('+item.nmatkul+') ?', { color: 'red',width:600,'desc':'proses ini juga menghapus seluruh data kontrak matakuliah MHS.' }).then((confirm) => {
                if (confirm)
                {
                    this.btnLoadingTable=true;
                    this.$ajax.post('/akademik/perkuliahan/penyelenggaraanmatakuliah/'+item.id,
                        {
                            '_method':'DELETE',
                        },
                        {
                            headers:{
                                Authorization:this.$store.getters['auth/Token']
                            }
                        }
                    ).then(()=>{   
                        const index = this.datatable.indexOf(item);
                        this.datatable.splice(index, 1);
                        this.btnLoadingTable=false;
                    }).catch(()=>{
                        this.btnLoadingTable=false;
                    });
                }                
            });
        },
    },
    watch:{
        tahun_akademik()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
        semester_akademik()
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
        Filter6               
    },
}
</script>