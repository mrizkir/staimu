<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-format-columns
            </template>
            <template v-slot:name>
                KARTU RENCANA STUDI
            </template>
            <template v-slot:subtitle v-if="$store.getters['uiadmin/getDefaultDashboard']!='mahasiswa'&&$store.getters['uiadmin/getDefaultDashboard']!='mahasiswabaru'">
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
                    Halaman untuk melihat daftar kontrak matakuliah per tahun akademik, dan semester yang telah dilakukan.
                </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar v-if="$store.getters['uiadmin/getDefaultDashboard']!='mahasiswa'&&$store.getters['uiadmin/getDefaultDashboard']!='mahasiswabaru'">
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
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR KRS</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" dark class="mb-2" to="/akademik/perkuliahan/krs/tambah">TAMBAH</v-btn>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.idkelas="{item}">
                            {{$store.getters['uiadmin/getNamaKelas'](item.idkelas)}}
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-btn
                                small
                                icon
                                @click.stop="$router.push('/akademik/perkuliahan/penyelenggaraan/'+item.id+'/dosenpengampu')">
                                <v-icon>
                                    mdi-account-child-outline
                                </v-icon>
                            </v-btn>   
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
    name: 'PerkuliahanKRS',
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
                text:'KRS',
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

        btnLoadingTable:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'NIM', value: 'kmatkul', sortable:true,width:150  },   
            { text: 'NAMA', value: 'nmatkul', sortable:true  },   
            { text: 'ANGK.', value: 'sks', sortable:true, width:100  },               
            { text: 'JUMLAH MATKUL', value: 'semester', sortable:true, width:100  },               
            { text: 'JUMLAH SKS', value: 'ta_matkul', sortable:true, width:100 },               
            { text: 'TA.SMT', value: 'jumlah_dosen',sortable:true, width:100 },                           
            { text: 'SAH', value: 'jumlah_mhs',sortable:true, width:100},                           
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'', 
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