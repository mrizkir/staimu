(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-31ba75ca"],{"94df":function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("v-system-bar",{staticClass:"green lighten-2 white--text",attrs:{app:"",dark:""}}),a("v-app-bar",{attrs:{app:""}},[a("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),a("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[a("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),a("v-spacer"),a("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[a("v-list",[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list-item",{attrs:{to:"/system-users/profil"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-title",[t._v("Profil")])],1),a("v-divider"),a("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-power")])],1),a("v-list-item-title",[t._v("Logout")])],1)],1)],1),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawerRight=!t.drawerRight}}},[a("v-icon",[t._v("mdi-menu-open")])],1)],1),a("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.hideleftnav,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("DMASTER-GROUP")?a("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/dmaster"},link:"",color:"green"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-floor-b")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("BOARD DATA MASTER")])],1)],1):t._e(),a("v-subheader",[t._v("FASILITAS")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/ruangkelas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-seat-legroom-extra")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" RUANG KELAS ")])],1)],1),a("v-subheader",[t._v("MAHASISWA")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/statusmahasiswa"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-vertical-lock")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" STATUS MAHASISWA ")])],1)],1),t.CAN_ACCESS("DMASTER-KELAS_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/kelas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-google-classroom")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" KELAS ")])],1)],1):t._e(),a("v-list-item",{attrs:{link:"",to:"/dmaster/jenjangstudi"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-stairs-up")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" JENJANG STUDI ")])],1)],1),t.CAN_ACCESS("DMASTER-FAKULTAS_BROWSE")&&t.isBentukPT("universitas")?a("v-list-item",{attrs:{link:"",to:"/dmaster/fakultas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" FAKULTAS ")])],1)],1):t._e(),t.CAN_ACCESS("DMASTER-PRODI_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/programstudi"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-assistant")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PROGRAM STUDI ")])],1)],1):t._e(),a("v-subheader",[t._v("DOSEN")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/jabatanakademik"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-chair-rolling")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" JABATAN AKADEMIK ")])],1)],1),a("v-subheader",[t._v("AKADEMIK")]),t.CAN_ACCESS("DMASTER-TA_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/ta"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-calendar-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAHUN AKADEMIK ")])],1)],1):t._e()],1)],1),t.showrightsidebar?a("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(e){t.drawerRight=e},expression:"drawerRight"}},[a("v-list",{attrs:{dense:""}},[a("v-list-item",[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-menu-open")])],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),a("v-divider"),a("v-list-item",{staticClass:"teal lighten-5 mb-5"},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-filter")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),a("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},s=[],r=(a("b0c0"),a("ac1f"),a("5319"),a("5530")),n=a("2f62"),o={name:"DataMasterLayout",props:{showrightsidebar:{type:Boolean,default:!0}},data:function(){return{loginTime:0,drawer:null,drawerRight:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(r["a"])({},Object(n["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t},hideleftnav:function(){return"ReportFormBMurni"==this.$route.name}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,c=a("2877"),d=a("6544"),v=a.n(d),m=a("40dc"),u=a("5bc1"),h=a("8212"),p=a("ce7e"),f=a("132d"),_=a("adda"),A=a("8860"),g=a("da13"),b=a("8270"),T=a("5d23"),S=a("34c3"),C=a("f6c4"),k=a("e449"),w=a("f774"),E=a("2fa4"),x=a("e0c7"),R=a("afd9"),y=a("2a7f"),I=Object(c["a"])(l,i,s,!1,null,null,null);e["a"]=I.exports;v()(I,{VAppBar:m["a"],VAppBarNavIcon:u["a"],VAvatar:h["a"],VDivider:p["a"],VIcon:f["a"],VImg:_["a"],VList:A["a"],VListItem:g["a"],VListItemAvatar:b["a"],VListItemContent:T["g"],VListItemIcon:S["a"],VListItemSubtitle:T["j"],VListItemTitle:T["k"],VMain:C["a"],VMenu:k["a"],VNavigationDrawer:w["a"],VSpacer:E["a"],VSubheader:x["a"],VSystemBar:R["a"],VToolbarTitle:y["c"]})},b01e:function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("DataMasterLayout",[a("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-arrow-vertical-lock ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" STATUS MAHASISWA ")]},proxy:!0},{key:"subtitle",fn:function(){},proxy:!0},{key:"breadcrumbs",fn:function(){return[a("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[a("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[a("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman ini berisi informasi status mahasiwa. ID dan Nama Status melekat ke sistem sehingga tidak bisa diubah. ")])]},proxy:!0}])}),a("v-container",{attrs:{fluid:""}},[a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,"item-key":"id","sort-by":"id","show-expand":"","disable-pagination":!0,"hide-default-footer":!0,expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(e){t.expanded=e},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"expanded-item",fn:function(e){var i=e.headers,s=e.item;return[a("td",{staticClass:"text-center",attrs:{colspan:i.length}},[a("v-col",{attrs:{cols:"12"}},[a("strong",[t._v("created_at:")]),t._v(t._s(t.$date(s.created_at).format("DD/MM/YYYY HH:mm"))+" "),a("strong",[t._v("updated_at:")]),t._v(t._s(t.$date(s.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},s=[],r=(a("96cf"),a("1da1")),n=a("94df"),o=a("e477"),l={name:"StatusMahasiswa",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"DATA MASTER",disabled:!1,href:"/dmaster"},{text:"STATUS MAHASISWA",disabled:!0,href:"#"}],this.initialize()},data:function(){return{breadcrumbs:[],btnLoading:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"ID",value:"k_status",width:10,sortable:!1},{text:"NAMA STATUS",value:"n_status",sortable:!1}]}},methods:{initialize:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.get("/datamaster/statusmahasiswa",{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var a=t.data;e.datatable=a.status_mahasiswa,e.datatableLoading=!1}));case 3:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]}},components:{DataMasterLayout:n["a"],ModuleHeader:o["a"]}},c=l,d=a("2877"),v=a("6544"),m=a.n(v),u=a("0798"),h=a("2bc5"),p=a("62ad"),f=a("a523"),_=a("8fea"),A=a("132d"),g=a("0fd9"),b=Object(d["a"])(c,i,s,!1,null,null,null);e["default"]=b.exports;m()(b,{VAlert:u["a"],VBreadcrumbs:h["a"],VCol:p["a"],VContainer:f["a"],VDataTable:_["a"],VIcon:A["a"],VRow:g["a"]})},e477:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:t.isReportPage}},[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("h1",{staticClass:"subheading grey--text"},[a("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},s=[],r={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},n=r,o=a("2877"),l=a("6544"),c=a.n(l),d=a("62ad"),v=a("a523"),m=a("132d"),u=a("0fd9"),h=Object(o["a"])(n,i,s,!1,null,null,null);e["a"]=h.exports;c()(h,{VCol:d["a"],VContainer:v["a"],VIcon:m["a"],VRow:u["a"]})}}]);