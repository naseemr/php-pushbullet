<?php
class notify{
	private $key;

	public function __construct($key){
		$this->key = $key;
	}

	private function pushbullet($title = "", $body = ""){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.pushbullet.com/api/devices");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERPWD, $this->key.":");
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		$output = curl_exec($ch);
		$info = curl_getinfo($ch);
		curl_close($ch);

		$devices = json_decode($output)->devices;

		foreach($devices as $device){
			$fields = array(
				"device_id" => urlencode($device->id),
				"type" => urlencode("note"),
				"title" => urlencode($title),
				"body" => urlencode($body)
			);
	
			$fields_string = "";

			foreach($fields as $key=>$value) {
				$fields_string .= $key.'='.$value.'&';
			}
	
			rtrim($fields_string, '&');

			$ch = curl_init();

			curl_setopt($ch,CURLOPT_URL, "https://api.pushbullet.com/api/pushes");
			curl_setopt($ch,CURLOPT_POST, count($fields));
			curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERPWD, $this->key.":");
			curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
			$output = curl_exec($ch);
			$info = curl_getinfo($ch);
			curl_close($ch);
		}
	}

	public function notify($title = "", $body = ""){
		$this->pushbullet($title, $body);
	}
}
?>
