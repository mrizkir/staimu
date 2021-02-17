<template>
    <AkademikLayout :showrightsidebar="false" :temporaryleftsidebar="true">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-book-open-outline
            </template>
            <template v-slot:name>
                KONVERSI NILAI 
            </template>
            <template v-slot:subtitle>
                TAHUN PENDAFTARAN {{tahun_pendaftaran}} - {{nama_prodi}}
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
                    Halaman ini digunakan untuk mengelola konversi nilai mahasiswa pindahan/ampulan 
                </v-alert>
            </template>
        </ModuleHeader>                
        <v-container fluid v-if="data_konversi.id">                         
            <v-row class="mb-4" no-gutters>
                <v-col cols="12">
                    <v-card color="grey lighten-4">
                        <v-toolbar elevation="2"> 
                            <v-toolbar-title>DATA KONVERSI</v-toolbar-title>
                            <v-divider
                                class="mx-4"
                                inset
                                vertical
                            ></v-divider>
                            <v-spacer></v-spacer>
                            <v-icon                
                                @click.stop="$router.push('/akademik/nilai/konversi')">
                                mdi-close-thick
                            </v-icon>
                        </v-toolbar>
                        <v-card-text>
                            <v-row>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>ID KRS:</v-card-title>  
                                        <v-card-subtitle>
                                            {{data_konversi.id}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>TAHUN MATAKULIAH :</v-card-title>
                                        <v-card-subtitle>
                                            {{data_konversi.tahun}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                            </v-row>
                            <v-row>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>NIM ASAL / NIM SISTEM:</v-card-title>  
                                        <v-card-subtitle>
                                            {{data_konversi.nim_asal}} / {{data_konversi.nim==null?'N.A':data_konversi.nim}} 
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>NAMA P.T ASAL:</v-card-title>
                                        <v-card-subtitle>
                                            [{{data_konversi.kode_pt_asal}}] / {{data_konversi.nama_pt_asal}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                            </v-row>
                            <v-row>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>NAMA MAHASISWA:</v-card-title>  
                                        <v-card-subtitle>
                                            {{data_konversi.nama_mhs}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>PROGRAM STUDI ASAL:</v-card-title>  
                                        <v-card-subtitle>
                                            [{{data_konversi.kode_ps_asal}}] / {{data_konversi.nama_ps_asal}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                            </v-row>
                            <v-row>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>ALAMAT:</v-card-title>  
                                        <v-card-subtitle>
                                            {{data_konversi.alamat}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>JUMLAH YANG TERKONVERSI:</v-card-title>  
                                        <v-card-subtitle>
                                            Matakuliah : {{totalMatkul}} / SKS: {{totalSKS}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                            </v-row>
                            <v-row>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>NO. TELEPON:</v-card-title>  
                                        <v-card-subtitle>
                                            {{data_konversi.no_telp}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                                <v-col xs="12" sm="12" md="6">
                                    <v-card flat>
                                        <v-card-title>CREATED/UPDATED:</v-card-title>  
                                        <v-card-subtitle>
                                            {{$date(data_konversi.created_at).format('DD/MM/YYYY HH:mm')}} / {{$date(data_konversi.updated_at).format('DD/MM/YYYY HH:mm')}}
                                        </v-card-subtitle>
                                    </v-card>
                                </v-col>
                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly || $vuetify.breakpoint.smOnly"/>
                            </v-row>                            
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
                        :disable-pagination="true"
                        :hide-default-footer="true"                        
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait">
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>KURIKULUM MATAKULIAH T.A {{tahun_pendaftaran}}</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>                                  
                            </v-toolbar>
                        </template>     
                        <template v-slot:item.kmatkul_asal="{item}">                                
                            {{item.kmatkul_asal==null ? 'N.A':item.kmatkul_asal}}
                        </template>                                                                                
                        <template v-slot:item.matkul_asal="{item}">                                
                            {{item.matkul_asal==null ? 'N.A':item.matkul_asal}}
                        </template>                                                                                
                        <template v-slot:item.sks_asal="{item}">                                
                            {{item.sks_asal==null ? 'N.A':item.sks_asal}}
                        </template>                                                                  
                        <template v-slot:item.n_kual="{item}">                                
                            {{item.n_kual==null ? 'N.A':item.n_kual}}
                        </template>                                                                                                                                                                      
                        <template v-slot:no-data>
                            Data belum tersedia
                        </template>   
                        <template v-slot:body.append v-if="datatable.length > 0">
                            <tr class="grey lighten-4 font-weight-black">
                                <td class="text-right" colspan="2">TOTAL SKS</td>
                                <td colspan="6">{{totalSKS}}</td>                                 
                            </tr>
                            <tr class="grey lighten-4 font-weight-black">
                                <td class="text-right" colspan="2">TOTAL MATAKULIAH</td>
                                <td colspan="6">{{totalMatkul}}</td>                                 
                            </tr>
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>            
        </v-container>        
        <v-dialog v-model="dialogprintpdf" max-width="500px" persistent>                
            <v-card>
                <v-card-title>
                    <span class="headline">Print to PDF</span>
                </v-card-title>
                <v-card-text>
                    <v-btn
                        color="green"
                        text
                        :href="$api.url+'/'+file_pdf">                            
                        Download
                    </v-btn>                           
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click.stop="closedialogprintpdf">CLOSE</v-btn>                            
                </v-card-actions>
            </v-card>            
        </v-dialog>
    </AkademikLayout>
</template>
<script>
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name: 'NilaiKonversiDetail',
    created () {
        this.nilai_konversi_id=this.$route.params.nilai_konversi_id;        
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
                text:'NILAI',
                disabled:false,
                href:'#'
            },            
            {
                text:'KONVERSI MAHASISWA PINDAHAN/AMPULAN',
                disabled:false,
                href:'/akademik/nilai/konversi'
            },
            {
                text:'DETAIL',
                disabled:true,
                href:'#'
            }
        ];
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_pendaftaran=this.$store.getters['uiadmin/getTahunPendaftaran'];                
        this.initialize()
    },  
    data: () => ({ 
        nilai_konversi_id:null,        
        prodi_id:null,
        nama_prodi:null,
        tahun_pendaftaran:null,

        btnLoading:false,
        btnLoadingTable:false,
        datatableLoading:false,        
        datatable:[],      
        headers: [            
            { text: 'KODE', value: 'kmatkul', sortable:false, width:100  },               
            { text: 'NAMA', value: 'nmatkul', sortable:false, width:250  },               
            { text: 'SKS', value: 'sks',sortable:false, width:70 },                           
            { text: 'SMT', value: 'semester',sortable:true,width:70, },                           
            { text: 'KODE MATKUL ASAL', value: 'kmatkul_asal',sortable:false,width:120 },                           
            { text: 'MATAKULIAH ASAL', value: 'matkul_asal',sortable:false,width:170 },                           
            { text: 'SKS ASAL', value: 'sks_asal',sortable:false,width:70},                           
            { text: 'NILAI', value: 'n_kual',sortable:false,width:70},                                       
        ],  
        search:'', 

        dialogprintpdf:false,
        file_pdf:null,

        form_valid:true,   
        daftar_jenjang:[],                        
        data_konversi:{
            'id':null,
            'user_id':'',
            'nim':'',
            'nama_mhs':'',
            'alamat':'', 
            'no_telp':'',         
            'nim_asal':'', 
            'kode_jenjang':'', 
            'kode_pt_asal':'',
            'nama_pt_asal':'',
            'kode_ps_asal':'',
            'nama_ps_asal':'',
            'tahun':'',
            
            'kjur':'',
            'perpanjangan':'',   
        },        
        rule_nim_asal:[
            value => !!value||"Mohon di isi nim mahasiswa pindahan/ampulan dengan  nim dari perguruan tinggi asal !!!",              
        ],
        rule_nama_mhs:[
            value => !!value||"Mohon di isi nama mahasiswa pindahan/ampulan dari perguruan tinggi asal !!!", 
            value => /^[A-Za-z\s]*$/.test(value) || 'Nama mahasiswa pindahan/ampulan hanya boleh string dan spasi',                
        ],
        rule_alamat:[
            value => !!value||"Mohon di isi alamat mahasiswa pindahan/ampulan !!!",              
        ],
        rule_telepon:[
            value => !!value||"Mohon di isi nomor hp mahasiswa pindahan/ampulan !!!",          
            value => /^\+[1-9]{1}[0-9]{1,14}$/.test(value) || 'Nomor HP/Telepon hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388',    
        ],       
        rule_email:[
            value => !!value||"Mohon di isi email mahasiswa pindahan/ampulan !!!",          
            value => /.+@.+\..+/.test(value) || 'Format E-mail mohon di isi dengan benar',
        ],       
        rule_kode_pt_asal:[
            value => !!value||"Mohon di isi kode perguruan tinggi asal !!!",      
            value => /^[0-9]+$/.test(value) || 'Kode perguruan tinggi asal hanya boleh angka',        
        ],
        rule_nama_pt_asal:[
            value => !!value||"Mohon di isi nama perguruan tinggi asal !!!",              
        ],
        rule_kode_jenjang:[
            value => !!value||"Mohon dipilih Jenjang Studi dari perguruan tinggi asal !!!",              
        ],
        rule_kode_ps_asal:[
            value => !!value||"Mohon di isi kode program studi dari perguruan tinggi asal !!!",        
            value => /^[0-9]+$/.test(value) || 'Kode program studi asal hanya boleh angka',              
        ],
        rule_nama_ps_asal:[
            value => !!value||"Mohon di isi nama program studi dari tinggi asal !!!",              
        ],
    }),
    methods: {        
        initialize:async function () 
        {      
            this.datatableLoading=true;
            await this.$ajax.get('/akademik/nilai/konversi/'+this.nilai_konversi_id,            
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{               
                this.datatable = data.nilai_konversi;
                this.data_konversi = data.data_konversi;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });         
            await this.$ajax.get('/datamaster/programstudi/jenjangstudi').then(({data})=>{
                this.daftar_jenjang=data.jenjangstudi;
            }); 
        },   
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;  

                var daftar_nilai=[];
                this.datatable.forEach(item => {
                    if (item.kmatkul_asal && item.matkul_asal && item.sks_asal && item.n_kual)
                    {
                        daftar_nilai.push({
                            matkul_id:item.id,
                            kmatkul_asal:item.kmatkul_asal,
                            matkul_asal:item.matkul_asal,
                            sks_asal:item.sks_asal,
                            n_kual:item.n_kual,     
                        });
                    }
                });

                await this.$ajax.post('/akademik/nilai/konversi/'+this.nilai_konversi_id,
                    {
                        _method:'put',
                        nim_asal:this.data_konversi.nim_asal,                            
                        nama_mhs:this.data_konversi.nama_mhs,                            
                        alamat:this.data_konversi.alamat,   
                        no_telp:this.data_konversi.no_telp,                                                        
                        email:this.data_konversi.email,                                                        
                        kode_jenjang:this.data_konversi.kode_jenjang,                                                        
                        kode_pt_asal:this.data_konversi.kode_pt_asal,                                                                                                             
                        nama_pt_asal:this.data_konversi.nama_pt_asal,                                                                                                             
                        kode_ps_asal:this.data_konversi.kode_ps_asal,                                                                                                             
                        nama_ps_asal:this.data_konversi.nama_ps_asal,                                                                                                             
                        tahun:this.tahun_pendaftaran,                                                                                                             
                        kjur:this.prodi_id,  
                        daftar_nilai:JSON.stringify(Object.assign({},daftar_nilai)),                    
                    },
                    {
                        headers:{
                            Authorization:this.$store.getters['auth/Token']
                        }
                    }
                ).then(()=>{   
                    this.$router.go();        
                    this.btnLoading=false;
                }).catch(()=>{
                    this.btnLoading=false;
                });                
            }
        },  
        async printpdf2(item)
        {
            this.btnLoading=true;
            await this.$ajax.get('/akademik/nilai/transkripkurikulum/printpdf2/'+item.user_id,                
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    },
                    
                }
            ).then(({data})=>{                              
                this.file_pdf=data.pdf_file;
                this.dialogprintpdf=true;
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });                 
        },
        closedialogprintpdf () {                  
            setTimeout(() => {
                this.file_pdf=null;
                this.dialogprintpdf = false;      
                }, 300
            );
        }, 
    },
    computed:{
        totalMatkul()
        {
            var jumlah_matkul=0;
            this.datatable.forEach(item => {
                if (item.kmatkul_asal && item.matkul_asal && item.sks_asal && item.n_kual)
                {
                    jumlah_matkul+=1;
                }
            });
            return jumlah_matkul;
        },
        totalSKS()
        {
            var jumlah_sks=0;
            this.datatable.forEach(item => {
                if (item.kmatkul_asal && item.matkul_asal && item.sks_asal && item.n_kual)
                {
                    jumlah_sks+=parseInt(item.sks);
                }
            });
            return jumlah_sks;
        },
    },
    components:{
        AkademikLayout,
        ModuleHeader,            
    },
}
</script>