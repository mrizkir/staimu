(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2e04cde8"],{"5c65":function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("BlogLayout",{attrs:{temporaryleftsidebar:!0,temporaryrightsidebar:!1},scopedSlots:t._u([{key:"filtersidebar",fn:function(){return[a("v-list-item",[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-menu-open")])],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),a("v-divider")]},proxy:!0}])},[a("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-google-classroom ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" INFO KAMPUS ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[a("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[a("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[a("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman untuk mengelola informasi seputar kampus ")])]},proxy:!0}])}),t.INFO_KAMPUS_TERM_ID?a("v-container",{attrs:{fluid:""}},[a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[a("v-card",[a("v-card-title",[a("span",{staticClass:"headline"},[t._v("TAMBAH INFORMASI")])]),a("v-card-text",[a("v-text-field",{attrs:{label:"JUDUL INFORMASI",outlined:"",rules:t.rule_judul},model:{value:t.formdata.post_title,callback:function(e){t.$set(t.formdata,"post_title",e)},expression:"formdata.post_title"}}),a("tiptap-vuetify",{attrs:{extensions:t.extensions,rules:t.rule_content},model:{value:t.formdata.post_content,callback:function(e){t.$set(t.formdata,"post_content",e)},expression:"formdata.post_content"}})],1),a("v-card-actions",[a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.$router.push("/blog/pages/infokampus")}}},[t._v(" BATAL ")]),a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:"",disabled:!t.form_valid||t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.save(e)}}},[t._v(" SIMPAN ")])],1)],1)],1)],1)],1)],1):a("v-container",{attrs:{fluid:""}},[a("v-row",[a("v-col",{attrs:{cols:"12"}},[a("v-alert",{attrs:{type:"info"}},[t._v(" KATEGORI untuk Info Kampus belum disetting. ")])],1)],1)],1)],1)},r=[],o=a("1da1"),s=(a("96cf"),a("f242")),n=a("e477"),l=a("3f38"),c={name:"PageInfoKampus",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/Token"]},{text:"BLOG",disabled:!1,href:"/blog"},{text:"INFO KAMPUS",disabled:!1,href:"/blog/pages/infokampus"},{text:"TAMBAH",disabled:!0,href:"#"}]},mounted:function(){this.fetchConfig()},data:function(){return{firstloading:!0,btnLoading:!1,INFO_KAMPUS_TERM_ID:null,extensions:[l["h"],l["a"],l["k"],l["r"],l["o"],l["j"],l["l"],l["c"],l["m"],[l["g"],{options:{levels:[1,2,3]}}],l["b"],l["d"],l["e"],l["i"],l["n"],l["f"]],form_valid:!0,formdata:{post_title:"",post_content:""},formdefault:{post_title:"",post_content:""},rule_judul:[function(t){return!!t||"Mohon judul informasi untuk di isi !!!"}],rule_content:[function(t){return!!t||"Mohon konten informasi untuk di isi !!!"}]}},methods:{fetchConfig:function(){var t=this;return Object(o["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return e.next=2,t.$ajax.get("/blog/pages/infokampus/config",{headers:{Authorization:t.$store.getters["auth/Token"]}}).then((function(e){var a=e.data;t.INFO_KAMPUS_TERM_ID=a.config.INFO_KAMPUS_TERM_ID}));case 2:t.firstloading=!1;case 3:case"end":return e.stop()}}),e)})))()},save:function(){var t=Object(o["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!this.$refs.frmdata.validate()){t.next=4;break}return this.btnLoading=!0,t.next=4,this.$ajax.post("/blog/pages/infokampus/store",{post_title:this.formdata.post_title,post_content:this.formdata.post_content,term_id:this.INFO_KAMPUS_TERM_ID},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var a=t.data;e.btnLoading=!1,e.$router.push("/blog/pages/infokampus/"+a.post.id+"/edit")})).catch((function(){e.btnLoading=!1}));case 4:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}()},components:{BlogLayout:s["a"],TiptapVuetify:l["p"],ModuleHeader:n["a"]}},u=c,d=a("2877"),v=a("6544"),m=a.n(v),f=a("0798"),p=a("2bc5"),h=a("8336"),g=a("b0af"),_=a("99d9"),b=a("62ad"),k=a("a523"),T=a("ce7e"),A=a("4bd4"),x=a("132d"),V=a("da13"),C=a("5d23"),I=a("34c3"),w=a("0fd9"),y=a("2fa4"),E=a("8654"),R=Object(d["a"])(u,i,r,!1,null,null,null);e["default"]=R.exports;m()(R,{VAlert:f["a"],VBreadcrumbs:p["a"],VBtn:h["a"],VCard:g["a"],VCardActions:_["b"],VCardText:_["d"],VCardTitle:_["e"],VCol:b["a"],VContainer:k["a"],VDivider:T["a"],VForm:A["a"],VIcon:x["a"],VListItem:V["a"],VListItemContent:C["g"],VListItemIcon:I["a"],VListItemTitle:C["k"],VRow:w["a"],VSpacer:y["a"],VTextField:E["a"]})},e477:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:t.isReportPage}},[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("h1",{staticClass:"subheading grey--text"},[a("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},r=[],o={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},s=o,n=a("2877"),l=a("6544"),c=a.n(l),u=a("62ad"),d=a("a523"),v=a("132d"),m=a("0fd9"),f=Object(n["a"])(s,i,r,!1,null,null,null);e["a"]=f.exports;c()(f,{VCol:u["a"],VContainer:d["a"],VIcon:v["a"],VRow:m["a"]})},f242:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[a("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),a("v-app-bar",{attrs:{app:""}},[a("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),a("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[a("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),a("v-spacer"),a("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[a("v-list",[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),a("v-divider"),a("v-list-item",{attrs:{to:"/system-users/profil"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-title",[t._v("Profil")])],1),a("v-divider"),a("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-power")])],1),a("v-list-item-title",[t._v("Logout")])],1)],1)],1),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawerRight=!t.drawerRight}}},[a("v-icon",[t._v("mdi-menu-open")])],1)],1),a("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),a("v-divider"),a("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("BLOG-GROUP")?a("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/blog"},link:"",color:"green"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-floor-b")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("BOARD BLOG")])],1)],1):t._e(),a("v-subheader",[t._v("PAGES")]),a("v-list-item",{attrs:{link:"",to:"/blog/pages/infokampus"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-seat-legroom-extra")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" INFO KAMPUS ")])],1)],1)],1)],1),t.showrightsidebar?a("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:t.temporaryrightsidebar},model:{value:t.drawerRight,callback:function(e){t.drawerRight=e},expression:"drawerRight"}},[a("v-list",{attrs:{dense:""}},[t._t("filtersidebar")],2)],1):t._e(),a("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),a("v-footer",{attrs:{app:"",padless:"",fixed:""}},[a("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[a("v-divider"),a("v-card-text",{staticClass:"py-2 black--text text-center"},[a("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),a("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[a("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},r=[],o=a("5530"),s=(a("5319"),a("ac1f"),a("2f62")),n={name:"BlogLayout",props:{temporaryrightsidebar:{type:Boolean,default:!0},showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(o["a"])(Object(o["a"])({},Object(s["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=n,c=a("2877"),u=a("6544"),d=a.n(u),v=a("40dc"),m=a("5bc1"),f=a("8212"),p=a("8336"),h=a("b0af"),g=a("99d9"),_=a("ce7e"),b=a("553a"),k=a("132d"),T=a("adda"),A=a("8860"),x=a("da13"),V=a("8270"),C=a("5d23"),I=a("34c3"),w=a("f6c4"),y=a("e449"),E=a("f774"),R=a("2fa4"),S=a("e0c7"),O=a("afd9"),L=a("2a7f"),M=Object(c["a"])(l,i,r,!1,null,null,null);e["a"]=M.exports;d()(M,{VAppBar:v["a"],VAppBarNavIcon:m["a"],VAvatar:f["a"],VBtn:p["a"],VCard:h["a"],VCardText:g["d"],VDivider:_["a"],VFooter:b["a"],VIcon:k["a"],VImg:T["a"],VList:A["a"],VListItem:x["a"],VListItemAvatar:V["a"],VListItemContent:C["g"],VListItemIcon:I["a"],VListItemSubtitle:C["j"],VListItemTitle:C["k"],VMain:w["a"],VMenu:y["a"],VNavigationDrawer:E["a"],VSpacer:R["a"],VSubheader:S["a"],VSystemBar:O["a"],VToolbarTitle:L["c"]})}}]);