(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-52300594"],{"5a46":function(t,e,i){"use strict";i.r(e);var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("SystemUserLayout",[i("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-account-key ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" MY PERMISSIONS ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[i("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[i("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[i("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Daftar aksi-aksi terhadap sebuah modul. Format penulisan permission, NAMAMODULE atau NAMA MODULE. Nama Permission tighly coupling dengan kode sumber. ")])]},proxy:!0}])}),i("v-container",{attrs:{fluid:""}},[i("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[i("v-col",{attrs:{xs:"12",sm:"12",md:"12"}},[i("v-card",[i("v-card-text",[i("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1)],1)],1)],1),i("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[i("v-col",{attrs:{xs:"12",sm:"12",md:"12"}},[i("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.daftar_permissions,search:t.search,"item-key":"id","sort-by":"name","show-expand":"",expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(e){t.expanded=e},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[i("v-toolbar",{attrs:{flat:"",color:"white"}},[i("v-toolbar-title",[t._v("DAFTAR PERMISSION")]),i("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),i("v-spacer")],1)]},proxy:!0},{key:"expanded-item",fn:function(e){var s=e.headers,a=e.item;return[i("td",{staticClass:"text-center",attrs:{colspan:s.length}},[i("strong",[t._v("ID:")]),t._v(t._s(a.id)+" "),i("strong",[t._v("created_at:")]),t._v(t._s(t.$date(a.created_at).format("DD/MM/YYYY HH:mm"))+" "),i("strong",[t._v("updated_at:")]),t._v(t._s(t.$date(a.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},a=[],r=i("5530"),n=i("2f62"),o=i("e0b6"),l=i("e477"),c={name:"Permissions",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.ACCESS_TOKEN},{text:"USER SISTEM",disabled:!1,href:"/system-users"},{text:"PERMISSIONS",disabled:!0,href:"#"}],this.initialize()},data:function(){return{breadcrumbs:[],datatableLoading:!1,btnLoading:!1,expanded:[],daftar_permissions:[],headers:[{text:"NAMA PERMISSION",value:"name"},{text:"GUARD",value:"guard_name"}],search:""}},methods:{initialize:function(){var t=this;this.datatableLoading=!0,this.$ajax.get("/system/users/"+this.ATTRIBUTE_USER("id")+"/mypermission",{headers:{Authorization:this.TOKEN}}).then((function(e){var i=e.data;t.daftar_permissions=i.permissions,t.datatableLoading=!1}))},dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]}},computed:Object(r["a"])({},Object(n["b"])("auth",{ACCESS_TOKEN:"AccessToken",TOKEN:"Token",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),components:{SystemUserLayout:o["a"],ModuleHeader:l["a"]}},d=c,m=i("2877"),v=i("6544"),u=i.n(v),S=i("0798"),_=i("2bc5"),p=i("b0af"),h=i("99d9"),f=i("62ad"),E=i("a523"),b=i("8fea"),A=i("ce7e"),C=i("132d"),T=i("0fd9"),g=i("2fa4"),R=i("8654"),k=i("71d9"),y=i("2a7f"),x=Object(m["a"])(d,s,a,!1,null,null,null);e["default"]=x.exports;u()(x,{VAlert:S["a"],VBreadcrumbs:_["a"],VCard:p["a"],VCardText:h["d"],VCol:f["a"],VContainer:E["a"],VDataTable:b["a"],VDivider:A["a"],VIcon:C["a"],VRow:T["a"],VSpacer:g["a"],VTextField:R["a"],VToolbar:k["a"],VToolbarTitle:y["c"]})},e0b6:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("div",[i("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[i("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),i("v-app-bar",{attrs:{app:""}},[i("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),i("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[i("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),i("v-spacer"),i("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),i("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var s=e.on;return[i("v-avatar",{attrs:{size:"30"}},[i("v-img",t._g({attrs:{src:t.photoUser}},s))],1)]}}])},[i("v-list",[i("v-list-item",[i("v-list-item-avatar",[i("v-img",{attrs:{src:t.photoUser}})],1),i("v-list-item-content",[i("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),i("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),i("v-divider"),i("v-list-item",{attrs:{to:"/system-users/profil"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-title",[t._v("Profil")])],1),i("v-divider"),i("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-power")])],1),i("v-list-item-title",[t._v("Logout")])],1)],1)],1)],1),i("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[i("v-list-item",[i("v-list-item-avatar",[i("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),i("v-list-item-content",[i("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),i("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),i("v-divider"),i("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("SYSTEM-USERS-GROUP")?i("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/system-users"},link:"",color:"green"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v("BOARD USERS")])],1)],1):t._e(),i("v-list-item",{attrs:{link:"",to:"/system-users/profil"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" PROFIL USER ")])],1)],1),i("v-divider"),t.CAN_ACCESS("SYSTEM-SETTING-PERMISSIONS")?i("v-list-item",{attrs:{link:"",to:"/system-users/permissions"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-key")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" PERMISSIONS ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-SETTING-ROLES")?i("v-list-item",{attrs:{link:"",to:"/system-users/roles"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account-group")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" ROLES ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-SETTING-ROLES")?i("v-divider"):t._e(),t.CAN_ACCESS("SYSTEM-USERS-SUPERADMIN_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/superadmin"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" SUPERADMIN ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-KEUANGAN_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/keuangan"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" KEUANGAN ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PMB_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/pmb"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" TIM PMB ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-AKADEMIK_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/akademik"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" AKADEMIK ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PROGRAM-STUDI_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/prodi"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" PROGRAM STUDI ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PUSLAHTA_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/puslahta"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" PUSLAHTA ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-DOSEN_BROWSE")?i("v-list-item",{attrs:{link:"",to:"/system-users/dosen"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" DOSEN ")])],1)],1):t._e(),"dosen"==t.dashboard?i("v-list-item",{attrs:{link:"",to:"/system-users/biodatadiridosen"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" BIODATA DIRI ")])],1)],1):t._e(),"mahasiswa"==t.dashboard?i("v-list-item",{attrs:{link:"",to:"/system-users/biodatadirimahasiswa"}},[i("v-list-item-icon",{staticClass:"mr-2"},[i("v-icon",[t._v("mdi-account")])],1),i("v-list-item-content",[i("v-list-item-title",[t._v(" BIODATA DIRI ")])],1)],1):t._e()],1)],1),i("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),i("v-footer",{attrs:{app:"",padless:"",fixed:""}},[i("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[i("v-divider"),i("v-card-text",{staticClass:"py-2 black--text text-center"},[i("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),i("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[i("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},a=[],r=i("5530"),n=(i("5319"),i("ac1f"),i("2f62")),o={name:"SystemUserLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(r["a"])(Object(r["a"])({},Object(n["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,c=i("2877"),d=i("6544"),m=i.n(d),v=i("40dc"),u=i("5bc1"),S=i("8212"),_=i("8336"),p=i("b0af"),h=i("99d9"),f=i("ce7e"),E=i("553a"),b=i("132d"),A=i("adda"),C=i("8860"),T=i("da13"),g=i("8270"),R=i("5d23"),k=i("34c3"),y=i("f6c4"),x=i("e449"),I=i("f774"),U=i("2fa4"),M=i("afd9"),N=i("2a7f"),O=Object(c["a"])(l,s,a,!1,null,null,null);e["a"]=O.exports;m()(O,{VAppBar:v["a"],VAppBarNavIcon:u["a"],VAvatar:S["a"],VBtn:_["a"],VCard:p["a"],VCardText:h["d"],VDivider:f["a"],VFooter:E["a"],VIcon:b["a"],VImg:A["a"],VList:C["a"],VListItem:T["a"],VListItemAvatar:g["a"],VListItemContent:R["g"],VListItemIcon:k["a"],VListItemSubtitle:R["j"],VListItemTitle:R["k"],VMain:y["a"],VMenu:x["a"],VNavigationDrawer:I["a"],VSpacer:U["a"],VSystemBar:M["a"],VToolbarTitle:N["c"]})},e477:function(t,e,i){"use strict";var s=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-container",{attrs:{fluid:t.isReportPage}},[i("v-row",{attrs:{"no-gutters":""}},[i("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),i("v-row",{attrs:{"no-gutters":""}},[i("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[i("h1",{staticClass:"subheading grey--text"},[i("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),i("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[i("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),i("v-row",{attrs:{"no-gutters":""}},[i("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},a=[],r={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},n=r,o=i("2877"),l=i("6544"),c=i.n(l),d=i("62ad"),m=i("a523"),v=i("132d"),u=i("0fd9"),S=Object(o["a"])(n,s,a,!1,null,null,null);e["a"]=S.exports;c()(S,{VCol:d["a"],VContainer:m["a"],VIcon:v["a"],VRow:u["a"]})}}]);