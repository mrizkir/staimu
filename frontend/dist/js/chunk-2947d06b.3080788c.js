(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2947d06b"],{"684f":function(a,t,e){"use strict";var n=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("div",[e("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[e("strong",[a._v("Hak Akses Sebagai :")]),a._v(" "+a._s(a.ROLE)+" ")]),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(t){t.stopPropagation(),a.drawer=!a.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(t){t.stopPropagation(),a.$router.push("/dashboard/"+a.$store.getters["auth/AccessToken"]).catch((function(a){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[a._v(a._s(a.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:a._u([{key:"activator",fn:function(t){var n=t.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",a._g({attrs:{src:a.photoUser}},n))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:a.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[a._v(" "+a._s(a.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[a._v(" ["+a._s(a.DEFAULT_ROLE)+"] ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-account")])],1),e("v-list-item-title",[a._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(t){return t.preventDefault(),a.logout(t)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-power")])],1),e("v-list-item-title",[a._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(t){t.stopPropagation(),a.drawerRight=!a.drawerRight}}},[e("v-icon",[a._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:a.temporaryleftsidebar,app:""},model:{value:a.drawer,callback:function(t){a.drawer=t},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:a.photoUser},on:{click:function(t){return t.stopPropagation(),a.toProfile(t)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[a._v(" "+a._s(a.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[a._v(" ["+a._s(a.DEFAULT_ROLE)+"] ")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[a.CAN_ACCESS("SPMB-GROUP")&&"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/spmb"},link:"",color:"green"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-monitor-dashboard")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v("BOARD SPMB")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-SOAL_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/soalpmb"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-head-question-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" SOAL PMB ")])],1)],1):a._e(),e("v-subheader",[a._v("DATA MHS. BARU")]),a.CAN_ACCESS("SPMB-PMB_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/pendaftaranbaru"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-account-plus")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" PENDAFTAR ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-FORMULIR-PENDAFTARAN_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/formulirpendaftaran"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-file-document-edit-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" BIODATA ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-PERSYARATAN_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/persyaratan"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-file-document-edit-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" PERSYARATAN ")])],1)],1):a._e(),e("v-subheader",[a._v("UJIAN PMB")]),a.CAN_ACCESS("SPMB-PMB-JADWAL-UJIAN_BROWSE")&&"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-list-item",{attrs:{link:"",to:"/spmb/jadwalujianpmb"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-calendar-account")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" JADWAL UJIAN ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-NILAI-UJIAN_BROWSE")&&"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-list-item",{attrs:{link:"",to:"/spmb/nilaiujian"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-calendar-account")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" NILAI UJIAN ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-GROUP")&&"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-subheader",[a._v("LAPORAN")]):a._e(),a.CAN_ACCESS("SPMB-PMB-LAPORAN-FAKULTAS_BROWSE")&&a.isBentukPT("universitas")?e("v-list-item",{attrs:{link:"",to:"/spmb/laporanfakultas"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-file-document-edit-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" LAPORAN FAKULTAS ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-LAPORAN-PRODI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/laporanprodi"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-file-document-edit-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" LAPORAN PRODI ")])],1)],1):a._e(),a.CAN_ACCESS("SPMB-PMB-LAPORAN-KELULUSAN_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/spmb/laporankelulusan"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-file-document-edit-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v(" LAPORAN KELULUSAN ")])],1)],1):a._e()],1)],1),a.showrightsidebar?e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:a.drawerRight,callback:function(t){a.drawerRight=t},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[a._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{staticClass:"teal lighten-5 mb-5"},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[a._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[a._v("FILTER")])],1)],1),a._t("filtersidebar")],2)],1):a._e(),e("v-main",{staticClass:"mx-4 mb-4"},[a._t("default")],2),e("v-footer",{attrs:{app:"",padless:"",fixed:""}},[e("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[e("v-divider"),e("v-card-text",{staticClass:"py-2 black--text text-center"},[e("strong",[a._v(a._s(a.APP_NAME)+" (2021-2021)")]),a._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),e("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[e("v-icon",[a._v("mdi-github")])],1)],1)],1)],1)],1)},i=[],r=e("5530"),s=(e("5319"),e("ac1f"),e("2f62")),o={name:"SPMBLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var a=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){a.$store.dispatch("auth/logout"),a.$store.dispatch("uifront/reinit"),a.$store.dispatch("uiadmin/reinit"),a.$router.push("/")})).catch((function(){a.$store.dispatch("auth/logout"),a.$store.dispatch("uifront/reinit"),a.$store.dispatch("uiadmin/reinit"),a.$router.push("/")}))},isBentukPT:function(a){return this.$store.getters["uifront/getBentukPT"]==a}},computed:Object(r["a"])(Object(r["a"])({},Object(s["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var a,t=this.ATTRIBUTE_USER("foto");return a=""==t?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+t,a}}),watch:{loginTime:{handler:function(a){var t=this;a>=0?setTimeout((function(){t.loginTime=1==t.AUTHENTICATED?t.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,u=e("2877"),d=e("6544"),m=e.n(d),c=e("40dc"),f=e("5bc1"),_=e("8212"),v=e("8336"),h=e("b0af"),g=e("99d9"),p=e("ce7e"),b=e("553a"),A=e("132d"),j=e("adda"),k=e("8860"),x=e("da13"),S=e("8270"),T=e("5d23"),w=e("34c3"),C=e("f6c4"),P=e("e449"),L=e("f774"),U=e("2fa4"),M=e("e0c7"),E=e("afd9"),R=e("2a7f"),N=Object(u["a"])(l,n,i,!1,null,null,null);t["a"]=N.exports;m()(N,{VAppBar:c["a"],VAppBarNavIcon:f["a"],VAvatar:_["a"],VBtn:v["a"],VCard:h["a"],VCardText:g["d"],VDivider:p["a"],VFooter:b["a"],VIcon:A["a"],VImg:j["a"],VList:k["a"],VListItem:x["a"],VListItemAvatar:S["a"],VListItemContent:T["g"],VListItemIcon:w["a"],VListItemSubtitle:T["j"],VListItemTitle:T["k"],VMain:C["a"],VMenu:P["a"],VNavigationDrawer:L["a"],VSpacer:U["a"],VSubheader:M["a"],VSystemBar:E["a"],VToolbarTitle:R["c"]})},d9af:function(a,t,e){"use strict";e.r(t);var n=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("SPMBLayout",[e("ModuleHeader",{scopedSlots:a._u([{key:"icon",fn:function(){return[a._v(" mdi-calendar-account ")]},proxy:!0},{key:"name",fn:function(){return[a._v(" JADWAL UJIAN PMB ")]},proxy:!0},{key:"subtitle",fn:function(){return[a._v(" TAHUN PENDAFTARAN "+a._s(a.tahun_pendaftaran)+" - SEMESTER "+a._s(a.nama_semester_pendaftaran)+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:a.breadcrumbs},scopedSlots:a._u([{key:"divider",fn:function(){return[e("v-icon",[a._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[a._v(" Berisi daftar dan pengelolaan jadwal ujian PMB. ")])]},proxy:!0}])}),e("v-container",{attrs:{fluid:""}},[e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-text",[e("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:a.search,callback:function(t){a.search=t},expression:"search"}})],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:a.headers,items:a.datatable,search:a.search,"item-key":"id","sort-by":"name","show-expand":"",expanded:a.expanded,"single-expand":!0,loading:a.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(t){a.expanded=t},"click:row":a.dataTableRowClicked},scopedSlots:a._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[a._v("DAFTAR JADWAL UJIAN PMB")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer"),"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-btn",{staticClass:"mb-2",attrs:{color:"primary",disabled:a.btnLoading},on:{click:function(t){return t.stopPropagation(),a.addItem(t)}}},[a._v(" TAMBAH ")]):a._e(),e("v-dialog",{attrs:{"max-width":"800px",persistent:""},model:{value:a.dialogfrm,callback:function(t){a.dialogfrm=t},expression:"dialogfrm"}},[e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:a.form_valid,callback:function(t){a.form_valid=t},expression:"form_valid"}},[e("v-card",[e("v-card-title",[e("span",{staticClass:"headline"},[a._v(a._s(a.formTitle))])]),e("v-card-text",[e("v-text-field",{attrs:{label:"NAMA UJIAN ONLINE",outlined:"",rules:a.rule_nama_kegiatan},model:{value:a.formdata.nama_kegiatan,callback:function(t){a.$set(a.formdata,"nama_kegiatan",t)},expression:"formdata.nama_kegiatan"}}),a._v(" Jumlah soal, pastikan lebih kecil atau sama dengan jumlah soal BANK SOAL. "),e("v-text-field",{attrs:{label:"JUMLAH SOAL",outlined:"",rules:a.rule_jumlah_soal},model:{value:a.formdata.jumlah_soal,callback:function(t){a.$set(a.formdata,"jumlah_soal",t)},expression:"formdata.jumlah_soal"}}),e("v-menu",{ref:"menuTanggalAkhirPendaftaran",attrs:{"close-on-content-click":!1,"return-value":a.formdata.tanggal_akhir_daftar,transition:"scale-transition","offset-y":"","max-width":"290px","min-width":"290px"},on:{"update:returnValue":function(t){return a.$set(a.formdata,"tanggal_akhir_daftar",t)},"update:return-value":function(t){return a.$set(a.formdata,"tanggal_akhir_daftar",t)}},scopedSlots:a._u([{key:"activator",fn:function(t){var n=t.on;return[e("v-text-field",a._g({attrs:{label:"TANGGAL AKHIR PENDAFTARAN",readonly:"",outlined:""},model:{value:a.formdata.tanggal_akhir_daftar,callback:function(t){a.$set(a.formdata,"tanggal_akhir_daftar",t)},expression:"formdata.tanggal_akhir_daftar"}},n))]}}]),model:{value:a.menuTanggalAkhirPendaftaran,callback:function(t){a.menuTanggalAkhirPendaftaran=t},expression:"menuTanggalAkhirPendaftaran"}},[e("v-date-picker",{attrs:{"no-title":"",scrollable:""},model:{value:a.formdata.tanggal_akhir_daftar,callback:function(t){a.$set(a.formdata,"tanggal_akhir_daftar",t)},expression:"formdata.tanggal_akhir_daftar"}},[e("v-spacer"),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){a.menuTanggalAkhirPendaftaran=!1}}},[a._v("Cancel")]),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){return a.$refs.menuTanggalAkhirPendaftaran.save(a.formdata.tanggal_akhir_daftar)}}},[a._v("OK")])],1)],1),e("v-menu",{ref:"menuTanggalUjian",attrs:{"close-on-content-click":!1,"return-value":a.formdata.tanggal_ujian,transition:"scale-transition","offset-y":"","max-width":"290px","min-width":"290px"},on:{"update:returnValue":function(t){return a.$set(a.formdata,"tanggal_ujian",t)},"update:return-value":function(t){return a.$set(a.formdata,"tanggal_ujian",t)}},scopedSlots:a._u([{key:"activator",fn:function(t){var n=t.on;return[e("v-text-field",a._g({attrs:{label:"TANGGAL UJIAN",readonly:"",outlined:""},model:{value:a.formdata.tanggal_ujian,callback:function(t){a.$set(a.formdata,"tanggal_ujian",t)},expression:"formdata.tanggal_ujian"}},n))]}}]),model:{value:a.menuTanggalUjian,callback:function(t){a.menuTanggalUjian=t},expression:"menuTanggalUjian"}},[e("v-date-picker",{attrs:{"no-title":"",scrollable:""},model:{value:a.formdata.tanggal_ujian,callback:function(t){a.$set(a.formdata,"tanggal_ujian",t)},expression:"formdata.tanggal_ujian"}},[e("v-spacer"),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){a.menuTanggalUjian=!1}}},[a._v("Cancel")]),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){return a.$refs.menuTanggalUjian.save(a.formdata.tanggal_ujian)}}},[a._v("OK")])],1)],1),e("v-menu",{ref:"menuJamMulaiUjian",attrs:{"close-on-content-click":!1,"nudge-right":40,"return-value":a.formdata.jam_mulai_ujian,transition:"scale-transition","offset-y":"","max-width":"290px","min-width":"290px"},on:{"update:returnValue":function(t){return a.$set(a.formdata,"jam_mulai_ujian",t)},"update:return-value":function(t){return a.$set(a.formdata,"jam_mulai_ujian",t)}},scopedSlots:a._u([{key:"activator",fn:function(t){var n=t.on,i=t.attrs;return[e("v-text-field",a._g(a._b({attrs:{label:"JAM MULAI UJIAN",readonly:"",outlined:""},model:{value:a.formdata.jam_mulai_ujian,callback:function(t){a.$set(a.formdata,"jam_mulai_ujian",t)},expression:"formdata.jam_mulai_ujian"}},"v-text-field",i,!1),n))]}}]),model:{value:a.menuJamMulaiUjian,callback:function(t){a.menuJamMulaiUjian=t},expression:"menuJamMulaiUjian"}},[a.menuJamMulaiUjian?e("v-time-picker",{attrs:{"full-width":"",format:"24hr"},on:{"click:minute":function(t){return a.$refs.menuJamMulaiUjian.save(a.formdata.jam_mulai_ujian)}},model:{value:a.formdata.jam_mulai_ujian,callback:function(t){a.$set(a.formdata,"jam_mulai_ujian",t)},expression:"formdata.jam_mulai_ujian"}}):a._e()],1),e("v-menu",{ref:"menuJamSelesaiUjian",attrs:{"close-on-content-click":!1,"nudge-right":40,"return-value":a.formdata.jam_selesai_ujian,transition:"scale-transition","offset-y":"","max-width":"290px","min-width":"290px"},on:{"update:returnValue":function(t){return a.$set(a.formdata,"jam_selesai_ujian",t)},"update:return-value":function(t){return a.$set(a.formdata,"jam_selesai_ujian",t)}},scopedSlots:a._u([{key:"activator",fn:function(t){var n=t.on,i=t.attrs;return[e("v-text-field",a._g(a._b({attrs:{label:"JAM SELESAI UJIAN",readonly:"",outlined:""},model:{value:a.formdata.jam_selesai_ujian,callback:function(t){a.$set(a.formdata,"jam_selesai_ujian",t)},expression:"formdata.jam_selesai_ujian"}},"v-text-field",i,!1),n))]}}]),model:{value:a.menuJamSelesaiUjian,callback:function(t){a.menuJamSelesaiUjian=t},expression:"menuJamSelesaiUjian"}},[a.menuJamSelesaiUjian?e("v-time-picker",{attrs:{"full-width":"",format:"24hr"},on:{"click:minute":function(t){return a.$refs.menuJamSelesaiUjian.save(a.formdata.jam_selesai_ujian)}},model:{value:a.formdata.jam_selesai_ujian,callback:function(t){a.$set(a.formdata,"jam_selesai_ujian",t)},expression:"formdata.jam_selesai_ujian"}}):a._e()],1),e("v-select",{attrs:{label:"RUANG UJIAN",items:a.daftar_ruangan,"item-text":"namaruang","item-value":"id",outlined:""},model:{value:a.formdata.ruangkelas_id,callback:function(t){a.$set(a.formdata,"ruangkelas_id",t)},expression:"formdata.ruangkelas_id"}})],1),e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(t){return t.stopPropagation(),a.closedialogfrm(t)}}},[a._v("BATAL")]),e("v-btn",{attrs:{color:"blue darken-1",text:"",disabled:!a.form_valid||a.btnLoading},on:{click:function(t){return t.stopPropagation(),a.save(t)}}},[a._v(" SIMPAN ")])],1)],1)],1)],1)],1)]},proxy:!0},{key:"item.tanggal_ujian",fn:function(t){var e=t.item;return[a._v(" "+a._s(a.$date(e.tanggal_ujian).format("DD/MM/YYYY"))+" ")]}},{key:"item.tanggal_akhir_daftar",fn:function(t){var e=t.item;return[a._v(" "+a._s(a.$date(e.tanggal_akhir_daftar).format("DD/MM/YYYY"))+" ")]}},{key:"item.durasi_ujian",fn:function(t){var n=t.item;return[a._v(" "+a._s(n.jam_mulai_ujian)+" - "+a._s(n.jam_selesai_ujian)+" "),e("br"),a._v("("+a._s(a.durasiUjian(n))+" Menit) ")]}},{key:"item.status_ujian",fn:function(t){var e=t.item;return[a._v(" "+a._s(a.getStatusJadwanUjian(e))+" ")]}},"mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?{key:"item.actions",fn:function(t){var n=t.item;return[e("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return t.stopPropagation(),a.viewItem(n)}}},[a._v(" mdi-eye ")]),e("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return t.stopPropagation(),a.editItem(n)}}},[a._v(" mdi-pencil ")]),e("v-icon",{attrs:{small:"",disabled:a.btnLoading},on:{click:function(t){return t.stopPropagation(),a.deleteItem(n)}}},[a._v(" mdi-delete ")])]}}:{key:"item.actions",fn:function(){return[a._v(" N.A ")]},proxy:!0},{key:"expanded-item",fn:function(t){var n=t.headers,i=t.item;return[e("td",{staticClass:"text-center",attrs:{colspan:n.length}},[e("v-col",{attrs:{cols:"12"}},[e("strong",[a._v("ID:")]),a._v(a._s(i.id)+" "),e("strong",[a._v("Ruangan:")]),a._v(a._s(i.namaruang)+" "),e("strong",[a._v("created_at:")]),a._v(a._s(a.$date(i.created_at).format("DD/MM/YYYY HH:mm"))+" "),e("strong",[a._v("updated_at:")]),a._v(a._s(a.$date(i.updated_at).format("DD/MM/YYYY HH:mm"))+" ")]),e("v-col",{attrs:{cols:"12"}},["mahasiswabaru"!=a.dashboard&&"mahasiswa"!=a.dashboard?e("v-btn",{attrs:{text:"",small:"",color:"primary",to:"/spmb/jadwalujianpmb/passinggrade/"+i.id}},[a._v("TENTUKAN PASSING GRADE")]):a._e()],1)],1)]}},{key:"no-data",fn:function(){return[a._v(" Data belum tersedia ")]},proxy:!0}],null,!0)})],1)],1)],1)],1)},i=[],r=e("1da1"),s=(e("a434"),e("96cf"),e("684f")),o=e("e477"),l={name:"JadwalUjianPMB",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"],this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"SPMB",disabled:!1,href:"#"},{text:"JADWAL UJIAN PMB",disabled:!0,href:"#"}],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"],this.semester_pendaftaran=this.$store.getters["uiadmin/getSemesterPendaftaran"],this.nama_semester_pendaftaran=this.$store.getters["uiadmin/getNamaSemester"](this.semester_pendaftaran),this.initialize()},data:function(){var a=this,t=this.$date().format("YYYY-MM-DD");return{breadcrumbs:[],dashboard:null,firstloading:!0,tahun_pendaftaran:null,semester_pendaftaran:null,nama_semester_pendaftaran:null,btnLoading:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"NAMA UJIAN",value:"nama_kegiatan",sortable:!0,width:300},{text:"TGL. UJIAN",value:"tanggal_ujian",sortable:!0,width:100},{text:"TGL. AKHIR PENDAFTARAN",value:"tanggal_akhir_daftar",sortable:!0,width:100},{text:"DURASI UJIAN",value:"durasi_ujian",sortable:!0,width:100},{text:"JUMLAH PESERTA",value:"jumlah_peserta",sortable:!0,width:100},{text:"STATUS",value:"status_ujian",sortable:!0,width:100},{text:"AKSI",value:"actions",sortable:!1,width:100}],search:"",dialogfrm:!1,form_valid:!0,jumlah_bank_soal:0,daftar_ruangan:[],menuTanggalUjian:!1,menuJamMulaiUjian:!1,menuJamSelesaiUjian:!1,menuTanggalAkhirPendaftaran:!1,formdata:{id:0,nama_kegiatan:"",jumlah_soal:"",tanggal_ujian:t,jam_mulai_ujian:"",jam_selesai_ujian:"",tanggal_akhir_daftar:t,ruangkelas_id:"",ta:"",idsmt:"",status_pendaftaran:"",status_ujian:"",created_at:"",updated_at:""},formdefault:{id:0,nama_kegiatan:"",jumlah_soal:"",tanggal_ujian:this.$date().format("YYYY-MM-DD"),jam_mulai_ujian:"",jam_selesai_ujian:"",tanggal_akhir_daftar:t,durasi_ujian:"",ruangkelas_id:"",ta:"",idsmt:"",status_pendaftaran:"",status_ujian:"",created_at:"",updated_at:""},editedIndex:-1,rule_nama_kegiatan:[function(a){return!!a||"Mohon untuk di isi nama ujian online !!!"}],rule_jumlah_soal:[function(a){return!!a||"Mohon untuk di isi jumlah soal ujian !!!"},function(a){return/^[0-9]+$/.test(a)||"Jumlah soal ujian hanya boleh angka"},function(t){if(t&&"undefined"!==typeof t&&t.length>0){var e=parseInt(a.jumlah_bank_soal),n=parseInt(t);return n<=e||"Jumlah soal harus lebih kecil atau sama dengan jumlah di bank soal ("+e+")"}return!0}]}},methods:{changeTahunPendaftaran:function(a){this.tahun_pendaftaran=a},changeSemesterPendaftaran:function(a){this.semester_pendaftaran=a},initialize:function(){var a=Object(r["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return this.datatableLoading=!0,a.next=3,this.$ajax.post("/spmb/jadwalujianpmb",{tahun_pendaftaran:this.tahun_pendaftaran,semester_pendaftaran:this.semester_pendaftaran},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.jumlah_bank_soal=e.jumlah_bank_soal,t.datatable=e.jadwal_ujian,t.datatableLoading=!1})).catch((function(){t.datatableLoading=!1}));case 3:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),getStatusJadwanUjian:function(a){switch(a.status_ujian){case 0:return"BELUM MULAI";case 1:return"BERJALAN";case 2:return"SELESAI";default:return"N.A"}},dataTableRowClicked:function(a){a===this.expanded[0]?this.expanded=[]:this.expanded=[a]},addItem:function(){var a=Object(r["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return this.btnLoading=!0,a.next=3,this.$ajax.get("/datamaster/ruangankelas",{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.daftar_ruangan=e.ruangan,t.btnLoading=!1,t.dialogfrm=!0})).catch((function(){t.btnLoading=!1}));case 3:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),durasiUjian:function(a){var t=this.$date(a.tanggal_ujian+" "+a.jam_mulai_ujian),e=this.$date(a.tanggal_ujian+" "+a.jam_selesai_ujian);return e.diff(t,"minute")},viewItem:function(a){this.$router.push("/spmb/jadwalujianpmb/"+a.id+"/detail")},editItem:function(){var a=Object(r["a"])(regeneratorRuntime.mark((function a(t){var e=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return a.next=2,this.$ajax.get("/datamaster/ruangankelas",{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var n=a.data;e.daftar_ruangan=n.ruangan,e.btnLoading=!1,e.editedIndex=e.datatable.indexOf(t),e.formdata=Object.assign({},t),e.dialogfrm=!0})).catch((function(){e.btnLoading=!1}));case 2:case"end":return a.stop()}}),a,this)})));function t(t){return a.apply(this,arguments)}return t}(),save:function(){var a=Object(r["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(!this.$refs.frmdata.validate()){a.next=9;break}if(this.btnLoading=!0,!(this.editedIndex>-1)){a.next=7;break}return a.next=5,this.$ajax.post("/spmb/jadwalujianpmb/"+this.formdata.id,{_method:"PUT",nama_kegiatan:this.formdata.nama_kegiatan,jumlah_soal:this.formdata.jumlah_soal,tanggal_ujian:this.formdata.tanggal_ujian,jam_mulai_ujian:this.formdata.jam_mulai_ujian,jam_selesai_ujian:this.formdata.jam_selesai_ujian,tanggal_akhir_daftar:this.formdata.tanggal_akhir_daftar,durasi_ujian:this.durasiUjian(this.formdata),ruangkelas_id:this.formdata.ruangkelas_id},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(){t.closedialogfrm(),t.btnLoading=!1,t.initialize()})).catch((function(){t.btnLoading=!1}));case 5:a.next=9;break;case 7:return a.next=9,this.$ajax.post("/spmb/jadwalujianpmb/store",{nama_kegiatan:this.formdata.nama_kegiatan,jumlah_soal:this.formdata.jumlah_soal,tanggal_ujian:this.formdata.tanggal_ujian,jam_mulai_ujian:this.formdata.jam_mulai_ujian,jam_selesai_ujian:this.formdata.jam_selesai_ujian,tanggal_akhir_daftar:this.formdata.tanggal_akhir_daftar,durasi_ujian:this.durasiUjian(this.formdata),ruangkelas_id:this.formdata.ruangkelas_id,ta:this.tahun_pendaftaran,idsmt:this.semester_pendaftaran},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(){t.closedialogfrm(),t.btnLoading=!1,t.initialize()})).catch((function(){t.btnLoading=!1}));case 9:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),deleteItem:function(a){var t=this;this.$root.$confirm.open("Delete","Apakah Anda ingin menghapus data dengan ID "+a.id+" ?",{color:"red"}).then((function(e){e&&(t.btnLoading=!0,t.$ajax.post("/spmb/jadwalujianpmb"+a.id,{_method:"DELETE"},{headers:{Authorization:t.$store.getters["auth/Token"]}}).then((function(){var e=t.datatable.indexOf(a);t.datatable.splice(e,1),t.btnLoading=!1})).catch((function(){t.btnLoading=!1})))}))},closedialogfrm:function(){var a=this;this.dialogfrm=!1,setTimeout((function(){a.formdata=Object.assign({},a.formdefault),a.editedIndex=-1,a.$refs.frmdata.reset()}),300)}},computed:{formTitle:function(){return-1===this.editedIndex?"TAMBAH JADWAL":"UBAH JADWAL"}},components:{SPMBLayout:s["a"],ModuleHeader:o["a"]}},u=l,d=e("2877"),m=e("6544"),c=e.n(m),f=e("0798"),_=e("2bc5"),v=e("8336"),h=e("b0af"),g=e("99d9"),p=e("62ad"),b=e("a523"),A=e("8fea"),j=e("2e4b"),k=e("169a"),x=e("ce7e"),S=e("4bd4"),T=e("132d"),w=e("e449"),C=e("0fd9"),P=e("b974"),L=e("2fa4"),U=e("8654"),M=e("c964"),E=e("71d9"),R=e("2a7f"),N=Object(d["a"])(u,n,i,!1,null,null,null);t["default"]=N.exports;c()(N,{VAlert:f["a"],VBreadcrumbs:_["a"],VBtn:v["a"],VCard:h["a"],VCardActions:g["b"],VCardText:g["d"],VCardTitle:g["e"],VCol:p["a"],VContainer:b["a"],VDataTable:A["a"],VDatePicker:j["a"],VDialog:k["a"],VDivider:x["a"],VForm:S["a"],VIcon:T["a"],VMenu:w["a"],VRow:C["a"],VSelect:P["a"],VSpacer:L["a"],VTextField:U["a"],VTimePicker:M["a"],VToolbar:E["a"],VToolbarTitle:R["c"]})},e477:function(a,t,e){"use strict";var n=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("v-container",{attrs:{fluid:a.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[a._t("icon")],2),a._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[a._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a._t("desc")],2)],1)],1)},i=[],r={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},s=r,o=e("2877"),l=e("6544"),u=e.n(l),d=e("62ad"),m=e("a523"),c=e("132d"),f=e("0fd9"),_=Object(o["a"])(s,n,i,!1,null,null,null);t["a"]=_.exports;u()(_,{VCol:d["a"],VContainer:m["a"],VIcon:c["a"],VRow:f["a"]})}}]);