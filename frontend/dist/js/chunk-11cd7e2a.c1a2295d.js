(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-11cd7e2a"],{"7b2d":function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("KeuanganLayout",{scopedSlots:t._u([{key:"filtersidebar",fn:function(){return[e("Filter1",{ref:"filter1",on:{changeTahunAkademik:t.changeTahunAkademik}})]},proxy:!0}])},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-account-cash ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" TRANSAKSI ")]},proxy:!0},{key:"subtitle",fn:function(){},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Transaksi ")])]},proxy:!0}])}),e("v-container",{attrs:{fluid:""}},[e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-text",[e("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:t.search,callback:function(a){t.search=a},expression:"search"}})],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,search:t.search,"item-key":"id","sort-by":"nama_mhs","show-expand":"",expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(a){t.expanded=a},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[t._v("DAFTAR TRANSAKSI")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer"),t.dialogdetailitem?e("v-dialog",{attrs:{"max-width":"700px",persistent:""},model:{value:t.dialogdetailitem,callback:function(a){t.dialogdetailitem=a},expression:"dialogdetailitem"}},[e("v-card",[e("v-card-title",[e("span",{staticClass:"headline"},[t._v("DETAIL TRANSAKSI")])]),e("v-card-text",[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[e("v-card",{attrs:{flat:""}},[e("v-card-title",[t._v("KODE PRODI :")]),e("v-card-subtitle",[t._v(" "+t._s(t.formdata.kode_prodi)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?e("v-responsive",{attrs:{width:"100%"}}):t._e(),e("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[e("v-card",{attrs:{flat:""}},[e("v-card-title",[t._v("NAMA PRODI :")]),e("v-card-subtitle",[t._v(" "+t._s(t.formdata.nama_prodi)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?e("v-responsive",{attrs:{width:"100%"}}):t._e()],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[e("v-card",{attrs:{flat:""}},[e("v-card-title",[t._v("NAMA SINGKAT PRODI :")]),e("v-card-subtitle",[t._v(" "+t._s(t.formdata.nama_prodi_alias)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?e("v-responsive",{attrs:{width:"100%"}}):t._e()],1)],1),e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(a){return a.stopPropagation(),t.closedialogdetailitem(a)}}},[t._v("KELUAR")])],1)],1)],1):t._e()],1)]},proxy:!0},{key:"item.tanggal",fn:function(a){var e=a.item;return[t._v(" "+t._s(t.$date(e.tanggal).format("DD/MM/YYYY"))+" ")]}},{key:"item.total",fn:function(a){var e=a.item;return[t._v(" "+t._s(t._f("formatUang")(e.total))+" ")]}},{key:"item.nama_status",fn:function(a){var i=a.item;return[e("v-chip",{attrs:{color:i.style,dark:""}},[t._v(t._s(i.nama_status))])]}},{key:"item.actions",fn:function(a){var i=a.item;return[e("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(a){return a.stopPropagation(),t.viewItem(i)}}},[t._v(" mdi-eye ")])]}},{key:"expanded-item",fn:function(a){var i=a.headers,s=a.item;return[e("td",{staticClass:"text-center",attrs:{colspan:i.length}},[e("v-col",{attrs:{cols:"12"}},[e("strong",[t._v("ID:")]),t._v(t._s(s.id)+" "),e("strong",[t._v("created_at:")]),t._v(t._s(t.$date(s.created_at).format("DD/MM/YYYY HH:mm"))+" "),e("strong",[t._v("updated_at:")]),t._v(t._s(t.$date(s.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},s=[],n=(e("96cf"),e("1da1")),r=e("c8b0"),o=e("e477"),l=e("9fc1"),c={name:"Transaksi",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.ACCESS_TOKEN},{text:"KEUANGAN",disabled:!1,href:"/keuangan"},{text:"DAFTAR TRANSAKSI",disabled:!0,href:"#"}],this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"]},mounted:function(){this.initialize()},data:function(){return{breadcrumbs:[],tahun_akademik:0,btnLoading:!1,datatableLoading:!1,datatable:[],headers:[{text:"KODE BILLING",value:"no_transaksi",width:100,sortable:!0},{text:"TANGGAL",value:"tanggal",width:120,sortable:!0},{text:"NAMA MAHASISWA",value:"nama_mhs",sortable:!0},{text:"TOTAL",value:"total",width:100,sortable:!0},{text:"STATUS",value:"nama_status",width:100,sortable:!0},{text:"AKSI",value:"actions",sortable:!1,width:100}],expanded:[],search:"",dialogdetailitem:!1,formdata:{}}},methods:{changeTahunAkademik:function(t){this.tahun_akademik=t},initialize:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.post("/keuangan/transaksi",{TA:2020},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatable=e.transaksi,a.datatableLoading=!1}));case 3:this.firstloading=!1;case 4:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]},viewItem:function(t){this.formdata=t,this.dialogdetailitem=!0},closedialogdetailitem:function(){var t=this;this.dialogdetailitem=!1,setTimeout((function(){t.formdata=Object.assign({},{}),t.editedIndex=-1}),300)}},components:{KeuanganLayout:r["a"],ModuleHeader:o["a"],Filter1:l["a"]}},d=c,u=e("2877"),v=e("6544"),m=e.n(v),h=e("0798"),f=e("2bc5"),_=e("8336"),A=e("b0af"),p=e("99d9"),b=e("cc20"),k=e("62ad"),g=e("a523"),T=e("8fea"),S=e("169a"),E=e("ce7e"),N=e("132d"),C=e("6b53"),R=e("0fd9"),x=e("2fa4"),w=e("8654"),I=e("71d9"),y=e("2a7f"),O=Object(u["a"])(d,i,s,!1,null,null,null);a["default"]=O.exports;m()(O,{VAlert:h["a"],VBreadcrumbs:f["a"],VBtn:_["a"],VCard:A["a"],VCardActions:p["a"],VCardSubtitle:p["b"],VCardText:p["c"],VCardTitle:p["d"],VChip:b["a"],VCol:k["a"],VContainer:g["a"],VDataTable:T["a"],VDialog:S["a"],VDivider:E["a"],VIcon:N["a"],VResponsive:C["a"],VRow:R["a"],VSpacer:x["a"],VTextField:w["a"],VToolbar:I["a"],VToolbarTitle:y["a"]})},"9fc1":function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-list-item",[e("v-list-item-content",[e("v-select",{attrs:{items:t.daftar_ta,"item-text":"tahun_akademik","item-value":"tahun",label:"TAHUN AKADEMIK",outlined:""},model:{value:t.tahun_akademik,callback:function(a){t.tahun_akademik=a},expression:"tahun_akademik"}})],1)],1)},s=[],n={name:"FilterMode1",created:function(){this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"]},data:function(){return{firstloading:!0,daftar_ta:[],tahun_akademik:null}},methods:{setFirstTimeLoading:function(t){this.firstloading=t}},watch:{tahun_akademik:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateTahunAkademik",t),this.$emit("changeTahunAkademik",t))}}},r=n,o=e("2877"),l=e("6544"),c=e.n(l),d=e("da13"),u=e("5d23"),v=e("b974"),m=Object(o["a"])(r,i,s,!1,null,null,null);a["a"]=m.exports;c()(m,{VListItem:d["a"],VListItemContent:u["a"],VSelect:v["a"]})},c8b0:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("div",[e("v-system-bar",{staticClass:"brown darken-2 white--text",attrs:{app:"",dark:""}}),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(a){a.stopPropagation(),t.drawer=!t.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(a){a.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(a){var i=a.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account")])],1),e("v-list-item-title",[t._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(a){return a.preventDefault(),t.logout(a)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-power")])],1),e("v-list-item-title",[t._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(a){a.stopPropagation(),t.drawerRight=!t.drawerRight}}},[e("v-icon",[t._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{staticClass:"brown darken-4",attrs:{width:"300",dark:"",temporary:t.isReportPage,app:""},model:{value:t.drawer,callback:function(a){t.drawer=a},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser},on:{click:function(a){return a.stopPropagation(),t.toProfile(a)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("KEUANGAN-GROUP")&&"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?e("v-list-item",{attrs:{to:{path:"/keuangan"},link:"",color:"deep-orange darken-1"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-monitor-dashboard")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("MODULE KEUANGAN")])],1)],1):t._e(),e("v-subheader",[t._v("KOMPONEN")]),e("v-list-item",{attrs:{link:"",to:"/keuangan/channelpembayaran"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" CHANNEL PEMBAYARAN ")])],1)],1),t.CAN_ACCESS("KEUANGAN-STATUS-TRANSAKSI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/statustransaksi"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" STATUS TRANSAKSI ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-KOMPONEN-BIAYA_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponen"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-video-input-component")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BIAYA KOMPONEN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-BIAYA-KOMPONEN-PERIODE_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponenperiode"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-triforce")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BIAYA KOMPONEN PERIODE ")])],1)],1):t._e(),"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?e("v-subheader",[t._v("METODE PEMBAYARAN")]):t._e(),t.CAN_ACCESS("KEUANGAN-METODE-TRANSFER-BANK_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transferbank"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSFER BANK ")])],1)],1):t._e(),e("v-subheader",[t._v("TRANSAKSI")]),t.CAN_ACCESS("KEUANGAN-TRANSAKSI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR TRANSAKSI ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI_STORE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-baru"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSAKSI BARU ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-KONFIRMASI-PEMBAYARAN_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/keuangan/konfirmasipembayaran"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-cash")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KONFIRMASI PEMBAYARAN ")])],1)],1):t._e()],1)],1),e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(a){t.drawerRight=a},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{staticClass:"teal lighten-5 mb-5"},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1),e("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},s=[],n=(e("b0c0"),e("ac1f"),e("5319"),e("5530")),r=e("2f62"),o={name:"KeuanganLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(n["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,a=this.ATTRIBUTE_USER("foto");return t=""==a?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+a,t},isReportPage:function(){return"ReportFormBMurni"==this.$route.name}}),watch:{loginTime:{handler:function(t){var a=this;t>=0?setTimeout((function(){a.loginTime=1==a.AUTHENTICATED?a.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,c=e("2877"),d=e("6544"),u=e.n(d),v=e("40dc"),m=e("5bc1"),h=e("8212"),f=e("ce7e"),_=e("132d"),A=e("adda"),p=e("8860"),b=e("da13"),k=e("8270"),g=e("5d23"),T=e("34c3"),S=e("f6c4"),E=e("e449"),N=e("f774"),C=e("2fa4"),R=e("e0c7"),x=e("afd9"),w=e("2a7f"),I=Object(c["a"])(l,i,s,!1,null,null,null);a["a"]=I.exports;u()(I,{VAppBar:v["a"],VAppBarNavIcon:m["a"],VAvatar:h["a"],VDivider:f["a"],VIcon:_["a"],VImg:A["a"],VList:p["a"],VListItem:b["a"],VListItemAvatar:k["a"],VListItemContent:g["a"],VListItemIcon:T["a"],VListItemSubtitle:g["b"],VListItemTitle:g["c"],VMain:S["a"],VMenu:E["a"],VNavigationDrawer:N["a"],VSpacer:C["a"],VSubheader:R["a"],VSystemBar:x["a"],VToolbarTitle:w["a"]})}}]);