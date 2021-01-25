<template>
    <DataMasterLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-format-list-checks
            </template>
            <template v-slot:name>
                PERSYARATAN PMB
            </template>
            <template v-slot:subtitle>
                TAHUN PENDAFTARAN {{tahun_pendaftaran}}
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
                    Halaman untuk mengelola persyaratan PMB setiap tahun pendaftaran.
                </v-alert>
            </template>
        </ModuleHeader>   
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
                                <v-toolbar-title>DAFTAR PERSYARATAN</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>
                                <v-btn color="primary" dark class="mb-2 mr-2" @click.stop="showDialogCopyMatkul" v-if="$store.getters['auth/can']('DMASTER-PERSYARATAN-PMB_STORE')">SALIN PERSYARATAN PMB</v-btn>
                                <v-btn 
                                    color="primary" 
                                    dark 
                                    class="mb-2" 
                                    @click.stop="tambahItem"                                    
                                    v-if="$store.getters['auth/can']('DMASTER-PERSYARATAN-PMB_STORE')">
                                    TAMBAH
                                </v-btn>
                                <v-dialog v-model="dialogfrm" max-width="500px" persistent>                                    
                                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ formTitle }}</span>
                                            </v-card-title>
                                            <v-card-text>                                                                                                      
                                                <v-text-field 
                                                    v-model="formdata.nama_persyaratan" 
                                                    label="NAMA MATAKULIAH"
                                                    outlined
                                                    :rules="rule_nama_matakuliah">
                                                </v-text-field>                                                                                                                                                                                                
                                                
                                                <v-switch
                                                    v-model="formdata.islintas_prodi"
                                                    label="MATAKULIAH LINTAS PROGRAM STUDI">
                                                </v-switch>
                                                <v-switch
                                                    v-model="formdata.syarat_skripsi"
                                                    label="SYARAT SKRIPSI">
                                                </v-switch>
                                                <v-switch
                                                    v-model="formdata.status"
                                                    label="STATUS">
                                                </v-switch>
                                                <v-switch
                                                    v-model="formdata.update_penyelenggaraan"
                                                    label="UPDATE PENYELENGGARAAN"
                                                    v-if="editedIndex > -1">
                                                </v-switch>
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
                                <v-dialog v-model="dialogdetailitem" max-width="750px" persistent>
                                    <v-card>
                                        <v-card-title>
                                            <span class="headline">DETAIL DATA</span>
                                        </v-card-title>
                                        <v-card-text>
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>ID :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.id}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>SKS :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.sks}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>                                            
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>KODE MATAKULIAH :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.kmatkul}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                                                
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>SKS TATAP MUKA :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.sks_tatap_muka}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>                                            
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAMA MATAKULIAH :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.nama_persyaratan}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                                                
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>SKS PRAKTIKUM :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.sks_praktikum2}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>                     
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>MINIMAL NILAI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.minimal_nilai}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>                                                
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>SYARAT SKRIPSI :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.syarat_skripsi == 1 ? 'YA' : 'TIDAK'}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>                                                                                        
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="blue darken-1" text @click.stop="closedialogdetailitem">KELUAR</v-btn>
                                        </v-card-actions>
                                    </v-card>                                    
                                </v-dialog>
                                <v-dialog v-model="dialogcopymatkul" max-width="500px" persistent>     
                                    <v-form ref="frmdialogcopymatkul" v-model="form_valid" lazy-validation>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">SALIN PERSYARATAN PMB</span>
                                            </v-card-title>                                            
                                            <v-card-text>       
                                                <v-alert
                                                    class="info"
                                                    dark>
                                                    Salin persyaratan PMB dari tahun pendaftaran berikut ke tahun akademik {{tahun_pendaftaran}}
                                                </v-alert>
                                                <v-select
                                                    v-model="dari_tahun_pendaftaran"
                                                    :items="daftar_ta"                                                    
                                                    label="TAHUN AKADEMIK"
                                                    :rules="rule_dari_tahun_pendaftaran"
                                                    outlined/>                                        
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-spacer></v-spacer>
                                                    <v-btn color="blue darken-1" text @click.stop="closedialogsalinama_persyaratan">BATAL</v-btn>
                                                    <v-btn 
                                                        color="blue darken-1" 
                                                        text 
                                                        @click.stop="salinama_persyaratan" 
                                                        :loading="btnLoading"
                                                        :disabled="!form_valid||btnLoading">
                                                            SALIN
                                                    </v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-form>
                                </v-dialog>
                            </v-toolbar>
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
                                    <strong>ID:</strong>{{ item.id }}          
                                    <strong>created_at:</strong>{{ $date(item.created_at).format('DD/MM/YYYY HH:mm') }}
                                    <strong>updated_at:</strong>{{ $date(item.updated_at).format('DD/MM/YYYY HH:mm') }}
                                </v-col>                                
                            </td>
                        </template>
                        <template v-slot:body.append v-if="datatable.length > 0">
                            <tr class="grey lighten-4 font-weight-black">
                                <td class="text-right" colspan="4">TOTAL</td>
                                <td class="text-center">{{totalSKS}}</td> 
                                <td></td>
                                <td></td>
                            </tr>
                        </template>
                        <template v-slot:no-data>
                            Data belum tersedia
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <template v-slot:filtersidebar>
            <Filter9 v-on:ChangeTahunPendaftaran="ChangeTahunPendaftaran" ref="filter19" />	
        </template>
    </DataMasterLayout>
