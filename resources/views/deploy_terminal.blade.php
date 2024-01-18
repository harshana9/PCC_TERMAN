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
    <h1>{{ $title }}</h1>
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
                    <th>TID</th>
                    <th>Merchnat</th>
                    <th>Serial No</th>
                    <th>Condition</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dataset['deploy__terminal'] as $item)
                <tr>
                    <td>{{ $item['tid'] }}</td>
                    <td>{{ $item['merchant'] }} ({{ $item['mid'] }})</td>
                    <td>{{ $item['serial_no'] }}</td>
                    <td>{{ $item['condition'] }}</td>
                    <td>{{ $item['remark'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>