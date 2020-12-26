<template>
    <KemahasiswaanLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                KEMAHASISWAAN 
            </template>
            <template v-slot:subtitle>
                TAHUN KEMAHASISWAAN {{tahun_akademik}}
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
                    dashboard untuk memperoleh ringkasan informasi kemahasiswaan perguruan tinggi.
                    </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter1 v-on:changeTahunAkademik="changeTahunAkademik" ref="filter1" />
        </template>
        <v-container fluid>            
            <v-row>
                <v-col cols="12">
                    <v-card outlined>
                        <v-list-item three-line>
                            <v-list-item-content>
                                <div class="overline mb-1">
                                    PROFIL MAHASISWA
                                </div>                                
                                <v-list-item-subtitle>                                    
                                    <v-autocomplete
                                        v-model="model"
                                        :items="items"
                                        :loading="isLoading"
                                        :search-input.sync="search"
                                        color="white"
                                        hide-no-data
                                        hide-selected
                                        item-text="deskripsi"
                                        item-value="user_id"
                                        label="Nomor Induk Mahasiswa"                                        
                                        prepend-icon="mdi-database-search"
                                        return-object
                                    ></v-autocomplete>
                                </v-list-item-subtitle>
                            </v-list-item-content>
                            <v-list-item-avatar
                                tile
                                size="80"
                                color="grey"
                            >
                                <v-icon>mdi-account</v-icon>
                            </v-list-item-avatar>
                        </v-list-item>  
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                :disabled="!model"
                                color="grey darken-3"
                                @click="model = null"
                            >
                                Clear
                                <v-icon right>
                                mdi-close-circle
                                </v-icon>
                            </v-btn>
                        </v-card-actions>
                    </v-card>                    
                </v-col>
            </v-row>
        </v-container>
    </KemahasiswaanLayout>
</template>
<script>
import KemahasiswaanLayout from '@/views/layouts/KemahasiswaanLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter1 from '@/components/sidebar/FilterMode1';
export default {
    name: 'Akademik',
    created ()
	{
		this.breadcrumbs = [
			{
				text:'HOME',
				disabled:false,
				href:'/dashboard/'+this.$store.getters['auth/AccessToken']
			},
			{
				text:'KEMAHASISWAAN',
				disabled:true,
				href:'#'
			}
        ];				
        this.tahun_akademik = this.$store.getters['uiadmin/getTahunAkademik'];                 
    },
    mounted()
    {
        this.initialize();
    },
    data: () => ({
        msg:0,
        datatableLoading:false,
        firstloading:true,
        breadcrumbs:[],        
        tahun_akademik:0,
        
    }),
    methods : {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
		initialize:async function()
		{	
            this.datatableLoading=true;            
            
            this.firstloading=false;            
            this.$refs.filter1.setFirstTimeLoading(this.firstloading); 

        }
    },
    watch:{
        tahun_akademik()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
    },
    components:{
        KemahasiswaanLayout,
        ModuleHeader,           
        Filter1,      
    },
}
</script>