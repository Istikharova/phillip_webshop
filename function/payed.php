<?php
function paypalCreateOrder(array $deliveryAddressData, array $cartProducts){
    //todo
}

function rechnungCreateOrder(array $deliveryAddressData, array $cartProducts){
    header("Location:".BASE_URL."index.php/paymentComplete");
}   