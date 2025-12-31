<template>
  <v-dialog v-model="dialog" max-width="500px" persistent @keydown.esc="cancel">
    <v-card class="rounded-lg" elevation="8">
      <v-toolbar dark color="primary" dense flat class="elevation-0">
        <v-icon left class="mr-2">mdi-printer</v-icon>
        <v-toolbar-title class="text-h6 font-weight-medium">
          Printout {{ title }}
        </v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn icon dark @click="cancel">
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-toolbar>

      <v-card-text class="pa-6">
        <div class="d-flex align-center mb-4">
          <v-icon color="success" size="40" class="mr-3">mdi-file-check</v-icon>
          <div class="flex-grow-1">
            <p class="body-1 mb-0 text--primary font-weight-medium">
              {{ message }}
            </p>
            <p v-if="nama_file" class="caption text--secondary mt-1 mb-0">
              {{ nama_file }}
            </p>
          </div>
        </div>

        <v-divider class="my-4"></v-divider>

        <div class="text-center">
          <v-btn
            color="success"
            large
            depressed
            :href="$api.storageURL + '/' + file"
            target="_blank"
            class="px-6 text-capitalize"
            elevation="2"
          >
            <v-icon left>mdi-download</v-icon>
            Download File
          </v-btn>
        </div>
      </v-card-text>

      <v-card-actions class="px-6 pb-4">
        <v-spacer></v-spacer>
        <v-btn
          text
          @click="cancel"
          class="text-capitalize"
        >
          Tutup
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
  export default {
    name: "DialogPrintoutKeuangan",
    props: {
      pid: {
        type: String,
        required: true,
      }, 
      title: {
        type: String,
        default: "",
        required: true,
      },
    },
    data: () => ({
      dialog: false,
      message: "",
      file: "",
      nama_file: "",
    }),
    methods: {
      open(item = {}) {
        this.message = item.message || "";
        this.file = item.file || "";
        this.nama_file = item.nama_file || "";
        this.dialog = true;
      },
      cancel() {
        if (this.resolve) {
          this.resolve(false);
        }
        this.dialog = false;
      }
    },
  };
</script>
