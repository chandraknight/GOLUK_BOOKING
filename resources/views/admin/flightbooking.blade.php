@extends('admin.layouts.main')
@section('content')
    <table id="flightbooking" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                Customer Name
            </th>
            <th>
                Customer Contact
            </th>
            <th>
                Customer Email
            </th>
            <th>
                Adults
            </th>
            <th>
                Childs
            </th>
            <th>
                Amount
            </th>
            <th>
                Commission
            </th>
            <th>
                Actions
            </th>
        </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <script>
        $('#flightbooking').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url":"{{route('admin.flight.booking.data')}}",
                "dataType":"json",
                "type":"POST",
                "data":{"_token":"<?= csrf_token(); ?>"}
            },
            "columns":[
                {"data":"id","searchable":false,"orderable":false},
                {"data":"customer_name"},
                {"data":"customer_contact"},
                {"data":"customer_email"},
                {"data":"adults"},
                {"data":"childs"},
                {"data":"amount"},
                {"data":"commission"},
                {"data":"actions","searchable":false,"orderable":false}
            ],
            language: {
                searchPlaceholder: "By Name,Email,Contact"
            }
        } );

    </script>
@endsection