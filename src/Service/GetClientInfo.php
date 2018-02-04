<?php

namespace App\Service;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;

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
		$browser = new Browser();
		$os = new Os();
		$ipApi = file_get_contents('http://ip-api.com/json/'. self::getIp());

		if ($ipApi != false) {
		    $decodedIpApi = json_decode($ipApi, true);
		    //Create client
		    $client = new \stdClass();
		    $client->ip = self::getIp();
		    $client->proxy = self::getProxy();
		    $client->browser = $browser->getName();
		    $client->os = $os->getName();
		    $client->country = self::getValue("country", $decodedIpApi);
		    $client->region = self::getValue("region", $decodedIpApi);
		    $client->regionName = self::getValue("regionName", $decodedIpApi);
		    $client->lat = self::getValue("lat", $decodedIpApi);
		    $client->lon = self::getValue("lon", $decodedIpApi);
		    $client->timezone = self::getValue("timezone", $decodedIpApi);
		    $client->query = self::getValue("query", $decodedIpApi);

		    //Operation
			$jsonClient = json_encode($client, 
				JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);

			$clientData = json_decode(file_get_contents('/home/sonny/clientInfo.json'));
			$clientData [] = $client;
			$clientData = json_encode ($clientData, JSON_PRETTY_PRINT );
			$myfile = file_put_contents('/home/sonny/clientInfo.json', $clientData);
			}
	}

	public function getBrowserStats() {
		$clientInfo = file_get_contents('/home/sonny/clientInfo.json');
		$data = json_decode($clientInfo, true);

		$firefox = 0;
		$chrome = 0;
		$ie = 0;
		$opera = 0;
		$safari = 0;
		$other = 0;
		$browsers = array (
			"firefox" => 0,
			"chrome" => 0,
			"opera" => 0,
			"ie" => 0,
			"safari" => 0,
			"other" => 0,
		);
		foreach ($data as $client) {
		    $browser = $client['browser'];
		    switch ($browser) {
		        case "Firefox":
		            $firefox++;
		            $browsers['firefox'] = $firefox;
		            break;
		        case "Chrome":
		            $chrome++;
		            $browsers['chrome'] = $chrome;
		            break;
		        case "Opera":
		            $opera++;
		            $browsers['opera'] = $opera;
		            break;
		        case "Internet Explorer":
		            $ie++;
		            $browsers['ie'] = $ie;
		            break;
		        case "Safari":
		            $safari++;
		            $browsers['safari'] = $safari;
		            break;
		        default:
		            $other++;
		            $browsers['other'] = $other;
		    }

		}

		return $browsers;
	}

	public function getOsStats() {
		$clientInfo = file_get_contents('/home/sonny/clientInfo.json');
		$data = json_decode($clientInfo, true);

		$linux = 0;
		$windows = 0;
		$android = 0;
		$other = 0;
		$os = array(
			"linux" => 0,
			"windows" => 0,
			"android" => 0,
			"other" => 0,
		);
		foreach ($data as $client) {
		    $letOs = $client['os'];
		    switch ($letOs) {
		        case "Linux":
		            $linux++;
		            $os['linux'] = $linux;
		            break;
		        case "Windows":
		            $windows++;
		            $os['windows'] = $windows;
		            break;
		     	case "Android":
		            $android++;
		            $os['android'] = $android;
		            break;
		        default:
		            $other++;
		            $os['other'] = $other;
		    }

		}

		return $os;
	}

}