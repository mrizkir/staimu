(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-12578f90"],{"0639":function(t,i,e){"use strict";var a=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-list-item",[e("v-list-item-content",[e("v-select",{attrs:{items:t.daftar_prodi,"item-text":"text","item-value":"id",label:"PROGRAM STUDI",outlined:""},model:{value:t.prodi_id,callback:function(i){t.prodi_id=i},expression:"prodi_id"}}),e("v-select",{attrs:{items:t.daftar_ta,label:"TAHUN PENDAFTARAN",outlined:""},model:{value:t.tahun_pendaftaran,callback:function(i){t.tahun_pendaftaran=i},expression:"tahun_pendaftaran"}})],1)],1)},s=[],n={name:"FilterMode7",created:function(){this.daftar_prodi=this.$store.getters["uiadmin/getDaftarProdi"],this.prodi_id=this.$store.getters["uiadmin/getProdiID"],this.daftar_ta=this.$store.getters["uiadmin/getDaftarTA"],this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"]},data:function(){return{firstloading:!0,daftar_prodi:[],prodi_id:null,daftar_ta:[],tahun_pendaftaran:null}},methods:{setFirstTimeLoading:function(t){this.firstloading=t}},watch:{tahun_pendaftaran:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateTahunPendaftaran",t),this.$emit("changeTahunPendaftaran",t))},prodi_id:function(t){this.firstloading||(this.$store.dispatch("uiadmin/updateProdi",t),this.$emit("changeProdi",t))}}},r=n,o=e("2877"),l=e("6544"),d=e.n(l),c=e("da13"),m=e("5d23"),u=e("b974"),v=Object(o["a"])(r,a,s,!1,null,null,null);i["a"]=v.exports;d()(v,{VListItem:c["a"],VListItemContent:m["g"],VSelect:u["a"]})},"577c":function(t,i,e){"use strict";e.r(i);var a=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("AkademikLayout",{scopedSlots:t._u([{key:"filtersidebar",fn:function(){return[e("Filter7",{ref:"filter7",on:{changeTahunPendaftaran:t.changeTahunPendaftaran,changeProdi:t.changeProdi}})]},proxy:!0}])},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-book-open ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" TRANSKRIP NILAI KURIKULUM ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v(" TAHUN PENDAFTARAN "+t._s(t.tahun_pendaftaran)+" - "+t._s(t.nama_prodi)+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman berisi daftar transkrip nilai berdasarkan kurikulum. Jumlah SKS, Jumlah Matkul, dan IPK Sementara nilai-nya tidak realtime. ")])]},proxy:!0}])}),e("v-container",{attrs:{fluid:""}},[e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-text",[e("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:t.search,callback:function(i){t.search=i},expression:"search"}}),e("v-switch",{staticClass:"font-weight-bold",attrs:{label:"ABAIKAN FILTER"},model:{value:t.filter_ignore,callback:function(i){t.filter_ignore=i},expression:"filter_ignore"}})],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,search:t.search,"item-key":"user_id","show-expand":"",expanded:t.expanded,"single-expand":!0,"disable-pagination":!0,"hide-default-footer":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(i){t.expanded=i},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[t._v("DAFTAR MAHASISWA")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer")],1)]},proxy:!0},{key:"item.idkelas",fn:function(i){var e=i.item;return[t._v(" "+t._s(t.$store.getters["uiadmin/getNamaKelas"](e.idkelas))+" ")]}},{key:"item.actions",fn:function(i){var a=i.item;return[e("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(i){var s=i.on,n=i.attrs;return[e("v-btn",t._g(t._b({staticClass:"ma-2",attrs:{color:"primary",icon:"",outlined:"","x-small":"",disabled:t.btnLoading},on:{click:function(i){return i.stopPropagation(),t.viewItem(a)}}},"v-btn",n,!1),s),[e("v-icon",[t._v("mdi-eye")])],1)]}}],null,!0)},[e("span",[t._v("Detail Transkrip")])]),e("v-tooltip",{attrs:{bottom:""},scopedSlots:t._u([{key:"activator",fn:function(i){var s=i.on,n=i.attrs;return[e("v-btn",t._g(t._b({staticClass:"ma-2",attrs:{color:"primary",icon:"",outlined:"","x-small":"",disabled:t.btnLoading},on:{click:function(i){return i.stopPropagation(),t.printpdf2(a)}}},"v-btn",n,!1),s),[e("v-icon",[t._v("mdi-printer")])],1)]}}],null,!0)},[e("span",[t._v("Cetak Transkrip Dua Kolom")])])]}},{key:"expanded-item",fn:function(i){var a=i.headers,s=i.item;return[e("td",{staticClass:"text-center",attrs:{colspan:a.length}},[e("v-col",{attrs:{cols:"12"}},[e("strong",[t._v("user_id:")]),t._v(t._s(s.user_id)+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1),e("v-dialog",{attrs:{"max-width":"500px",persistent:""},model:{value:t.dialogprintpdf,callback:function(i){t.dialogprintpdf=i},expression:"dialogprintpdf"}},[e("v-card",[e("v-card-title",[e("span",{staticClass:"headline"},[t._v("Print to PDF")])]),e("v-card-text",[e("v-btn",{attrs:{color:"green",text:"",href:t.$api.url+"/"+t.file_pdf}},[t._v(" Download ")])],1),e("v-card-actions",[e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(i){return i.stopPropagation(),t.closedialogprintpdf(i)}}},[t._v("CLOSE")])],1)],1)],1)],1)},s=[],n=e("1da1"),r=(e("841c"),e("ac1f"),e("96cf"),e("e60c")),o=e("e477"),l=e("0639"),d={name:"TranskripNilaiKurikulum",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"NILAI",disabled:!1,href:"#"},{text:"TRANSKRIP KURIKULUM",disabled:!0,href:"#"}];var t=this.$store.getters["uiadmin/getProdiID"];this.prodi_id=t,this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"],this.initialize()},data:function(){return{firstloading:!0,prodi_id:null,nama_prodi:null,tahun_pendaftaran:null,filter_ignore:!1,awaiting_search:!1,btnLoading:!1,btnLoadingTable:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"NIM",value:"nim",sortable:!0,width:100},{text:"NAMA MAHASISWA",value:"nama_mhs",sortable:!0},{text:"KELAS",value:"idkelas",sortable:!0,width:120},{text:"JUMLAH MATKUL",value:"jumlah_matkul",sortable:!1,width:100},{text:"JUMLAH SKS",value:"jumlah_sks",sortable:!1,width:100},{text:"IPK SEMENTARA",value:"ipk",sortable:!0,width:100},{text:"AKSI",value:"actions",sortable:!1,width:120}],search:"",dialogprintpdf:!1,file_pdf:null}},methods:{changeTahunPendaftaran:function(t){this.tahun_pendaftaran=t},changeProdi:function(t){this.prodi_id=t},initialize:function(){var t=Object(n["a"])(regeneratorRuntime.mark((function t(){var i=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.post("/akademik/nilai/transkripkurikulum",{prodi_id:this.prodi_id,ta:this.tahun_pendaftaran},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;i.datatable=e.mahasiswa,i.datatableLoading=!1})).catch((function(){i.datatableLoading=!1}));case 3:this.firstloading=!1,this.$refs.filter7.setFirstTimeLoading(this.firstloading);case 5:case"end":return t.stop()}}),t,this)})));function i(){return t.apply(this,arguments)}return i}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]},viewItem:function(t){this.$router.push("/akademik/nilai/transkripkurikulum/"+t.user_id)},printpdf2:function(t){var i=this;return Object(n["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return i.btnLoading=!0,e.next=3,i.$ajax.get("/akademik/nilai/transkripkurikulum/printpdf2/"+t.user_id,{headers:{Authorization:i.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;i.file_pdf=e.pdf_file,i.dialogprintpdf=!0,i.btnLoading=!1})).catch((function(){i.btnLoading=!1}));case 3:case"end":return e.stop()}}),e)})))()},closedialogprintpdf:function(){var t=this;setTimeout((function(){t.file_pdf=null,t.dialogprintpdf=!1}),300)}},watch:{tahun_pendaftaran:function(){this.firstloading||this.initialize()},prodi_id:function(t){this.firstloading||(this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](t),this.initialize())},search:function(){var t=this;this.awaiting_search||setTimeout(Object(n["a"])(regeneratorRuntime.mark((function i(){return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:if(!(t.search.length>0&&t.filter_ignore)){i.next=4;break}return t.datatableLoading=!0,i.next=4,t.$ajax.post("/akademik/nilai/transkripkurikulum",{prodi_id:t.prodi_id,ta:t.tahun_pendaftaran,search:t.search},{headers:{Authorization:t.$store.getters["auth/Token"]}}).then((function(i){var e=i.data;t.datatable=e.mahasiswa,t.datatableLoading=!1}));case 4:t.awaiting_search=!1;case 5:case"end":return i.stop()}}),i)}))),1e3),this.awaiting_search=!0}},components:{AkademikLayout:r["a"],ModuleHeader:o["a"],Filter7:l["a"]}},c=d,m=e("2877"),u=e("6544"),v=e.n(u),h=e("0798"),A=e("2bc5"),p=e("8336"),S=e("b0af"),_=e("99d9"),g=e("62ad"),f=e("a523"),k=e("8fea"),C=e("169a"),E=e("ce7e"),T=e("132d"),I=e("0fd9"),b=e("2fa4"),L=e("b73d"),R=e("8654"),K=e("71d9"),N=e("2a7f"),M=e("3a2f"),x=Object(m["a"])(c,a,s,!1,null,null,null);i["default"]=x.exports;v()(x,{VAlert:h["a"],VBreadcrumbs:A["a"],VBtn:p["a"],VCard:S["a"],VCardActions:_["b"],VCardText:_["d"],VCardTitle:_["e"],VCol:g["a"],VContainer:f["a"],VDataTable:k["a"],VDialog:C["a"],VDivider:E["a"],VIcon:T["a"],VRow:I["a"],VSpacer:b["a"],VSwitch:L["a"],VTextField:R["a"],VToolbar:K["a"],VToolbarTitle:N["c"],VTooltip:M["a"]})},e477:function(t,i,e){"use strict";var a=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("v-container",{attrs:{fluid:t.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},s=[],n={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=n,o=e("2877"),l=e("6544"),d=e.n(l),c=e("62ad"),m=e("a523"),u=e("132d"),v=e("0fd9"),h=Object(o["a"])(r,a,s,!1,null,null,null);i["a"]=h.exports;d()(h,{VCol:c["a"],VContainer:m["a"],VIcon:u["a"],VRow:v["a"]})},e60c:function(t,i,e){"use strict";var a=function(){var t=this,i=t.$createElement,e=t._self._c||i;return e("div",[e("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[e("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),e("v-app-bar",{attrs:{app:""}},[e("v-app-bar-nav-icon",{class:this.$store.getters["uiadmin/getTheme"]("V-APP-BAR-NAV-ICON-CSS-CLASS"),on:{click:function(i){i.stopPropagation(),t.drawer=!t.drawer}}}),e("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(i){i.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[e("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),e("v-spacer"),e("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(i){var a=i.on;return[e("v-avatar",{attrs:{size:"30"}},[e("v-img",t._g({attrs:{src:t.photoUser}},a))],1)]}}])},[e("v-list",[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),e("v-divider"),e("v-list-item",{attrs:{to:"/system-users/profil"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account")])],1),e("v-list-item-title",[t._v("Profil")])],1),e("v-divider"),e("v-list-item",{on:{click:function(i){return i.preventDefault(),t.logout(i)}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-power")])],1),e("v-list-item-title",[t._v("Logout")])],1)],1)],1),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-app-bar-nav-icon",{on:{click:function(i){i.stopPropagation(),t.drawerRight=!t.drawerRight}}},[e("v-icon",[t._v("mdi-menu-open")])],1)],1),e("v-navigation-drawer",{class:this.$store.getters["uiadmin/getTheme"]("V-NAVIGATION-DRAWER-CSS-CLASS"),attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(i){t.drawer=i},expression:"drawer"}},[e("v-list-item",[e("v-list-item-avatar",[e("v-img",{attrs:{src:t.photoUser},on:{click:function(i){return i.stopPropagation(),t.toProfile(i)}}})],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),e("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),e("v-divider"),e("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("AKADEMIK-GROUP")?e("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-CSS-CLASS"),attrs:{to:{path:"/akademik"},link:"",color:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-BOARD-COLOR")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-monitor-dashboard")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("BOARD AKADEMIK")])],1)],1):t._e(),e("v-subheader",[t._v("PERWALIAN")]),t.CAN_ACCESS("SYSTEM-USERS-DOSEN-WALI_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dosenwali","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-teach")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DOSEN WALI ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")||t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?e("v-subheader",[t._v("DAFTAR ULANG")]):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mhsbelumpunyanim","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-alert")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" BELUM PUNYA NIM ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-BARU_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswabaru","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-arrow-left")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MAHASISWA BARU ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-DULANG-LAMA_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/dulang/mahasiswalama","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-account-box-multiple")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MAHASISWA LAMA ")])],1)],1):t._e(),e("v-subheader",[t._v("PERKULIAHAN")]),t.CAN_ACCESS("AKADEMIK-MATAKULIAH_BROWSE")?e("v-list-item",{attrs:{link:"",to:"/akademik/matakuliah","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-book")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" MATAKULIAH ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/penyelenggaraan","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-home-floor-b")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("PENYELENGGARAAN")])],1)]},proxy:!0}],null,!1,2791626149)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/penyelenggaraan/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/penyelenggaraan/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PENYELENGGARAAN_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/penyelenggaraan/"+t.paramid+"/dosenpengampu"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DOSEN PENGAMPU ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/krs","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-format-columns")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("KRS")])],1)]},proxy:!0}],null,!1,2196385036)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/krs/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/krs/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_SHOW")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/detail"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DETAIL KRS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-KRS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/krs/"+t.paramid+"/tambahmatkul"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH MATKUL ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-VERIFIKASI-KRS_STORE")?e("v-list-item",{attrs:{link:"",to:{path:"/akademik/perkuliahan/krs/verifikasi"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" VERIFIKASI KRS ")])],1)],1):t._e()],1)]):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?e("v-list-group",{attrs:{group:"/akademik/perkuliahan/pembagiankelas","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-google-classroom")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("PEMBAGIAN KELAS")])],1)]},proxy:!0}],null,!1,3897047730)},[e("div",[t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/perkuliahan/pembagiankelas/daftar",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" DAFTAR ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:"/akademik/perkuliahan/pembagiankelas/tambah"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TAMBAH KELAS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-PERKULIAHAN-PEMBAGIAN-KELAS_STORE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),disabled:"",to:{path:"/akademik/perkuliahan/pembagiankelas/"+t.paramid+"/peserta"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PESERTA ")])],1)],1):t._e()],1)]):t._e(),e("v-subheader",[t._v("NILAI")]),!t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_BROWSE")||"puslahta"!=t.dashboard&&"dosen"!=t.dashboard?t._e():e("v-list-group",{attrs:{group:"/akademik/nilai/matakuliah","active-class":"yellow","no-action":"",color:"green"},scopedSlots:t._u([{key:"activator",fn:function(){return[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-format-columns")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("ISI NILAI")])],1)]},proxy:!0}],null,!1,927400214)},[e("div",[t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"dosen"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperdosen",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KELAS MHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"puslahta"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperkelasmhs",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KELAS MHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-MATAKULIAH_STORE")&&"puslahta"==t.dashboard?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:"/akademik/nilai/matakuliah/isiperkrs",color:"white"}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" PER KRS ")])],1)],1):t._e()],1)]),t.CAN_ACCESS("AKADEMIK-NILAI-KONVERSI_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/konversi"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KONVERSI NILAI ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-KHS_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/khs"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" KHS ")])],1)],1):t._e(),t.CAN_ACCESS("AKADEMIK-NILAI-TRANSKRIP-KURIKULUM_BROWSE")?e("v-list-item",{attrs:{link:"","active-class":this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS"),to:{path:"/akademik/nilai/transkripkurikulum"}}},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-arrow-right-bold-hexagon-outline")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v(" TRANSKRIP KURIKULUM ")])],1)],1):t._e()],1)],1),t.showrightsidebar?e("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(i){t.drawerRight=i},expression:"drawerRight"}},[e("v-list",{attrs:{dense:""}},[e("v-list-item",[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-menu-open")])],1),e("v-list-item-content",[e("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),e("v-divider"),e("v-list-item",{class:this.$store.getters["uiadmin/getTheme"]("V-LIST-ITEM-ACTIVE-CSS-CLASS")},[e("v-list-item-icon",{staticClass:"mr-2"},[e("v-icon",[t._v("mdi-filter")])],1),e("v-list-item-content",[e("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),e("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),e("v-footer",{attrs:{app:"",padless:"",fixed:""}},[e("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[e("v-divider"),e("v-card-text",{staticClass:"py-2 black--text text-center"},[e("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),e("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[e("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},s=[],n=e("5530"),r=(e("b0c0"),e("5319"),e("ac1f"),e("2f62")),o={name:"AkademikLayout",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"]},props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null,dashboard:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(n["a"])(Object(n["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,i=this.ATTRIBUTE_USER("foto");return t=""==i?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+i,t},paramid:function(){var t="empty";switch(this.$route.name){case"PerkuliahanPenyelenggaraanDosenPengampu":t=this.$route.params.idpenyelenggaraan;break;case"PerkuliahanKRSDetail":t=this.$route.params.krsid;break;case"PerkuliahanKRSTambahMatkul":t=this.$route.params.krsid;break;case"PerkuliahanPembagianKelasPeserta":t=this.$route.params.kelas_mhs_id;break}return t}}),watch:{loginTime:{handler:function(t){var i=this;t>=0?setTimeout((function(){i.loginTime=1==i.AUTHENTICATED?i.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,d=e("2877"),c=e("6544"),m=e.n(c),u=e("40dc"),v=e("5bc1"),h=e("8212"),A=e("8336"),p=e("b0af"),S=e("99d9"),_=e("ce7e"),g=e("553a"),f=e("132d"),k=e("adda"),C=e("8860"),E=e("56b0"),T=e("da13"),I=e("8270"),b=e("5d23"),L=e("34c3"),R=e("f6c4"),K=e("e449"),N=e("f774"),M=e("2fa4"),x=e("e0c7"),V=e("afd9"),w=e("2a7f"),P=Object(d["a"])(l,a,s,!1,null,null,null);i["a"]=P.exports;m()(P,{VAppBar:u["a"],VAppBarNavIcon:v["a"],VAvatar:h["a"],VBtn:A["a"],VCard:p["a"],VCardText:S["d"],VDivider:_["a"],VFooter:g["a"],VIcon:f["a"],VImg:k["a"],VList:C["a"],VListGroup:E["a"],VListItem:T["a"],VListItemAvatar:I["a"],VListItemContent:b["g"],VListItemIcon:L["a"],VListItemSubtitle:b["j"],VListItemTitle:b["k"],VMain:R["a"],VMenu:K["a"],VNavigationDrawer:N["a"],VSpacer:M["a"],VSubheader:x["a"],VSystemBar:V["a"],VToolbarTitle:w["c"]})}}]);