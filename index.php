<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Pagar</title>
    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    <link href="css/bootstrap.css" rel="stylesheet">
	<link href="css/checkout.css" rel="stylesheet">
  </head>

  <body>
  
  <div class="container">
		<div class="principal">
  <h1>Checkout Transparente</h1>
  <table  class="table">
  	<tr>
  		<td></td>
  		<td><h3>Cartoes de Teste</h3></td>
  		<td></td>
  	</tr>
  	<tr>
	 	<td><p><img src="http://img.mlstatic.com/org-img/MP3/API/logos/visa.gif" align="center" style="margin:8px;" > 4235647728025682 </p></td>
		<td><p><img src="http://img.mlstatic.com/org-img/MP3/API/logos/master.gif" align="center" style="margin:8px;"> 5031433215406351 </p></td>
	  	<td><p><img src="http://img.mlstatic.com/org-img/MP3/API/logos/amex.gif" align="center" style="margin:8px;">375365153556885 </p></td>
	</tr>
  </table>
    
    <div class="container">
    <form action="payment.php" method="post" id="pay" name="pay" >
    	<table clas="table">
    
        <tr>
            <td><label for="email">Email</label></td>
            <td><input id="email" class="form-control" name="email" value="test_user_88379317@testuser.com" type="email" placeholder="your email"/></td>
        </tr>
            <tr>
                <td><label for="cardNumber">Credit card number:</label></td>
                <td><input type="text" id="cardNumber" data-checkout="cardNumber" class="form-control" placeholder="4509 9535 6623 3704" value="4509 9535 6623 3704" /></td>
            </tr>
            <tr>
                <td><label for="description">Description:</label></td>
                <td><input type="text" name="description" id="description" data-checkout="description" class="form-control" placeholder="My Product" value="My Product" /></td>
            </tr>            
            <tr>
                <td><label for="securityCode">Security code:</label></td>
                <td><input type="text" id="securityCode" data-checkout="securityCode" class="form-control" placeholder="123" value="123" /></td>
            </tr>
            <tr>
                <td><label for="cardExpirationMonth">Expiration month:</label></td>
                <td><input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" class="form-control" placeholder="12" value="12" /></td>
            </tr>
            <tr>
                <td><label for="cardExpirationYear">Expiration year:</label></td>
                <td><input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" class="form-control" placeholder="2015" value="2018" /></td>
            </tr>
            <tr>
                <td><label for="cardholderName">Card holder name:</label></td>
                <td><input type="text" id="cardholderName" data-checkout="cardholderName" class="form-control" placeholder="APRO" value="APRO" /></td>
            </tr>            	
            <tr>
                <td><label for="docNumber">Document number:</label></td>
                <td><input type="text" id="docNumber" data-checkout="docNumber" class="form-control" placeholder="48285482030" value="48285482030" /></td>
            </tr>
            <tr>
            	<td><label for="docNumber">Amount:</label></td>
            	<td><input type="number" class="form-control" name="amount" id="amount" value=""/></td>
            </tr>
            <tr>
              <td><label for="docNumber">Installments:</label></td>
              <td><select id="installments" class="form-control" name="installmentsOption"></select></td>
            </tr>
        	
        	<input data-checkout="docType" type="hidden" value="CPF"/>
            <input data-checkout="siteId" type="hidden" value="MLB"/>
        
        	<tr>
        		<td></td><td><input class="btn btn-primary" type="submit" value="Pay!" /></td>
        	</tr>
    
</table>
</form>
</div>
		</div>
	</div>   
  <br>
  <br>
  
    
  <script type="text/javascript">
    Mercadopago.setPublishableKey("TEST-366482ce-cbe8-4a57-9c08-6f08a60ed772");
    
    $(document).ready(function() {
    $("#amount").val(Math.floor(Math.random() * 600) + 10)
    });
    
    function addEvent(el, eventName, handler){
    if (el.addEventListener) {
           el.addEventListener(eventName, handler);
    } else {
        el.attachEvent('on' + eventName, function(){
          handler.call(el);
        });
    }
  };
    function getBin() {
        var ccNumber = document.querySelector('input[data-checkout="cardNumber"]');
        return ccNumber.value.replace(/[ .-]/g, '').slice(0, 6);
    };
    
    function guessingPaymentMethod(event) {
        var bin = getBin();
    
        if (event.type == "keyup") {
            if (bin.length >= 6) {
                Mercadopago.getPaymentMethod({
                    "bin": bin
                }, setPaymentMethodInfo);
            }
        } else {
            setTimeout(function() {
                if (bin.length >= 6) {
                    Mercadopago.getPaymentMethod({
                        "bin": bin
                    }, setPaymentMethodInfo);
                }
            }, 100);
        }
    };
    
    function setPaymentMethodInfo(status, response) {
        if (status == 200) {
            // do somethings ex: show logo of the payment method
            var form = document.querySelector('#pay');
    
            if (document.querySelector("input[name=paymentMethodId]") == null) {
                var paymentMethod = document.createElement('input');
                paymentMethod.setAttribute('name', "paymentMethodId");
                paymentMethod.setAttribute('type', "hidden");
                paymentMethod.setAttribute('value', response[0].id);
                form.appendChild(paymentMethod);
            } else {
                document.querySelector("input[name=paymentMethodId]").value = response[0].id;
            }
            
                var img = "<img src='" + response[0].thumbnail + "' align='center' style='margin-left:10px;' ' >";
                $("#bandeira").empty();
                $("#bandeira").append(img);
                amount = document.querySelector('#amount').value;
                Mercadopago.getInstallments({
                                              "bin": getBin(),
                                              "amount": amount
                                          }, setInstallmentInfo);
                
        }
    };
    
    addEvent(document.querySelector('input[data-checkout="cardNumber"]'), 'keyup', guessingPaymentMethod);
    addEvent(document.querySelector('input[data-checkout="cardNumber"]'), 'change', guessingPaymentMethod);
    
    doSubmit = false;
    addEvent(document.querySelector('#pay'),'submit',doPay);
    
    function doPay(event){
    event.preventDefault();
      if(!doSubmit){
          var $form = document.querySelector('#pay');
          
          Mercadopago.createToken($form, sdkResponseHandler); // The function "sdkResponseHandler" is defined below
  
          return false;
      }
    };
    
    function sdkResponseHandler(status, response) {
    if (status != 200 && status != 201) {
        alert("verify filled data");
    }else{
       
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
    function setInstallmentInfo(status, response) {
    var selectorInstallments = document.querySelector("#installments"),
        fragment = document.createDocumentFragment();
    selectorInstallments.options.length = 0;
    if (response.length > 0) {
        var option = new Option("Choose...", '-1'),
            payerCosts = response[0].payer_costs;
        fragment.appendChild(option);
        for (var i = 0; i < payerCosts.length; i++) {
            option = new Option(payerCosts[i].recommended_message || payerCosts[i].installments, payerCosts[i].installments);
            fragment.appendChild(option);
        }
        selectorInstallments.appendChild(fragment);
        selectorInstallments.removeAttribute('disabled');
    }
  };
    
    
    </script>
  </body>
</html>