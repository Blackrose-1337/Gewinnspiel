import{m as U,ai as z,K,g as q,t as h,r as j,w as C,ad as M,n as o,p as l,v as d,x as e,am as R,q as i,an as L,F as x,y as V,z as S,ak as B,E}from"./index.2f8d8692.js";import{u as T}from"./evaluation.38247113.js";const A={key:0},G=i("h4",{class:"q-ma-md"},"Projekttitle",-1),H=i("h4",{class:"q-ma-md"},"Projekttext",-1),J={class:"row q-gutter-lg pic"},O=["src"],W={key:0},X={key:1},Y={key:1},Z={class:"texts q-pa-lg"},$={class:"row q-gutter-lg pic"},ee=["src"],se=U({props:{user:null,selectedproject:null,view:null},setup(F){const v=F,r=z(),f=T(),p=K(),a=q(()=>r.project);q(()=>f.img);const{user:g}=h(v),{selectedproject:_}=h(v),{view:s}=h(v);let m=j(!1);const D=j(!0),u=j([]);var k=new Image;async function I(){await r.postProject()==!0?p.notify({type:"positive",message:"\xC4nderung wurden gespeichert!",color:"green"}):p.notify({type:"negative",message:"Der Speichervorgang ist gescheitert",color:"red"})}async function N(){await r.remove(a.value.id)==!0?p.notify({type:"positive",message:"Bilder und Projekt wurden gel\xF6scht",color:"green"}):p.notify({type:"negative",message:"Der Speichervorgang ist gescheitert",color:"red"})}async function P(){m.value=!0,g.value==null||(r.clear(),await r.getProject(g.value.id),await b())}async function b(){u.value=[],a.value.pics!==null&&a.value.pics!=="undefined"&&a.value.pics.forEach(t=>{k.src=t.img,u.value.push(k.src)}),setTimeout(()=>{m.value=!1},500)}async function Q(){u.value=[],m.value=!0,r.setProject(_.value),await f.getImages(_.value.id),r.clear(),a.value.pics=f.img,await b()}function w(t){t.target.classList.contains("expandanimation")?(t.target.classList.remove("expandanimation"),t.target.classList.add("reexpandanimation")):(t.target.classList.remove("reexpandanimation"),t.target.classList.add("expandanimation"))}return C(g,t=>{P()}),M(()=>{(s==null?void 0:s.value)!=="Project"&&(s==null?void 0:s.value)!=="evaluation"&&(typeof g.value.id=="undefined"||P())}),C(_,t=>{Q()}),(t,n)=>(o(),l(x,null,[d(e(R),{active:e(m),backgroundColor:"rgba(0, 0, 0, 0.021)","can-cancel":!0,"is-full-page":D.value},null,8,["active","is-full-page"]),e(s)==="Project"||e(s)==="User"?(o(),l("div",A,[i("div",null,[G,d(L,{modelValue:e(a).title,"onUpdate:modelValue":n[0]||(n[0]=c=>e(a).title=c),outlined:"",class:"q-ma-md"},null,8,["modelValue"]),H,d(L,{modelValue:e(a).text,"onUpdate:modelValue":n[1]||(n[1]=c=>e(a).text=c),outlined:"",class:"q-ma-md",autogrow:""},null,8,["modelValue"])]),i("div",J,[(o(!0),l(x,null,V(e(u),c=>(o(),l("img",{class:"minipic q-pa-md",src:c,ratio:1,onClick:n[2]||(n[2]=y=>w(y))},null,8,O))),256))]),e(s)=="Project"?(o(),l("div",W,[d(S,{label:"\xC4nderungen Speichern",color:"blue",onClick:I,class:"rebtn"})])):B("",!0),e(s)=="Project"?(o(),l("div",X,[d(S,{label:"Projekt L\xF6schen",color:"red",onClick:N,class:"rebtn"})])):B("",!0)])):(o(),l("div",Y,[i("div",Z,[i("h3",null,E(e(a).title),1),i("p",null,E(e(a).text),1)]),i("div",$,[(o(!0),l(x,null,V(e(u),c=>(o(),l("img",{"spinner-color":"green",class:"minipic q-pa-md",src:c,ratio:1,onClick:n[3]||(n[3]=y=>w(y))},null,8,ee))),256))])]))],64))}});export{se as _};
