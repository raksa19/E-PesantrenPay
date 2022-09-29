<?php

$id_tagihan = $_POST['tandaiid'];

$total = 0;
$name = explode(" ", $data['nama']);
$order_id = 0;

if (!$_POST['tandaiid']) {
    echo "<script>alert('harus diceklis salah satu!');location.replace('index.php?page=tagihan');</script>";
} else {

    $item_details = array();
    for ($i = 0; $i < count($id_tagihan); $i++) {
        $id = $id_tagihan[$i];
        $qs_tr = $conn->query("select * from tagihan where id_tagihan='$id'");
        while ($rows = $qs_tr->fetch_assoc()) {
            $item_details[$i] = array(
                'id' => $rows['id_tagihan'],
                'price' => intval($rows['nominal']),
                'quantity' => 1,
                'name' => $rows['nm_tagihan']
            );
            $total += intval($rows['nominal']);
            $order_id += intval($rows['id_tagihan']);
        }
    }

    // Required
    $transaction_details = array(
        'order_id' => $order_id,
        'gross_amount' => $total, // no decimal allowed for creditcard
    );
    // Optional
    $customer_details = array(
        'first_name'    => $name[0],
        'last_name'     => $name[1],
        'email'         => $data['email'] . ".com",
        'phone'         => "0" . $data['no_hp'],
        // 'billing_address'  => $billing_address,
        // 'shipping_address' => $shipping_address
    );
    // Optional, remove this to display all available payment methods
    $enable_payments = array('credit_card', 'gopay', 'shopeepay', 'bank_transfer');

    // Fill transaction details
    $transaction = array(
        'enabled_payments' => $enable_payments,
        'transaction_details' => $transaction_details,
        'customer_details' => $customer_details,
        'item_details' => $item_details,
    );
    // $snapToken = "4eff1721-5a5f-4e60-bb8e-e67117bf4cf4";
    $snapToken = Veritrans_Snap::getSnapToken($transaction);
}
?>

<div class="row mt-5 justify-content-center">
    <div class="col-sm-auto">
        <div class="card">
            <div class="card-header"></div>
            <div class="card-body">
                <table class="table table-responsive">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Tagihan</th>
                            <th>Nama Tagihan</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        for ($i = 0; $i < count($item_details); $i++) { ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $item_details[$i]['id'] ?></td>
                            <td><?= $item_details[$i]['name'] ?></td>
                            <td><?= strval($item_details[$i]['price']) ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="3">Total yang harus dibayar</td>
                            <td><?= $total; ?></td>
                        </tr>
                        <tr>
                            <td colspan="5"><button type="button" id="btn-debit"
                                    class="btn btn-warning float-right">Bayar</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
var id_tagihan = <?= json_encode($id_tagihan); ?>;

// document.getElementById('btn-cash').onclick = function() {
//     console.log(<?= json_encode($item_details) ?>);
//     $.ajax({
//         url: 'tagihan_cash.php',
//         type: 'POST',
//         dataType: 'JSON',
//         data: {
//             nis: <?= $data['nis']; ?>,
//             item_details: <?= json_encode($item_details) ?>,
//             id_tag: id_tagihan[0]
//         },
//         success: function(data) {
//             if (data.status) {
//                 $("#modalBtnPembayaran").modal('hide');
//                 window.location.replace("index.php?page=tagihan");
//                 $("#alert").addClass('show');
//                 $("#alert").html(data.pesan);
//             }
//         }
//     });
// }

document.getElementById('btn-debit').onclick = function() {
    $("#modalBtnPembayaran").modal('hide');
    snap.pay('<?= $snapToken; ?>', {
        // Optional
        onSuccess: function(result) {
            console.log(result);
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);

        },
        // Optional
        onPending: function(result) {
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            $.ajax({
                url: 'update.php',
                type: 'POST',
                dataType: 'JSON',
                data: {
                    nis: <?= $data['nis']; ?>,
                    token: '<?= $snapToken; ?>',
                    result: result,
                    id_tag: id_tagihan
                },
                success: function(data) {
                    if (data.status) {
                        window.location.replace("index.php?page=tagihan");
                        $("#alert").addClass('show');
                        $("#alert").html(data.pesan);
                    }
                }
            });
            console.log(result);
        },
        // Optional
        onError: function(result) {
            /* You may add your own js here, this is just example */
            // document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
            console.log(result);
        }
    });
};
</script>