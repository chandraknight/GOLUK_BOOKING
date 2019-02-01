<?php
namespace App\Domestic\Request;

use App\Domestic\KeepBasic;
use App\Domestic\XMLSerializer;

class GetFlightDetail extends KeepBasic {
    public function __construct()
    {
        parent::__construct();
    }

    public function generateBody($id){
        return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <GetFlightDetail xmlns="http://booking.us.dev/">
            <strUserId xmlns="">$this->userid</strUserId>
            <strFlightId xmlns="">$id</strFlightId>
        </GetFlightDetail>
    </Body>
</Envelope
XML;

    }

    public function doRequest($id){
        if(is_array($id)){
            $c = 1;
            $details = [];
            foreach($id as $d){

                $xmlStr = $this->generateBody($d);
                if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
                    $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRQ".$c.".txt";
                    file_put_contents($file,$xmlStr);
                } else {
                    mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
                    $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRQ".$c.".txt";
                    file_put_contents($file,$xmlStr);
                }
                $client = $this->createSoapClient();
                $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
                if(!$rawresponse){
                    return false;
                }
                $response = html_entity_decode($rawresponse);
                if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
                    $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRS".$c.".txt";
                    file_put_contents($file,$xmlStr);
                } else {
                    mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
                    $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRS".$c.".txt";
                    file_put_contents($file,$xmlStr);
                }
                array_push($details,$this->formatResponse($response));
                $c++;
            }
            return $details;
        } else {
            $xmlStr = $this->generateBody($id);
            if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
                $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRQ.txt";
                file_put_contents($file,$xmlStr);
            } else {
                mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
                $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRQ.txt";
                file_put_contents($file,$xmlStr);
            }
            $client = $this->createSoapClient();
            $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
            if(!$rawresponse){
                return false;
            }
            $response = html_entity_decode($rawresponse);
            if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
                $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRS.txt";
                file_put_contents($file,$response);
            } else {
                mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
                $file = "../app/Domestic/Files/".session()->get('searchid')."/GetFlightDetailRS.txt";
                file_put_contents($file,$response);
            }
            $details = $this->formatResponse($response);
            return $details;
        }

    }

    public function formatResponse($response){
//        $response = $this->tempResponse();
        $doc  = new \DOMDocument();
        $doc->loadXML($response);
        $xmlArray = XMLSerializer::XMLtoArray($response);
        $soap_fault = $this->checkArrayKey($xmlArray,'ERROR');
        if($soap_fault){
            return false;
        }
        $soap_fault= $this->checkArrayKey($xmlArray,'S:FAULT');
        if($soap_fault){
            return false;
        }
        $detail = [];
        $detail['airline'] = $doc->getElementsByTagName('Airline')->item(0)->nodeValue;
        $detail['flightdate'] = $doc->getElementsByTagName('FlightDate')->item(0)->nodeValue;
        $detail['flightno'] = $doc->getElementsByTagName('FlightNo')->item(0)->nodeValue;
        $detail['departure'] = $doc->getElementsByTagName('Departure')->item(0)->nodeValue;
        $detail['departuretime'] = $doc->getElementsByTagName('DepartureTime')->item(0)->nodeValue;
        $detail['arrival'] = $doc->getElementsByTagName('Arrival')->item(0)->nodeValue;
        $detail['arrivaltime'] = $doc->getElementsByTagName('ArrivalTime')->item(0)->nodeValue;
        $detail['type'] = $doc->getElementsByTagName('AircraftType')->item(0)->nodeValue;
        $detail['class'] = $doc->getElementsByTagName('FlightClassCode')->item(0)->nodeValue;
        $detail['flightid'] = $doc->getElementsByTagName('FlightId')->item(0)->nodeValue;
        $detail['currency'] = $doc->getElementsByTagName('Currency')->item(0)->nodeValue;
        $detail['afare'] = $doc->getElementsByTagName('AdultFare')->item(0)->nodeValue;
        $detail['cfare'] = $doc->getElementsByTagName('ChildFare')->item(0)->nodeValue;
        $detail['ifare'] = $doc->getElementsByTagName('InfantFare')->item(0)->nodeValue;
        $detail['rfare'] = $doc->getElementsByTagName('ResFare')->item(0)->nodeValue;
        $detail['fuel']  = $doc->getElementsByTagName('FuelSurcharge')->item(0)->nodeValue;
        $detail['tax'] = $doc->getElementsByTagName('Tax')->item(0)->nodeValue;
        $detail['refund'] = $doc->getElementsByTagName('Refundable')->item(0)->nodeValue;
        $detail['baggage'] = $doc->getElementsByTagName('FreeBaggage')->item(0)->nodeValue;
        $detail['agencycommission'] = $doc->getElementsByTagName('AgencyCommission')->item(0)->nodeValue;

        return $detail;
    }

    public function tempResponse(){
        return <<<XML
<Availability>
	<Airline>RMK</Airline>
	<FlightDate>30-JAN-2019</FlightDate>
	<FlightNo>RMK171</FlightNo>
	<Departure>KATHMANDU</Departure>
	<DepartureTime>13:30</DepartureTime>
	<Arrival>BHAIRAHAWA</Arrival>
	<ArrivalTime>14:05</ArrivalTime>
	<AircraftType>BEECH</AircraftType>
	<Adult>1</Adult>
	<Child>0</Child>
	<Infant>0</Infant>
	<FlightId>7c5d46aa-e5b1-42aa-b913-c51283688a20</FlightId>
	<FlightClassCode>Y</FlightClassCode>
	<Currency>NPR</Currency>
	<AdultFare>3060</AdultFare>
	<ChildFare>2050.2</ChildFare>
	<InfantFare>306</InfantFare>
	<ResFare>5355</ResFare>
	<FuelSurcharge>2430</FuelSurcharge>
	<Tax>200</Tax>
	<Refundable>T</Refundable>
	<FreeBaggage>10 KG</FreeBaggage>
	<AgencyCommission>520.2</AgencyCommission>
	<CallingStationId>110.44.127.181</CallingStationId>
	<CallingStation>ASIANL</CallingStation>
</Availability>
XML;

    }
}