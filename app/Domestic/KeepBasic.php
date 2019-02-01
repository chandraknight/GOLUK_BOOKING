<?php
namespace App\Domestic;

use Illuminate\Support\Facades\Config;

class KeepBasic {
    public $userid,$password,$agency;

    public function __construct()
    {
        $this->userid = Config::get('domestic.userid');
        $this->password = Config::get('domestic.password');
        $this->agency = Config::get('domestic.agency');
    }

    public function createSoapClient() {
        $client = new \SoapClient(null, array(
            'location' => 'http://dev.usbooking.org/UnitedSolutions?wsdl',
            'uri' => 'http://dev.usbooking.org/UnitedSolutions?wsdl',
            'trace' => 1,
            'exceptions' => true,
            'use' => 'wse'
        ));

        return $client;
    }

    public function checkArrayKey(array $arr,$key){
        // is in base array?
        if (array_key_exists($key, $arr)) {
            return true;
        }

        // check arrays contained in this array
        foreach ($arr as $element) {
            if (is_array($element)) {
                if ($this->checkArrayKey($element, $key)) {
                    return true;
                }
            }

        }

        return false;
    }

    public function generateXmlWithEnvelope($body){
        return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
    $body
    </Body>
</Envelope>
XML;

    }
}