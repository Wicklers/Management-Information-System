<?php
/**
 * Creates "config.php" file from the specifications provided, each argument is mandatory.
 * use example : create_config_file("localhost","root","mypassword","MIS","172.16.30.70");
 * @param string $db_server, path of the mysql database server
 * @param string $db_username, username of the mysql database
 * @param string $db_password, corresponding password of the mysql database
 * @param string $db_name, database name
 * @param string $ldap_server, path of the LDAP server
 * 
 * @return void
 * @package MIS
 * @name Create Config File
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */

function create_config_file($db_server,$db_username,$db_password,$db_name,$ldap_server){
    
    $filename = "config_sample.php";
    $file = fopen($filename, "a+");
    $new_filename = "config.php";
    $nf = fopen($new_filename,"w");
    while(!feof($file)){
        $line = fgets($file);
        $var = array("db-server","db-username","db-password","db-name","ldap-server");
        $values = array($db_server,$db_username,$db_password,$db_name,$ldap_server);
        
        $content = str_replace($var, $values, $line);
        fwrite($nf,$content);
    }
}
?>