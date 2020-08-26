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
                TAHUN AKADEMIK {{tahun_akademik}}
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
            <Filter1 v-on:changeTahunAkademik="changeTahunAkademik" ref="filter1" />
        </template>
        <v-container fluid>
            <v-row dense>
                <v-col xs="12" sm="4" md="3">
                    <v-card                         
                        class="clickable green darken-1"
                        color="#385F73" 
                        @click.native="$router.push('/spmb/pendaftaranbaru')"
                        dark>
                        <v-card-title class="headline">
                            TOTAL TRANSAKSI
                        </v-card-title>    
                        <v-card-subtitle>
                            Total transaksi keseluruhan
                        </v-card-subtitle>
                        <v-card-text>
                            {{total_transaction|formatUang}}
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
                <v-col xs="12" sm="4" md="3">
                    <v-card                         
                        class="clickable green darken-1"
                        color="#385F73" 
                        @click.native="$router.push('/spmb/pendaftaranbaru')"
                        dark>
                        <v-card-title class="headline">
                            TRANSAKSI PAID
                        </v-card-title>    
                        <v-card-subtitle>
                            Total transaksi dengan status PAID
                        </v-card-subtitle>
                        <v-card-text>
                            {{total_transaction_paid|formatUang}}
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
                <v-col xs="12" sm="4" md="3">
                    <v-card                         
                        class="clickable green darken-1"
                        color="#385F73" 
                        @click.native="$router.push('/spmb/pendaftaranbaru')"
                        dark>
                        <v-card-title class="headline">
                            TRANSAKSI UNPAID
                        </v-card-title>    
                        <v-card-subtitle>
                            Total transaksi dengan status UNPAID
                        </v-card-subtitle>
                        <v-card-text>
                            {{total_transaction_unpaid|formatUang}}
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
                <v-col xs="12" sm="4" md="3">
                    <v-card                         
                        class="clickable green darken-1"
                        color="#385F73" 
                        @click.native="$router.push('/spmb/pendaftaranbaru')"
                        dark>
                        <v-card-title class="headline">
                            TRANSAKSI CANCELLED
                        </v-card-title>    
                        <v-card-subtitle>
                            Total transaksi dengan status CANCELLED
                        </v-card-subtitle>
                        <v-card-text>
                            {{total_transaction_cancelled|formatUang}}
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
            </v-row>
            <v-row>
                <v-col xs="12" sm="12" md="6">
                    <v-card class="mb-3">
                        <v-card-title>
                            Semester Ganjil
                        </v-card-title>
                        <v-card-subtitle>
                            Jumlah yang muncul berdasarkan transaksi yang statusnya PAID
                        </v-card-subtitle>
                        <v-card-text>
                            <v-data-table 
                                :loading="datatableLoading"
                                loading-text="Loading... Please wait"
                                :dense="true"                                                  
                                :disable-pagination="true"
                                :hide-default-footer="true"
                                :headers="headers"
                                :items="kombi_ganjil_paid"> 
                                <template v-slot:item.jumlah="{ item }">                            
                                    {{  item.jumlah|formatUang }}
                                </template>    
                                <template v-slot:body.append v-if="kombi_ganjil_paid.length > 0">
                                    <tr class="grey lighten-4 font-weight-black">
                                        <td class="text-right">TOTAL</td>
                                        <td class="text-right">{{totalKombiGanjilPaid|formatUang}}</td>                                                                                
                                    </tr>
                                </template>
                                <template v-slot:no-data>                            
                                    belum ada transaksi dengan status PAID.
                                </template>                           
                            </v-data-table>
                        </v-card-text>
                    </v-card>                    
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
                <v-col xs="12" sm="12" md="6">
                    <v-card class="mb-3">
                        <v-card-title>
                            Semester Genap
                        </v-card-title>
                        <v-card-subtitle>
                            Jumlah yang muncul berdasarkan transaksi yang statusnya PAID
                        </v-card-subtitle>
                        <v-card-text>
                            <v-data-table       
                                :loading="datatableLoading"
                                loading-text="Loading... Please wait"      
                                :dense="true"                   
                                :disable-pagination="true"
                                :hide-default-footer="true"
                                :headers="headers"
                                :items="kombi_genap_paid"> 
                                <template v-slot:item.jumlah="{ item }">                            
                                    {{  item.jumlah|formatUang }}
                                </template>    
                                <template v-slot:body.append v-if="kombi_genap_paid.length > 0">
                                    <tr class="grey lighten-4 font-weight-black">
                                        <td class="text-right">TOTAL</td>
                                        <td class="text-right">{{totalKombiGenapPaid|formatUang}}</td>                                                                                
                                    </tr>
                                </template>
                                <template v-slot:no-data>                            
                                    belum ada transaksi dengan status PAID.
                                </template>                           
                            </v-data-table>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>  
            </v-row>
        </v-container>
    </KeuanganLayout>
