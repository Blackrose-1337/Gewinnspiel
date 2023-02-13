var nt=Object.defineProperty,ut=Object.defineProperties;var st=Object.getOwnPropertyDescriptors;var Me=Object.getOwnPropertySymbols;var ct=Object.prototype.hasOwnProperty,dt=Object.prototype.propertyIsEnumerable;var Oe=(e,o,s)=>o in e?nt(e,o,{enumerable:!0,configurable:!0,writable:!0,value:s}):e[o]=s,M=(e,o)=>{for(var s in o||(o={}))ct.call(o,s)&&Oe(e,s,o[s]);if(Me)for(var s of Me(o))dt.call(o,s)&&Oe(e,s,o[s]);return e},Y=(e,o)=>ut(e,st(o));import{M as vt,N as G,O as ft,P as ht,R as re,S as be,T as xe,U as ye,V as qe,W as ge,s as mt,X as bt,c as Re,u as Xe,r as S,d as Ie,g as d,Y as yt,Z as gt,_ as pt,$ as Ye,h as B,i as St,a0 as je,a1 as zt,a2 as Be,k as Je,a3 as W,a4 as De,a5 as $e,a6 as wt,a7 as _t,a8 as Ct,a9 as kt,aa as qt,ab as Bt,ac as Pt,w as C,ad as Tt,ae as Ae,af as Ee,j as Mt,ag as Ot,m as xt,t as jt,ah as Dt,ai as $t,aj as He,n as O,B as pe,C as x,v as R,x as L,H as Fe,G as Le,p as V,y as Se,F as ze,z as oe,ak as ie,q as ue,D as ne,al as we,E as _e}from"./index.2f8d8692.js";const Pe={left:!0,right:!0,up:!0,down:!0,horizontal:!0,vertical:!0},At=Object.keys(Pe);Pe.all=!0;function Ve(e){const o={};for(const s of At)e[s]===!0&&(o[s]=!0);return Object.keys(o).length===0?Pe:(o.horizontal===!0?o.left=o.right=!0:o.left===!0&&o.right===!0&&(o.horizontal=!0),o.vertical===!0?o.up=o.down=!0:o.up===!0&&o.down===!0&&(o.vertical=!0),o.horizontal===!0&&o.vertical===!0&&(o.all=!0),o)}function We(e,o){return o.event===void 0&&e.target!==void 0&&e.target.draggable!==!0&&typeof o.handler=="function"&&e.target.nodeName.toUpperCase()!=="INPUT"&&(e.qClonedBy===void 0||e.qClonedBy.indexOf(o.uid)===-1)}function Ce(e,o,s){const y=qe(e);let t,i=y.left-o.event.x,u=y.top-o.event.y,a=Math.abs(i),b=Math.abs(u);const l=o.direction;l.horizontal===!0&&l.vertical!==!0?t=i<0?"left":"right":l.horizontal!==!0&&l.vertical===!0?t=u<0?"up":"down":l.up===!0&&u<0?(t="up",a>b&&(l.left===!0&&i<0?t="left":l.right===!0&&i>0&&(t="right"))):l.down===!0&&u>0?(t="down",a>b&&(l.left===!0&&i<0?t="left":l.right===!0&&i>0&&(t="right"))):l.left===!0&&i<0?(t="left",a<b&&(l.up===!0&&u<0?t="up":l.down===!0&&u>0&&(t="down"))):l.right===!0&&i>0&&(t="right",a<b&&(l.up===!0&&u<0?t="up":l.down===!0&&u>0&&(t="down")));let _=!1;if(t===void 0&&s===!1){if(o.event.isFirst===!0||o.event.lastDir===void 0)return{};t=o.event.lastDir,_=!0,t==="left"||t==="right"?(y.left-=i,a=0,i=0):(y.top-=u,b=0,u=0)}return{synthetic:_,payload:{evt:e,touch:o.event.mouse!==!0,mouse:o.event.mouse===!0,position:y,direction:t,isFirst:o.event.isFirst,isFinal:s===!0,duration:Date.now()-o.event.time,distance:{x:a,y:b},offset:{x:i,y:u},delta:{x:y.left-o.event.lastX,y:y.top-o.event.lastY}}}}let Et=0;var Z=vt({name:"touch-pan",beforeMount(e,{value:o,modifiers:s}){if(s.mouse!==!0&&G.has.touch!==!0)return;function y(i,u){s.mouse===!0&&u===!0?mt(i):(s.stop===!0&&ye(i),s.prevent===!0&&xe(i))}const t={uid:"qvtp_"+Et++,handler:o,modifiers:s,direction:Ve(s),noop:ft,mouseStart(i){We(i,t)&&ht(i)&&(re(t,"temp",[[document,"mousemove","move","notPassiveCapture"],[document,"mouseup","end","passiveCapture"]]),t.start(i,!0))},touchStart(i){if(We(i,t)){const u=i.target;re(t,"temp",[[u,"touchmove","move","notPassiveCapture"],[u,"touchcancel","end","passiveCapture"],[u,"touchend","end","passiveCapture"]]),t.start(i)}},start(i,u){if(G.is.firefox===!0&&be(e,!0),t.lastEvt=i,u===!0||s.stop===!0){if(t.direction.all!==!0&&(u!==!0||t.modifiers.mouseAllDir!==!0)){const l=i.type.indexOf("mouse")>-1?new MouseEvent(i.type,i):new TouchEvent(i.type,i);i.defaultPrevented===!0&&xe(l),i.cancelBubble===!0&&ye(l),Object.assign(l,{qKeyEvent:i.qKeyEvent,qClickOutside:i.qClickOutside,qAnchorHandled:i.qAnchorHandled,qClonedBy:i.qClonedBy===void 0?[t.uid]:i.qClonedBy.concat(t.uid)}),t.initialEvent={target:i.target,event:l}}ye(i)}const{left:a,top:b}=qe(i);t.event={x:a,y:b,time:Date.now(),mouse:u===!0,detected:!1,isFirst:!0,isFinal:!1,lastX:a,lastY:b}},move(i){if(t.event===void 0)return;const u=qe(i),a=u.left-t.event.x,b=u.top-t.event.y;if(a===0&&b===0)return;t.lastEvt=i;const l=t.event.mouse===!0,_=()=>{y(i,l),s.preserveCursor!==!0&&(document.documentElement.style.cursor="grabbing"),l===!0&&document.body.classList.add("no-pointer-events--children"),document.body.classList.add("non-selectable"),bt(),t.styleCleanup=h=>{if(t.styleCleanup=void 0,s.preserveCursor!==!0&&(document.documentElement.style.cursor=""),document.body.classList.remove("non-selectable"),l===!0){const k=()=>{document.body.classList.remove("no-pointer-events--children")};h!==void 0?setTimeout(()=>{k(),h()},50):k()}else h!==void 0&&h()}};if(t.event.detected===!0){t.event.isFirst!==!0&&y(i,t.event.mouse);const{payload:h,synthetic:k}=Ce(i,t,!1);h!==void 0&&(t.handler(h)===!1?t.end(i):(t.styleCleanup===void 0&&t.event.isFirst===!0&&_(),t.event.lastX=h.position.left,t.event.lastY=h.position.top,t.event.lastDir=k===!0?void 0:h.direction,t.event.isFirst=!1));return}if(t.direction.all===!0||l===!0&&t.modifiers.mouseAllDir===!0){_(),t.event.detected=!0,t.move(i);return}const z=Math.abs(a),p=Math.abs(b);z!==p&&(t.direction.horizontal===!0&&z>p||t.direction.vertical===!0&&z<p||t.direction.up===!0&&z<p&&b<0||t.direction.down===!0&&z<p&&b>0||t.direction.left===!0&&z>p&&a<0||t.direction.right===!0&&z>p&&a>0?(t.event.detected=!0,t.move(i)):t.end(i,!0))},end(i,u){if(t.event!==void 0){if(ge(t,"temp"),G.is.firefox===!0&&be(e,!1),u===!0)t.styleCleanup!==void 0&&t.styleCleanup(),t.event.detected!==!0&&t.initialEvent!==void 0&&t.initialEvent.target.dispatchEvent(t.initialEvent.event);else if(t.event.detected===!0){t.event.isFirst===!0&&t.handler(Ce(i===void 0?t.lastEvt:i,t).payload);const{payload:a}=Ce(i===void 0?t.lastEvt:i,t,!0),b=()=>{t.handler(a)};t.styleCleanup!==void 0?t.styleCleanup(b):b()}t.event=void 0,t.initialEvent=void 0,t.lastEvt=void 0}}};e.__qtouchpan=t,s.mouse===!0&&re(t,"main",[[e,"mousedown","mouseStart",`passive${s.mouseCapture===!0?"Capture":""}`]]),G.has.touch===!0&&re(t,"main",[[e,"touchstart","touchStart",`passive${s.capture===!0?"Capture":""}`],[e,"touchmove","noop","notPassiveCapture"]])},updated(e,o){const s=e.__qtouchpan;s!==void 0&&(o.oldValue!==o.value&&(typeof value!="function"&&s.end(),s.handler=o.value),s.direction=Ve(o.modifiers))},beforeUnmount(e){const o=e.__qtouchpan;o!==void 0&&(o.event!==void 0&&o.end(),ge(o,"main"),ge(o,"temp"),G.is.firefox===!0&&be(e,!1),o.styleCleanup!==void 0&&o.styleCleanup(),delete e.__qtouchpan)}});const Ne=["vertical","horizontal"],ke={vertical:{offset:"offsetY",scroll:"scrollTop",dir:"down",dist:"y"},horizontal:{offset:"offsetX",scroll:"scrollLeft",dir:"right",dist:"x"}},Qe={prevent:!0,mouse:!0,mouseAllDir:!0};var Ht=Re({name:"QScrollArea",props:Y(M({},Xe),{thumbStyle:Object,verticalThumbStyle:Object,horizontalThumbStyle:Object,barStyle:[Array,String,Object],verticalBarStyle:[Array,String,Object],horizontalBarStyle:[Array,String,Object],contentStyle:[Array,String,Object],contentActiveStyle:[Array,String,Object],delay:{type:[String,Number],default:1e3},visible:{type:Boolean,default:null},tabindex:[String,Number],onScroll:Function}),setup(e,{slots:o,emit:s}){const y=S(!1),t=S(!1),i=S(!1),u={vertical:S(0),horizontal:S(0)},a={vertical:{ref:S(null),position:S(0),size:S(0)},horizontal:{ref:S(null),position:S(0),size:S(0)}},b=Je(),l=Ie(e,b.proxy.$q);let _,z;const p=S(null),h=d(()=>"q-scrollarea"+(l.value===!0?" q-scrollarea--dark":""));a.vertical.percentage=d(()=>{const n=a.vertical.size.value-u.vertical.value;if(n<=0)return 0;const c=W(a.vertical.position.value/n,0,1);return Math.round(c*1e4)/1e4}),a.vertical.thumbHidden=d(()=>(e.visible===null?i.value:e.visible)!==!0&&y.value===!1&&t.value===!1||a.vertical.size.value<=u.vertical.value+1),a.vertical.thumbStart=d(()=>a.vertical.percentage.value*(u.vertical.value-a.vertical.thumbSize.value)),a.vertical.thumbSize=d(()=>Math.round(W(u.vertical.value*u.vertical.value/a.vertical.size.value,50,u.vertical.value))),a.vertical.style=d(()=>Y(M(M({},e.thumbStyle),e.verticalThumbStyle),{top:`${a.vertical.thumbStart.value}px`,height:`${a.vertical.thumbSize.value}px`})),a.vertical.thumbClass=d(()=>"q-scrollarea__thumb q-scrollarea__thumb--v absolute-right"+(a.vertical.thumbHidden.value===!0?" q-scrollarea__thumb--invisible":"")),a.vertical.barClass=d(()=>"q-scrollarea__bar q-scrollarea__bar--v absolute-right"+(a.vertical.thumbHidden.value===!0?" q-scrollarea__bar--invisible":"")),a.horizontal.percentage=d(()=>{const n=a.horizontal.size.value-u.horizontal.value;if(n<=0)return 0;const c=W(a.horizontal.position.value/n,0,1);return Math.round(c*1e4)/1e4}),a.horizontal.thumbHidden=d(()=>(e.visible===null?i.value:e.visible)!==!0&&y.value===!1&&t.value===!1||a.horizontal.size.value<=u.horizontal.value+1),a.horizontal.thumbStart=d(()=>a.horizontal.percentage.value*(u.horizontal.value-a.horizontal.thumbSize.value)),a.horizontal.thumbSize=d(()=>Math.round(W(u.horizontal.value*u.horizontal.value/a.horizontal.size.value,50,u.horizontal.value))),a.horizontal.style=d(()=>Y(M(M({},e.thumbStyle),e.horizontalThumbStyle),{left:`${a.horizontal.thumbStart.value}px`,width:`${a.horizontal.thumbSize.value}px`})),a.horizontal.thumbClass=d(()=>"q-scrollarea__thumb q-scrollarea__thumb--h absolute-bottom"+(a.horizontal.thumbHidden.value===!0?" q-scrollarea__thumb--invisible":"")),a.horizontal.barClass=d(()=>"q-scrollarea__bar q-scrollarea__bar--h absolute-bottom"+(a.horizontal.thumbHidden.value===!0?" q-scrollarea__bar--invisible":""));const k=d(()=>a.vertical.thumbHidden.value===!0&&a.horizontal.thumbHidden.value===!0?e.contentStyle:e.contentActiveStyle),w=[[Z,n=>{ee(n,"vertical")},void 0,M({vertical:!0},Qe)]],v=[[Z,n=>{ee(n,"horizontal")},void 0,M({horizontal:!0},Qe)]];function X(){const n={};return Ne.forEach(c=>{const m=a[c];n[c+"Position"]=m.position.value,n[c+"Percentage"]=m.percentage.value,n[c+"Size"]=m.size.value,n[c+"ContainerSize"]=u[c].value}),n}const g=yt(()=>{const n=X();n.ref=b.proxy,s("scroll",n)},0);function A(n,c,m){if(Ne.includes(n)===!1){console.error("[QScrollArea]: wrong first param of setScrollPosition (vertical/horizontal)");return}(n==="vertical"?$e:De)(p.value,c,m)}function J({height:n,width:c}){let m=!1;u.vertical.value!==n&&(u.vertical.value=n,m=!0),u.horizontal.value!==c&&(u.horizontal.value=c,m=!0),m===!0&&U()}function N({position:n}){let c=!1;a.vertical.position.value!==n.top&&(a.vertical.position.value=n.top,c=!0),a.horizontal.position.value!==n.left&&(a.horizontal.position.value=n.left,c=!0),c===!0&&U()}function se({height:n,width:c}){a.horizontal.size.value!==c&&(a.horizontal.size.value=c,U()),a.vertical.size.value!==n&&(a.vertical.size.value=n,U())}function ee(n,c){const m=a[c];if(n.isFirst===!0){if(m.thumbHidden.value===!0)return;z=m.position.value,t.value=!0}else if(t.value!==!0)return;n.isFinal===!0&&(t.value=!1);const $=ke[c],I=u[c].value,ce=(m.size.value-I)/(I-m.thumbSize.value),ae=n.distance[$.dist],de=z+(n.direction===$.dir?1:-1)*ae*ce;j(de,c)}function Q(n,c){const m=a[c];if(m.thumbHidden.value!==!0){const $=n[ke[c].offset];if($<m.thumbStart.value||$>m.thumbStart.value+m.thumbSize.value){const I=$-m.thumbSize.value/2;j(I/u[c].value*m.size.value,c)}m.ref.value!==null&&m.ref.value.dispatchEvent(new MouseEvent(n.type,n))}}function T(n){Q(n,"vertical")}function E(n){Q(n,"horizontal")}function U(){y.value===!0?clearTimeout(_):y.value=!0,_=setTimeout(()=>{y.value=!1},e.delay),e.onScroll!==void 0&&g()}function j(n,c){p.value[ke[c].scroll]=n}function K(){i.value=!0}function te(){i.value=!1}Object.assign(b.proxy,{getScrollTarget:()=>p.value,getScroll:X,getScrollPosition:()=>({top:a.vertical.position.value,left:a.horizontal.position.value}),getScrollPercentage:()=>({top:a.vertical.percentage.value,left:a.horizontal.percentage.value}),setScrollPosition:A,setScrollPercentage(n,c,m){A(n,c*(a[n].size.value-u[n].value),m)}});let D=null;return gt(()=>{D={top:a.vertical.position.value,left:a.horizontal.position.value}}),pt(()=>{if(D===null)return;const n=p.value;n!==null&&(De(n,D.left),$e(n,D.top))}),Ye(g.cancel),()=>B("div",{class:h.value,onMouseenter:K,onMouseleave:te},[B("div",{ref:p,class:"q-scrollarea__container scroll relative-position fit hide-scrollbar",tabindex:e.tabindex!==void 0?e.tabindex:void 0},[B("div",{class:"q-scrollarea__content absolute",style:k.value},St(o.default,[B(je,{debounce:0,onResize:se})])),B(zt,{axis:"both",onScroll:N})]),B(je,{debounce:0,onResize:J}),B("div",{class:a.vertical.barClass.value,style:[e.barStyle,e.verticalBarStyle],"aria-hidden":"true",onMousedown:T}),B("div",{class:a.horizontal.barClass.value,style:[e.barStyle,e.horizontalBarStyle],"aria-hidden":"true",onMousedown:E}),Be(B("div",{ref:a.vertical.ref,class:a.vertical.thumbClass.value,style:a.vertical.style.value,"aria-hidden":"true"}),w),Be(B("div",{ref:a.horizontal.ref,class:a.horizontal.thumbClass.value,style:a.horizontal.style.value,"aria-hidden":"true"}),v)])}});const Ue=150;var Ft=Re({name:"QDrawer",inheritAttrs:!1,props:Y(M(M({},wt),Xe),{side:{type:String,default:"left",validator:e=>["left","right"].includes(e)},width:{type:Number,default:300},mini:Boolean,miniToOverlay:Boolean,miniWidth:{type:Number,default:57},breakpoint:{type:Number,default:1023},showIfAbove:Boolean,behavior:{type:String,validator:e=>["default","desktop","mobile"].includes(e),default:"default"},bordered:Boolean,elevated:Boolean,overlay:Boolean,persistent:Boolean,noSwipeOpen:Boolean,noSwipeClose:Boolean,noSwipeBackdrop:Boolean}),emits:[..._t,"on-layout","mini-state"],setup(e,{slots:o,emit:s,attrs:y}){const t=Je(),{proxy:{$q:i}}=t,u=Ie(e,i),{preventBodyScroll:a}=Ot(),{registerTimeout:b}=Ct(),l=kt(qt,()=>{console.error("QDrawer needs to be child of QLayout")});let _,z,p;const h=S(e.behavior==="mobile"||e.behavior!=="desktop"&&l.totalWidth.value<=e.breakpoint),k=d(()=>e.mini===!0&&h.value!==!0),w=d(()=>k.value===!0?e.miniWidth:e.width),v=S(e.showIfAbove===!0&&h.value===!1?!0:e.modelValue===!0),X=d(()=>e.persistent!==!0&&(h.value===!0||$.value===!0));function g(r,f){if(se(),r!==!1&&l.animate(),P(0),h.value===!0){const q=l.instances[D.value];q!==void 0&&q.belowBreakpoint===!0&&q.hide(!1),H(1),l.isContainer.value!==!0&&a(!0)}else H(0),r!==!1&&fe(!1);b(()=>{r!==!1&&fe(!0),f!==!0&&s("show",r)},Ue)}function A(r,f){ee(),r!==!1&&l.animate(),H(0),P(E.value*w.value),he(),f!==!0&&b(()=>{s("hide",r)},Ue)}const{show:J,hide:N}=Bt({showing:v,hideOnRouteChange:X,handleShow:g,handleHide:A}),{addToHistory:se,removeFromHistory:ee}=Pt(v,N,X),Q={belowBreakpoint:h,hide:N},T=d(()=>e.side==="right"),E=d(()=>(i.lang.rtl===!0?-1:1)*(T.value===!0?1:-1)),U=S(0),j=S(!1),K=S(!1),te=S(w.value*E.value),D=d(()=>T.value===!0?"left":"right"),n=d(()=>v.value===!0&&h.value===!1&&e.overlay===!1?e.miniToOverlay===!0?e.miniWidth:w.value:0),c=d(()=>e.overlay===!0||e.miniToOverlay===!0||l.view.value.indexOf(T.value?"R":"L")>-1||i.platform.is.ios===!0&&l.isContainer.value===!0),m=d(()=>e.overlay===!1&&v.value===!0&&h.value===!1),$=d(()=>e.overlay===!0&&v.value===!0&&h.value===!1),I=d(()=>"fullscreen q-drawer__backdrop"+(v.value===!1&&j.value===!1?" hidden":"")),ce=d(()=>({backgroundColor:`rgba(0,0,0,${U.value*.4})`})),ae=d(()=>T.value===!0?l.rows.value.top[2]==="r":l.rows.value.top[0]==="l"),de=d(()=>T.value===!0?l.rows.value.bottom[2]==="r":l.rows.value.bottom[0]==="l"),Ke=d(()=>{const r={};return l.header.space===!0&&ae.value===!1&&(c.value===!0?r.top=`${l.header.offset}px`:l.header.space===!0&&(r.top=`${l.header.size}px`)),l.footer.space===!0&&de.value===!1&&(c.value===!0?r.bottom=`${l.footer.offset}px`:l.footer.space===!0&&(r.bottom=`${l.footer.size}px`)),r}),Ge=d(()=>{const r={width:`${w.value}px`,transform:`translateX(${te.value}px)`};return h.value===!0?r:Object.assign(r,Ke.value)}),Ze=d(()=>"q-drawer__content fit "+(l.isContainer.value!==!0?"scroll":"overflow-auto")),et=d(()=>`q-drawer q-drawer--${e.side}`+(K.value===!0?" q-drawer--mini-animate":"")+(e.bordered===!0?" q-drawer--bordered":"")+(u.value===!0?" q-drawer--dark q-dark":"")+(j.value===!0?" no-transition":v.value===!0?"":" q-layout--prevent-focus")+(h.value===!0?" fixed q-drawer--on-top q-drawer--mobile q-drawer--top-padding":` q-drawer--${k.value===!0?"mini":"standard"}`+(c.value===!0||m.value!==!0?" fixed":"")+(e.overlay===!0||e.miniToOverlay===!0?" q-drawer--on-top":"")+(ae.value===!0?" q-drawer--top-padding":""))),tt=d(()=>{const r=i.lang.rtl===!0?e.side:D.value;return[[Z,ot,void 0,{[r]:!0,mouse:!0}]]}),at=d(()=>{const r=i.lang.rtl===!0?D.value:e.side;return[[Z,Te,void 0,{[r]:!0,mouse:!0}]]}),lt=d(()=>{const r=i.lang.rtl===!0?D.value:e.side;return[[Z,Te,void 0,{[r]:!0,mouse:!0,mouseAllDir:!0}]]});function ve(){it(h,e.behavior==="mobile"||e.behavior!=="desktop"&&l.totalWidth.value<=e.breakpoint)}C(h,r=>{r===!0?(_=v.value,v.value===!0&&N(!1)):e.overlay===!1&&e.behavior!=="mobile"&&_!==!1&&(v.value===!0?(P(0),H(0),he()):J(!1))}),C(()=>e.side,(r,f)=>{l.instances[f]===Q&&(l.instances[f]=void 0,l[f].space=!1,l[f].offset=0),l.instances[r]=Q,l[r].size=w.value,l[r].space=m.value,l[r].offset=n.value}),C(l.totalWidth,()=>{(l.isContainer.value===!0||document.qScrollPrevented!==!0)&&ve()}),C(()=>e.behavior+e.breakpoint,ve),C(l.isContainer,r=>{v.value===!0&&a(r!==!0),r===!0&&ve()}),C(l.scrollbarWidth,()=>{P(v.value===!0?0:void 0)}),C(n,r=>{F("offset",r)}),C(m,r=>{s("on-layout",r),F("space",r)}),C(T,()=>{P()}),C(w,r=>{P(),me(e.miniToOverlay,r)}),C(()=>e.miniToOverlay,r=>{me(r,w.value)}),C(()=>i.lang.rtl,()=>{P()}),C(()=>e.mini,()=>{e.modelValue===!0&&(rt(),l.animate())}),C(k,r=>{s("mini-state",r)});function P(r){r===void 0?Ae(()=>{r=v.value===!0?0:w.value,P(E.value*r)}):(l.isContainer.value===!0&&T.value===!0&&(h.value===!0||Math.abs(r)===w.value)&&(r+=E.value*l.scrollbarWidth.value),te.value=r)}function H(r){U.value=r}function fe(r){const f=r===!0?"remove":l.isContainer.value!==!0?"add":"";f!==""&&document.body.classList[f]("q-body--drawer-toggle")}function rt(){clearTimeout(z),t.proxy&&t.proxy.$el&&t.proxy.$el.classList.add("q-drawer--mini-animate"),K.value=!0,z=setTimeout(()=>{K.value=!1,t&&t.proxy&&t.proxy.$el&&t.proxy.$el.classList.remove("q-drawer--mini-animate")},150)}function ot(r){if(v.value!==!1)return;const f=w.value,q=W(r.distance.x,0,f);if(r.isFinal===!0){q>=Math.min(75,f)===!0?J():(l.animate(),H(0),P(E.value*f)),j.value=!1;return}P((i.lang.rtl===!0?T.value!==!0:T.value)?Math.max(f-q,0):Math.min(0,q-f)),H(W(q/f,0,1)),r.isFirst===!0&&(j.value=!0)}function Te(r){if(v.value!==!0)return;const f=w.value,q=r.direction===e.side,le=(i.lang.rtl===!0?q!==!0:q)?W(r.distance.x,0,f):0;if(r.isFinal===!0){Math.abs(le)<Math.min(75,f)===!0?(l.animate(),H(1),P(0)):N(),j.value=!1;return}P(E.value*le),H(W(1-le/f,0,1)),r.isFirst===!0&&(j.value=!0)}function he(){a(!1),fe(!0)}function F(r,f){l.update(e.side,r,f)}function it(r,f){r.value!==f&&(r.value=f)}function me(r,f){F("size",r===!0?e.miniWidth:f)}return l.instances[e.side]=Q,me(e.miniToOverlay,w.value),F("space",m.value),F("offset",n.value),e.showIfAbove===!0&&e.modelValue!==!0&&v.value===!0&&e["onUpdate:modelValue"]!==void 0&&s("update:modelValue",!0),Tt(()=>{s("on-layout",m.value),s("mini-state",k.value),_=e.showIfAbove===!0;const r=()=>{(v.value===!0?g:A)(!1,!0)};if(l.totalWidth.value!==0){Ae(r);return}p=C(l.totalWidth,()=>{p(),p=void 0,v.value===!1&&e.showIfAbove===!0&&h.value===!1?J(!1):r()})}),Ye(()=>{p!==void 0&&p(),clearTimeout(z),v.value===!0&&he(),l.instances[e.side]===Q&&(l.instances[e.side]=void 0,F("size",0),F("offset",0),F("space",!1))}),()=>{const r=[];h.value===!0&&(e.noSwipeOpen===!1&&r.push(Be(B("div",{key:"open",class:`q-drawer__opener fixed-${e.side}`,"aria-hidden":"true"}),tt.value)),r.push(Ee("div",{ref:"backdrop",class:I.value,style:ce.value,"aria-hidden":"true",onClick:N},void 0,"backdrop",e.noSwipeBackdrop!==!0&&v.value===!0,()=>lt.value)));const f=k.value===!0&&o.mini!==void 0,q=[B("div",Y(M({},y),{key:""+f,class:[Ze.value,y.class]}),f===!0?o.mini():Mt(o.default))];return e.elevated===!0&&v.value===!0&&q.push(B("div",{class:"q-layout__shadow absolute-full overflow-hidden no-pointer-events"})),r.push(Ee("aside",{ref:"content",class:et.value,style:Ge.value},q,"contentclose",e.noSwipeClose!==!0&&h.value===!0,()=>at.value)),B("div",{class:"q-drawer-container"},r)}}});const Lt=ue("h4",{class:"title"},"Jury",-1),Vt={key:0,class:"fullwidth"},Wt=ne("Jurymitglied hinzuf\xFCgen"),Nt=ue("h4",{class:"title"},"Teilnehmende",-1),Qt={key:0},Ut=ue("h4",{class:"title"},"Project",-1),Rt={class:"fullwidth"},Jt=xt({props:{view:null},emits:["change:selection","change:selectproject"],setup(e,{emit:o}){const s=e,{view:y}=jt(s),t=Dt(),i=$t(),{users:u}=He(t),{projects:a}=He(i);let b=S(1);const l=d(()=>b.value);function _(v){o("change:selection",v),b.value=v.id}function z(v){o("change:selectproject",v),b.value=v.id}function p(){const v={id:0,name:"",surname:"",role:"jury",email:"",land:"",plz:null,ortschaft:"",str:"",strNr:null,vorwahl:"",tel:null};u.value.push(v),o("change:selection",v)}async function h(){t.getUsers()}async function k(){i.getProjects()}function w(){(y==null?void 0:y.value)=="User"?h():k()}return w(),(v,X)=>(O(),pe(Ft,{"show-if-above":"",width:300,breakpoint:700,elevated:"",bordered:""},{default:x(()=>[R(Ht,{class:"fit"},{default:x(()=>[L(y)==="User"?(O(),pe(Fe,{key:0,bordered:""},{default:x(()=>[R(Le,{color:"q-primary",class:"fullwitdh"},{default:x(()=>[Lt]),_:1}),(O(!0),V(ze,null,Se(L(u),g=>(O(),V("div",{key:g.id},[g.role==="jury"?(O(),V("div",Vt,[R(oe,{id:g.id,class:"fullwitdh",style:we([L(l)===g.id?{background:"#09deed"}:{background:"#37ed09"}]),bordered:"",onClick:A=>_(g)},{default:x(()=>[ne(_e(g.surname+" "+g.name),1)]),_:2},1032,["id","style","onClick"])])):ie("",!0)]))),128)),R(oe,{class:"fullwitdh btn",color:"primary",onClick:p},{default:x(()=>[Wt]),_:1}),Nt,(O(!0),V(ze,null,Se(L(u),g=>(O(),V("div",{key:g.id,class:"fullwidth"},[g.role==="teilnehmende"?(O(),V("div",Qt,[R(oe,{class:"fullwitdh",style:we([L(l)===g.id?{background:"#09deed"}:{background:"#37ed09"}]),onClick:A=>_(g)},{default:x(()=>[ne(_e(g.surname+" "+g.name),1)]),_:2},1032,["style","onClick"])])):ie("",!0)]))),128))]),_:1})):ie("",!0),L(y)==="Project"?(O(),pe(Fe,{key:1,bordered:""},{default:x(()=>[R(Le,{color:"q-primary",class:"fullwitdh"},{default:x(()=>[Ut]),_:1}),(O(!0),V(ze,null,Se(L(a),g=>(O(),V("div",{key:g.id},[ue("div",Rt,[R(oe,{class:"fullwitdh",bordered:"",style:we([L(l)===g.id?{background:"#09deed"}:{background:"#37ed09"}]),onClick:A=>z(g)},{default:x(()=>[ne(_e(g.id),1)]),_:2},1032,["style","onClick"])])]))),128))]),_:1})):ie("",!0)]),_:1})]),_:1}))}});export{Jt as _};
