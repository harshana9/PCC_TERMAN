<!DOCTYPE html>
<html>
<head>
    <title>Issue Note to PCC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
        td{
            vertical-align: top;
        }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <table width="100%">
        <tr>
            <td colspan="2"><b>Date : </b>{{ $dataset['date'] }}<br/></td>
        </tr>
        <tr>
            <td>
                <b>Product Manufacturer/Vendor :</b><br/>
                <table width="100%">
                    <tr><td>Name : </td><td>{{ $dataset['vendor_name'] }}</td></tr>
                    <tr><td>Address : </td><td>{{ $dataset['vendor_address'] }}</td></tr>
                    <tr><td>Email : </td><td>{{ $dataset['vendor_email'] }}</td></tr>
                    <tr><td>Contact : </td><td>{{ $dataset['vendor_contact_1'] }}<br/>{{ $dataset['vendor_contact_2'] }}</td></tr>
                </table>
            </td>
        </tr>
    </table>
    
    <div class="table-responsive" style="margin-top:25px;">
        <table class="table">
            <thead>
                <tr>
                    <th>Replace Date</th>
                    <th>Merchant</th>
                    <th>TID</th>
                    <th>Old Terminal</th>
                    <th>New Terminal</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dataset['replace__terminal'] as $item)
                <tr>
                    <td>{{ $item['date'] }}</td>
                    <td>{{ $item['merchant'] }} ({{ $item['mid'] }})</td>
                    <td>{{ $item['tid'] }}</td>
                    <td>
                        <b>SN:</b> {{ $item['serial_no_old'] }}<br/>
                        <b>Prod.:</b> {{ $item['old_product']}} ({{ $item['old_connection_type']}})<br/>
                        <b>condition:</b> {{ $item['old_machine_condition']}}
                    </td>
                    <td>
                        <b>SN:</b> {{ $item['serial_no_new'] }}<br/>
                        <b>Prod.:</b> {{ $item['new_product']}} ({{ $item['new_machine_condition']}})<br/>
                        <b>condition:</b> {{ $item['new_machine_condition']}}
                    </td>
                    <td>{{ $item['remark'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>