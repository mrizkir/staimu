(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-8d6bbd9a"],{"6fdf":function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("AkademikLayout",{attrs:{showrightsidebar:!1,temporaryleftsidebar:!0}},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-book-open-outline ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" KONVERSI NILAI ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v(" TAHUN PENDAFTARAN "+t._s(t.tahun_pendaftaran)+" - "+t._s(t.nama_prodi)+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman ini digunakan untuk mengelola konversi nilai mahasiswa pindahan/ampulan ")])]},proxy:!0}])}),e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(a){t.form_valid=a},expression:"form_valid"}},[e("v-container",{attrs:{fluid:""}},[e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-title",[t._v(" Data Konversi ")]),e("v-card-text",[e("v-text-field",{attrs:{label:"NIM ASAL",rules:t.rule_nim_asal,outlined:""},model:{value:t.formdata.nim_asal,callback:function(a){t.$set(t.formdata,"nim_asal",a)},expression:"formdata.nim_asal"}}),e("v-text-field",{attrs:{label:"NAMA",rules:t.rule_nama_mhs,outlined:""},model:{value:t.formdata.nama_mhs,callback:function(a){t.$set(t.formdata,"nama_mhs",a)},expression:"formdata.nama_mhs"}}),e("v-text-field",{attrs:{label:"ALAMAT",outlined:"",rules:t.rule_alamat},model:{value:t.formdata.alamat,callback:function(a){t.$set(t.formdata,"alamat",a)},expression:"formdata.alamat"}}),e("v-text-field",{attrs:{label:"NO. TELEPON/HP",outlined:"",rules:t.rule_telepon},model:{value:t.formdata.no_telp,callback:function(a){t.$set(t.formdata,"no_telp",a)},expression:"formdata.no_telp"}}),e("v-text-field",{attrs:{label:"EMAIL",outlined:"",rules:t.rule_email},model:{value:t.formdata.email,callback:function(a){t.$set(t.formdata,"email",a)},expression:"formdata.email"}}),e("v-text-field",{attrs:{label:"KODE P.T. ASAL",outlined:"",rules:t.rule_kode_pt_asal},model:{value:t.formdata.kode_pt_asal,callback:function(a){t.$set(t.formdata,"kode_pt_asal",a)},expression:"formdata.kode_pt_asal"}}),e("v-text-field",{attrs:{label:"NAMA P.T. ASAL",outlined:"",rules:t.rule_nama_pt_asal},model:{value:t.formdata.nama_pt_asal,callback:function(a){t.$set(t.formdata,"nama_pt_asal",a)},expression:"formdata.nama_pt_asal"}}),e("v-select",{attrs:{label:"JENJANG",items:t.daftar_jenjang,"item-text":"nama_jenjang","item-value":"kode_jenjang",outlined:"",rules:t.rule_kode_jenjang},model:{value:t.formdata.kode_jenjang,callback:function(a){t.$set(t.formdata,"kode_jenjang",a)},expression:"formdata.kode_jenjang"}}),e("v-text-field",{attrs:{label:"KODE PRODI ASAL",rules:t.rule_kode_ps_asal,outlined:""},model:{value:t.formdata.kode_ps_asal,callback:function(a){t.$set(t.formdata,"kode_ps_asal",a)},expression:"formdata.kode_ps_asal"}}),e("v-text-field",{attrs:{label:"NAMA PRODI ASAL",rules:t.rule_nama_ps_asal,outlined:""},model:{value:t.formdata.nama_ps_asal,callback:function(a){t.$set(t.formdata,"nama_ps_asal",a)},expression:"formdata.nama_ps_asal"}})],1),e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:"",href:"/akademik/nilai/konversi"}},[t._v("BATAL")]),e("v-btn",{attrs:{color:"blue darken-1",text:"",disabled:!t.form_valid||t.btnLoading},on:{click:function(a){return a.stopPropagation(),t.save(a)}}},[t._v(" SIMPAN ")])],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,search:t.search,"item-key":"id","disable-pagination":!0,"hide-default-footer":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},scopedSlots:t._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[t._v("KURIKULUM MATAKULIAH T.A "+t._s(t.tahun_pendaftaran))]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer")],1)]},proxy:!0},{key:"item.kmatkul_asal",fn:function(a){return[e("v-text-field",{attrs:{dense:""},model:{value:a.item.kmatkul_asal,callback:function(e){t.$set(a.item,"kmatkul_asal",e)},expression:"props.item.kmatkul_asal"}})]}},{key:"item.matkul_asal",fn:function(a){return[e("v-text-field",{attrs:{dense:""},model:{value:a.item.matkul_asal,callback:function(e){t.$set(a.item,"matkul_asal",e)},expression:"props.item.matkul_asal"}})]}},{key:"item.sks_asal",fn:function(a){return[e("v-text-field",{attrs:{dense:""},model:{value:a.item.sks_asal,callback:function(e){t.$set(a.item,"sks_asal",e)},expression:"props.item.sks_asal"}})]}},{key:"item.n_kual",fn:function(a){return[e("v-select",{staticStyle:{width:"65px"},attrs:{items:t.$store.getters["uiadmin/getSkalaNilai"],dense:""},model:{value:a.item.n_kual,callback:function(e){t.$set(a.item,"n_kual",e)},expression:"props.item.n_kual"}})]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)],1)},s=[],n=e("1da1"),r=(e("159b"),e("96cf"),e("e60c")),l=e("e477"),o={name:"NilaiKonversiTambah",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"NILAI",disabled:!1,href:"#"},{text:"KONVERSI MAHASISWA PINDAHAN/AMPULAN",disabled:!1,href:"/akademik/nilai/konversi"},{text:"TAMBAH",disabled:!0,href:"#"}];var t=this.$store.getters["uiadmin/getProdiID"];this.prodi_id=t,this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"],this.initialize()},data:function(){return{prodi_id:null,nama_prodi:null,tahun_pendaftaran:null,btnLoading:!1,btnLoadingTable:!1,datatableLoading:!1,datatable:[],headers:[{text:"KODE",value:"kmatkul",sortable:!1,width:100},{text:"NAMA",value:"nmatkul",sortable:!1,width:250},{text:"SKS",value:"sks",sortable:!1,width:70},{text:"SMT",value:"semester",sortable:!0,width:70},{text:"KODE MATKUL ASAL",value:"kmatkul_asal",sortable:!1,width:120},{text:"MATAKULIAH ASAL",value:"matkul_asal",sortable:!1,width:170},{text:"SKS ASAL",value:"sks_asal",sortable:!1,width:70},{text:"NILAI",value:"n_kual",sortable:!1,width:70}],search:"",form_valid:!0,daftar_jenjang:[],formdata:{id:"",user_id:"",nim:"",nama_mhs:"",alamat:"",no_telp:"",nim_asal:"",kode_jenjang:"",kode_pt_asal:"",nama_pt_asal:"",kode_ps_asal:"",nama_ps_asal:"",tahun:"",kjur:"",perpanjangan:""},formdefault:{id:"",user_id:"",nim:"",nama_mhs:"",alamat:"",no_telp:"",nim_asal:"",kode_jenjang:"",kode_pt_asal:"",nama_pt_asal:"",kode_ps_asal:"",nama_ps_asal:"",tahun:"",kjur:"",perpanjangan:""},rule_nim_asal:[function(t){return!!t||"Mohon di isi nim mahasiswa pindahan/ampulan dengan  nim dari perguruan tinggi asal !!!"}],rule_nama_mhs:[function(t){return!!t||"Mohon di isi nama mahasiswa pindahan/ampulan dari perguruan tinggi asal !!!"},function(t){return/^[A-Za-z\s]*$/.test(t)||"Nama mahasiswa pindahan/ampulan hanya boleh string dan spasi"}],rule_alamat:[function(t){return!!t||"Mohon di isi alamat mahasiswa pindahan/ampulan !!!"}],rule_telepon:[function(t){return!!t||"Mohon di isi nomor hp mahasiswa pindahan/ampulan !!!"},function(t){return/^\+[1-9]{1}[0-9]{1,14}$/.test(t)||"Nomor HP/Telepon hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388"}],rule_email:[function(t){return!!t||"Mohon di isi email mahasiswa pindahan/ampulan !!!"},function(t){return/.+@.+\..+/.test(t)||"Format E-mail mohon di isi dengan benar"}],rule_kode_pt_asal:[function(t){return!!t||"Mohon di isi kode perguruan tinggi asal !!!"},function(t){return/^[0-9]+$/.test(t)||"Kode perguruan tinggi asal hanya boleh angka"}],rule_nama_pt_asal:[function(t){return!!t||"Mohon di isi nama perguruan tinggi asal !!!"}],rule_kode_jenjang:[function(t){return!!t||"Mohon dipilih Jenjang Studi dari perguruan tinggi asal !!!"}],rule_kode_ps_asal:[function(t){return!!t||"Mohon di isi kode program studi dari perguruan tinggi asal !!!"},function(t){return/^[0-9]+$/.test(t)||"Kode program studi asal hanya boleh angka"}],rule_nama_ps_asal:[function(t){return!!t||"Mohon di isi nama program studi dari tinggi asal !!!"}]}},methods:{initialize:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.post("/akademik/nilai/konversi/matakuliah",{prodi_id:this.prodi_id,ta:this.tahun_pendaftaran},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatable=e.matakuliah,a.datatableLoading=!1})).catch((function(){a.datatableLoading=!1}));case 3:return t.next=5,this.$ajax.get("/datamaster/programstudi/jenjangstudi").then((function(t){var e=t.data;a.daftar_jenjang=e.jenjangstudi}));case 5:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),save:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var a,e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!this.$refs.frmdata.validate()){t.next=6;break}return this.btnLoading=!0,a=[],this.datatable.forEach((function(t){t.kmatkul_asal&&t.matkul_asal&&t.sks_asal&&t.n_kual&&a.push({matkul_id:t.id,kmatkul_asal:t.kmatkul_asal,matkul_asal:t.matkul_asal,sks_asal:t.sks_asal,n_kual:t.n_kual})})),t.next=6,this.$ajax.post("/akademik/nilai/konversi/store",{nim_asal:this.formdata.nim_asal,nama_mhs:this.formdata.nama_mhs,alamat:this.formdata.alamat,no_telp:this.formdata.no_telp,email:this.formdata.email,kode_jenjang:this.formdata.kode_jenjang,kode_pt_asal:this.formdata.kode_pt_asal,nama_pt_asal:this.formdata.nama_pt_asal,kode_ps_asal:this.formdata.kode_ps_asal,nama_ps_asal:this.formdata.nama_ps_asal,tahun:this.tahun_pendaftaran,kjur:this.prodi_id,daftar_nilai:JSON.stringify(Object.assign({},a))},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var a=t.data;e.$router.push("/akademik/nilai/konversi/"+a.data_konversi.id+"/edit"),e.btnLoading=!1})).catch((function(){e.btnLoading=!1}));case 6:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}()},components:{AkademikLayout:r["a"],ModuleHeader:l["a"]}},m=o,d=e("2877"),u=e("6544"),c=e.n(u),v=e("0798"),A=e("2bc5"),_=e("8336"),h=e("b0af"),S=e("99d9"),k=e("62ad"),p=e("a523"),g=e("8fea"),f=e("ce7e"),E=e("4bd4"),C=e("132d"),I=e("0fd9"),T=e("b974"),b=e("2fa4"),L=e("8654"),K=e("71d9"),N=e("2a7f"),R=Object(d["a"])(m,i,s,!1,null,null,null);a["default"]=R.exports;c()(R,{VAlert:v["a"],VBreadcrumbs:A["a"],VBtn:_["a"],VCard:h["a"],VCardActions:S["b"],VCardText:S["d"],VCardTitle:S["e"],VCol:k["a"],VContainer:p["a"],VDataTable:g["a"],VDivider:f["a"],VForm:E["a"],VIcon:C["a"],VRow:I["a"],VSelect:T["a"],VSpacer:b["a"],VTextField:L["a"],VToolbar:K["a"],VToolbarTitle:N["c"]})},e477:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-container",{attrs:{fluid:t.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},s=[],n={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=n,l=e("2877"),o=e("6544"),m=e.n(o),d=e("62ad"),u=e("a523"),c=e("132d"),v=e("0fd9"),A=Object(l["a"])(r,i,s,!1,null,null,null);a["a"]=A.exports;m()(A,{VCol:d["a"],VContainer:u["a"],VIcon:c["a"],VRow:v["a"]})},e60c:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[e("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{class:this.$store.getters["uiadmin/getTheme"]("V-APP-BAR-NAV-ICON-CSS-CLASS"),on:{click:function(a){a.stopPropagation(),t.drawer=!t.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(a){a.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(a){var i=a.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" [ "+t._s(t.DEFAULT_ROLE)+" ] ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account")])],1),e("v-list-item-title",[t._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(a){return a.preventDefault(),t.logout(a)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-power")])],1),e("v-list-item-title",[t._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(a){a.stopPropagation(),t.drawerRight=!t.drawerRight}}},[e("v-icon",[t._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{class:this.$store.getters["uiadmin/getTheme"]("V-NAVIGATION-DRAWER-CSS-CLASS"),attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(a){t.drawer=a},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser},on:{click:function(a){return a.stopPropagation(),t.toProfile(a)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v("[ "+t._s(t.DEFAULT_ROLE)+" ]")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("AKADEMIK-GROUP")?e("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-CSS-CLASS"),attrs:{to:{path:"/akademik"},link:"",color:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-COLOR")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-monitor-dashboard")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("BOARD AKADEMIK")])],1)],1):t._e(),e("v-subheader",[t._v("PERWALIAN")]),t.CAN_ACCESS("SYSTEM-USERS-DOSEN-WALI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dosenwali","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-teach")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DOSEN WALI ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")||t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?e("v-subheader",[t._v(" DAFTAR ULANG ")]):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mhsbelumpunyanim","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-alert")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BELUM PUNYA NIM ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswabaru","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-arrow-left")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MAHASISWA BARU ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswalama","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-box-multiple")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MAHASISWA LAMA ")])],1)],1):t._e(),e("v-subheader",[t._v("PERKULIAHAN")]),t.CAN_ACCESS("AKADEMIK-MATAKULIAH_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/matakuliah","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-book")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MATAKULIAH ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/penyelenggaraan","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-home-floor-b")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("PENYELENGGARAAN")])],1)]},proxy:!0}],null,!1,2791626149)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/penyelenggaraan/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/penyelenggaraan/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/penyelenggaraan/"+t.paramid+"/dosenpengampu"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DOSEN PENGAMPU ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/krs","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-format-columns")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("KRS")])],1)]},proxy:!0}],null,!1,2196385036)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/krs/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/krs/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_SHOW")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/detail"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DETAIL KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/tambahmatkul"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-VERIFIKASI-KRS_STORE")?e("v-list-item",{attrs:{link:"",to:{path:"/akademik/perkuliahan/krs/verifikasi"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" VERIFIKASI KRS ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/pembagiankelas","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-google-classroom")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("PEMBAGIAN KELAS")])],1)]},proxy:!0}],null,!1,3897047730)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/pembagiankelas/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/pembagiankelas/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH KELAS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/pembagiankelas/"+t.paramid+"/peserta"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PESERTA ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-UJIAN-MUNAQASAH_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/perkuliahan/ujianmunaqasah","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-run-fast")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" UJIAN MUNAQASAH ")])],1)],1):t._e(),e("v-subheader",[t._v("NILAI")]),!t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_BROWSE")||"puslahta"!=t.dashboard&&"dosen"!=t.dashboard?t._e():e("v-list-group",{attrs:{group:"/akademik/nilai/matakuliah","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-format-columns")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("ISI NILAI")])],1)]},proxy:!0}],null,!1,927400214)},[e("div",[t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"dosen"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperdosen",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KELAS MHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"puslahta"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperkelasmhs",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KELAS MHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"puslahta"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperkrs",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KRS ")])],1)],1):t._e()],1)]),t.CAN_ACCESS("AKADEMIK-NILAI-KONVERSI_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/konversi"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KONVERSI NILAI ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-KHS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/khs"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-TRANSKRIP-KURIKULUM_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/transkripkurikulum"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSKRIP KURIKULUM ")])],1)],1):t._e()],1)],1),t.showrightsidebar?e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(a){t.drawerRight=a},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),e("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),e("v-footer",{attrs:{app:"",padless:"",fixed:""}},[e("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[e("v-divider"),e("v-card-text",{staticClass:"py-2 black--text text-center"},[e("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM ITSTAI Miftahul 'Ulum Tanjungpinang "),e("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[e("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},s=[],n=e("5530"),r=(e("b0c0"),e("5319"),e("ac1f"),e("2f62")),l={name:"AkademikLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(n["a"])(Object(n["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,a=this.ATTRIBUTE_USER("foto");return t=""==a?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+a,t},paramid:function(){var t="empty";switch(this.$route.name){case"PerkuliahanPenyelenggaraanDosenPengampu":t=this.$route.params.idpenyelenggaraan;break;case"PerkuliahanKRSDetail":t=this.$route.params.krsid;break;case"PerkuliahanKRSTambahMatkul":t=this.$route.params.krsid;break;case"PerkuliahanPembagianKelasPeserta":t=this.$route.params.kelas_mhs_id;break}return t}}),watch:{loginTime:{handler:function(t){var a=this;t>=0?setTimeout((function(){a.loginTime=1==a.AUTHENTICATED?a.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},o=l,m=e("2877"),d=e("6544"),u=e.n(d),c=e("40dc"),v=e("5bc1"),A=e("8212"),_=e("8336"),h=e("b0af"),S=e("99d9"),k=e("ce7e"),p=e("553a"),g=e("132d"),f=e("adda"),E=e("8860"),C=e("56b0"),I=e("da13"),T=e("8270"),b=e("5d23"),L=e("34c3"),K=e("f6c4"),N=e("e449"),R=e("f774"),M=e("2fa4"),x=e("e0c7"),V=e("afd9"),w=e("2a7f"),$=Object(m["a"])(o,i,s,!1,null,null,null);a["a"]=$.exports;u()($,{VAppBar:c["a"],VAppBarNavIcon:v["a"],VAvatar:A["a"],VBtn:_["a"],VCard:h["a"],VCardText:S["d"],VDivider:k["a"],VFooter:p["a"],VIcon:g["a"],VImg:f["a"],VList:E["a"],VListGroup:C["a"],VListItem:I["a"],VListItemAvatar:T["a"],VListItemContent:b["g"],VListItemIcon:L["a"],VListItemSubtitle:b["j"],VListItemTitle:b["k"],VMain:K["a"],VMenu:N["a"],VNavigationDrawer:R["a"],VSpacer:M["a"],VSubheader:x["a"],VSystemBar:V["a"],VToolbarTitle:w["c"]})}}]);