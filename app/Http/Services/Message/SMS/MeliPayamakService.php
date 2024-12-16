<?php

namespace App\Http\Services\Message\SMS;

use App\Http\Services\Message\MessageService;
use Illuminate\Support\Facades\Config;
use Melipayamak\MelipayamakApi;
use SoapClient;
use SoapFault;

class MeliPayamakService
{

    private mixed $username;
    private mixed $password;

    public function __construct()
    {
        $this->username = Config::get('sms.username');
        $this->password = Config::get('sms.password');
    }


    /**
     * @throws SoapFault
     */
    public function addContact(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl", array("encoding" => "UTF-8"));
        $parameters['username'] = "***";
        $parameters['password'] = "***";
        $parameters['groupIds'] = "***"; //My group Id in panel
        $parameters['firstname'] = "MyUserFirstName";
        $parameters['lastname'] = "MyUserLastName";
        $parameters['nickname'] = "MyUserNickName";
        $parameters['corporation'] = "MyUserCorporation";
        $parameters['mobilenumber'] = "MyUserMobileNumber";
        $parameters['phone'] = "MyUserPhone";
        $parameters['fax'] = "MyUserFax";
        $parameters['birthdate'] = 2013 - 06 - 15; //for Example
        $parameters['email'] = "MyUserEmailAddress";
        $parameters['gender'] = 2; //For Example
        $parameters['province'] = 18; //For Example
        $parameters['city'] = 711; //For Example
        $parameters['address'] = "MyUserAddress";
        $parameters['postalCode'] = "MyUserPostalCode";
        $parameters['additionaldate'] = 2013 - 06 - 15; //For Example
        $parameters['additionaltext'] = "MyUserAdditionalText";
        $parameters['descriptions'] = "MyUserDescriptions";
        echo $sms_client->AddContact($parameters)->AddContactResult;
    }


    /**
     * @throws SoapFault
     */
    public function addSchedule(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/schedule.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "***";
        $parameters['password'] = "***";
        $parameters['to'] = "912***";
        $parameters['from'] = "3000***";
        $parameters['text'] = "Test";
        $parameters['isflash'] = false;
        $parameters['scheduleDateTime'] = "2013-06-15T16:50:45";
        $parameters['period'] = "Once";
        echo $sms_client->AddSchedule($parameters)->AddScheduleResult;
    }


    /**
     * @throws SoapFault
     */
    public function getCredit(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/Send.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "username";
        $parameters['password'] = "password";

        echo $sms_client->GetCredit($parameters)->GetCreditResult;
    }


    /**
     * @throws SoapFault
     */
    public function getInboxCountSoapClient(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/receive.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "username";
        $parameters['password'] = "pass";
        $parameters['isRead'] = false;

        echo $sms_client->GetInboxCount($parameters)->GetInboxCountResult;
    }


    /**
     * @throws SoapFault
     */
    public function getMessageStr(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/Receive.asmx?wsdl', array('encoding' => 'UTF-8'));
        $parameters['username'] = "username";
        $parameters['password'] = "password";
        $parameters['location'] = 1;
        $parameters['from'] = "";
        $parameters['index'] = 0;
        $parameters['count'] = 10;
        echo $sms_client->GetMessageStr($parameters)->GetMessageStrResult;
    }

    /**
     * @throws SoapFault
     */
    public function SendSimpleSms2SoapClient(): void
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        $sms_client = new \SoapClient('http://api.payamak-panel.com/post/send.asmx?wsdl', array('encoding' => 'UTF-8'));

        $parameters['username'] = "demo";
        $parameters['password'] = "demo";
        $parameters['to'] = "912...";
        $parameters['from'] = "1000..";
        $parameters['text'] = "تست";
        $parameters['isflash'] = false;

        echo $sms_client->SendSimpleSMS2($parameters)->SendSimpleSMS2Result;
    }

    /**
     * @throws SoapFault
     */
    public function sendSmsSoapClient($from, array $to, $text, $isFlash = true)
    {
        // turn off the WSDL cache
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $sms = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl", array("encoding" => "UTF-8"));
            $parameters['username'] = $this->username;
            $parameters['password'] = $this->password;
            $parameters['from'] = $from;
            $parameters['to'] = $to;
            $parameters['text'] = $text;
            $parameters['isflash'] = $isFlash;
            $parameters['udh'] = "";
            $parameters['recId'] = array(0);
            $parameters['status'] = 0x0;
            $GetCreditResult = $sms->GetCredit(array("username" => $this->username, "password" => $this->password))->GetCreditResult; // should be 0
            $sendSmsResult = $sms->SendSms($parameters)->SendSmsResult; // should be 1

            if ($GetCreditResult == 0 && $sendSmsResult == 1) {
                return true;
            } else {
                return false;
            }

        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }

    public function SendByBaseNumber($text, $to, $bodyId)
    {
        ini_set("soap.wsdl_cache_enabled", "0");
        try {
            $sms = new SoapClient("http://api.payamak-panel.com/post/Send.asmx?wsdl", array("encoding" => "UTF-8"));
            $data = array(
                "username" => $this->username,
                "password" => $this->password,
                "text" => $text,
                "to" => $to,
                "bodyId" => $bodyId
            );
            return $sms->SendByBaseNumber($text, $to, $bodyId);
        } catch (SoapFault $ex) {
            echo $ex->faultstring;
        }
    }

}
