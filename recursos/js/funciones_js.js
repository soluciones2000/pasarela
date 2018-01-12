
function doPay(event){
	alert("script");
	event.preventDefault();
	if(!doSubmit) {
		alert('entro');
    	var $form = document.querySelector('#pay');
		Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below
		return false;
	}
};

function sdkResponseHandler(status, response) {
	if (status != 200 && status != 201) {
		alert("verificar los datos introducidos");
	} else {
		var form = document.querySelector('#pay');
		var card = document.createElement('input');
		card.setAttribute('name',"token");
		card.setAttribute('type',"hidden");
		card.setAttribute('value',response.id);
		form.appendChild(card);
		doSubmit=true;
		form.submit();
	}
};
