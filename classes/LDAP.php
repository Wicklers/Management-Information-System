<?php
error_reporting(1);
/**
 * @package MIS
 * @name LDAP
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class LDAP {
    private $_host, $_port, $_base, $_dn;

   public function __construct($host = LDAP_SERVER) {
        $this -> _port = 389;
        $this -> _base = '';
        $this -> setHost($host);
    }

    private function setHost($host = '') {
        $this -> _host = $host;
    }

    public function getHost() {
        return $this -> _host;
    }

    public function getPort() {
        return $this -> _port;
    }

    public function getDN() {
        return $this -> _dn;
    }

    public function setDN($username) {
        $email=$username;
        $username = explode('@', $username);
        $uid = $username[0];
        if (!isset($username[1])) {
            $log = new Log();
            $log -> loginLog("attempt");
            return 0;
        }
        $dc = explode('.', $username[1]);
        if ($dc[0] === 'nits') {
            $this -> _dn = 'uid=' . $uid . ',ou=people,dc=nits,dc=ac,dc=in';
            //Faculty type in Session
            Session::put('type', 'faculty');
        } else {
            
            if ($dc[0] == 'student') {
                //Student type in session var
                $uid = $this->getUID($email); // modify uid to bind with ldap, uid is actually scholar number in LDAP database. so we are retrieving scholar number here by searching through email id entered by user
            	Session::put('sn',$uid);
                $this -> _dn = 'uid=' . $uid . ',ou=people,dc=' . $dc[0] . ',dc=nits,dc=ac,dc=in';
            	Session::put('type', 'student');

            } else {
            	$this -> _dn = 'uid=' . $uid . ',ou=people,dc=' . $dc[0] . ',dc=nits,dc=ac,dc=in';
            	
                //Faculty type in session
                Session::put('type', 'faculty');
            }

        }
        //Display name in session var
        Session::put('displayname', $this -> getDisplayName($email));
        $log = new Log();
        $log -> loginLog('attempt');
        if(Session::get('displayname')==""){
            Session::destroy();
            unset($this);
            return 0;
        }
        else{
            return 1;
        }
    }

    public function Connect() {
        return ldap_connect($this -> getHost(), $this -> getPort());
    }

    public function Bind($password = '') {
        $conn = $this -> Connect();
        $bind = 0;
        ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
        $bind = ldap_bind($conn, $this -> getDN(), $password);
        return $bind;
    }

    public function Auth($username, $password) {
    	//$username means $email :P
        if ($this -> setDN($username)) {
            if ($this -> Bind($password)) {
                ldap_unbind($conn);
                return 1;
            } else {
                
                 $log = new Log();
                 $log -> loginLog('wrong credentials');
		 ldap_unbind($conn);
		 Session::destroy();
                 return 0;
                
            }
        } else {
            ldap_unbind($conn);
	    Session::destroy();
            return 0;
        }

    }

    public function getDisplayName($email) {
        $ldap_connection = $this -> Connect();
        $ldap_password = LDAP_SUPERUSER_PASSWORD;
        $ldap_username = LDAP_SUPERUSER;

        ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
        ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
        // We need this for doing an LDAP search.
		
        
        //Now bind the superuser and get his token to access and modify LDAP Database
        $bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);

        $ldap_base_dn = 'dc=nits,dc=ac,dc=in';
        $search_filter = "(&(mail=" . $email . "))";
        $result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
        if (FALSE !== $result) {
            $entries = ldap_get_entries($ldap_connection, $result);
        }
        ldap_unbind($ldap_connection);
        return $entries[0]['displayname'][0];
        // Clean up
    }
    
    public function getSN($email) {
    	$ldap_connection = $this -> Connect();
    	$ldap_password = LDAP_SUPERUSER_PASSWORD;
    	$ldap_username = LDAP_SUPERUSER;
    
    	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
    	ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
    	// We need this for doing an LDAP search.
    
    
    	//Now bind the superuser and get his token to access and modify LDAP Database
    	$bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);
    
    	$ldap_base_dn = 'dc=nits,dc=ac,dc=in';
    	$search_filter = "(&(mail=" . $email . "))";
    	$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
    	if (FALSE !== $result) {
    		$entries = ldap_get_entries($ldap_connection, $result);
    	}
    	ldap_unbind($ldap_connection);
    	return $entries[0]['sn'][0];
    	// Clean up 
    }

   public function getUID($email) {
    	$ldap_connection = $this -> Connect();
    	$ldap_password = LDAP_SUPERUSER_PASSWORD;
    	$ldap_username = LDAP_SUPERUSER;
    
    	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
    	ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
    	// We need this for doing an LDAP search.
    
    
    	//Now bind the superuser and get his token to access and modify LDAP Database
    	$bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);
    
    	$ldap_base_dn = 'dc=nits,dc=ac,dc=in';
    	$search_filter = "(&(mail=" . $email . "))";
    	$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
    	if (FALSE !== $result) {
    		$entries = ldap_get_entries($ldap_connection, $result);
    	}
    	ldap_unbind($ldap_connection);
    	return $entries[0]['uid'][0];
    	// Clean up 
    }
	public function getDEmail($email) {
	    	$ldap_connection = $this -> Connect();
	    	$ldap_password = LDAP_SUPERUSER_PASSWORD;
	    	$ldap_username = LDAP_SUPERUSER;
	    
	    	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
	    	ldap_set_option($ldap_connection, LDAP_OPT_REFERRALS, 0);
	    	// We need this for doing an LDAP search.
	    
	    
	    	//Now bind the superuser and get his token to access and modify LDAP Database

	    	$bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);
	    
	    	$ldap_base_dn = 'dc=nits,dc=ac,dc=in';
	    	$search_filter = "(&(mail=" . $email . "))";
	    	$result = ldap_search($ldap_connection, $ldap_base_dn, $search_filter);
	    	if (FALSE !== $result) {
	    		$entries = ldap_get_entries($ldap_connection, $result);
	    	}
	    	ldap_unbind($ldap_connection);
	    	return $entries[0]['mail'][0];
	    	// Clean up 
	    }
	/**
	 * 
	 * @param string $dn DN
	 * @param array $attributeWithValue example : array($attribute1 => array(0=>'this is some data', 1=>'ths is'))
	 */
    public function addAttribute($dn, $attributesWithValues){
    	$ldap_connection = $this -> Connect();
    	$ldap_password = LDAP_SUPERUSER_PASSWORD;
    	$ldap_username = LDAP_SUPERUSER;
    	
    	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
    	
    	//Now bind the superuser and get his token to access and modify LDAP Database
    	$bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);
    	
    	$add = ldap_modify($ldap_connection, $dn, $attributesWithValues);
    	
    	if($add==1 && ldap_error($ldap_connection)=='Success')
    		return 1;
    	else
    		return 0;
    }
    
    public function changePassword($email, $newpassword){
    	$this->setDN($email);
    	
    	$salt = sha1(rand());
    	$salt = substr($salt, 0, 4);
    	$hash = base64_encode(sha1($newpassword . $salt, true) . $salt );
    	
    	$newEntry = array('userPassword' => "{ssha}".$hash);
    	
    	$ldap_connection = $this -> Connect();
    	$ldap_password = LDAP_SUPERUSER_PASSWORD;
    	$ldap_username = LDAP_SUPERUSER;
    	
    	ldap_set_option($ldap_connection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
    	
    	
    	//Now bind the superuser and get his token to access and modify LDAP Database
    	$bind = ldap_bind($ldap_connection, $ldap_username, $ldap_password);
    	
    	if(ldap_mod_replace($ldap_connection, $this->getDN(), $newEntry))
    		return 1;
    	else
    		return 0;
    }
}

?>
