(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["chunk-01b24e83"],{4886:function(t,e,o){"use strict";o.r(e);var a=function(){var t=this,e=t.$createElement,o=t._self._c||e;return o("div",{staticClass:"category d-flex flex-column"},[o("div",{staticClass:"container container-main d-flex flex-grow-1"},[o("div",{staticClass:"container-inner"},[o("div",{staticClass:"products"},[o("h2",{staticClass:"title products__title text-center"},[t._v(t._s("new"===t.$route.name?t.$route.path.split("-").join(" ").toUpperCase().split("/").pop():t.$route.params.name.split("-").join(" ").toUpperCase()))]),o("div",{staticClass:"d-flex flex-wrap align-items-start justify-content-start"},t._l(t.products,function(e){return o("router-link",{key:e.id,staticClass:"product",attrs:{to:{name:t.$route.name+"-product",params:{id:e.id}},tag:"a"}},[o("transition",{attrs:{name:"show-product"}},[o("app-product",{attrs:{element:e,hoverText:t.hoverText}})],1)],1)}),1)])])])])},n=[],i=(o("28a5"),o("ac6a"),o("7f7f"),o("cebc")),s=o("bc3a"),c=o.n(s),r=o("be6f"),l=o("2f62"),u=o("9c9e"),d={name:"category",data:function(){return{categories:"",collections:"",categoryId:"",collectionId:"",products:[],total:"",page:1,hoverText:"Подробнее",domen:"http://mersh-jewelry.com"}},created:function(){this.domen=location.origin,this.page=1,this.getCategories(),window.addEventListener("scroll",this.showVisible)},beforeDestroy:function(){this.scroll(0),window.removeEventListener("scroll",this.showVisible)},computed:Object(i["a"])({},Object(l["c"])([])),methods:{fetch:function(){var t=this;if("new"===t.$route.name)var e=t.domen+"/api/products/"+t.$route.name+"/"+t.page;else if("category"===t.$route.name)e=t.domen+"/api/products/"+t.$route.name+"/"+t.categoryId+"/"+t.page;else if("collection"===t.$route.name)e=t.domen+"/api/products/"+t.$route.name+"/"+t.collectionId+"/"+t.page;c.a.get(e).then(function(e){for(var o=0;o<e.data.products.length;o++)t.products.push(e.data.products[o]);t.total=e.data.total}).catch(function(e){console.log(e),t.products=[],t.page=1,t.total=0})},showVisible:function(){var t=document.getElementsByClassName("product"),e=t[t.length-1];this.isVisible(e)&&this.page<Math.ceil(this.total/12)&&(this.page+=1,this.fetch())},getCategories:function(){var t=this;c.a.get(t.domen+"/api/info/main").then(function(e){t.categories=e.data.categories,t.collections=e.data.collections,t.getCategoryId(),t.fetch()}).catch(function(t){return console.log(t)})},getCategoryId:function(){var t=this;t.products=[],t.page=1,t.total=0,"category"===t.$route.name?this.categories.forEach(function(e){e.name.toLowerCase().split(" ").join("-")===t.$route.params.name&&(t.categoryId=e.id)}):"collection"===t.$route.name&&this.collections.forEach(function(e){e.name.toLowerCase().split(" ").join("-")===t.$route.params.name&&(t.collectionId=e.id)})}},components:{"app-product":r["a"]},mixins:[u["d"],u["e"],u["a"]]},p=d,f=(o("5b8d"),o("2877")),h=Object(f["a"])(p,a,n,!1,null,null,null);e["default"]=h.exports},"5b8d":function(t,e,o){"use strict";var a=o("f09d"),n=o.n(a);n.a},f09d:function(t,e,o){}}]);
//# sourceMappingURL=chunk-01b24e83.3c8f157b.js.map