<?php

/**
 * 
 *
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @author 2Wicklers
 * @version 1.0
 * @copyright Computer Science & Engineering Department, NIT Silchar 
 * @package MIS
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
 

/**
 * MySQL Database Server Address
 */
define("DB_SERVER","localhost");



/**
 * MySQL Database Username
 */
define("DB_USERNAME","root");

/**
 * MySQL Database Password
 */
define("DB_PASSWORD","*******");

/**
 * DATABASE NAME of the System
 */
define("DB_NAME","mis");

 /**
 * LDAP_SERVER location or Address
 */
define("LDAP_SERVER","ldap://172.161.231.70");

/**
 * LDAP_SUPERUSER_PASSWORD is a password used for searching in LDAP directory
 */
define("LDAP_SUPERUSER_PASSWORD","*******");

/**
 * LDAP_SUPERUSER is DN used to search in LDAP directory
 */
define("LDAP_SUPERUSER", "uid=*****,cn=*****,cn=****");



/**
* BIZGROW SMS API KEY
*/
define("SMS_APIKEY", "***************");

/**
* SMS SENDER ID
*/
define("SMS_SENDER_ID", "NITSMS");



header("Cache-Control: no-cache");
header("Pragma: no-cache");

//ini_set('display_errors', 1);
error_reporting(E_ALL);

/**
 * Setting timezone for India :) 
 */
date_default_timezone_set('Asia/Kolkata');
?>
