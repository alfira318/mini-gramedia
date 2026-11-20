<?php

namespace App\Service\Midtrans;

use App\Models\Checkout;
use Midtrans\Notification;

class CallbackService extends Midtrans
{
    protected $notification;
    protected $checkout;
    protected $serverKey;
    protected $signatureSecretKey;

    public function __construct()
    {
        parent::__construct();

        $this->serverKey = config('midtrans.server_key');
        $this->signatureSecretKey = config('midtrans.signature_key');
        $this->_handleNotification();
    }

    public function isSignatureKeyVerified()
    {
        // hash_equals sama kaya operator == tp dipake khusus unruk karakter acak (hash)
        return hash_equals($this->_createLocalSignatureKey(), $this->notification->signature_key);
    }

    public function isSuccess()
    {
        $statusCode = $this->notification->status_code;
        $transactionStatus = $this->notification->transaction_status;
        $fraudStatus = !empty($this->notification->fraud_status) ? ($this->notification->fraud_status == 'accept') : true;

        return ($statusCode == 200 && $fraudStatus && ($transactionStatus == 'capture' || $transactionStatus == 'settlement'));
    }

    public function isExpire()
    {
        return ($this->notification->transaction_status == 'expire');
    }

    public function isCancelled()
    {
        return ($this->notification->transaction_status == 'cancel');
    }

    public function getNotification()
    {
        return $this->notification;
    }

    public function getCheckout()
    {
        return $this->checkout;
    }

    public function getPaymentType()
    {
        // mengambil opsi pembayaran dari midtrans yg dipilih utk disimpan ke db table checkouts
        return $this->notification->payment_type ?? null;
    }

    protected function _createLocalSignatureKey()
    {
        $orderId = $this->notification->order_id;
        $statusCode = $this->notification->status_code;
        $grossAmount = $this->notification->gross_amount;
        $signatureSecretKey = $this->signatureSecretKey;
        $input = $orderId . $statusCode . $grossAmount . $signatureSecretKey;
        $signature = openssl_digest($input, 'sha512');

        return $signature;
    }

    protected function _handleNotification()
    {
        $notification = new Notification();

        // ambil data dari table checkouts yg order_code nya sama ky order_id dari
        // response snap (notification)
        $checkout = Checkout::where('order_code', $notification->order_id)->first();

        $this->notification = $notification;
        $this->checkout = $checkout;
    }
}
