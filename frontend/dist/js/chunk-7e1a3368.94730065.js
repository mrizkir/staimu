(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-7e1a3368"],{"560a":function(a,t,e){"use strict";e("800d")},6330:function(a,t,e){"use strict";var i=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("v-text-field",a._g(a._b({staticClass:"right-input",on:{blur:a.onBlur,focus:a.onFocus,keydown:a.keyProcess},model:{value:a.dataValue,callback:function(t){a.dataValue=a._n(t)},expression:"dataValue"}},"v-text-field",a.$attrs,!1),a.$listeners))},n=[],s=(e("1276"),e("ac1f"),e("d3b7"),e("25f0"),e("b65f"),e("caad"),e("b680"),e("a9e3"),{data:function(){return{dataValue:this.value}},props:{value:[String,Number]},watch:{value:{immediate:!0,handler:function(a){this.dataValue=a}}}}),r={name:"VAngkaNilai",mixins:[s],data:function(){return{fractDigitsEdited:!1,fractPart:null,isFocused:!1}},mounted:function(){var a=(this.dataValue+"").split(".");a.length>0&&(this.fractPart=a[1],this.fractDigitsEdited=!0),this.fractPart=a.length>0?a[1]:null},methods:{clearValue:function(){this.dataValue=0,this.fractPart=null,this.fractDigitsEdited=!1},setFocus:function(a){this.isFocused=a},onBlur:function(){this.setFocus(!1)},onFocus:function(){this.setFocus(!0)},keyProcess:function(a){if(this.isFocused&&("ArrowLeft"!==a.key&&"ArrowRight"!==a.key&&a.preventDefault(),a.stopPropagation(),"Enter"!==a.key))if("Delete"!==a.key){var t=["0","1","2","3","4","5","6","7","8","9"],e=Math.trunc(this.dataValue).toString();t.includes(a.key)?this.fractDigitsEdited?null==this.fractPart?this.fractPart=a.key:this.fractPart.length<=1&&(this.fractPart+=a.key.toString()):e+=a.key:"Backspace"===a.key?this.fractDigitsEdited?null===this.fractPart?this.fractDigitsEdited=!1:this.fractPart=this.fractPart.length<1?null:this.fractPart.substring(0,this.fractPart.length-1):e=e.length<=1?"0":e.substring(0,e.length-1):["."].includes(a.key)&&(this.fractDigitsEdited=!this.fractDigitsEdited);var i=null==this.fractPart?parseFloat(e).toFixed(2):parseFloat(e+"."+this.fractPart).toFixed(2);i>=0&&i<=100&&(this.dataValue=i,this.$emit("input",this.dataValue))}else this.clearValue()}}},l=r,o=(e("560a"),e("2877")),u=e("6544"),d=e.n(u),c=e("8654"),_=Object(o["a"])(l,i,n,!1,null,"2fc9ad40",null);t["a"]=_.exports;d()(_,{VTextField:c["a"]})},"800d":function(a,t,e){},b65f:function(a,t,e){var i=e("23e7"),n=Math.ceil,s=Math.floor;i({target:"Math",stat:!0},{trunc:function(a){return(a>0?s:n)(a)}})},b794:function(a,t,e){"use strict";e.r(t);var i=function(){var a=this,t=a.$createElement,e=a._self._c||t;return e("AkademikLayout",{attrs:{showrightsidebar:!1,temporaryleftsidebar:!0}},[e("ModuleHeader",{scopedSlots:a._u([{key:"icon",fn:function(){return[a._v(" mdi-monitor-dashboard ")]},proxy:!0},{key:"name",fn:function(){return[a._v(" ISI NILAI PER KELAS ")]},proxy:!0},{key:"subtitle",fn:function(){return[a._v(" TAHUN AKADEMIK "+a._s(a.tahun_akademik)+" SEMESTER "+a._s(a.$store.getters["uiadmin/getNamaSemester"](a.semester_akademik))+" ")]},proxy:!0},{key:"breadcrumbs",fn:function(){return[e("v-breadcrumbs",{staticClass:"pa-0",attrs:{items:a.breadcrumbs},scopedSlots:a._u([{key:"divider",fn:function(){return[e("v-icon",[a._v("mdi-chevron-right")])]},proxy:!0}])})]},proxy:!0},{key:"desc",fn:function(){return[e("v-alert",{attrs:{color:"cyan",border:"left","colored-border":"",type:"info"}},[a._v(" Halaman untuk melakukan pengisian nilai berdasarkan kelas mahasiswa yang telah dibentuk pada pembagian kelas. ")])]},proxy:!0}])}),a.data_kelas_mhs?e("v-container",{attrs:{fluid:""}},[e("v-row",[e("v-col",{attrs:{cols:"12"}},[e("DataKelasMHS",{attrs:{datakelas:a.data_kelas_mhs}})],1)],1),e("v-row",[e("v-col",{attrs:{cols:"12"}},[e("v-alert",{attrs:{type:"warning"}},[a._v(" Catatan: Pilihlah (CENTANG) mahasiswa yang akan diisi nilainya. Untuk meningkatkan performance bila jumlah peserta lebih dari 10; maka disarankan mengisi nilai per 10 mahasiswa. ")])],1),e("v-col",{attrs:{cols:"12"}},[e("v-expansion-panels",{attrs:{focusable:""}},[e("v-expansion-panel",[e("v-expansion-panel-header",[a._v("Range Nilai Huruf")]),e("v-expansion-panel-content",[a._v(" A = 95.00-100.00"),e("br"),a._v(" A- = 90.00-94.99"),e("br"),a._v(" A/B = 85.00-89.99"),e("br"),a._v(" (B+) = 80.00-84.99"),e("br"),a._v(" B = 75.00-79.99"),e("br"),a._v(" B- = 70.00-74.99"),e("br"),a._v(" B/C = 65.00-69.99"),e("br"),a._v(" (C+) = 60.00-64.99"),e("br"),a._v(" C = 55.00-59.99"),e("br"),a._v(" C- = 50.00-54.99"),e("br"),a._v(" C/D = 45.00-49.99"),e("br"),a._v(" (D+) = 40.00-44.99"),e("br"),a._v(" D = 35.00-39.99"),e("br"),a._v(" E = 34.99-0"),e("br")])],1)],1)],1),e("v-col",{attrs:{cols:"12"}},[e("v-form",{ref:"frmdata",attrs:{"lazy-validation":""},model:{value:a.form_valid,callback:function(t){a.form_valid=t},expression:"form_valid"}},[e("v-data-table",{staticClass:"elevation-1",attrs:{headers:a.headers_peserta,items:a.datatable_peserta,"item-key":"krsmatkul_id","show-select":"","disable-pagination":!0,"hide-default-footer":!0,loading:a.datatableLoading,"loading-text":"Loading... Please wait",dense:""},scopedSlots:a._u([{key:"top",fn:function(){return[e("v-toolbar",{attrs:{flat:"",color:"white"}},[e("v-toolbar-title",[a._v("DAFTAR PESERTA")]),e("v-divider",{staticClass:"mx-4",attrs:{inset:"",vertical:""}}),e("v-spacer")],1)]},proxy:!0},{key:"item.idkelas",fn:function(t){var e=t.item;return[a._v(" "+a._s(a.$store.getters["uiadmin/getNamaKelas"](e.idkelas))+" ")]}},{key:"item.kjur",fn:function(t){var e=t.item;return[a._v(" "+a._s(a.$store.getters["uiadmin/getProdiName"](e.kjur))+" ")]}},{key:"item.nilai_absen",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_absen,callback:function(e){a.$set(t.item,"nilai_absen",e)},expression:"props.item.nilai_absen"}})]}},{key:"item.nilai_quiz",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_quiz,callback:function(e){a.$set(t.item,"nilai_quiz",e)},expression:"props.item.nilai_quiz"}})]}},{key:"item.nilai_tugas_individu",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_tugas_individu,callback:function(e){a.$set(t.item,"nilai_tugas_individu",e)},expression:"props.item.nilai_tugas_individu"}})]}},{key:"item.nilai_tugas_kelompok",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_tugas_kelompok,callback:function(e){a.$set(t.item,"nilai_tugas_kelompok",e)},expression:"props.item.nilai_tugas_kelompok"}})]}},{key:"item.nilai_uts",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_uts,callback:function(e){a.$set(t.item,"nilai_uts",e)},expression:"props.item.nilai_uts"}})]}},{key:"item.nilai_uas",fn:function(t){return[e("VAngkaNilai",{staticStyle:{width:"65px"},attrs:{dense:"",disabled:a.isbydosen(t.item.bydosen)},on:{input:function(e){return a.updateNKuan(t)}},model:{value:t.item.nilai_uas,callback:function(e){a.$set(t.item,"nilai_uas",e)},expression:"props.item.nilai_uas"}})]}},{key:"item.n_kuan",fn:function(t){return[null!=t.item.n_kuan?e("v-chip",{staticClass:"ma-2",attrs:{color:"primary",outlined:"",label:""}},[a._v(a._s(t.item.n_kuan))]):a._e()]}},{key:"item.n_kual",fn:function(t){return[e("v-select",{staticStyle:{width:"65px"},attrs:{items:a.$store.getters["uiadmin/getSkalaNilai"],disabled:a.isbydosen(t.item.bydosen),dense:""},model:{value:t.item.n_kual,callback:function(e){a.$set(t.item,"n_kual",e)},expression:"props.item.n_kual"}})]}},a.datatable_peserta.length>0?{key:"body.append",fn:function(){return[e("tr",[e("td",{staticClass:"text-right",attrs:{colspan:"12"}},[e("v-btn",{staticClass:"primary mt-2 mb-2",attrs:{disabled:a.btnLoading},on:{click:function(t){return t.stopPropagation(),a.save(t)}}},[a._v(" SIMPAN ")])],1)])]},proxy:!0}:null,{key:"no-data",fn:function(){return[a._v(" Data belum tersedia ")]},proxy:!0}],null,!0),model:{value:a.daftar_nilai,callback:function(t){a.daftar_nilai=t},expression:"daftar_nilai"}})],1)],1)],1)],1):a._e()],1)},n=[],s=e("1da1"),r=(e("b680"),e("159b"),e("96cf"),e("e60c")),l=e("e477"),o=e("d087"),u=e("6330"),d={name:"NilaiIsiPerKelasMHSDetail",created:function(){this.breadcrumbs=[{text:"HOME",disabled:!1,href:"/dashboard/"+this.$store.getters["auth/AccessToken"]},{text:"AKADEMIK",disabled:!1,href:"/akademik"},{text:"ISI NILAI",disabled:!1,href:"#"},{text:"PER KELAS MAHASISWA",disabled:!0,href:"#"}],this.kelas_mhs_id=this.$route.params.kelas_mhs_id,this.tahun_akademik=this.$store.getters["uiadmin/getTahunAkademik"],this.semester_akademik=this.$store.getters["uiadmin/getSemesterAkademik"],this.initialize()},data:function(){return{kelas_mhs_id:null,data_kelas_mhs:null,tahun_akademik:null,semester_akademik:null,btnLoadingTable:!1,datatableLoading:!1,btnLoading:!1,datatable:[],datatable_peserta:[],headers_peserta:[{text:"NIM",value:"nim",sortable:!1,width:100},{text:"NAMA",value:"nama_mhs",sortable:!1,width:250},{text:"NILAI ABSENSI",value:"nilai_absen",sortable:!1,width:100},{text:"NILAI QUIZ",value:"nilai_quiz",sortable:!1,width:100},{text:"NILAI TUGAS INDIVIDU",value:"nilai_tugas_individu",sortable:!1,width:100},{text:"NILAI TUGAS KELOMPOK",value:"nilai_tugas_kelompok",sortable:!1,width:100},{text:"NILAI UTS",value:"nilai_uts",sortable:!1,width:100},{text:"NILAI UAS",value:"nilai_uas",sortable:!1,width:100},{text:"NILAI ANGKA (0 s.d 100)",value:"n_kuan",sortable:!1,width:100},{text:"NILAI HURUP",value:"n_kual",sortable:!1,width:100}],form_valid:!0,komponen_nilai:{persen_absen:15,persen_quiz:0,persen_tugas_individu:35,persen_tugas_kelompok:0,persen_uts:25,persen_uas:25},daftar_nilai:[]}},methods:{initialize:function(){var a=Object(s["a"])(regeneratorRuntime.mark((function a(){var t=this;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return this.datatableLoading=!0,a.next=3,this.$ajax.get("/akademik/perkuliahan/pembagiankelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.data_kelas_mhs=e.pembagiankelas}));case 3:return a.next=5,this.$ajax.get("/akademik/nilai/matakuliah/pesertakelas/"+this.kelas_mhs_id,{headers:{Authorization:this.$store.getters["auth/Token"]}}).then((function(a){var e=a.data;t.datatableLoading=!1,t.datatable_peserta=e.peserta}));case 5:case"end":return a.stop()}}),a,this)})));function t(){return a.apply(this,arguments)}return t}(),updateNKuan:function(a){var t=0;a.item.nilai_absen>0&&this.komponen_nilai.persen_absen>0&&(t=this.komponen_nilai.persen_absen/100*a.item.nilai_absen);var e=0;a.item.nilai_quiz>0&&this.komponen_nilai.persen_quiz>0&&(e=this.komponen_nilai.persen_quiz/100*a.item.nilai_quiz);var i=0;a.item.nilai_tugas_individu>0&&this.komponen_nilai.persen_tugas_individu>0&&(i=this.komponen_nilai.persen_tugas_individu/100*a.item.nilai_tugas_individu);var n=0;a.item.nilai_tugas_kelompok>0&&this.komponen_nilai.persen_tugas_kelompok>0&&(n=this.komponen_nilai.persen_tugas_kelompok/100*a.item.nilai_tugas_kelompok);var s=0;a.item.nilai_uts>0&&this.komponen_nilai.persen_uts>0&&(s=this.komponen_nilai.persen_uts/100*a.item.nilai_uts);var r=0;a.item.nilai_uas>0&&this.komponen_nilai.persen_uas>0&&(r=this.komponen_nilai.persen_uas/100*a.item.nilai_uas);var l=(t+e+i+n+s+r).toFixed(2);a.item.n_kuan=l;var o=null;l>=95?o="A":l>=90&&l<95?o="A-":l>=85&&l<90?o="A/B":l>=80&&l<85?o="B+":l>=75&&l<80?o="B":l>=70&&l<75?o="B-":l>=65&&l<70?o="B/C":l>=60&&l<65?o="C+":l>=55&&l<59?o="C":l>=50&&l<54?o="C-":l>=45&&l<50||l>=40&&l<45?o="C/D":l>=40&&l<45?o="D+":l<40&&(o="E"),a.item.n_kual=o},save:function(){var a=this;return Object(s["a"])(regeneratorRuntime.mark((function t(){var e;return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:return a.btnLoadingTable=!0,e=[],a.daftar_nilai.forEach((function(a){e.push({krsmatkul_id:a.krsmatkul_id,nilai_absen:a.nilai_absen,nilai_tugas_individu:a.nilai_tugas_individu,nilai_tugas_kelompok:a.nilai_tugas_kelompok,nilai_quiz:a.nilai_quiz,nilai_uts:a.nilai_uts,nilai_uas:a.nilai_uas,n_kuan:a.n_kuan,n_kual:a.n_kual})})),t.next=5,a.$ajax.post("/akademik/nilai/matakuliah/perdosen/storeperdosen",{kelas_mhs_id:a.kelas_mhs_id,daftar_nilai:JSON.stringify(Object.assign({},e))},{headers:{Authorization:a.$store.getters["auth/Token"]}}).then((function(){a.$router.go()})).catch((function(){a.btnLoadingTable=!1}));case 5:case"end":return t.stop()}}),t)})))()},isbydosen:function(a){return!!a&&!a}},computed:{},components:{AkademikLayout:r["a"],ModuleHeader:l["a"],DataKelasMHS:o["a"],VAngkaNilai:u["a"]}},c=d,_=e("2877"),m=e("6544"),k=e.n(m),p=e("0798"),h=e("2bc5"),f=e("8336"),b=e("cc20"),v=e("62ad"),g=e("a523"),y=e("8fea"),x=e("ce7e"),A=e("cd55"),w=e("49e2"),N=e("c865"),V=e("0393"),S=e("4bd4"),I=e("132d"),E=e("0fd9"),P=e("b974"),$=e("2fa4"),D=e("71d9"),L=e("2a7f"),C=Object(_["a"])(c,i,n,!1,null,null,null);t["default"]=C.exports;k()(C,{VAlert:p["a"],VBreadcrumbs:h["a"],VBtn:f["a"],VChip:b["a"],VCol:v["a"],VContainer:g["a"],VDataTable:y["a"],VDivider:x["a"],VExpansionPanel:A["a"],VExpansionPanelContent:w["a"],VExpansionPanelHeader:N["a"],VExpansionPanels:V["a"],VForm:S["a"],VIcon:I["a"],VRow:E["a"],VSelect:P["a"],VSpacer:$["a"],VToolbar:D["a"],VToolbarTitle:L["c"]})}}]);