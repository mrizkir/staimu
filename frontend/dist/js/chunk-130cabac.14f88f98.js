(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-130cabac"],{1265:function(t,a,i){"use strict";i.r(a);var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("KeuanganLayout",{scopedSlots:t._u([{key:"filtersidebar",fn:function(){return[i("Filter1",{ref:"filter1",on:{changeTahunAkademik:t.changeTahunAkademik}})]},proxy:!0}])},[i("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-video-input-component ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" LAPORAN PENERIMAAN SPP ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v("TAHUN AKADEMIK "+t._s(t.tahun_akademik))]},proxy:!0},{key:"breadcrumbs",fn:function(){return[i("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[i("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[i("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman ini digunakan untuk memperoleh laporan penerimaan SPP mahasiswa baru dan lama. ")])]},proxy:!0}])}),i("v-container",{attrs:{fluid:""}},[i("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[i("v-col",{attrs:{cols:"12"}},[i("div",{staticClass:"v-data-table theme--light v-data-table--has-top"},[i("header",{staticClass:"v-sheet theme--light v-toolbar v-toolbar--flat white",staticStyle:{height:"64px"}},[i("div",{staticClass:"v-toolbar__content",staticStyle:{height:"64px"}},[i("div",{staticClass:"v-toolbar__title"},[t._v(" REKAPITULASI PENERIMAAN SPP ")]),i("hr",{staticClass:"mx-4 v-divider v-divider--inset v-divider--vertical theme--light",attrs:{role:"separator","aria-orientation":"vertical"}}),i("div",{staticClass:"spacer"}),i("v-btn",{staticClass:"ma-2",attrs:{color:"primary",icon:"",outlined:"",small:"",disabled:t.btnLoading},on:{click:function(a){return a.stopPropagation(),t.printtoexcel(a)}}},[i("v-icon",[t._v("mdi-printer")])],1)],1)]),i("div",{staticClass:"v-data-table__wrapper"},[i("table",[i("thead",{staticClass:"v-data-table-header"},[i("tr",[i("th",{staticClass:"text-start",staticStyle:{width:"70px","min-width":"70px"}},[t._v(" NO ")]),i("th",{staticClass:"text-start",staticStyle:{width:"150px","min-width":"150px"}},[t._v(" BULAN ")]),i("th",{staticClass:"text-end"},[t._v(" JUMLAH ")])])]),i("tbody",[t._l(t.datatable,(function(a){return i("tr",{key:a.no_bulan},[i("td",{staticClass:"text-start"},[t._v(t._s(a.no_bulan))]),i("td",{staticClass:"text-start"},[t._v(t._s(a.nama_bulan))]),i("td",[i("table",{attrs:{width:"100%"}},[t._l(a.data_prodi,(function(a){return i("tr",{key:a.prodi_id},[i("td",[t._v(t._s(a.nama_prodi))]),i("td",{staticClass:"text-end"},[t._v(" "+t._s(t._f("formatUang")(a.jumlah))+" ")])])})),i("tr",{staticClass:"font-weight-medium"},[i("td",[t._v("SUB TOTAL")]),i("td",{staticClass:"text-end",attrs:{colspan:"2"}},[t._v(" "+t._s(t._f("formatUang")(a.sub_total))+" ")])])],2)])])})),i("tr",{staticClass:"text-end font-weight-medium",attrs:{colspan:"2"}},[i("td",{attrs:{colspan:"2"}},[t._v(" TOTAL KESELURUHAN ")]),i("td",[t._v(" "+t._s(t._f("formatUang")(t.total_keseluruhan))+" ")])])],2)])])])])],1)],1)],1)},s=[],n=i("1da1"),r=(i("2b3d"),i("d3b7"),i("3ca3"),i("ddb0"),i("159b"),i("96cf"),i("c8b0")),o=i("e477"),l=i("9fc1"),c={name:"TransaksiSPP",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"],this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"KEUANGAN",disabled:!1,href:"/keuangan"},{text:"LAPORAN PENERIMAAN SPP",disabled:!0,href:"#"}],this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"]},mounted:function(){this.initialize()},data:function(){return{firstloading:!0,breadcrumbs:[],tahun_akademik:0,btnLoading:!1,datatableLoading:!1,datatable:[],headers:[{text:"NO",value:"no_bulan",width:70,sortable:!1},{text:"BULAN",value:"nama_bulan",width:200,sortable:!1},{text:"JUMLAH",value:"jumlah",align:"end",sortable:!0}],dialogfrm:!1,total_keseluruhan:0}},methods:{changeTahunAkademik:function(t){this.tahun_akademik=t},initialize:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.post("/keuangan/transaksi-laporanspp",{TA:this.tahun_akademik},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var i=t.data;a.datatable=i.transaksi,a.datatableLoading=!1,a.total_keseluruhan=i.total_keseluruhan}));case 3:this.firstloading=!1,this.$refs.filter1.setFirstTimeLoading(this.firstloading);case 5:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),addItem:function(){var t=this;return Object(n["a"])(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.daftar_semester=t.$store.getters["uiadmin/getDaftarSemester"],t.formdata.semester_akademik=t.semester_akademik,"mahasiswa"==t.dashboard&&(t.formdata.nim=t.$store.getters["auth/AttributeUser"]("username")),t.dialogfrm=!0;case 4:case"end":return a.stop()}}),a)})))()},printtoexcel:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.btnLoading=!0,t.next=3,this.$ajax.post("/keuangan/transaksi-laporanspp/printtoexcel1",{TA:this.tahun_akademik},{headers:{Authorization:this.$store.getters["auth/Token"]},responseType:"arraybuffer"}).then((function(t){var i=t.data,e=window.URL.createObjectURL(new Blob([i])),s=document.createElement("a");s.href=e,s.setAttribute("download","spp_"+Date.now()+".xlsx"),s.setAttribute("id","download_laporan"),document.body.appendChild(s),s.click(),document.body.removeChild(s),a.btnLoading=!1})).catch((function(){a.btnLoading=!1}));case 3:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}()},computed:{totaltransaksi:function(){var t=0;return this.datatable.forEach((function(a){t+=a.jumlah})),t}},watch:{tahun_akademik:function(){this.firstloading||this.initialize()},prodi_id:function(t){this.firstloading||(this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.initialize())}},components:{KeuanganLayout:r["a"],ModuleHeader:o["a"],Filter1:l["a"]}},d=c,u=(i("3f18"),i("2877")),m=i("6544"),v=i.n(m),h=i("0798"),A=i("2bc5"),_=i("8336"),p=i("62ad"),f=i("a523"),k=i("132d"),g=i("0fd9"),b=Object(u["a"])(d,e,s,!1,null,"642d932e",null);a["default"]=b.exports;v()(b,{VAlert:h["a"],VBreadcrumbs:A["a"],VBtn:_["a"],VCol:p["a"],VContainer:f["a"],VIcon:k["a"],VRow:g["a"]})},"3f18":function(t,a,i){"use strict";i("4575")},4575:function(t,a,i){},"9fc1":function(t,a,i){"use strict";var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("v-list-item",[i("v-list-item-content",[i("v-select",{attrs:{items:t.daftar_ta,label:"TAHUN AKADEMIK",outlined:""},model:{value:t.tahun_akademik,callback:function(a){t.tahun_akademik=a},expression:"tahun_akademik"}})],1)],1)},s=[],n={name:"FilterMode1",created:function(){this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"]},data:function(){return{firstloading:!0,daftar_ta:[],tahun_akademik:null}},methods:{setFirstTimeLoading:function(t){this.firstloading=t}},watch:{tahun_akademik:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateTahunAkademik",t),this.$emit("changeTahunAkademik",t))}}},r=n,o=i("2877"),l=i("6544"),c=i.n(l),d=i("da13"),u=i("5d23"),m=i("b974"),v=Object(o["a"])(r,e,s,!1,null,null,null);a["a"]=v.exports;c()(v,{VListItem:d["a"],VListItemContent:u["g"],VSelect:m["a"]})},c8b0:function(t,a,i){"use strict";var e=function(){var t=this,a=t.$createElement,i=t._self._c||a;return i("div",[i("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[i("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),i("v-app-bar",{attrs:{app:""}},[i("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(a){a.stopPropagation(),t.drawer=!t.drawer}}}),i("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(a){a.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[i("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),i("v-spacer"),i("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(a){var e=a.on;return[i("v-avatar",{attrs:{size:"30"}},[i("v-img",t._g({attrs:{src:t.photoUser}},e))],1)]}}])},[i("v-list",[i("v-list-item",[i("v-list-item-avatar",[i("v-img",{attrs:{src:t.photoUser}})],1),i("v-list-item-content",[i("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),i("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),i("v-divider"),i("v-list-item",{attrs:{to:"/system-users/profil"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-title",[t._v("Profil")])],1),i("v-divider"),i("v-list-item",{on:{click:function(a){return a.preventDefault(),t.logout(a)}}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-power")])],1),i("v-list-item-title",[t._v("Logout")])],1)],1)],1),i("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),i("v-app-bar-nav-icon",{on:{click:function(a){a.stopPropagation(),t.drawerRight=!t.drawerRight}}},[i("v-icon",[t._v("mdi-menu-open")])],1)],1),i("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(a){t.drawer=a},expression:"drawer"}},[i("v-list-item",[i("v-list-item-avatar",[i("v-img",{attrs:{src:t.photoUser},on:{click:function(a){return a.stopPropagation(),t.toProfile(a)}}})],1),i("v-list-item-content",[i("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),i("v-list-item-subtitle",[t._v("["+t._s(t.DEFAULT_ROLE)+"]")])],1)],1),i("v-divider"),i("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("KEUANGAN-GROUP")&&"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?i("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/keuangan"},link:"",color:"green"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-monitor-dashboard")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v("BOARD KEUANGAN")])],1)],1):t._e(),i("v-subheader",[t._v("DAFTAR ULANG")]),i("v-list-item",{attrs:{link:"",to:"/keuangan/channelpembayaran"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-triforce")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" CHANNEL PEMBAYARAN ")])],1)],1),t.CAN_ACCESS("KEUANGAN-STATUS-TRANSAKSI_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/statustransaksi"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-triforce")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" STATUS TRANSAKSI ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-KOMPONEN-BIAYA_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponen"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-video-input-component")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" BIAYA KOMPONEN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-BIAYA-KOMPONEN-PERIODE_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/biayakomponenperiode"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-triforce")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" BIAYA KOMPONEN PERIODE ")])],1)],1):t._e(),"mahasiswabaru"!=t.dashboard&&"mahasiswa"!=t.dashboard?i("v-subheader",[t._v(" METODE PEMBAYARAN ")]):t._e(),t.CAN_ACCESS("KEUANGAN-METODE-TRANSFER-BANK_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transferbank"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" TRANSFER BANK ")])],1)],1):t._e(),i("v-subheader",[t._v("TRANSAKSI")]),t.CAN_ACCESS("KEUANGAN-KONFIRMASI-PEMBAYARAN_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/konfirmasipembayaran"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" KONFIRMASI PEMBAYARAN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" DAFTAR TRANSAKSI ")])],1)],1):t._e(),i("v-divider"),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-DULANG-MHS-BARU_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-dulangmhsbaru"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" DAFTAR ULANG MHS. BARU ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-REGISTRASIKRS_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-registrasikrs"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" REGISTRASI KRS ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-SPP_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-spp"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" SPP ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-KKN_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-kkn"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" KKN ")])],1)],1):t._e(),t.CAN_ACCESS("KEUANGAN-TRANSAKSI-UJIAN-MUNAQASAH_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-ujianmunaqasah"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" UJIAN MUNAQASAH ")])],1)],1):t._e(),i("v-subheader",[t._v("LAPORAN")]),t.CAN_ACCESS("KEUANGAN-LAPORAN-PENERIMAAN-SPP_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/keuangan/transaksi-laporanspp"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-cash")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" PENERIMAAN SPP ")])],1)],1):t._e()],1)],1),t.showrightsidebar?i("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(a){t.drawerRight=a},expression:"drawerRight"}},[i("v-list",{attrs:{dense:""}},[i("v-list-item",[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-menu-open")])],1),i("v-list-item-content",[i("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),i("v-divider"),i("v-list-item",{staticClass:"teal lighten-5 mb-5"},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-filter")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),i("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),i("v-footer",{attrs:{app:"",padless:"",fixed:""}},[i("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[i("v-divider"),i("v-card-text",{staticClass:"py-2 black--text text-center"},[i("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),i("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[i("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},s=[],n=i("5530"),r=(i("5319"),i("ac1f"),i("2f62")),o={name:"KeuanganLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(n["a"])(Object(n["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,a=this.ATTRIBUTE_USER("foto");return t=""==a?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+a,t}}),watch:{loginTime:{handler:function(t){var a=this;t>=0?setTimeout((function(){a.loginTime=1==a.AUTHENTICATED?a.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,c=i("2877"),d=i("6544"),u=i.n(d),m=i("40dc"),v=i("5bc1"),h=i("8212"),A=i("8336"),_=i("b0af"),p=i("99d9"),f=i("ce7e"),k=i("553a"),g=i("132d"),b=i("adda"),S=i("8860"),N=i("da13"),E=i("8270"),C=i("5d23"),T=i("34c3"),R=i("f6c4"),w=i("e449"),U=i("f774"),I=i("2fa4"),x=i("e0c7"),O=i("afd9"),P=i("2a7f"),y=Object(c["a"])(l,e,s,!1,null,null,null);a["a"]=y.exports;u()(y,{VAppBar:m["a"],VAppBarNavIcon:v["a"],VAvatar:h["a"],VBtn:A["a"],VCard:_["a"],VCardText:p["d"],VDivider:f["a"],VFooter:k["a"],VIcon:g["a"],VImg:b["a"],VList:S["a"],VListItem:N["a"],VListItemAvatar:E["a"],VListItemContent:C["g"],VListItemIcon:T["a"],VListItemSubtitle:C["j"],VListItemTitle:C["k"],VMain:R["a"],VMenu:w["a"],VNavigationDrawer:U["a"],VSpacer:I["a"],VSubheader:x["a"],VSystemBar:O["a"],VToolbarTitle:P["c"]})}}]);