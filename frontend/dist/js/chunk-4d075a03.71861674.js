(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-4d075a03"],{3346:function(t,a,e){},6330:function(t,a,e){"use strict";var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-text-field",t._g(t._b({staticClass:"right-input",on:{blur:t.onBlur,focus:t.onFocus,keydown:t.keyProcess},model:{value:t.dataValue,callback:function(a){t.dataValue=t._n(a)},expression:"dataValue"}},"v-text-field",t.$attrs,!1),t.$listeners))},n=[],s=(e("caad"),e("b65f"),e("b680"),e("d3b7"),e("ac1f"),e("25f0"),e("1276"),e("a9e3"),{data:function(){return{dataValue:this.value}},props:{value:[String,Number]},watch:{value:{immediate:!0,handler:function(t){this.dataValue=t}}}}),r={name:"VAngkaNilai",mixins:[s],data:function(){return{fractDigitsEdited:!1,fractPart:null,isFocused:!1}},mounted:function(){var t=(this.dataValue+"").split(".");t.length>0&&(this.fractPart=t[1],this.fractDigitsEdited=!0),this.fractPart=t.length>0?t[1]:null},methods:{clearValue:function(){this.dataValue=0,this.fractPart=null,this.fractDigitsEdited=!1},setFocus:function(t){this.isFocused=t},onBlur:function(){this.setFocus(!1)},onFocus:function(){this.setFocus(!0)},keyProcess:function(t){if(this.isFocused&&("ArrowLeft"!==t.key&&"ArrowRight"!==t.key&&t.preventDefault(),t.stopPropagation(),"Enter"!==t.key))if("Delete"!==t.key){var a=["0","1","2","3","4","5","6","7","8","9"],e=Math.trunc(this.dataValue).toString();a.includes(t.key)?this.fractDigitsEdited?null==this.fractPart?this.fractPart=t.key:this.fractPart.length<=1&&(this.fractPart+=t.key.toString()):e+=t.key:"Backspace"===t.key?this.fractDigitsEdited?null===this.fractPart?this.fractDigitsEdited=!1:this.fractPart=this.fractPart.length<1?null:this.fractPart.substring(0,this.fractPart.length-1):e=e.length<=1?"0":e.substring(0,e.length-1):["."].includes(t.key)&&(this.fractDigitsEdited=!this.fractDigitsEdited);var i=null==this.fractPart?parseFloat(e).toFixed(2):parseFloat(e+"."+this.fractPart).toFixed(2);i>=0&&i<=100&&(this.dataValue=i,this.$emit("input",this.dataValue))}else this.clearValue()}}},l=r,u=(e("7abe"),e("2877")),o=e("6544"),d=e.n(o),c=e("8654"),_=Object(u["a"])(l,i,n,!1,null,"10f57d86",null);a["a"]=_.exports;d()(_,{VTextField:c["a"]})},"7abe":function(t,a,e){"use strict";var i=e("3346"),n=e.n(i);n.a},b65f:function(t,a,e){var i=e("23e7"),n=Math.ceil,s=Math.floor;i({target:"Math",stat:!0},{trunc:function(t){return(t>0?s:n)(t)}})},b794:function(t,a,e){"use strict";e.r(a);var i=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("AkademikLayout",{attrs:{showrightsidebar:!1,temporaryleftsidebar:!0}},[e("ModuleHeader",{scopedSlots:t._u([{key:"icon",fn:function(){return[t._v(" mdi-monitor-dashboard ")]},proxy:!0},{key:"name",fn:function(){return[t._v(" ISI NILAI PER KELAS ")]},proxy:!0},{key:"subtitle",fn:function(){return[t._v(" TAHUN AKADEMIK "+t._s(t.tahun_akademik)+" SEMESTER "+t._s(t.$store.getters["uiadmin/getNamaSemester"](t.semester_akademik))+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:t.breadcrumbs},scopedSlots:t._u([{key:"divider",fn:function(){return[e("v-icon",[t._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[t._v(" Halaman untuk melakukan pengisian nilai berdasarkan kelas mahasiswa yang telah dibentuk pada pembagian kelas. ")])]},proxy:!0}])}),t.data_kelas_mhs?e("v-container",{attrs:{fluid:""}},[e("v-row",[e("v-col",{attrs:{cols:"12"}},[e("DataKelasMHS",{attrs:{datakelas:t.data_kelas_mhs}})],1)],1),e("v-row",[e("v-col",{attrs:{cols:"12"}},[e("v-alert",{attrs:{type:"info"}},[t._v(" Catatan: Pilihlah mahasiswa yang akan diisi nilainya. Untuk meningkatkan performance bila jumlah peserta lebih dari 10; maka disarankan mengisi nilai per 10 mahasiswa. ")])],1),e("v-col",{attrs:{cols:"12"}},[e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:t.form_valid,callback:function(a){t.form_valid=a},expression:"form_valid"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:t.headers_peserta,items:t.datatable_peserta,"item-key":"krsmatkul_id","show-select":"","disable-pagination":!0,"hide-default-footer":!0,loading:t.datatableLoading,"loading-text":"Loading... Please wait",dense:""},scopedSlots:t._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[t._v("DAFTAR PESERTA")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer")],1)]},proxy:!0},{key:"item.idkelas",fn:function(a){var e=a.item;return[t._v(" "+t._s(t.$store.getters["uiadmin/getNamaKelas"](e.idkelas))+" ")]}},{key:"item.kjur",fn:function(a){var e=a.item;return[t._v(" "+t._s(t.$store.getters["uiadmin/getProdiName"](e.kjur))+" ")]}},{key:"item.nilai_absen",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_absen,callback:function(e){t.$set(a.item,"nilai_absen",e)},expression:"props.item.nilai_absen"}})]}},{key:"item.nilai_quiz",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_quiz,callback:function(e){t.$set(a.item,"nilai_quiz",e)},expression:"props.item.nilai_quiz"}})]}},{key:"item.nilai_tugas_individu",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_tugas_individu,callback:function(e){t.$set(a.item,"nilai_tugas_individu",e)},expression:"props.item.nilai_tugas_individu"}})]}},{key:"item.nilai_tugas_kelompok",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_tugas_kelompok,callback:function(e){t.$set(a.item,"nilai_tugas_kelompok",e)},expression:"props.item.nilai_tugas_kelompok"}})]}},{key:"item.nilai_uts",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_uts,callback:function(e){t.$set(a.item,"nilai_uts",e)},expression:"props.item.nilai_uts"}})]}},{key:"item.nilai_uas",fn:function(a){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:!a.item.bydosen},on:{input:function(e){return t.updateNKuan(a)}},model:{value:a.item.nilai_uas,callback:function(e){t.$set(a.item,"nilai_uas",e)},expression:"props.item.nilai_uas"}})]}},{key:"item.n_kuan",fn:function(a){return[null!=a.item.n_kuan?e("v-chip",{staticClass:"ma-2",attrs:{color:"primary",outlined:"",label:""}},[t._v(t._s(a.item.n_kuan))]):t._e()]}},{key:"item.n_kual",fn:function(a){return[e("v-select",{staticStyle:{width:"65px"},attrs:{items:t.$store.getters["uiadmin/getSkalaNilai"],disabled:!a.item.bydosen,dense:""},model:{value:a.item.n_kual,callback:function(e){t.$set(a.item,"n_kual",e)},expression:"props.item.n_kual"}})]}},t.datatable_peserta.length>0?{key:"body.append",fn:function(){return[e("tr",[e("td",{staticClass:"text-right",attrs:{colspan:"12"}},[e("v-btn",{staticClass:"primary mt-2 mb-2",attrs:{loading:t.btnLoading,disabled:t.btnLoading},on:{click:function(a){return a.stopPropagation(),t.save(a)}}},[t._v(" SIMPAN ")])],1)])]},proxy:!0}:null,{key:"no-data",fn:function(){return[t._v(" Data belum tersedia ")]},proxy:!0}],null,!0),model:{value:t.daftar_nilai,callback:function(a){t.daftar_nilai=a},expression:"daftar_nilai"}})],1)],1)],1)],1):t._e()],1)},n=[],s=(e("4160"),e("b680"),e("159b"),e("96cf"),e("1da1")),r=e("e60c"),l=e("e477"),u=e("d087"),o=e("6330"),d={name:"NilaiIsiPerKelasMHSDetail",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"ISI NILAI",disabled:!1,href:"#"},{text:"PER KELAS MAHASISWA",disabled:!0,href:"#"}],this.kelas_mhs_id=this.$route.params.kelas_mhs_id,this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"],this.semester_akademik=this.$store.getters["uiadmin/getSemesterAkademik"],this.initialize()},data:function(){return{kelas_mhs_id:null,data_kelas_mhs:null,tahun_akademik:null,semester_akademik:null,btnLoadingTable:!1,datatableLoading:!1,btnLoading:!1,datatable:[],datatable_peserta:[],headers_peserta:[{text:"NIM",value:"nim",sortable:!1,width:100},{text:"NAMA",value:"nama_mhs",sortable:!1,width:250},{text:"NILAI ABSENSI",value:"nilai_absen",sortable:!1,width:100},{text:"NILAI QUIZ",value:"nilai_quiz",sortable:!1,width:100},{text:"NILAI TUGAS INDIVIDU",value:"nilai_tugas_individu",sortable:!1,width:100},{text:"NILAI TUGAS KELOMPOK",value:"nilai_tugas_kelompok",sortable:!1,width:100},{text:"NILAI UTS",value:"nilai_uts",sortable:!1,width:100},{text:"NILAI UAS",value:"nilai_uas",sortable:!1,width:100},{text:"NILAI ANGKA (0 s.d 100)",value:"n_kuan",sortable:!1,width:100},{text:"NILAI HURUP",value:"n_kual",sortable:!1,width:100}],form_valid:!0,komponen_nilai:{persen_absen:15,persen_quiz:0,persen_tugas_individu:35,persen_tugas_kelompok:0,persen_uts:25,persen_uas:25},daftar_nilai:[]}},methods:{initialize:function(){var t=Object(s["a"])(regeneratorRuntime.mark((function t(){var a=this;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return this.datatableLoading=!0,t.next=3,this.$ajax.get("/akademik/perkuliahan/pembagiankelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.data_kelas_mhs=e.pembagiankelas}));case 3:return t.next=5,this.$ajax.get("/akademik/nilai/matakuliah/pesertakelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(t){var e=t.data;a.datatableLoading=!1,a.datatable_peserta=e.peserta}));case 5:case"end":return t.stop()}}),t,this)})));function a(){return t.apply(this,arguments)}return a}(),updateNKuan:function(t){var a=0;t.item.nilai_absen>0&&this.komponen_nilai.persen_absen>0&&(a=this.komponen_nilai.persen_absen/100*t.item.nilai_absen);var e=0;t.item.nilai_quiz>0&&this.komponen_nilai.persen_quiz>0&&(e=this.komponen_nilai.persen_quiz/100*t.item.nilai_quiz);var i=0;t.item.nilai_tugas_individu>0&&this.komponen_nilai.persen_tugas_individu>0&&(i=this.komponen_nilai.persen_tugas_individu/100*t.item.nilai_tugas_individu);var n=0;t.item.nilai_tugas_kelompok>0&&this.komponen_nilai.persen_tugas_kelompok>0&&(n=this.komponen_nilai.persen_tugas_kelompok/100*t.item.nilai_tugas_kelompok);var s=0;t.item.nilai_uts>0&&this.komponen_nilai.persen_uts>0&&(s=this.komponen_nilai.persen_uts/100*t.item.nilai_uts);var r=0;t.item.nilai_uas>0&&this.komponen_nilai.persen_uas>0&&(r=this.komponen_nilai.persen_uas/100*t.item.nilai_uas),t.item.n_kuan=(a+e+i+n+s+r).toFixed(2),console.log(t.item.n_kuan)},save:function(){var t=this;return Object(s["a"])(regeneratorRuntime.mark((function a(){var e;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return t.btnLoadingTable=!0,e=[],t.daftar_nilai.forEach((function(t){e.push({krsmatkul_id:t.krsmatkul_id,nilai_absen:t.nilai_absen,nilai_tugas_individu:t.nilai_tugas_individu,nilai_tugas_kelompok:t.nilai_tugas_kelompok,nilai_quiz:t.nilai_quiz,nilai_uts:t.nilai_uts,nilai_uas:t.nilai_uas,n_kuan:t.n_kuan,n_kual:t.n_kual})})),a.next=5,t.$ajax.post("/akademik/nilai/matakuliah/perdosen/storeperdosen",{kelas_mhs_id:t.kelas_mhs_id,daftar_nilai:JSON.stringify(Object.assign({},e))},{headers:{Authorization:t.$store.getters["auth/Token"]}}).then((function(){t.$router.go()})).catch((function(){t.btnLoadingTable=!1}));case 5:case"end":return a.stop()}}),a)})))()},togleAngkaNilai:function(){console.log("test")}},computed:{},components:{AkademikLayout:r["a"],ModuleHeader:l["a"],DataKelasMHS:u["a"],VAngkaNilai:o["a"]}},c=d,_=e("2877"),m=e("6544"),k=e.n(m),h=e("0798"),p=e("2bc5"),f=e("8336"),b=e("cc20"),g=e("62ad"),v=e("a523"),y=e("8fea"),x=e("ce7e"),A=e("4bd4"),w=e("132d"),N=e("0fd9"),S=e("b974"),V=e("2fa4"),I=e("71d9"),P=e("2a7f"),L=Object(_["a"])(c,i,n,!1,null,null,null);a["default"]=L.exports;k()(L,{VAlert:h["a"],VBreadcrumbs:p["a"],VBtn:f["a"],VChip:b["a"],VCol:g["a"],VContainer:v["a"],VDataTable:y["a"],VDivider:x["a"],VForm:A["a"],VIcon:w["a"],VRow:N["a"],VSelect:S["a"],VSpacer:V["a"],VToolbar:I["a"],VToolbarTitle:P["c"]})}}]);