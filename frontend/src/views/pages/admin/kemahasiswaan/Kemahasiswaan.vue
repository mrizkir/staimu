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
                                        v-model="nim"
                                        :items="items"
                                        :loading="isLoading"
                                        :search-input.sync="search"                                        
                                        hide-no-data
                                        hide-selected
                                        item-text="Description"
                                        item-value="API"
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
                        <v-divider></v-divider>
                        <v-expand-transition>
                            <v-list v-if="nim">
                                <v-list-item
                                    v-for="(field, i) in fields"
                                    :key="i"
                                >
                                    <v-list-item-content>
                                        <v-list-item-title v-text="field.value"></v-list-item-title>
                                        <v-list-item-subtitle v-text="field.key"></v-list-item-subtitle>
                                    </v-list-item-content>
                                </v-list-item>
                            </v-list>
                        </v-expand-transition>  
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                :disabled="!nim"                                
                                @click="nim = null"
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
        firstloading:true,
        breadcrumbs:[],        
        tahun_akademik:0,
        
        //profil mahasiswa
        descriptionLimit: 60,
        entries:[],
        isLoading:false,
        nim:null,
        search:null
        
    }),
    methods : {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
		initialize:async function()
		{	
            
            this.firstloading=false;            
            this.$refs.filter1.setFirstTimeLoading(this.firstloading); 

        }
    },
    computed: {
        fields () {
            if (!this.nim) return [];
            return Object.keys(this.nim).map(key => {
                return {
                    key,
                    value: this.nim[key] || 'n/a',
                }
            })
        },
        items () {
            return this.entries.map(entry => {
                const Description = entry.Description.length > this.descriptionLimit
                ? entry.Description.slice(0, this.descriptionLimit) + '...'
                : entry.Description

                return Object.assign({}, entry, { Description })
            });
        },
    },
    watch:{
        tahun_akademik()
        {
            if (!this.firstloading)
            {
                this.initialize();
            }            
        },
        search (val) 
        {
            setTimeout(() => {
                console.log(val);    
                }, 1000
            );
            
            // // Items have already been loaded
            // if (this.items.length > 0) return

            // // Items have already been requested
            // if (this.isLoading) return

            // this.isLoading = true

            // console.log(this.search);
            // Lazily load input items
            // fetch('https://api.publicapis.org/entries')
            // .then(res => res.json())
            // .then(res => {
            //     console.log(res);
            //     const { count, entries } = res;
            //     this.count = count;
            //     this.entries = entries;
            //     // console.log(count);
            // })
            // .catch(err => {
            //     console.log(err)
            // })
            // .finally(() => (this.isLoading = false))
        },
    },
    components:{
        KemahasiswaanLayout,
        ModuleHeader,           
        Filter1,      
    },
}
</script>