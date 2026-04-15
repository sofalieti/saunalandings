var ready = (callback) => {
  if (document.readyState != "loading") callback();
  else document.addEventListener("DOMContentLoaded", callback);
}
var ifrm, content, script_tag;
ready(() => { 
    content = document.getElementById('isprts_widget');
    ifrm = document.createElement("iframe");
    
    script_tag = document.querySelector('script[isprts-widget-id]');
    
    console.log(script_tag);
    
    //container = content;
    
    content.innerHTML = '<div id="loader">Load...</div>';
    
    setTimeout(function(){
        ifrm.setAttribute("src", "https://wasaunapart.com/test_api/test_api.php");
        ifrm.setAttribute("frameborder", 0);
        //ifrm.setAttribute("onload", "iframe_loaded(this);");
        ifrm.setAttribute("scrolling", 'no');
        ifrm.setAttribute("allowTransparency", 'true');
        ifrm.width = '100%';
        ifrm.height = '0';
        ifrm.style.opacity = 0;
        content.appendChild(ifrm);
        ifrm.onload = function() {
            /*var height = ifrm.contentWindow.document.body.scrollHeight;
            ifrm.height = height + 'px';
            ifrm.style.opacity = 1;
            document.getElementById('loader').remove();*/
            //var win = window.ifrm;
            //window.postMessage("hello there!", "http://example.com");
        }
    }, 500);
    
    
    //alert(ifrm.contentWindow.document.body.scrollHeight);
    if (window.addEventListener) {
        window.addEventListener("message", listener);
    } else {
        // IE8
        window.attachEvent("onmessage", listener);
    }
    
});

function listener(event) {
    ifrm.height = parseInt(event.data)+300 + 'px';
    ifrm.style.opacity = 1;
    document.getElementById('loader').remove();
    //alert( "получено: " + event.data );
}

function iframe_loaded(ifrm){
    //console.log(content);
    //container.innerHTML = '';
    var height = ifrm.contentWindow.document.body.scrollHeight;
    ifrm.height = height + 'px';
    ifrm.style.opacity = 1;
}