<?php
namespace App\Domestic\Request;

use App\Domestic\KeepBasic;
use App\Domestic\XMLSerializer;

class Reservation extends KeepBasic {
    public function __construct()
    {
        parent::__construct();
    }

    public function generateBody($flights){
//        dd($flights);
        if(isset($flights['in'])){
            $in = $flights['in'];
            $out = $flights['out'];
            return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Reservation xmlns="http://booking.us.dev/">
            <strFlightId xmlns="">$out</strFlightId>
            <strReturnFlightId xmlns="">$in</strReturnFlightId>
        </Reservation>
    </Body>
</Envelope>
XML;
        } else {
            $out = $flights['out'];
            return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Reservation xmlns="http://booking.us.dev/">
            <strFlightId xmlns="">$out</strFlightId>
            <strReturnFlightId xmlns=""></strReturnFlightId>
        </Reservation>
    </Body>
</Envelope>
XML;
        }


    }

    public function doRequest($flights){
//        dd($flights);
        $xmlStr = $this->generateBody($flights);
//        dd($xmlStr);
        if(is_dir("../storage/app/public/Domestic/".session()->get('searchid'))){
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/ReservationRQ.txt";
            file_put_contents($file,$xmlStr);
        } else {
            mkdir("../storage/app/public/Domestic/".session()->get('searchid'),0755,true);
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/ReservationRQ.txt";
            file_put_contents($file,$xmlStr);
        }

        $client = $this->createSoapClient();
        $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
        if(!$rawresponse){
            return false;
        }
        $response = html_entity_decode($rawresponse);
//        dd($response);
        if(is_dir("../storage/app/public/Domestic/".session()->get('searchid'))){
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/ReservationRS.txt";
            file_put_contents($file,$response);
        } else {
            mkdir("../storage/app/public/Domestic/".session()->get('searchid'),0755,true);
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/ReservationRS.txt";
            file_put_contents($file,$response);
        }

        $formattedresponse = $this->formatResponse($response);
        if(!$formattedresponse){
            return false;
        }
//        dd($formattedresponse);
        return $formattedresponse;
    }

    public function formatResponse($response){
//        $response = $this->tempResponse();
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $xmlArray = XMLSerializer::XMLtoArray($response);
//        dd($xmlArray);
        $soap_fault = $this->checkArrayKey($xmlArray,"ERROR");
        if($soap_fault){
            return false;
        }
        $soap_fault = $this->checkArrayKey($xmlArray,"S:FAULT");
//        dd($soap_fault);
        if($soap_fault){
            return false;
        }
        $formattedResponse = [];
        $pnrdetail = $doc->getElementsByTagName('PNRDetail');
        foreach ($pnrdetail as $detail){
            $airlineid = $detail->getElementsByTagName('AirlineID')->item(0)->nodeValue;
            $flightid = $detail->getElementsByTagName('FlightId')->item(0)->nodeValue;
            $pnr = $detail->getElementsByTagName('PNRNO')->item(0)->nodeValue;
            $status = $detail->getElementsByTagName('ReservationStatus')->item(0)->nodeValue;
            $ttldate = $detail->getElementsByTagName('TTLDate')->item(0)->nodeValue;
            $ttltime = $detail->getElementsByTagName('TTLTime')->item(0)->nodeValue;
            array_push($formattedResponse,[
                'airline'=>$airlineid,
                'flight'=>$flightid,
                'pnr'=>$pnr,
                'status'=>$status,
                'ttldate'=>$ttldate,
                'ttltime'=>$ttltime
            ]);
        }
//        dd($formattedResponse);

        return $formattedResponse;
    }



    public function tempResponse(){
        return <<<XML
<S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
	<S:Body>
		<ns2:ReservationResponse xmlns:ns2="http://booking.us.org/">
			<ReservationDetail>
				<PNRDetail>
					<AirlineID>U4</AirlineID>
					<FlightId>d27185d1-dc00-491e-88bf-17905b44c162</FlightId>
					<PNRNO>TMPPNR</PNRNO>
					<ReservationStatus>HK</ReservationStatus>
					<TTLDate>29-DEC-2014</TTLDate>
					<TTLTime>12:20</TTLTime>
				</PNRDetail>
			</ReservationDetail>
		</ns2:ReservationResponse>
	</S:Body>
</S:Envelope>
XML;

    }
}