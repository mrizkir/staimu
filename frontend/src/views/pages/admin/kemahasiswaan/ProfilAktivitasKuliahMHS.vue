<template>
  <ProfilMahasiswaLayout :showrightsidebar="false">
    <ModuleHeader>
      <template v-slot:icon>
        mdi-account-box-multiple
      </template>
      <template v-slot:name>
        AKTIVITAS KULIAH MAHASISWA
      </template>
      <template v-slot:subtitle v-if="datamhs && datamhs.user_id && datamhs.nama_mhs">
        <span v-if="datatable && datatable.length > 0 && datatable[0].nim">
          [{{datatable[0].nim}}] {{datamhs.nama_mhs}}
        </span>
        <span v-else>
          {{datamhs.nama_mhs}}
        </span>
      </template>
      <template v-slot:breadcrumbs>
        <v-breadcrumbs :items="breadcrumbs" class="pa-0">
          <template v-slot:divider>
            <v-icon>mdi-chevron-right</v-icon>
          </template>
        </v-breadcrumbs>
      </template>
    </ModuleHeader>
    <v-container fluid v-if="datamhs && datamhs.user_id">
      <v-row>
        <v-col cols="12">
          <v-data-table
            :headers="headers"
            :items="datatable"
            :loading="datatableLoading"
            item-key="id"
            :expanded.sync="expanded"
            show-expand
            class="elevation-1"
            :footer-props="{
              'items-per-page-options': [10, 20, 50, 100, -1]
            }"
          >
            <template v-slot:item.tahun="{ item }">
              {{ item.tahun }}
            </template>
            <template v-slot:item.idsmt="{ item }">
              {{ $store.getters['uiadmin/getNamaSemester'](item.idsmt) }}
            </template>
            <template v-slot:item.n_status="{ item }">
              <v-chip
                :color="getStatusColor(item.k_status)"
                small
                dark
              >
                {{ item.n_status }}
              </v-chip>
            </template>
            <template v-slot:item.n_status_sebelumnya="{ item }">
              <v-chip
                v-if="item.n_status_sebelumnya"
                :color="getStatusColor(item.status_sebelumnya)"
                small
                outlined
              >
                {{ item.n_status_sebelumnya }}
              </v-chip>
              <span v-else>-</span>
            </template>
            <template v-slot:item.update_info="{ item }">
              <v-chip
                :color="item.update_info == 1 ? 'success' : 'warning'"
                small
                dark
              >
                {{ item.update_info == 1 ? 'Sudah Update' : 'Belum Update' }}
              </v-chip>
            </template>
            <template v-slot:expanded-item="{ headers, item }">
              <td :colspan="headers.length" class="pa-4">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-card outlined>
                      <v-card-title class="subtitle-1">
                        DETAIL INFORMASI
                      </v-card-title>
                      <v-card-text>
                        <v-simple-table dense>
                          <tbody>
                            <tr>
                              <td><strong>ID Dulang:</strong></td>
                              <td>{{ item.id }}</td>
                            </tr>
                            <tr>
                              <td><strong>NIM:</strong></td>
                              <td>{{ item.nim }}</td>
                            </tr>
                            <tr>
                              <td><strong>Tahun Akademik:</strong></td>
                              <td>{{ item.tahun }}</td>
                            </tr>
                            <tr>
                              <td><strong>Semester:</strong></td>
                              <td>{{ $store.getters['uiadmin/getNamaSemester'](item.idsmt) }}</td>
                            </tr>
                            <tr>
                              <td><strong>Status:</strong></td>
                              <td>
                                <v-chip
                                  :color="getStatusColor(item.k_status)"
                                  small
                                  dark
                                >
                                  {{ item.n_status }}
                                </v-chip>
                                <span class="ml-2">({{ item.k_status }})</span>
                              </td>
                            </tr>
                            <tr v-if="item.n_status_sebelumnya">
                              <td><strong>Status Sebelumnya:</strong></td>
                              <td>
                                <v-chip
                                  :color="getStatusColor(item.status_sebelumnya)"
                                  small
                                  outlined
                                >
                                  {{ item.n_status_sebelumnya }}
                                </v-chip>
                                <span class="ml-2">({{ item.status_sebelumnya }})</span>
                              </td>
                            </tr>
                            <tr>
                              <td><strong>Update Info:</strong></td>
                              <td>{{ item.update_info == 1 ? 'Sudah Update' : 'Belum Update' }}</td>
                            </tr>
                            <tr v-if="item.descr">
                              <td><strong>Keterangan:</strong></td>
                              <td>{{ item.descr }}</td>
                            </tr>
                            <tr>
                              <td><strong>Tanggal Dibuat:</strong></td>
                              <td>{{ formatDate(item.created_at) }}</td>
                            </tr>
                            <tr>
                              <td><strong>Tanggal Diupdate:</strong></td>
                              <td>{{ formatDate(item.updated_at) }}</td>
                            </tr>
                          </tbody>
                        </v-simple-table>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </td>
            </template>
            <template v-slot:no-data>
              <v-alert
                type="info"
                text
                class="ma-4"
              >
                Tidak ada data aktivitas kuliah
              </v-alert>
            </template>
          </v-data-table>
        </v-col>
      </v-row>
    </v-container>
  </ProfilMahasiswaLayout>
