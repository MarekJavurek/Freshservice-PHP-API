<?php

namespace Freshservice;

class Freshservice {
	const VERSION = '1.1';
	private $_serviceUrl;
	private $_loginCredentials;
	private $_curlConnection;
	
	public function __construct($serviceUrl, LoginCredentials $loginCredentials) {
		$this->_serviceUrl = $serviceUrl;
		$this->_loginCredentials = $loginCredentials;
		$this->_curlConnection = curl_init();
		
		$header[] = "Content-type: application/json";
	        curl_setopt($this->_curlConnection, CURLOPT_RETURNTRANSFER, true);
	        curl_setopt($this->_curlConnection, CURLOPT_HTTPHEADER, $header);
	        curl_setopt($this->_curlConnection, CURLOPT_HEADER, false);
	        curl_setopt($this->_curlConnection, CURLOPT_VERBOSE, false);
	        curl_setopt($this->_curlConnection, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	        curl_setopt($this->_curlConnection, CURLOPT_SSL_VERIFYHOST, 0);
	        curl_setopt($this->_curlConnection, CURLOPT_SSL_VERIFYPEER, 0);
	
		if (null !== $this->_loginCredentials) {
			curl_setopt($this->_curlConnection, CURLOPT_USERPWD, $this->_loginCredentials->getCurlLoginString());
		} else {
			throw new FreshserviceException('class Freshservice => LoginCredentials object is null!');
		}
	}

	public function Exec($target, $methodId, $data = null) {
		curl_setopt($this->_curlConnection, CURLOPT_URL, $this->_serviceUrl . $target);
	        $json_body = json_encode($data, JSON_FORCE_OBJECT | JSON_PRETTY_PRINT);
	
		if($methodId == 1) { // GET
			curl_setopt ($this->_curlConnection, CURLOPT_POST, false);
		}
	        elseif($methodId == 2) { // POST
			curl_setopt($this->_curlConnection, CURLOPT_POST, true);
			curl_setopt($this->_curlConnection, CURLOPT_POSTFIELDS, $json_body);
		}
		elseif($methodId == 3) { // PUT
			curl_setopt($this->_curlConnection, CURLOPT_CUSTOMREQUEST, "PUT" );
			curl_setopt($this->_curlConnection, CURLOPT_POSTFIELDS, $json_body);
		}
		elseif($methodId == 4) { // DELETE
			curl_setopt($this->_curlConnection, CURLOPT_CUSTOMREQUEST, "DELETE" ); // UNTESTED!
		}

		$httpResponse = curl_exec($this->_curlConnection);
		$http_status = curl_getinfo($this->_curlConnection, CURLINFO_HTTP_CODE);
	
		if( !preg_match( '/2\d\d/', $http_status ) ) {
			throw new FreshserviceException('HTTP error in Excec method');
		}
	
		return json_decode($httpResponse);
	}

	public function Close() {
		curl_close($this->_curlConnection);
	}
}
