<template>
    <div>
        <v-system-bar app dark class="brown darken-2 white--text">
            
		</v-system-bar>	
        <v-app-bar app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="grey--text"></v-app-bar-nav-icon>
            <v-toolbar-title class="headline clickable" @click.stop="$router.push('/dashboard/'+$store.getters['auth/AccessToken']).catch(err => {})">
				<span class="hidden-sm-and-down">{{APP_NAME}}</span>
			</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-menu 
                :close-on-content-click="false"
                origin="center center"
                transition="scale-transition"
                :offset-y="true"
                bottom 
                left
                v-if="CAN_ACCESS('SYSTEM-SETTING-GROUP')">
                <template v-slot:activator="{on}">
                    <v-btn v-on="on" icon>
                        <v-icon>mdi-cogs</v-icon>
                    </v-btn>
                </template>
                <v-list dense>
                    <v-list-item>
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-cogs</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title class="title">
                                KONFIGURASI SISTEM
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                &nbsp;
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>
                    <v-divider/>
                    <v-list-item class="teal lighten-5">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>								
                            <v-list-item-title>PERGURUAN TINGGI</v-list-item-title>
                        </v-list-item-content>		
                    </v-list-item>
                    <v-list-item link v-if="CAN_ACCESS('SYSTEM-SETTING-IDENTITAS-DIRI')" to="/system-setting/identitasdiri">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                IDENTITAS DIRI
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>                    
                    <v-list-item class="teal lighten-5">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-account</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>								
                            <v-list-item-title>USER</v-list-item-title>
                        </v-list-item-content>		
                    </v-list-item>
                    <v-list-item link v-if="CAN_ACCESS('SYSTEM-SETTING-PERMISSIONS')" to="/system-setting/permissions">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                PERMISSIONS
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>                    
                    <v-list-item link v-if="CAN_ACCESS('SYSTEM-SETTING-ROLES')" to="/system-setting/roles">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                ROLES
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>          
                    <v-list-item class="teal lighten-5">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-server-network</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>								
                            <v-list-item-title>SERVER</v-list-item-title>
                        </v-list-item-content>		
                    </v-list-item>
                    <v-list-item link v-if="CAN_ACCESS('SYSTEM-SETTING-VARIABLES')" to="/system-setting/captcha">
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-chevron-right</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>
                            <v-list-item-title>
                                CAPTCHA
                            </v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>  
                </v-list>
            </v-menu>
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
            <v-menu 
                :close-on-content-click="true"
                origin="center center"
                transition="scale-transition"
                :offset-y="true"
                bottom 
                left>
                <template v-slot:activator="{on}">
                    <v-avatar size="30">
                        <v-img :src="photoUser" v-on="on" />
                    </v-avatar>                    
                </template>
                <v-list>
                    <v-list-item>
                        <v-list-item-avatar>
                            <v-img :src="photoUser"></v-img>
                        </v-list-item-avatar>
                        <v-list-item-content>					
                            <v-list-item-title class="title">
                                {{ATTRIBUTE_USER('username')}}
                            </v-list-item-title>
                            <v-list-item-subtitle>                                
                                {{ROLE}}
                            </v-list-item-subtitle>
                        </v-list-item-content>
                    </v-list-item>                    
                    <v-divider/>
                    <v-list-item to="/system-users/profil">
                        <v-list-item-icon class="mr-2">
							<v-icon>mdi-account</v-icon>
						</v-list-item-icon>
                        <v-list-item-title>Profil</v-list-item-title>
                    </v-list-item>
                    <v-divider/>
                    <v-list-item @click.prevent="logout">
                        <v-list-item-icon class="mr-2">
							<v-icon>mdi-power</v-icon>
						</v-list-item-icon>
                        <v-list-item-title>Logout</v-list-item-title>
                    </v-list-item>
                </v-list>
            </v-menu>			
        </v-app-bar>    
        <v-navigation-drawer v-model="drawer" width="300" dark class="brown darken-4" :temporary="isReportPage" app>
			<v-list-item>
				<v-list-item-avatar>
					<v-img :src="photoUser" @click.stop="toProfile"></v-img>
				</v-list-item-avatar>
				<v-list-item-content>					
					<v-list-item-title class="title">
						{{ATTRIBUTE_USER('username')}}
					</v-list-item-title>
					<v-list-item-subtitle>
						{{ROLE}}
					</v-list-item-subtitle>
				</v-list-item-content>
			</v-list-item>
			<v-divider></v-divider>
            <v-list expand>
                <v-list-item :to="{path:'/system-users'}" v-if="CAN_ACCESS('SYSTEM-USERS-GROUP')" link color="deep-orange darken-1" >
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>MODULE USER SISTEM</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link v-if="CAN_ACCESS('SYSTEM-USERS-PMB')" to="/system-users/pmb">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-account</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            TIM PMB
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>    
            </v-list>
        </v-navigation-drawer>        
        <v-main class="mx-4 mb-4">			
			<slot />
		</v-main>
    </div>    
</template>
<script>
import {mapGetters} from 'vuex';
export default {
    name:'DataMasterLayout',        
    data:()=>({
        loginTime:0,
        drawer:null,        
    }),       
    methods: {        
        logout ()
        {
            this.loginTime=0;
            this.$ajax.post('/auth/logout',
                {},
                {
                    headers:{
                        'Authorization': this.TOKEN,
                    }
                }
            ).then(()=> {     
                this.$store.dispatch('auth/logout');	
                this.$store.dispatch('uifront/reinit');	
                this.$store.dispatch('uiadmin/reinit');	
                this.$router.push('/');
            })
            .catch(() => {
                this.$store.dispatch('auth/logout');	
                this.$store.dispatch('uifront/reinit');	
                this.$store.dispatch('uiadmin/reinit');	
                this.$router.push('/');
            });
        },
        isBentukPT (bentuk_pt)
        {
            return this.$store.getters['uifront/getBentukPT']==bentuk_pt?true:false;
        }
	},
    computed:{
        ...mapGetters('auth',{
            AUTHENTICATED:'Authenticated',  
            ACCESS_TOKEN:'AccessToken',          
            TOKEN:'Token',          
            ROLE:'Role',
            CAN_ACCESS:'can',         
            ATTRIBUTE_USER:'AttributeUser',               
        }),
        APP_NAME ()
        {
            return process.env.VUE_APP_NAME;
        },
        photoUser()
		{
			let img=this.ATTRIBUTE_USER('foto');
			var photo;
			if (img == '')
			{
				photo = this.$api.url+'/storage/images/users/no_photo.png';	
			}
			else
			{
				photo = this.$api.url+'/'+img;	
			}
			return photo;
        },
        isReportPage ()
		{
			if (this.$route.name=='ReportFormBMurni')
			{
				return true;
			}
			else
			{
				return false;
			}
        },        
    },
    watch: {
        loginTime:{
            handler(value)
            {
                
                if (value >= 0)
                {
                    setTimeout(() => { 
                        this.loginTime=this.AUTHENTICATED==true?this.loginTime+1:-1;                                                                     
					}, 1000);
                }
                else
                {
                    this.$store.dispatch('auth/logout');
                    this.$router.replace('/login');
                }
            },
            immediate:true
        },        
    }
}
</script>