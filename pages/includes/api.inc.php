<?php

function coingGeckoRequest(){
  $url='http://api.coingecko.com/api/v3/coins/markets?vs_currency=usd&ids=bitcoin%2Cethereum%2Cdogecoin&order=market_cap_desc&per_page=10&page=1&sparkline=false&price_change_percentage=1h%2C5h%2C12h%2C24h%2C7d%2C1m%2C1y';
  $json=json_decode( file_get_contents( $url ) );
  return  $json;
}


function get_btc_price(){
    $url='http://bitpay.com/api/rates';
    $json=json_decode( file_get_contents( $url ) );
    $dollar=$btc=0;

    foreach( $json as $obj ){
    if( $obj->code=='USD' )$btc=$obj->rate;
    }

    return "$" . $btc . "USD";


}
function get_eth_price(){
  $url = 'http://api.coinmarketcap.com/v1/ticker/ethereum/?convert=USD';
  $data = file_get_contents($url);
  $priceInfo = json_decode($data);

  return $priceInfo[0]->price_usd;


}

