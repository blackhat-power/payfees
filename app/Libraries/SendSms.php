<?php


namespace App\Libraries;


use AfricasTalking\SDK\AfricasTalking;

static private  $api_key ="49de3275efe676338a441b15d41703f29c52913aea84b1a5ea4293c88c3b4004";
static private $username ="vidalocal";

class SendSms
{


    public static function sendSingle($sender,$message,$to)
    {
        return self::send($to,$sender,$message);
    }


    public static function send($to,$from,$message)
    {
        $at = new AfricasTalking(self::$username,self::$api_key);
        $sms      = $at->sms();
        return $sms->send(['to'=> $to,  'from' =>$from, 'message' => $message]);
    }



}