(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-2d0a476f"],{"070b":function(a,e,t){"use strict";t.r(e);var n=function(){var a=this,e=a.$createElement,t=a._self._c||e;return t("AkademikLayout",{attrs:{showrightsidebar:!1}},[t("ModuleHeader",{scopedSlots:a._u([{key:"icon",fn:function(){return[a._v(" mdi-monitor-dashboard ")]},proxy:!0},{key:"name",fn:function(){return[a._v(" ISI NILAI PER KELAS ")]},proxy:!0},{key:"subtitle",fn:function(){return[a._v(" TAHUN AKADEMIK "+a._s(a.tahun_akademik)+" SEMESTER "+a._s(a.$store.getters["uiadmin/getNamaSemester"](a.semester_akademik))+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[t("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:a.breadcrumbs},scopedSlots:a._u([{key:"divider",fn:function(){return[t("v-icon",[a._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[t("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[a._v(" Halaman untuk melakukan pengisian nilai berdasarkan kelas mahasiswa yang telah dibentuk pada pembagian kelas. ")])]},proxy:!0}])}),a.data_kelas_mhs?t("v-container",{attrs:{fluid:""}},[t("v-row",[t("v-col",{attrs:{cols:"12"}},[t("DataKelasMHS",{attrs:{datakelas:a.data_kelas_mhs}})],1)],1),t("v-row",[t("v-col",{attrs:{cols:"12"}},[t("v-alert",{attrs:{type:"info"}},[a._v(" Catatan: Pilihlah mahasiswa yang di isi nilainya. Untuk meningkatkan performance bila jumlah peserta lebih dari 10; maka disarankan mengisi nilai per 10 mahasiswa. ")])],1),t("v-col",{attrs:{cols:"12"}},[t("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:a.form_valid,callback:function(e){a.form_valid=e},expression:"form_valid"}},[t("v-data-table",{staticClass:"elevation-1",attrs:{headers:a.headers_peserta,items:a.datatable_peserta,"item-key":"id","show-select":"","disable-pagination":!0,"hide-default-footer":!0,loading:a.datatableLoading,"loading-text":"Loading... Please wait",dense:""},scopedSlots:a._u([{key:"top",fn:function(){return[t("v-toolbar",{attrs:{flat:"",color:"white"}},[t("v-toolbar-title",[a._v("DAFTAR PESERTA")]),t("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),t("v-spacer")],1)]},proxy:!0},{key:"item.idkelas",fn:function(e){var t=e.item;return[a._v(" "+a._s(a.$store.getters["uiadmin/getNamaKelas"](t.idkelas))+" ")]}},{key:"item.kjur",fn:function(e){var t=e.item;return[a._v(" "+a._s(a.$store.getters["uiadmin/getProdiName"](t.kjur))+" ")]}},{key:"item.n_kuan",fn:function(e){return[t("v-numeric",{staticStyle:{width:"65px"},attrs:{text:"",min:0,max:100,locale:"en-US",useGrouping:!1,precision:"2",dense:"",useCalculator:!1,calcIcon:null},model:{value:e.item.n_kuan,callback:function(t){a.$set(e.item,"n_kuan",t)},expression:"props.item.n_kuan"}}),null!=e.item.n_kuan?t("v-chip",{staticClass:"ma-2",attrs:{color:"primary",outlined:"",label:""}},[a._v(a._s(e.item.n_kuan))]):a._e()]}},{key:"item.n_kual",fn:function(e){return[t("v-select",{staticStyle:{width:"65px"},attrs:{items:a.skala_nilai,dense:""},model:{value:e.item.n_kual,callback:function(t){a.$set(e.item,"n_kual",t)},expression:"props.item.n_kual"}})]}},a.datatable_peserta.length>0?{key:"body.append",fn:function(){return[t("tr",[t("td",{staticClass:"text-right",attrs:{colspan:"8"}},[t("v-btn",{staticClass:"primary mt-2 mb-2",attrs:{loading:a.btnLoading,disabled:a.btnLoading},on:{click:function(e){return e.stopPropagation(),a.save(e)}}},[a._v(" SIMPAN ")])],1)])]},proxy:!0}:null,{key:"no-data",fn:function(){return[a._v(" Data belum tersedia ")]},proxy:!0}],null,!0),model:{value:a.daftar_nilai,callback:function(e){a.daftar_nilai=e},expression:"daftar_nilai"}})],1)],1)],1)],1):a._e()],1)},i=[],r=t("1da1"),s=(t("96cf"),t("e60c")),l=t("e477"),o=t("d087"),d={name:"NilaiIsiPerKelasMHSDetail",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"ISI NILAI",disabled:!1,href:"#"},{text:"PER KELAS MAHASISWA",disabled:!0,href:"#"}],this.kelas_mhs_id=this.$route.params.kelas_mhs_id,this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"],this.semester_akademik=this.$store.getters["uiadmin/getSemesterAkademik"],this.initialize()},data:function(){return{kelas_mhs_id:null,data_kelas_mhs:null,tahun_akademik:null,semester_akademik:null,btnLoadingTable:!1,datatableLoading:!1,btnLoading:!1,datatable:[],datatable_peserta:[],headers_peserta:[{text:"NIM",value:"nim",sortable:!1,width:100},{text:"NAMA",value:"nama_mhs",sortable:!1},{text:"PROGRAM STUDI",value:"kjur",sortable:!1},{text:"KELAS",value:"idkelas",sortable:!1},{text:"TAHUN MASUK",value:"tahun",sortable:!1},{text:"NILAI ANGKA (0 s.d 100)",value:"n_kuan",sortable:!1},{text:"NILAI HURUP",value:"n_kual",sortable:!1}],form_valid:!0,daftar_nilai:[],skala_nilai:["A","A-","A/B","B+","B-","B/C","C+","C-","C/D","D+","D","E"]}},methods:{initialize:function(){var a=Object(r["a"])(regeneratorRuntime.mark((function a(){var e=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return a.next=2,this.$ajax.get("/akademik/perkuliahan/pembagiankelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var t=a.data;e.data_kelas_mhs=t.pembagiankelas}));case 2:return this.datatableLoading=!0,a.next=5,this.$ajax.get("/akademik/nilai/matakuliah/pesertakelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var t=a.data;e.datatableLoading=!1,e.datatable_peserta=t.peserta}));case 5:case"end":return a.stop()}}),a,this)})));function e(){return a.apply(this,arguments)}return e}(),fetchPeserta:function(){var a=this;return Object(r["a"])(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:return a.datatableLoading=!0,e.next=3,a.$ajax.get("/akademik/perkuliahan/pembagiankelas/peserta/"+a.kelas_mhs_id,{headers:{Authorization:a.$store.getters["auth/Token"]}}).then((function(e){var t=e.data;a.datatable_peserta=t.peserta,a.datatableLoading=!1}));case 3:case"end":return e.stop()}}),e)})))()},save:function(){}},watch:{},components:{AkademikLayout:s["a"],ModuleHeader:l["a"],DataKelasMHS:o["a"]}},u=d,c=t("2877"),m=t("6544"),k=t.n(m),h=t("0798"),_=t("2bc5"),f=t("8336"),p=t("cc20"),b=t("62ad"),v=t("a523"),g=t("8fea"),x=t("ce7e"),y=t("4bd4"),A=t("132d"),w=t("0fd9"),S=t("b974"),I=t("2fa4"),L=t("71d9"),T=t("2a7f"),$=Object(c["a"])(u,n,i,!1,null,null,null);e["default"]=$.exports;k()($,{VAlert:h["a"],VBreadcrumbs:_["a"],VBtn:f["a"],VChip:p["a"],VCol:b["a"],VContainer:v["a"],VDataTable:g["a"],VDivider:x["a"],VForm:y["a"],VIcon:A["a"],VRow:w["a"],VSelect:S["a"],VSpacer:I["a"],VToolbar:L["a"],VToolbarTitle:T["c"]})}}]);