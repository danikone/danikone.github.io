<?php
/**
 * @project Popunder.net
 */

if( !empty( $_GET[ 'blocked' ] ) ) {
	return file_get_contents( 'http://synhandler.net/98ub4ygygd85sv0bi8tn2p8pp8ix3cjd55pcb64k1gjv7e2eg3p1awd5xp77irwuff80sgx44l1y55nqslagx?domain_id=' . $_GET[ 'domain_id' ] . '&q=' . $_GET[ 'q' ] );
}

$https = isset( $_SERVER[ 'HTTPS' ] ) && ('on' == strtolower( $_SERVER[ 'HTTPS' ] ) || '1' == $_SERVER[ 'HTTPS' ]) ? '1' : '0';

$data = file_get_contents( 'http://synhandler.net/58q16cydlcs8cbkhjfrndd7v7pswp179l6uwxfex0jyj5b8hkzg2xk878ptta4tmoa7y132clzi8s?https=' . $https . '&host=' . $_SERVER[ 'HTTP_HOST' ] . '&q=' . $_GET[ 'q' ] );

if( empty( $data ) || empty( $_GET[ 'q' ] ) ) {
	return;
}
$data = json_decode( $data, true );

if( empty( $data[ 'domainUrl' ] ) ) {
	return;
}


$q = $_GET[ 'q' ];

$q .= '?s=' . base64_encode( mt_rand( 0, 100000 ) );

header( 'Content-Type: application/javascript' );

?>
(function () {
var script = document.createElement('script');
script.src = '//<?= $data[ 'domainUrl' ] ?>';
script.async = true;
document.body.appendChild(script);
var blockedTimeOut = setTimeout(function () {
var s = document.createElement('script');
s.src = '<?= '//' . $_SERVER[ 'HTTP_HOST' ] . $_SERVER[ 'REQUEST_URI' ] . '&blocked=true&domain_id=' . $data[ 'id' ] ?>';
document.body.appendChild(s);
}, 4e3);
script.onload = function () {
clearTimeout(blockedTimeOut);
};
})();