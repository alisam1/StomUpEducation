$(".lector_about").readmore({speed:75,maxHeight:115,moreLink:'<a href="#">Подробнее</a>',lessLink:'<a href="#">Скрыть</a>'}),function(){var e=document.querySelector("#aside1"),t=null,n=0;function o(){if(null==t){for(var o=getComputedStyle(e,""),d="",i=0;i<o.length;i++)0!=o[i].indexOf("overflow")&&0!=o[i].indexOf("padding")&&0!=o[i].indexOf("border")&&0!=o[i].indexOf("outline")&&0!=o[i].indexOf("box-shadow")&&0!=o[i].indexOf("background")||(d+=o[i]+": "+o.getPropertyValue(o[i])+"; ");(t=document.createElement("div")).style.cssText=d+" box-sizing: border-box; width: "+e.offsetWidth+"px;",e.insertBefore(t,e.firstChild);var l=e.childNodes.length;for(i=1;i<l;i++)t.appendChild(e.childNodes[1]);e.style.height=t.getBoundingClientRect().height+"px",e.style.padding="0",e.style.border="0"}var r=e.getBoundingClientRect(),s=Math.round(r.top+t.getBoundingClientRect().height-document.querySelector(".events__popular").getBoundingClientRect().top+0);r.top-n<=0?r.top-n<=s?(t.className="stop",t.style.top=-s+"px"):(t.className="sticky",t.style.top=n+"px"):(t.className="",t.style.top=""),window.addEventListener("resize",function(){e.children[0].style.width=getComputedStyle(e,"").width},!1)}window.addEventListener("scroll",o,!1),document.body.addEventListener("scroll",o,!1)}();