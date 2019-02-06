<?php
namespace App\Domestic\Request;

use App\Domestic\KeepBasic;
use App\Domestic\XMLSerializer;

class IssueTicket extends KeepBasic {
    public function __construct()
    {
        parent::__construct();
    }

    public function generateBodyXml($passengers,$flights,$contact){
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://booking.us.dev/">
    <SOAP-ENV:Body>
        <ns1:IssueTicket>
            $flights
            $contact
            <strPassengerDetail><![CDATA[<?xml version="1.0"?><PassengerDetail>$passengers</PassengerDetail>]]></strPassengerDetail>
       </ns1:IssueTicket>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

    }

    public function generateFlights($flights){
//        dd($flights);
        if(count($flights)>1){

            $flightid = $flights[0];
            $returnflight = $flights[1];
            return <<<XML
<strFlightId>$flightid</strFlightId>
            <strReturnFlightId>$returnflight</strReturnFlightId>
XML;

        } else {

            $flightid = $flights[0];
            return <<<XML
<strFlightId>$flightid</strFlightId>
            <strReturnFlightId></strReturnFlightId>
XML;

        }


    }

    public function generatePassengers($passengers){
        $passengers_array = [
            'Passenger'=>''
        ];
        $space = '';
        foreach($passengers as $pax){
//            dd($pax);
                $data =[
                    "PaxType"=>$pax['type'],
                    "Title"=>$pax['title'],
                    "Gender"=>$pax['gender'],
                    "FirstName"=>$pax['name'],
                    "LastName"=>$pax['surname'],
                    "Nationality"=>$pax['nationality'],
                    "PaxRemarks"=>$pax['remarks']
                ];
                $passengers_array['Passenger'.$space] = $data;
                $space =$space.' ';
        }
        $request = XMLSerializer::generateValidXmlFromArray($passengers_array);
        RETURN $request;
//        $data = '';
//        foreach($passengers as $pax){
//            $data = $data.
//                    '<Passenger>' . PHP_EOL.
//                        '<PaxType>'.$pax->passenger_type.'</PaxType>'.PHP_EOL.
//                        '<Title>'.$pax->passenger_title.'</Title>'.PHP_EOL.
//                        '<Gender>'.$pax->passenger_gender.'</Gender>'.PHP_EOL.
//                        '<FirstName>'.$pax->passenger_name.'</FirstName>'.PHP_EOL.
//                        '<LastName>'.$pax->passenger_surname.'</LastName>'.PHP_EOL.
//                        '<Nationality>'.$pax->passenger_nationality.'</Nationality>'.PHP_EOL.
//                        '<PaxRemarks>'.$pax->passenger_remarks.'</PaxRemarks>'.PHP_EOL.
//                        '</Passenger>';
//        }
//        return $data;

    }

    public function generateContact($contact){

        $name = $contact['name'];
        $email = $contact['email'];
        $phone = $contact['contact'];
        return <<<XML
<strContactName>$name</strContactName>
            <strContactEmail>$email</strContactEmail>
            <strContactMobile>$phone</strContactMobile>
XML;

    }


    public function tempRequest(){
        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://booking.us.dev/">
  <SOAP-ENV:Body>
    <ns1:IssueTicket>
      <strFlightId>95d503d0-6a75-449d-9f9c-b306f4019a49</strFlightId>
      <strReturnFlightId></strReturnFlightId>
      <strContactName>Test name</strContactName>
      <strContactEmail>test@test.com</strContactEmail>
      <strContactMobile>4526875214</strContactMobile>
      <strPassengerDetail><![CDATA[<?xml version="1.0"?><PassengerDetail>
                         <Passenger>
                             <PaxType>ADULT</PaxType>
                             <Title>Mr</Title>
                             <Gender>M</Gender>
                             <FirstName>Plazma</FirstName>
                             <LastName>Test</LastName>
                             <Nationality>NP</Nationality>
                             <PaxRemarks>Test Ticket</PaxRemarks>
                             </Passenger>
                         </PassengerDetail>]]></strPassengerDetail>
    </ns1:IssueTicket>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

    }

    public function doRequest($details){
//        dd($details);
        $passengers = $this->generatePassengers($details['pax']);
        $flights = $this->generateFlights($details['flights']);
        $contact = $this->generateContact($details['contact']);
        $xmlStr= $this->generateBodyXml($passengers,$flights,$contact);
        $xmlreq = $this->tempRequest();
//        dd($xmlStr);
        if(is_dir("../storage/app/public/Domestic/".session()->get('searchid'))){
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/IssueTicketRQ.txt";
            file_put_contents($file,$xmlStr);
        } else {
            mkdir("../storage/app/public/Domestic/".session()->get('searchid'),0755,true);
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/IssueTicketRQ.txt";
            file_put_contents($file,$xmlStr);
        }
//        dd($xmlStr);
        $client = $this->createSoapClient();
        $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
        if(!$rawresponse){
            return false;
        }
        $response = html_entity_decode($rawresponse);
        if(is_dir("../storage/app/public/Domestic/".session()->get('searchid'))){
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/IssueTicketRS.txt";
            file_put_contents($file,$response);
        } else {
            mkdir("../storage/app/public/Domestic/".session()->get('searchid'),0755,true);
            $file = "../storage/app/public/Domestic/".session()->get('searchid')."/IssueTicketRS.txt";
            file_put_contents($file,$response);
        }
        $formattedresponse = $this->formatResponse($response);
        return $formattedresponse;
    }

