(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-74fae408"],{"6a9d":function(a,t,e){"use strict";e.r(t);var r=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("SPMBLayout",{scopedSlots:a._u(["mahasiswabaru"!=a.dashboard?{key:"filtersidebar",fn:function(){return[e("Filter7",{ref:"filter7",on:{changeTahunPendaftaran:a.changeTahunPendaftaran,changeProdi:a.changeProdi}})]},proxy:!0}:null],null,!0)},[e("ModuleHeader",{scopedSlots:a._u([{key:"icon",fn:function(){return[a._v(" mdi-file-document-edit-outline ")]},proxy:!0},{key:"name",fn:function(){return[a._v(" BIODATA ")]},proxy:!0},"mahasiswabaru"!=a.dashboard?{key:"subtitle",fn:function(){return[a._v(" TAHUN PENDAFTARAN "+a._s(a.tahun_pendaftaran)+" - "+a._s(a.nama_prodi)+" ")]},proxy:!0}:null,{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:a.breadcrumbs},scopedSlots:a._u([{key:"divider",fn:function(){return[e("v-icon",[a._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},"mahasiswabaru"==a.dashboard?{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[a._v(" Halaman ini berisi pengisian formulir pendaftaran, mohon diisi dengan lengkap dan benar. ")])]},proxy:!0}:{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[a._v(" Berisi kelengkapan biodata, silahkan melakukan filter tahun akademik dan program studi. ")])]},proxy:!0}],null,!0)}),"mahasiswabaru"==a.dashboard?e("v-container",{attrs:{fluid:""}},[e("FormMhsBaru")],1):e("v-container",{attrs:{fluid:""}},[e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-card",[e("v-card-text",[e("v-text-field",{attrs:{"append-icon":"mdi-database-search",label:"Search","single-line":"","hide-details":""},model:{value:a.search,callback:function(t){a.search=t},expression:"search"}})],1)],1)],1)],1),e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:a.headers,items:a.datatable,search:a.search,"item-key":"id","sort-by":"name","show-expand":"",expanded:a.expanded,"single-expand":!0,loading:a.datatableLoading,"loading-text":"Loading... Please wait"},on:{"update:expanded":function(t){a.expanded=t},"click:row":a.dataTableRowClicked},scopedSlots:a._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[a._v("DAFTAR MAHASISWA BARU")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer"),e("v-dialog",{attrs:{fullscreen:!0},model:{value:a.dialogprofilmhsbaru,callback:function(t){a.dialogprofilmhsbaru=t},expression:"dialogprofilmhsbaru"}},[e("ProfilMahasiswaBaru",{attrs:{item:a.datamhsbaru},on:{closeProfilMahasiswaBaru:a.closeProfilMahasiswaBaru}})],1)],1)]},proxy:!0},{key:"item.foto",fn:function(t){var r=t.item;return[e("v-badge",{attrs:{bordered:"",color:a.badgeColor(r),icon:a.badgeIcon(r),overlap:""}},[e("v-avatar",{attrs:{size:"30"}},[e("v-img",{attrs:{src:a.$api.url+"/"+r.foto}})],1)],1)]}},{key:"item.actions",fn:function(t){var r=t.item;return[e("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return t.stopPropagation(),a.viewItem(r)}}},[a._v(" mdi-eye ")]),e("v-icon",{staticClass:"mr-2",attrs:{small:""},on:{click:function(t){return t.stopPropagation(),a.editItem(r)}}},[a._v(" mdi-pencil ")])]}},{key:"expanded-item",fn:function(t){var r=t.headers,i=t.item;return[e("td",{staticClass:"text-center",attrs:{colspan:r.length}},[e("v-col",{attrs:{cols:"12"}},[e("strong",[a._v("ID:")]),a._v(a._s(i.id)+" "),e("strong",[a._v("created_at:")]),a._v(a._s(a.$date(i.created_at).format("DD/MM/YYYY HH:mm"))+" "),e("strong",[a._v("updated_at:")]),a._v(a._s(a.$date(i.updated_at).format("DD/MM/YYYY HH:mm"))+" ")])],1)]}},{key:"no-data",fn:function(){return[a._v(" Data belum tersedia ")]},proxy:!0}])})],1)],1)],1)],1)},i=[],n=e("1da1"),s=(e("96cf"),e("684f")),o=e("e477"),d=e("e86b"),l=e("b229"),u=e("0639"),m={name:"FormulirPendaftaran",created:function(){this.dashboard=this.$store.getters["uiadmin/getDefaultDashboard"],this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"SPMB",disabled:!1,href:"/spmb"},{text:"BIODATA",disabled:!0,href:"#"}],this.breadcrumbs[1].disabled="mahasiswabaru"==this.dashboard||"mahasiswa"==this.dashboard;var a=this.$store.getters["uiadmin/getProdiID"];this.prodi_id=a,this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](a),this.tahun_pendaftaran=this.$store.getters["uiadmin/getTahunPendaftaran"],this.initialize()},data:function(){return{firstloading:!0,prodi_id:null,tahun_pendaftaran:null,nama_prodi:null,dialogprofilmhsbaru:!1,breadcrumbs:[],dashboard:null,btnLoading:!1,datatableLoading:!1,expanded:[],datatable:[],headers:[{text:"",value:"foto",width:70},{text:"NO. FORMULIR",value:"no_formulir",width:140,sortable:!0},{text:"USERNAME",value:"username",width:150,sortable:!0},{text:"NAMA MAHASISWA",value:"name",width:350,sortable:!0},{text:"JK",value:"jk",width:70},{text:"NOMOR HP",value:"nomor_hp",width:100},{text:"KELAS",value:"nkelas",width:150,sortable:!0},{text:"AKSI",value:"actions",sortable:!1,width:100}],search:"",datamhsbaru:{}}},methods:{changeTahunPendaftaran:function(a){this.tahun_pendaftaran=a},changeProdi:function(a){this.prodi_id=a},initialize:function(){var a=Object(n["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:a.t0=this.dashboard,a.next="mahasiswabaru"===a.t0?3:4;break;case 3:return a.abrupt("break",9);case 4:return this.datatableLoading=!0,a.next=7,this.$ajax.post("/spmb/formulirpendaftaran",{TA:this.tahun_pendaftaran,prodi_id:this.prodi_id},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.datatable=e.pmb,t.datatableLoading=!1}));case 7:this.firstloading=!1,this.$refs.filter7.setFirstTimeLoading(this.firstloading);case 9:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),dataTableRowClicked:function(a){a===this.expanded[0]?this.expanded=[]:this.expanded=[a]},badgeColor:function(a){return 1==a.active?"success":"error"},badgeIcon:function(a){return 1==a.active?"mdi-check-bold":"mdi-close-thick"},viewItem:function(a){this.datamhsbaru=a,this.dialogprofilmhsbaru=!0},editItem:function(a){this.$router.push("/spmb/formulirpendaftaran/"+a.id+"/edit")},closeProfilMahasiswaBaru:function(){this.dialogprofilmhsbaru=!1}},watch:{tahun_pendaftaran:function(){this.firstloading||this.initialize()},prodi_id:function(a){this.firstloading||(this.nama_prodi=this.$store.getters["uiadmin/getProdiName"](a),this.initialize())}},components:{SPMBLayout:s["a"],ModuleHeader:o["a"],FormMhsBaru:d["a"],ProfilMahasiswaBaru:l["a"],Filter7:u["a"]}},c=m,f=e("2877"),h=e("6544"),_=e.n(h),b=e("0798"),p=e("8212"),v=e("4ca6"),k=e("2bc5"),g=e("b0af"),x=e("99d9"),A=e("62ad"),w=e("a523"),L=e("8fea"),$=e("169a"),y=e("ce7e"),T=e("132d"),P=e("adda"),M=e("0fd9"),V=e("2fa4"),I=e("8654"),N=e("71d9"),j=e("2a7f"),R=Object(f["a"])(c,r,i,!1,null,null,null);t["default"]=R.exports;_()(R,{VAlert:b["a"],VAvatar:p["a"],VBadge:v["a"],VBreadcrumbs:k["a"],VCard:g["a"],VCardText:x["d"],VCol:A["a"],VContainer:w["a"],VDataTable:L["a"],VDialog:$["a"],VDivider:y["a"],VIcon:T["a"],VImg:P["a"],VRow:M["a"],VSpacer:V["a"],VTextField:I["a"],VToolbar:N["a"],VToolbarTitle:j["c"]})},e477:function(a,t,e){"use strict";var r=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("v-container",{attrs:{fluid:a.isReportPage}},[e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a._t("breadcrumbs")],2)],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("h1",{staticClass:"subheading grey--text"},[e("v-icon",{attrs:{large:""}},[a._t("icon")],2),a._t("name")],2)]),e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[e("span",{staticClass:"ml-10 subtitle-1 green--text font-weight-bold"},[a._t("subtitle")],2)])],1),e("v-row",{attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12",xs:"12",sm:"12",md:"12"}},[a._t("desc")],2)],1)],1)},i=[],n={name:"ModuleHeader",computed:{isReportPage:function(){return!0}}},s=n,o=e("2877"),d=e("6544"),l=e.n(d),u=e("62ad"),m=e("a523"),c=e("132d"),f=e("0fd9"),h=Object(o["a"])(s,r,i,!1,null,null,null);t["a"]=h.exports;l()(h,{VCol:u["a"],VContainer:m["a"],VIcon:c["a"],VRow:f["a"]})},e86b:function(a,t,e){"use strict";var r=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("v-row",{staticClass:"mb-4",attrs:{"no-gutters":""}},[e("v-col",{attrs:{cols:"12"}},[e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:a.form_valid,callback:function(t){a.form_valid=t},expression:"form_valid"}},[e("v-card",{staticClass:"mb-4"},[e("v-card-title",[a._v(" IDENTITAS DIRI ")]),e("v-card-text",[e("v-text-field",{attrs:{label:"NAMA LENGKAP",rules:a.rule_nama_mhs,filled:""},model:{value:a.formdata.nama_mhs,callback:function(t){a.$set(a.formdata,"nama_mhs",t)},expression:"formdata.nama_mhs"}}),e("v-text-field",{attrs:{label:"TEMPAT LAHIR",rules:a.rule_tempat_lahir,filled:""},model:{value:a.formdata.tempat_lahir,callback:function(t){a.$set(a.formdata,"tempat_lahir",t)},expression:"formdata.tempat_lahir"}}),e("v-menu",{ref:"menuTanggalLahir",attrs:{"close-on-content-click":!1,"return-value":a.formdata.tanggal_lahir,transition:"scale-transition","offset-y":"","max-width":"290px","min-width":"290px"},on:{"update:returnValue":function(t){return a.$set(a.formdata,"tanggal_lahir",t)},"update:return-value":function(t){return a.$set(a.formdata,"tanggal_lahir",t)}},scopedSlots:a._u([{key:"activator",fn:function(t){var r=t.on;return[e("v-text-field",a._g({attrs:{label:"TANGGAL LAHIR",readonly:"",filled:"",rules:a.rule_tanggal_lahir},model:{value:a.formdata.tanggal_lahir,callback:function(t){a.$set(a.formdata,"tanggal_lahir",t)},expression:"formdata.tanggal_lahir"}},r))]}}]),model:{value:a.menuTanggalLahir,callback:function(t){a.menuTanggalLahir=t},expression:"menuTanggalLahir"}},[e("v-date-picker",{attrs:{"no-title":"",scrollable:""},model:{value:a.formdata.tanggal_lahir,callback:function(t){a.$set(a.formdata,"tanggal_lahir",t)},expression:"formdata.tanggal_lahir"}},[e("v-spacer"),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){a.menuTanggalLahir=!1}}},[a._v("Cancel")]),e("v-btn",{attrs:{text:"",color:"primary"},on:{click:function(t){return a.$refs.menuTanggalLahir.save(a.formdata.tanggal_lahir)}}},[a._v("OK")])],1)],1),e("v-radio-group",{attrs:{row:""},model:{value:a.formdata.jk,callback:function(t){a.$set(a.formdata,"jk",t)},expression:"formdata.jk"}},[a._v(" JENIS KELAMIN : "),e("v-radio",{attrs:{label:"LAKI-LAKI",value:"L"}}),e("v-radio",{attrs:{label:"PEREMPUAN",value:"P"}})],1),e("v-text-field",{attrs:{label:"NOMOR HP",filled:"",rules:a.rule_nomorhp},model:{value:a.formdata.nomor_hp,callback:function(t){a.$set(a.formdata,"nomor_hp",t)},expression:"formdata.nomor_hp"}}),e("v-text-field",{attrs:{label:"EMAIL",rules:a.rule_email,filled:""},model:{value:a.formdata.email,callback:function(t){a.$set(a.formdata,"email",t)},expression:"formdata.email"}}),e("v-text-field",{attrs:{label:"NAMA IBU KANDUNG",rules:a.rule_nama_ibu_kandung,filled:""},model:{value:a.formdata.nama_ibu_kandung,callback:function(t){a.$set(a.formdata,"nama_ibu_kandung",t)},expression:"formdata.nama_ibu_kandung"}})],1)],1),e("v-card",{staticClass:"mb-4"},[e("v-card-title",[a._v(" ALAMAT ")]),e("v-card-text",[e("v-select",{attrs:{label:"PROVINSI",items:a.daftar_provinsi,"item-text":"nama","item-value":"id","return-object":"",loading:a.btnLoadingProv,filled:""},model:{value:a.provinsi_id,callback:function(t){a.provinsi_id=t},expression:"provinsi_id"}}),e("v-select",{attrs:{label:"KABUPATEN/KOTA",items:a.daftar_kabupaten,"item-text":"nama","item-value":"id","return-object":"",loading:a.btnLoadingKab,filled:""},model:{value:a.kabupaten_id,callback:function(t){a.kabupaten_id=t},expression:"kabupaten_id"}}),e("v-select",{attrs:{label:"KECAMATAN",items:a.daftar_kecamatan,"item-text":"nama","item-value":"id","return-object":"",filled:""},model:{value:a.kecamatan_id,callback:function(t){a.kecamatan_id=t},expression:"kecamatan_id"}}),e("v-select",{attrs:{label:"DESA/KELURAHAN",items:a.daftar_desa,"item-text":"nama","item-value":"id","return-object":"",rules:a.rule_desa,filled:""},model:{value:a.desa_id,callback:function(t){a.desa_id=t},expression:"desa_id"}}),e("v-text-field",{attrs:{label:"ALAMAT RUMAH",rules:a.rule_alamat_rumah,filled:""},model:{value:a.formdata.alamat_rumah,callback:function(t){a.$set(a.formdata,"alamat_rumah",t)},expression:"formdata.alamat_rumah"}})],1)],1),e("v-card",{staticClass:"mb-4"},[e("v-card-title",[a._v(" RENCANA STUDI ")]),e("v-card-text",["universitas"==a.$store.getters["uifront/getBentukPT"]?e("v-select",{attrs:{label:"FAKULTAS",filled:"",rules:a.rule_fakultas,items:a.daftar_fakultas,"item-text":"nama_fakultas","item-value":"kode_fakultas",loading:a.btnLoadingFakultas},model:{value:a.kode_fakultas,callback:function(t){a.kode_fakultas=t},expression:"kode_fakultas"}}):a._e(),e("v-select",{attrs:{label:"PROGRAM STUDI",items:a.daftar_prodi,"item-text":"nama_prodi2","item-value":"id",rules:a.rule_prodi,filled:""},model:{value:a.formdata.kjur1,callback:function(t){a.$set(a.formdata,"kjur1",t)},expression:"formdata.kjur1"}}),e("v-select",{attrs:{label:"KELAS",items:a.daftar_kelas,"item-text":"nkelas","item-value":"idkelas",rules:a.rule_kelas,filled:""},model:{value:a.formdata.idkelas,callback:function(t){a.$set(a.formdata,"idkelas",t)},expression:"formdata.idkelas"}})],1)],1),e("v-card",{staticClass:"mb-4"},[e("v-card-actions",[a._v(" Kode Billing: "),e("strong",[a._v(a._s(a.kode_billing))]),e("v-spacer"),e("v-btn",{attrs:{color:"blue darken-1",text:"",disabled:!a.form_valid||a.btnLoading},on:{click:function(t){return t.stopPropagation(),a.save(t)}}},[a._v("SIMPAN")])],1)],1)],1)],1)],1)},i=[],n=e("1da1"),s=(e("96cf"),{name:"FormMahasiswaBaru",created:function(){this.initialize()},data:function(){return{btnLoading:!1,btnLoadingProv:!1,btnLoadingKab:!1,btnLoadingKec:!1,btnLoadingFakultas:!1,kode_billing:"N.A",form_valid:!0,menuTanggalLahir:!1,daftar_provinsi:[],provinsi_id:0,daftar_kabupaten:[],kabupaten_id:0,daftar_kecamatan:[],kecamatan_id:0,daftar_desa:[],desa_id:0,daftar_fakultas:[],kode_fakultas:"",daftar_prodi:[],daftar_kelas:[],formdata:{nama_mhs:"",tempat_lahir:"",tanggal_lahir:"",jk:"L",nomor_hp:"",email:"",alamat_rumah:"",nama_ibu_kandung:"",kjur1:"",idkelas:""},rule_nama_mhs:[function(a){return!!a||"Nama Mahasiswa mohon untuk diisi !!!"},function(a){return/^[A-Za-z\s\\,\\.]*$/.test(a)||"Nama Mahasiswa hanya boleh string dan spasi"}],rule_nidn:[function(a){return!!a||"Mohon untuk di isi NIDN !!!"},function(a){return/^[0-9]+$/.test(a)||"NIDN hanya boleh angka"}],rule_nipy:[function(a){return!!a||"Mohon untuk di isi NIP Yayasan !!!"},function(a){return/^[0-9]+$/.test(a)||"NIP Yayasan hanya boleh angka"}],rule_tempat_lahir:[function(a){return!!a||"Tempat Lahir mohon untuk diisi !!!"}],rule_tanggal_lahir:[function(a){return!!a||"Tanggal Lahir mohon untuk diisi !!!"}],rule_nomorhp:[function(a){return!!a||"Nomor HP mohon untuk diisi !!!"},function(a){return/^\+[1-9]{1}[0-9]{1,14}$/.test(a)||"Nomor HP hanya boleh angka dan gunakan kode negara didepan seperti +6281214553388"}],rule_email:[function(a){return!!a||"Email mohon untuk diisi !!!"},function(a){return/.+@.+\..+/.test(a)||"Format E-mail mohon di isi dengan benar"}],rule_nama_ibu_kandung:[function(a){return!!a||"Nama Ibu Kandung mohon untuk diisi !!!"},function(a){return/^[A-Za-z\s\\,\\.]*$/.test(a)||"Nama Ibu Kandung hanya boleh string dan spasi"}],rule_desa:[function(a){return!!a||"Mohon Desa mohon untuk diisi !!!"}],rule_alamat_rumah:[function(a){return!!a||"Alamat Rumah mohon untuk diisi !!!"}],rule_fakultas:[function(a){return!!a||"Fakultas mohon untuk dipilih !!!"}],rule_prodi:[function(a){return!!a||"Program studi mohon untuk dipilih !!!"}],rule_kelas:[function(a){return!!a||"Kelas mohon untuk dipilih !!!"}]}},methods:{initialize:function(){var a=Object(n["a"])(regeneratorRuntime.mark((function a(){var t,e=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(t=this.$store.getters["uifront/getBentukPT"],this.$ajax.get("/datamaster/provinsi").then((function(a){var t=a.data;e.daftar_provinsi=t.provinsi})),"universitas"!=t){a.next=7;break}return a.next=5,this.$ajax.get("/datamaster/fakultas").then((function(a){var t=a.data;e.daftar_fakultas=t.fakultas}));case 5:a.next=9;break;case 7:return a.next=9,this.$ajax.get("/datamaster/programstudi").then((function(a){var t=a.data;e.daftar_prodi=t.prodi}));case 9:return this.$ajax.get("/datamaster/kelas").then((function(a){var t=a.data;e.daftar_kelas=t.kelas})),a.next=12,this.$ajax.get("/spmb/formulirpendaftaran/"+this.$store.getters["auth/AttributeUser"]("id"),{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var r=a.data;e.formdata.nama_mhs=r.formulir.nama_mhs,e.formdata.tempat_lahir=r.formulir.tempat_lahir,e.formdata.tanggal_lahir=r.formulir.tanggal_lahir,e.formdata.jk=r.formulir.jk,e.formdata.nomor_hp="+"+r.formulir.nomor_hp,e.formdata.email=r.formulir.email,e.formdata.nama_ibu_kandung=r.formulir.nama_ibu_kandung,e.provinsi_id={id:""+r.formulir.address1_provinsi_id,nama:""+r.formulir.address1_provinsi},e.kabupaten_id={id:""+r.formulir.address1_kabupaten_id,nama:""+r.formulir.address1_kabupaten},e.kecamatan_id={id:""+r.formulir.address1_kecamatan_id,nama:""+r.formulir.address1_kecamatan},e.desa_id={id:""+r.formulir.address1_desa_id,nama:""+r.formulir.address1_kelurahan},e.formdata.alamat_rumah=r.formulir.alamat_rumah,"universitas"==t&&null!=r.formulir.kode_fakultas&&(e.kode_fakultas=r.formulir.kode_fakultas),e.formdata.kjur1=r.formulir.kjur1,e.formdata.idkelas=r.formulir.idkelas,e.kode_billing=r.no_transaksi,e.$refs.frmdata.resetValidation()}));case 12:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),save:function(){var a=Object(n["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(!this.$refs.frmdata.validate()){a.next=6;break}return this.btnLoading=!0,a.next=4,this.$ajax.post("/spmb/formulirpendaftaran/"+this.$store.getters["auth/AttributeUser"]("id"),{_method:"put",nama_mhs:this.formdata.nama_mhs,tempat_lahir:this.formdata.tempat_lahir,tanggal_lahir:this.formdata.tanggal_lahir,jk:this.formdata.jk,nomor_hp:this.formdata.nomor_hp,email:this.formdata.email,nama_ibu_kandung:this.formdata.nama_ibu_kandung,address1_provinsi_id:this.provinsi_id.id,address1_provinsi:this.provinsi_id.nama,address1_kabupaten_id:this.kabupaten_id.id,address1_kabupaten:this.kabupaten_id.nama,address1_kecamatan_id:this.kecamatan_id.id,address1_kecamatan:this.kecamatan_id.nama,address1_desa_id:this.desa_id.id,address1_kelurahan:this.desa_id.nama,alamat_rumah:this.formdata.alamat_rumah,kjur1:this.formdata.kjur1,idkelas:this.formdata.idkelas},{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.kode_billing=e.no_transaksi,t.btnLoading=!1})).catch((function(){t.btnLoading=!1}));case 4:this.form_valid=!0,this.$refs.frmdata.resetValidation();case 6:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}()},watch:{provinsi_id:function(a){var t=this;null!=a.id&&""!=a.id&&(this.btnLoadingProv=!0,this.$ajax.get("/datamaster/provinsi/"+a.id+"/kabupaten").then((function(a){var e=a.data;t.daftar_kabupaten=e.kabupaten,t.btnLoadingProv=!1})),this.daftar_kecamatan=[])},kabupaten_id:function(a){var t=this;null!=a.id&&""!=a.id&&(this.btnLoadingKab=!0,this.$ajax.get("/datamaster/kabupaten/"+a.id+"/kecamatan").then((function(a){var e=a.data;t.daftar_kecamatan=e.kecamatan,t.btnLoadingKab=!1})))},kecamatan_id:function(a){var t=this;null!=a.id&&""!=a.id&&(this.btnLoadingKec=!0,this.$ajax.get("/datamaster/kecamatan/"+a.id+"/desa").then((function(a){var e=a.data;t.daftar_desa=e.desa,t.btnLoadingKec=!1})))},kode_fakultas:function(a){var t=this;this.btnLoadingFakultas=!0,this.$ajax.get("/datamaster/fakultas/"+a+"/programstudi").then((function(a){var e=a.data;t.daftar_prodi=e.programstudi,t.btnLoadingFakultas=!1}))}}}),o=s,d=e("2877"),l=e("6544"),u=e.n(l),m=e("8336"),c=e("b0af"),f=e("99d9"),h=e("62ad"),_=e("2e4b"),b=e("4bd4"),p=e("e449"),v=e("67b6"),k=e("43a6"),g=e("0fd9"),x=e("b974"),A=e("2fa4"),w=e("8654"),L=Object(d["a"])(o,r,i,!1,null,null,null);t["a"]=L.exports;u()(L,{VBtn:m["a"],VCard:c["a"],VCardActions:f["b"],VCardText:f["d"],VCardTitle:f["e"],VCol:h["a"],VDatePicker:_["a"],VForm:b["a"],VMenu:p["a"],VRadio:v["a"],VRadioGroup:k["a"],VRow:g["a"],VSelect:x["a"],VSpacer:A["a"],VTextField:w["a"]})}}]);