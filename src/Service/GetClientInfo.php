<?php

namespace App\Service;

class GetClientInfo {

	public function getIp() {
		$IP = '';
	    if (getenv('HTTP_CLIENT_IP')) {
	    $IP =getenv('HTTP_CLIENT_IP');
	    } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
	    $IP =getenv('HTTP_X_FORWARDED_FOR');
	    } elseif (getenv('HTTP_X_FORWARDED')) {
	    $IP =getenv('HTTP_X_FORWARDED');
	    } elseif (getenv('HTTP_FORWARDED_FOR')) {
	    $IP =getenv('HTTP_FORWARDED_FOR');
	    } elseif (getenv('HTTP_FORWARDED')) {
	    $IP = getenv('HTTP_FORWARDED');
	    } else {
	    $IP = $_SERVER['REMOTE_ADDR'];
	    }
	    return $IP;
	}

	public function getProxy() {
	    if(getenv('HTTP_X_FORWARDED')) {
	        return $proxy = getenv('HTTP_X_FORWARDED');
	    } else {
	        return "N/A";
	    }
	}

	public function getValue($key, $array) {
	    $value = array_key_exists($key, $array) ? $array[$key] : "N/A";
	    return $value;
	}

	public function getClientData() {
		$ipApi = file_get_contents('http://ip-api.com/json/'. self::getIp());
		if (isset($ipApi) && !empty($ipApi)) {
		    $decodedIpApi = json_decode($ipApi, true);
		    $client = new \stdClass();
		    $client->ip = self::getIp();
		    $client->proxy = self::getProxy();
		    $client->country = self::getValue("country", $decodedIpApi);
		    $client->region = self::getValue("region", $decodedIpApi);
		    $client->regionName = self::getValue("regionName", $decodedIpApi);
		    $client->lat = self::getValue("lat", $decodedIpApi);
		    $client->lon = self::getValue("lon", $decodedIpApi);
		    $client->timezone = self::getValue("timezone", $decodedIpApi);
		    $client->query = self::getValue("query", $decodedIpApi);
		    $jsonClient = json_encode($client);
		    $decodedClient = json_decode($jsonClient, true);
		    $myfile = file_put_contents('/home/sonny/clientInfoText.json', $jsonClient.PHP_EOL , FILE_APPEND | LOCK_EX);
		}
		else {
			$myfile = file_put_contents('/home/sonny/clientInfoText.json', 'Error on ipApi'.PHP_EOL , FILE_APPEND | LOCK_EX);
		}
	}
}