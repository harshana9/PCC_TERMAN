<!DOCTYPE html>
<html>
<head>
    <title>Purchase Note</title>
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
        <table class="table" border="1">
            <thead>
                <tr>
                    <th rowspan="2">Product</th>
                    <td colspan="2">Supplies</td>
                    <td colspan="2">PCC</td>
                    <td colspan="2">Vendor</td>
                    <td rowspan="2">Deployed</td>
                    <td rowspan="2">Junked</td>
                    <td rowspan="2">Total</td>
                </tr>
                <tr>
                    <td>New</td>
                    <td>Used</td>
                    <td>New</td>
                    <td>Used</td>
                    <td>New</td>
                    <td>Used</td>
                </tr>
            </thead>
            <tbody>
            @foreach($dataset as $product)
                <tr>
                    <td>{{ $product['name'] }}</td>
                    <td>{{ $product['stock_new_supplies'] }}</td>
                    <td>{{ $product['stock_used_supplies'] }}</td>
                    <td>{{ $product['stock_new_pcc'] }}</td>
                    <td>{{ $product['stock_used_pcc'] }}</td>
                    <td>{{ $product['stock_new_vendor'] }}</td>
                    <td>{{ $product['stock_used_vendor'] }}</td>
                    <td>{{ $product['stock_deployed'] }}</td>
                    <td>{{ $product['stock_junked'] }}</td>
                    <td>{{ $product['stock_new_supplies'] + $product['stock_used_supplies'] + $product['stock_new_pcc'] + $product['stock_used_pcc'] + $product['stock_new_vendor'] + $product['stock_used_vendor'] + $product['stock_deployed'] + $product['stock_junked'] }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</body>

</html>