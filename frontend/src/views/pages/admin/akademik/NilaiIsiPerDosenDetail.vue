<template>
    <AkademikLayout :showrightsidebar="false">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                ISI NILAI PER KELAS
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
                    Halaman untuk melakukan pengisian nilai berdasarkan kelas mahasiswa yang telah dibentuk pada pembagian kelas.
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid v-if="data_kelas_mhs">        
            <v-row>
                <v-col cols="12">                            
                    <DataKelasMHS :datakelas="data_kelas_mhs" />
                </v-col>
            </v-row>            
            <v-row>                 
                <v-col cols="12">                     
                    <v-alert type="info">
                        Catatan: Pilihlah mahasiswa yang di isi nilainya. Untuk meningkatkan performance bila jumlah peserta lebih dari 10; maka disarankan mengisi nilai per 10 mahasiswa.
                    </v-alert>
                </v-col>
                <v-col cols="12">                     
                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                        <v-data-table
                            v-model="daftar_nilai"
                            :headers="headers_peserta"
                            :items="datatable_peserta"                        
                            item-key="id"  
                            show-select                                              
                            :disable-pagination="true"
                            :hide-default-footer="true"                        
                            class="elevation-1"
                            :loading="datatableLoading"
                            loading-text="Loading... Please wait"
                            dense>
                            <template v-slot:top>
                                <v-toolbar flat color="white">
                                    <v-toolbar-title>DAFTAR PESERTA</v-toolbar-title>
                                    <v-divider
                                        class="mx-4"
                                        inset
                                        vertical
                                    ></v-divider>
                                    <v-spacer></v-spacer>                                
                                </v-toolbar>
                            </template>                        
                            <template v-slot:item.idkelas="{item}">
                                {{$store.getters['uiadmin/getNamaKelas'](item.idkelas)}}
                            </template>
                            <template v-slot:item.kjur="{item}">
                                {{$store.getters['uiadmin/getProdiName'](item.kjur)}}
                            </template>             
                            <template v-slot:item.nilai_absen="props"> 
                                <v-numeric                
                                    @input="updateNKuan(props)"
                                    v-model="props.item.nilai_absen"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_absen != null">{{props.item.nilai_absen}}</v-chip>        
                            </template>          
                            <template v-slot:item.nilai_quiz="props"> 
                                <v-numeric               
                                    @input="updateNKuan(props)" 
                                    v-model="props.item.nilai_quiz"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_quiz != null">{{props.item.nilai_quiz}}</v-chip>        
                            </template>                        
                            <template v-slot:item.nilai_tugas_individu="props"> 
                                <v-numeric                
                                    @input="updateNKuan(props)"
                                    v-model="props.item.nilai_tugas_individu"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_tugas_individu != null">{{props.item.nilai_tugas_individu}}</v-chip>        
                            </template>                        
                            <template v-slot:item.nilai_tugas_kelompok="props"> 
                                <v-numeric            
                                    @input="updateNKuan(props)"    
                                    v-model="props.item.nilai_tugas_kelompok"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_tugas_kelompok != null">{{props.item.nilai_tugas_kelompok}}</v-chip>        
                            </template>                        
                            <template v-slot:item.nilai_uts="props"> 
                                <v-numeric                
                                    @input="updateNKuan(props)"
                                    v-model="props.item.nilai_uts"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_uts != null">{{props.item.nilai_uts}}</v-chip>        
                            </template>                        
                            <template v-slot:item.nilai_uas="props"> 
                                <v-numeric                
                                    @input="updateNKuan(props)"
                                    v-model="props.item.nilai_uas"
                                    text
                                    :min="0"
                                    :max="100"
                                    locale="en-US"
                                    :useGrouping="false"
                                    precision="2"
                                    dense
                                    :useCalculator="false"
                                    :calcIcon="null"
                                    style="width:65px">
                                </v-numeric>                        
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.nilai_uas != null">{{props.item.nilai_uas}}</v-chip>        
                            </template>                        
                            <template v-slot:item.n_kuan="props">                                                     
                                <v-chip color="primary" class="ma-2" outlined label v-if="props.item.n_kuan != null">{{props.item.n_kuan}}</v-chip>        
                            </template>                        
                            <template v-slot:item.n_kual="props">                                
                                <v-select 
                                    :items="skala_nilai" 
                                    v-model="props.item.n_kual"
                                    style="width:65px"
                                    dense>
                               </v-select>
                            </template>  
                            <template v-slot:body.append v-if="datatable_peserta.length > 0">
                                <tr>
                                    <td class="text-right" colspan="12">
                                        <v-btn 
                                            class="primary mt-2 mb-2"                                 
                                            @click.stop="save" 
                                            :loading="btnLoading"
                                            :disabled="btnLoading">
                                                SIMPAN
                                        </v-btn>
                                    </td>                                     
                                </tr>                                
                            </template>                     
                            <template v-slot:no-data>
                                Data belum tersedia
                            </template>   
                        </v-data-table>                                            
                    </v-form>
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
    name: 'NilaiIsiPerKelasMHSDetail',
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
                text:'ISI NILAI',
                disabled:false,
                href:'#'
            },
            {
                text:'PER KELAS MAHASISWA',
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

        btnLoadingTable:false,
        datatableLoading:false,
        btnLoading:false,  
        
        datatable:[],            
        datatable_peserta:[],                 
        headers_peserta: [
            { text: 'NIM', value: 'nim', sortable:false,width:100  },   
            { text: 'NAMA', value: 'nama_mhs', sortable:false,width:250   },   
            { text: 'NILAI ABSENSI', value: 'nilai_absen', sortable:false,width:100   },   
            { text: 'NILAI QUIZ', value: 'nilai_quiz', sortable:false,width:100   },   
            { text: 'NILAI TUGAS INDIVIDU', value: 'nilai_tugas_individu', sortable:false,width:100   },   
            { text: 'NILAI TUGAS KELOMPOK', value: 'nilai_tugas_kelompok', sortable:false,width:100   },               
            { text: 'NILAI UTS', value: 'nilai_uts', sortable:false,width:100   },                           
            { text: 'NILAI UAS', value: 'nilai_uas', sortable:false,width:100  },                                                   
            { text: 'NILAI ANGKA (0 s.d 100)', value: 'n_kuan', sortable:false,width:100 },                                                   
            { text: 'NILAI HURUP', value: 'n_kual', sortable:false,width:100 },                                                   
        ],                

        //formdata
        form_valid:true, 
        daftar_nilai:[],        
        skala_nilai:[
            'A',
            'A-',
            'A/B',
            'B+',
            'B-',
            'B/C',
            'C+',
            'C-',
            'C/D',
            'D+',
            'D',
            'E'
        ]       
        
    }),
    methods: {        
        initialize:async function () 
        {
            await this.$ajax.get('/akademik/perkuliahan/pembagiankelas/'+this.kelas_mhs_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{           
                this.data_kelas_mhs=data.pembagiankelas;                                         
            });
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/nilai/matakuliah/pesertakelas/'+this.kelas_mhs_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                                                                                 
                this.datatableLoading=false;
                this.datatable_peserta=data.peserta;   
            })              
        },        
        async fetchPeserta()
        {
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/perkuliahan/pembagiankelas/peserta/'+this.kelas_mhs_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                                                      
                this.datatable_peserta=data.peserta;                                
                this.datatableLoading=false;
            })   
        },      
        updateNKuan(props)
        {
            var nilai_absen=0;
            if (props.item.nilai_absen>0)
            {
                nilai_absen=0.10*props.item.nilai_absen;
            }
            
            var nilai_quiz=0;
            if (props.item.nilai_quiz>0)
            {
                nilai_quiz=0.20*props.item.nilai_quiz;
            }
            
            var nilai_tugas_individu=0;
            if (props.item.nilai_tugas_individu>0)
            {
                nilai_tugas_individu=0.15*props.item.nilai_tugas_individu;
            }
            
            var nilai_tugas_kelompok=0;
            if (props.item.nilai_tugas_kelompok>0)
            {
                nilai_tugas_kelompok=0.15*props.item.nilai_tugas_kelompok;
            }
            
            var nilai_uts=0;
            if (props.item.nilai_uts>0)
            {
                nilai_uts=0.20*props.item.nilai_uts;
            }
            var nilai_uas=0;
            if (props.item.nilai_uas>0)
            {
                nilai_uas=0.20*props.item.nilai_uas;
            }
            
            props.item.n_kuan=(nilai_absen+nilai_quiz+nilai_tugas_individu+nilai_tugas_kelompok+nilai_uts+nilai_uas).toFixed(2);
        },    
        async save()
        {
            this.btnLoadingTable=true;
            var daftar_nilai=[];

            this.datatable_peserta.forEach(item => {
                daftar_nilai.push({
                    krsmatkul_id:item.id,
                    n_kuan:item.n_kuan,
                    n_kual:item.n_kual
                });
            });         
            await this.$ajax.post('/akademik/nilai/matakuliah/perdosen/storeperdosen',
                {
                    kelas_mhs_id:this.kelas_mhs_id,
                    daftar_nilai:JSON.stringify(Object.assign({},daftar_nilai)),                    
                },
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    }
                }
            ).then(()=>{                   
                // this.$router.go();
            }).catch(()=>{
                this.btnLoadingTable=false;
            });
            
        }      
    },
    computed:{
        
    },  
    components:{
        AkademikLayout,
        ModuleHeader,     
        DataKelasMHS       
    },
}
</script>