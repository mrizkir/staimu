<template>
    <SystemUserLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-account
            </template>
            <template v-slot:name>
                USER PROFILE
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
                        berisi informasi profile user.
                </v-alert>
            </template>
        </ModuleHeader>   
        <v-container fluid>    
            <v-row class="mb-4" no-gutters>
                <v-col md="12">
                    <v-card>
                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                    <tbody>
                                        <tr>
                                            <td width="150">ID</td>
                                            <td>{{$store.getters['auth/AttributeUser']('id')}}</td>
                                            <td width="150">EMAIL</td>
                                            <td>{{$store.getters['auth/AttributeUser']('email')}}</td>
                                        </tr>
                                        <tr>
                                            <td width="150">USERNAME</td>
                                            <td>{{$store.getters['auth/AttributeUser']('username')}}</td>
                                            <td width="150">CREATED</td>
                                            <td>{{$date($store.getters['auth/AttributeUser']('created_at')).format('DD/MM/YYYY HH:mm')}}</td>
                                        </tr>
                                         <tr>
                                            <td width="150">NAMA</td>
                                            <td>{{$store.getters['auth/AttributeUser']('name')}}</td>
                                            <td width="150">UPDATED</td>
                                            <td>{{$date($store.getters['auth/AttributeUser']('updated_at')).format('DD/MM/YYYY HH:mm')}}</td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
            <v-row> 
                <v-col xs="12" sm="6" md="6">
                    <v-form ref="frmdata" v-model="form_valid" lazy-validation>
                        <v-card>
                            <v-card-title>
                                <span class="headline">GANTI PASSWORD</span>
                            </v-card-title>
                            <v-card-text>    
                                 <v-text-field 
                                    v-model="formdata.password" 
                                    label="PASSWORD BARU"
                                    :type="'password'"
                                    outlined
                                    :rules="rule_user_password">
                                </v-text-field> 
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>                                
                                <v-btn 
                                    color="blue darken-1" 
                                    text 
                                    @click.stop="save" 
                                    :loading="btnLoading"
                                    :disabled="!form_valid||btnLoading">SIMPAN</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </v-col>
            </v-row>
        </v-container>
    </SystemUserLayout>
</template>
<script>
import SystemUserLayout from '@/views/layouts/SystemUserLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name:'UsersProfile',
    created () {
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.$store.getters['auth/AccessToken']
            },
            {
                text:'SYSTEM',
                disabled:false,
                href:'#'
            },
            {
                text:'PROFILE USER',
                disabled:true,
                href:'#'
            }
        ];
    }, 
    data ()
    {
        return {
            btnLoading:false,
            datatable:[],
            avatar : null,
            //form data   
            form_valid:true,         
            formdata: {
                id:0,                        
                foto:null,  
                password: '',                       
                created_at: '',           
                updated_at: '',           
            },
            formdefault: {
                id:0,           
                foto:null,    
                password: '',                                  
                created_at: '',           
                updated_at: '',       
            },
            //form rules  
            rule_foto:[
                value => !!value||"Mohon pilih gambar !!!",  
                value =>  !value || value.size < 2000000 || 'File foto harus kurang dari 2MB.'                
            ], 
            rule_user_password:[
                value => !!value||"Mohon untuk di isi password User !!!",
                value => {
                    if (value && typeof value !== 'undefined' && value.length > 0){
                        return value.length >= 8 || 'Minimial Password 8 karaketer';
                    }
                    else
                    {
                        return true;
                    }
                }
            ],
        };
    },
    methods: {
        save()
        {
            if (this.$refs.frmdata.validate())
            {
                this.btnLoading=true;
                this.$ajax.post('/system/users/updatepassword/'+this.$store.getters['auth/AttributeUser']('id'),
                    {
                        '_method':'PUT',                        
                        password:this.formdata.password,                           
                    },
                    {
                        headers:{
                            Authorization:this.$store.getters['auth/Token']
                        }
                    }
                ).then(({data})=>{                                                                            
                    this.$refs.frmdata.reset(); 
                    this.formdata.foto=data.foto;       
                    this.formdata=this.formdefault; 
                    this.btnLoading=false;
                }).catch(()=>{
                    this.btnLoading=false;
                });                     
            }
        },
        previewImage (e)
        {
            if (typeof e === 'undefined')
            {
                this.avatar=null;
            }
            else
            {
                let reader = new FileReader();
                reader.readAsDataURL(e);
                reader.onload = img => {                    
                    this.photoUser=img.target.result;
                }
            }            
            
        },
        uploadFoto:async function () 
        {
            if (this.$refs.frmuploadfoto.validate())
            {
                if (this.formdata.foto)
                {                
                    this.btnLoading=true;
                    var formdata = new FormData();
                    formdata.append('foto',this.formdata.foto);
                    await this.$ajax.post('/setting/users/uploadfoto/'+this.$store.getters.User.id,formdata,                    
                        {
                            headers:{
                                Authorization:this.$store.getters['auth/Token'],  
                                'Content-Type': 'multipart/form-data'                      
                            }
                        }
                    ).then(({data})=>{                           
                        this.btnLoading=false;
                        this.$store.dispatch('updateFoto',data.user.foto);                        
                    }).catch(()=>{
                        this.btnLoading=false;
                    });    
                    this.$refs.frmdata.reset(); 
                }   
            }
        },
        resetFoto:async function () 
        {
            this.btnLoading=true;
            await this.$ajax.post('/setting/users/resetfoto/'+this.$store.getters.User.id,{},                    
                {
                    headers:{
                        Authorization:this.$store.getters['auth/Token'],                              
                    }
                }
            ).then(({data})=>{                           
                this.btnLoading=false;
                this.$store.dispatch('updateFoto',data.user.foto);
            }).catch(()=>{
                this.btnLoading=false;
            });    
        }
        
    },
    computed:{        
		photoUser: {
            get()
            {
                if (this.avatar==null)
                {
                    let photo = this.$api.url+'/'+this.$store.getters.User.foto;			
                    return photo;
                }
                else
                {
                   return this.avatar;
                }
                
            },
            set(val)
            {   
                this.avatar = val;
            }
		}
    },
    components:{
        SystemUserLayout,
        ModuleHeader,
    },
}
</script>