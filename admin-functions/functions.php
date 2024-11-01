<?php
function licenceCheck($PUBLICAPIKEY, $SECRETAPIKEY, $SERVERIPADDRESS, $SERVERPORT ){

	$licenceCheckURL = "http://sapi.knowyourenemy.co.uk/?action=apiCallData&apipublic=" . $PUBLICAPIKEY . "&apisecret=" . $SECRETAPIKEY . "&serverip=" . $SERVERIPADDRESS . "&serverport=" . $SERVERPORT;

	$curl = curl_init();
    curl_setopt ($curl, CURLOPT_URL, $licenceCheckURL);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $json = curl_exec ($curl);
    curl_close ($curl);
    $jsonObject = json_decode($json);

    if( $jsonObject->error ){
    	return FALSE;
    }else{
    	return TRUE;
    }
}