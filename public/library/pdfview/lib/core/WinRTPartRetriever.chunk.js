/** Notice * This file contains works from many authors under various (but compatible) licenses. Please see core.txt for more information. **/
(function(){(window.wpCoreControlsBundle=window.wpCoreControlsBundle||[]).push([[17],{444:function(ia,ba,e){e.r(ba);var ea=e(1),x=e(245);ia=e(434);var ha=e(94);e=e(376);var ca={},da=function(e){function w(w,n){var h=e.call(this,w,n)||this;h.url=w;h.range=n;h.status=x.a.NOT_STARTED;return h}Object(ea.c)(w,e);w.prototype.start=function(e){var n=this;"undefined"===typeof ca[this.range.start]&&(ca[this.range.start]={ku:function(h){var f=atob(h),r,w=f.length;h=new Uint8Array(w);for(r=0;r<w;++r)h[r]=f.charCodeAt(r);
f=h.length;r="";for(var x=0;x<f;)w=h.subarray(x,x+1024),x+=1024,r+=String.fromCharCode.apply(null,w);n.ku(r,e)},AS:function(){n.status=x.a.ERROR;e({code:n.status})}},window.external.Bpa(this.url),this.status=x.a.STARTED);n.tC()};return w}(ia.ByteRangeRequest);ia=function(e){function w(w,n,h,f){w=e.call(this,w,h,f)||this;w.Tx=da;return w}Object(ea.c)(w,e);w.prototype.Rv=function(e,n){return e+"?"+n.start+"&"+(n.stop?n.stop:"")};return w}(ha.a);Object(e.a)(ia);Object(e.b)(ia);ba["default"]=ia}}]);}).call(this || window)