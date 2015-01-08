<?php
require_once 'classes/FwsApi.php';
$api = new FwsApi();
$unread = $api->getNewOrderCount();
$orders = $api->getNewOrders();

function getStatus($status) {
    $value = '';

    switch ($status) {
        case 0:
            $value = 'Not paid';
            break;
        case 1:
            $value = 'Paid';
            break;
        case 2:
            $value = 'Closed';
            break;
        default:
            $value = 'Error';
            break;
    }

    return $value;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>thealchemistscupboard.co.uk</title>
<style>
    body {
        font-family:Verdana, Geneva, sans-serif;
        font-size: 14px;
    }
    table {
        border:1px solid #000;
        border-collapse:collapse
    }
    th, td {
       border:1px solid #000;
       padding: 5px;
    }
    form {
        margin-bottom: 10px;
    }
</style>
</head>

<body>
    <h1>Unread Orders <?php echo $unread ?></h1>
    <form method="post" action="dispatch.php" target="_blank">
        <input type="hidden" name="toDispatch" value='<?php echo json_encode($orders) ?>'>
        <button>Print Dispatch Notes</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
                <th>Payment Method</th>
                <th>Dispatched</th>
                <th>shopkeeper_orderno</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($orders as $row): ?>
            <tr>
                <td><?php echo $row->id ?></td>
                <td><?php echo $row->customer ?></td>
                <td><?php echo $row->creationdate ?></td>
                <td><?php echo $row->total ?></td>
                <td><?php echo getStatus($row->status) ?></td>
                <td><?php echo $row->paymentmethod ?></td>
                <td><?php if ($row->dispatched != '0'): ?>Yes<?php else: ?>No<?php endif; ?></td>
                <td><?php echo $row->shopkeeper_orderno ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
