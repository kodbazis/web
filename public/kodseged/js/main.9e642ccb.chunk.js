(this.webpackJsonpkodseged=this.webpackJsonpkodseged||[]).push([[0],{30:function(e,t,n){},314:function(e,t){},316:function(e,t){},335:function(e,t){},364:function(e,t,n){"use strict";n.r(t);var a=n(0),c=n.n(a),r=n(69),i=n.n(r),l=(n(79),n(30),n(80),n(81),n(12)),o=n(6),s=n.n(o),u=n(3),f=n(13),m=n(2),d=n(17),b=n.n(d),v=n(28),p=n(72),g=n(9),j=n(7),O=n(14);function h(e){var t,n=e.fileChangesURL,r=e.videoId,i=e.layout,l=e.wrapperClassName,o=Object(a.useRef)(),d=Object(a.useState)(),b=Object(m.a)(d,2),p=b[0],g=b[1],j=Object(a.useState)(0),O=Object(m.a)(j,2),h=O[0],k=O[1],w=Object(a.useState)(),C=Object(m.a)(w,2),x=C[0],S=C[1],L=Object(a.useState)(""),A=Object(m.a)(L,2),R=A[0],I=A[1],T=Object(a.useState)(!1),U=Object(m.a)(T,2),V=U[0],B=U[1],M=Object(a.useState)(16),F=Object(m.a)(M,2),z=F[0],P=F[1];try{t=new BroadcastChannel("codeAssistant")}catch(G){t={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}c.a.useMemo((function(){return t}),[]),c.a.useEffect((function(){return t.onmessage=function(e){"clientClosed"===e.data.event&&B(!1)},t.close}),[]),Object(a.useEffect)((function(){S(i)}),[]),Object(a.useEffect)((function(){var e=document.querySelector(".".concat(l));e&&("inline"===x?(e.classList.add("kodseged-inline"),e.classList.remove("kodseged-block")):(e.classList.add("kodseged-block"),e.classList.remove("kodseged-inline")))}),[x]);var D=Object(a.useState)([]),H=Object(m.a)(D,2),q=H[0],J=H[1];Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t,a;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(n).catch(console.log);case 2:if(!(t=e.sent)||t.ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,t.json().catch(console.log);case 7:if((a=e.sent).length){e.next=10;break}return e.abrupt("return");case 10:J(a.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:W(e.fileName)})})));case 11:case"end":return e.stop()}}),e)})))()}),[]);var K=Object(a.useRef)();return q.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{ref:K,className:("inline"===x?"col-md-8":"col-md-12")+" p-0 pr-1"},c.a.createElement(v.a,{opts:{width:"100%"},videoId:r,onReady:function(e){o.current=e.target,g(1)},onStateChange:function(e){2===e.data&&k((function(e){return e+1}))}})),p?c.a.createElement(N,{containerRef:K,fontSize:z,channel:t,isVisible:V,className:"w-100",fileChanges:q,videoStateChanged:h,currentLayout:x,setCurrentLayout:S,setExplicitelyActive:I,explicitelyActive:R,getCurrentTime:function(){return o.current.getCurrentTime()}}):y(x)),c.a.createElement(E,{setFontSize:P,currentLayout:x,setCurrentLayout:S,isVisible:V,setVisible:B,explicitelyActive:R,setExplicitelyActive:I,channel:t}))):c.a.createElement("div",{className:"text-center"},"Bet\xf6lt\xe9s...")}function E(e){var t=e.setFontSize,n=e.currentLayout,r=e.setCurrentLayout,i=e.isVisible,l=e.setVisible,o=e.explicitelyActive,s=e.setExplicitelyActive,u=e.channel;return c.a.createElement("div",{className:"row",style:{backgroundColor:"rgb(35, 36, 31)"}},"inline"===n?c.a.createElement("div",{className:"col-md-8"}):"",c.a.createElement("div",{className:"inline"===n?"col-md-4 border-top border-dark":"col-md-12"},p.isMobile||i?"":c.a.createElement("button",{className:"btn btn-sm btn-warning d-inline-block mr-2",onClick:function(){r("inline"===n?"block":"inline")},"data-tip":"N\xe9zet v\xe1lt\xe1sa"},c.a.createElement(g.a,{icon:j.b}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-warning d-inline-block mr-2",onClick:function(){l((function(e){return!e}))},"data-tip":i?"Megjelen\xedt\xe9s":"Elrejt\xe9s"},c.a.createElement(g.a,{icon:i?j.d:j.e}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),i?"":c.a.createElement(a.Fragment,null,u.noop?"":c.a.createElement("button",{className:"btn btn-sm btn-warning d-inline-block mr-2",onClick:function(){l(!0),Object.assign(document.createElement("a"),{target:"_blank",href:"/kodseged-kliens?isFullPageClientApp=1"}).click()},"data-tip":"Teljes k\xe9perny\u0151"},c.a.createElement(g.a,{icon:j.c}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},c.a.createElement("small",null,c.a.createElement(g.a,{icon:j.f})),c.a.createElement(g.a,{icon:j.h}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-outline-warning m-1",onClick:function(){t((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},c.a.createElement("small",null,c.a.createElement(g.a,{icon:j.g})),c.a.createElement(g.a,{icon:j.h}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("div",{className:"d-inline-block"},o?c.a.createElement("button",{className:"btn btn-sm btn-outline-success",onClick:function(){o&&s("")},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},c.a.createElement(g.a,{icon:j.a}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})):""))))}function y(e){return c.a.createElement("div",{className:"inline"===e?"col-md-4":"col-md-12 text-center bg-light"},c.a.createElement("div",{className:"d-flex justify-content-center center"},c.a.createElement("div",{className:"spinner-border text-danger mr-2",role:"status"},c.a.createElement("span",{className:"sr-only"},"Bet\xf6lt\xe9s..."))))}function N(e){var t=e.containerRef,n=e.channel,r=e.fontSize,i=e.fileChanges,o=e.videoStateChanged,s=e.currentLayout,f=e.explicitelyActive,d=e.setExplicitelyActive,v=e.isVisible,p=e.getCurrentTime,g=Object(a.useRef)({}),j=Object(a.useState)({}),O=Object(m.a)(j,2),h=O[0],E=O[1],y=Object(a.useState)(""),N=Object(m.a)(y,2),k=N[0],w=N[1];function C(){var e,t=p(),n=i.filter((function(e){return e.timestamp<t}));if(n.length){var a=n.pop();(null===(e=g.current[a.fileName])||void 0===e?void 0:e.content)!==a.content&&(g.current=Object(u.a)(Object(u.a)({},g.current),{},Object(l.a)({},a.fileName,a)),E(g.current),w(a.fileName))}}if(Object(a.useEffect)((function(){for(var e,t,n=Object.keys(i.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(l.a)({},t.fileName,t))}),{})),a=p(),c={},r=function(){var e=s[o],t=i.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<a}));if(!t.length)return"continue";var n=t.pop();c[e]=n},o=0,s=n;o<s.length;o++)r();g.current=c;for(var f=0,m=Object.values(c);f<m.length;f++){var b=m[f];b.timestamp<t||(t=b.timestamp,e=b.fileName)}w(e),d("")}),[o]),Object(a.useEffect)((function(){C(),setTimeout((function(){n.postMessage({event:"init",payload:{files:g.current,active:k}})}),100)}),[o]),Object(a.useEffect)((function(){n.onmessage=function(e){"clientConnected"===e.data.event&&n.postMessage({event:"init",payload:{files:g.current,active:k}})}}),[]),Object(a.useEffect)((function(){setTimeout((function(){n.postMessage({event:"refresh",payload:{files:g.current,active:k}})}),100)}),[h]),Object(a.useEffect)((function(){var e=setInterval(C,50);return function(){clearInterval(e)}}),[]),v)return"";var x=f||k;return c.a.createElement("div",{className:("inline"===s?"col-md-4":"col-md-12")+" p-0 ",style:{height:t.current.clientHeight,overflow:"scroll",backgroundColor:"rgb(35, 36, 31)"}},Object.entries(g.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center p-2",style:{backgroundColor:x===n?"black":"rgb(35, 36, 31)",color:x===n?"white":"grey",width:parseInt(100/Object.values(g.current).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(k!==n||f)&&d(n)}},n)})),c.a.createElement("div",{className:"overflow-auto"},Object.entries(g.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return x===n})).map((function(e){var n=Object(m.a)(e,2),a=n[0],i=n[1];return c.a.createElement("div",{key:a,style:{height:t.current.clientHeight-30-(f?45:0),fontSize:"".concat(r,"px")},className:"font-family-monospace"},c.a.createElement(b.a,{className:i.languageName},i.content))}))))}function k(e){var t=e.fileChangesURL,n=e.videoURL,r=e.layout,i=Object(a.useState)([]),l=Object(m.a)(i,2),o=l[0],d=l[1],b=Object(a.useState)(""),v=Object(m.a)(b,2),p=v[0],g=v[1],j=Object(a.useState)(!1),O=Object(m.a)(j,2),h=O[0],y=O[1],N=Object(a.useState)(16),k=Object(m.a)(N,2),C=k[0],x=k[1],S=Object(a.useState)(),L=Object(m.a)(S,2),A=L[0],R=L[1],I=c.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);Object(a.useEffect)((function(){R(r)}),[]),Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n,a;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if(n=e.sent){e.next=5;break}return e.abrupt("return");case 5:if(n.ok){e.next=7;break}return e.abrupt("return");case 7:return e.next=9,n.json().catch(console.log);case 9:if(a=e.sent){e.next=12;break}return e.abrupt("return");case 12:d(a.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:W(e.fileName)})})));case 13:case"end":return e.stop()}}),e)})))()}),[]);var T=Object(a.useRef)(),U=Object(a.useState)(!1),V=Object(m.a)(U,2),B=(V[0],V[1]);return o.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:("inline"===A?"col-md-8":"col-md-12")+" p-0 pr-1"},c.a.createElement("video",{onLoadedData:function(){B(!0)},className:"w-100",id:"video",src:n,controls:!0,width:"100%",crossOrigin:"anonymous",ref:T})),T.current?c.a.createElement(w,{channel:I,fontSize:C,isVisible:h,className:"w-100",fileChanges:o,explicitelyActive:p,setExplicitelyActive:g,currentLayout:A,videoReference:T}):""),c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-12 p-0",style:{backgroundColor:"rgb(35, 36, 31)"}},c.a.createElement(E,{setFontSize:x,currentLayout:A,setCurrentLayout:R,isVisible:h,setVisible:y,explicitelyActive:p,setExplicitelyActive:g}))))):c.a.createElement("div",{className:"text-center"},"Bet\xf6lt\xe9s...")}function w(e){var t=e.fileChanges,n=e.videoReference,r=e.currentLayout,i=e.channel,o=e.explicitelyActive,s=e.setExplicitelyActive,f=e.fontSize,d=e.isVisible,v=Object(a.useRef)({}),p=Object(a.useState)({}),g=Object(m.a)(p,2),j=g[0],O=g[1],h=Object(a.useState)(""),E=Object(m.a)(h,2),y=E[0],N=E[1],k=Object(a.useRef)();function w(){var e;if(n.current){var a=t.filter((function(e){return e.timestamp<n.current.currentTime}));if(a.length){var c=a.pop();(null===(e=v.current[c.fileName])||void 0===e?void 0:e.content)!==c.content&&(v.current=Object(u.a)(Object(u.a)({},v.current),{},Object(l.a)({},c.fileName,c)),O(v.current),N(c.fileName))}}}if(Object(a.useEffect)((function(){return k.current=setInterval(w,50),function(){clearInterval(k.current)}}),[]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){w(),setTimeout((function(){i.postMessage({event:"init",payload:{files:v.current,active:y}})}),100)}))}),[]),Object(a.useEffect)((function(){i.onmessage=function(e){"clientConnected"===e.data.event&&i.postMessage({event:"init",payload:{files:v.current,active:y}})}}),[]),Object(a.useEffect)((function(){setTimeout((function(){i.postMessage({event:"refresh",payload:{files:v.current,active:y}})}),100)}),[j]),Object(a.useEffect)((function(){n.current.addEventListener("seeked",(function(){for(var e,a,c=Object.keys(t.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(l.a)({},t.fileName,t))}),{})),r={},i=function(){var e=f[o],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.timestamp<n.current.currentTime}));if(!a.length)return"continue";var c=a.pop();r[e]=c},o=0,f=c;o<f.length;o++)i();v.current=r;for(var m=0,d=Object.values(r);m<d.length;m++){var b=d[m];b.timestamp<a||(a=b.timestamp,e=b.fileName)}N(e),s("")}))}),[]),d)return"";var C=o||y;return c.a.createElement("div",{className:("inline"===r?"col-md-4":"col-md-12")+" p-0",style:{height:n.current.clientHeight,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(v.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center",style:{backgroundColor:C===n?"black":"rgb(35, 36, 31)",color:C===n?"white":"grey",width:parseInt(100/Object.values(v.current).length)+"%",borderBottom:"1px solid lightgrey",height:"30px",display:"inline-block",cursor:"pointer"},onClick:function(){(y!==n||o)&&s(n)}},n)})),c.a.createElement("div",{className:"overflow-auto"},Object.entries(v.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return C===n})).map((function(e){var t=Object(m.a)(e,2),a=t[0],r=t[1];return c.a.createElement("div",{style:{height:n.current.clientHeight-30-(o?45:0),fontSize:"".concat(f,"px")},key:a,className:"font-family-monospace"},c.a.createElement(b.a,{className:r.languageName},r.content))}))))}var C=n(18),x=n.n(C),S=n(43);function L(e){var t=e.gifUrl,n=Object(a.useState)([]),r=Object(m.a)(n,2),i=r[0],l=r[1],o=Object(a.useState)(!0),d=Object(m.a)(o,2),b=d[0],v=d[1],p=Object(a.useRef)([]),g=Object(a.useRef)(2);Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return v(!0),e.next=3,S({url:t,frames:"all",outputType:"canvas",cumulative:!0});case 3:n=e.sent,v(!1),g.current=n.length,p.current=n,E({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var j=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(u.a)(Object(u.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),O=Object(m.a)(j,2),h=O[0],E=O[1];return Object(a.useEffect)((function(){p.current[0]&&(l((function(e){return p.current[0]?e.concat([p.current[0].getImage()]):e})),p.current.shift(),setTimeout((function(){E({type:"UPDATE"})}),0))}),[h.calcCount]),b?c.a.createElement("div",{className:"d-flex flex-column align-items-center justify-content-center p-5 bg-light"},c.a.createElement("div",{className:"row mb-2 text-danger"},c.a.createElement("div",{className:"spinner-border",role:"status"},c.a.createElement("span",{className:"sr-only"},"Bet\xf6lt\xe9s..."))),c.a.createElement("div",{className:"row text-dark"},c.a.createElement("strong",null,"Bet\xf6lt\xe9s..."))):i.length>0?c.a.createElement(A,{frames:i,total:g.current,calcCount:h.calcCount}):""}function A(e){var t=e.frames,n=e.total,r=e.calcCount,i=Object(a.createRef)(),l=Object(a.useState)(0),o=Object(m.a)(l,2),s=o[0],u=o[1],f=Object(a.useRef)(),d=Object(a.useState)(!1),b=Object(m.a)(d,2),v=b[0],p=b[1];return Object(a.useEffect)((function(){if(i.current&&!v){var e=f.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;i.current.width=n.width*a,i.current.height=n.height*a,i.current.getContext("2d").scale(a,a),i.current.getContext("2d").drawImage(n,0,0),p(!0)}}),[i]),Object(a.useEffect)((function(){if(void 0!==t[s]){var e=t[s],n=f.current.offsetWidth,a=n/e.width<1?n/e.width:1;i.current.width=e.width*a,i.current.height=e.height*a,i.current.getContext("2d").scale(a,a),i.current.getContext("2d").drawImage(e,0,0)}}),[s]),t.length?c.a.createElement("div",{className:"text-center",ref:f},c.a.createElement("canvas",{className:"text-center m-auto",ref:i}),c.a.createElement("div",{className:"main-scroller"},c.a.createElement(x.a,{formatLabel:function(){return""},minValue:0,maxValue:n-1,value:s,onChange:function(e){e>r||u(e)}})),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(x.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:n+1,value:r,onChange:function(){}}))):""}var R=n(43);function I(e){var t=e.fileChangesURL,n=e.gifUrl,r=e.showFrameNumber,i=e.layout,o=Object(a.useState)([]),d=Object(m.a)(o,2),b=d[0],v=d[1],p=Object(a.useState)(!0),g=Object(m.a)(p,2),j=g[0],O=g[1],h=Object(a.useState)([]),E=Object(m.a)(h,2),y=E[0],N=E[1],k=Object(a.useRef)([]),w=Object(a.useRef)(1);Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return O(!0),e.next=3,R({url:n,frames:"all",outputType:"canvas",cumulative:!0});case 3:t=e.sent,O(!1),w.current=t.length,k.current=t,L({type:"UPDATE"});case 8:case"end":return e.stop()}}),e)})))()}),[]);var C=Object(a.useReducer)((function(e,t){switch(t.type){case"UPDATE":return Object(u.a)(Object(u.a)({},e),{},{calcCount:e.calcCount+1});default:throw new Error("Invalid Action Type")}}),{calcCount:0}),x=Object(m.a)(C,2),S=x[0],L=x[1];return Object(a.useEffect)((function(){k.current[0]&&(N((function(e){return k.current[0]?e.concat([k.current[0].getImage()]):e})),k.current.shift(),setTimeout((function(){L({type:"UPDATE"})}),0))}),[S.calcCount]),Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var n,a,c,r,i;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(t).catch(console.log);case 2:if((n=e.sent).ok){e.next=5;break}return e.abrupt("return");case 5:return e.next=7,n.text();case 7:a=e.sent,c=new DOMParser,r=c.parseFromString(a,"text/xml"),i=Array.from(r.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(l.a)({},t.localName,"frame"===t.localName?parseInt(t.innerHTML):t.innerHTML))}),{})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})),v(i.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:W(e.fileName)})})));case 12:case"end":return e.stop()}}),e)})))()}),[]),j?c.a.createElement("div",{className:"d-flex flex-column align-items-center justify-content-center p-5 bg-light"},c.a.createElement("div",{className:"row mb-2 text-danger"},c.a.createElement("div",{className:"spinner-border",role:"status"},c.a.createElement("span",{className:"sr-only"},"Bet\xf6lt\xe9s..."))),c.a.createElement("div",{className:"row text-dark"},c.a.createElement("strong",null,"Bet\xf6lt\xe9s..."))):y.length>0?c.a.createElement(T,{frames:y,fileChanges:b,showFrameNumber:r,layout:i,total:w.current,calcCount:S.calcCount}):""}function T(e){var t=e.frames,n=e.fileChanges,r=e.showFrameNumber,i=e.layout,l=e.total,o=e.calcCount,s=Object(a.createRef)(),u=Object(a.useState)(0),f=Object(m.a)(u,2),d=f[0],b=f[1],v=Object(a.useRef)(),p=Object(a.useState)(0),g=Object(m.a)(p,2),j=g[0],O=g[1],h=Object(a.useState)(!1),E=Object(m.a)(h,2),y=E[0],N=E[1];return Object(a.useEffect)((function(){O(v.current.offsetHeight)}),[v.current]),Object(a.useEffect)((function(){if(s.current&&!y){var e=v.current.offsetWidth,n=t[0],a=e/n.width<1?e/n.width:1;s.current.width=n.width*a,s.current.height=n.height*a,s.current.getContext("2d").scale(a,a),s.current.getContext("2d").drawImage(n,0,0),N(!0)}}),[s]),Object(a.useEffect)((function(){if(t[d]){var e=t[d],n=v.current.offsetWidth,a=n/e.width<1?n/e.width:1;s.current.width=e.width*a,s.current.height=e.height*a,s.current.getContext("2d").scale(a,a),s.current.getContext("2d").drawImage(e,0,0)}}),[d]),"inline"===i?c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-7 p-0 mb-5",ref:v},c.a.createElement("canvas",{ref:s}),c.a.createElement("div",{className:"main-scroller"},l-1>0?c.a.createElement(x.a,{formatLabel:function(e){return r?e:""},minValue:0,maxValue:l-1,value:d,onChange:function(e){e>o||b(e)}}):""),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(x.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:l+1,value:o,onChange:function(){}}))),c.a.createElement("div",{className:"col-md-5 p-0 m-0"},v.current?c.a.createElement(U,{fileChanges:n,frame:d,height:j}):"")):void 0!==t.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"text-center mb-5",ref:v},c.a.createElement("canvas",{ref:s}),c.a.createElement("div",{className:"main-scroller"},l-1>0?c.a.createElement(x.a,{formatLabel:function(e){return r?e:""},minValue:0,maxValue:l-1,value:d,onChange:function(e){e>o||b(e)}}):""),c.a.createElement("div",{className:"buffer-indicator-track"},c.a.createElement(x.a,{disabled:!0,formatLabel:function(){return""},minValue:0,maxValue:l+1,value:o,onChange:function(){}}))),v.current?c.a.createElement(U,{fileChanges:n,frame:d,height:j}):""):""}function U(e){var t=e.fileChanges,n=e.frame,r=e.height,i=Object(a.useRef)({}),o=Object(a.useState)({}),s=Object(m.a)(o,2),f=(s[0],s[1],Object(a.useState)("")),d=Object(m.a)(f,2),v=d[0],p=d[1],g=Object(a.useState)(""),j=Object(m.a)(g,2),O=j[0],h=j[1];Object(a.useEffect)((function(){h("");for(var e,a,c=Object.keys(t.reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(l.a)({},t.fileName,t))}),{})),r={},o=function(){var e=f[s],a=t.filter((function(t){return t.fileName===e})).filter((function(e){return e.frame<n}));if(!a.length)return"continue";var c=a.pop();r[e]=c},s=0,f=c;s<f.length;s++)o();i.current=r;for(var m=0,d=Object.values(r);m<d.length;m++){var b=d[m];b.frame<a||(a=b.frame,e=b.fileName)}p(e)}),[n]);var E=O||v;return c.a.createElement("div",{className:"col-md-12 p-0 overflow-auto",style:{height:r,backgroundColor:"rgb(35, 36, 31)"}},Object.entries(i.current).map((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return c.a.createElement("div",{key:n,className:"text-center p-2",style:{backgroundColor:E===n?"black":"rgb(35, 36, 31)",color:E===n?"white":"grey",width:parseInt(100/Object.values(i.current).length)+"%",borderBottom:"1px solid lightgrey",display:"inline-block",cursor:"pointer"},onClick:function(){(v!==n||O)&&h(n)}},n)})),Object.entries(i.current).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return E===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return c.a.createElement("div",{key:n,className:"font-family-monospace"},c.a.createElement(b.a,{className:a.languageName},a.content))})))}function V(e){var t=e.videoId;return c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-12 p-0"},c.a.createElement(v.a,{opts:{width:"100%"},videoId:t}))))}function B(){var e=Object(a.useState)({}),t=Object(m.a)(e,2),n=t[0],r=t[1],i=Object(a.useState)(""),l=Object(m.a)(i,2),o=l[0],s=l[1],u=Object(a.useState)(16),f=Object(m.a)(u,2),d=f[0],v=f[1],p=Object(a.useState)(""),h=Object(m.a)(p,2),E=h[0],y=h[1],N=c.a.useMemo((function(){return new BroadcastChannel("codeAssistant")}),[]);c.a.useEffect((function(){N.postMessage({event:"clientConnected"}),N.onmessage=function(e){var t={refresh:function(e){r(e.files),s(e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop())},init:function(e){r(e.files),s(e.active&&Object.keys(e.files).includes(e.active)?e.active:Object.keys(e.files).pop())}}[e.data.event];t&&t(e.data.payload)}}),[]);var k=E||o;return c.a.createElement("div",{className:"col-md-12 p-0 w-100",style:{backgroundColor:"rgb(35, 36, 31)"}},Object.entries(n).map((function(e){var t=Object(m.a)(e,2),a=t[0];t[1];return c.a.createElement("div",{key:a,className:"text-center p-2",style:{backgroundColor:k===a?"black":"rgb(35, 36, 31)",color:k===a?"white":"grey",width:parseInt(100/Object.values(n).length)+"%",borderBottom:"1px solid lightgrey",height:"30px",display:"inline-block",cursor:"pointer"},onClick:function(){(o!==a||E)&&y(a)}},a)})),c.a.createElement("div",{className:"overflow-auto"},Object.entries(n).filter((function(e){var t=Object(m.a)(e,2),n=t[0];t[1];return k===n})).map((function(e){var t=Object(m.a)(e,2),n=t[0],a=t[1];return c.a.createElement("div",{key:n,className:"font-family-monospace",style:{fontSize:"".concat(d,"px")}},c.a.createElement(b.a,{className:a.languageName},a.content))}))),c.a.createElement("div",{className:"row p-3"},c.a.createElement("div",{className:"btn-group fixed-bottom w-25"},c.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){v((function(e){return e-1}))},"data-tip":"Bet\u0171m\xe9ret cs\xf6kkent\xe9se"},c.a.createElement("small",null,c.a.createElement(g.a,{icon:j.f})),c.a.createElement(g.a,{icon:j.h}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-warning m-1",onClick:function(){v((function(e){return e+1}))},"data-tip":"Bet\u0171m\xe9ret n\xf6vel\xe9se"},c.a.createElement("small",null,c.a.createElement(g.a,{icon:j.g})),c.a.createElement(g.a,{icon:j.h}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),c.a.createElement("button",{className:"btn btn-sm btn-danger m-1",onClick:function(){N.postMessage({event:"clientClosed"}),window.close()},"data-tip":"Bez\xe1r\xe1s"},c.a.createElement(g.a,{icon:j.i}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})),E?c.a.createElement("button",{className:"btn btn-sm btn-success m-1",onClick:function(){E&&y("")},"data-tip":"K\xf6vet\xe9s bekapcsol\xe1sa"},c.a.createElement(g.a,{icon:j.a}),c.a.createElement(O.a,{place:"top",type:"dark",effect:"float"})):"")))}var M=n(29),F=n(40),z=n.n(F);function P(e){var t,n=e.fileChangesURL,r=e.videoId,i=e.layout,o=e.wrapperClassName,d=Object(a.useRef)(),b=Object(a.useState)(),v=Object(m.a)(b,2),p=v[0],g=v[1],j=Object(a.useState)(0),O=Object(m.a)(j,2),h=O[0],k=O[1],w=Object(a.useState)(),C=Object(m.a)(w,2),x=C[0],S=C[1],L=Object(a.useState)(""),A=Object(m.a)(L,2),R=A[0],I=A[1],T=Object(a.useState)(!1),U=Object(m.a)(T,2),V=U[0],B=U[1],F=Object(a.useState)(16),P=Object(m.a)(F,2),D=P[0],H=P[1];try{t=new BroadcastChannel("codeAssistant")}catch(X){t={onmessage:function(){},postMessage:function(){},close:function(){},noop:!0}}c.a.useMemo((function(){return t}),[]),c.a.useEffect((function(){return t.onmessage=function(e){"clientClosed"===e.data.event&&B(!1)},t.close}),[]),Object(a.useEffect)((function(){S(i)}),[]),Object(a.useEffect)((function(){var e=document.querySelector(".".concat(o));e&&("inline"===x?(e.classList.add("kodseged-inline"),e.classList.remove("kodseged-block")):(e.classList.add("kodseged-block"),e.classList.remove("kodseged-inline")))}),[x]);var q=Object(a.useState)([]),J=Object(m.a)(q,2),K=J[0],G=J[1];function Y(e){return $.apply(this,arguments)}function $(){return($=Object(f.a)(s.a.mark((function e(t){var n,a,c;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,t.text();case 2:return n=e.sent,a=new DOMParser,c=a.parseFromString(n,"text/xml"),e.abrupt("return",Array.from(c.firstChild.children).map((function(e){return Array.from(e.children).reduce((function(e,t){return Object(u.a)(Object(u.a)({},e),{},Object(l.a)({},t.localName,t.innerHTML))}),{})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{timestamp:z()(e.timestamp,"mm:ss").diff(z()().startOf("day"),"seconds")})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("&gt;",">").replace("&lt;","<")})})).map((function(e){return Object(u.a)(Object(u.a)({},e),{},{content:e.content.replace("<![CDATA[\n","").replace("]]>","")})})));case 6:case"end":return e.stop()}}),e)})))).apply(this,arguments)}Object(a.useEffect)((function(){Object(f.a)(s.a.mark((function e(){var t,a,c,r;return s.a.wrap((function(e){for(;;)switch(e.prev=e.next){case 0:return e.next=2,fetch(n).catch(console.log);case 2:if(!(a=e.sent)||a.ok){e.next=5;break}return e.abrupt("return");case 5:if(c=Object.fromEntries(Array.from(a.headers.entries())),r=[],"application/xml"!==c["content-type"]){e.next=11;break}return e.next=10,Y(a);case 10:r=e.sent;case 11:if("application/json"!==c["content-type"]){e.next=15;break}return e.next=14,a.json().catch(console.log);case 14:r=e.sent;case 15:if(null===(t=r)||void 0===t?void 0:t.length){e.next=17;break}return e.abrupt("return");case 17:G(r.map((function(e){return Object(u.a)(Object(u.a)({},e),{},{languageName:W(e.fileName)})})));case 18:case"end":return e.stop()}}),e)})))()}),[]);var _=Object(a.useRef)(),Q=Object(a.useRef)(0);return K.length?c.a.createElement(a.Fragment,null,c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{ref:_,className:("inline"===x?"col-md-8":"col-md-12")+" p-0 pr-1 border-right border-dark",style:{backgroundColor:"rgb(35, 36, 31)"}},c.a.createElement(M.a,{video:r,responsive:!0,onReady:function(e){d.current=e.element,g(1)},onTimeUpdate:function(e){Q.current=e.seconds},onSeeked:function(e){k((function(e){return e+1}))}})),p?c.a.createElement(N,{containerRef:_,fontSize:D,channel:t,isVisible:V,className:"w-100",fileChanges:K,videoReference:d,videoStateChanged:h,currentLayout:x,setCurrentLayout:S,setExplicitelyActive:I,explicitelyActive:R,getCurrentTime:function(){return Q.current}}):y(x)),c.a.createElement(E,{setFontSize:H,currentLayout:x,setCurrentLayout:S,isVisible:V,setVisible:B,explicitelyActive:R,setExplicitelyActive:I,channel:t}))):c.a.createElement("div",{className:"text-center"},"Bet\xf6lt\xe9s...")}function D(e){var t=e.videoId;return c.a.createElement("div",{className:"container-fluid"},c.a.createElement("div",{className:"row"},c.a.createElement("div",{className:"col-md-12 p-0"},c.a.createElement(M.a,{video:t,responsive:!0}))))}function H(e){var t=e.fileChangesURL,n=e.videoURL,a=e.gifURL,r=e.type,i=e.showFrameNumber,l=e.layout,o=e.videoId,s=e.wrapperClassName,u={codeAssistantYoutube:function(){return c.a.createElement(h,{layout:l,fileChangesURL:t,videoId:o,wrapperClassName:s})},codeAssistantVimeo:function(){return c.a.createElement(P,{layout:l,fileChangesURL:t,videoId:o,wrapperClassName:s})},youtube:function(){return c.a.createElement(V,{videoId:o})},vimeo:function(){return c.a.createElement(D,{videoId:o})},onSite:function(){return c.a.createElement(k,{layout:l,fileChangesURL:t,videoURL:n})},gif:function(){return c.a.createElement(L,{gifUrl:a})},codeAssistantGif:function(){return c.a.createElement(I,{fileChangesURL:t,gifUrl:a,showFrameNumber:i,layout:l})},codeAssistantClient:function(){return c.a.createElement(B,null)}}[r];return u?u():"Invalid type (".concat(r,")")}function W(e){var t=e?e.substr(e.lastIndexOf(".")+1):"plaintext";return"txt"===t?"plaintext":t}Boolean("localhost"===window.location.hostname||"[::1]"===window.location.hostname||window.location.hostname.match(/^127(?:\.(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)){3}$/));n(363);!function(){var e=document.getElementsByClassName("kodseged");e.length&&(new URLSearchParams(window.location.search).get("isFullPageClientApp")?Array.from(e).filter((function(e){return"codeAssistantClient"===e.dataset.type})).forEach(t):Array.from(e).filter((function(e){return"codeAssistantClient"!==e.dataset.type})).forEach(t),"serviceWorker"in navigator&&navigator.serviceWorker.ready.then((function(e){e.unregister()})).catch((function(e){console.error(e.message)})));function t(e){var t,n,a,r,l,o,s,u;i.a.render(c.a.createElement(c.a.StrictMode,null,c.a.createElement(H,{wrapperClassName:null===(t=e.dataset)||void 0===t?void 0:t.wrapperclassname,fileChangesURL:null===(n=e.dataset)||void 0===n?void 0:n.filechangesurl,videoURL:null===(a=e.dataset)||void 0===a?void 0:a.videourl,videoId:null===(r=e.dataset)||void 0===r?void 0:r.videoid,type:null===(l=e.dataset)||void 0===l?void 0:l.type,gifURL:null===(o=e.dataset)||void 0===o?void 0:o.gifurl,showFrameNumber:Boolean(null===(s=e.dataset)||void 0===s?void 0:s.showframenumber),layout:null===(u=e.dataset)||void 0===u?void 0:u.layout})),e)}}()},74:function(e,t,n){e.exports=n(364)},79:function(e,t,n){}},[[74,1,2]]]);
//# sourceMappingURL=main.9e642ccb.chunk.js.map