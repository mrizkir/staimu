<template>
    <KeuanganLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-monitor-dashboard
            </template>
            <template v-slot:name>
                KEUANGAN 
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
                    dashboard untuk memperoleh ringkasan informasi keuangan perguruan tinggi.
                    </v-alert>
            </template>
        </ModuleHeader>
        <template v-slot:filtersidebar>
            <Filter9 v-on:changeTahunPendaftaran="changeTahunPendaftaran" ref="filter9" />
        </template>
        <v-container fluid>
            
        </v-container>
    </KeuanganLayout>
</template>
<script>
import KeuanganLayout from '@/views/layouts/KeuanganLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter9 from '@/components/sidebar/FilterMode9';
export default {
    name: 'Keuangan',
    created ()
	{
		this.breadcrumbs = [
			{
				text:'HOME',
				disabled:false,
				href:'/dashboard/'+this.$store.getters['auth/AccessToken']
			},
			{
				text:'KEUANGAN',
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
            await this.$ajax.post('/dashboard/keuangan',
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
        KeuanganLayout,
        ModuleHeader,           
        Filter9,        
    },
}
</script>