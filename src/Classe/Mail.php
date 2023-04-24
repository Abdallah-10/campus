<?php

namespace App\Classe;

use Mailjet\Client;
use Mailjet\Resources;

class Mail
{
    private $api_key = 'b308b5e9b6b4d63a325ac44efd4b1167';
    private $api_key_secret = 'a054c154fc6149dae5b6e337c9e96dc1';

    public function send($to_email, $to_name, $subject, $content)
    {
        $mj = new Client($this->api_key, $this->api_key_secret,true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
              [
                'From' => [
                  'Email' => "abdallahsalah15@gmail.com",
                  'Name' => "abdallah"
                ],
                'To' => [
                  [
                    'Email' => "abdallahsalah15@gmail.com",
                    'Name' => "abdallah"
                  ]
                ],
                'Subject' => "Greetings from Mailjet.",
                'TextPart' => "My first Mailjet email",
                'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href='https://www.mailjet.com/'>Mailjet</a>!</h3><br />May the delivery force be with you!",
                'CustomID' => "AppGettingStartedTest"
              ]
            ]
            ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}