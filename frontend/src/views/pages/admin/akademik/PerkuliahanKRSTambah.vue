<template>
    <AkademikLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-format-columns
            </template>
            <template v-slot:name>
                KARTU RENCANA STUDI
            </template>
            <template v-slot:subtitle  v-if="$store.getters['uiadmin/getDefaultDashboard']!='mahasiswa'&&$store.getters['uiadmin/getDefaultDashboard']!='mahasiswabaru'">
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
                    Halaman untuk melakukan tambah krs 
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>                         
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">                    
                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                        <v-card>
                            <v-card-title>
                                PILIH TAHUN AKADEMIK DAN SEMESTER
                            </v-card-title>
                            <v-card-text>        
                                <v-row no-gutters>                                 
                                    <v-col cols="12">
                                        <v-text-field 
                                            v-model="formdata.nim"
                                            label="NIM"   
                                            :rules="rule_nim"                                                                  
                                            outlined /> 
                                    </v-col>
                                </v-row>
                                <v-row no-gutters>
                                    <v-col cols="6">
                                        <v-select
                                            v-model="ta_matkul"
                                            :items="daftar_ta"
                                            item-text="tahun_akademik"
                                            item-value="tahun"
                                            label="TAHUN AKADEMIK"                                            
                                            class="mr-2"
                                            outlined/> 
                                    </v-col>
                                    <v-col cols="6">
                                        <v-select
                                            v-model="semester_akademik"
                                            :items="daftar_semester"
                                            item-text="text"
                                            item-value="id"
                                            label="SEMESTER AKADEMIK"
                                            outlined/>            
                                    </v-col>
                                </v-row>
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
                                        TAMBAH
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
export default {
    name: 'PerkuliahanKRSTambah',
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
                disabled:false,
                href:'/akademik/perkuliahan/krs/daftar'
            },
            {
                text:'TAMBAH',
                disabled:true,
                href:'#'
            },
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.daftar_ta=this.$store.getters['uiadmin/getDaftarTA'];          
        this.tahun_akademik=this.$store.getters['uiadmin/getTahunAkademik'];                
        this.ta_matkul=this.tahun_akademik;
        this.daftar_semester=this.$store.getters['uiadmin/getDaftarSemester'];          
        this.semester_akademik=this.$store.getters['uiadmin/getSemesterAkademik'];                
        if (this.$store.getters['uiadmin/getDefaultDashboard']=='mahasiswa')
        {
            this.formdata.nim=this.$store.getters['auth/AttributeUser']('username');
        }
    },  
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        nama_prodi:null,
        tahun_akademik:null,
        ta_matkul:null,
        semester_akademik:null,

        btnLoading:false,        

        //table
        dialogdetailitem:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'KODE', value: 'kmatkul', sortable:true,width:120  },   
            { text: 'NAMA MATAKULIAH', value: 'nmatkul',sortable:true },               
            { text: 'KELOMPOK', value: 'group_alias', sortable:true,width:120 },               
            { text: 'SKS', value: 'sks',sortable:true,width:80, align:'center' },               
            { text: 'SMT', value: 'semester', sortable:true,width:80 },               
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'',    

        //formdata
        form_valid:true,   
        formdata:{
            nim:''
        },        
        rule_nim:[
            value => !!value||"Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!",
            value => /^[0-9]+$/.test(value) || 'Nomor Induk Mahasiswa (NIM) hanya boleh angka',
        ], 

    }),
    methods: {                
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
                await this.$ajax.post('/akademik/dulang/cekdulangkrs',
                {
                    nim:this.formdata.nim,
                    idsmt:this.semester_akademik,
                    ta:this.tahun_akademik
                },
                {
                    headers: {
                        Authorization:this.$store.getters['auth/Token']
                    }
                }).then(({data,status})=>{               
                    console.log(data,status);
                    this.btnLoading=false;
                }).catch(()=>{
                    this.btnLoading=false;
                });                  
            }
        },
       
        closedialogfrm () {                             
            setTimeout(() => {       
                this.formdata = Object.assign({}, this.formdefault);                                
                this.$router.push('/akademik/perkuliahan/krs/daftar');
                }, 300
            );
        },
    },
    
    components:{
        AkademikLayout,
        ModuleHeader,            
    },
}
</script>