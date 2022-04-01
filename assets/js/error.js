const error =document.querySelector("#error");
const errorClose =document.querySelector("#error-close");
const errorCard =document.querySelector("#error-card");
errorCard.style.display ='none';
const url = window.location.href;
function parseURLParams(url) {
    var queryStart = url.indexOf("?") + 1,
        queryEnd   = url.indexOf("#") + 1 || url.length + 1,
        query = url.slice(queryStart, queryEnd - 1),
        pairs = query.replace(/\+/g, " ").split("&"),
        parms = {}, i, n, v, nv;

    if (query === url || query === "") return;

    for (i = 0; i < pairs.length; i++) {
        nv = pairs[i].split("=", 2);
        n = decodeURIComponent(nv[0]);
        v = decodeURIComponent(nv[1]);

        if (!parms.hasOwnProperty(n)) parms[n] = [];
        parms[n].push(nv.length === 2 ? v : null);
    }
    return parms;
}
const params = parseURLParams(window.location.href);
try{
    if (params.error) {
        error.innerText = params.error;
        errorCard.style.display = 'block';
    }
}catch{}
errorClose.addEventListener('click',()=>{
    console.log(window.location.href);
    const url =String(window.location.href);
    if(url.includes("register")){
        window.location.href = 'register.html';
    }
    else if(url.includes("login")){
        window.location.href = 'login.html';
    }
})