    public function formatResponse($response){
//        dd($response);
        $doc = new \DOMDocument();
        $doc->loadXML($response);
        $xmlArray = XMLSerializer::XMLtoArray($response);
//        dd($xmlArray);
        $soap_fault = $this->checkArrayKey($xmlArray,'ERROR');
        if($soap_fault){
            return false;
        }
        $soap_fault= $this->checkArrayKey($xmlArray,'S:FAULT');
        if($soap_fault){
            return false;
        }
        $passengers = $doc->getElementsByTagName('Passenger');
        $ticketDetails = [];
        foreach($passengers as $passenger){

            array_push($ticketDetails,[
                'airline'=>$passenger->getElementsByTagName('Airline')->item(0)->nodeValue,
                'pnr'=>$passenger->getElementsByTagName('PnrNo')->item(0)->nodeValue,
                'title'=>$passenger->getElementsByTagName('Title')->item(0)->nodeValue,
                'gender'=>$passenger->getElementsByTagName('Gender')->item(0)->nodeValue,
                'name'=>$passenger->getElementsByTagName('FirstName')->item(0)->nodeValue,
                'surname'=>$passenger->getElementsByTagName('LastName')->item(0)->nodeValue,
                'pax_type'=>$passenger->getElementsByTagName('PaxType')->item(0)->nodeValue,
                'nationality'=>$passenger->getElementsByTagName('Nationality')->item(0)->nodeValue,
                'issue_date'=>$passenger->getElementsByTagName('IssueDate')->item(0)->nodeValue,
                'flightno'=>$passenger->getElementsByTagName('FlightNo')->item(0)->nodeValue,
                'flightdate'=>$passenger->getElementsByTagName('FlightDate')->item(0)->nodeValue,
                'flight_time'=>$passenger->getElementsByTagName('FlightTime')->item(0)->nodeValue,
                'ticketno'=>$passenger->getElementsByTagName('TicketNo')->item(0)->nodeValue,
                'barcode'=>$passenger->getElementsByTagName('BarCodeValue')->item(0)->nodeValue,
                'barcodeimage'=>$passenger->getElementsByTagName('BarcodeImage')->item(0)->nodeValue,
                'arrival'=>$passenger->getElementsByTagName('Arrival')->item(0)->nodeValue,
                'arrivaltime'=>$passenger->getElementsByTagName('ArrivalTime')->item(0)->nodeValue,
                'sector'=>$passenger->getElementsByTagName('Sector')->item(0)->nodeValue,
                'class'=>$passenger->getElementsByTagName('ClassCode')->item(0)->nodeValue,
                'currency'=>$passenger->getElementsByTagName('Currency')->item(0)->nodeValue,
                'fare'=>$passenger->getElementsByTagName('Fare')->item(0)->nodeValue,
                'surcharge'=>$passenger->getElementsByTagName('Surcharge')->item(0)->nodeValue,
                'taxcurrency'=>$passenger->getElementsByTagName('TaxCurrency')->item(0)->nodeValue,
                'tax'=>$passenger->getElementsByTagName('Tax')->item(0)->nodeValue,
                'commission'=>$passenger->getElementsByTagName('CommissionAmount')->item(0)->nodeValue,
                'refundable'=>$passenger->getElementsByTagName('Refundable')->item(0)->nodeValue,
                'baggage'=>$passenger->getElementsByTagName('FreeBaggage')->item(0)->nodeValue
            ]);
         }

         return $ticketDetails;
    }

    public function tempResponse(){
        return <<<XML
<?xml version='1.0' encoding='UTF-8'?>
<S:Envelope
    xmlns:S="http://schemas.xmlsoap.org/soap/envelope/">
	<S:Body>
		<ns2:IssueTicketResponse
            xmlns:ns2="http://booking.us.dev/">
			<return>
				<Itinerary>
					<Passenger>
						<Airline>RMK</Airline>
						<PnrNo>EQVS3A</PnrNo>
						<Title/>
						<Gender>M</Gender>
						<FirstName>PLAZMA TEST</FirstName>
						<LastName/>
						<PaxNo/>
						<PaxType>ADULT</PaxType>
						<Nationality>NEP</Nationality>
						<PaxId/>
						<IssueFrom>PLZ147</IssueFrom>
						<AgencyName>PLZ147</AgencyName>
						<IssueDate>03-FEB-2019</IssueDate>
						<IssueBy>ASIANL</IssueBy>
						<FlightNo>CHT</FlightNo>
						<FlightDate>10-FEB-2019</FlightDate>
						<Departure>KTM</Departure>
						<FlightTime>12:50</FlightTime>
						<TicketNo>227280</TicketNo>
						<BarCodeValue>227280#EQVS3A</BarCodeValue>
						<BarcodeImage>http://dev.unitsoln.com/us/b2b/barcode/img/227280.png</BarcodeImage>
						<Arrival>BIR</Arrival>
						<ArrivalTime>12:50</ArrivalTime>
						<Sector>KTM-BIR</Sector>
						<ClassCode>Y</ClassCode>
						<Currency>NPR</Currency>
						<Fare>5000</Fare>
						<Surcharge>1000</Surcharge>
						<TaxCurrency>NPR</TaxCurrency>
						<Tax>200</Tax>
						<CommissionAmount>5000</CommissionAmount>
						<Refundable>Refundable</Refundable>
						<ReportingTime>One Hour Before Flight Time</ReportingTime>
						<FreeBaggage>10KG</FreeBaggage>
					</Passenger>
				</Itinerary>
			</return>
		</ns2:IssueTicketResponse>
	</S:Body>
</S:Envelope>
XML;

    }
}