(this.webpackJsonpkodseged=this.webpackJsonpkodseged||[]).push([[0],{107:function(e,t,n){e.exports=n(456)},112:function(e,t,n){},36:function(e,t,n){},406:function(e,t){},408:function(e,t){},427:function(e,t){},456:function(e,t,n){"use strict";n.r(t);var a=n(0),r=n.n(a),c=n(99),o=n.n(c),i=(n(112),n(36),n(113),n(12)),l=n(5),s=n.n(l),u=n(3),f=n(10),m=n(2),d=n(461),b=n(460),p=n(115);function v(e){var t=e.assistantContainerHeight,n=e.channel,c=e.fontSize,o=e.fileChanges,l=e.videoStateChanged,s=e.explicitelyActive,f=e.setExplicitelyActive,d=e.isFollowingEnabled,b=e.setFollowingEnabled,v=e.getCurrentTime,g=e.active,O=e.setActive,E=Object(a.useRef)({}),y=Object(a.useState)({}),k=Object(m.a)(y,2),x=k[0],w=k[1],N=Object(a.useState)(),C=Object(m.a)(N,2),S=C[0],A=C[1],L=Object(a.useRef)(j()+"-code-container");Object(a.useEffect)((function(){E.current=o.filter((function(e){return 0===e.timestamp})).reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.fileName,t))}),{}),Object.keys(E.current)[0]&&(w(E.current),A(!0))}),[]),Object(a.useEffect)((function(){O(Object.keys(E.current).reduceRight((function(e,t){return t}),""))}),[S]),Object(a.useEffect)((function(){for(var e,t,n=Object.keys(o.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.fileName,t))}),{})),a=v(),r={},c=function(){var e=s[l],t=o.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<a}));if(!t.length)return"continue";var n=t.pop();r[e]=n},l=0,s=n;l<s.length;l++)c();E.current=Object(u.a)({},r);for(var m=0,d=Object.values(r);m<d.length;m++){var p=d[m];p.timestamp<t||(t=p.timestamp,e=p.fileName)}O(e),f(""),b(!0),R.current=!0}),[l]),Object(a.useEffect)((function(){setTimeout((function(){n.postMessage({event:"init",payload:{files:E.current,active:g}})}),100)}),[l]),Object(a.useEffect)((function(){n.onmessage=function(e){"clientConnected"===e.data.event&&n.postMessage({event:"init",payload:{files:E.current,active:g}})}}),[]);var I=Object(a.useRef)(1);Object(a.useEffect)((function(){setTimeout((function(){n.postMessage({event:"refresh",payload:{files:E.current,active:g,changedLine:I.current}})}),100)}),[x]);var R=Object(a.useRef)(!0);Object(a.useEffect)((function(){R.current=d}),[d]),Object(a.useEffect)((function(){d?B():Array.from(document.querySelectorAll(".linenumber")).forEach((function(e){return e.parentElement.style.backgroundColor=""}))}),[d]),Object(a.useEffect)((function(){var e=setInterval(H,50);return function(){clearInterval(e)}}),[]);var F=Object(a.useState)(0),T=Object(m.a)(F,2),U=T[0],M=T[1],B=function(){var e=document.getElementById(L.current),n=Array.from(e.querySelectorAll(".linenumber")),a=n.filter((function(e){return parseInt(e.innerHTML)===I.current})).pop();a&&(n.forEach((function(e){return e.parentElement.style.backgroundColor=""})),a.parentElement.style.backgroundColor="#555",setTimeout((function(){a.parentElement.style.backgroundColor="#333"}),200),e.scroll({top:a.offsetTop-t/2.7,behavior:"smooth"}))};function H(){var e=v(),t=o.filter((function(t){return t.timestamp<e}));if(t.length){var n=t.pop();R.current&&(I.current=function(e,t){var n;if(!(null===(n=t[e.fileName])||void 0===n?void 0:n.content))return;var a=new p(t[e.fileName].content,e.content).changes.filter((function(e){return e.changes>0}));if(!a[0])return;return a[0].lineno}(n,E.current),M((function(e){return e+1}))),E.current=Object(u.a)(Object(u.a)({},E.current),{},Object(i.a)({},n.fileName,n)),w(E.current),O(n.fileName)}}Object(a.useEffect)(B,[U]);var V=s||g;return r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"scrollbar-hidden border-bottom border-dark",style:{background:"linear-gradient(90deg, #23241F, #161616)",display:"flex",flexDirection:"row"}},Object.entries(E.current).map((function(e,t){var n=Object(m.a)(e,2),a=n[0];n[1];return r.a.createElement("div",{key:a,className:"text-center p-2 w-100 scrollbar-hidden",style:{background:V===a?"black":"rgb(35, 36, 31)",color:V===a?"white":"grey",display:"flex",flexDirection:"column",justifyContent:"space-evenly",cursor:"pointer",borderRight:t===Object.entries(E.current).length-1?"":"1px solid #333",overflowX:"scroll"},onClick:function(){(g!==a||s)&&(b(!1),f(a))}},a)}))),r.a.createElement("div",{id:L.current,style:{background:"linear-gradient(90deg, #23241F, #161616)",overflow:"scroll",height:t-45},className:"scrollbar-hidden"},Object.entries(E.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return V===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return r.a.createElement("div",{key:n,className:"font-family-monospace scrollbar-hidden"},h(c,a.languageName,a.content))}))))}var g={phtml:"php",htaccess:"apacheconf",Dockerfile:"dockerfile",parancsok:"shellsession"};function h(e,t,n){return r.a.createElement(d.a,{customStyle:{fontSize:e,background:"linear-gradient(90deg, #23241F, #171717)"},codeTagProps:{style:{lineHeight:"inherit",fontSize:"inherit"}},showLineNumbers:!0,wrapLines:!0,lineProps:{style:{paddingBottom:3,paddingTop:3}},style:b.a,language:g[t]?g[t]:t},n)}function j(){return"xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,(function(e){var t=16*Math.random()|0;return("x"==e?t:3&t|8).toString(16)}))}var O=n(7),E=n(8),y=n(15),k={inline:"offset-md-8 col-md-4",block:"col-md-12",inlineWide:"col-md-12"};function x(e){var t=e.setFontSize,n=e.currentLayout,c=e.setExplicitelyActive,o=e.active,i=e.isFollowingEnabled,l=e.setFollowingEnabled,s=e.channel;return r.a.createElement("div",{style:{background:"linear-gradient(90deg, #23241F, #161616)"},className:k[n]},r.a.createElement(a.Fragment,null,s.noop?"":r.a.createElement("button",{className:"btn btn-sm btn-outline-warning d-inline-block m-1",onClick:function(){Object.assign(document.createElement("a"),{target:"_blank",href:"/kodseged-kliens?isFullPageClientApp=1"}).click()},"data-tip":"T\xf6bb k\xe9perny\u0151s megjelen\xedt\xe9s"},r.a.createElement(O.a,{icon:E.h}),r.a.createElement(y.a,{place:"bottom",type:"dark",effect:"float"})),r.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},r.a.createElement(O.a,{icon:E.c}),r.a.createElement("small",null,r.a.createElement(O.a,{icon:E.a})),r.a.createElement(y.a,{place:"bottom",type:"dark",effect:"float"})),r.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},r.a.createElement(O.a,{icon:E.c}),r.a.createElement("small",null,r.a.createElement(O.a,{icon:E.b})),r.a.createElement(y.a,{place:"bottom",type:"dark",effect:"float"})),r.a.createElement("div",{className:"d-inline-block"},i?r.a.createElement("button",{className:"btn btn-sm btn-outline-success m-1",onClick:function(){c(o),l(!1)},"data-tip":"K\xf6vet\xe9s kikapcsol\xe1sa"},r.a.createElement(O.a,{icon:E.f}),r.a.createElement(y.a,{place:"bottom",type:"dark",effect:"float"})):r.a.createElement("button",{className:"btn btn-sm btn-outline-danger m-1",onClick:function(){c(""),l(!0)},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},r.a.createElement(O.a,{icon:E.e}),r.a.createElement(y.a,{place:"bottom",type:"dark",effect:"float"})))))}function w(e){var t=e.fileChangesURL,n=e.videoURL,c=e.layout,o=Object(a.useState)([]),i=Object(m.a)(o,2),l=i[0],d=i[1],b=Object(a.useState)(""),p=Object(m.a)(b,2),v=p[0],g=p[1],h=Object(a.useState)(!1),j=Object(m.a)(h,2),O=j[0],E=j[1],y=Object(a.useState)(16),k=Object(m.a)(y,2),w=k[0],C=k[1],S=Object(a.useState)(),A=Object(m.a)(S,2),L=A[0],I=A[1],R=r.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);Object(a.useEffect)((function(){I(c)}),[]),Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n,a;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if(n=e.sent){e.next=5;break}return e.abrupt("return");case 5:if(n.ok){e.next=7;break}return e.abrupt("return");case 7:return e.next=9,n.json().catch(console.log);case 9:if(a=e.sent){e.next=12;break}return e.abrupt("return");case 12:d(a.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:_(e.fileName)})})));case 13:case"end":return e.stop()}}),e)})))()}),[]);var F=Object(a.useRef)(),T=Object(a.useState)(!1),U=Object(m.a)(T,2),M=(U[0],U[1]);return l.length?r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"container-fluid"},r.a.createElement("div",{className:"row"},r.a.createElement("div",{className:("inline"===L?"col-md-8":"col-md-12")+" p-0 pr-1"},r.a.createElement("video",{onLoadedData:function(){M(!0)},className:"w-100",id:"video",src:n,controls:!0,width:"100%",crossOrigin:"anonymous",ref:F})),F.current?r.a.createElement(N,{channel:R,fontSize:w,isVisible:O,className:"w-100",fileChanges:l,explicitelyActive:v,setExplicitelyActive:g,currentLayout:L,videoReference:F}):""),r.a.createElement("div",{className:"row"},r.a.createElement("div",{className:"col-md-12 p-0",style:{backgroundColor:"rgb(35, 36, 31)"}},r.a.createElement(x,{setFontSize:C,currentLayout:L,setCurrentLayout:I,isVisible:O,setVisible:E,explicitelyActive:v,setExplicitelyActive:g}))))):r.a.createElement("div",{className:"text-center"},"Bet\xf6lt\xe9s...")}function N(e){var t=e.fileChanges,n=e.videoReference,c=e.currentLayout,o=e.channel,l=e.explicitelyActive,s=e.setExplicitelyActive,f=e.fontSize,d=e.isVisible,b=Object(a.useRef)({}),p=Object(a.useState)({}),v=Object(m.a)(p,2),g=v[0],j=v[1],O=Object(a.useState)(""),E=Object(m.a)(O,2),y=E[0],k=E[1],x=Object(a.useRef)();function w(){var e;if(n.current){var a=t.filter((function(e){return e.timestamp<n.current.currentTime}));if(a.length){var r=a.pop();(null===(e=b.current[r.fileName])||void 0===e?void 0:e.content)!==r.content&&(b.current=Object(u.a)(Object(u.a)({},b.current),{},Object(i.a)({},r.fileName,r)),j(b.current),k(r.fileName))}}}if(Object(a.useEffect)((function(){return x.current=setInterval(w,50),function(){clearInterval(x.current)}}),[]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){w(),setTimeout((function(){o.postMessage({event:"init",payload:{files:b.current,active:y}})}),100)}))}),[]),Object(a.useEffect)((function(){o.onmessage=function(e){"clientConnected"===e.data.event&&o.postMessage({event:"init",payload:{files:b.current,active:y}})}}),[]),Object(a.useEffect)((function(){setTimeout((function(){o.postMessage({event:"refresh",payload:{files:b.current,active:y}})}),100)}),[g]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){for(var e,a,r=Object.keys(t.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.fileName,t))}),{})),c={},o=function(){var e=f[l],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<n.current.currentTime}));if(!a.length)return"continue";var r=a.pop();c[e]=r},l=0,f=r;l<f.length;l++)o();b.current=c;for(var m=0,d=Object.values(c);m<d.length;m++){var p=d[m];p.timestamp<a||(a=p.timestamp,e=p.fileName)}k(e),s("")}))}),[]),d)return"";var N=l||y;return r.a.createElement("div",{className:("inline"===c?"col-md-4":"col-md-12")+" p-0",style:{height:n.current.clientHeight,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(b.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return r.a.createElement("div",{key:n,className:"text-center",style:{backgroundColor:N===n?"black":"rgb(35, 36, 31)",color:N===n?"white":"grey",width:parseInt(100/Object.values(b.current).length)+"%",borderBottom:"1px solid lightgrey",height:"30px",display:"inline-block",cursor:"pointer"},onClick:function(){(y!==n||l)&&s(n)}},n)})),r.a.createElement("div",{className:"overflow-auto"},Object.entries(b.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return N===n})).map((function(e){var t=Object(m.a)(e,2),a=t[0],c=t[1];return r.a.createElement("div",{style:{height:n.current.clientHeight-30-(l?45:0)},key:a,className:"font-family-monospace"},h(f,c.languageName,c.content))}))))}var C=n(34);function S(e){var t,n,c=e.fileChangesURL,o=e.videoId,i=e.layout,l=e.wrapperClassName,d=Object(a.useRef)(),b=Object(a.useState)(),p=Object(m.a)(b,2),g=p[0],h=p[1],j=Object(a.useState)(0),O=Object(m.a)(j,2),E=O[0],y=O[1],k=Object(a.useState)(),w=Object(m.a)(k,2),N=w[0],S=w[1],L=Object(a.useState)(""),I=Object(m.a)(L,2),R=I[0],F=I[1],T=Object(a.useState)(!0),U=Object(m.a)(T,2),M=U[0],B=U[1],H=Object(a.useState)(!1),V=Object(m.a)(H,2),D=V[0],z=V[1],P=Object(a.useState)(16),W=Object(m.a)(P,2),K=W[0],q=W[1];try{n=new BroadcastChannel("codeAssistant")}catch(Q){n={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}r.a.useMemo((function(){return n}),[]),r.a.useEffect((function(){return n.onmessage=function(e){"clientClosed"===e.data.event&&z(!1)},n.close}),[]),Object(a.useEffect)((function(){S(i)}),[]),Object(a.useEffect)((function(){var e=document.querySelector(".".concat(l));e&&("inline"===N?(e.classList.add("kodseged-inline"),e.classList.remove("kodseged-block")):(e.classList.add("kodseged-block"),e.classList.remove("kodseged-inline")))}),[N]);var J=Object(a.useState)([]),Y=Object(m.a)(J,2),G=Y[0],X=Y[1];Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t,n;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(c).catch(console.log);case 2:if(!(t=e.sent)||t.ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,t.json().catch(console.log);case 7:if((n=e.sent).length){e.next=10;break}return e.abrupt("return");case 10:X(n.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:_(e.fileName)})})));case 11:case"end":return e.stop()}}),e)})))()}),[]);var $=Object(a.useRef)();return G.length?r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"container-fluid"},r.a.createElement("div",{className:"row"},r.a.createElement("div",{ref:$,className:("inline"===N?"col-md-8":"col-md-12")+" p-0"},r.a.createElement(C.a,{opts:{width:"100%"},videoId:o,onReady:function(e){d.current=e.target,h(1)},onStateChange:function(e){2===e.data&&y((function(e){return e+1}))}})),r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"col-md-12 p-0 border-right border-dark",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},g?r.a.createElement(v,{assistantContainerHeight:null===(t=$.current)||void 0===t?void 0:t.clientHeight,containerRef:$,fontSize:K,channel:n,isVisible:D,className:"w-100",fileChanges:G,videoStateChanged:E,currentLayout:N,setCurrentLayout:S,setExplicitelyActive:F,setFollowingEnabled:B,explicitelyActive:R,getCurrentTime:function(){return d.current.getCurrentTime()}}):A(N)))),r.a.createElement(x,{setFontSize:q,currentLayout:N,setCurrentLayout:S,isVisible:D,setVisible:z,explicitelyActive:R,setExplicitelyActive:F,isFollowingEnabled:M,setFollowingEnabled:B,channel:n}))):r.a.createElement("div",{style:{marginTop:50,marginBottom:50}},A(i))}function A(e){return r.a.createElement("div",{className:"inline"===e?"col-md-4":"col-md-12 text-center"},r.a.createElement("div",{className:"spinner-border text-info",style:{width:"3rem",height:"3rem"}},r.a.createElement("span",{className:"sr-only"},"Bet\xf6lt\xe9s...")))}var L=n(19),I=n.n(L),R=n(73);function F(e){var t=e.gifUrl,n=Object(a.useState)([]),c=Object(m.a)(n,2),o=c[0],i=c[1],l=Object(a.useState)(!0),d=Object(m.a)(l,2),b=d[0],p=d[1],v=Object(a.useRef)([]),g=Object(a.useRef)(2);Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return p(!0),e.next=3,R({url:t,frames:"all",outputType:"canvas",cumulative:!0});case 3:n=e.sent,p(!1),g.current=n.length,v.current=n,E({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var h=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(u.a)(Object(u.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),j=Object(m.a)(h,2),O=j[0],E=j[1];return Object(a.useEffect)((function(){v.current[0]&&(i((function(e){return v.current[0]?e.concat([v.current[0].getImage()]):e})),v.current.shift(),setTimeout((function(){E({type:"UPDATE"})}),0))}),[O.calcCount]),b?A("block"):o.length>0?r.a.createElement(T,{frames:o,total:g.current,calcCount:O.calcCount}):""}function T(e){var t=e.frames,n=e.total,c=e.calcCount,o=Object(a.createRef)(),i=Object(a.useState)(0),l=Object(m.a)(i,2),s=l[0],u=l[1],f=Object(a.useRef)(),d=Object(a.useState)(!1),b=Object(m.a)(d,2),p=b[0],v=b[1];return Object(a.useEffect)((function(){if(o.current&&!p){var e=f.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;o.current.width=n.width*a,o.current.height=n.height*a,o.current.getContext("2d").scale(a,a),o.current.getContext("2d").drawImage(n,0,0),v(!0)}}),[o]),Object(a.useEffect)((function(){if(void 0!==t[s]){var e=t[s],n=f.current.offsetWidth,a=n/e.width<1?n/e.width:1;o.current.width=e.width*a,o.current.height=e.height*a,o.current.getContext("2d").scale(a,a),o.current.getContext("2d").drawImage(e,0,0)}}),[s]),t.length?r.a.createElement("div",{className:"text-center",ref:f},r.a.createElement("canvas",{className:"text-center m-auto",ref:o}),r.a.createElement("div",{className:"main-scroller"},r.a.createElement(I.a,{formatLabel:function(){return""},minValue:0,maxValue:n-1,value:s,onChange:function(e){e>c||u(e)}})),r.a.createElement("div",{className:"buffer-indicator-track"},r.a.createElement(I.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:n+1,value:c,onChange:function(){}}))):""}var U=n(73);function M(e){var t=e.fileChangesURL,n=e.gifUrl,c=e.showFrameNumber,o=e.layout,l=Object(a.useState)([]),d=Object(m.a)(l,2),b=d[0],p=d[1],v=Object(a.useState)(!0),g=Object(m.a)(v,2),h=g[0],j=g[1],O=Object(a.useState)([]),E=Object(m.a)(O,2),y=E[0],k=E[1],x=Object(a.useRef)([]),w=Object(a.useRef)(1);Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return j(!0),e.next=3,U({url:n,frames:"all",outputType:"canvas",cumulative:!0});case 3:t=e.sent,j(!1),w.current=t.length,x.current=t,L({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var N=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(u.a)(Object(u.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),C=Object(m.a)(N,2),S=C[0],L=C[1];return Object(a.useEffect)((function(){x.current[0]&&(k((function(e){return x.current[0]?e.concat([x.current[0].getImage()]):e})),x.current.shift(),setTimeout((function(){L({type:"UPDATE"})}),0))}),[S.calcCount]),Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n,a,r,c,o;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if((n=e.sent).ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,n.text();case 7:a=e.sent,r=new DOMParser,c=r.parseFromString(a,"text/xml"),o=Array.from(c.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.localName,"frame"===t.localName?parseInt(t.innerHTML):t.innerHTML))}),{})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})),p(o.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:_(e.fileName)})})));case 12:case"end":return e.stop()}}),e)})))()}),[]),h?A("block"):y.length>0?r.a.createElement(B,{frames:y,fileChanges:b,showFrameNumber:c,layout:o,total:w.current,calcCount:S.calcCount}):""}function B(e){var t=e.frames,n=e.fileChanges,c=e.showFrameNumber,o=e.layout,i=e.total,l=e.calcCount,s=Object(a.createRef)(),u=Object(a.useState)(0),f=Object(m.a)(u,2),d=f[0],b=f[1],p=Object(a.useRef)(),v=Object(a.useState)(0),g=Object(m.a)(v,2),h=g[0],j=g[1],O=Object(a.useState)(!1),E=Object(m.a)(O,2),y=E[0],k=E[1];return Object(a.useEffect)((function(){j(p.current.offsetHeight)}),[p.current]),Object(a.useEffect)((function(){if(s.current&&!y){var e=p.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;s.current.width=n.width*a,s.current.height=n.height*a,s.current.getContext("2d").scale(a,a),s.current.getContext("2d").drawImage(n,0,0),k(!0)}}),[s]),Object(a.useEffect)((function(){if(t[d]){var e=t[d],n=p.current.offsetWidth,a=n/e.width<1?n/e.width:1;s.current.width=e.width*a,s.current.height=e.height*a,s.current.getContext("2d").scale(a,a),s.current.getContext("2d").drawImage(e,0,0)}}),[d]),"inline"===o?r.a.createElement("div",{className:"row"},r.a.createElement("div",{className:"col-md-7 p-0 mb-5",ref:p},r.a.createElement("canvas",{ref:s}),r.a.createElement("div",{className:"main-scroller"},i-1>0?r.a.createElement(I.a,{formatLabel:function(e){return c?e:""},minValue:0,maxValue:i-1,value:d,onChange:function(e){e>l||b(e)}}):""),r.a.createElement("div",{className:"buffer-indicator-track"},r.a.createElement(I.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:i+1,value:l,onChange:function(){}}))),r.a.createElement("div",{className:"col-md-5 p-0 m-0"},p.current?r.a.createElement(H,{fileChanges:n,frame:d,height:h}):"")):void 0!==t.length?r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"text-center mb-5",ref:p},r.a.createElement("canvas",{ref:s}),r.a.createElement("div",{className:"main-scroller"},i-1>0?r.a.createElement(I.a,{formatLabel:function(e){return c?e:""},minValue:0,maxValue:i-1,value:d,onChange:function(e){e>l||b(e)}}):""),r.a.createElement("div",{className:"buffer-indicator-track"},r.a.createElement(I.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:i+1,value:l,onChange:function(){}}))),p.current?r.a.createElement(H,{fileChanges:n,frame:d,height:h}):""):""}function H(e){var t=e.fileChanges,n=e.frame,c=e.height,o=Object(a.useRef)({}),l=Object(a.useState)({}),s=Object(m.a)(l,2),f=(s[0],s[1],Object(a.useState)("")),d=Object(m.a)(f,2),b=d[0],p=d[1],v=Object(a.useState)(""),g=Object(m.a)(v,2),j=g[0],O=g[1];Object(a.useEffect)((function(){O("");for(var e,a,r=Object.keys(t.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.fileName,t))}),{})),c={},l=function(){var e=f[s],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.frame<n}));if(!a.length)return"continue";var r=a.pop();c[e]=r},s=0,f=r;s<f.length;s++)l();o.current=c;for(var m=0,d=Object.values(c);m<d.length;m++){var b=d[m];b.frame<a||(a=b.frame,e=b.fileName)}p(e)}),[n]);var E=j||b;return r.a.createElement("div",{className:"col-md-12 p-0 overflow-auto",style:{height:c,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(o.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return r.a.createElement("div",{key:n,className:"text-center p-2",style:{backgroundColor:E===n?"black":"rgb(35, 36, 31)",color:E===n?"white":"grey",width:parseInt(100/Object.values(o.current).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(b!==n||j)&&O(n)}},n)})),Object.entries(o.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return E===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return r.a.createElement("div",{key:n,className:"font-family-monospace"},h(20,a.languageName,a.content))})))}function V(e){var t=e.videoId;return r.a.createElement("div",{className:"container-fluid"},r.a.createElement("div",{className:"row"},r.a.createElement("div",{className:"col-md-12 p-0"},r.a.createElement("div",{className:"text-center m-auto",style:{maxWidth:"720px"}},r.a.createElement(C.a,{opts:{width:"100%"},videoId:t})))))}function D(){var e=Object(a.useState)({}),t=Object(m.a)(e,2),n=t[0],c=t[1],o=Object(a.useState)(""),i=Object(m.a)(o,2),l=i[0],s=i[1],u=Object(a.useState)(16),f=Object(m.a)(u,2),d=f[0],b=f[1],p=Object(a.useState)(""),v=Object(m.a)(p,2),g=v[0],j=v[1],k=Object(a.useState)(0),x=Object(m.a)(k,2),w=x[0],N=x[1],C=Object(a.useRef)(1),S=r.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);r.a.useEffect((function(){S.postMessage({event:"clientConnected"}),S.onmessage=function(e){var t={refresh:function(e){c(e.files);var t=e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop();g||s(t),C.current=e.changedLine,N((function(e){return e+1}))},init:function(e){c(e.files),j(""),s(e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop())}}[e.data.event];t&&t(e.data.payload)}}),[]),Object(a.useEffect)((function(){if(!g){var e=Array.from(document.querySelectorAll(".linenumber")),t=e.filter((function(e){return parseInt(e.innerHTML)===C.current})).pop();if(t){e.forEach((function(e){return e.parentElement.style.backgroundColor=""})),t.parentElement.style.backgroundColor="#555",setTimeout((function(){t.parentElement.style.backgroundColor="#333"}),200);var n=Math.max(document.documentElement.clientHeight||0,window.innerHeight||0);window.scroll({top:t.offsetTop-n/2.7,behavior:"smooth"})}}}),[w]),Object(a.useEffect)((function(){g&&Array.from(document.querySelectorAll(".linenumber")).forEach((function(e){return e.parentElement.style.backgroundColor=""}))}),[g]);var A=g||l;return r.a.createElement("div",{className:"col-md-12 p-0 w-100 mt-5",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},r.a.createElement("div",{className:"w-100 fixed-top"},Object.entries(n).map((function(e){var t=Object(m.a)(e,2),a=t[0];t[1];return r.a.createElement("div",{key:a,className:"text-center p-2",style:{backgroundColor:A===a?"black":"rgb(35, 36, 31)",color:A===a?"white":"grey",width:parseInt(100/Object.values(n).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(l!==a||g)&&j(a)}},a)}))),r.a.createElement("div",{className:"overflow-auto",id:"code-container"},Object.entries(n).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return A===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return r.a.createElement("div",{key:n,className:"font-family-monospace"},h(d,a.languageName,a.content))}))),r.a.createElement("div",{className:"row p-3"},r.a.createElement("div",{className:"btn-group fixed-bottom w-25"},r.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){b((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},r.a.createElement(O.a,{icon:E.c}),r.a.createElement("small",null,r.a.createElement(O.a,{icon:E.a})),r.a.createElement(y.a,{place:"top",type:"dark",effect:"float"})),r.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){b((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},r.a.createElement(O.a,{icon:E.c}),r.a.createElement("small",null,r.a.createElement(O.a,{icon:E.b})),r.a.createElement(y.a,{place:"top",type:"dark",effect:"float"})),r.a.createElement("button",{className:"btn btn-sm btn-danger m-1",onClick:function(){S.postMessage({event:"clientClosed"}),window.close()},"data-tip":"Bez\xe1r\xe1s"},r.a.createElement(O.a,{icon:E.d}),r.a.createElement(y.a,{place:"top",type:"dark",effect:"float"})),g?r.a.createElement("button",{className:"btn btn-sm btn-danger m-1",onClick:function(){j("")},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},r.a.createElement(O.a,{icon:E.f}),r.a.createElement(y.a,{place:"top",type:"dark",effect:"float"})):r.a.createElement("button",{className:"btn btn-sm btn-success m-1",onClick:function(){j(l)},"data-tip":"K\xf6vet\xe9s kikapcsol\xe1sa"},r.a.createElement(O.a,{icon:E.e}),r.a.createElement(y.a,{place:"top",type:"dark",effect:"float"})))))}var z=n(35),P=n(55),W=n.n(P);function K(e){var t=e.embeddableId,n=e.currentLayout,c=e.assistantContainerHeight,o=Object(a.useState)(!1),i=Object(m.a)(o,2),l=i[0],u=i[1],d=Object(a.useState)([]),b=Object(m.a)(d,2),p=b[0],v=b[1],g=Object(a.useRef)(j()+"-comment-container");function h(){return O.apply(this,arguments)}function O(){return(O=Object(f.a)(s.a.mark((function e(){var n,a;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch("".concat("","/api/comments?from=0&limit=1000&filters=").concat(JSON.stringify({key:"embeddableId",operator:"eq",value:t}),"&orderBy=").concat(JSON.stringify({key:"createdAt",value:"asc"}))).catch(console.log);case 2:if(!(n=e.sent)||n.ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,n.json();case 7:a=e.sent,v(a.results);case 9:case"end":return e.stop()}}),e)})))).apply(this,arguments)}Object(a.useEffect)((function(){var e=document.getElementById(g.current);e&&!l&&e.scroll({top:e.scrollHeight,behavior:"smooth"})}),[l]),Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return u(!0),e.next=3,h();case 3:u(!1);case 4:case"end":return e.stop()}}),e)})))()}),[]);return r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:{inline:"col-md-12",block:"col-md-4",inlineWide:"col-md-12"}[n]+" w-100 p-0",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},r.a.createElement("div",{className:"text-center text-white border-bottom border-dark p-2",style:{background:"black",display:"flex",flexDirection:"column",justifyContent:"space-evenly",borderRight:"1px solid #333"}},"K\xe9rd\xe9sek \xe9s v\xe1laszok:"),r.a.createElement("div",{id:g.current,className:"p-2 scrollbar-hidden",style:{height:c,overflowY:"scroll"}},l?r.a.createElement("div",{className:"w-100 text-center",style:{marginTop:c/2-20}},r.a.createElement("div",{className:"spinner-grow m-auto text-info",style:{width:"3rem",height:"3rem"}},r.a.createElement("span",{className:"sr-only"},"Loading..."))):p.length?p.map((function(e,t){return r.a.createElement(a.Fragment,{key:e.id},r.a.createElement(q,{comment:e}),t!==p.length-1?r.a.createElement("hr",{className:"border-dark m-2"}):"")})):r.a.createElement("div",{className:"w-100 text-center",style:{marginTop:c/2-50}},r.a.createElement("h1",null,"M\xe9g nem \xe9rkezett k\xe9rd\xe9s")))),r.a.createElement("div",{className:"mb-2 p-2 w-100",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},r.a.createElement("form",{onSubmit:function(){var e=Object(f.a)(s.a.mark((function e(n){var a,r,c,o;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return n.preventDefault(),r=n.target.elements.content.value,n.target.reset(),c=null!==(a=localStorage.getItem("commentAuthorKey"))&&void 0!==a?a:J(),u(!0),e.next=7,fetch("".concat("","/api/comments"),{body:JSON.stringify({key:c,content:r,embeddableId:t}),method:"POST"}).catch(console.log);case 7:if(!(o=e.sent)||o.ok){e.next=10;break}return e.abrupt("return");case 10:return e.next=12,h();case 12:u(!1);case 13:case"end":return e.stop()}}),e)})));return function(t){return e.apply(this,arguments)}}()},r.a.createElement("textarea",{name:"content",style:{background:"linear-gradient(90deg, #23241F, #161616)"},placeholder:"K\xe9rd\xe9sed vagy v\xe1laszod van? \xcdrd ide...",className:"form-control text-white border border-secondary mb-2",rows:"6"}),r.a.createElement("button",{className:"btn btn-success"},"K\xfcld\xe9s"))))}function q(e){var t=e.comment;return r.a.createElement("div",{className:"p-2 rounded",style:{backgroundColor:Y(t.key,-60),border:"1px solid "+t.key}},r.a.createElement("span",{className:"text-left text-white"},r.a.createElement(O.a,{icon:E.g,className:"mr-2",style:{color:t.key}}),t.content),r.a.createElement("br",null))}function J(){for(var e="#",t=0;t<6;t++)e+="0123456789ABCDEF"[Math.floor(16*Math.random())];return localStorage.setItem("commentAuthorKey",e),e}function Y(e,t){var n=parseInt(e.substring(1,3),16),a=parseInt(e.substring(3,5),16),r=parseInt(e.substring(5,7),16);return n=parseInt(n*(100+t)/100),a=(a=parseInt(a*(100+t)/100))<255?a:255,r=(r=parseInt(r*(100+t)/100))<255?r:255,"#"+(1==(n=n<255?n:255).toString(16).length?"0"+n.toString(16):n.toString(16))+(1==a.toString(16).length?"0"+a.toString(16):a.toString(16))+(1==r.toString(16).length?"0"+r.toString(16):r.toString(16))}function G(e){var t,n=e.embeddableId,c=e.fileChangesURL,o=e.videoId,l=e.layout,d=e.wrapperClassName,b=e.isAutoplay,p=Object(a.useState)(),g=Object(m.a)(p,2),h=g[0],j=g[1],O=Object(a.useState)(0),E=Object(m.a)(O,2),y=E[0],k=E[1],w=Object(a.useState)(),N=Object(m.a)(w,2),C=N[0],S=N[1],L=Object(a.useState)(""),I=Object(m.a)(L,2),R=I[0],F=I[1],T=Object(a.useState)(!0),U=Object(m.a)(T,2),M=U[0],B=U[1],H=Object(a.useState)(14),V=Object(m.a)(H,2),D=V[0],P=V[1];try{t=new BroadcastChannel("codeAssistant")}catch(se){t={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}r.a.useMemo((function(){return t}),[]),Object(a.useEffect)((function(){S(l)}),[]);var q={inline:"kodseged-inline",block:"kodseged-block",inlineWide:"kodseged-inline-wide"};Object(a.useEffect)((function(){var e=document.querySelector(".".concat(d));e&&(Object.values(q).forEach((function(t){e.classList.remove(t)})),q[C]&&e.classList.add(q[C]))}),[C]);var J=Object(a.useState)([]),Y=Object(m.a)(J,2),G=Y[0],X=Y[1];function $(e){return Q.apply(this,arguments)}function Q(){return(Q=Object(f.a)(s.a.mark((function e(t){var n,a,r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.text();case 2:return n=e.sent,a=new DOMParser,r=a.parseFromString(n,"text/xml"),e.abrupt("return",Array.from(r.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(i.a)({},t.localName,t.innerHTML))}),{})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{timestamp:W()(e.timestamp,"mm:ss").diff(W()().startOf("day"),"seconds")})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("<![CDATA[\n","").replace("]]>","")})})));case 6:case"end":return e.stop()}}),e)})))).apply(this,arguments)}Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t,n,a,r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(c).catch(console.log);case 2:if(!(n=e.sent)||n.ok){e.next=5;break}return e.abrupt("return");case 5:if(a=Object.fromEntries(Array.from(n.headers.entries())),r=[],"application/xml"!==a["content-type"]){e.next=11;break}return e.next=10,$(n);case 10:r=e.sent;case 11:if("application/json"!==a["content-type"]){e.next=15;break}return e.next=14,n.json().catch(console.log);case 14:r=e.sent;case 15:if(null===(t=r)||void 0===t?void 0:t.length){e.next=17;break}return e.abrupt("return");case 17:X(r.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:_(e.fileName)})})));case 18:case"end":return e.stop()}}),e)})))()}),[]);var Z=Object(a.useRef)(),ee=Object(a.useRef)(0),te=Object(a.useState)(400),ne=Object(m.a)(te,2),ae=ne[0],re=ne[1];Object(a.useEffect)((function(){var e,t;(null===(e=Z.current)||void 0===e?void 0:e.clientHeight)&&re(null===(t=Z.current)||void 0===t?void 0:t.clientHeight)}),[h]),Object(a.useEffect)((function(){j(!0)}),[]);var ce=Object(a.useState)(""),oe=Object(m.a)(ce,2),ie=oe[0],le=oe[1];if(!G.length)return r.a.createElement("div",{className:"d-flex justify-content-center",style:{paddingTop:30,paddingBottom:30,backgroundColor:"rgb(35, 36, 31)"}},A(l));return r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:"container-fluid"},r.a.createElement("div",{className:"row"},r.a.createElement("div",{ref:Z,className:{inline:"col-md-8",block:"col-md-12",inlineWide:"col-md-4"}[C]+" p-0",style:{backgroundColor:"rgb(35, 36, 31)"}},r.a.createElement(z.a,{video:o,autoplay:b,responsive:!0,onReady:function(e){j(1)},onTimeUpdate:function(e){ee.current=e.seconds},onSeeked:function(e){k((function(e){return e+1}))}})),h?r.a.createElement(a.Fragment,null,r.a.createElement("div",{className:{inline:"col-md-4",block:"col-md-8",inlineWide:"col-md-8"}[C]+" p-0 border-right border-dark",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},r.a.createElement(v,{assistantContainerHeight:ae,fontSize:D,channel:t,className:"w-100",fileChanges:G,videoStateChanged:y,currentLayout:C,setCurrentLayout:S,setExplicitelyActive:F,explicitelyActive:R,isFollowingEnabled:M,setFollowingEnabled:B,getCurrentTime:function(){return ee.current},active:ie,setActive:le}),r.a.createElement(x,{setFontSize:P,currentLayout:C,setCurrentLayout:S,setExplicitelyActive:F,active:ie,isFollowingEnabled:M,setFollowingEnabled:B,channel:t})),r.a.createElement(K,{embeddableId:n,currentLayout:C,assistantContainerHeight:"block"===C?ae:400})):r.a.createElement("span",{style:{margin:"auto"}},A(l)))))}function X(e){var t=e.embeddableId,n=e.videoId,c=e.isAutoplay,o=Object(a.useState)(!1),i=Object(m.a)(o,2),l=i[0],s=i[1];return r.a.createElement("div",{className:"container-fluid"},r.a.createElement("div",{className:"row"},l?A("block"):r.a.createElement("div",{className:"col-md-12 p-0",style:{backgroundColor:"#151515"}},r.a.createElement(z.a,{autoplay:c,video:n,responsive:!0,onReady:function(e){s(!1)}})),r.a.createElement(K,{embeddableId:t,currentLayout:"inline",assistantContainerHeight:400})))}function $(e){var t=e.embeddableId,n=e.fileChangesURL,a=e.videoURL,c=e.gifURL,o=e.type,i=e.showFrameNumber,l=e.layout,s=e.videoId,u=e.wrapperClassName,f=e.isAutoplay,m={codeAssistantYoutube:function(){return r.a.createElement(S,{layout:l,fileChangesURL:n,videoId:s,wrapperClassName:u})},codeAssistantVimeo:function(){return r.a.createElement(G,{embeddableId:t,layout:l,fileChangesURL:n,videoId:s,wrapperClassName:u,isAutoplay:f})},youtube:function(){return r.a.createElement(V,{videoId:s})},vimeo:function(){return r.a.createElement(X,{videoId:s,isAutoplay:f,embeddableId:t})},onSite:function(){return r.a.createElement(w,{layout:l,fileChangesURL:n,videoURL:a})},gif:function(){return r.a.createElement(F,{gifUrl:c})},codeAssistantGif:function(){return r.a.createElement(M,{fileChangesURL:n,gifUrl:c,showFrameNumber:i,layout:l})},codeAssistantClient:function(){return r.a.createElement(D,null)}}[o];return m?m():"Invalid type (".concat(o,")")}function _(e){var t=e?e.substr(e.lastIndexOf(".")+1):"plaintext";return"txt"===t?"plaintext":t}Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));n(455);!function(){var e=document.getElementsByClassName("kodseged");e.length&&(new URLSearchParams(window.location.search).get("isFullPageClientApp")?Array.from(e).filter((function(e){return"codeAssistantClient"===e.dataset.type})).forEach(t):Array.from(e).filter((function(e){return"codeAssistantClient"!==e.dataset.type})).forEach(t),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()})).catch((function(e){console.error(e.message)})));function t(e){var t,n,a,c,i,l,s,u,f,m;o.a.render(r.a.createElement(r.a.StrictMode,null,r.a.createElement($,{embeddableId:null===(t=e.dataset)||void 0===t?void 0:t.embeddableid,wrapperClassName:null===(n=e.dataset)||void 0===n?void 0:n.wrapperclassname,fileChangesURL:null===(a=e.dataset)||void 0===a?void 0:a.filechangesurl,videoURL:null===(c=e.dataset)||void 0===c?void 0:c.videourl,videoId:null===(i=e.dataset)||void 0===i?void 0:i.videoid,isAutoplay:Boolean(null===(l=e.dataset)||void 0===l?void 0:l.isautoplay),type:null===(s=e.dataset)||void 0===s?void 0:s.type,gifURL:null===(u=e.dataset)||void 0===u?void 0:u.gifurl,showFrameNumber:Boolean(null===(f=e.dataset)||void 0===f?void 0:f.showframenumber),layout:null===(m=e.dataset)||void 0===m?void 0:m.layout})),e)}}()}},[[107,1,2]]]);