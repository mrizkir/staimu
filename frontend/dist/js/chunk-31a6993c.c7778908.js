(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-31a6993c"],{"68b4":function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("DataMasterLayout",{attrs:{showrightsidebar:!1}},[a("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-calendar-outline ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" TAHUN AKADEMIK ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[a("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[a("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[a("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman untuk mengelola tahun akademik pada perguruan tinggi. ")])]},proxy:!0}])}),a("v-container",{attrs:{fluid:""}},[a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-card",[a("v-card-text",[a("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1)],1)],1)],1),a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.datatable,search:t.search,"item-key":"tahun","sort-by":"tahun","show-expand":"",expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(e){t.expanded=e},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[a("v-toolbar",{attrs:{flat:"",color:"white"}},[a("v-toolbar-title",[t._v("DAFTAR TAHUN AKADEMIK")]),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-spacer"),a("v-dialog",{attrs:{"max-width":"600px",persistent:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-btn",t._g({staticClass:"ma-2",attrs:{color:"primary",icon:"",outlined:"",small:""}},i),[a("v-icon",[t._v("mdi-plus")])],1)]}}]),model:{value:t.dialogfrm,callback:function(e){t.dialogfrm=e},expression:"dialogfrm"}},[a("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[a("v-card",[a("v-card-title",[a("span",{staticClass:"headline"},[t._v(t._s(t.formTitle))])]),a("v-card-text",[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-text-field",{staticClass:"mr-1",attrs:{label:"TAHUN",outlined:"",rules:t.rule_tahun},model:{value:t.formdata.tahun,callback:function(e){t.$set(t.formdata,"tahun",e)},expression:"formdata.tahun"}})],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e(),a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-text-field",{attrs:{label:"TAHUN AKADEMIK",outlined:"",rules:t.rule_tahun_akademik},model:{value:t.formdata.tahun_akademik,callback:function(e){t.$set(t.formdata,"tahun_akademik",e)},expression:"formdata.tahun_akademik"}})],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"12",md:"12"}},[a("v-menu",{ref:"menuSemesterGanjil",attrs:{"close-on-content-click":!1,"return-value":t.semester_ganjil,transition:"scale-transition","offset-y":"","max-width":"550px","min-width":"550px"},on:{"update:returnValue":function(e){t.semester_ganjil=e},"update:return-value":function(e){t.semester_ganjil=e}},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-text-field",t._g({staticClass:"mr-1",attrs:{label:"SEMESTER GANJIL",readonly:"",outlined:""},model:{value:t.semesterGanjilText,callback:function(e){t.semesterGanjilText=e},expression:"semesterGanjilText"}},i))]}}]),model:{value:t.menuSemesterGanjil,callback:function(e){t.menuSemesterGanjil=e},expression:"menuSemesterGanjil"}},[a("v-date-picker",{attrs:{"no-title":"",scrollable:"",range:"",landscape:"","full-width":""},model:{value:t.semester_ganjil,callback:function(e){t.semester_ganjil=e},expression:"semester_ganjil"}},[a("v-spacer"),a("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){t.menuSemesterGanjil=!1}}},[t._v("Cancel")]),a("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){return t.$refs.menuSemesterGanjil.save(t.semester_ganjil)}}},[t._v("OK")])],1)],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"12",md:"12"}},[a("v-menu",{ref:"menuSemesterGenap",attrs:{"close-on-content-click":!1,"return-value":t.semester_genap,transition:"scale-transition","offset-y":"","max-width":"550px","min-width":"550px"},on:{"update:returnValue":function(e){t.semester_genap=e},"update:return-value":function(e){t.semester_genap=e}},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-text-field",t._g({staticClass:"mr-1",attrs:{label:"SEMESTER GENAP",readonly:"",outlined:""},model:{value:t.semesterGenapText,callback:function(e){t.semesterGenapText=e},expression:"semesterGenapText"}},i))]}}]),model:{value:t.menuSemesterGenap,callback:function(e){t.menuSemesterGenap=e},expression:"menuSemesterGenap"}},[a("v-date-picker",{attrs:{"no-title":"",scrollable:"",range:"",landscape:"","full-width":""},model:{value:t.semester_genap,callback:function(e){t.semester_genap=e},expression:"semester_genap"}},[a("v-spacer"),a("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){t.menuSemesterGenap=!1}}},[t._v("Cancel")]),a("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(e){return t.$refs.menuSemesterGenap.save(t.semester_genap)}}},[t._v("OK")])],1)],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1)],1),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.closedialogfrm(e)}}},[t._v("BATAL")]),a("v-btn",{attrs:{color:"blue darken-1",text:"",disabled:!t.form_valid||t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.save(e)}}},[t._v(" SIMPAN ")])],1)],1)],1)],1),a("v-dialog",{attrs:{"max-width":"600px",persistent:""},model:{value:t.dialogdetailitem,callback:function(e){t.dialogdetailitem=e},expression:"dialogdetailitem"}},[a("v-card",[a("v-card-title",[a("span",{staticClass:"headline"},[t._v("DETAIL DATA")])]),a("v-card-text",[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("TAHUN:")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.tahun)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e(),a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("TAHUN AKADEMIK :")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.tahun_akademik)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AWAL GANJIL:")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.awal_ganjil)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e(),a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AKHIR GANJIL :")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.akhir_ganjil)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AWAL GENAP:")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.awal_genap)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e(),a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AKHIR GENAP :")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.akhir_genap)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AWAL PENDEK:")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.awal_pendek)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e(),a("v-col",{attrs:{xs:"12",sm:"6",md:"6"}},[a("v-card",{attrs:{flat:""}},[a("v-card-title",[t._v("AKHIR PENDEK :")]),a("v-card-subtitle",[t._v(" "+t._s(t.formdata.akhir_pendek)+" ")])],1)],1),t.$vuetify.breakpoint.xsOnly?a("v-responsive",{attrs:{width:"100%"}}):t._e()],1)],1),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.closedialogdetailitem(e)}}},[t._v("KELUAR")])],1)],1)],1)],1)]},proxy:!0},{key:"item.awal_ganjil",fn:function(e){var a=e.item;return[t._v(" "+t._s(null==a.awal_ganjil?"N.A":t.$date(a.awal_ganjil).format("DD/MM/YYYY"))+" ")]}},{key:"item.akhir_ganjil",fn:function(e){var a=e.item;return[t._v(" "+t._s(null==a.akhir_ganjil?"N.A":t.$date(a.akhir_ganjil).format("DD/MM/YYYY"))+" ")]}},{key:"item.awal_genap",fn:function(e){var a=e.item;return[t._v(" "+t._s(null==a.awal_genap?"N.A":t.$date(a.awal_genap).format("DD/MM/YYYY"))+" ")]}},{key:"item.akhir_genap",fn:function(e){var a=e.item;return[t._v(" "+t._s(null==a.akhir_genap?"N.A":t.$date(a.akhir_genap).format("DD/MM/YYYY"))+" ")]}},{key:"item.actions",fn:function(e){var i=e.item;return[a("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(e){return e.stopPropagation(),t.viewItem(i)}}},[t._v(" mdi-eye ")]),a("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(e){return e.stopPropagation(),t.editItem(i)}}},[t._v(" mdi-pencil ")]),a("v-icon",{attrs:{small:"",disabled:t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.deleteItem(i)}}},[t._v(" mdi-delete ")])]}},{key:"expanded-item",fn:function(e){var i=e.headers,n=e.item;return[a("td",{staticClass:"text-center",attrs:{colspan:i.length}},[a("v-col",{attrs:{cols:"12"}},[a("strong",[t._v("ID:")]),t._v(t._s(n.tahun)+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},n=[],s=a("5530"),r=a("1da1"),o=(a("a434"),a("a15b"),a("96cf"),a("2f62")),l=a("94df"),c=a("e477"),d={name:"TahunAkademik",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.ACCESS_TOKEN},{text:"DATA MASTER",disabled:!1,href:"#"},{text:"TAHUN AKADEMIK",disabled:!0,href:"#"}],this.initialize()},data:function(){var t=new Date,e=[t.getFullYear()+"-09-01",t.getFullYear()+1+"-02-28"],a=[t.getFullYear()+1+"-03-01",t.getFullYear()+1+"-08-31"];return{btnLoading:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"TA",value:"tahun",width:50},{text:"TAHUN AKADEMIK",value:"tahun_akademik",width:150},{text:"AWAL GANJIL",value:"awal_ganjil",width:50},{text:"AKHIR GANJIL",value:"akhir_ganjil",width:50},{text:"AWAL GENAP",value:"awal_genap",width:50},{text:"AKHIR GENAP",value:"akhir_genap",width:50},{text:"AWAL PENDEK",value:"awal_pendek",width:50},{text:"AKHIR PENDEK",value:"akhir_pendek",width:50},{text:"AKSI",value:"actions",sortable:!1,width:100}],search:"",dialogfrm:!1,dialogdetailitem:!1,old_tahun:"",form_valid:!0,menuSemesterGanjil:!1,semester_ganjil:e,menuSemesterGenap:!1,semester_genap:a,formdata:{tahun:"",tahun_akademik:"",awal_ganjil:"",akhir_ganjil:"",awal_genap:"",akhir_genap:"",awal_pendek:"",akhir_pendek:""},formdefault:{tahun:"",tahun_akademik:"",awal_ganjil:"",akhir_ganjil:"",awal_genap:"",akhir_genap:"",awal_pendek:"",akhir_pendek:""},editedIndex:-1,rule_tahun:[function(t){return!!t||"Tahun Akademik mohon untuk diisi Misalnya 2020 !!!"},function(t){return/^[0-9]+$/.test(t)||"Tahun Akademik hanya boleh angka"},function(t){return!(t&&"undefined"!==typeof t&&t.length>0)||(4==t.length||"Tahun Akademik hanya boleh 4 karakter")}],rule_tahun_akademik:[function(t){return!!t||"Mohon untuk di isi nama tahun akademik !!!"}]}},methods:{initialize:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.get("/datamaster/tahunakademik",{headers:{Authorization:this.TOKEN}}).then((function(t){var a=t.data;e.datatable=a.ta,e.datatableLoading=!1})).catch((function(){e.datatableLoading=!1}));case 3:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]},viewItem:function(t){this.formdata=t,this.dialogdetailitem=!0},editItem:function(t){this.editedIndex=this.datatable.indexOf(t),this.formdata=Object.assign({},t),this.semester_ganjil[0]=null==this.formdata.awal_ganjil?t.tahun+"-09-01":t.awal_ganjil,this.semester_ganjil[1]=null==this.formdata.akhir_ganjil?t.tahun+1+"-02-31":t.akhir_ganjil,this.semester_genap[0]=null==this.formdata.awal_genap?t.tahun+1+"-03-01":t.awal_genap,this.semester_genap[1]=null==this.formdata.akhir_genap?t.tahun+1+"-08-31":t.akhir_genap,this.old_tahun=t.tahun,this.dialogfrm=!0},save:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:if(!this.$refs.frmdata.validate()){t.next=9;break}if(this.btnLoading=!0,!(this.editedIndex>-1)){t.next=7;break}return t.next=5,this.$ajax.post("/datamaster/tahunakademik/"+this.old_tahun,{_method:"PUT",tahun:this.formdata.tahun,tahun_akademik:this.formdata.tahun_akademik,awal_ganjil:this.semester_ganjil[0],akhir_ganjil:this.semester_ganjil[1],awal_genap:this.semester_genap[0],akhir_genap:this.semester_genap[1]},{headers:{Authorization:this.TOKEN}}).then((function(){e.$router.go(),e.btnLoading=!1})).catch((function(){e.btnLoading=!1}));case 5:t.next=9;break;case 7:return t.next=9,this.$ajax.post("/datamaster/tahunakademik/store",{tahun:this.formdata.tahun,tahun_akademik:this.formdata.tahun_akademik,awal_ganjil:this.semester_ganjil[0],akhir_ganjil:this.semester_ganjil[1],awal_genap:this.semester_genap[0],akhir_genap:this.semester_genap[1]},{headers:{Authorization:this.TOKEN}}).then((function(t){var a=t.data;e.datatable.push(a.ta),e.closedialogfrm(),e.btnLoading=!1})).catch((function(){e.btnLoading=!1}));case 9:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),deleteItem:function(t){var e=this;this.$root.$confirm.open("Delete","Apakah Anda ingin menghapus data dengan ID "+t.tahun+" ?",{color:"red"}).then((function(a){a&&(e.btnLoading=!0,e.$ajax.post("/datamaster/tahunakademik/"+t.tahun,{_method:"DELETE"},{headers:{Authorization:e.TOKEN}}).then((function(){var a=e.datatable.indexOf(t);e.datatable.splice(a,1),e.btnLoading=!1})).catch((function(){e.btnLoading=!1})))}))},closedialogdetailitem:function(){this.$router.go()},closedialogfrm:function(){this.$router.go()}},computed:Object(s["a"])(Object(s["a"])({},Object(o["b"])("auth",{ACCESS_TOKEN:"AccessToken",TOKEN:"Token"})),{},{formTitle:function(){return-1===this.editedIndex?"TAMBAH DATA":"UBAH DATA"},semesterGanjilText:{set:function(){},get:function(){return this.semester_ganjil.join(" ~ ")}},semesterGenapText:{set:function(){},get:function(){return this.semester_genap.join(" ~ ")}}}),components:{DataMasterLayout:l["a"],ModuleHeader:c["a"]}},u=d,m=a("2877"),v=a("6544"),h=a.n(v),_=a("0798"),p=a("2bc5"),f=a("8336"),g=a("b0af"),k=a("99d9"),A=a("62ad"),b=a("a523"),x=a("8fea"),T=a("2e4b"),w=a("169a"),E=a("ce7e"),S=a("4bd4"),C=a("132d"),y=a("e449"),j=a("6b53"),R=a("0fd9"),I=a("2fa4"),N=a("8654"),D=a("71d9"),L=a("2a7f"),O=Object(m["a"])(u,i,n,!1,null,null,null);e["default"]=O.exports;h()(O,{VAlert:_["a"],VBreadcrumbs:p["a"],VBtn:f["a"],VCard:g["a"],VCardActions:k["b"],VCardSubtitle:k["c"],VCardText:k["d"],VCardTitle:k["e"],VCol:A["a"],VContainer:b["a"],VDataTable:x["a"],VDatePicker:T["a"],VDialog:w["a"],VDivider:E["a"],VForm:S["a"],VIcon:C["a"],VMenu:y["a"],VResponsive:j["a"],VRow:R["a"],VSpacer:I["a"],VTextField:N["a"],VToolbar:D["a"],VToolbarTitle:L["c"]})},"94df":function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("v-system-bar",{class:this.$store.getters["uiadmin/getTheme"]("V-SYSTEM-BAR-CSS-CLASS"),attrs:{app:"",dark:""}},[a("strong",[t._v("Hak Akses Sebagai :")]),t._v(" "+t._s(t.ROLE)+" ")]),a("v-app-bar",{attrs:{app:""}},[a("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),a("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[a("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),a("v-spacer"),a("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[a("v-list",[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),a("v-divider"),a("v-list-item",{attrs:{to:"/system-users/profil"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-title",[t._v("Profil")])],1),a("v-divider"),a("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-power")])],1),a("v-list-item-title",[t._v("Logout")])],1)],1)],1),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-app-bar-nav-icon",{on:{click:function(e){e.stopPropagation(),t.drawerRight=!t.drawerRight}}},[a("v-icon",[t._v("mdi-menu-open")])],1)],1),a("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.temporaryleftsidebar,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" ["+t._s(t.DEFAULT_ROLE)+"] ")])],1)],1),a("v-divider"),a("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("DMASTER-GROUP")?a("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/dmaster"},link:"",color:"green"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-floor-b")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("BOARD DATA MASTER")])],1)],1):t._e(),a("v-subheader",[t._v("FASILITAS")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/ruangkelas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-seat-legroom-extra")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" RUANG KELAS ")])],1)],1),a("v-subheader",[t._v("PMB")]),t.CAN_ACCESS("DMASTER-PERSYARATAN-PMB_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/persyaratanpmb"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-format-list-checks")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PERSYARATAN PMB ")])],1)],1):t._e(),a("v-subheader",[t._v("MAHASISWA")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/statusmahasiswa"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-arrow-vertical-lock")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" STATUS MAHASISWA ")])],1)],1),t.CAN_ACCESS("DMASTER-KELAS_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/kelas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-google-classroom")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" KELAS ")])],1)],1):t._e(),a("v-list-item",{attrs:{link:"",to:"/dmaster/jenjangstudi"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-stairs-up")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" JENJANG STUDI ")])],1)],1),t.CAN_ACCESS("DMASTER-FAKULTAS_BROWSE")&&t.isBentukPT("universitas")?a("v-list-item",{attrs:{link:"",to:"/dmaster/fakultas"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" FAKULTAS ")])],1)],1):t._e(),t.CAN_ACCESS("DMASTER-PRODI_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/programstudi"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-home-assistant")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PROGRAM STUDI ")])],1)],1):t._e(),a("v-subheader",[t._v("DOSEN")]),a("v-list-item",{attrs:{link:"",to:"/dmaster/jabatanakademik"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-chair-rolling")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" JABATAN AKADEMIK ")])],1)],1),a("v-subheader",[t._v("AKADEMIK")]),t.CAN_ACCESS("DMASTER-TA_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/ta"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-calendar-outline")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TAHUN AKADEMIK ")])],1)],1):t._e(),t.CAN_ACCESS("DMASTER-PERSYARATAN-UJIAN-MUNAQASAH_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/dmaster/persyaratanujianmunaqasah"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-format-list-checks")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" SYARAT UJIAN MUNAQASAH ")])],1)],1):t._e()],1)],1),t.showrightsidebar?a("v-navigation-drawer",{attrs:{width:"300",app:"",fixed:"",right:"",temporary:""},model:{value:t.drawerRight,callback:function(e){t.drawerRight=e},expression:"drawerRight"}},[a("v-list",{attrs:{dense:""}},[a("v-list-item",[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-menu-open")])],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" OPTIONS ")])],1)],1),a("v-divider"),a("v-list-item",{staticClass:"teal lighten-5 mb-5"},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-filter")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("FILTER")])],1)],1),t._t("filtersidebar")],2)],1):t._e(),a("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2),a("v-footer",{attrs:{app:"",padless:"",fixed:""}},[a("v-card",{staticClass:"flex",attrs:{color:"yellow darken-2",flat:"",tile:""}},[a("v-divider"),a("v-card-text",{staticClass:"py-2 black--text text-center"},[a("strong",[t._v(t._s(t.APP_NAME)+" (2021-2021)")]),t._v(" dikembangkan oleh TIM IT STAI Miftahul 'Ulum Tanjungpinang "),a("v-btn",{attrs:{icon:"",href:"https://github.com/mrizkir/stiemu"}},[a("v-icon",[t._v("mdi-github")])],1)],1)],1)],1)],1)},n=[],s=a("5530"),r=(a("5319"),a("ac1f"),a("2f62")),o={name:"DataMasterLayout",props:{showrightsidebar:{type:Boolean,default:!0},temporaryleftsidebar:{type:Boolean,default:!1}},data:function(){return{loginTime:0,drawer:null,drawerRight:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(s["a"])(Object(s["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",DEFAULT_ROLE:"DefaultRole",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"})),{},{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,c=a("2877"),d=a("6544"),u=a.n(d),m=a("40dc"),v=a("5bc1"),h=a("8212"),_=a("8336"),p=a("b0af"),f=a("99d9"),g=a("ce7e"),k=a("553a"),A=a("132d"),b=a("adda"),x=a("8860"),T=a("da13"),w=a("8270"),E=a("5d23"),S=a("34c3"),C=a("f6c4"),y=a("e449"),j=a("f774"),R=a("2fa4"),I=a("e0c7"),N=a("afd9"),D=a("2a7f"),L=Object(c["a"])(l,i,n,!1,null,null,null);e["a"]=L.exports;u()(L,{VAppBar:m["a"],VAppBarNavIcon:v["a"],VAvatar:h["a"],VBtn:_["a"],VCard:p["a"],VCardText:f["d"],VDivider:g["a"],VFooter:k["a"],VIcon:A["a"],VImg:b["a"],VList:x["a"],VListItem:T["a"],VListItemAvatar:w["a"],VListItemContent:E["g"],VListItemIcon:S["a"],VListItemSubtitle:E["j"],VListItemTitle:E["k"],VMain:C["a"],VMenu:y["a"],VNavigationDrawer:j["a"],VSpacer:R["a"],VSubheader:I["a"],VSystemBar:N["a"],VToolbarTitle:D["c"]})},e477:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:t.isReportPage}},[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("h1",{staticClass:"subheading grey--text"},[a("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},n=[],s={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=s,o=a("2877"),l=a("6544"),c=a.n(l),d=a("62ad"),u=a("a523"),m=a("132d"),v=a("0fd9"),h=Object(o["a"])(r,i,n,!1,null,null,null);e["a"]=h.exports;c()(h,{VCol:d["a"],VContainer:u["a"],VIcon:m["a"],VRow:v["a"]})}}]);