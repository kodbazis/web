(this["webpackJsonp16-login-system"]=this["webpackJsonp16-login-system"]||[]).push([[0],{34:function(e,t,s){},35:function(e,t,s){},60:function(e,t,s){"use strict";s.r(t);var c=s(0),n=s(1),a=s.n(n),r=s(27),i=s.n(r),l=(s(34),s(9)),o=(s(35),s(10)),j=s(2),u=s(8),b=s(13),d=s.n(b),h="";var m=d.a.create();function O(){var e=Object(j.g)(),t=Object(n.useState)(!1),s=Object(u.a)(t,2),a=s[0],r=s[1];return a?Object(c.jsx)("div",{className:"center-item",children:Object(c.jsx)("div",{className:"spinner-border text-danger"})}):Object(c.jsx)("div",{className:"container-fluid d-flex justify-content-center h-100 login-container",children:Object(c.jsxs)("div",{className:"card login-card",children:[Object(c.jsx)("div",{className:"card-header login-card-header",children:Object(c.jsx)("h3",{children:"Bejelentkez\xe9s"})}),Object(c.jsx)("div",{className:"card-body",children:Object(c.jsxs)("form",{onSubmit:function(t){var s,c;t.preventDefault(),r(!0),(s=t.target.elements.email.value,c=t.target.elements.password.value,d.a.post("https://kodbazis.hu/api/login-user",{email:s,password:c},{withCredentials:!0}).then((function(e){h=e.data.accessToken}))).then((function(){r(!1),e.push("/react-kurzus/bejelentkezesi-felulet-epitese?url=/osszes-szallas")})).catch((function(e){alert("Helytelen bejelentkez\xe9si adatok, k\xe9rj\xfck pr\xf3b\xe1ld \xfajra!"),r(!1)}))},children:[Object(c.jsx)("div",{className:"input-group form-group",children:Object(c.jsx)("input",{type:"email",name:"email",className:"form-control",placeholder:"Email"})}),Object(c.jsx)("div",{className:"input-group form-group",children:Object(c.jsx)("input",{type:"password",name:"password",className:"form-control",placeholder:"Jelsz\xf3"})}),Object(c.jsx)("div",{className:"form-group",children:Object(c.jsx)("button",{type:"submit",className:"btn float-right btn-warning",children:"K\xfcld\xe9s"})})]})})]})})}function x(){var e=Object(j.g)();return Object(c.jsx)("button",{className:"btn btn-danger m-3 float-right",onClick:function(){m.post("https://kodbazis.hu/api/logout-user").catch(console.log).finally((function(){e.push("/react-kurzus/bejelentkezesi-felulet-epitese?url=/")}))},children:"Kijelentkez\xe9s"})}function p(){var e=Object(n.useState)([]),t=Object(u.a)(e,2),s=t[0],a=t[1],r=Object(n.useState)(!1),i=Object(u.a)(r,2),l=i[0],b=i[1],d=Object(j.g)();return Object(n.useEffect)((function(){b(!0),m.get("https://kodbazis.hu/api/szallasok").then((function(e){return e.data})).then((function(e){b(!1),a(e)})).catch((function(){b(!1),d.push("/react-kurzus/bejelentkezesi-felulet-epitese?url=/")}))}),[]),l||!s.length?Object(c.jsx)("div",{className:"center-item",children:Object(c.jsx)("div",{className:"spinner-border text-danger"})}):Object(c.jsxs)("div",{children:[Object(c.jsx)(x,{}),Object(c.jsxs)("ul",{className:"list-group w-100",children:[Object(c.jsxs)("div",{className:"row border-bottom p-2 text-dark",children:[Object(c.jsx)("div",{className:"col-xs-12 col-sm-4",children:Object(c.jsx)("h5",{className:"visible-xs",children:"Megnevez\xe9s"})}),Object(c.jsx)("h5",{className:"col-xs-4 col-sm-2 right",children:"Helysz\xedn"}),Object(c.jsx)("h5",{className:"col-xs-8 col-sm-3",children:"Minimum \xe9jszak\xe1k sz\xe1ma"}),Object(c.jsx)("h5",{className:"col-xs-10 col-sm-2",children:"\xc1r"})]}),s.map((function(e){return Object(c.jsx)(o.b,{to:"/react-kurzus/bejelentkezesi-felulet-epitese?url=/szallas-"+e.id,children:Object(c.jsxs)("div",{className:"row border-bottom p-2 text-dark",children:[Object(c.jsxs)("div",{className:"col-xs-12 col-sm-4",children:[Object(c.jsx)("h4",{className:"visible-xs",children:e.name}),Object(c.jsx)("span",{className:"hidden-xs",children:e.host_name})]}),Object(c.jsxs)("div",{className:"col-xs-4 col-sm-2 right",children:[e.neighbourhood," ",e.neighbourhood_group]}),Object(c.jsx)("div",{className:"col-xs-8 col-sm-3",children:e.minimum_nights}),Object(c.jsxs)("div",{className:"col-xs-10 col-sm-2",children:[e.price,"$"]})]})},e.id)}))]})]})}function f(e){var t=e.id,s=Object(n.useState)({}),a=Object(u.a)(s,2),r=a[0],i=a[1],l=Object(n.useState)(!1),o=Object(u.a)(l,2),b=o[0],d=o[1],h=Object(j.g)();return Object(n.useEffect)((function(){d(!0),m.get("https://kodbazis.hu/api/szallasok/"+t).then((function(e){return e.data})).then((function(e){i(e),d(!1)})).catch((function(){d(!1),h.push("/react-kurzus/bejelentkezesi-felulet-epitese?url=/")}))}),[]),b||!r.id?Object(c.jsx)("div",{className:"center-item",children:Object(c.jsx)("div",{className:"spinner-border text-danger"})}):Object(c.jsxs)("div",{className:"card w-100 m-auto p-3",children:[Object(c.jsx)("h1",{children:r.name}),Object(c.jsx)("h3",{children:r.host_name}),Object(c.jsxs)("h3",{children:[r.neighbourhood," ",r.neighbourhood_group]}),Object(c.jsx)("h3",{children:r.minimum_nights}),Object(c.jsx)(x,{})]})}function g(){return Object(c.jsx)(o.a,{children:Object(c.jsxs)(j.d,{children:[Object(c.jsx)(j.b,{component:z,path:"/react-kurzus/bejelentkezesi-felulet-epitese"}),Object(c.jsx)(j.b,{path:"/bejelentkezes",exact:!0,component:O}),Object(c.jsx)(j.b,{path:"/osszes-szallas",component:p}),Object(c.jsx)(j.b,{path:"/szallas-:szallasId",children:function(e){return Object(c.jsx)(f,{id:e.match.params.szallasId})}}),Object(c.jsx)(j.a,{to:"/bejelentkezes"})]})})}function z(e){var t=new URLSearchParams(Object(j.h)().search).get("url");return t?"/osszes-szallas"===t?Object(c.jsx)(p,Object(l.a)({},e)):"/bejelentkezes"===t?Object(c.jsx)(O,Object(l.a)({},e)):t.includes("/szallas-")?Object(c.jsx)(f,{id:t.split("-")[1]}):Object(c.jsx)(j.a,{to:"/react-kurzus/bejelentkezesi-felulet-epitese?url=/bejelentkezes"}):Object(c.jsx)(j.a,{to:"/react-kurzus/bejelentkezesi-felulet-epitese?url=/bejelentkezes"})}m.interceptors.request.use((function(e){return h?Object(l.a)(Object(l.a)({},e),{},{headers:Object(l.a)(Object(l.a)({},e.headers),{},{Authorization:"Bearer ".concat(h)}),withCredentials:!0}):e}),(function(e){return Promise.reject(e)})),m.interceptors.response.use((function(e){return e}),(function(e){var t=e.config;return 403!==e.response.status||t.isRetry?Promise.reject(e):(t.isRetry=!0,d.a.get("https://kodbazis.hu/api/get-new-access-token",{withCredentials:!0}).then((function(e){h=e.data.accessToken})).then((function(){return m(t)})))}));var k=function(e){e&&e instanceof Function&&s.e(3).then(s.bind(null,61)).then((function(t){var s=t.getCLS,c=t.getFID,n=t.getFCP,a=t.getLCP,r=t.getTTFB;s(e),c(e),n(e),a(e),r(e)}))};s(59);i.a.render(Object(c.jsx)(a.a.StrictMode,{children:Object(c.jsx)(g,{})}),document.getElementById("root")),k()}},[[60,1,2]]]);
//# sourceMappingURL=main.09300e0e.chunk.js.map