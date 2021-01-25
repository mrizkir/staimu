<template>
    <AkademikLayout :showrightsidebar="false">
        <ModuleHeader>
            <template v-slot:icon>
                mdi-teach
            </template>
            <template v-slot:name>
                DOSEN WALI
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
                        Halaman ini berisi daftar DOSEN WALI / PENDAMPING AKADEMIK yang bertanggungjawab untuk membantu pembelajaran mahasiswa.
                </v-alert>
            </template>
        </ModuleHeader>        
        <v-container fluid>   
            <ProfilDosen :datadosen="data_dosen" url="/akademik/dosenwali" /> 
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
                        :items="daftar_mahasiswa"
                        :search="search"
                        item-key="user_id"
                        sort-by="name"
                        show-expand
                        :expanded.sync="expanded"
                        :single-expand="true"
                        @click:row="dataTableRowClicked"
                        class="elevation-1"
                        :loading="datatableLoading"
                        loading-text="Loading... Please wait"
                    >
                        <template v-slot:top>
                            <v-toolbar flat color="white">
                                <v-toolbar-title>DAFTAR MAHASISWA</v-toolbar-title>
                                <v-divider
                                    class="mx-4"
                                    inset
                                    vertical
                                ></v-divider>
                                <v-spacer></v-spacer>                                 
                            </v-toolbar>
                        </template>
                        <template v-slot:item.nidn="{ item }">
                            {{(item.nidn && item.nidn.length > 0) > 0 ? item.nidn:'N.A'}}
                        </template>
                        <template v-slot:item.is_dw="{ item }">
                            {{item.is_dw == false ? 'BUKAN':'YA'}}
                        </template>
                        <template v-slot:item.actions>                            
                            <v-tooltip bottom>             
                                <template v-slot:activator="{ on, attrs }">                                             
                                    <v-btn 
                                        v-bind="attrs"
                                        v-on="on"
                                        color="primary" 
                                        icon                                         
                                        x-small 
                                        class="ma-2" 
                                        :disabled="btnLoading"
                                        @click.stop="changeDosenWali">
                                        <v-icon>mdi-file-replace-outline</v-icon>
                                    </v-btn>     
                                </template>
                                <span>Ganti Dosen Wali</span>                                   
                            </v-tooltip>
                        </template>
                        <template v-slot:item.foto="{ item }">                            
                            <v-avatar size="30">
                                <v-img :src="$api.url+'/'+item.foto" />                                
                            </v-avatar>                                                                                                  
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
import {mapGetters} from 'vuex';
import AkademikLayout from '@/views/layouts/AkademikLayout';
import ModuleHeader from '@/components/ModuleHeader';
import ProfilDosen from '@/components/ProfilDosen';
export default {
    name: 'DosenWaliDetail',  
    created () {
        this.dosen_id = this.$route.params.dosen_id;
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.ACCESS_TOKEN
            },
            {
                text:'AKADEMIK',
                disabled:false,
                href:'/akademik'
            },
            {
                text:'DOSEN WALI',
                disabled:false,
                href:'/akademik/dosenwali'
            },
            {
                text:'DETAIL',
                disabled:true,
                href:'#'
            }
        ];
        this.initialize()
    },  
   
    data: () => ({ 
        dosen_id:null,
        data_dosen:{},
        datatableLoading:false,
        btnLoading:false,      
        //tables
        headers: [                        
            { text: '', value: 'foto',width:70, },
            { text: 'NIM', value: 'nim',width:100,sortable:true },
            { text: 'NAMA MAHASISWA', value: 'nama_mhs',width:250,sortable:true },
            { text: 'PROGRAM STUDI', value: 'nama_prodi',width:150,sortable:true },     
            { text: 'KELAS', value: 'nkelas',width:150,sortable:true },     
            { text: 'TAHUN MASUK', value: 'tahun',sortable:true },                 
            { text: 'AKSI', value: 'actions', sortable: false,width:50 },
        ],
        expanded:[],
        search:'',
        daftar_mahasiswa: [],               
    }),
    methods: {
        initialize:async function () 
        {
            this.datatableLoading=true;
            await this.$ajax.get('/system/usersdosen/biodatadiri/'+this.dosen_id,             
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token']
                    }
                },
                
            ).then(({data})=>{   
                this.data_dosen=data.biodatadiri;                                           
            });       

            await this.$ajax.get('/akademik/dosenwali/'+this.dosen_id,{
                headers: {
                    Authorization:this.TOKEN
                }
            }).then(({data})=>{               
                this.daftar_mahasiswa = data.daftar_mahasiswa;                
                this.datatableLoading=false;
            });          
            
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
        showDialogChangeDW()
        {

        },                     
        changeDosenWali ()
        {
            this.btnLoading=true;
            this.$ajax.post('/akademik/dosenwali/'+item.id,
                {
                    '_method':'PUT',
                    'user_id':'PUT',
                },
                {
                    headers:{
                        Authorization:this.TOKEN
                    }
                }
            ).then(()=>{   
                const index = this.daftar_mahasiswa.indexOf(item);
                this.daftar_mahasiswa.splice(index, 1);
                this.btnLoading=false;
            }).catch(()=>{
                this.btnLoading=false;
            });
        },        
    },
    computed: {        
        ...mapGetters('auth',{            
            ACCESS_TOKEN:'AccessToken',          
            TOKEN:'Token',                                  
        }),
    },    
    components:{
        AkademikLayout,
        ModuleHeader,
        ProfilDosen          
    },
}
</script>