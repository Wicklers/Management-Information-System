<?php
/**
 * @package MIS
 * @name SMS
 * @author Harsh Vardhan Ladha & Yogesh Chauhan
 * @copyright Computer Science & Engineering Department, NIT Silchar
 * @link http://mis.nits.ac.in
 * @license NIT Silchar
 */
class SMS{
	private $_mobile,
			$_message,
			$_username,
			$_password,
			$_senderID;
	public $error;

	public function __construct(){
		$this->_mobile = NULL;
		$this->_message =NULL;
		$this->error=NULL;
		$this->_apikey = SMS_APIKEY;// SMS API KEY
		$this->_senderID = SMS_SENDER_ID;
	}

	public function send($mobile,$message){

		$this->_mobile = $mobile;
		$this->_message = urlencode($message);

		$url = "http://message.bizgrow.in/app/smsapi/index.php?key={$this->_apikey}&type=text&contacts={$this->_mobile}&senderid={$this->_senderID}&msg={$this->_message}";

		//cURL to send sms!!!

		$ch = curl_init();
		$timeout = 500000;
		curl_setopt($ch, CURLOPT_URL, $url);
		//curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, 0); // If PROXY!!
		//curl_setopt($ch, CURLOPT_PROXY, '172.16.30.20:8080'); // PROXY
		//curl_setopt($ch, CURLOPT_POST, TRUE);             // Use POST method
		//curl_setopt($ch, CURLOPT_POSTFIELDS, "var1=1&var2=2&var3=3");  // Define POST data values
		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.0)");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		if(explode('_',$data)[0]==='api'){
			$file = '/opt/lampp/MIS.LOGS/sms.log';
			$handle = fopen($file, 'a+');
			fwrite($handle, date('Y-m-d H:i:s') . ':::' . $mobile  . ':::"' . $message . '"' . "\n");
			fclose($handle);
				return 1;
			}
		else{
			$this->error = $data;
			return $this->error;
		}
	}
}
?>

