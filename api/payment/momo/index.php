<?php
class MomoPayment {
  public function callback ($data) {
    $code = (string)$data['comment'];
		$money = (int)$data['amount'];

    (new Pay())->verifyPayAuto($money, $code, 1);
		res(200, 'SUCCESS');
  }
}