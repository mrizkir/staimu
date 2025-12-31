<template>
  <v-card class="profile-card" elevation="2">
    <v-toolbar color="primary" dark elevation="0" class="profile-toolbar">
      <v-icon left class="ml-2">mdi-account-circle</v-icon>
      <v-toolbar-title class="font-weight-bold">PROFIL MAHASISWA</v-toolbar-title>
      <v-spacer></v-spacer>
      <v-btn
        icon
        dark
        @click.stop="exit()"
        class="mr-2"
      >
        <v-icon>mdi-close</v-icon>
      </v-btn>
    </v-toolbar>
    
    <v-card-text v-if="datamhs.hasOwnProperty('user_id')" class="pa-4">
      <v-row>
        <!-- Photo & Quick Info Section -->
        <v-col cols="12" md="3" class="d-flex flex-column">
          <v-card 
            elevation="3" 
            class="photo-card mb-4 text-center"
            rounded="lg"
          >
            <v-img 
              :src="$api.url + '/' + datamhs.foto" 
              class="profile-photo"
              aspect-ratio="1"
              cover
            >
              <template v-slot:placeholder>
                <v-row class="fill-height ma-0" align="center" justify="center">
                  <v-icon size="64" color="grey lighten-1">mdi-account</v-icon>
                </v-row>
              </template>
            </v-img>
            <v-card-text class="pa-4">
              <v-chip 
                :color="getStatusColor(datamhs.n_status)" 
                dark 
                class="mb-3"
                large
                label
              >
                <v-icon left small>mdi-information</v-icon>
                {{ datamhs.n_status }}
              </v-chip>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Main Information Section -->
        <v-col cols="12" md="9">
          <v-row dense>
            <!-- Nama Mahasiswa - Highlighted -->
            <v-col cols="12">
              <v-card 
                elevation="2" 
                class="info-card highlight-card"
                rounded="lg"
              >
                <v-card-text class="pa-4">
                  <div class="d-flex align-center mb-2">
                    <v-icon color="primary" class="mr-2">mdi-account</v-icon>
                    <span class="text-caption grey--text text--darken-1 font-weight-medium">NAMA MAHASISWA</span>
                  </div>
                  <div class="text-h6 primary--text font-weight-bold">
                    {{ datamhs.nama_mhs }}
                    <v-chip x-small class="ml-2" color="secondary" text-color="white">
                      {{ datamhs.jk }}
                    </v-chip>
                  </div>
                  <v-divider class="my-3"></v-divider>
                  <v-row dense>
                    <v-col cols="12" sm="4">
                      <div class="text-caption grey--text text--darken-1 mb-1">Nomor HP</div>
                      <div class="text-body-2 font-weight-medium">{{ datamhs.nomor_hp || '-' }}</div>
                    </v-col>
                    <v-col cols="12" sm="4">
                      <div class="text-caption grey--text text--darken-1 mb-1">Username</div>
                      <div class="text-body-2 font-weight-medium">{{ datamhs.nim || '-' }}</div>
                    </v-col>
                    <v-col cols="12" sm="4">
                      <div class="text-caption grey--text text--darken-1 mb-1">CREATED / UPDATED</div>
                      {{ $date(datamhs.created_at).format("DD/MM/YYYY HH:mm") }} 
                      <v-icon size="14" class="mx-2">mdi-arrow-right</v-icon>
                      {{ $date(datamhs.updated_at).format("DD/MM/YYYY HH:mm") }}
                    </v-col>
                  </v-row>                                    
                </v-card-text>
              </v-card>
            </v-col>

            <!-- User ID -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-identifier</v-icon>
                    <span class="text-caption grey--text text--darken-1">USER ID</span>
                  </div>
                  <div class="text-body-1 font-weight-medium">{{ datamhs.user_id }}</div>
                </v-card-text>
              </v-card>
            </v-col>

            <!-- Program Studi / Kelas -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-school</v-icon>
                    <span class="text-caption grey--text text--darken-1">PROGRAM STUDI / KELAS</span>
                  </div>
                  <div class="text-body-1 font-weight-medium">
                    {{ datamhs.nama_prodi }} / {{ datamhs.nkelas }}
                  </div>
                </v-card-text>
              </v-card>
            </v-col>

            <!-- Tahun Pendaftaran -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-calendar</v-icon>
                    <span class="text-caption grey--text text--darken-1">TAHUN PENDAFTARAN</span>
                  </div>
                  <div class="text-body-1 font-weight-medium">{{ datamhs.tahun }}</div>
                </v-card-text>
              </v-card>
            </v-col>

            <!-- NIM / NIRM / No. Formulir -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-card-account-details</v-icon>
                    <span class="text-caption grey--text text--darken-1">NIM / NIRM / NO. FORMULIR</span>
                  </div>
                  <div class="text-body-2 font-weight-medium">
                    {{ datamhs.nim }} / {{ datamhs.nirm }} / {{ datamhs.no_formulir }}
                  </div>
                </v-card-text>
              </v-card>
            </v-col>

            <!-- Email -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-email</v-icon>
                    <span class="text-caption grey--text text--darken-1">EMAIL</span>
                  </div>
                  <div class="text-body-2 font-weight-medium">{{ datamhs.email || '-' }}</div>
                </v-card-text>
              </v-card>
            </v-col>

            <!-- Alamat -->
            <v-col cols="12" sm="6" md="4">
              <v-card elevation="2" class="info-card" rounded="lg">
                <v-card-text class="pa-3">
                  <div class="d-flex align-center mb-1">
                    <v-icon color="primary" size="18" class="mr-2">mdi-map-marker</v-icon>
                    <span class="text-caption grey--text text--darken-1">ALAMAT</span>
                  </div>
                  <div class="text-body-2 font-weight-medium">{{ datamhs.alamat_rumah || '-' }}</div>
                </v-card-text>
              </v-card>
            </v-col>
          </v-row>
        </v-col>
      </v-row>
    </v-card-text>
  </v-card>
</template>
<script>
  export default {
    name: 'ProfilMahasiswaLama',
    created() {
      this.initialize(); 
    },
    props: {
      datamhs: {
        type: Object,
        required: true
      },
      url: {
        type: String,
        default: null            
      }
    },
    
    methods: {
      initialize: async function() {
        // Initialize if needed
      },
      exit() {
        if (this.url != null) {
          this.$router.push(this.url);
        } 
      },
      getStatusColor(status) {
        const statusColors = {
          'Aktif': 'success',
          'Lulus': 'info',
          'Cuti': 'warning',
          'Nonaktif': 'error',
          'Drop Out': 'error'
        };
        return statusColors[status] || 'primary';
      }
    }
  }
</script>

<style scoped>
  .profile-card {
    border-radius: 12px;
    overflow: hidden;
  }

  .profile-toolbar {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
  }

  .photo-card {
    position: sticky;
    top: 20px;
  }

  .profile-photo {
    border-radius: 8px 8px 0 0;
  }

  .info-card {
    transition: all 0.3s ease;
    height: 100%;
  }

  .info-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
  }

  .highlight-card {
    background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
    border-left: 4px solid #667eea;
  }

  @media (max-width: 960px) {
    .photo-card {
      position: relative;
      top: 0;
    }
  }
</style>