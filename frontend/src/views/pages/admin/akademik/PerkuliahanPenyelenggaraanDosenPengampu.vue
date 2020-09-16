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
        <v-container fluid>   
            <v-row class="mb-4">   
                <v-col cols="12">
                    <DataMatakuliahPenyelenggaraan :datamatkul="data_matkul"></DataMatakuliahPenyelenggaraan>
                </v-col>
                <v-col cols="12">                    
                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                        <v-card>
                            <v-card-title>
                                TAMBAH DOSEN PENGAMPU
                            </v-card-title>
                            <v-card-text>
                                <v-alert type="info">
                                    Silahkan pilih dosen untuk mengampu matakuliah ini 
                                </v-alert>                                
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn 
                                    color="blue darken-1" 
                                    text 
                                    @click.stop="$router.push('/akademik/perkuliahan/penyelenggaraan/daftar')">
                                        BATAL
                                    </v-btn>
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
        </v-container>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import DataMatakuliahPenyelenggaraan from '@/components/DataMatakuliahPenyelenggaraan';
export default {
    name: 'PerkuliahanPenyelenggaraanDosenPengampu',
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
                disabled:false,
                href:'/akademik/perkuliahan/penyelenggaraan/daftar'
            },
            {
                text:'DOSEN PENGAMPU',
                disabled:true,
                href:'#'
            },
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.daftar_ta=this.$store.getters['uiadmin/getDaftarTA'];          
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                        
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        this.formdata.idpenyelenggaraan=this.$route.params.idpenyelenggaraan;
    }, 
    mounted()
    {
        this.fetchMatkul(); 
    },
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        tahun_akademik:null,        
        semester_akademik:null,

        btnLoading:false,        

        //table        
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:true,width:120  },   
            { text: 'NAMA MATAKULIAH', value: 'nmatkul',sortable:true },               
            { text: 'KELOMPOK', value: 'group_alias', sortable:true,width:120 },               
            { text: 'SKS', value: 'sks',sortable:true,width:80, align:'center' },               
            { text: 'SMT', value: 'semester', sortable:true,width:80 },               
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],     

        //formdata
        form_valid:true, 
        data_matkul:null,  
        formdata:{
            idpenyelenggaraan:null,
            dosen_id:null,
            is_ketua:false,
        },        
        formdefault:{
            idpenyelenggaraan:null,
            dosen_id:null,
            is_ketua:false,
        },        

    }),
    methods: {        
        async fetchMatkul ()
        {
            await this.$ajax.get('/akademik/perkuliahan/penyelenggaraanmatakuliah/'+this.formdata.idpenyelenggaraan,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                               
                this.data_matkul = data.penyelenggaraan;                
            })  
        }
        
    },
   
    components:{
        AkademikLayout,
        ModuleHeader, 
        DataMatakuliahPenyelenggaraan           
    },
}
</script>