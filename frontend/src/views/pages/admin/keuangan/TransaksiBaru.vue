<template>
    <KeuanganLayout>
        <ModuleHeader>
            <template v-slot:icon>
                mdi-video-input-component
            </template>
            <template v-slot:name>
                TAMBAH TRANSAKSI BARU
            </template>
            <template v-slot:subtitle>
                
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
                        Halaman ini berisi tambah transaksi baru.
                    </v-alert>
            </template>
        </ModuleHeader>
        <v-container fluid>
            <v-row>
                <v-col cols="7">
                    <v-card>
                        <v-card-text>
                            <v-autocomplete
                                v-model="data_mhs"
                                label="NAMA MAHASISWA/CALON MAHASISWAN"
                                outlined
                                clearable
                                return-object
                                no-filter                                
                                :search-input.sync="search">
                            </v-autocomplete>
                        </v-card-text>
                    </v-card>
                </v-col>
                <v-col cols="5">
                    <v-card>
                        <v-card-text>
                            Ringkasan
                        </v-card-text>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </KeuanganLayout>
</template>
<script>
import KeuanganLayout from '@/views/layouts/KeuanganLayout';
import ModuleHeader from '@/components/ModuleHeader';
export default {
    name:'TransaksiBaru',
    created()
    {
        this.breadcrumbs = [
            {
                text:'HOME',
                disabled:false,
                href:'/dashboard/'+this.$store.getters['auth/AccessToken']
            },
            {
                text:'KEUANGAN',
                disabled:false,
                href:'/keuangan'
            },
            {
                text:'TRANSAKSI-BARU',
                disabled:true,
                href:'#'
            }
        ];        
    },
    data: () => ({
        breadcrumbs:[],  
        search: null,

        //form data
        data_mhs:{}
    }),
    methods : {
        
    }, 
    watch:{
        
        search (val)
        {
            console.log('saerch',val);
        }
    },
    components:{
        KeuanganLayout,
        ModuleHeader,        
    },
}
</script>
