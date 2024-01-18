<!DOCTYPE html>
<html>
<head>
    <title>Deployed Terminal Report</title>
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
            <td colspan="2"><b>Date : </b>{{ $date }}<br/></td>
        </tr>
    </table>
    
    <div class="table-responsive" style="margin-top:25px;">
        <table class="table">
            <thead>
                <tr>
                `tid``mid``merchant``city``product``connection_type``vendor_name``serial_no``condition``remove_condition`
                    <th>TID</th>
                    <th>MID</th>
                    <th>Merchnat</th>
                    <th>City</th>
                    <th>Product</th>
                    <th>Connection Type</th>
                    <th>Vendor Name</th>
                    <th>Serial No</th>
                    <th>Deploy Condition</th>
                    <th>Remove Condition</th>
                </tr>
            </thead>
            <tbody>
            @foreach($dataset as $item)
                <tr>
                    <td>{{ $item['tid'] }}</td>
                    <td>{{ $item['mid'] }}</td>
                    <td>{{ $item['merchant'] }}</td>
                    <td>{{ $item['city'] }}</td>
                    <td>{{ $item['product'] }}</td>
                    <td>{{ $item['connection_type'] }}</td>
                    <td>{{ $item['vendor_name'] }}</td>
                    <td>{{ $item['serial_no'] }}</td>
                    <td>{{ $item['condition'] }}</td>
                    <td>{{ $item['remove_condition'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</body>

</html>