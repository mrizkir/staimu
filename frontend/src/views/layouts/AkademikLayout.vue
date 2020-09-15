<template>
    <div>
        <v-system-bar app dark class="green lighten-2 white--text">
            
		</v-system-bar>	
        <v-app-bar app>
            <v-app-bar-nav-icon @click.stop="drawer = !drawer" class="grey--text"></v-app-bar-nav-icon>
            <v-toolbar-title class="headline clickable" @click.stop="$router.push('/dashboard/'+$store.getters['auth/AccessToken']).catch(err => {})">
				<span class="hidden-sm-and-down">{{APP_NAME}}</span>
			</v-toolbar-title>
            <v-spacer></v-spacer>
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
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
			<v-app-bar-nav-icon @click.stop="drawerRight = !drawerRight">
                <v-icon>mdi-menu-open</v-icon>
			</v-app-bar-nav-icon>            
        </v-app-bar>    
        <v-navigation-drawer v-model="drawer" width="300" dark class="green darken-1" :temporary="isReportPage" app>
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
                <v-list-item :to="{path:'/akademik'}" link class="yellow" color="green" v-if="CAN_ACCESS('AKADEMIK-GROUP')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-monitor-dashboard</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>BOARD AKADEMIK</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>                   
                <v-list-item link to="/akademik/dosenwali" v-if="CAN_ACCESS('SYSTEM-USERS-DOSEN-WALI_BROWSE')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-teach</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            DOSEN WALI
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/akademik/matakuliah" v-if="CAN_ACCESS('AKADEMIK-MATAKULIAH_BROWSE')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-book</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            MATAKULIAH
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-subheader>DAFTAR ULANG</v-subheader>
                <v-list-item link to="/akademik/dulang/mhsbelumpunyanim" v-if="CAN_ACCESS('AKADEMIK-DULANG-BARU_BROWSE')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-book</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            BELUM PUNYA NIM
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-list-item link to="/akademik/dulang/mahasiswabaru" v-if="CAN_ACCESS('AKADEMIK-DULANG-BARU_BROWSE')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-book</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            MAHASISWA BARU
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>                
                <v-subheader>KEMAHASISWAAN</v-subheader>
                <v-list-item link to="/akademik/kemahasiswaan/daftarmahasiswa" v-if="CAN_ACCESS('AKADEMIK-KEMAHASISWAAN-DAFTAR-MAHASISWA_BROWSE')">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-book</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>
                        <v-list-item-title>
                            DAFTAR MAHASISWA
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>              
                <v-subheader>PERKULIAHAN</v-subheader>                         
                <v-list-group group="/akademik/perkuliahan/penyelenggaraan" active-class="yellow" no-action v-if="CAN_ACCESS('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE')" color="green">
                    <template v-slot:activator>
                        <v-list-item-icon class="mr-2">
                            <v-icon>mdi-home-floor-b</v-icon>
                        </v-list-item-icon>
                        <v-list-item-content>								
                            <v-list-item-title>PENYELENGGARAAN</v-list-item-title>
                        </v-list-item-content>							
                    </template>
					<div>
						<v-list-item link v-if="CAN_ACCESS('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE')" active-class="light-green lighten-1 white--text" to="/akademik/perkuliahan/penyelenggaraan/daftar" color="white">
                            <v-list-item-icon class="mr-2">
                                <v-icon>mdi-book</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>
                                    DAFTAR
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>   						 
						<v-list-item link v-if="CAN_ACCESS('AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE')" active-class="light-green lighten-1 white--text" disabled to="/akademik/perkuliahan/penyelenggaraan/tambah">
                            <v-list-item-icon class="mr-2">
                                <v-icon>mdi-book</v-icon>
                            </v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>
                                    TAMBAH MATKUL
                                </v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>   						 
					</div>
                </v-list-group>
            </v-list>
        </v-navigation-drawer>
        <v-navigation-drawer v-model="drawerRight" width="300" app fixed right temporary>
            <v-list dense>
                <v-list-item>		
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-menu-open</v-icon>
                    </v-list-item-icon>			
                    <v-list-item-content>									
                        <v-list-item-title class="title">
                            OPTIONS
                        </v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
                <v-divider></v-divider>
                <v-list-item class="teal lighten-5 mb-5">
                    <v-list-item-icon class="mr-2">
                        <v-icon>mdi-filter</v-icon>
                    </v-list-item-icon>
                    <v-list-item-content>								
                        <v-list-item-title>FILTER</v-list-item-title>
                    </v-list-item-content>		
                </v-list-item>
                <slot name="filtersidebar"/>		                	
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
    name:'AkademikLayout',     
    created()
    {
        this.dashboard = this.$store.getters['uiadmin/getDefaultDashboard'];        
    },
    data:()=>({
        loginTime:0,
        drawer:null,
        drawerRight:null, 
        
        dashboard:null,
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