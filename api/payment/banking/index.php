<?php
class BankPayment {
  public function callback (array $data = []) {
    $code = (string)$data['user'];
		$money = (int)$data['money'];

    (new Pay())->verifyPayAuto($money, $code, 1);

    // Telegram
    $chatid = '-1001766452338';
    $noidung = 'BANK Tru Tiên: Giao dịch '.$code.'  Nạp thành công '.format_cash($money).'';
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.telegram.org/bot5842357455:AAFyDvWS-BZfn9WRIZ0rd8YEgYmeZyinJ9I/sendMessage",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS =>"{\n    \"chat_id\": \"$chatid\",\n    \"text\": \"$noidung\" \n }",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
      ),
    ));
    $response = curl_exec($curl);
    curl_close($curl);

    // Done
		res(200, 'SUCCESS');
  }
}