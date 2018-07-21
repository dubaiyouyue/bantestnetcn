//加入收藏 
;function AddFavorite(sURL, sTitle) { 
    sURL = encodeURI(sURL); 
    try{ 
        window.external.addFavorite(sURL, sTitle); 
    }catch(e) { 
        try{
            window.sidebar.addPanel(sTitle, sURL, ""); 
        }catch (e) { 
            alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置."); 
        } 
    } 
};