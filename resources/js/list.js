window.loadHtmlListBody = function (nodeId, parentRowIdQS, targetId) {
    document.getElementById(targetId).innerHTML = '<div class="w-100 mt-5 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>';

    const xhttp = new XMLHttpRequest();
    xhttp.onload = function () {
        document.getElementById(targetId).innerHTML = this.responseText;
    }
    var request = "/render/" + nodeId + "/ajax";
    if (parentRowIdQS) {
        request += "?" + parentRowIdQS;
    }
    xhttp.open("GET", request);
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();
}

window.createRefreshHtmlListBody = function (formId, parentRowId, targetId) {
	window.refreshEvtHtmlListBody = new CustomEvent("refreshHtmlListBody", {
		detail: {
			formId: formId,
            parentRowId: parentRowId,
			targetId: targetId
		}
	});
	window.dispatchEvent(window.refreshEvtHtmlListBody);
}

window.refreshHtmlListBody = function() {
	window.dispatchEvent(window.refreshEvtHtmlListBody);
}

window.addEventListener('refreshHtmlListBody', function (event) {
	loadHtmlListBody(event.detail.formId, event.detail.parentRowId, event.detail.targetId);
})
