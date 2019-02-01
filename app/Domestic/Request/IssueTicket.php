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
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" 
xmlns:ns1="http://booking.us.org/">
   <SOAP-ENV:Body>
     <ns1:IssueTicket>
       $flights
       $contact
       <strPassengerDetail><![CDATA[<?xml version="1.0"?><PassengerDetail>
       $passengers
 </PassengerDetail>]]></strPassengerDetail>
     </ns1:IssueTicket>
   </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
XML;

    }

    public function generateFlights($flights){
//        dd($flights);
        if(count($flights)>1){
            $body_array = [

                    "strFlightId"=>$flights[0],
                    "strReturnFlightId"=>$flights[1],

            ];
        } else {
            $body_array = [

                    "strFlightId"=>$flights[0]
                    ];
        }
        $request = XMLSerializer::generateValidXmlFromArray($body_array);
        return $request;

    }

    public function generatePassengers($passengers){

        $space = "";
        foreach($passengers as $pax){
            $passengers_array = [
                "Passenger" => [
                    "PaxType"=>$pax['type'],
                    "Title"=>$pax['title'],
                    "Gender"=>$pax['gender'],
                    "FirstName"=>$pax['name'],
                    "LastName"=>$pax['surname'],
                    "Nationality"=>$pax['nationality'],
                    "PaxRemarks"=>$pax['remarks']
                ]

            ];

        }

        $request = XMLSerializer::generateValidXmlFromArray($passengers_array);
        return $request;

    }

    public function generateContact($contact){
        $contact_array = [
          "strContactName"=>$contact['name'],
          "strContactEmail"=>$contact['email'],
          "strContactMobile"=>$contact['contact']
        ];
        $request = XMLSerializer::generateValidXmlFromArray($contact_array);
        return $request;
    }

    public function doRequest($details){
//        dd($details);
        $passengers = $this->generatePassengers($details['pax']);
        $flights = $this->generateFlights($details['flights']);
        $contact = $this->generateContact($details['contact']);
        $xmlStr = $this->generateBodyXml($passengers,$flights,$contact);

        if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
            $file = "../app/Domestic/Files/".session()->get('searchid')."/IssueTicketRQ.txt";
            file_put_contents($file,$xmlStr);
        } else {
            mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
            $file = "../app/Domestic/Files/".session()->get('searchid')."/IssueTicketRQ.txt";
            file_put_contents($file,$xmlStr);
        }
//        dd($xmlStr);
        $client = $this->createSoapClient();
        $rawresponse = $client->__doRequest($xmlStr,'http://dev.usbooking.org/UnitedSolutions?wsdl','http://dev.usbooking.org/UnitedSolutions?wsdl',1);
        if(!$rawresponse){
            return false;
        }
        $response = html_entity_decode($rawresponse);
        if(is_dir("../app/Domestic/Files/".session()->get('searchid'))){
            $file = "../app/Domestic/Files/".session()->get('searchid')."/IssueTicketRS.txt";
            file_put_contents($file,$response);
        } else {
            mkdir("../app/Domestic/Files/".session()->get('searchid'),0755,true);
            $file = "../app/Domestic/Files/".session()->get('searchid')."/IssueTicketRS.txt";
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
    }
}