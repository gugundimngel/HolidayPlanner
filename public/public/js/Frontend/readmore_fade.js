/* jedfoster.github.io/Readmore.js */
!function(e){"function"==typeof define&&define.amd?define(["jquery"],e):"object"==typeof exports?module.exports=e(require("jquery")):e(jQuery)}(function(e){"use strict";function t(e,t,o){var i;return function(){var a=this,n=arguments,s=function(){i=null,o||e.apply(a,n)},r=o&&!i;clearTimeout(i),i=setTimeout(s,t),r&&e.apply(a,n)}}function o(e){var t=++l;return String(null==e?"rmjs-":e)+t}function i(e){var t=e.clone().css({height:"auto",width:e.width(),maxHeight:"none",overflow:"hidden"}).insertAfter(e),o=t.outerHeight(),i=parseInt(t.css({maxHeight:""}).css("max-height").replace(/[^-\d\.]/g,""),10),a=e.data("defaultHeight");t.remove();var n=i||e.data("collapsedHeight")||a;e.data({expandedHeight:o,maxHeight:i,collapsedHeight:n}).css({maxHeight:"none"})}function a(e){if(!d[e.selector]){var t=" ";e.embedCSS&&""!==e.blockCSS&&(t+=e.selector+" + [data-readmore-toggle], "+e.selector+"[data-readmore]{"+e.blockCSS+"}"),t+=e.selector+"[data-readmore]{transition: height "+e.speed+"ms;overflow: hidden;}",function(e,t){var o=e.createElement("style");o.type="text/css",o.styleSheet?o.styleSheet.cssText=t:o.appendChild(e.createTextNode(t)),e.getElementsByTagName("head")[0].appendChild(o)}(document,t),d[e.selector]=!0}}function n(t,o){this.element=t,this.options=e.extend({},r,o),a(this.options),this._defaults=r,this._name=s,this.init(),window.addEventListener?(window.addEventListener("load",h),window.addEventListener("resize",h)):(window.attachEvent("load",h),window.attachEvent("resize",h))}var s="readmore",r={speed:500,collapsedHeight:155,heightMargin:16,moreLink:'<a href="#" class="readmorelnk">[+] Read More</a>',lessLink:'<a href="#" class="readmorelnk">[-] Read Less</a>',embedCSS:!0,blockCSS:"display: block; width: 100%;",startOpen:!1,blockProcessed:function(){},beforeToggle:function(){},afterToggle:function(){}},d={},l=0,h=t(function(){e("[data-readmore]").each(function(){var t=e(this),o="true"===t.attr("aria-expanded");i(t),t.css({height:t.data(o?"expandedHeight":"collapsedHeight")})})},100);n.prototype={init:function(){var t=e(this.element);t.data({defaultHeight:this.options.collapsedHeight,heightMargin:this.options.heightMargin}),i(t);var a=t.data("collapsedHeight"),n=t.data("heightMargin");if(t.outerHeight(!0)<=a+n)return this.options.blockProcessed&&"function"==typeof this.options.blockProcessed&&this.options.blockProcessed(t,!1),!0;var s=t.attr("id")||o(),r=this.options.startOpen?this.options.lessLink:this.options.moreLink;t.attr({"data-readmore":"","aria-expanded":this.options.startOpen,id:s}),t.addClass("read-more-fade"),t.after(e(r).on("click",function(e){return function(o){e.toggle(this,t[0],o)}}(this)).attr({"data-readmore-toggle":s,"aria-controls":s})),this.options.startOpen||t.css({height:a}),this.options.blockProcessed&&"function"==typeof this.options.blockProcessed&&this.options.blockProcessed(t,!0)},toggle:function(t,o,i){i&&i.preventDefault(),t||(t=e('[aria-controls="'+this.element.id+'"]')[0]),o||(o=this.element);var a=e(o),n="",s="",r=!1,d=a.data("collapsedHeight");a.height()<=d?(n=a.data("expandedHeight")+"px",s="lessLink",r=!0,a.removeClass("read-more-fade")):(n=d,s="moreLink",a.addClass("read-more-fade")),this.options.beforeToggle&&"function"==typeof this.options.beforeToggle&&this.options.beforeToggle(t,a,!r),a.css({height:n}),a.on("transitionend",function(o){return function(){o.options.afterToggle&&"function"==typeof o.options.afterToggle&&o.options.afterToggle(t,a,r),e(this).attr({"aria-expanded":r}).off("transitionend")}}(this)),e(t).replaceWith(e(this.options[s]).on("click",function(e){return function(t){e.toggle(this,o,t)}}(this)).attr({"data-readmore-toggle":a.attr("id"),"aria-controls":a.attr("id")}))},destroy:function(){e(this.element).each(function(){var t=e(this);t.attr({"data-readmore":null,"aria-expanded":null}).css({maxHeight:"",height:""}).next("[data-readmore-toggle]").remove(),t.removeData()})}},e.fn.readmore=function(t){var o=arguments,i=this.selector;return t=t||{},"object"==typeof t?this.each(function(){if(e.data(this,"plugin_"+s)){var o=e.data(this,"plugin_"+s);o.destroy.apply(o)}t.selector=i,e.data(this,"plugin_"+s,new n(this,t))}):"string"==typeof t&&"_"!==t[0]&&"init"!==t?this.each(function(){var i=e.data(this,"plugin_"+s);i instanceof n&&"function"==typeof i[t]&&i[t].apply(i,Array.prototype.slice.call(o,1))}):void 0}});