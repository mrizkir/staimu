(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-33e8583a"],{"6ba9":function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-list-item",[e("v-list-item-content",[e("v-select",{attrs:{items:t.daftar_ta,label:"TAHUN PENDAFTARAN",outlined:""},model:{value:t.tahun_pendaftaran,callback:function(a){t.tahun_pendaftaran=a},expression:"tahun_pendaftaran"}})],1)],1)},n=[],s={name:"FilterMode9",created:function(){this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"]},data:function(){return{firstloading:!0,daftar_ta:[],tahun_pendaftaran:null}},methods:{setFirstTimeLoading:function(t){this.firstloading=t}},watch:{tahun_pendaftaran:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateTahunPendaftaran",t),this.$emit("changeTahunPendaftaran",t))}}},r=s,o=e("2877"),d=e("6544"),l=e.n(d),u=e("da13"),c=e("5d23"),m=e("b974"),f=Object(o["a"])(r,i,n,!1,null,null,null);a["a"]=f.exports;l()(f,{VListItem:u["a"],VListItemContent:c["g"],VSelect:m["a"]})},e477:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-container",{attrs:{fluid:t.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},n=[],s={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=s,o=e("2877"),d=e("6544"),l=e.n(d),u=e("62ad"),c=e("a523"),m=e("132d"),f=e("0fd9"),h=Object(o["a"])(r,i,n,!1,null,null,null);a["a"]=h.exports;l()(h,{VCol:u["a"],VContainer:c["a"],VIcon:m["a"],VRow:f["a"]})},f58b:function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("SystemMigrationLayout",{scopedSlots:t._u([{key:"filtersidebar",fn:function(){return[e("Filter9",{ref:"filter9",on:{changeTahunPendaftaran:t.changeTahunPendaftaran}})]},proxy:!0}])},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-bank-transfer-in ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" MIGRASI SISTEM ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v(" TAHUN PENDAFTARAN "+t._s(t.tahun_pendaftaran)+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman ini digunakan untuk melakukan migrasi data mahasiswa. ")])]},proxy:!0}])}),e("v-container",{attrs:{fluid:""}},[e("v-row",[e("v-col",{attrs:{cols:"12"}},[e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(a){t.form_valid=a},expression:"form_valid"}},[e("v-card",{staticClass:"mb-4"},[e("v-card-title",[t._v(" BIODATA MAHASISWA ")]),e("v-card-text",[e("v-alert",{attrs:{type:"info"}},[t._v(" Isi form mahasiswa dengan lengkap dan benar; hasil inputan bisa dilihat di Akademik->Daftar Mahasiswa atau Akademik->Daftar Ulang ")]),e("v-text-field",{attrs:{label:"NIM",rules:t.rule_nim,outlined:""},model:{value:t.formdata.nim,callback:function(a){t.$set(t.formdata,"nim",a)},expression:"formdata.nim"}}),e("v-text-field",{attrs:{label:"NIRM",rules:t.rule_nirm,outlined:""},model:{value:t.formdata.nirm,callback:function(a){t.$set(t.formdata,"nirm",a)},expression:"formdata.nirm"}}),e("v-text-field",{attrs:{label:"NAMA LENGKAP",rules:t.rule_nama_mhs,outlined:""},model:{value:t.formdata.nama_mhs,callback:function(a){t.$set(t.formdata,"nama_mhs",a)},expression:"formdata.nama_mhs"}}),e("v-select",{attrs:{label:"PROGRAM STUDI",items:t.daftar_prodi,"item-text":"text","item-value":"id",rules:t.rule_prodi,outlined:""},model:{value:t.formdata.prodi_id,callback:function(a){t.$set(t.formdata,"prodi_id",a)},expression:"formdata.prodi_id"}}),e("v-select",{attrs:{label:"KELAS",items:t.daftar_kelas,"item-text":"text","item-value":"id",rules:t.rule_kelas,outlined:""},model:{value:t.formdata.idkelas,callback:function(a){t.$set(t.formdata,"idkelas",a)},expression:"formdata.idkelas"}}),e("v-select",{attrs:{label:"DOSEN WALI",items:t.daftar_dw,"item-text":"name","item-value":"id",rules:t.rule_dw,outlined:""},model:{value:t.formdata.dosen_id,callback:function(a){t.$set(t.formdata,"dosen_id",a)},expression:"formdata.dosen_id"}})],1)],1),e("v-card",{staticClass:"mb-4"},[e("v-card-title",[t._v(" Daftar Ulang Mahasiswa ")]),e("v-card-text",[e("v-data-table",{attrs:{loading:t.datatableLoading,"loading-text":"Loading... Please wait","disable-pagination":!0,"hide-default-footer":!0,headers:t.headers,"item-key":"id",items:t.daftar_tasmt,dense:""},scopedSlots:t._u([{key:"item.k_status",fn:function(a){var i=a.item;return[e("v-select",{attrs:{items:t.daftar_status_mhs,"item-text":"text","item-value":"id"},model:{value:t.formdata.status_mhs[t.daftar_tasmt.indexOf(i)],callback:function(a){t.$set(t.formdata.status_mhs,t.daftar_tasmt.indexOf(i),a)},expression:"formdata.status_mhs[daftar_tasmt.indexOf(item)]"}})]}},{key:"no-data",fn:function(){return[t._v(" belum ada data tahun akademik dan semester, silahkan ganti Tahun Pendaftaran ke yang lebih kecil dari 2020 ")]},proxy:!0}])})],1)],1),e("v-card",[e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:"",loading:t.btnLoading,disabled:!t.form_valid||t.btnLoading},on:{click:function(a){return a.stopPropagation(),t.save(a)}}},[t._v("SIMPAN")])],1)],1)],1)],1)],1)],1)],1)},n=[],s=(e("4160"),e("159b"),e("96cf"),e("1da1")),r=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("v-system-bar",{staticClass:"green lighten-2 white--text",attrs:{app:"",dark:""}}),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(a){a.stopPropagation(),t.drawer=!t.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(a){a.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(a){var i=a.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account")])],1),e("v-list-item-title",[t._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(a){return a.preventDefault(),t.logout(a)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-power")])],1),e("v-list-item-title",[t._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(a){a.stopPropagation(),t.drawerRight=!t.drawerRight}}},[e("v-icon",[t._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",app:""},model:{value:t.drawer,callback:function(a){t.drawer=a},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser},on:{click:function(a){return a.stopPropagation(),t.toProfile(a)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("SYSTEM-MIGRATION_BROWSE")?e("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/system-migration"},link:"",color:"green"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-bank-transfer-in")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("MIGRASI SISTEM")])],1)],1):t._e()],1)],1),t.showrightsidebar?e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(a){t.drawerRight=a},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{staticClass:"teal lighten-5 mb-5"},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),e("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},o=[],d=(e("ac1f"),e("5319"),e("5530")),l=e("2f62"),u={name:"SystemMigrationLayout",props:{showrightsidebar:{type:Boolean,default:!0}},created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(d["a"])({},Object(l["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,a=this.ATTRIBUTE_USER("foto");return t=""==a?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+a,t}}),watch:{loginTime:{handler:function(t){var a=this;t>=0?setTimeout((function(){a.loginTime=1==a.AUTHENTICATED?a.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},c=u,m=e("2877"),f=e("6544"),h=e.n(f),v=e("40dc"),_=e("5bc1"),p=e("8212"),g=e("ce7e"),b=e("132d"),k=e("adda"),T=e("8860"),x=e("da13"),A=e("8270"),w=e("5d23"),I=e("34c3"),S=e("f6c4"),$=e("e449"),y=e("f774"),E=e("2fa4"),M=e("afd9"),C=e("2a7f"),V=Object(m["a"])(c,r,o,!1,null,null,null),R=V.exports;h()(V,{VAppBar:v["a"],VAppBarNavIcon:_["a"],VAvatar:p["a"],VDivider:g["a"],VIcon:b["a"],VImg:k["a"],VList:T["a"],VListItem:x["a"],VListItemAvatar:A["a"],VListItemContent:w["g"],VListItemIcon:I["a"],VListItemSubtitle:w["j"],VListItemTitle:w["k"],VMain:S["a"],VMenu:$["a"],VNavigationDrawer:y["a"],VSpacer:E["a"],VSystemBar:M["a"],VToolbarTitle:C["c"]});var N=e("e477"),L=e("6ba9"),P={name:"SystemMigration",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"MIGRASI SISTEM",disabled:!0,href:"#"}],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"]},mounted:function(){this.initialize()},data:function(){return{firstloading:!0,breadcrumbs:[],tahun_pendaftaran:0,form_valid:!0,btnLoading:!1,daftar_prodi:[],daftar_kelas:[],daftar_dw:[],daftar_tasmt:[],daftar_status_mhs:[],formdata:{nim:"",nirm:"",nama_mhs:"",dosen_id:"",prodi_id:"",idkelas:"",status_mhs:[]},rule_nim:[function(t){return!!t||"Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!"},function(t){return/^[0-9]+$/.test(t)||"Nomor Induk Mahasiswa (NIM) hanya boleh angka"}],rule_nirm:[function(t){return!!t||"Nomor Induk Registrasi Masuk (NIRM) mohon untuk diisi !!!"},function(t){return/^[0-9]+$/.test(t)||"Nomor Induk Registrasi Masuk (NIRM) hanya boleh angka"}],rule_nama_mhs:[function(t){return!!t||"Nama Mahasiswa mohon untuk diisi !!!"},function(t){return/^[A-Za-z\s\\,\\.]*$/.test(t)||"Nama Mahasiswa hanya boleh string dan spasi"}],rule_prodi:[function(t){return!!t||"Program studi mohon untuk dipilih !!!"}],rule_kelas:[function(t){return!!t||"Kelas mohon untuk dipilih !!!"}],rule_dw:[function(t){return!!t||"Mohon dipilih Dosen Wali untuk Mahasiswa ini !!!"}],datatableLoading:!1,headers:[{text:"TAHUN AKADEMIK",value:"ta",sortable:!1},{text:"SEMESTER",value:"semester",sortable:!1},{text:"STATUS",value:"k_status",sortable:!1,width:250}]}},methods:{changeTahunPendaftaran:function(t){this.tahun_pendaftaran=t},initialize:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.daftar_prodi=this.$store.getters["uiadmin/getDaftarProdi"],this.daftar_kelas=this.$store.getters["uiadmin/getDaftarKelas"],t.next=4,this.$ajax.get("/akademik/dosenwali",{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.daftar_dw=e.users}));case 4:return this.datatableLoading=!0,t.next=7,this.$ajax.post("/system/migration",{TA:this.tahun_pendaftaran},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.daftar_tasmt=e.daftar_tasmt;var i=a.daftar_tasmt,n=0;i.forEach((function(){a.formdata.status_mhs[n]="A",n+=1})),a.datatableLoading=!1}));case 7:this.daftar_status_mhs=this.$store.getters["uiadmin/getDaftarStatusMahasiswa"],this.firstloading=!1,this.$refs.filter9.setFirstTimeLoading(this.firstloading);case 10:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),save:function(){var t=this;this.$refs.frmdata.validate()&&(this.btnLoading=!0,this.$ajax.post("/system/migration/store",{nim:this.formdata.nim,nirm:this.formdata.nirm,nama_mhs:this.formdata.nama_mhs,dosen_id:this.formdata.dosen_id,prodi_id:this.formdata.prodi_id,idkelas:this.formdata.idkelas,tahun_pendaftaran:this.tahun_pendaftaran,status_mhs:JSON.stringify(Object.assign({},this.formdata.status_mhs))},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;console.log(e),setTimeout((function(){t.$router.go(),t.btnLoading=!1}),300)})).catch((function(){t.btnLoading=!1})))}},watch:{tahun_pendaftaran:function(){this.firstloading||this.initialize()}},components:{SystemMigrationLayout:R,ModuleHeader:N["a"],Filter9:L["a"]}},O=P,D=e("0798"),U=e("2bc5"),B=e("8336"),j=e("b0af"),H=e("99d9"),z=e("62ad"),F=e("a523"),K=e("8fea"),G=e("4bd4"),W=e("0fd9"),J=e("b974"),Y=e("8654"),Z=Object(m["a"])(O,i,n,!1,null,null,null);a["default"]=Z.exports;h()(Z,{VAlert:D["a"],VBreadcrumbs:U["a"],VBtn:B["a"],VCard:j["a"],VCardActions:H["b"],VCardText:H["d"],VCardTitle:H["e"],VCol:z["a"],VContainer:F["a"],VDataTable:K["a"],VForm:G["a"],VIcon:b["a"],VRow:W["a"],VSelect:J["a"],VSpacer:E["a"],VTextField:Y["a"]})}}]);