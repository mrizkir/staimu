<template>
  <v-row class="mb-4" no-gutters>
    <v-col cols="12">
      <v-bottom-navigation color="purple lighten-1">        
        <v-btn @click.stop="showdialogrealisasikinerja">
          <span>Ganti Dosen Wali</span>
          <v-icon>mdi-note-outline</v-icon>
        </v-btn>
        <v-btn @click.stop="exitprofile">
          <span>Keluar</span>
          <v-icon>mdi-close</v-icon>
        </v-btn>
      </v-bottom-navigation>
    </v-col>
  </v-row>			
</template>