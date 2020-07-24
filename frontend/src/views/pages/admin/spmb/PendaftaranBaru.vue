<template>
    <SPMBLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-account-plus
            </template>
            <template v-slot:name>
                PENDAFTAR 
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
                        Berisi pendaftar baru, silahkan melakukan filter tahun akademik dan program studi.
                    </v-alert>
            </template>
        </ModuleHeader>  
        <v-container>    
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
                                <v-spacer></v-spacer>
                                <v-btn 
                                    :loading="btnLoading"
                                    :disabled="btnLoading"
                                    color="warning" 
                                    class="mb-2 mr-2" 
                                    @click.stop="syncPermission" 
                                    v-if="$store.getters['auth/can']('USER_STOREPERMISSIONS')">
                                    SYNC PERMISSION
                                </v-btn>
                                <v-btn color="primary" 
                                    class="mb-2" 
                                    @click.stop="addItem">
                                        TAMBAH
                                </v-btn>
                                <v-dialog v-model="dialogfrm" max-width="500px" persistent>                                    
                                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                                        <v-card>
                                            <v-card-title>
                                                <span class="headline">{{ formTitle }}</span>
                                            </v-card-title>
                                            <v-card-subtitle>
                                                <span class="info--text">Akan tersimpan di prodi <strong>{{nama_prodi}} - {{tahun_pendaftaran}}</strong></span>
                                            </v-card-subtitle>
                                            <v-card-text>
                                                <v-text-field 
                                                    v-model="formdata.name"
                                                    label="NAMA LENGKAP" 
                                                    :rules="rule_name"
                                                    filled/>                               
                                                <v-text-field 
                                                    v-model="formdata.nomor_hp"
                                                    label="NOMOR HP (ex: +628123456789)" 
                                                    :rules="rule_nomorhp"
                                                    filled/>                               
                                                <v-text-field 
                                                    v-model="formdata.email"
                                                    label="EMAIL" 
                                                    :rules="rule_email"
                                                    filled/>                                                 
                                                <v-text-field 
                                                    v-model="formdata.username"
                                                    label="USERNAME" 
                                                    :rules="rule_username"
                                                    filled />   
                                                <v-text-field 
                                                    v-model="formdata.password"
                                                    label="PASSWORD" 
                                                    type="password"                                                                             
                                                    filled 
                                                    v-if="editedIndex>-1" /> 
                                                <v-text-field 
                                                    v-model="formdata.password"
                                                    label="PASSWORD" 
                                                    type="password"         
                                                    :rules="rule_password"                
                                                    filled 
                                                    v-else /> 
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
                                <v-dialog v-model="dialogdetailitem" max-width="500px" persistent>
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
                                                        <v-card-title>CREATED :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{$date(formdata.created_at).format('DD/MM/YYYY HH:mm')}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                            </v-row>
                                            <v-row no-gutters>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>NAME :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{formdata.name}}
                                                        </v-card-subtitle>
                                                    </v-card>
                                                </v-col>
                                                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                                                <v-col xs="12" sm="6" md="6">
                                                    <v-card flat>
                                                        <v-card-title>UPDATED :</v-card-title>
                                                        <v-card-subtitle>
                                                            {{$date(formdata.updated_at).format('DD/MM/YYYY HH:mm')}}
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
                            </v-toolbar>
                        </template>
                        <template v-slot:item.actions="{ item }">
                            <v-icon
                                small
                                class="mr-2"
                                :loading="btnLoading"
                                :disabled="btnLoading"
                                @click.stop="viewItem(item)"
                            >
                                mdi-eye
                            </v-icon>
                            <v-icon
                                small
                                class="mr-2"
                                :loading="btnLoading"
                                :disabled="btnLoading"
                                @click.stop="editItem(item)"
                            >
                                mdi-pencil
                            </v-icon>
                            <v-icon
                                small
                                :loading="btnLoading"
                                :disabled="btnLoading"
                                @click.stop="deleteItem(item)"
                            >
                                mdi-delete
                            </v-icon>
                        </template>
                        <template v-slot:item.foto="{ item }">    
                            <v-badge
                                bordered
                                :color="badgeColor(item)"
                                :icon="badgeIcon(item)"
                                overlap>                
                                <v-avatar size="30">                                        
                                    <v-img :src="$api.url+'/'+item.foto" />                                                                     
                                </v-avatar>                                                                                                  
                            </v-badge>
                        </template>
                        <template v-slot:item.created_at="{ item }">                            
                            {{$date(item.created_at).format('DD/MM/YYYY HH:mm')}}
                        </template>
                        <template v-slot:expanded-item="{ headers, item }">
                            <td colspan="5">
                                    <strong>ID:</strong>{{ item.id }}
                                    <strong>Username:</strong>{{ item.username }}
                                    <strong>created_at:</strong>{{ $date(item.created_at).format('DD/MM/YYYY HH:mm') }}
                                    <strong>updated_at:</strong>{{ $date(item.updated_at).format('DD/MM/YYYY HH:mm') }}
                            </td>
                            <td colspan="2" class="text-right">
                                <v-btn 
                                    icon 
                                    color="warning" 
                                    title="aktifkan"
                                    :loading="btnLoading"
                                    :disabled="btnLoading" 
                                    @click.stop="aktifkan(item.id)"
                                    v-if="item.active==0">
                                    <v-icon>mdi-email-check</v-icon>
                                </v-btn>
                            </td>
                        </template>
                        <template v-slot:no-data>
                            Data belum tersedia
                        </template>
                    </v-data-table>
                </v-col>
            </v-row>
        </v-container>
        <template v-slot:filtersidebar>
            <Filter7 v-on:changeTahunPendaftaran="changeTahunPendaftaran" v-on:changeProdi="changeProdi" ref="filter7" />	
        </template>
    </SPMBLayout>
