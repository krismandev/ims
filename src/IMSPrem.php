<?php 

namespace Krisman\IMS;

use GuzzleHttp\Client;

/**
 * Class IMSReg
 * 
 * This class is used to send SMS regular route
 * 
 * @package Krisman\IMS
 * @author Krisman
 * @version 1.0.0 
 */

class IMSPrem {
    private string $login_id;
    private string $password;
    private string $defaultSender;
    private $httpClient;
    private string $urlV1 = "https://api.imitra.com:25000/sendsms";
    private string $urlV2 = "https://api.imitra.com:25000/sendsms/v2";

    public function __construct(string $login_id,string $password, string $sender){
        $this->login_id = $login_id;
        $this->password = $password;
        $this->httpClient = new Client();
        $this->defaultSender = $sender;
    }

    /**
     * this function used to send sms
     * 
     * @param string $msisdn The mobile destination number
     * @param string $message Message content
     * @param string $sender alternative Sender ID if you do not want to use default sender
     * @return string send sms result in plain text format with pipe separator  
     */
    public function sendSms(string $msisdn, string $message,string $sender = null,string $referenceid = null) : string {
        $response = $this->httpClient->post($this->urlV1,[
            'form_params'=>[
                'username'=>$this->login_id,
                'password'=>$this->password,
                'msisdn'=>$msisdn,
                'msisdn_sender'=> $sender ?? $this->defaultSender,
                'message'=>$message,
                'referenceid'=>$referenceid

            ]
        ]);

        $body = $response->getBody();
        $content = $body->getContents();

        return $content;
    }

        /**
     * this function used to send sms
     * 
     * @param string $msisdn The mobile destination number
     * @param string $message Message content
     * @param string $sender alternative Sender ID if you do not want to use default sender
     * @return string send sms result in json format  
     */
    public function sendSmsJson(string $msisdn, string $message,string $sender = null,string $referenceid = null) : string {
        $response = $this->httpClient->post($this->urlV2,[
            'json'=>[
                'loginid'=>$this->login_id,
                'password'=>$this->password,
                'msisdn'=>$msisdn,
                'sender'=> $sender ?? $this->defaultSender,
                'msg'=>$message,
                'referenceid'=>$referenceid

            ]
        ]);

        $body = $response->getBody();
        $content = $body->getContents();

        return $content;
    }
}