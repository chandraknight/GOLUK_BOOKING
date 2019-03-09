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
        if(is_dir("../storage/app/public/Domestic/".$this->searchid."/FlightAvailabilityRQ.txt")){
            $file = "../storage/app/public/Domestic/".$this->searchid."/FlightAvailabilityRQ.txt";
            file_put_contents($file,$body);
        } else {
            mkdir("../storage/app/public/Domestic/".$this->searchid,0755,true);
            $file = "../storage/app/public/Domestic/".$this->searchid."/FlightAvailabilityRQ.txt";
            file_put_contents($file,$body);
        }


        $client = $this->createSoapClient();
        $rawresponse = $client->__doRequest($body,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
//        dd($rawresponse);
        if(!$rawresponse){
            return false;
        }
        $response = html_entity_decode($rawresponse);
        if(is_dir("../storage/app/public/Domestic/".$this->searchid)){
            $file = "../storage/app/public/Domestic/".$this->searchid."/FlightAvailabilityRS.txt";
            file_put_contents($file,$response);
        } else {
            mkdir("../storage/app/public/Domestic/".$this->searchid,0755,true);
            $file = "../storage/app/public/Domestic/".$this->searchid."/FlightAvailabilityRS.txt";
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
//        $response = $this->tempResponse();
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
								$out['tafare'] = $available->getElementsByTagName('AdultFare')->item(0)->nodeValue + $available->getElementsByTagName('FuelSurcharge')->item(0)->nodeValue + $available->getElementsByTagName('Tax')->item(0)->nodeValue;
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
					$in['tafare'] = $available->getElementsByTagName('AdultFare')->item(0)->nodeValue + $available->getElementsByTagName('FuelSurcharge')->item(0)->nodeValue + $available->getElementsByTagName('Tax')->item(0)->nodeValue;
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
      //  dd($flights);
        return $flights;
    }
    public function tempResponse(){
        return <<<XML
<?xml version='1.0' encoding='UTF-8'?>
<S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
	<S:Body>
		<ns2:FlightAvailabilityResponse xmlns:ns2="http://booking.us.dev/">
			<return>
				<Flightavailability>
					<Outbound>
						<Availability>
							<Airline>RMK</Airline>
							<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
							<FlightDate>28-FEB-2019</FlightDate>
							<FlightNo>RMKCHT1</FlightNo>
							<Departure>BIRATNAGAR</Departure>
							<DepartureTime>11:30</DepartureTime>
							<Arrival>KATHMANDU</Arrival>
							<ArrivalTime>11:30</ArrivalTime>
							<AircraftType>BEECH</AircraftType>
							<Adult>1</Adult>
							<Child>0</Child>
							<Infant>0</Infant>
							<FlightId>0e68876c-ed72-48e9-96a3-0e668e95ba70</FlightId>
							<FlightClassCode>Y</FlightClassCode>
							<Currency>NPR</Currency>
							<AdultFare>5000</AdultFare>
							<ChildFare>3350</ChildFare>
							<InfantFare>500</InfantFare>
							<ResFare>8750</ResFare>
							<FuelSurcharge>2000</FuelSurcharge>
							<Tax>0</Tax>
							<Refundable>T</Refundable>
							<FreeBaggage>10 KG</FreeBaggage>
							<AgencyCommission>0</AgencyCommission>
							<ChildCommission>0</ChildCommission>
							<CallingStationId>202.51.76.200</CallingStationId>
							<CallingStation>ASIANL</CallingStation>
						</Availability>
						<Availability>
							<Airline>RMK</Airline>
							<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
							<FlightDate>28-FEB-2019</FlightDate>
							<FlightNo>RMKCHT1</FlightNo>
							<Departure>BIRATNAGAR</Departure>
							<DepartureTime>11:30</DepartureTime>
							<Arrival>KATHMANDU</Arrival>
							<ArrivalTime>11:30</ArrivalTime>
							<AircraftType>BEECH</AircraftType>
							<Adult>1</Adult>
							<Child>0</Child>
							<Infant>0</Infant>
							<FlightId>dbd4bfc2-e560-44e2-94f3-7d29b66fc0dd</FlightId>
							<FlightClassCode>A</FlightClassCode>
							<Currency>NPR</Currency>
							<AdultFare>4500</AdultFare>
							<ChildFare>4500</ChildFare>
							<InfantFare>0</InfantFare>
							<ResFare>0</ResFare>
							<FuelSurcharge>2000</FuelSurcharge>
							<Tax>0</Tax>
							<Refundable>T</Refundable>
							<FreeBaggage>10 KG</FreeBaggage>
							<AgencyCommission>0</AgencyCommission>
							<ChildCommission>0</ChildCommission>
							<CallingStationId>202.51.76.200</CallingStationId>
							<CallingStation>ASIANL</CallingStation>
						</Availability>
						<Availability>
							<Airline>RMK</Airline>
							<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
							<FlightDate>28-FEB-2019</FlightDate>
							<FlightNo>RMKCHT1</FlightNo>
							<Departure>BIRATNAGAR</Departure>
							<DepartureTime>11:30</DepartureTime>
							<Arrival>KATHMANDU</Arrival>
							<ArrivalTime>11:30</ArrivalTime>
							<AircraftType>BEECH</AircraftType>
							<Adult>1</Adult>
							<Child>0</Child>
							<Infant>0</Infant>
							<FlightId>3b4974d3-d703-408f-9fb0-8d03e970ba5a</FlightId>
							<FlightClassCode>D</FlightClassCode>
							<Currency>NPR</Currency>
							<AdultFare>0</AdultFare>
							<ChildFare>0</ChildFare>
							<InfantFare>0</InfantFare>
							<ResFare>0</ResFare>
							<FuelSurcharge>2000</FuelSurcharge>
							<Tax>0</Tax>
							<Refundable>F</Refundable>
							<FreeBaggage>10 KG</FreeBaggage>
							<AgencyCommission>0</AgencyCommission>
							<ChildCommission>0</ChildCommission>
							<CallingStationId>202.51.76.200</CallingStationId>
							<CallingStation>ASIANL</CallingStation>
						</Availability>
						<Availability>
							<Airline>RMK</Airline>
							<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
							<FlightDate>28-FEB-2019</FlightDate>
							<FlightNo>RMKCHT1</FlightNo>
							<Departure>BIRATNAGAR</Departure>
							<DepartureTime>11:30</DepartureTime>
							<Arrival>KATHMANDU</Arrival>
							<ArrivalTime>11:30</ArrivalTime>
							<AircraftType>BEECH</AircraftType>
							<Adult>1</Adult>
							<Child>0</Child>
							<Infant>0</Infant>
							<FlightId>701dc1fa-40f7-4e2b-82ca-39d9a5f1a7ab</FlightId>
							<FlightClassCode>C</FlightClassCode>
							<Currency>NPR</Currency>
							<AdultFare>4000</AdultFare>
							<ChildFare>4000</ChildFare>
							<InfantFare>0</InfantFare>
							<ResFare>0</ResFare>
							<FuelSurcharge>2000</FuelSurcharge>
							<Tax>0</Tax>
							<Refundable>F</Refundable>
							<FreeBaggage>10 KG</FreeBaggage>
							<AgencyCommission>0</AgencyCommission>
							<ChildCommission>0</ChildCommission>
							<CallingStationId>202.51.76.200</CallingStationId>
							<CallingStation>ASIANL</CallingStation>
						</Availability>
						<Availability>
							<Airline>RMK</Airline>
							<AirlineLogo>http://116.90.239.74/us/apiImages/RMK.jpg</AirlineLogo>
							<FlightDate>28-FEB-2019</FlightDate>
							<FlightNo>RMKCHT1</FlightNo>
							<Departure>BIRATNAGAR</Departure>
							<DepartureTime>11:30</DepartureTime>
							<Arrival>KATHMANDU</Arrival>
							<ArrivalTime>11:30</ArrivalTime>
							<AircraftType>BEECH</AircraftType>
							<Adult>1</Adult>
							<Child>0</Child>
							<Infant>0</Infant>
							<FlightId>060feb55-6db1-43a7-82bf-a7b0a7421f45</FlightId>
							<FlightClassCode>B</FlightClassCode>
							<Currency>NPR</Currency>
							<AdultFare>4200</AdultFare>
							<ChildFare>4200</ChildFare>
							<InfantFare>0</InfantFare>
							<ResFare>0</ResFare>
							<FuelSurcharge>2000</FuelSurcharge>
							<Tax>0</Tax>
							<Refundable>T</Refundable>
							<FreeBaggage>10 KG</FreeBaggage>
							<AgencyCommission>0</AgencyCommission>
							<ChildCommission>0</ChildCommission>
							<CallingStationId>202.51.76.200</CallingStationId>
							<CallingStation>ASIANL</CallingStation>
						</Availability>
					</Outbound>
					<Inbound/>
				</Flightavailability>
			</return>
		</ns2:FlightAvailabilityResponse>
	</S:Body>
</S:Envelope>
XML;

    }
}