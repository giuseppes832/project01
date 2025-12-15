window.ajaxGET = function(url, targetId, callback) {

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (targetId) {
            document.getElementById(targetId).innerHTML = this.responseText;
        }

        if (callback) {
            callback();
        }
    }
    xhttp.open("GET", url);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();

}


window.ajaxPOST = function (url, formData, targetId, callback) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (targetId) {
            document.getElementById(targetId).innerHTML = this.responseText;
        }
        if (callback) {
            callback();
        }
    }
    xhttp.open("POST", url);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send(formData);
}

window.ajaxPUT = function (url, formData, targetId, callback) {
    const xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
        if (targetId) {
            document.getElementById(targetId).innerHTML = this.responseText;
        }
        if (callback) {
            callback();
        }
    }
    xhttp.open("PUT", url);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send(formData);
}