</template>

<script>
  import ProfilMahasiswaLayout from "@/views/layouts/ProfilMahasiswaLayout";
  import ModuleHeader from "@/components/ModuleHeader";
  
  export default {
    name: "ProfilAktivitasKuliahMHS",
    created()
    {
      this.user_id = this.$route.params.user_id;
      this.breadcrumbs = [
        {
          text: "HOME",
          disabled: false,
          href: "/dashboard/" + this.$store.getters["auth/AccessToken"]
        },
        {
          text: "KEMAHASISWAAN",
          disabled: false,
          href: "/kemahasiswaan"
        },
        {
          text: "PROFIL",
          disabled: false,
          href: "/kemahasiswaan/profil/" + this.user_id,
        },
        {
          text: "AKTIVITAS KULIAH",
          disabled: true,
          href: "#",
        },
      ];
    },
    mounted() {
      this.initialize();
    },
    data: () => ({
      firstloading: true,
      breadcrumbs: [],
      user_id: null,
      datamhs: null,
      datatableLoading: false,
      datatable: [],
      headers: [
        { text: "TAHUN", value: "tahun", width: 100, sortable: true },
        { text: "SEMESTER", value: "idsmt", width: 120, sortable: true },
        { text: "STATUS", value: "n_status", width: 100, sortable: true },
        { text: "STATUS SEBELUMNYA", value: "n_status_sebelumnya", width: 150, sortable: true },
        { text: "UPDATE INFO", value: "update_info", width: 130, sortable: true },
        { text: "KETERANGAN", value: "descr", sortable: false },
        { text: "", value: "data-table-expand" },
      ],
      expanded: [],
    }),
    methods: {
      initialize: async function() {
        this.datatableLoading = true;
        await this.$ajax.get('/akademik/dulang/aktivitaskuliah/' + this.user_id,
          {
            headers: {
              Authorization: this.$store.getters["auth/Token"]
            }
          }
        )
        .then(({ data }) => {
          this.datamhs = data.mahasiswa;
          this.datatable = data.aktivitas_kuliah;
          this.datatableLoading = false;
        })
        .catch(() => {
          this.datatableLoading = false;
        });
      },
      getStatusColor(status) {
        const colors = {
          'A': 'success',
          'C': 'warning',
          'L': 'info',
          'DO': 'error',
          'K': 'error',
          'N': 'grey'
        };
        return colors[status] || 'grey';
      },
      formatDate(date) {
        if (!date) return '-';
        return new Date(date).toLocaleString('id-ID', {
          year: 'numeric',
          month: 'long',
          day: 'numeric',
          hour: '2-digit',
          minute: '2-digit'
        });
      }
    },
    components: {
      ProfilMahasiswaLayout,
      ModuleHeader,
    },
  };
</script>
