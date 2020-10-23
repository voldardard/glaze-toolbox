//Utils
function fetchJson(method, url, callback){
    console.log(url);
    const headers = new Headers({
        'accept': 'application/json'
    });

    fetch(url, {
        method: method,
        headers,
    }).then(function(response) {
        if (!response.ok) {
            throw Error('error:'+response.statusText+' statuscode:'+response.status);

        }else{
            return response.json();
        }
    }).then(data => {
        callback(data);
    });
}

//-------------
function translate(key) {
    if (key in lang) {
        return lang[key];
    } else {
        return key;
    }
}
function start_loading(icon, name="fa-check-circle"){
    console.log('start_loading');
    icon.classList.remove(name);
    icon.classList.add("fa-spinner");
}
function stop_loading(icon, name="fa-check-circle"){
    console.log('stop_loading');
    icon.classList.remove("fa-spinner");
    icon.classList.add(name);
}
