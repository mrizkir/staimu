(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-90f81bc0"],{"0639":function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-list-item",[e("v-list-item-content",[e("v-select",{attrs:{items:t.daftar_prodi,"item-text":"text","item-value":"id",label:"PROGRAM STUDI",outlined:""},model:{value:t.prodi_id,callback:function(a){t.prodi_id=a},expression:"prodi_id"}}),e("v-select",{attrs:{items:t.daftar_ta,label:"TAHUN PENDAFTARAN",outlined:""},model:{value:t.tahun_pendaftaran,callback:function(a){t.tahun_pendaftaran=a},expression:"tahun_pendaftaran"}})],1)],1)},n=[],s={name:"FilterMode7",created:function(){this.daftar_prodi=this.$store.getters["uiadmin/getDaftarProdi"],this.prodi_id=this.$store.getters["uiadmin/getProdiID"],this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"]},data:function(){return{firstloading:!0,daftar_prodi:[],prodi_id:null,daftar_ta:[],tahun_pendaftaran:null}},methods:{setFirstTimeLoading:function(t){this.firstloading=t}},watch:{tahun_pendaftaran:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateTahunPendaftaran",t),this.$emit("changeTahunPendaftaran",t))},prodi_id:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateProdi",t),this.$emit("changeProdi",t))}}},r=s,o=e("2877"),l=e("6544"),d=e.n(l),c=e("da13"),u=e("5d23"),m=e("b974"),v=Object(o["a"])(r,i,n,!1,null,null,null);a["a"]=v.exports;d()(v,{VListItem:c["a"],VListItemContent:u["g"],VSelect:m["a"]})},"9cc6":function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("KeuanganLayout",{scopedSlots:t._u(["mahasiswa"!=t.dashboard&&"mahasiswabaru"!=t.dashboard?{key:"filtersidebar",fn:function(){return[e("Filter7",{ref:"filter7",on:{changeTahunPendaftaran:t.changeTahunPendaftaran,changeProdi:t.changeProdi}})]},proxy:!0}:null],null,!0)},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-video-input-component ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" BIAYA KOMPONEN PER PERIODE ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v(" TAHUN PENDAFTARAN "+t._s(t.tahun_pendaftaran)+" - PROGRAM STUDI "+t._s(t.nama_prodi)+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman ini berisi informasi biaya komponen biaya per periode yang masing-masing. ")])]},proxy:!0}])}),e("v-container",{attrs:{fluid:""}},["mahasiswa"!=t.dashboard&&"mahasiswabaru"!=t.dashboard?e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-title",[t._v(" FILTER ")]),e("v-card-text",[e("v-select",{attrs:{label:"KELAS",items:t.daftar_kelas,"item-text":"text","item-value":"id",outlined:"",clearable:""},model:{value:t.filter_idkelas,callback:function(a){t.filter_idkelas=a},expression:"filter_idkelas"}})],1)],1)],1)],1):t._e(),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-text",[e("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":"",outlined:""},model:{value:t.search,callback:function(a){t.search=a},expression:"search"}})],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,search:t.search,"item-key":"id","sort-by":"idkelas","show-expand":"","disable-pagination":!0,"hide-default-footer":!0,expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(a){t.expanded=a},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[t._v("DAFTAR BIAYA KOMPONEN PER PERIODE")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer"),"mahasiswa"!=t.dashboard&&"mahasiswabaru"!=t.dashboard?e("v-btn",{staticClass:"mb-2",attrs:{color:"primary",loading:t.btnLoading,disabled:t.btnLoading},on:{click:function(a){return a.stopPropagation(),t.loadkombiperiode(a)}}},[t._v(" GENERATE KOMPONEN BIAYA ")]):t._e()],1)]},proxy:!0},{key:"item.biaya",fn:function(a){return[e("v-edit-dialog",{attrs:{"return-value":a.item.biaya,large:""},on:{"update:returnValue":function(e){return t.$set(a.item,"biaya",e)},"update:return-value":function(e){return t.$set(a.item,"biaya",e)},save:function(e){return t.saveItem({id:a.item.id,biaya:a.item.biaya})},cancel:t.cancelItem,open:t.openItem,close:t.closeItem},scopedSlots:t._u([{key:"input",fn:function(){return[e("div",{staticClass:"mt-4 title"},[t._v("Update Biaya")]),e("v-currency-field",{attrs:{label:"BIAYA KOMPONEN",min:null,max:null,outlined:"",autofocus:""},model:{value:a.item.biaya,callback:function(e){t.$set(a.item,"biaya",e)},expression:"props.item.biaya"}})]},proxy:!0}],null,!0)},[t._v(" "+t._s(t._f("formatUang")(a.item.biaya))+" ")])]}},{key:"item.idkelas",fn:function(a){var e=a.item;return[t._v(" "+t._s(t.$store.getters["uiadmin/getNamaKelas"](e.idkelas))+" ")]}},{key:"expanded-item",fn:function(a){var i=a.headers,n=a.item;return[e("td",{staticClass:"text-center",attrs:{colspan:i.length}},[e("v-col",{attrs:{cols:"12"}},[e("strong",[t._v("ID:")]),t._v(t._s(n.id)+" "),e("strong",[t._v("created_at:")]),t._v(t._s(t.$date(n.created_at).format("DD/MM/YYYY HH:mm"))+" "),e("strong",[t._v("updated_at:")]),t._v(t._s(t.$date(n.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},n=[],s=(e("96cf"),e("1da1")),r=e("c8b0"),o=e("e477"),l=e("0639"),d={name:"BiayaKomponenPeriode",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"],this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"KEUANGAN",disabled:!1,href:"/keuangan"},{text:"BIAYA KOMPONEN PER PERIODE",disabled:!0,href:"#"}],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"],this.prodi_id=this.$store.getters["uiadmin/getProdiID"],this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](this.prodi_id),this.daftar_kelas=this.$store.getters["uiadmin/getDaftarKelas"],this.initialize()},data:function(){return{dashboard:null,firstloading:!0,breadcrumbs:[],tahun_pendaftaran:0,prodi_id:null,nama_prodi:null,filter_idkelas:"",daftar_kelas:[],btnLoading:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"ID KOMPONEN",value:"kombi_id",width:10,sortable:!1},{text:"NAMA KOMPONEN",value:"nama_kombi",sortable:!1},{text:"PERIODE",value:"periode",width:150,sortable:!1},{text:"KELAS",value:"nkelas",width:120,sortable:!1},{text:"BIAYA",value:"biaya",width:150,sortable:!1}],search:""}},methods:{changeTahunPendaftaran:function(t){this.tahun_pendaftaran=t},changeProdi:function(t){this.prodi_id=t},initialize:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.post("/keuangan/biayakomponenperiode",{TA:this.tahun_pendaftaran,prodi_id:this.prodi_id},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatable=e.kombi,a.datatableLoading=!1}));case 3:this.firstloading=!1,this.$refs.filter7.setFirstTimeLoading(this.firstloading);case 5:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]},loadkombiperiode:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.btnLoading=!0,t.next=3,this.$ajax.post("/keuangan/biayakomponenperiode/loadkombiperiode",{TA:this.tahun_pendaftaran,prodi_id:this.prodi_id},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatable=e.kombi,a.btnLoading=!1}));case 3:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),saveItem:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(a){var e,i,n=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return e=a.id,i=a.biaya,t.next=3,this.$ajax.post("/keuangan/biayakomponenperiode/updatebiaya",{id:e,biaya:i},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(){n.initialize()}));case 3:case"end":return t.stop()}}),t,this)})));function a(a){return t.apply(this,arguments)}return a}(),cancelItem:function(){},openItem:function(){},closeItem:function(){}},watch:{tahun_pendaftaran:function(){this.firstloading||this.initialize()},prodi_id:function(t){this.firstloading||(this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.initialize())},filter_idkelas:function(t){var a=this;this.firstloading||(t&&"undefined"!==typeof t&&t.length>0?(this.datatableLoading=!0,this.$ajax.post("/keuangan/biayakomponenperiode",{TA:this.tahun_pendaftaran,prodi_id:this.prodi_id,filter_idkelas:t},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatable=e.kombi,a.datatableLoading=!1}))):this.initialize())}},components:{KeuanganLayout:r["a"],ModuleHeader:o["a"],Filter7:l["a"]}},c=d,u=e("2877"),m=e("6544"),v=e.n(m),h=e("0798"),p=e("2bc5"),f=e("8336"),_=e("b0af"),b=e("99d9"),g=e("62ad"),A=e("a523"),k=e("8fea"),E=e("ce7e"),N=e("7679"),T=e("132d"),R=e("0fd9"),S=e("b974"),C=e("2fa4"),x=e("8654"),y=e("71d9"),w=e("2a7f"),I=Object(u["a"])(c,i,n,!1,null,null,null);a["default"]=I.exports;v()(I,{VAlert:h["a"],VBreadcrumbs:p["a"],VBtn:f["a"],VCard:_["a"],VCardText:b["d"],VCardTitle:b["e"],VCol:g["a"],VContainer:A["a"],VDataTable:k["a"],VDivider:E["a"],VEditDialog:N["a"],VIcon:T["a"],VRow:R["a"],VSelect:S["a"],VSpacer:C["a"],VTextField:x["a"],VToolbar:y["a"],VToolbarTitle:w["c"]})},c8b0:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("v-system-bar",{staticClass:"green lighten-2 white--text",attrs:{app:"",dark:""}}),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(a){a.stopPropagation(),t.drawer=!t.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(a){a.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(a){var i=a.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account")])],1),e("v-list-item-title",[t._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(a){return a.preventDefault(),t.logout(a)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-power")])],1),e("v-list-item-title",[t._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(a){a.stopPropagation(),t.drawerRight=!t.drawerRight}}},[e("v-icon",[t._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.hideleftnav,app:""},model:{value:t.drawer,callback:function(a){t.drawer=a},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser},on:{click:function(a){return a.stopPropagation(),t.toProfile(a)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("KEUANGAN-GROUP")&&"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?e("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/keuangan"},link:"",color:"green"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-monitor-dashboard")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("BOARD KEUANGAN")])],1)],1):t._e(),e("v-subheader",[t._v("DAFTAR ULANG")]),e("v-list-item",{attrs:{link:"",to:"/keuangan/channelpembayaran"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" CHANNEL PEMBAYARAN ")])],1)],1),t.CAN_ACCESS("KEUANGAN-STATUS-TRANSAKSI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/statustransaksi"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" STATUS TRANSAKSI ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-KOMPONEN-BIAYA_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponen"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-video-input-component")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BIAYA KOMPONEN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-BIAYA-KOMPONEN-PERIODE_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponenperiode"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BIAYA KOMPONEN PERIODE ")])],1)],1):t._e(),"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?e("v-subheader",[t._v("METODE PEMBAYARAN")]):t._e(),t.CAN_ACCESS("KEUANGAN-METODE-TRANSFER-BANK_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transferbank"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSFER BANK ")])],1)],1):t._e(),e("v-subheader",[t._v("TRANSAKSI")]),t.CAN_ACCESS("KEUANGAN-KONFIRMASI-PEMBAYARAN_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/konfirmasipembayaran"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KONFIRMASI PEMBAYARAN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR TRANSAKSI ")])],1)],1):t._e(),e("v-divider"),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-REGISTRASIKRS_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-registrasikrs"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSAKSI REGISTRASI KRS ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-SPP_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-spp"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSAKSI SPP ")])],1)],1):t._e()],1)],1),t.showrightsidebar?e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(a){t.drawerRight=a},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{staticClass:"teal lighten-5 mb-5"},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),e("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},n=[],s=(e("b0c0"),e("ac1f"),e("5319"),e("5530")),r=e("2f62"),o={name:"KeuanganLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(s["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,a=this.ATTRIBUTE_USER("foto");return t=""==a?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+a,t},hideleftnav:function(){return"ReportFormBMurni"==this.$route.name}}),watch:{loginTime:{handler:function(t){var a=this;t>=0?setTimeout((function(){a.loginTime=1==a.AUTHENTICATED?a.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,d=e("2877"),c=e("6544"),u=e.n(c),m=e("40dc"),v=e("5bc1"),h=e("8212"),p=e("ce7e"),f=e("132d"),_=e("adda"),b=e("8860"),g=e("da13"),A=e("8270"),k=e("5d23"),E=e("34c3"),N=e("f6c4"),T=e("e449"),R=e("f774"),S=e("2fa4"),C=e("e0c7"),x=e("afd9"),y=e("2a7f"),w=Object(d["a"])(l,i,n,!1,null,null,null);a["a"]=w.exports;u()(w,{VAppBar:m["a"],VAppBarNavIcon:v["a"],VAvatar:h["a"],VDivider:p["a"],VIcon:f["a"],VImg:_["a"],VList:b["a"],VListItem:g["a"],VListItemAvatar:A["a"],VListItemContent:k["g"],VListItemIcon:E["a"],VListItemSubtitle:k["j"],VListItemTitle:k["k"],VMain:N["a"],VMenu:T["a"],VNavigationDrawer:R["a"],VSpacer:S["a"],VSubheader:C["a"],VSystemBar:x["a"],VToolbarTitle:y["c"]})},e477:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-container",{attrs:{fluid:t.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},n=[],s={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=s,o=e("2877"),l=e("6544"),d=e.n(l),c=e("62ad"),u=e("a523"),m=e("132d"),v=e("0fd9"),h=Object(o["a"])(r,i,n,!1,null,null,null);a["a"]=h.exports;d()(h,{VCol:c["a"],VContainer:u["a"],VIcon:m["a"],VRow:v["a"]})}}]);