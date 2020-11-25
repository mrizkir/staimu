<template>
    <v-card color="grey lighten-4">
        <v-toolbar elevation="2"> 
            <v-toolbar-title>PROFIL MAHASISWA</v-toolbar-title>
            <v-divider
                class="mx-4"
                inset
                vertical
            ></v-divider>
            <v-spacer></v-spacer>
            <v-icon                
                @click.stop="exit()">
                mdi-close-thick
            </v-icon>
        </v-toolbar>
        <v-card-text>            
            <v-row no-gutters>
                <v-col xs="12" sm="6" md="2">
                    <v-card flat>
                        <v-card-text>
                            
                        </v-card-text>
                    </v-card>
                    <v-card flat>
                        <v-card-title>NOMOR HP:</v-card-title>  
                        <v-card-subtitle>
                            {{datamhs.nomor_hp}}
                        </v-card-subtitle>
                    </v-card>
                    <v-card flat>
                        <v-card-title>EMAIL:</v-card-title>  
                        <v-card-subtitle>
                            {{datamhs.email}}
                        </v-card-subtitle>
                    </v-card>
                </v-col>
                <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                <v-col xs="12" sm="6" md="10">
                    <v-row no-gutters>
                        <v-col xs="12" sm="6" md="7" class="mb-2 mr-2 ml-2">
                            <v-card flat>
                                <v-card-title>ID :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.user_id}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                        <v-col xs="12" sm="6" md="5">
                            <v-card flat>
                                <v-card-title>PROGRAM STUDI :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.nama_prodi}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                    </v-row>
                    <v-row no-gutters>                
                        <v-col xs="12" sm="6" md="7">
                            <v-card flat>
                                <v-card-title>NAMA MAHASISWA :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.nama_mhs}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                        <v-col xs="12" sm="6" md="5">
                            <v-card flat>
                                <v-card-title>KELAS :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.nama_kelas}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                    </v-row>
                    <v-row no-gutters>                
                        <v-col xs="12" sm="6" md="7">
                            <v-card flat>
                                <v-card-title>TEMPAT DAN TGL. LAHIR :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.tempat_lahir}}, {{$date(datamhs.tanggal_lahir).format('DD/MM/YYYY')}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                        <v-col xs="12" sm="6" md="5">
                            <v-card flat>
                                <v-card-title>TAHUN PENDAFTARAN :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.ta}}, ({{$date(datamhs.created_at).format('DD/MM/YYYY HH:mm')}})
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                    </v-row>
                    <v-row no-gutters>               
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                        <v-col xs="12" sm="6" md="7">
                            <v-card flat>
                                <v-card-title>ALAMAT RUMAH :</v-card-title>
                                <v-card-subtitle>
                                    {{datamhs.alamat_rumah}}, KEL. {{datamhs.address1_kelurahan}}, KEC. {{datamhs.address1_kecamatan}}, KOTA/KAB. {{datamhs.address1_kabupaten}}, PROV. {{datamhs.address1_provinsi}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                        <v-col xs="12" sm="6" md="5">
                            <v-card flat>
                                <v-card-title>TGL. UBAH :</v-card-title>
                                <v-card-subtitle>
                                    {{$date(datamhs.created_at).format('DD/MM/YYYY HH:mm')}}
                                </v-card-subtitle>
                            </v-card>
                        </v-col>
                        <v-responsive width="100%" v-if="$vuetify.breakpoint.xsOnly"/>
                    </v-row>
                </v-col>
            </v-row>            
        </v-card-text>
    </v-card>
</template>
<script>    
export default {
    name:'ProfilMahasiswaLama',
    created()
    {
        this.initialize();                     
    },
    props:{
        datamhs:{
            type:Object,            
            required:true
        }
    },
    
    methods: {
        initialize:async function ()
        {
            
        },
        exit()
        {

        }
    },    
}
</script>