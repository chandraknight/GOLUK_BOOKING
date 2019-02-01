<?php
namespace App\Domestic\Request;

use App\Domestic\KeepBasic;
use App\Domestic\XMLSerializer;
use App\SearchFlight;
use Carbon\Carbon;

class FlightAvailability extends KeepBasic{
    public $searchid;
    public function __construct($id)
    {
        parent::__construct();
        $this->searchid = $id;
    }
    public function generateBody(){
        $search = SearchFlight::findorfail($this->searchid);
        if($search->return_date == null){
            $depart = Carbon::parse($search->depart_date)->format('d-M-Y');
//            dd($depart);
            return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <FlightAvailability xmlns="http://booking.us.dev/">
            <strUserId xmlns="">$this->userid</strUserId>
            <strPassword xmlns="">$this->password</strPassword>
            <strAgencyId xmlns="">$this->agency</strAgencyId>
            <strSectorFrom xmlns="">$search->location</strSectorFrom>
            <strSectorTo xmlns="">$search->destination</strSectorTo>
            <strFlightDate xmlns="">$depart</strFlightDate>
            <strReturnDate xmlns="">$depart</strReturnDate>
            <strTripType xmlns="">O</strTripType>
            <strNationality xmlns="">$search->nationality</strNationality>
            <intAdult xmlns="">$search->adults</intAdult>
            <intChild xmlns="">$search->childs</intChild>
        </FlightAvailability>
    </Body>
</Envelope>
XML;
        } else {
            $depart = Carbon::parse($search->depart_date)->format('d-M-Y');
            $return = Carbon::parse($search->return_date)->format('d-M-Y');
    return <<<XML
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <FlightAvailability xmlns="http://booking.us.dev/">
            <strUserId xmlns="">$this->userid</strUserId>
            <strPassword xmlns="">$this->password</strPassword>
            <strAgencyId xmlns="">$this->agency</strAgencyId>
            <strSectorFrom xmlns="">$search->location</strSectorFrom>
            <strSectorTo xmlns="">$search->destination</strSectorTo>
            <strFlightDate xmlns="">$depart</strFlightDate>
            <strReturnDate xmlns="">$return</strReturnDate>
            <strTripType xmlns="">R</strTripType>
            <strNationality xmlns="">$search->nationality</strNationality>
            <intAdult xmlns="">$search->adults</intAdult>
            <intChild xmlns="">$search->childs</intChild>
        </FlightAvailability>
    </Body>
</Envelope>
XML;
        }
    }

