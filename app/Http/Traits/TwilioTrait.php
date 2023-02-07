<?php

namespace App\Http\Traits;
use Twilio\Rest\Client;
trait TwilioTrait
{
    public function sendsms($number,$otp){
        $sid=getenv('TWILIO_SID');
        $token=getenv('TWILIO_TOKEN');
        $sender=getenv('TWILIO_FROM');
        $client = new Client($sid, $token);
        $client->messages->create($number, [
                'from' => $sender,
                'body' => 'You verfication number is :'.$otp]);
        }
}
