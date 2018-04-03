
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Checkout</title>

    <script src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
    
  </head>

  <body>

<form action="payment.php" method="post" id="pay" name="pay" >
    <fieldset>
        <ul>
            <li>
                <label for="email">Email</label>
                <input id="email" name="email" value="test_user_19653727@testuser.com" type="email" placeholder="your email"/>
            </li>
            <li>
                <label for="cardNumber">Credit card number:</label>
                <input type="text" id="cardNumber" data-checkout="cardNumber" placeholder="4509 9535 6623 3704" value="4509 9535 6623 3704" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
            </li>
            <li>
                <label for="securityCode">Security code:</label>
                <input type="text" id="securityCode" data-checkout="securityCode" placeholder="123" value="123" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
            </li>
            <li>
                <label for="cardExpirationMonth">Expiration month:</label>
                <input type="text" id="cardExpirationMonth" data-checkout="cardExpirationMonth" placeholder="12" value="12" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
            </li>
            <li>
                <label for="cardExpirationYear">Expiration year:</label>
                <input type="text" id="cardExpirationYear" data-checkout="cardExpirationYear" placeholder="2018" value="2018" onselectstart="return false" onpaste="return false" onCopy="return false" onCut="return false" onDrag="return false" onDrop="return false" autocomplete=off />
            </li>
            <li>
                <label for="cardholderName">Card holder name:</label>
                <input type="text" id="cardholderName" data-checkout="cardholderName" placeholder="APRO" value="APRO" />
            </li>
            <li>
                <label for="docType">Document type:</label>
                <input id="docType" data-checkout="docType" value="CPF"/>
            	<input data-checkout="siteId" type="hidden" value="MLB"/>
            </li>
            <li>
                <label for="docNumber">Document number:</label>
                <input type="text" id="docNumber" data-checkout="docNumber" placeholder="82447571321" value="82447571321" />
            </li>
        </ul>
        <input type="hidden" name="paymentMethodId" />
        <input type="submit" value="Pay!" />
    </fieldset>
</form>


<script type="text/javascript">
    Mercadopago.setPublishableKey("TEST-dec04a88-a2a6-41c4-a6d8-f108de942aac");

    //lista de documentos disponíveis
    Mercadopago.getIdentificationTypes();

    //
    Mercadopago.getPaymentMethod({
    "bin": bin //6 primeiros dígitos do cartão
}, setPaymentMethodInfo);


function setPaymentMethodInfo(status, response) {
    if (status == 200) {
        paymentMethod.setAttribute('name', "paymentMethodId");
        paymentMethod.setAttribute('type', "hidden");
        paymentMethod.setAttribute('value', response[0].id);

        form.appendChild(paymentMethod);
        } else {
            document.querySelector("input[name=paymentMethodId]").value = response[0].id;
        }
    }
};

doSubmit = false;
addEvent(document.querySelector('#pay'), 'submit', doPay);
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
        card.setAttribute('name', 'token');
        card.setAttribute('type', 'hidden');
        card.setAttribute('value', response.id);
        form.appendChild(card);
        doSubmit=true;
        form.submit();
    }
};

Mercadopago.getInstallments({
    "bin": bin,
    "amount": amount
}, setInstallmentInfo);


    </script>
  </body>
</html>