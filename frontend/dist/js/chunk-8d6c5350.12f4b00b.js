(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-8d6c5350"],{"73fa":function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("AkademikLayout",[a("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-format-columns ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" KARTU RENCANA STUDI ")]},proxy:!0},"mahasiswa"!=t.$store.getters["uiadmin/getDefaultDashboard"]?{key:"subtitle",fn:function(){return[t._v(" TAHUN AKADEMIK "+t._s(t.tahun_akademik)+" SEMESTER "+t._s(t.$store.getters["uiadmin/getNamaSemester"](t.semester_akademik))+" - "+t._s(t.nama_prodi)+" ")]},proxy:!0}:null,{key:"breadcrumbs",fn:function(){return[a("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[a("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[a("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman untuk melakukan tambah krs ")])]},proxy:!0}],null,!0)}),a("v-container",{attrs:{fluid:""}},[a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[a("v-card",[a("v-card-title",[t._v(" PILIH TAHUN & SEMESTER DAFTAR ULANG ")]),a("v-card-text",[a("v-alert",{attrs:{type:"info"}},[t._v(" Silahkan pilih tahun dan semester daftar ulang. Bila tidak ada disebabkan belum melakukan pembayaran atau status daftar ulang dinyatakan tidak aktif ")]),a("v-text-field",{attrs:{label:"NIM",rules:t.rule_nim,outlined:"","append-outer-icon":"mdi-send",disabled:"mahasiswa"==this.$store.getters["uiadmin/getDefaultDashboard"]},on:{"click:append-outer":t.cekNIM},model:{value:t.formdata.nim,callback:function(e){t.$set(t.formdata,"nim",e)},expression:"formdata.nim"}}),a("v-select",{staticClass:"mr-2",attrs:{items:t.daftar_dulang,label:"DAFTAR ULANG",rules:t.rule_dulang,outlined:""},model:{value:t.formdata.dulang_id,callback:function(e){t.$set(t.formdata,"dulang_id",e)},expression:"formdata.dulang_id"}})],1),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.closedialogfrm(e)}}},[t._v("BATAL")]),a("v-btn",{attrs:{color:"blue darken-1",text:"",loading:t.btnLoading,disabled:!t.form_valid||t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.save(e)}}},[t._v(" BUAT ")])],1)],1)],1)],1)],1)],1)],1)},s=[],r=(a("96cf"),a("1da1")),n=a("e60c"),o=a("e477"),l={name:"PerkuliahanKRSTambah",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"PERKULIAHAN",disabled:!1,href:"#"},{text:"KRS",disabled:!1,href:"/akademik/perkuliahan/krs/daftar"},{text:"TAMBAH",disabled:!0,href:"#"}];var t=this.$store.getters["uiadmin/getProdiID"];this.prodi_id=t,this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"],this.ta_matkul=this.tahun_akademik,this.daftar_semester=this.$store.getters["uiadmin/getDaftarSemester"],this.semester_akademik=this.$store.getters["uiadmin/getSemesterAkademik"],"mahasiswa"==this.$store.getters["uiadmin/getDefaultDashboard"]&&(this.formdata.nim=this.$store.getters["auth/AttributeUser"]("username"),this.fetchDulang())},data:function(){return{firstloading:!0,prodi_id:null,nama_prodi:null,tahun_akademik:null,ta_matkul:null,semester_akademik:null,btnLoading:!1,dialogdetailitem:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"KODE",value:"kmatkul",sortable:!0,width:120},{text:"NAMA MATAKULIAH",value:"nmatkul",sortable:!0},{text:"KELOMPOK",value:"group_alias",sortable:!0,width:120},{text:"SKS",value:"sks",sortable:!0,width:80,align:"center"},{text:"SMT",value:"semester",sortable:!0,width:80},{text:"AKSI",value:"actions",sortable:!1,width:100}],search:"",form_valid:!0,daftar_dulang:[],formdata:{nim:"",dulang_id:""},rule_nim:[function(t){return!!t||"Nomor Induk Mahasiswa (NIM) mohon untuk diisi !!!"},function(t){return/^[0-9]+$/.test(t)||"Nomor Induk Mahasiswa (NIM) hanya boleh angka"}],rule_dulang:[function(t){return!!t||"Mohon dipilih Daftar Ulang yang telah dilakukan !!!"}]}},methods:{fetchDulang:function(){var t=this;return Object(r["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$ajax.post("/akademik/dulang/dulangnotinkrs",{nim:t.formdata.nim},{headers:{Authorization:t.$store.getters["auth/Token"]}}).then((function(e){var a=e.data;t.daftar_dulang=a.daftar_dulang}));case 2:case"end":return e.stop()}}),e)})))()},cekNIM:function(){this.formdata.nim.length>0&&this.fetchDulang()},save:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!this.$refs.frmdata.validate()){t.next=4;break}return this.btnLoading=!0,t.next=4,this.$ajax.post("/akademik/perkuliahan/krs/store",{nim:this.formdata.nim,dulang_id:this.formdata.dulang_id},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var a=t.data;e.$router.push("/akademik/perkuliahan/krs/"+a.krs.id+"/detail"),e.btnLoading=!1})).catch((function(){e.btnLoading=!1}));case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),closedialogfrm:function(){var t=this;setTimeout((function(){t.formdata=Object.assign({},t.formdefault),t.$router.push("/akademik/perkuliahan/krs/daftar")}),300)}},components:{AkademikLayout:n["a"],ModuleHeader:o["a"]}},m=l,d=a("2877"),c=a("6544"),u=a.n(c),v=a("0798"),A=a("2bc5"),h=a("8336"),S=a("b0af"),g=a("99d9"),k=a("62ad"),_=a("a523"),E=a("4bd4"),p=a("132d"),C=a("0fd9"),f=a("b974"),T=a("2fa4"),I=a("8654"),b=Object(d["a"])(m,i,s,!1,null,null,null);e["default"]=b.exports;u()(b,{VAlert:v["a"],VBreadcrumbs:A["a"],VBtn:h["a"],VCard:S["a"],VCardActions:g["b"],VCardText:g["d"],VCardTitle:g["e"],VCol:k["a"],VContainer:_["a"],VForm:E["a"],VIcon:p["a"],VRow:C["a"],VSelect:f["a"],VSpacer:T["a"],VTextField:I["a"]})},e477:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:t.isReportPage}},[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("h1",{staticClass:"subheading grey--text"},[a("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},s=[],r={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},n=r,o=a("2877"),l=a("6544"),m=a.n(l),d=a("62ad"),c=a("a523"),u=a("132d"),v=a("0fd9"),A=Object(o["a"])(n,i,s,!1,null,null,null);e["a"]=A.exports;m()(A,{VCol:d["a"],VContainer:c["a"],VIcon:u["a"],VRow:v["a"]})},e60c:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}}),a("v-app-bar",{attrs:{app:""}},[a("v-app-bar-nav-icon",{class:this.$store.getters["uiadmin/getTheme"]("V-APP-BAR-NAV-ICON-CSS-CLASS"),on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),a("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[a("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),a("v-spacer"),a("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[a("v-list",[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list-item",{attrs:{to:"/system-users/profil"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-title",[t._v("Profil")])],1),a("v-divider"),a("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-power")])],1),a("v-list-item-title",[t._v("Logout")])],1)],1)],1),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawerRight=!t.drawerRight}}},[a("v-icon",[t._v("mdi-menu-open")])],1)],1),a("v-navigation-drawer",{class:this.$store.getters["uiadmin/getTheme"]("V-NAVIGATION-DRAWER-CSS-CLASS"),attrs:{width:"300",dark:"",temporary:t.hideleftnav,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("AKADEMIK-GROUP")?a("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-CSS-CLASS"),attrs:{to:{path:"/akademik"},link:"",color:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-COLOR")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-monitor-dashboard")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("BOARD AKADEMIK")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-DOSEN-WALI_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/dosenwali","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-teach")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DOSEN WALI ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-MATAKULIAH_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/matakuliah","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-book")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" MATAKULIAH ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")||t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?a("v-subheader",[t._v("DAFTAR ULANG")]):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mhsbelumpunyanim","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-book")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" BELUM PUNYA NIM ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswabaru","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-book")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" MAHASISWA BARU ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswalama","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-book")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" MAHASISWA LAMA ")])],1)],1):t._e(),a("v-subheader",[t._v("KEMAHASISWAAN")]),t.CAN_ACCESS("AKADEMIK-KEMAHASISWAAN-DAFTAR-MAHASISWA_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/akademik/kemahasiswaan/daftarmahasiswa","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-book")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DAFTAR MAHASISWA ")])],1)],1):t._e(),a("v-subheader",[t._v("PERKULIAHAN")]),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?a("v-list-group",{attrs:{group:"/akademik/perkuliahan/penyelenggaraan","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-floor-b")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("PENYELENGGARAAN")])],1)]},proxy:!0}],null,!1,2791626149)},[a("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/penyelenggaraan/daftar",color:"white"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/penyelenggaraan/tambah"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/penyelenggaraan/"+t.paramid+"/dosenpengampu"}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DOSEN PENGAMPU ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?a("v-list-group",{attrs:{group:"/akademik/perkuliahan/krs","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-format-columns")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("KRS")])],1)]},proxy:!0}],null,!1,2196385036)},[a("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/krs/daftar",color:"white"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/krs/tambah"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAMBAH KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_SHOW")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/detail"}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DETAIL KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/tambahmatkul"}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?a("v-list-group",{attrs:{group:"/akademik/perkuliahan/pembagiankelas","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-google-classroom")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("PEMBAGIAN KELAS")])],1)]},proxy:!0}],null,!1,3897047730)},[a("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/pembagiankelas/daftar",color:"white"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/pembagiankelas/tambah"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAMBAH KELAS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/pembagiankelas/"+t.paramid+"/peserta"}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PESERTA ")])],1)],1):t._e()],1)]):t._e(),"puslahta"==t.dashboard?a("v-subheader",[t._v("NILAI")]):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_BROWSE")&&"puslahta"==t.dashboard?a("v-list-group",{attrs:{group:"/akademik/nilai/matakuliah","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-format-columns")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("ISI NILAI")])],1)]},proxy:!0}],null,!1,927400214)},[a("div",[t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"puslahta"==t.dashboard?a("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperkelasmhs",color:"white"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PER KELAS MHS ")])],1)],1):t._e()],1)]):t._e()],1)],1),t.showrightsidebar?a("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(e){t.drawerRight=e},expression:"drawerRight"}},[a("v-list",{attrs:{dense:""}},[a("v-list-item",[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-menu-open")])],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),a("v-divider"),a("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-filter")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),a("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},s=[],r=(a("b0c0"),a("ac1f"),a("5319"),a("5530")),n=a("2f62"),o={name:"AkademikLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(r["a"])({},Object(n["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t},hideleftnav:function(){return"ReportFormBMurni"==this.$route.name},paramid:function(){var t="empty";switch(this.$route.name){case"PerkuliahanPenyelenggaraanDosenPengampu":t=this.$route.params.idpenyelenggaraan;break;case"PerkuliahanKRSDetail":t=this.$route.params.krsid;break;case"PerkuliahanKRSTambahMatkul":t=this.$route.params.krsid;break;case"PerkuliahanPembagianKelasPeserta":t=this.$route.params.kelas_mhs_id;break}return t}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,m=a("2877"),d=a("6544"),c=a.n(d),u=a("40dc"),v=a("5bc1"),A=a("8212"),h=a("ce7e"),S=a("132d"),g=a("adda"),k=a("8860"),_=a("56b0"),E=a("da13"),p=a("8270"),C=a("5d23"),f=a("34c3"),T=a("f6c4"),I=a("e449"),b=a("f774"),L=a("2fa4"),R=a("e0c7"),N=a("afd9"),K=a("2a7f"),M=Object(m["a"])(l,i,s,!1,null,null,null);e["a"]=M.exports;c()(M,{VAppBar:u["a"],VAppBarNavIcon:v["a"],VAvatar:A["a"],VDivider:h["a"],VIcon:S["a"],VImg:g["a"],VList:k["a"],VListGroup:_["a"],VListItem:E["a"],VListItemAvatar:p["a"],VListItemContent:C["g"],VListItemIcon:f["a"],VListItemSubtitle:C["j"],VListItemTitle:C["k"],VMain:T["a"],VMenu:I["a"],VNavigationDrawer:b["a"],VSpacer:L["a"],VSubheader:R["a"],VSystemBar:N["a"],VToolbarTitle:K["c"]})}}]);