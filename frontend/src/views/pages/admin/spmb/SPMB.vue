<template>
    <SPMBLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                SPMB 
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
                    dashboard untuk memperoleh ringkasan informasi seleksi penerimaan mahasiswa baru (SPMB).
                    </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter9 v-on:changeTahunPendaftaran="changeTahunPendaftaran" ref="filter9" />
        </template>
        <v-container>
            <v-col cols="12">
                <v-card>
                    <v-card-title class="headline">
                        TOTAL MAHASISWA BARU : {{total_mb}}
                    </v-card-title>
                    <v-card-text>
                        <v-row dense>                
                            <v-col xs="12" sm="6" md="3" v-for="item in daftar_prodi" v-bind:key="item.id">
                                <v-card color="#385F73" dark>
                                    <v-card-title class="headline">
                                        {{item.nama_prodi}}
                                    </v-card-title>
                                    <v-card-subtitle class="headline">
                                        Jenjang : {{item.nama_jenjang}}
                                    </v-card-subtitle>
                                    <v-card-text>
                                        {{item.jumlah}}
                                    </v-card-text>
                                </v-card>
                            </v-col>
                            <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>            
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-container>
    </SPMBLayout>
</template>
<script>
import SPMBLayout from '@/views/layouts/SPMBLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter9 from '@/components/sidebar/FilterMode9';
export default {
    name: 'SPMB',
    created ()
	{
		this.breadcrumbs = [
			{
				text:'HOME',
				disabled:false,
				href:'/dashboard/'+this.$store.getters['auth/AccessToken']
			},
			{
				text:'SPMB',
				disabled:true,
				href:'#'
			}
        ];				
        this.tahun_pendaftaran = this.$store.getters['uiadmin/getTahunPendaftaran']; 
    },
    mounted()
    {
        this.initialize();
    },
    data: () => ({
        datatableLoading:false,
        firstloading:true,
        breadcrumbs:[],        
        tahun_pendaftaran:0,
        
        //statistik
        daftar_prodi:[],
        total_mb:0,
    }),
    methods : {
        changeTahunPendaftaran (tahun)
        {
            this.tahun_pendaftaran=tahun;
        },
		initialize:async function()
		{	
            this.datatableLoading=true;            
            await this.$ajax.post('/dashboard/pmb',
            {
                TA:this.tahun_pendaftaran,                
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                            
                this.daftar_prodi = data.daftar_prodi;
                this.total_mb = data.total_mb;
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });
            this.firstloading=false;            
            this.$refs.filter9.setFirstTimeLoading(this.firstloading); 
        }
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
        SPMBLayout,
        ModuleHeader,           
        Filter9,        
    },
}
</script>