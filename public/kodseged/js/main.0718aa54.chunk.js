(this.webpackJsonpkodseged=this.webpackJsonpkodseged||[]).push([[0],{107:function(e,t,n){e.exports=n(456)},112:function(e,t,n){},36:function(e,t,n){},406:function(e,t){},408:function(e,t){},427:function(e,t){},456:function(e,t,n){"use strict";n.r(t);var a=n(0),c=n.n(a),r=n(99),i=n.n(r),o=(n(112),n(36),n(113),n(9)),l=n(6),u=n.n(l),s=n(3),f=n(14),m=n(2),d=n(461),b=n(460),v=n(115);function p(e){var t=e.containerRef,n=e.channel,r=e.fontSize,i=e.fileChanges,l=e.videoStateChanged,u=e.currentLayout,f=e.explicitelyActive,d=e.setExplicitelyActive,b=e.isFollowingEnabled,p=e.setFollowingEnabled,g=e.isVisible,O=e.getCurrentTime,h=Object(a.useRef)({}),E=Object(a.useState)({}),y=Object(m.a)(E,2),k=y[0],x=y[1],w=Object(a.useState)(""),C=Object(m.a)(w,2),N=C[0],S=C[1],A=Object(a.useState)(),L=Object(m.a)(A,2),R=L[0],T=L[1],F=Object(a.useRef)("xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g,(function(e){var t=16*Math.random()|0;return("x"==e?t:3&t|8).toString(16)}))+"-code-container");Object(a.useEffect)((function(){h.current=i.filter((function(e){return 0===e.timestamp})).reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.fileName,t))}),{}),Object.keys(h.current)[0]&&(x(h.current),T(!0))}),[]),Object(a.useEffect)((function(){S(Object.keys(h.current).reduceRight((function(e,t){return t}),""))}),[R]),Object(a.useEffect)((function(){for(var e,t,n=Object.keys(i.reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.fileName,t))}),{})),a=O(),c={},r=function(){var e=u[l],t=i.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<a}));if(!t.length)return"continue";var n=t.pop();c[e]=n},l=0,u=n;l<u.length;l++)r();h.current=Object(s.a)({},c);for(var f=0,m=Object.values(c);f<m.length;f++){var b=m[f];b.timestamp<t||(t=b.timestamp,e=b.fileName)}S(e),d(""),p(!0),U.current=!0}),[l]),Object(a.useEffect)((function(){setTimeout((function(){n.postMessage({event:"init",payload:{files:h.current,active:N}})}),100)}),[l]),Object(a.useEffect)((function(){n.onmessage=function(e){"clientConnected"===e.data.event&&n.postMessage({event:"init",payload:{files:h.current,active:N}})}}),[]);var I=Object(a.useRef)(1);Object(a.useEffect)((function(){setTimeout((function(){n.postMessage({event:"refresh",payload:{files:h.current,active:N,changedLine:I.current}})}),100)}),[k]);var U=Object(a.useRef)(!0);Object(a.useEffect)((function(){U.current=b}),[b]),Object(a.useEffect)((function(){var e=setInterval(D,50);return function(){clearInterval(e)}}),[]);var V=Object(a.useState)(0),M=Object(m.a)(V,2),B=M[0],H=M[1];function D(){var e=O(),t=i.filter((function(t){return t.timestamp<e}));if(t.length){var n=t.pop();U.current&&(I.current=function(e,t){var n;if(!(null===(n=t[e.fileName])||void 0===n?void 0:n.content))return;var a=new v(t[e.fileName].content,e.content).changes.filter((function(e){return e.changes>0}));if(!a[0])return;return a[0].lineno}(n,h.current),H((function(e){return e+1}))),h.current=Object(s.a)(Object(s.a)({},h.current),{},Object(o.a)({},n.fileName,n)),x(h.current),S(n.fileName)}}Object(a.useEffect)((function(){var e=document.getElementById(F.current),t=Array.from(e.querySelectorAll(".linenumber"));t.forEach((function(e){return e.parentElement.style.backgroundColor=""}));var n=t.filter((function(e){return parseInt(e.innerHTML)===I.current})).pop();n&&(n.parentElement.style.backgroundColor="#555",setTimeout((function(){n.parentElement.style.backgroundColor="#333"}),200),e.scroll({top:n.offsetTop-W/2.7,behavior:"smooth"}))}),[B]);var P=Object(a.useState)(t.current.clientHeight),z=Object(m.a)(P,2),W=z[0],q=z[1],J=Object(a.useRef)(u);if(Object(a.useEffect)((function(){if(J.current!==u){J.current=u,q({inline:function(e){return 2*e.current.clientHeight/3},block:function(e){return e.current.clientHeight},inlineWide:function(e){return e.current.clientHeight}}[u](t))}}),[u]),g)return"";var K=f||N;return c.a.createElement("div",{className:{inline:"col-md-4",block:"col-md-12",inlineWide:"col-md-8"}[u]+" p-0 ",style:{height:"block"===u?t.current.clientHeight:W,background:"linear-gradient(90deg, #23241F, #161616)"}},c.a.createElement("div",{className:"scrollbar-hidden",style:{borderBottom:"1px solid lightgrey",overflowX:"scroll",display:"flex",flexDirection:"row"}},Object.entries(h.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center p-2 w-100",style:{background:K===n?"black":"rgb(35, 36, 31)",color:K===n?"white":"grey",display:"flex",flexDirection:"column",justifyContent:"space-evenly",cursor:"pointer",borderRight:"1px solid #333"},onClick:function(){(N!==n||f)&&(p(!1),d(n))}},n)}))),c.a.createElement("div",{className:"overflow-auto scrollbar-hidden",id:F.current},Object.entries(h.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return K===n})).map((function(e){var n=Object(m.a)(e,2),a=n[0],i=n[1];return c.a.createElement("div",{key:a,style:{height:t.current.clientHeight-30-(f?45:0)},className:"font-family-monospace scrollbar-hidden"},j(r,i.languageName,i.content))}))))}var g={phtml:"php",htaccess:"apacheconf",Dockerfile:"dockerfile",parancsok:"shellsession"};function j(e,t,n){return c.a.createElement(d.a,{customStyle:{fontSize:e,background:"linear-gradient(90deg, #23241F, #171717)"},codeTagProps:{style:{lineHeight:"inherit",fontSize:"inherit"}},showLineNumbers:!0,wrapLines:!0,lineProps:{style:{paddingBottom:3,paddingTop:3}},style:b.a,language:g[t]?g[t]:t},n)}var O=n(10),h=n(11),E=n(17),y={inline:"offset-md-8 col-md-4",block:"col-md-12",inlineWide:"offset-md-4 col-md-8"};function k(e){var t=e.setFontSize,n=e.currentLayout,r=(e.setCurrentLayout,e.isVisible),i=(e.setVisible,e.explicitelyActive,e.setExplicitelyActive),o=e.isFollowingEnabled,l=e.setFollowingEnabled,u=e.channel;return c.a.createElement("div",{className:"row",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},c.a.createElement("div",{className:y[n],style:{background:"linear-gradient(90deg, #23241F, #161616)"}},r?"":c.a.createElement(a.Fragment,null,u.noop?"":c.a.createElement("button",{className:"btn btn-sm btn-outline-warning d-inline-block mr-2",onClick:function(){Object.assign(document.createElement("a"),{target:"_blank",href:"/kodseged-kliens?isFullPageClientApp=1"}).click()},"data-tip":"T\xf6bb k\xe9perny\u0151s megjelen\xedt\xe9s"},c.a.createElement(O.a,{icon:h.f}),c.a.createElement(E.a,{place:"bottom",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},c.a.createElement("small",null,c.a.createElement(O.a,{icon:h.b})),c.a.createElement(O.a,{icon:h.d}),c.a.createElement(E.a,{place:"bottom",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},c.a.createElement("small",null,c.a.createElement(O.a,{icon:h.c})),c.a.createElement(O.a,{icon:h.d}),c.a.createElement(E.a,{place:"bottom",type:"dark",effect:"float"})),c.a.createElement("div",{className:"d-inline-block"},o?"":c.a.createElement("button",{className:"btn btn-sm btn-success",onClick:function(){i(""),l(!0)},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},c.a.createElement(O.a,{icon:h.a}),c.a.createElement(E.a,{place:"bottom",type:"dark",effect:"float"}))))))}function x(e){var t=e.fileChangesURL,n=e.videoURL,r=e.layout,i=Object(a.useState)([]),o=Object(m.a)(i,2),l=o[0],d=o[1],b=Object(a.useState)(""),v=Object(m.a)(b,2),p=v[0],g=v[1],j=Object(a.useState)(!1),O=Object(m.a)(j,2),h=O[0],E=O[1],y=Object(a.useState)(16),x=Object(m.a)(y,2),C=x[0],N=x[1],S=Object(a.useState)(),A=Object(m.a)(S,2),L=A[0],R=A[1],T=c.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);Object(a.useEffect)((function(){R(r)}),[]),Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var n,a;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if(n=e.sent){e.next=5;break}return e.abrupt("return");case 5:if(n.ok){e.next=7;break}return e.abrupt("return");case 7:return e.next=9,n.json().catch(console.log);case 9:if(a=e.sent){e.next=12;break}return e.abrupt("return");case 12:d(a.map((function(e){return Object(s.a)(Object(s.a)({},e),{},{languageName:K(e.fileName)})})));case 13:case"end":return e.stop()}}),e)})))()}),[]);var F=Object(a.useRef)(),I=Object(a.useState)(!1),U=Object(m.a)(I,2),V=(U[0],U[1]);return l.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:("inline"===L?"col-md-8":"col-md-12")+" p-0 pr-1"},c.a.createElement("video",{onLoadedData:function(){V(!0)},className:"w-100",id:"video",src:n,controls:!0,width:"100%",crossOrigin:"anonymous",ref:F})),F.current?c.a.createElement(w,{channel:T,fontSize:C,isVisible:h,className:"w-100",fileChanges:l,explicitelyActive:p,setExplicitelyActive:g,currentLayout:L,videoReference:F}):""),c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-12 p-0",style:{backgroundColor:"rgb(35, 36, 31)"}},c.a.createElement(k,{setFontSize:N,currentLayout:L,setCurrentLayout:R,isVisible:h,setVisible:E,explicitelyActive:p,setExplicitelyActive:g}))))):c.a.createElement("div",{className:"text-center"},"Bet\xf6lt\xe9s...")}function w(e){var t=e.fileChanges,n=e.videoReference,r=e.currentLayout,i=e.channel,l=e.explicitelyActive,u=e.setExplicitelyActive,f=e.fontSize,d=e.isVisible,b=Object(a.useRef)({}),v=Object(a.useState)({}),p=Object(m.a)(v,2),g=p[0],O=p[1],h=Object(a.useState)(""),E=Object(m.a)(h,2),y=E[0],k=E[1],x=Object(a.useRef)();function w(){var e;if(n.current){var a=t.filter((function(e){return e.timestamp<n.current.currentTime}));if(a.length){var c=a.pop();(null===(e=b.current[c.fileName])||void 0===e?void 0:e.content)!==c.content&&(b.current=Object(s.a)(Object(s.a)({},b.current),{},Object(o.a)({},c.fileName,c)),O(b.current),k(c.fileName))}}}if(Object(a.useEffect)((function(){return x.current=setInterval(w,50),function(){clearInterval(x.current)}}),[]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){w(),setTimeout((function(){i.postMessage({event:"init",payload:{files:b.current,active:y}})}),100)}))}),[]),Object(a.useEffect)((function(){i.onmessage=function(e){"clientConnected"===e.data.event&&i.postMessage({event:"init",payload:{files:b.current,active:y}})}}),[]),Object(a.useEffect)((function(){setTimeout((function(){i.postMessage({event:"refresh",payload:{files:b.current,active:y}})}),100)}),[g]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){for(var e,a,c=Object.keys(t.reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.fileName,t))}),{})),r={},i=function(){var e=f[l],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<n.current.currentTime}));if(!a.length)return"continue";var c=a.pop();r[e]=c},l=0,f=c;l<f.length;l++)i();b.current=r;for(var m=0,d=Object.values(r);m<d.length;m++){var v=d[m];v.timestamp<a||(a=v.timestamp,e=v.fileName)}k(e),u("")}))}),[]),d)return"";var C=l||y;return c.a.createElement("div",{className:("inline"===r?"col-md-4":"col-md-12")+" p-0",style:{height:n.current.clientHeight,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(b.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center",style:{backgroundColor:C===n?"black":"rgb(35, 36, 31)",color:C===n?"white":"grey",width:parseInt(100/Object.values(b.current).length)+"%",borderBottom:"1px solid lightgrey",height:"30px",display:"inline-block",cursor:"pointer"},onClick:function(){(y!==n||l)&&u(n)}},n)})),c.a.createElement("div",{className:"overflow-auto"},Object.entries(b.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return C===n})).map((function(e){var t=Object(m.a)(e,2),a=t[0],r=t[1];return c.a.createElement("div",{style:{height:n.current.clientHeight-30-(l?45:0)},key:a,className:"font-family-monospace"},j(f,r.languageName,r.content))}))))}var C=n(34);function N(e){var t,n=e.fileChangesURL,r=e.videoId,i=e.layout,o=e.wrapperClassName,l=Object(a.useRef)(),d=Object(a.useState)(),b=Object(m.a)(d,2),v=b[0],g=b[1],j=Object(a.useState)(0),O=Object(m.a)(j,2),h=O[0],E=O[1],y=Object(a.useState)(),x=Object(m.a)(y,2),w=x[0],N=x[1],A=Object(a.useState)(""),L=Object(m.a)(A,2),R=L[0],T=L[1],F=Object(a.useState)(!0),I=Object(m.a)(F,2),U=I[0],V=I[1],M=Object(a.useState)(!1),B=Object(m.a)(M,2),H=B[0],D=B[1],P=Object(a.useState)(16),z=Object(m.a)(P,2),W=z[0],q=z[1];try{t=new BroadcastChannel("codeAssistant")}catch(_){t={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}c.a.useMemo((function(){return t}),[]),c.a.useEffect((function(){return t.onmessage=function(e){"clientClosed"===e.data.event&&D(!1)},t.close}),[]),Object(a.useEffect)((function(){N(i)}),[]),Object(a.useEffect)((function(){var e=document.querySelector(".".concat(o));e&&("inline"===w?(e.classList.add("kodseged-inline"),e.classList.remove("kodseged-block")):(e.classList.add("kodseged-block"),e.classList.remove("kodseged-inline")))}),[w]);var J=Object(a.useState)([]),G=Object(m.a)(J,2),X=G[0],Y=G[1];Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var t,a;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(n).catch(console.log);case 2:if(!(t=e.sent)||t.ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,t.json().catch(console.log);case 7:if((a=e.sent).length){e.next=10;break}return e.abrupt("return");case 10:Y(a.map((function(e){return Object(s.a)(Object(s.a)({},e),{},{languageName:K(e.fileName)})})));case 11:case"end":return e.stop()}}),e)})))()}),[]);var $=Object(a.useRef)();return X.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{ref:$,className:("inline"===w?"col-md-8":"col-md-12")+" p-0"},c.a.createElement(C.a,{opts:{width:"100%"},videoId:r,onReady:function(e){l.current=e.target,g(1)},onStateChange:function(e){2===e.data&&E((function(e){return e+1}))}})),v?c.a.createElement(p,{containerRef:$,fontSize:W,channel:t,isVisible:H,className:"w-100",fileChanges:X,videoStateChanged:h,currentLayout:w,setCurrentLayout:N,setExplicitelyActive:T,explicitelyActive:R,getCurrentTime:function(){return l.current.getCurrentTime()}}):S(w)),c.a.createElement(k,{setFontSize:q,currentLayout:w,setCurrentLayout:N,isVisible:H,setVisible:D,explicitelyActive:R,setExplicitelyActive:T,isFollowingEnabled:U,setFollowingEnabled:V,channel:t}))):c.a.createElement("div",{style:{marginTop:50,marginBottom:50}},S(i))}function S(e){return c.a.createElement("div",{className:"inline"===e?"col-md-4":"col-md-12 text-center"},c.a.createElement("div",{className:"spinner-border text-info",style:{width:"3rem",height:"3rem"}},c.a.createElement("span",{className:"sr-only"},"Bet\xf6lt\xe9s...")))}var A=n(19),L=n.n(A),R=n(73);function T(e){var t=e.gifUrl,n=Object(a.useState)([]),r=Object(m.a)(n,2),i=r[0],o=r[1],l=Object(a.useState)(!0),d=Object(m.a)(l,2),b=d[0],v=d[1],p=Object(a.useRef)([]),g=Object(a.useRef)(2);Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var n;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return v(!0),e.next=3,R({url:t,frames:"all",outputType:"canvas",cumulative:!0});case 3:n=e.sent,v(!1),g.current=n.length,p.current=n,E({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var j=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(s.a)(Object(s.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),O=Object(m.a)(j,2),h=O[0],E=O[1];return Object(a.useEffect)((function(){p.current[0]&&(o((function(e){return p.current[0]?e.concat([p.current[0].getImage()]):e})),p.current.shift(),setTimeout((function(){E({type:"UPDATE"})}),0))}),[h.calcCount]),b?S("block"):i.length>0?c.a.createElement(F,{frames:i,total:g.current,calcCount:h.calcCount}):""}function F(e){var t=e.frames,n=e.total,r=e.calcCount,i=Object(a.createRef)(),o=Object(a.useState)(0),l=Object(m.a)(o,2),u=l[0],s=l[1],f=Object(a.useRef)(),d=Object(a.useState)(!1),b=Object(m.a)(d,2),v=b[0],p=b[1];return Object(a.useEffect)((function(){if(i.current&&!v){var e=f.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;i.current.width=n.width*a,i.current.height=n.height*a,i.current.getContext("2d").scale(a,a),i.current.getContext("2d").drawImage(n,0,0),p(!0)}}),[i]),Object(a.useEffect)((function(){if(void 0!==t[u]){var e=t[u],n=f.current.offsetWidth,a=n/e.width<1?n/e.width:1;i.current.width=e.width*a,i.current.height=e.height*a,i.current.getContext("2d").scale(a,a),i.current.getContext("2d").drawImage(e,0,0)}}),[u]),t.length?c.a.createElement("div",{className:"text-center",ref:f},c.a.createElement("canvas",{className:"text-center m-auto",ref:i}),c.a.createElement("div",{className:"main-scroller"},c.a.createElement(L.a,{formatLabel:function(){return""},minValue:0,maxValue:n-1,value:u,onChange:function(e){e>r||s(e)}})),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(L.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:n+1,value:r,onChange:function(){}}))):""}var I=n(73);function U(e){var t=e.fileChangesURL,n=e.gifUrl,r=e.showFrameNumber,i=e.layout,l=Object(a.useState)([]),d=Object(m.a)(l,2),b=d[0],v=d[1],p=Object(a.useState)(!0),g=Object(m.a)(p,2),j=g[0],O=g[1],h=Object(a.useState)([]),E=Object(m.a)(h,2),y=E[0],k=E[1],x=Object(a.useRef)([]),w=Object(a.useRef)(1);Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var t;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return O(!0),e.next=3,I({url:n,frames:"all",outputType:"canvas",cumulative:!0});case 3:t=e.sent,O(!1),w.current=t.length,x.current=t,L({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var C=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(s.a)(Object(s.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),N=Object(m.a)(C,2),A=N[0],L=N[1];return Object(a.useEffect)((function(){x.current[0]&&(k((function(e){return x.current[0]?e.concat([x.current[0].getImage()]):e})),x.current.shift(),setTimeout((function(){L({type:"UPDATE"})}),0))}),[A.calcCount]),Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var n,a,c,r,i;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if((n=e.sent).ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,n.text();case 7:a=e.sent,c=new DOMParser,r=c.parseFromString(a,"text/xml"),i=Array.from(r.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.localName,"frame"===t.localName?parseInt(t.innerHTML):t.innerHTML))}),{})})).map((function(e){return Object(s.a)(Object(s.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})),v(i.map((function(e){return Object(s.a)(Object(s.a)({},e),{},{languageName:K(e.fileName)})})));case 12:case"end":return e.stop()}}),e)})))()}),[]),j?S("block"):y.length>0?c.a.createElement(V,{frames:y,fileChanges:b,showFrameNumber:r,layout:i,total:w.current,calcCount:A.calcCount}):""}function V(e){var t=e.frames,n=e.fileChanges,r=e.showFrameNumber,i=e.layout,o=e.total,l=e.calcCount,u=Object(a.createRef)(),s=Object(a.useState)(0),f=Object(m.a)(s,2),d=f[0],b=f[1],v=Object(a.useRef)(),p=Object(a.useState)(0),g=Object(m.a)(p,2),j=g[0],O=g[1],h=Object(a.useState)(!1),E=Object(m.a)(h,2),y=E[0],k=E[1];return Object(a.useEffect)((function(){O(v.current.offsetHeight)}),[v.current]),Object(a.useEffect)((function(){if(u.current&&!y){var e=v.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;u.current.width=n.width*a,u.current.height=n.height*a,u.current.getContext("2d").scale(a,a),u.current.getContext("2d").drawImage(n,0,0),k(!0)}}),[u]),Object(a.useEffect)((function(){if(t[d]){var e=t[d],n=v.current.offsetWidth,a=n/e.width<1?n/e.width:1;u.current.width=e.width*a,u.current.height=e.height*a,u.current.getContext("2d").scale(a,a),u.current.getContext("2d").drawImage(e,0,0)}}),[d]),"inline"===i?c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-7 p-0 mb-5",ref:v},c.a.createElement("canvas",{ref:u}),c.a.createElement("div",{className:"main-scroller"},o-1>0?c.a.createElement(L.a,{formatLabel:function(e){return r?e:""},minValue:0,maxValue:o-1,value:d,onChange:function(e){e>l||b(e)}}):""),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(L.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:o+1,value:l,onChange:function(){}}))),c.a.createElement("div",{className:"col-md-5 p-0 m-0"},v.current?c.a.createElement(M,{fileChanges:n,frame:d,height:j}):"")):void 0!==t.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"text-center mb-5",ref:v},c.a.createElement("canvas",{ref:u}),c.a.createElement("div",{className:"main-scroller"},o-1>0?c.a.createElement(L.a,{formatLabel:function(e){return r?e:""},minValue:0,maxValue:o-1,value:d,onChange:function(e){e>l||b(e)}}):""),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(L.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:o+1,value:l,onChange:function(){}}))),v.current?c.a.createElement(M,{fileChanges:n,frame:d,height:j}):""):""}function M(e){var t=e.fileChanges,n=e.frame,r=e.height,i=Object(a.useRef)({}),l=Object(a.useState)({}),u=Object(m.a)(l,2),f=(u[0],u[1],Object(a.useState)("")),d=Object(m.a)(f,2),b=d[0],v=d[1],p=Object(a.useState)(""),g=Object(m.a)(p,2),O=g[0],h=g[1];Object(a.useEffect)((function(){h("");for(var e,a,c=Object.keys(t.reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.fileName,t))}),{})),r={},l=function(){var e=f[u],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.frame<n}));if(!a.length)return"continue";var c=a.pop();r[e]=c},u=0,f=c;u<f.length;u++)l();i.current=r;for(var m=0,d=Object.values(r);m<d.length;m++){var b=d[m];b.frame<a||(a=b.frame,e=b.fileName)}v(e)}),[n]);var E=O||b;return c.a.createElement("div",{className:"col-md-12 p-0 overflow-auto",style:{height:r,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(i.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center p-2",style:{backgroundColor:E===n?"black":"rgb(35, 36, 31)",color:E===n?"white":"grey",width:parseInt(100/Object.values(i.current).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(b!==n||O)&&h(n)}},n)})),Object.entries(i.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return E===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return c.a.createElement("div",{key:n,className:"font-family-monospace"},j(20,a.languageName,a.content))})))}function B(e){var t=e.videoId;return c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-12 p-0"},c.a.createElement("div",{className:"text-center m-auto",style:{maxWidth:"720px"}},c.a.createElement(C.a,{opts:{width:"100%"},videoId:t})))))}function H(){var e=Object(a.useState)({}),t=Object(m.a)(e,2),n=t[0],r=t[1],i=Object(a.useState)(""),o=Object(m.a)(i,2),l=o[0],u=o[1],s=Object(a.useState)(16),f=Object(m.a)(s,2),d=f[0],b=f[1],v=Object(a.useState)(""),p=Object(m.a)(v,2),g=p[0],y=p[1],k=Object(a.useState)(0),x=Object(m.a)(k,2),w=x[0],C=x[1],N=Object(a.useRef)(1),S=c.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);c.a.useEffect((function(){S.postMessage({event:"clientConnected"}),S.onmessage=function(e){var t={refresh:function(e){r(e.files);var t=e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop();g||u(t),N.current=e.changedLine,C((function(e){return e+1}))},init:function(e){r(e.files),y(""),u(e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop())}}[e.data.event];t&&t(e.data.payload)}}),[]),Object(a.useEffect)((function(){if(!g){var e=Array.from(document.querySelectorAll(".linenumber"));e.forEach((function(e){return e.parentElement.style.backgroundColor=""}));var t=e.filter((function(e){return parseInt(e.innerHTML)===N.current})).pop();if(t){t.parentElement.style.backgroundColor="#555",setTimeout((function(){t.parentElement.style.backgroundColor="#333"}),200);var n=Math.max(document.documentElement.clientHeight||0,window.innerHeight||0);window.scroll({top:t.offsetTop-n/2.7,behavior:"smooth"})}}}),[w]);var A=g||l;return c.a.createElement("div",{className:"col-md-12 p-0 w-100 mt-5",style:{background:"linear-gradient(90deg, #23241F, #161616)"}},c.a.createElement("div",{className:"w-100 fixed-top"},Object.entries(n).map((function(e){var t=Object(m.a)(e,2),a=t[0];t[1];return c.a.createElement("div",{key:a,className:"text-center p-2",style:{backgroundColor:A===a?"black":"rgb(35, 36, 31)",color:A===a?"white":"grey",width:parseInt(100/Object.values(n).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(l!==a||g)&&y(a)}},a)}))),c.a.createElement("div",{className:"overflow-auto",id:"code-container"},Object.entries(n).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return A===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return c.a.createElement("div",{key:n,className:"font-family-monospace"},j(d,a.languageName,a.content))}))),c.a.createElement("div",{className:"row p-3"},c.a.createElement("div",{className:"btn-group fixed-bottom w-25"},c.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){b((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},c.a.createElement("small",null,c.a.createElement(O.a,{icon:h.b})),c.a.createElement(O.a,{icon:h.d}),c.a.createElement(E.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){b((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},c.a.createElement("small",null,c.a.createElement(O.a,{icon:h.c})),c.a.createElement(O.a,{icon:h.d}),c.a.createElement(E.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-danger m-1",onClick:function(){S.postMessage({event:"clientClosed"}),window.close()},"data-tip":"Bez\xe1r\xe1s"},c.a.createElement(O.a,{icon:h.e}),c.a.createElement(E.a,{place:"top",type:"dark",effect:"float"})),g?c.a.createElement("button",{className:"btn btn-sm btn-success m-1",onClick:function(){g&&y("")},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},c.a.createElement(O.a,{icon:h.a}),c.a.createElement(E.a,{place:"top",type:"dark",effect:"float"})):"")))}var D=n(35),P=n(55),z=n.n(P);function W(e){var t,n=e.fileChangesURL,r=e.videoId,i=e.layout,l=e.wrapperClassName,d=e.isAutoplay,b=Object(a.useState)(),v=Object(m.a)(b,2),g=v[0],j=v[1],O=Object(a.useState)(0),h=Object(m.a)(O,2),E=h[0],y=h[1],x=Object(a.useState)(),w=Object(m.a)(x,2),C=w[0],N=w[1],A=Object(a.useState)(""),L=Object(m.a)(A,2),R=L[0],T=L[1],F=Object(a.useState)(!0),I=Object(m.a)(F,2),U=I[0],V=I[1],M=Object(a.useState)(!1),B=Object(m.a)(M,2),H=B[0],P=B[1],W=Object(a.useState)(14),q=Object(m.a)(W,2),J=q[0],G=q[1];try{t=new BroadcastChannel("codeAssistant")}catch(ae){t={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}c.a.useMemo((function(){return t}),[]),c.a.useEffect((function(){return t.onmessage=function(e){"clientClosed"===e.data.event&&P(!1)},t.close}),[]),Object(a.useEffect)((function(){N(i)}),[]);var X={inline:"kodseged-inline",block:"kodseged-block",inlineWide:"kodseged-inline-wide"};Object(a.useEffect)((function(){var e=document.querySelector(".".concat(l));e&&(Object.values(X).forEach((function(t){e.classList.remove(t)})),X[C]&&e.classList.add(X[C]))}),[C]);var Y=Object(a.useState)([]),$=Object(m.a)(Y,2),_=$[0],Q=$[1];function Z(e){return ee.apply(this,arguments)}function ee(){return(ee=Object(f.a)(u.a.mark((function e(t){var n,a,c;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.text();case 2:return n=e.sent,a=new DOMParser,c=a.parseFromString(n,"text/xml"),e.abrupt("return",Array.from(c.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(s.a)(Object(s.a)({},e),{},Object(o.a)({},t.localName,t.innerHTML))}),{})})).map((function(e){return Object(s.a)(Object(s.a)({},e),{},{timestamp:z()(e.timestamp,"mm:ss").diff(z()().startOf("day"),"seconds")})})).map((function(e){return Object(s.a)(Object(s.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})).map((function(e){return Object(s.a)(Object(s.a)({},e),{},{content:e.content.replace("<![CDATA[\n","").replace("]]>","")})})));case 6:case"end":return e.stop()}}),e)})))).apply(this,arguments)}Object(a.useEffect)((function(){Object(f.a)(u.a.mark((function e(){var t,a,c,r;return u.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(n).catch(console.log);case 2:if(!(a=e.sent)||a.ok){e.next=5;break}return e.abrupt("return");case 5:if(c=Object.fromEntries(Array.from(a.headers.entries())),r=[],"application/xml"!==c["content-type"]){e.next=11;break}return e.next=10,Z(a);case 10:r=e.sent;case 11:if("application/json"!==c["content-type"]){e.next=15;break}return e.next=14,a.json().catch(console.log);case 14:r=e.sent;case 15:if(null===(t=r)||void 0===t?void 0:t.length){e.next=17;break}return e.abrupt("return");case 17:Q(r.map((function(e){return Object(s.a)(Object(s.a)({},e),{},{languageName:K(e.fileName)})})));case 18:case"end":return e.stop()}}),e)})))()}),[]);var te=Object(a.useRef)(),ne=Object(a.useRef)(0);if(!_.length)return c.a.createElement("div",{className:"d-flex justify-content-center",style:{paddingTop:30,paddingBottom:30,backgroundColor:"rgb(35, 36, 31)"}},S(i));return c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{ref:te,className:{inline:"col-md-8",block:"col-md-12",inlineWide:"col-md-4"}[C]+" p-0",style:{backgroundColor:"rgb(35, 36, 31)"}},c.a.createElement(D.a,{video:r,autoplay:d,responsive:!0,onReady:function(e){j(1)},onTimeUpdate:function(e){ne.current=e.seconds},onSeeked:function(e){y((function(e){return e+1}))}})),g?c.a.createElement(p,{containerRef:te,fontSize:J,channel:t,isVisible:H,className:"w-100",fileChanges:_,videoStateChanged:E,currentLayout:C,setCurrentLayout:N,setExplicitelyActive:T,explicitelyActive:R,isFollowingEnabled:U,setFollowingEnabled:V,getCurrentTime:function(){return ne.current}}):c.a.createElement("span",{style:{margin:"auto"}},S(i))),c.a.createElement(k,{setFontSize:G,currentLayout:C,setCurrentLayout:N,isVisible:H,setVisible:P,explicitelyActive:R,setExplicitelyActive:T,isFollowingEnabled:U,setFollowingEnabled:V,channel:t})))}function q(e){var t=e.videoId,n=e.isAutoplay,r=Object(a.useState)(!1),i=Object(m.a)(r,2),o=i[0],l=i[1];return c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},o?S("block"):c.a.createElement("div",{className:"col-md-12 p-0",style:{backgroundColor:"#151515"}},c.a.createElement(D.a,{autoplay:n,video:t,responsive:!0,onReady:function(e){l(!1)}}))))}function J(e){var t=e.fileChangesURL,n=e.videoURL,a=e.gifURL,r=e.type,i=e.showFrameNumber,o=e.layout,l=e.videoId,u=e.wrapperClassName,s=e.isAutoplay,f={codeAssistantYoutube:function(){return c.a.createElement(N,{layout:o,fileChangesURL:t,videoId:l,wrapperClassName:u})},codeAssistantVimeo:function(){return c.a.createElement(W,{layout:o,fileChangesURL:t,videoId:l,wrapperClassName:u,isAutoplay:s})},youtube:function(){return c.a.createElement(B,{videoId:l})},vimeo:function(){return c.a.createElement(q,{videoId:l,isAutoplay:s})},onSite:function(){return c.a.createElement(x,{layout:o,fileChangesURL:t,videoURL:n})},gif:function(){return c.a.createElement(T,{gifUrl:a})},codeAssistantGif:function(){return c.a.createElement(U,{fileChangesURL:t,gifUrl:a,showFrameNumber:i,layout:o})},codeAssistantClient:function(){return c.a.createElement(H,null)}}[r];return f?f():"Invalid type (".concat(r,")")}function K(e){var t=e?e.substr(e.lastIndexOf(".")+1):"plaintext";return"txt"===t?"plaintext":t}Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));n(455);!function(){var e=document.getElementsByClassName("kodseged");e.length&&(new URLSearchParams(window.location.search).get("isFullPageClientApp")?Array.from(e).filter((function(e){return"codeAssistantClient"===e.dataset.type})).forEach(t):Array.from(e).filter((function(e){return"codeAssistantClient"!==e.dataset.type})).forEach(t),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()})).catch((function(e){console.error(e.message)})));function t(e){var t,n,a,r,o,l,u,s,f;i.a.render(c.a.createElement(c.a.StrictMode,null,c.a.createElement(J,{wrapperClassName:null===(t=e.dataset)||void 0===t?void 0:t.wrapperclassname,fileChangesURL:null===(n=e.dataset)||void 0===n?void 0:n.filechangesurl,videoURL:null===(a=e.dataset)||void 0===a?void 0:a.videourl,videoId:null===(r=e.dataset)||void 0===r?void 0:r.videoid,isAutoplay:Boolean(null===(o=e.dataset)||void 0===o?void 0:o.isautoplay),type:null===(l=e.dataset)||void 0===l?void 0:l.type,gifURL:null===(u=e.dataset)||void 0===u?void 0:u.gifurl,showFrameNumber:Boolean(null===(s=e.dataset)||void 0===s?void 0:s.showframenumber),layout:null===(f=e.dataset)||void 0===f?void 0:f.layout})),e)}}()}},[[107,1,2]]]);