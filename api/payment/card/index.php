<?php
class CardPayment {
	public function __construct () {
		$config = (new Config())->getConfigAll();
		$this->API_KEY = $config['api_key_card'];
		$this->URL_CALLBACK = $config['url_callback_card'];
		$this->URL_ADD = 'http://www.muabanthe.vn/API/NapThe';
	}

	/* Write Log */
	public function writeLog ($data) {
		$time = convertTime();
		$file = 'log/log-'.$time['full_date'].'.txt';
		$fp = fopen($file, 'a');

		$log = [];
		foreach ($data as $key => $value) {
			$log[] = '['.$key.']['.$value.']';
		}

		$log = implode(' - ', $log);
		$log = '['.$time['full'].'] - '.$log;
		fwrite($fp, $log.PHP_EOL);
		fclose($fp);
	}

	/* Curl Get */
	public function curlGet ($url, $data){
		$query = http_build_query($data);
		$curl = curl_init();
		curl_setopt_array($curl, array(
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_URL => $url.'?'.$query,
			CURLOPT_SSL_VERIFYPEER => false
		));
		$result = curl_exec($curl);

		if(curl_error($curl)){
			curl_close($curl);
			res(400, 'Hệ thống thẻ nạp đang bảo trì');
		}
		else {
			curl_close($curl);
			return (array)json_decode($result);
		}
	}

	/* Send */
	public function send (array $data) {
		if(empty($this->API_KEY)) return res(400, 'Hệ thống thẻ nạp đang bảo trì');

		if(
			empty($data['name'])
			|| empty($data['money'])
			|| empty($data['serial'])
			|| empty($data['pin'])
			|| empty($data['token'])
		) return res(400, 'Vui lòng nhập đầy đủ dữ liệu');
		
		$dataPost = array(
			'APIKey' =>   $this->API_KEY,
			'Network' => $data['name'],
			'CardValue' => $data['money'],
			'CardSeri' => $data['serial'],
			'CardCode' => $data['pin'],
			'TrxID' => $data['token'],
			'URLCallback' => $this->URL_CALLBACK
		);

		$result = $this->curlGet($this->URL_ADD, $dataPost);
		$code = is_numeric($result['Code']) ? $result['Code'] : 0;
		$message = !empty($result['Message']) ? $result['Message'] : 'Hệ thống thẻ cào đang gặp lỗi, vui lòng thử lại sau';

    if($code != 1) return res(400, $message);
    return array('money' => $dataPost['CardValue'], 'qr' => null);
	}

	/* Callback */
	public function callback (array $data) {
		$this->writeLog($data);
		$statusCode = (int)$data['Code'];
		$token = (string)$data['TrxID'];
		$money = (int)$data['CardValue'];

    // Is No Verify
    if($statusCode == 99) return;

		// Get Code Pay By Token
		$code = (new Pay())->getPayCodeByToken($token);

    // Verify
    $status = ($statusCode == 5) ? 2 : 1;
    (new Pay())->verifyPayAuto($money, $code, $status);
		res(200, 'SUCCESS');
	}
}