</template>
<script>
import {mapGetters} from 'vuex';
import DataMasterLayout from '@/views/layouts/DataMasterLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter9 from '@/components/sidebar/FilterMode9';
export default {
    name:'PersyaratanPMB',
    created () {
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.ACCESS_TOKEN
            },
            {
                text:'DATA MASTER',
                disabled:false,
                href:'/dmaster'
            },
            {
                text:'PERSYARATAN PMB',
                disabled:true,
                href:'#'
            }
        ];        
        this.tahun_pendaftaran=this.$store.getters['uiadmin/getTahunPendaftaran'];                
        this.initialize()
    },  
    data: () => ({ 
        firstloading:true,        
        tahun_pendaftaran:null,        

        btnLoading:false,
        datatableLoading:false,
        expanded:[],
        datatable:[],      
        headers: [
            { text: 'PROSES', value: 'proses', sortable:true,width:120  },   
            { text: 'NAMA PERSYARATAN', value: 'nama_persyaratan',sortable:true },                           
            { text: 'TA', value: 'ta',sortable:true,width:80, align:'center' },                           
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],  
        search:'',    

        //dialog
        dialogfrm:false,
        dialogdetailitem:false,
        dialogcopymatkul:false,

        //form data   
        form_valid:true, 
        daftar_ta:[],         
        dari_tahun_pendaftaran:null,          
        formdata: {
            id:'',                        
            proses:'pmb',                        
            nama_persyaratan:null,                        
            prodi_id:null, 
            ta:'',                   
        },
        formdefault: {
            id:'',                        
            proses:'pmb',                                         
            nama_persyaratan:null,                        
            prodi_id:null, 
            ta:'',                   
        },
        editedIndex: -1,

        //form rules            
        rule_kode_matkul:[
            value => !!value||"Kode Program Studi mohon untuk diisi !!!",            
        ], 
        rule_nama_matakuliah:[
            value => !!value||"Mohon Nama Program Studi untuk diisi !!!",              
        ], 
        rule_sks:[
            value => !!value||"Mohon SKS Matakuliah untuk dipilih !!!",              
        ],         
        rule_sks_tatap_muka:[
            value => !!value||"Mohon SKS Matakuliah Tatap Muka untuk dipilih !!!",              
        ],         
        rule_semester:[
            value => !!value||"Mohon Semester Matakuliah ini diselenggarakan untuk dipilih !!!",              
        ],         
        rule_minimal_nilai:[
            value => !!value||"Mohon Minimal nilai kelulusan matakuliah untuk dipilih !!!",              
        ], 
        rule_dari_tahun_pendaftaran:[
            value => !!value||"Mohon Tahun Akademik sumber data matakuliah untuk dipilih !!!",              
        ],             
    }),
    methods: {
        ChangeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },        
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.post('/datamaster/persyaratan',
            {
                TA:this.tahun_pendaftaran
            },
            {
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{               
                this.datatable = data.persyaratan;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });  
            this.firstloading=false;
            this.$refs.filter19.setFirstTimeLoading(this.firstloading); 
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
        tambahItem:async function()
        {   
            await this.$ajax.get('/akademik/groupmatakuliah',
            {
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{
                this.group_proses=data.group_proses;
            });            
            this.dialogfrm=true;
        },
        async viewItem (item) {
            this.formdata=item;      
            await this.$ajax.get('/akademik/matakuliah/'+item.id,
            {
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{
                this.formdata=data.matakuliah;
            });
            this.dialogdetailitem=true;                        
        },    
        editItem:async function (item) {            
            this.editedIndex = this.datatable.indexOf(item);            
            await this.$ajax.get('/akademik/groupmatakuliah',
            {
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{
                this.group_proses=data.group_proses;
            });  

            await this.$ajax.get('/akademik/matakuliah/'+item.id,
            {
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{
                this.formdata=data.matakuliah;
            });
            this.dialogfrm = true
        },    
        showDialogCopyMatkul()
        {
            let list_ta = this.$store.getters['uiadmin/getDaftarTA'];  
            for (var i =0; i < list_ta.length; i++)
            {
                var item = list_ta[i];                  
                if (this.tahun_pendaftaran!=item.value)
                {
                    this.daftar_ta.push({
                        value:item.value,
                        text:item.text
                    })
                }                              
            }            
            this.dialogcopymatkul=true;
        },
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
                if (this.editedIndex > -1) 
                {
                    await this.$ajax.post('/akademik/matakuliah/'+this.formdata.id,
                        {
                            '_method':'PUT',
                            id_group:this.formdata.id_group,                                                    
                            nama_group:this.formdata.nama_group,                                                    
                            group_alias:this.formdata.group_alias,                                                    
                            kmatkul:this.formdata.kmatkul,         
                            nama_persyaratan:this.formdata.nama_persyaratan, 
                            sks:this.formdata.sks, 
                            idkonsentrasi:this.formdata.idkonsentrasi, 
                            ispilihan:this.formdata.ispilihan, 
                            islintas_prodi:this.formdata.islintas_prodi, 
                            semester:this.formdata.semester, 
                            sks_tatap_muka:this.formdata.sks_tatap_muka, 
                            sks_praktikum:this.formdata.sks_praktikum, 
                            sks_praktik_lapangan:this.formdata.sks_praktik_lapangan, 
                            minimal_nilai:this.formdata.minimal_nilai,  
                            syarat_skripsi:this.formdata.syarat_skripsi,   
                            status:this.formdata.status,                             
                            ta:this.formdata.ta,                             
                            kjur:this.formdata.kjur,  
                            update_penyelenggaraan:this.formdata.update_penyelenggaraan,                                                       
                        },
                        {
                            headers:{
                                Authorization:this.TOKEN
                            }
                        }
                    ).then(()=>{   
                        this.initialize();
                        this.btnLoading=false;
                        this.closedialogfrm();                        
                    }).catch(()=>{
                        this.btnLoading=false;
                    });                 
                    
                } else {                    
                    await this.$ajax.post('/akademik/matakuliah/store',
                        {
                            id_group:this.formdata.id_group, 
                            nama_group:this.formdata.nama_group,                                                    
                            group_alias:this.formdata.group_alias,                                                                                                       
                            kmatkul:this.formdata.kmatkul,         
                            nama_persyaratan:this.formdata.nama_persyaratan, 
                            sks:this.formdata.sks, 
                            idkonsentrasi:this.formdata.idkonsentrasi, 
                            ispilihan:this.formdata.ispilihan, 
                            islintas_prodi:this.formdata.islintas_prodi, 
                            semester:this.formdata.semester, 
                            sks_tatap_muka:this.formdata.sks_tatap_muka, 
                            sks_praktikum:this.formdata.sks_praktikum, 
                            sks_praktik_lapangan:this.formdata.sks_praktik_lapangan, 
                            minimal_nilai:this.formdata.minimal_nilai,  
                            syarat_skripsi:this.formdata.syarat_skripsi,   
                            status:this.formdata.status,   
                            ta:this.tahun_pendaftaran,                             
                            kjur:this.prodi_id,                                                                                   
                        },
                        {
                            headers:{
                                Authorization:this.TOKEN
                            }
                        }
                    ).then(()=>{   
                        this.initialize();                  
                        this.btnLoading=false;
                        this.closedialogfrm();
                    }).catch(()=>{
                        this.btnLoading=false;
                    });
                }
            }
        },
        salinama_persyaratan()
        {
            if (this.$refs.frmdialogcopymatkul.validate())
            {
                this.btnLoading=true;
                this.$ajax.post('/akademik/matakuliah/salinama_persyaratan/'+this.tahun_pendaftaran,
                    {
                        dari_tahun_pendaftaran:this.dari_tahun_pendaftaran,
                        prodi_id:this.prodi_id,
                    },
                    {
                        headers:{
                            Authorization:this.TOKEN
                        }
                    }
                ).then(({data})=>{   
                    this.datatable=data.matakuliah;
                    this.btnLoading=false;
                    this.closedialogsalinama_persyaratan();
                }).catch(()=>{
                    this.btnLoading=false;
                });            
            }
        },
        deleteItem (item) {           
            this.$root.$confirm.open('Delete', 'Apakah Anda ingin menghapus matakuliah '+item.nama_persyaratan+' ?', { color: 'red' }).then((confirm) => {
                if (confirm)
                {
                    this.btnLoading=true;
                    this.$ajax.post('/akademik/matakuliah/'+item.id,
                        {
                            '_method':'DELETE',
                        },
                        {
                            headers:{
                                Authorization:this.TOKEN
                            }
                        }
                    ).then(()=>{   
                        const index = this.datatable.indexOf(item);
                        this.datatable.splice(index, 1);
                        this.btnLoading=false;
                    }).catch(()=>{
                        this.btnLoading=false;
                    });
                }                
            });
        },
        closedialogdetailitem () {
            this.dialogdetailitem = false;            
            setTimeout(() => {
                this.formdata = Object.assign({}, this.formdefault)
                this.editedIndex = -1
                }, 300
            );
        },
        closedialogfrm () {
            this.dialogfrm = false;            
            setTimeout(() => {                              
                this.$refs.frmdata.resetValidation();                                 
                this.formdata = Object.assign({}, this.formdefault);  
                this.editedIndex = -1
                }, 300
            );
        },
        closedialogsalinama_persyaratan () {                       
            this.dialogcopymatkul = false; 
            setTimeout(() => {                
                this.$refs.frmdialogcopymatkul.reset();                                 
                this.editedIndex = -1
                }, 300
            );           
        },
    },
    computed: {
        ...mapGetters('auth',{            
            ACCESS_TOKEN:'AccessToken',          
            TOKEN:'Token',                                  
        }),
        formTitle () {
            return this.editedIndex === -1 ? 'TAMBAH PERSYARATAN PMB' : 'UBAH PERSYARATAN PMB'
        },    
        totalSKS()
        {
            var total = 0;
            for (var i =0; i < this.datatable.length; i++)
            {
                var item = this.datatable[i];
                total=total+parseInt(item.sks);
            }
            return total;
        },            
    },
    watch:{
        tahun_pendaftaran()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },        
    },
    components:{
        DataMasterLayout,
        ModuleHeader,
        Filter9        
    },

}
</script>