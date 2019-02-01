<?php
namespace App\Domestic\Request;

use App\Domestic\KeepBasic;
use App\Domestic\XMLSerializer;

class SectorCode extends KeepBasic {
    public function __construct()
    {
        parent::__construct();
    }

    public function generateBody(){
        return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/" version="1.0" encoding="UTF-8">
    <Body>
        <SectorCode xmlns="http://booking.us.dev/">
            <strUserId xmlns="">$this->userid</strUserId>
        </SectorCode>
    </Body>
</Envelope>
XML;

    }

    public function doRequest(){
       $xmlStr =  $this->generateBody();

       $client = $this->createSoapClient();
       $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
       $response = (html_entity_decode($rawresponse));
       if(!$response){
          return false;
       }
       $formattedResponse = $this->formatResponse($response);
//        $formattedResponse = $this->formatResponse($this->tempResponse());
       if(!$formattedResponse){
           return false;
       }
       return $formattedResponse;


    }

    public function formatResponse($response){
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $xmlArray = XMLSerializer::XMLtoArray($response);
        $soap_fault_body = array_get($xmlArray, "Error", false);
        if ($soap_fault_body) {
            return false;
        }
//        dd($xmlArray);
        $sectors = $doc->getElementsByTagName('Sector');
//        dd($sectors);
        $sectorcodes = $doc->getElementsByTagName('SectorCode');
//        dd($sectorcodes);
        $codes = [];
        $names = [];
        $formattedresponse = [];
        foreach($sectorcodes as $sectorcode){
            array_push($codes,$sectorcode->nodeValue);
        }
//        dd($codes);
        $sectornames = $doc->getElementsByTagName('SectorName');
        foreach($sectornames as $sectorname){
            array_push($names,$sectorname->nodeValue);
        }
//        dd($names);
        $i = 0;
        foreach($codes as $key=>$value){
//            dd($value);
            $formattedresponse[$value]=$names[$i];
            $i++;
        }
//        dd($formattedresponse);
        return $formattedresponse;
    }

    public function tempResponse(){
        return <<<XML
<FlightSector><Sector><SectorCode>BDP</SectorCode><SectorName>BHADRAPUR</SectorName></Sector><Sector><SectorCode>BWA</SectorCode><SectorName>BHAIRAHAWA</SectorName></Sector><Sector><SectorCode>BHR</SectorCode><SectorName>BHARATPUR</SectorName></Sector><Sector><SectorCode>BIR</SectorCode><SectorName>BIRATNAGAR</SectorName></Sector><Sector><SectorCode>DHI</SectorCode><SectorName>DHANGADI</SectorName></Sector><Sector><SectorCode>JKR</SectorCode><SectorName>JANAKPUR</SectorName></Sector><Sector><SectorCode>JMO</SectorCode><SectorName>JOMSOM</SectorName></Sector><Sector><SectorCode>KTM</SectorCode><SectorName>KATHMANDU</SectorName></Sector><Sector><SectorCode>MTN</SectorCode><SectorName>MOUNTAIN</SectorName></Sector><Sector><SectorCode>KEP</SectorCode><SectorName>NEPALGUNJ</SectorName></Sector><Sector><SectorCode>PKR</SectorCode><SectorName>POKHARA</SectorName></Sector><Sector><SectorCode>SIF</SectorCode><SectorName>SIMARA</SectorName></Sector><Sector><SectorCode>TMI</SectorCode><SectorName>TUMLINGTAR</SectorName></Sector></FlightSector>
XML;

    }
}