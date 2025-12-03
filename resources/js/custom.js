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
	loadNode(event.detail.formId, event.detail.parentRowId, event.detail.targetId);
})

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
