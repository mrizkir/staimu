(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-52445479"],{c820:function(t,e,a){"use strict";a.r(e);var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("SystemUserLayout",[a("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-account ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" USERS SUPER ADMIN ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[a("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[a("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[a("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" User dengan role Super Admin bertanggungjawab terhadap proses keseluruhan sistem. ")])]},proxy:!0}])}),a("v-container",{attrs:{fluid:""}},[a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-card",[a("v-card-text",[a("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:t.search,callback:function(e){t.search=e},expression:"search"}})],1)],1)],1)],1),a("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12"}},[a("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers,items:t.daftar_users,search:t.search,"item-key":"id","sort-by":"name","show-expand":"",expanded:t.expanded,"single-expand":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(e){t.expanded=e},"click:row":t.dataTableRowClicked},scopedSlots:t._u([{key:"top",fn:function(){return[a("v-toolbar",{attrs:{flat:"",color:"white"}},[a("v-toolbar-title",[t._v("DAFTAR USERS SUPER ADMIN")]),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-spacer"),a("v-btn",{staticClass:"mb-2",attrs:{color:"primary",loading:t.btnLoading,disabled:t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.showDialogTambahUserSuperAdmin(e)}}},[t._v(" TAMBAH ")]),a("v-dialog",{attrs:{"max-width":"500px",persistent:""},model:{value:t.dialog,callback:function(e){t.dialog=e},expression:"dialog"}},[a("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[a("v-card",[a("v-card-title",[a("span",{staticClass:"headline"},[t._v(t._s(t.formTitle))])]),a("v-card-text",[a("v-text-field",{attrs:{label:"NAMA USER",outlined:"",rules:t.rule_user_name},model:{value:t.editedItem.name,callback:function(e){t.$set(t.editedItem,"name",e)},expression:"editedItem.name"}}),a("v-text-field",{attrs:{label:"EMAIL",outlined:"",rules:t.rule_user_email},model:{value:t.editedItem.email,callback:function(e){t.$set(t.editedItem,"email",e)},expression:"editedItem.email"}}),a("v-text-field",{attrs:{label:"NOMOR HP",outlined:"",rules:t.rule_user_nomorhp},model:{value:t.editedItem.nomor_hp,callback:function(e){t.$set(t.editedItem,"nomor_hp",e)},expression:"editedItem.nomor_hp"}}),a("v-text-field",{attrs:{label:"USERNAME",outlined:"",rules:t.rule_user_username},model:{value:t.editedItem.username,callback:function(e){t.$set(t.editedItem,"username",e)},expression:"editedItem.username"}}),a("v-text-field",{attrs:{label:"PASSWORD",type:"password",outlined:"",rules:t.rule_user_password},model:{value:t.editedItem.password,callback:function(e){t.$set(t.editedItem,"password",e)},expression:"editedItem.password"}}),a("v-autocomplete",{attrs:{items:t.daftar_roles,label:"ROLES",multiple:"","small-chips":"",outlined:""},model:{value:t.editedItem.role_id,callback:function(e){t.$set(t.editedItem,"role_id",e)},expression:"editedItem.role_id"}})],1),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.close(e)}}},[t._v("BATAL")]),a("v-btn",{attrs:{color:"blue darken-1",text:"",loading:t.btnLoading,disabled:!t.form_valid||t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.save(e)}}},[t._v(" SIMPAN ")])],1)],1)],1)],1),a("v-dialog",{attrs:{"max-width":"500px",persistent:""},model:{value:t.dialogEdit,callback:function(e){t.dialogEdit=e},expression:"dialogEdit"}},[a("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(e){t.form_valid=e},expression:"form_valid"}},[a("v-card",[a("v-card-title",[a("span",{staticClass:"headline"},[t._v(t._s(t.formTitle))])]),a("v-card-text",[a("v-text-field",{attrs:{label:"NAMA USER",outlined:"",rules:t.rule_user_name},model:{value:t.editedItem.name,callback:function(e){t.$set(t.editedItem,"name",e)},expression:"editedItem.name"}}),a("v-text-field",{attrs:{label:"EMAIL",outlined:"",rules:t.rule_user_email},model:{value:t.editedItem.email,callback:function(e){t.$set(t.editedItem,"email",e)},expression:"editedItem.email"}}),a("v-text-field",{attrs:{label:"NOMOR HP",outlined:"",rules:t.rule_user_nomorhp},model:{value:t.editedItem.nomor_hp,callback:function(e){t.$set(t.editedItem,"nomor_hp",e)},expression:"editedItem.nomor_hp"}}),a("v-text-field",{attrs:{label:"USERNAME",outlined:"",rules:t.rule_user_username},model:{value:t.editedItem.username,callback:function(e){t.$set(t.editedItem,"username",e)},expression:"editedItem.username"}}),a("v-text-field",{attrs:{label:"PASSWORD",type:"password",outlined:"",rules:t.rule_user_passwordEdit},model:{value:t.editedItem.password,callback:function(e){t.$set(t.editedItem,"password",e)},expression:"editedItem.password"}}),a("v-autocomplete",{attrs:{items:t.daftar_roles,label:"ROLES",multiple:"","small-chips":"",outlined:""},model:{value:t.editedItem.role_id,callback:function(e){t.$set(t.editedItem,"role_id",e)},expression:"editedItem.role_id"}})],1),a("v-card-actions",[a("v-spacer"),a("v-btn",{attrs:{color:"blue darken-1",text:""},on:{click:function(e){return e.stopPropagation(),t.close(e)}}},[t._v("BATAL")]),a("v-btn",{attrs:{color:"blue darken-1",text:"",loading:t.btnLoading,disabled:!t.form_valid||t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.save(e)}}},[t._v("SIMPAN")])],1)],1)],1)],1)],1)]},proxy:!0},{key:"item.actions",fn:function(e){var i=e.item;return[a("v-icon",{staticClass:"mr-2",attrs:{small:"",loading:t.btnLoading,disabled:t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.editItem(i)}}},[t._v(" mdi-pencil ")]),a("v-icon",{attrs:{small:"",loading:t.btnLoading,disabled:t.btnLoading},on:{click:function(e){return e.stopPropagation(),t.deleteItem(i)}}},[t._v(" mdi-delete ")])]}},{key:"item.foto",fn:function(e){var i=e.item;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",{attrs:{src:t.$api.url+"/"+i.foto}})],1)]}},{key:"expanded-item",fn:function(e){var i=e.headers,s=e.item;return[a("td",{staticClass:"text-center",attrs:{colspan:i.length}},[a("v-col",{attrs:{cols:"12"}},[a("strong",[t._v("ID:")]),t._v(t._s(s.id)+" "),a("strong",[t._v("created_at:")]),t._v(t._s(t.$date(s.created_at).format("DD/MM/YYYY HH:mm"))+" "),a("strong",[t._v("updated_at:")]),t._v(t._s(t.$date(s.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])],1)]}},{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},s=[],n=(a("4160"),a("c975"),a("a434"),a("b0c0"),a("159b"),a("5530")),r=(a("96cf"),a("1da1")),o=a("2f62"),l=a("e0b6"),d=a("e477"),c={name:"UsersSuperAdmin",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.ACCESS_TOKEN},{text:"USER SISTEM",disabled:!1,href:"/system-users"},{text:"USERS SUPER ADMIN",disabled:!0,href:"#"}],this.initialize()},data:function(){return{role_id:0,datatableLoading:!1,btnLoading:!1,headers:[{text:"",value:"foto"},{text:"USERNAME",value:"username",sortable:!0},{text:"NAME",value:"name",sortable:!0},{text:"EMAIL",value:"email",sortable:!0},{text:"NOMOR HP",value:"nomor_hp",sortable:!0},{text:"AKSI",value:"actions",sortable:!1,width:100}],expanded:[],search:"",daftar_users:[],form_valid:!0,daftar_roles:[],dialog:!1,dialogEdit:!1,editedIndex:-1,editedItem:{id:0,username:"",password:"",name:"",email:"",nomor_hp:"",role_id:["superadmin"],created_at:"",updated_at:""},defaultItem:{id:0,username:"",password:"",name:"",email:"",nomor_hp:"",role_id:["superadmin"],created_at:"",updated_at:""},rule_user_name:[function(t){return!!t||"Mohon untuk di isi nama User !!!"},function(t){return/^[A-Za-z\s]*$/.test(t)||"Nama User hanya boleh string dan spasi"}],rule_user_email:[function(t){return!!t||"Mohon untuk di isi email User !!!"},function(t){return/.+@.+\..+/.test(t)||"Format E-mail harus benar"}],rule_user_nomorhp:[function(t){return!!t||"Nomor HP mohon untuk diisi !!!"},function(t){return/^\+[1-9]{1}[0-9]{1,14}$/.test(t)||"Nomor HP hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388"}],rule_user_username:[function(t){return!!t||"Mohon untuk di isi username User !!!"},function(t){return/^[A-Za-z_]*$/.test(t)||"Username hanya boleh string dan underscore"}],rule_user_password:[function(t){return!!t||"Mohon untuk di isi password User !!!"},function(t){return!(t&&"undefined"!==typeof t&&t.length>0)||(t.length>=8||"Minimial Password 8 karaketer")}],rule_user_passwordEdit:[function(t){return!(t&&"undefined"!==typeof t&&t.length>0)||(t.length>=8||"Minimial Password 8 karaketer")}]}},methods:{initialize:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.get("/system/users",{headers:{Authorization:this.TOKEN}}).then((function(t){var a=t.data;e.daftar_users=a.users,e.role_id=a.role.id,e.datatableLoading=!1}));case 3:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),dataTableRowClicked:function(t){t===this.expanded[0]?this.expanded=[]:this.expanded=[t]},showDialogTambahUserSuperAdmin:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(){var e=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return t.next=2,this.$ajax.get("/system/setting/roles",{headers:{Authorization:this.TOKEN}}).then((function(t){var a=t.data,i=a.roles,s=[];i.forEach((function(t){"superadmin"==t.name?s.push({text:t.name,disabled:!0}):s.push({text:t.name,disabled:!1})})),e.daftar_roles=s,e.dialog=!0}));case 2:case"end":return t.stop()}}),t,this)})));function e(){return t.apply(this,arguments)}return e}(),editItem:function(){var t=Object(r["a"])(regeneratorRuntime.mark((function t(e){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.editedIndex=this.daftar_users.indexOf(e),e.password="",this.editedItem=Object.assign({},e),t.next=5,this.$ajax.get("/system/setting/roles",{headers:{Authorization:this.TOKEN}}).then((function(t){var e=t.data,i=e.roles,s=[];i.forEach((function(t){"superadmin"==t.name?s.push({text:t.name,disabled:!0}):s.push({text:t.name,disabled:!1})})),a.daftar_roles=s}));case 5:return this.btnLoading=!0,t.next=8,this.$ajax.get("/system/users/"+e.id+"/roles",{headers:{Authorization:this.TOKEN}}).then((function(t){var e=t.data;a.editedItem.role_id=e.roles,a.btnLoading=!1,a.dialogEdit=!0}));case 8:case"end":return t.stop()}}),t,this)})));function e(e){return t.apply(this,arguments)}return e}(),close:function(){var t=this;this.btnLoading=!1,this.dialog=!1,this.dialogEdit=!1,setTimeout((function(){t.$refs.frmdata.resetValidation(),t.editedItem=Object.assign({},t.defaultItem),t.editedIndex=-1}),300)},save:function(){var t=this;this.$refs.frmdata.validate()&&(this.btnLoading=!0,this.editedIndex>-1?this.$ajax.post("/system/users/"+this.editedItem.id,{_method:"PUT",name:this.editedItem.name,email:this.editedItem.email,nomor_hp:this.editedItem.nomor_hp,username:this.editedItem.username,password:this.editedItem.password,role_id:JSON.stringify(Object.assign({},this.editedItem.role_id))},{headers:{Authorization:this.TOKEN}}).then((function(e){var a=e.data;Object.assign(t.daftar_users[t.editedIndex],a.user),t.close()})).catch((function(){t.btnLoading=!1})):this.$ajax.post("/system/users/store",{name:this.editedItem.name,email:this.editedItem.email,nomor_hp:this.editedItem.nomor_hp,username:this.editedItem.username,password:this.editedItem.password,role_id:JSON.stringify(Object.assign({},this.editedItem.role_id))},{headers:{Authorization:this.TOKEN}}).then((function(e){var a=e.data;t.daftar_users.push(a.user),t.close()})).catch((function(){t.btnLoading=!1})))},deleteItem:function(t){var e=this;this.$root.$confirm.open("Delete","Apakah Anda ingin menghapus username "+t.username+" ?",{color:"red"}).then((function(a){a&&(e.btnLoading=!0,e.$ajax.post("/system/users/"+t.id,{_method:"DELETE"},{headers:{Authorization:e.TOKEN}}).then((function(){var a=e.daftar_users.indexOf(t);e.daftar_users.splice(a,1),e.btnLoading=!1})).catch((function(){e.btnLoading=!1})))}))}},computed:Object(n["a"])({formTitle:function(){return-1===this.editedIndex?"TAMBAH USER SUPER ADMIN":"EDIT USER SUPER ADMIN"}},Object(o["b"])("auth",{ACCESS_TOKEN:"AccessToken",TOKEN:"Token"})),watch:{dialog:function(t){t||this.close()},dialogEdit:function(t){t||this.close()}},components:{SystemUserLayout:l["a"],ModuleHeader:d["a"]}},u=c,m=a("2877"),v=a("6544"),p=a.n(v),h=a("0798"),f=a("c6a6"),_=a("8212"),b=a("2bc5"),g=a("8336"),S=a("b0af"),E=a("99d9"),A=a("62ad"),x=a("a523"),I=a("8fea"),k=a("169a"),T=a("ce7e"),C=a("4bd4"),R=a("132d"),w=a("adda"),y=a("0fd9"),U=a("2fa4"),N=a("8654"),O=a("71d9"),M=a("2a7f"),L=Object(m["a"])(u,i,s,!1,null,null,null);e["default"]=L.exports;p()(L,{VAlert:h["a"],VAutocomplete:f["a"],VAvatar:_["a"],VBreadcrumbs:b["a"],VBtn:g["a"],VCard:S["a"],VCardActions:E["b"],VCardText:E["d"],VCardTitle:E["e"],VCol:A["a"],VContainer:x["a"],VDataTable:I["a"],VDialog:k["a"],VDivider:T["a"],VForm:C["a"],VIcon:R["a"],VImg:w["a"],VRow:y["a"],VSpacer:U["a"],VTextField:N["a"],VToolbar:O["a"],VToolbarTitle:M["c"]})},e0b6:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("div",[a("v-system-bar",{staticClass:"green lighten-2 white--text",attrs:{app:"",dark:""}}),a("v-app-bar",{attrs:{app:""}},[a("v-app-bar-nav-icon",{staticClass:"grey--text",on:{click:function(e){e.stopPropagation(),t.drawer=!t.drawer}}}),a("v-toolbar-title",{staticClass:"headline clickable",on:{click:function(e){e.stopPropagation(),t.$router.push("/dashboard/"+t.$store.getters["auth/AccessToken"]).catch((function(t){}))}}},[a("span",{staticClass:"hidden-sm-and-down"},[t._v(t._s(t.APP_NAME))])]),a("v-spacer"),a("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),a("v-menu",{attrs:{"close-on-content-click":!0,origin:"center center",transition:"scale-transition","offset-y":!0,bottom:"",left:""},scopedSlots:t._u([{key:"activator",fn:function(e){var i=e.on;return[a("v-avatar",{attrs:{size:"30"}},[a("v-img",t._g({attrs:{src:t.photoUser}},i))],1)]}}])},[a("v-list",[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list-item",{attrs:{to:"/system-users/profil"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-title",[t._v("Profil")])],1),a("v-divider"),a("v-list-item",{on:{click:function(e){return e.preventDefault(),t.logout(e)}}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-power")])],1),a("v-list-item-title",[t._v("Logout")])],1)],1)],1)],1),a("v-navigation-drawer",{staticClass:"green darken-1",attrs:{width:"300",dark:"",temporary:t.hideleftnav,app:""},model:{value:t.drawer,callback:function(e){t.drawer=e},expression:"drawer"}},[a("v-list-item",[a("v-list-item-avatar",[a("v-img",{attrs:{src:t.photoUser},on:{click:function(e){return e.stopPropagation(),t.toProfile(e)}}})],1),a("v-list-item-content",[a("v-list-item-title",{staticClass:"title"},[t._v(" "+t._s(t.ATTRIBUTE_USER("username"))+" ")]),a("v-list-item-subtitle",[t._v(" "+t._s(t.ROLE)+" ")])],1)],1),a("v-divider"),a("v-list",{attrs:{expand:""}},[t.CAN_ACCESS("SYSTEM-USERS-GROUP")?a("v-list-item",{staticClass:"yellow",attrs:{to:{path:"/system-users"},link:"",color:"green"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v("BOARD USERS")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-SETTING-PERMISSIONS")?a("v-list-item",{attrs:{link:"",to:"/system-users/permissions"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account-key")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PERMISSIONS ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-SETTING-ROLES")?a("v-list-item",{attrs:{link:"",to:"/system-users/roles"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account-group")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" ROLES ")])],1)],1):t._e(),a("v-divider"),t.CAN_ACCESS("SYSTEM-USERS-SUPERADMIN_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/superadmin"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" SUPERADMIN ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-KEUANGAN_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/keuangan"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" KEUANGAN ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PMB_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/pmb"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" TIM PMB ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-AKADEMIK_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/akademik"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" AKADEMIK ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PROGRAM-STUDI_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/prodi"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PROGRAM STUDI ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-PUSLAHTA_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/puslahta"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" PUSLAHTA ")])],1)],1):t._e(),t.CAN_ACCESS("SYSTEM-USERS-DOSEN_BROWSE")?a("v-list-item",{attrs:{link:"",to:"/system-users/dosen"}},[a("v-list-item-icon",{staticClass:"mr-2"},[a("v-icon",[t._v("mdi-account")])],1),a("v-list-item-content",[a("v-list-item-title",[t._v(" DOSEN ")])],1)],1):t._e()],1)],1),a("v-main",{staticClass:"mx-4 mb-4"},[t._t("default")],2)],1)},s=[],n=(a("b0c0"),a("ac1f"),a("5319"),a("5530")),r=a("2f62"),o={name:"SystemUserLayout",props:{showrightsidebar:{type:Boolean,default:!0}},data:function(){return{loginTime:0,drawer:null}},methods:{logout:function(){var t=this;this.loginTime=0,this.$ajax.post("/auth/logout",{},{headers:{Authorization:this.TOKEN}}).then((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")})).catch((function(){t.$store.dispatch("auth/logout"),t.$store.dispatch("uifront/reinit"),t.$store.dispatch("uiadmin/reinit"),t.$router.push("/")}))},isBentukPT:function(t){return this.$store.getters["uifront/getBentukPT"]==t}},computed:Object(n["a"])({},Object(r["b"])("auth",{AUTHENTICATED:"Authenticated",ACCESS_TOKEN:"AccessToken",TOKEN:"Token",ROLE:"Role",CAN_ACCESS:"can",ATTRIBUTE_USER:"AttributeUser"}),{APP_NAME:function(){return"PortalEkampus v3"},photoUser:function(){var t,e=this.ATTRIBUTE_USER("foto");return t=""==e?this.$api.url+"/storage/images/users/no_photo.png":this.$api.url+"/"+e,t},hideleftnav:function(){return"UsersProfil"==this.$route.name}}),watch:{loginTime:{handler:function(t){var e=this;t>=0?setTimeout((function(){e.loginTime=1==e.AUTHENTICATED?e.loginTime+1:-1}),1e3):(this.$store.dispatch("auth/logout"),this.$router.replace("/login"))},immediate:!0}}},l=o,d=a("2877"),c=a("6544"),u=a.n(c),m=a("40dc"),v=a("5bc1"),p=a("8212"),h=a("ce7e"),f=a("132d"),_=a("adda"),b=a("8860"),g=a("da13"),S=a("8270"),E=a("5d23"),A=a("34c3"),x=a("f6c4"),I=a("e449"),k=a("f774"),T=a("2fa4"),C=a("afd9"),R=a("2a7f"),w=Object(d["a"])(l,i,s,!1,null,null,null);e["a"]=w.exports;u()(w,{VAppBar:m["a"],VAppBarNavIcon:v["a"],VAvatar:p["a"],VDivider:h["a"],VIcon:f["a"],VImg:_["a"],VList:b["a"],VListItem:g["a"],VListItemAvatar:S["a"],VListItemContent:E["g"],VListItemIcon:A["a"],VListItemSubtitle:E["j"],VListItemTitle:E["k"],VMain:x["a"],VMenu:I["a"],VNavigationDrawer:k["a"],VSpacer:T["a"],VSystemBar:C["a"],VToolbarTitle:R["c"]})},e477:function(t,e,a){"use strict";var i=function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("v-container",{attrs:{fluid:t.isReportPage}},[a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("breadcrumbs")],2)],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("h1",{staticClass:"subheading grey--text"},[a("v-icon",{attrs:{large:""}},[t._t("icon")],2),t._t("name")],2)]),a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[t._t("subtitle")],2)])],1),a("v-row",{attrs:{"no-gutters":""}},[a("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[t._t("desc")],2)],1)],1)},s=[],n={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},r=n,o=a("2877"),l=a("6544"),d=a.n(l),c=a("62ad"),u=a("a523"),m=a("132d"),v=a("0fd9"),p=Object(o["a"])(r,i,s,!1,null,null,null);e["a"]=p.exports;d()(p,{VCol:c["a"],VContainer:u["a"],VIcon:m["a"],VRow:v["a"]})}}]);