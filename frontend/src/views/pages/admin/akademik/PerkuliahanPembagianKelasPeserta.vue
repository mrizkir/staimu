<template>
    <AkademikLayout :showrightsidebar="false">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                PEMBAGIAN KELAS
            </template>
            <template v-slot:subtitle>
                TAHUN AKADEMIK {{tahun_akademik}} SEMESTER {{$store.getters['uiadmin/getNamaSemester'](semester_akademik)}}
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
                    Halaman untuk melakukan menambah peserta pada kelas terpilih.
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid v-if="data_kelas_mhs">        
            <v-row>
                <v-col cols="12">                            
                    <DataKelasMHS :datakelas="data_kelas_mhs" />
                </v-col>
            </v-row>
            <v-row no-gutters>
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
                                <v-toolbar-title>DAFTAR PEMBAGIAN KELAS</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" dark class="mb-2" to="/akademik/perkuliahan/pembagiankelas/tambah" v-if="CAN_ACCESS('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE')">TAMBAH</v-btn>
                                <v-dialog v-model="dialogfrm" max-width="750px" persistent>                                    
                                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">UBAH DATA KELAS</span>
                                            </v-card-title>
                                            <v-card-text>
                                                <v-row>
                                                    <v-col cols="4">
                                                        <v-select
                                                            v-model="formdata.hari"
                                                            :items="daftar_hari"                                                    
                                                            label="HARI"
                                                            :rules="rule_hari"        
                                                            outlined/> 
                                                    </v-col>
                                                    <v-col cols="4">
                                                        <v-text-field 
                                                            v-model="formdata.jam_masuk" 
                                                            label="JAM MASUK (contoh: 04:00)"
                                                            outlined
                                                            :rules="rule_jam_masuk">
                                                        </v-text-field>
                                                    </v-col>
                                                    <v-col cols="4">
                                                        <v-text-field 
                                                            v-model="formdata.jam_keluar" 
                                                            label="JAM KELUAR (contoh: 06:00)"
                                                            outlined
                                                            :rules="rule_jam_keluar">
                                                        </v-text-field>
                                                    </v-col>
                                                </v-row>
                                                <v-select
                                                    v-model="formdata.ruang_kelas_id"
                                                    :items="daftar_ruang_kelas"                                                    
                                                    label="RUANG KELAS"
                                                    :rules="rule_ruang_kelas"
                                                    item-text="namaruang"
                                                    item-value="id"
                                                    outlined/> 
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
                                </v-dialog>
                            </v-toolbar>
                        </template>
                        <template v-slot:item.nmatkul="{item}">
                            {{item.nmatkul}} - {{$store.getters['uiadmin/getNamaKelas'](item.idkelas)}}
                        </template>
                        <template v-slot:item.jam_masuk="{item}">
                            {{item.jam_masuk}}-{{item.jam_keluar}}
                        </template>
                        <template v-slot:item.actions="{ item }" v-if="CAN_ACCESS('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE')">
                            <v-btn
                                small
                                icon
                                @click.stop="$router.push('/akademik/perkuliahan/pembagiankelas/'+item.id+'/peserta')">
                                <v-icon>
                                    mdi-account-child-outline
                                </v-icon>
                            </v-btn>   
                            <v-btn
                                small
                                icon
                                :loading="btnLoadingTable"
                                :disabled="btnLoadingTable"
                                @click.stop="editItem(item)">
                                <v-icon>
                                    mdi-pencil
                                </v-icon>
                            </v-btn>   
                            <v-btn
                                small
                                icon
                                :loading="btnLoadingTable"
                                :disabled="btnLoadingTable"
                                @click.stop="deleteItem(item)">
                                <v-icon>
                                    mdi-delete
                                </v-icon>
                            </v-btn>   
                        </template>           
                        <template v-slot:item.actions v-else>
                            N.A
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
        
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import DataKelasMHS from '@/components/DataKelasMHS';

export default {
    name: 'PerkuliahanPembagianKelasTambah',
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
                text:'PEMBAGIAN KELAS',
                disabled:false,
                href:'/akademik/perkuliahan/pembagiankelas/daftar'
            },
            {
                text:'PESERTA',
                disabled:true,
                href:'#'
            }
        ];        
        this.kelas_mhs_id=this.$route.params.kelas_mhs_id;        
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        this.initialize()
    },  
    data: () => ({ 
        kelas_mhs_id:null,
        data_kelas_mhs:null,
        tahun_akademik:null,
        semester_akademik:null,

        datatableLoading:false,
        btnLoading:false,  

        datatable:[],          

        //formdata
        form_valid:true,         
    }),
    methods: {        
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/perkuliahan/pembagiankelas/'+this.kelas_mhs_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{           
                this.data_kelas_mhs=data.pembagiankelas;    
                this.datatable=data.penyelenggaraan;                                
            })       
        },
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
            }            
        },        
    },
    watch:{
        
    },    
    components:{
        AkademikLayout,
        ModuleHeader,     
        DataKelasMHS       
    },
}
</script>