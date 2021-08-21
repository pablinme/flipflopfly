<?php
error_reporting(E_ALL ^ E_NOTICE);
    
/*=========== Database Configuraiton ==========*/
$db_host = '127.0.0.1';
$db_user = 'root';
$db_pass = 'PASSWORD';
$db_name = 'chasqui';

/*=========== Memcached Configuraiton ==========*/
$memcached_host = '127.0.0.1';
$memcached_port = '11211';
$timeout = 60;

/*=========== Rating Configuraiton ==========*/
$rating_unit = 15;
$units = 5;

/*=========== Website Configuration ==========*/

$defaultTitle = 'Chasqui';
$defaultFooter = '2013';
$topicsPage = 4;
$postsPage = 10;
$limitLatest = 5;
$limitRequests = 10;
$limitOffers = 10;
$site = 'http://example.com/';
$siteCrumbs = 'http://example.com';

?>
