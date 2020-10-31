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
                    Halaman untuk melakukan pembagian kelas terhadap matakuliah yang sudah diselenggarakan per prodi, tahun akademik, dan semester.
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>                                    
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">
                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                        <v-card class="mb-2">
                            <v-card-title>PILIH DOSEN / PENGAMPU</v-card-title>
                            <v-card-text>
                                <v-autocomplete
                                    label="DOSEN"
                                    v-model="dosen_id"
                                    :items="daftar_dosen"
                                    item-text="nama_dosen"
                                    item-value="user_id"
                                    :rules="rule_dosen"
                                    outlined/>    
                            </v-card-text>
                        </v-card>
                        <v-card class="mb-2">
                            <v-card-title>TAMBAH KELAS BARU</v-card-title>
                            <v-card-text>
                                <v-select
                                    v-model="formdata.penyelenggaraan_dosen_id"
                                    :items="daftar_matakuliah"                                                    
                                    label="MATAKULIAH"
                                    :rules="rule_matakuliah"
                                    item-text="nmatkul"
                                    item-value="id"
                                    :disabled="dosen_id==null"
                                    outlined/> 
                                <v-select
                                    v-model="formdata.idkelas"
                                    :items="daftar_kelas"                                                    
                                    label="KELAS"
                                    :rules="rule_kelas"
                                    item-text="text"
                                    item-value="id"
                                    :disabled="dosen_id==null"
                                    outlined/> 

                                <v-row>
                                    <v-col cols="4">
                                        <v-select
                                            v-model="formdata.hari"
                                            :items="daftar_hari"                                                    
                                            label="HARI"
                                            :rules="rule_hari"                                            
                                            :disabled="dosen_id==null"
                                            outlined/> 
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field 
                                            v-model="formdata.jam_masuk" 
                                            label="JAM MASUK (contoh: 04:00)"
                                            outlined
                                            :rules="rule_jam_masuk"
                                            :disabled="dosen_id==null">
                                        </v-text-field>
                                    </v-col>
                                    <v-col cols="4">
                                        <v-text-field 
                                            v-model="formdata.jam_keluar" 
                                            label="JAM KELUAR (contoh: 06:00)"
                                            outlined
                                            :rules="rule_jam_keluar"
                                            :disabled="dosen_id==null">
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
                                    outlined
                                    :disabled="dosen_id==null"/> 
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn color="blue darken-1" text @click.stop="$router.push('/akademik/perkuliahan/pembagiankelas/daftar')">KEMBALI</v-btn>
                                <v-btn 
                                    color="blue darken-1" 
                                    text 
                                    @click.stop="save" 
                                    :loading="btnLoading"
                                    :disabled="!form_valid||btnLoading||dosen_id==null">
                                        BUAT
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
                text:'TAMBAH',
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
        tahun_akademik:null,
        semester_akademik:null,

        btnLoadingTable:false,        
        //formdata
        form_valid:true, 
        daftar_dosen:[],        
        dosen_id:null,

        daftar_matakuliah:[],

        daftar_kelas:[],

        daftar_ruang_kelas:[],

        daftar_hari:[
            {
                text:'SENIN',
                value:1,
            },
            {
                text:'SELASA',
                value:2,
            },
            {
                text:'RABU',
                value:3,
            },
            {
                text:'KAMIS',
                value:4,
            },
            {
                text:'JUMAT',
                value:5,
            },
            {
                text:'SABTU',
                value:6,
            },
        ],
        formdata:{            
            id:'',
            idkelas:'',            
            hari:'',            
            jam_masuk:'',
            jam_keluar:'',
            penyelenggaraan_dosen_id:'',
            ruang_kelas_id:'',            
        },  
        rule_dosen:[
            value => !!value||"Mohon dipilih Dosen pengampu matakuliah !!!"
        ],
        rule_matakuliah:[
            value => !!value||"Mohon dipilih matakuliah dari dosen pengampu ini!!!"
        ],
        rule_kelas:[
            value => !!value||"Mohon dipilih kelas matakuliah ini!!!"
        ],
        rule_hari:[
            value => !!value||"Mohon dipilih hari mengajar!!!"
        ],
        rule_jam_masuk:[
            value => !!value||"Mohon diisi jam masuk mengajar!!!",
            value => /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/.test(value) || 'Format jam masuk mengajar hh:mm, misalnya 15:30'
        ],
        rule_jam_keluar:[
            value => !!value||"Mohon diisi jam keluar mengajar!!!",
            value => /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/.test(value) || 'Format jam keluar mengajar hh:mm, misalnya 15:00'
        ],
        rule_ruang_kelas:[
            value => !!value||"Mohon dipilih ruang kelas mengajar!!!"
        ],
    }),
    methods: {        
        initialize:async function () 
        {
            await this.$ajax.post('/akademik/perkuliahan/penyelenggaraanmatakuliah/pengampu',            
            {
                ta:this.$store.getters['uiadmin/getTahunAkademik'],
                prodi_id:this.prodi_id,
                semester_akademik:this.$store.getters['uiadmin/getSemesterAkademik'],
                pid:'daftarpengampu'
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                                               
                this.daftar_dosen = data.dosen;                
            });  

            await this.$ajax.get('/datamaster/ruangankelas',{
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{
                this.daftar_ruang_kelas = data.ruangan;                
            });
        },
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;                
                await this.$ajax.post('/akademik/perkuliahan/pembagiankelas/store',
                    {
                        idkelas:this.formdata.idkelas,                            
                        hari:this.formdata.hari,                            
                        jam_masuk:this.formdata.jam_masuk,
                        jam_keluar:this.formdata.jam_keluar,
                        penyelenggaraan_dosen_id:this.formdata.penyelenggaraan_dosen_id,
                        ruang_kelas_id:this.formdata.ruang_kelas_id,                            
                    },
                    {
                        headers:{
                            Authorization:this.$store.getters['auth/Token']
                        }
                    }
                ).then(()=>{                        
                    this.btnLoading=false;
                    this.$router.push('/akademik/perkuliahan/pembagiankelas/daftar')
                }).catch(()=>{
                    this.btnLoading=false;
                });
            }            
        },        
    },
    watch:{
        async dosen_id(val)
        {
            await this.$ajax.post('/akademik/perkuliahan/penyelenggaraanmatakuliah/matakuliah',            
            {
                user_id:val,
                ta:this.$store.getters['uiadmin/getTahunAkademik'],
                prodi_id:this.prodi_id,
                semester_akademik:this.$store.getters['uiadmin/getSemesterAkademik'],                
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                                               
                this.daftar_matakuliah = data.matakuliah;     
                
                this.daftar_kelas=this.$store.getters['uiadmin/getDaftarKelas'];  
            })  
        }
    },    
    components:{
        AkademikLayout,
        ModuleHeader,            
    },
}
</script>