</template>
<script>
import KeuanganLayout from '@/views/layouts/KeuanganLayout';
import ModuleHeader from '@/components/ModuleHeader';
import Filter1 from '@/components/sidebar/FilterMode1';
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
        this.tahun_akademik = this.$store.getters['uiadmin/getTahunAkademik'];         
    },
    mounted()
    {
        this.initialize();
    },
    data: () => ({
        datatableLoading:false,
        firstloading:true,
        breadcrumbs:[],        
        tahun_akademik:0,
        
        //daftar komponen biaya
        kombi_ganjil_unpaid:[],       
        kombi_genap_unpaid:[],       

        kombi_ganjil_paid:[],       
        kombi_genap_paid:[],       

        kombi_ganjil_cancelled:[],       
        kombi_genap_cancelled:[],       

        headers: [                        
            { text: 'NAMA KOMPONEN', value: 'nama_kombi', sortable:false},               
            { text: 'JUMLAH', align:'end',value: 'jumlah',width:250, sortable:false},                
        ], 
        //statistik
        total_transaction:0,
        total_transaction_paid:0,
        total_transaction_unpaid:0,
        total_transaction_cancelled:0
    }),
    methods : {
        changeTahunAkademik (tahun)
        {
            this.tahun_akademik=tahun;
        },
		initialize:async function()
		{	
            this.datatableLoading=true;            
            await this.$ajax.post('/dashboard/keuangan',
            {
                TA:this.tahun_akademik,                
            },
            {
                headers: {
                    Authorization:this.$store.getters['auth/Token']
                }
            }).then(({data})=>{                 
                this.total_transaction=data.total_transaction;
                this.total_transaction_paid=data.total_transaction_paid;          
                this.total_transaction_unpaid=data.total_transaction_unpaid;          
                this.total_transaction_cancelled=data.total_transaction_cancelled;          

                this.kombi_ganjil_unpaid=data.kombi_ganjil_unpaid;
                this.kombi_genap_unpaid=data.kombi_genap_unpaid;

                this.kombi_ganjil_paid=data.kombi_ganjil_paid;
                this.kombi_genap_paid=data.kombi_genap_paid;

                this.kombi_ganjil_cancelled=data.kombi_ganjil_cancelled;
                this.kombi_genap_cancelled=data.kombi_genap_cancelled;
                
                this.datatableLoading=false;
            }).catch(()=>{
                this.datatableLoading=false;
            });
            this.firstloading=false;            
            this.$refs.filter1.setFirstTimeLoading(this.firstloading); 

        }
    },
    computed:{        
        totalKombiGanjilPaid()
        {
            var total = 0;
            for (var i =0; i < this.kombi_ganjil_paid.length; i++)
            {
                var item = this.kombi_ganjil_paid[i];
                total+=item.jumlah;
            }
            return total;
        },
        totalKombiGenapPaid()
        {
            var total = 0;
            for (var i =0; i < this.kombi_genap_paid.length; i++)
            {
                var item = this.kombi_genap_paid[i];
                total+=item.jumlah;
            }
            return total;
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
        KeuanganLayout,
        ModuleHeader,           
        Filter1,        
    },
}
</script>