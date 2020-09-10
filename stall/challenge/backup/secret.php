<?php
function secret($amount){
    $address = '127.0.0.1';
    $port = 20080;
    $key = 'BambooFoxCurrencyManagementKey';
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    socket_connect($socket, $address, $port);
    socket_write($socket, $amount . $key);
}
?>