    public function doRequest(){
        $body = $this->generateBody();
        if(is_dir("../app/Domestic/Files/".$this->searchid."/FlightAvailabilityRQ.txt")){
            $file = "../app/Domestic/Files/".$this->searchid."/FlightAvailabilityRQ.txt";
            file_put_contents($file,$body);
        } else {
            mkdir("../app/Domestic/Files/".$this->searchid,0755,true);
            $file = "../app/Domestic/Files/".$this->searchid."/FlightAvailabilityRQ.txt";
            file_put_contents($file,$body);
        }


        $client = $this->createSoapClient();
        $rawresponse = $client->__doRequest($body,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
//        dd($rawresponse);
        if(!$rawresponse){
            return false;
        }
        $response = html_entity_decode($rawresponse);
        if(is_dir("../app/Domestic/Files/".$this->searchid)){
            $file = "../app/Domestic/Files/".$this->searchid."/FlightAvailabilityRS.txt";
            file_put_contents($file,$response);
        } else {
            mkdir("../app/Domestic/Files/".$this->searchid,0755,true);
            $file = "../app/Domestic/Files/".$this->searchid."/FlightAvailabilityRS.txt";
            file_put_contents($file,$response);
        }
//        dd($response);
//        $tempResponse = $this->tempResponse();
        $formattedResponse = $this->formatResponse($response);
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
        $flights['out'] = [];
        $flights['in']=[];
        $outair = [];
        $inair = [];
        $outbounds = $doc->getElementsByTagName('Outbound');
        foreach ($outbounds as $outbound){

            $availablity = $outbound->getElementsByTagName('Availability');
            foreach ($availablity as $available){
                $out=[];
                $out['airline'] = $available->getElementsByTagName('Airline')->item(0)->nodeValue;
                $out['logo']=$available->getElementsByTagName('AirlineLogo')->item(0)->nodeValue;
                $out['date']= $available->getElementsByTagName('FlightDate')->item(0)->nodeValue;
                $out['flightno']= $available->getElementsByTagName('FlightNo')->item(0)->nodeValue;
                $out['departure']= $available->getElementsByTagName('Departure')->item(0)->nodeValue;
                $out['departuretime'] = $available->getElementsByTagName('DepartureTime')->item(0)->nodeValue;
                $out['arrival']=$available->getElementsByTagName('Arrival')->item(0)->nodeValue;
                $out['arrivaltime']=$available->getElementsByTagName('ArrivalTime')->item(0)->nodeValue;
                $out['type']=$available->getElementsByTagName('AircraftType')->item(0)->nodeValue;
                $out['flightid']=$available->getElementsByTagName('FlightId')->item(0)->nodeValue;
                $out['class']=$available->getElementsByTagName('FlightClassCode')->item(0)->nodeValue;
                $out['currency']=$available->getElementsByTagName('Currency')->item(0)->nodeValue;
                $out['afare']=$available->getElementsByTagName('AdultFare')->item(0)->nodeValue;
                $out['cfare']=$available->getElementsByTagName('ChildFare')->item(0)->nodeValue;
                $out['ifare']=$available->getElementsByTagName('InfantFare')->item(0)->nodeValue;
                $out['rfare']=$available->getElementsByTagName('ResFare')->item(0)->nodeValue;
                $out['fuel']=$available->getElementsByTagName('FuelSurcharge')->item(0)->nodeValue;
                $out['tax']=$available->getElementsByTagName('Tax')->item(0)->nodeValue;
                $out['refund']=$available->getElementsByTagName('Refundable')->item(0)->nodeValue;
                $out['baggage']=$available->getElementsByTagName('FreeBaggage')->item(0)->nodeValue;
                $out['agencycomm']=$available->getElementsByTagName('AgencyCommission')->item(0)->nodeValue;
                $out['childcomm']=$available->getElementsByTagName('ChildCommission')->item(0)->nodeValue;
                array_push($flights['out'],$out);
            }

        }
//        dd($outair);
        $inair = [];
        $inbounds = $doc->getElementsByTagName('Inbound');
        foreach ($inbounds as $inbound){

            $availablity = $inbound->getElementsByTagName('Availability');
            if(count($availablity)>0){
                foreach ($availablity as $available){
                    $in=[];
                    $in['airline'] = $available->getElementsByTagName('Airline')->item(0)->nodeValue;
                    $in['logo']=$available->getElementsByTagName('AirlineLogo')->item(0)->nodeValue;
                    $in['date']= $available->getElementsByTagName('FlightDate')->item(0)->nodeValue;
                    $in['flightno']= $available->getElementsByTagName('FlightNo')->item(0)->nodeValue;
                    $in['departure']= $available->getElementsByTagName('Departure')->item(0)->nodeValue;
                    $in['departuretime'] = $available->getElementsByTagName('DepartureTime')->item(0)->nodeValue;
                    $in['arrival']=$available->getElementsByTagName('Arrival')->item(0)->nodeValue;
                    $in['arrivaltime']=$available->getElementsByTagName('ArrivalTime')->item(0)->nodeValue;
                    $in['type']=$available->getElementsByTagName('AircraftType')->item(0)->nodeValue;
                    $in['flightid']=$available->getElementsByTagName('FlightId')->item(0)->nodeValue;
                    $in['class']=$available->getElementsByTagName('FlightClassCode')->item(0)->nodeValue;
                    $in['currency']=$available->getElementsByTagName('Currency')->item(0)->nodeValue;
                    $in['afare']=$available->getElementsByTagName('AdultFare')->item(0)->nodeValue;
                    $in['cfare']=$available->getElementsByTagName('ChildFare')->item(0)->nodeValue;
                    $in['ifare']=$available->getElementsByTagName('InfantFare')->item(0)->nodeValue;
                    $in['rfare']=$available->getElementsByTagName('ResFare')->item(0)->nodeValue;
                    $in['fuel']=$available->getElementsByTagName('FuelSurcharge')->item(0)->nodeValue;
                    $in['tax']=$available->getElementsByTagName('Tax')->item(0)->nodeValue;
                    $in['refund']=$available->getElementsByTagName('Refundable')->item(0)->nodeValue;
                    $in['baggage']=$available->getElementsByTagName('FreeBaggage')->item(0)->nodeValue;
                    $in['agencycomm']=$available->getElementsByTagName('AgencyCommission')->item(0)->nodeValue;
                    $in['childcomm']=$available->getElementsByTagName('ChildCommission')->item(0)->nodeValue;
                    array_push($flights['in'],$in);
                }
            }
        }
//        array_push($flights,[
//            'out'=>$outair,
//            'in'=>$inair,
//        ]);
//        dd($flights);
        return $flights;
    }
    public function tempResponse(){
        return <<<XML
<Flightavailability>
	<Outbound>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK171</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>13:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>14:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>a95e9c4a-6cb8-4a2b-8576-7c7f8c79df11</FlightId>
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
			<ChildCommission>348.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK171</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>13:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>14:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>9f23e924-198e-41f1-9e4e-2d27750a8de4</FlightId>
			<FlightClassCode>A</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>2350</AdultFare>
			<ChildFare>2350</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>470</AgencyCommission>
			<ChildCommission>470</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK173</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>15:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>16:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>4ca62dcb-0894-46d2-b17b-6fe931da6286</FlightId>
			<FlightClassCode>D</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>600</AdultFare>
			<ChildFare>600</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>0</AgencyCommission>
			<ChildCommission>0</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK173</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>15:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>16:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>c2c9181e-608f-4ede-9291-46f1e0301694</FlightId>
			<FlightClassCode>C</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>900</AdultFare>
			<ChildFare>900</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>270</AgencyCommission>
			<ChildCommission>270</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK173</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>15:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>16:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>8cf91fb4-adb9-42ef-92ae-d86a56b0b643</FlightId>
			<FlightClassCode>B</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>1650</AdultFare>
			<ChildFare>1650</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>379.5</AgencyCommission>
			<ChildCommission>379.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK173</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>15:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>16:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>b7578a51-8f93-4318-ae97-9c435aeb5fd5</FlightId>
			<FlightClassCode>A</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>2350</AdultFare>
			<ChildFare>2350</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>470</AgencyCommission>
			<ChildCommission>470</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK173</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>15:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>16:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>4aa1438e-1fdb-4cb8-82ba-dbd145cd5759</FlightId>
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
			<ChildCommission>348.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK171</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>13:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>14:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>22cd8772-98ce-4c26-b5cb-22e1ad0451e5</FlightId>
			<FlightClassCode>D</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>600</AdultFare>
			<ChildFare>600</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>0</AgencyCommission>
			<ChildCommission>0</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK171</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>13:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>14:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>2192bf76-77f5-4a7f-ad76-73560910cd22</FlightId>
			<FlightClassCode>C</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>900</AdultFare>
			<ChildFare>900</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>270</AgencyCommission>
			<ChildCommission>270</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>30-JAN-2019</FlightDate>
			<FlightNo>RMK171</FlightNo>
			<Departure>KATHMANDU</Departure>
			<DepartureTime>13:30</DepartureTime>
			<Arrival>BHAIRAHAWA</Arrival>
			<ArrivalTime>14:05</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>bf719c3f-6239-4a97-9724-dcaf46c8a93b</FlightId>
			<FlightClassCode>B</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>1650</AdultFare>
			<ChildFare>1650</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>379.5</AgencyCommission>
			<ChildCommission>379.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
	</Outbound>
	<Inbound>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK172</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>14:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>14:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>348a8854-7872-44dc-b9c1-08c67cf228eb</FlightId>
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
			<ChildCommission>348.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK174</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>16:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>16:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>3898ec0c-65da-4c68-9080-d77e9a63df0d</FlightId>
			<FlightClassCode>C</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>900</AdultFare>
			<ChildFare>900</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>270</AgencyCommission>
			<ChildCommission>270</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK174</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>16:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>16:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>38de3eb4-14aa-4aaf-8c3e-bf1eec9e658b</FlightId>
			<FlightClassCode>B</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>1650</AdultFare>
			<ChildFare>1650</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>379.5</AgencyCommission>
			<ChildCommission>379.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK174</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>16:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>16:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>0fac9752-c9ca-4126-9024-a7a975018ed4</FlightId>
			<FlightClassCode>A</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>2350</AdultFare>
			<ChildFare>2350</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>470</AgencyCommission>
			<ChildCommission>470</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK174</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>16:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>16:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>8d12a979-50b7-4e28-8c8a-11a2fd80cb43</FlightId>
			<FlightClassCode>D</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>600</AdultFare>
			<ChildFare>600</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>0</AgencyCommission>
			<ChildCommission>0</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK172</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>14:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>14:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>5e16a352-c38c-4bb1-9e33-e4cf63c32b39</FlightId>
			<FlightClassCode>D</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>600</AdultFare>
			<ChildFare>600</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>0</AgencyCommission>
			<ChildCommission>0</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK172</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>14:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>14:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>f266176a-1d6b-4e8e-8639-fd16b6a076a3</FlightId>
			<FlightClassCode>C</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>900</AdultFare>
			<ChildFare>900</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>F</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>270</AgencyCommission>
			<ChildCommission>270</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK172</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>14:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>14:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>938430ff-ac41-47c4-98b8-6eb230e07650</FlightId>
			<FlightClassCode>B</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>1650</AdultFare>
			<ChildFare>1650</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>379.5</AgencyCommission>
			<ChildCommission>379.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK172</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>14:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>14:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>b96adeec-ac4e-4d53-a40e-b5c46c6fabfe</FlightId>
			<FlightClassCode>A</FlightClassCode>
			<Currency>NPR</Currency>
			<AdultFare>2350</AdultFare>
			<ChildFare>2350</ChildFare>
			<InfantFare>0</InfantFare>
			<ResFare>0</ResFare>
			<FuelSurcharge>2430</FuelSurcharge>
			<Tax>200</Tax>
			<Refundable>T</Refundable>
			<FreeBaggage>10 KG</FreeBaggage>
			<AgencyCommission>470</AgencyCommission>
			<ChildCommission>470</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
		<Availability>
			<Airline>RMK</Airline>
			<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
			<FlightDate>02-FEB-2019</FlightDate>
			<FlightNo>RMK174</FlightNo>
			<Departure>BHAIRAHAWA</Departure>
			<DepartureTime>16:20</DepartureTime>
			<Arrival>KATHMANDU</Arrival>
			<ArrivalTime>16:55</ArrivalTime>
			<AircraftType>BEECH</AircraftType>
			<Adult>1</Adult>
			<Child>1</Child>
			<Infant>0</Infant>
			<FlightId>b31ba1a7-6629-4220-9934-3acab29a079b</FlightId>
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
			<ChildCommission>348.5</ChildCommission>
			<CallingStationId>110.44.127.181</CallingStationId>
			<CallingStation>ASIANL</CallingStation>
		</Availability>
	</Inbound>
</Flightavailability>
XML;

    }
}