</template>
<script>
import SPMBLayout from '@/views/layouts/SPMBLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter7 from '@/components/sidebar/FilterMode7';
export default {
    name: 'PendaftaranBaru',  
    created()
    {
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
                text:'PENDAFTAR BARU',
                disabled:true,
                href:'#'
            }
        ];   
        let prodi_id=this.$store.getters['uiadmin/getProdiID'];
        this.prodi_id=prodi_id;
        this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](prodi_id);
        this.tahun_pendaftaran=this.$store.getters['uiadmin/getTahunPendaftaran'];        
        this.initialize();
    },
    data: () => ({ 
        firstloading:true,
        prodi_id:null,
        tahun_pendaftaran:null,
        nama_prodi:null,
        
        breadcrumbs:[],
        datatableLoading:false,
        btnLoading:false,    
        btnLoadingFakultas:false,
                  
        //tables
        headers: [                        
            { text: '', value: 'foto', width:70 },            
            { text: 'NAMA MAHASISWA', value: 'name',width:350,sortable:true },
            { text: 'EMAIL', value: 'email',sortable:true },     
            { text: 'NOMOR HP', value: 'nomor_hp',sortable:true },     
            { text: 'TGL.DAFTAR', value: 'created_at',sortable:true,width:150 },     
            { text: 'AKSI', value: 'actions', sortable: false,width:100 },
        ],
        expanded:[],
        search:'',
        datatable:[],

        //dialog
        dialogfrm:false,
        dialogdetailitem:false,
        
        //form data   
        form_valid:true,                 
        formdata: {
            name:'',
            email:'',            
            nomor_hp:'',
            username:'',
            password:'',       
            created_at: '',           
            updated_at: '',     
        },     
        formdefault: {
            name:'',
            email:'',            
            nomor_hp:'',
            username:'',
            password:'',
            created_at: '',           
            updated_at: '',              
        },    
        editedIndex: -1,

        rule_name:[
            value => !!value||"Nama Mahasiswa mohon untuk diisi !!!",
            value => /^[A-Za-z\s\\,\\.]*$/.test(value) || 'Nama Mahasiswa hanya boleh string dan spasi',
        ], 
        rule_nomorhp:[
            value => !!value||"Nomor HP mohon untuk diisi !!!",
            value => /^\+[1-9]{1}[0-9]{1,14}$/.test(value) || 'Nomor HP hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388',
        ], 
        rule_email:[
            value => !!value||"Email mohon untuk diisi !!!",
            v => /.+@.+\..+/.test(v) || 'Format E-mail mohon di isi dengan benar',
        ],        
        rule_username:[
            value => !!value||"Username mohon untuk diisi !!!"
        ], 
        rule_password:[
            value => !!value||"Password mohon untuk diisi !!!"
        ], 
    }),
    methods: {
        changeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },
        changeProdi (id)
        {
            this.prodi_id=id;
        },
        initialize:async function () 
        {
            this.datatableLoading=true;            
            await this.$ajax.post('/spmb/pmb',
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
        },
        badgeColor(item)
        {
            return item.active == 1 ? 'success':'error'
        },
        badgeIcon(item)
        {
            return item.active == 1 ? 'mdi-check-bold':'mdi-close-thick'
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
        aktifkan(id)
        {
            this.btnLoading=true;
            this.$ajax.post('/kemahasiswaan/updatestatus/'+id,
                {
                    'active':1
                },
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    }
                }
            ).then(()=>{   
                this.initialize();
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });
        },
        syncPermission:async function ()
        {
            this.btnLoading=true;
            await this.$ajax.post('/system/users/syncallpermissions',
                {
                    role_name:'mahasiswabaru',
                    TA:this.tahun_pendaftaran,                    
                    prodi_id:this.prodi_id                     
                },
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    }
                }
            ).then(()=>{                   
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });     
        },
        addItem ()
        {
            this.dialogfrm = true;                       
        },
        save:async function () {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
                if (this.editedIndex > -1) 
                {
                    await this.$ajax.post('/spmb/pmb/updatependaftar/'+this.formdata.id,
                        {
                            '_method':'PUT',
                            name:this.formdata.name,
                            email:this.formdata.email,                    
                            nomor_hp:this.formdata.nomor_hp,
                            username:this.formdata.username,                                                                  
                            password:this.formdata.password,                     
                        },
                        {
                            headers:{
                                Authorization:this.$store.getters['auth/Token']
                            }
                        }
                    ).then(({data})=>{   
                        Object.assign(this.datatable[this.editedIndex], data.pendaftar);
                        this.closedialogfrm();
                        this.btnLoading=false;
                    }).catch(()=>{
                        this.btnLoading=false;
                    });                 
                    
                } else {
                    await this.$ajax.post('/spmb/pmb/storependaftar',
                        {
                            name:this.formdata.name,
                            email:this.formdata.email,                    
                            nomor_hp:this.formdata.nomor_hp,
                            username:this.formdata.username,                                      
                            prodi_id:this.prodi_id,
                            password:this.formdata.password,                            
                        },
                        {
                            headers:{
                                Authorization:this.$store.getters['auth/Token']
                            }
                        }
                    ).then(({data})=>{                           
                        this.datatable.push(data.pendaftar);
                        this.closedialogfrm();
                        this.btnLoading=false;
                    }).catch(()=>{
                        this.btnLoading=false;
                    });
                }
            }
        },
        viewItem (item) {           
            this.formdata=item;      
            this.dialogdetailitem=true;
        },
        editItem (item) {
            this.editedIndex = this.datatable.indexOf(item);
            this.formdata = Object.assign({}, item);
            this.dialogfrm = true;
        },   
        deleteItem (item) {           
            this.$root.$confirm.open('Delete', 'Apakah Anda ingin menghapus MAHASISWA BARU '+item.name+' ?', { color: 'red' }).then((confirm) => {
                if (confirm)
                {
                    this.btnLoading=true;
                    this.$ajax.post('/spmb/pmb/'+item.id,
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
                this.formdata = Object.assign({}, this.formdefault);                
                this.editedIndex = -1
                this.$refs.frmdata.reset(); 
                }, 300
            );
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
        prodi_id(val)
        {
            if (!this.firstloading)
            {
                this.nama_prodi=this.$store.getters['uiadmin/getProdiName'](val);
                this.initialize();
            }            
        },        
    },
    computed: {        
        formTitle () {
            return this.editedIndex === -1 ? 'TAMBAH DATA' : 'UBAH DATA'
        },        
    },
    
    components:{
        SPMBLayout,
        ModuleHeader,    
        Filter7    
    },
}
</script>