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




/*
window.loadNode = function (nodeId, parentRowIdQS, targetId) {
    document.getElementById(targetId).innerHTML = '<div class="w-100 mt-5 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>';

    const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById(targetId).innerHTML = this.responseText;
  }
  var request = "/render/" + nodeId;
  if (parentRowIdQS) {
      request += "?" + parentRowIdQS;
  }
  xhttp.open("GET", request);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.send();
}


window.loadRow = function (rowId, targetId) {
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById(targetId).innerHTML = this.responseText;
  }
  xhttp.open("GET", "/rows/" + rowId);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
  xhttp.send();
}


window.submitRow = function (form, targetId, others) {
  event.preventDefault();

  document.getElementById('globalModalBody').innerHTML = '<div class="w-100 text-center"><div class="spinner-border" style="width: 3rem; height: 3rem;" role="status"><span class="visually-hidden">Loading...</span></div></div>';
  const xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
	document.getElementById(targetId).innerHTML = this.responseText;
	window.refresh();
  }
  xhttp.open(form.method, form.action);
  xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");

  let formData = new FormData(form);
  if (others) {
      others.forEach((input) => {
          formData.set(input.name, input.value);
      })
  }
  xhttp.send(formData);
}

window.deleteRow = function (rowId) {
    if(confirm("Confermi di voler cancellare il record selezionato ?")) {
        const xhttp = new XMLHttpRequest();
        xhttp.onload = function () {
            window.refresh();
        }
        xhttp.open("GET", "/rows/" + rowId + "/delete");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();
    }
}

*/



window.createRefresh = function (formId, parentRowId, targetId) {
	window.refreshEvt = new CustomEvent("refresh", {
		detail: {
			formId: formId,
            parentRowId: parentRowId,
			targetId: targetId
		}
	});
	window.dispatchEvent(window.refreshEvt);
}

window.refresh = function() {
	window.dispatchEvent(window.refreshEvt);
}

window.addEventListener('refresh', function (event) {
    let nodeId = event.detail.formId;
    let parentRowId = event.detail.parentRowId;
    let qs = null;
    if (parentRowId) {
        qs = '?parent_row_id=' + parentRowId;
    }
    let targetId = event.detail.targetId;
    ajaxGET('/render/' + nodeId + qs, targetId);
})

/*
window.yes = function(selectedNodeId) {
    event.preventDefault();

    let others = [{
        name: "new_node_id",
        value: selectedNodeId
    }]

    submitRow(event.target.form, 'globalModalBody', others);
}


window.back = function () {
    event.preventDefault();

    let others = [{
        name: "back",
        value: true
    }]

    submitRow(event.target.form, 'globalModalBody', others);
}
 */




