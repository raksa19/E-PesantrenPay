<?php
    $responData = $admController->ambilPesan(31300190122);
    // echo "<pre>";
    // print_r($responData);
?>

<div class="row">
    <div class="col-3 bg-light">
        <input type="text" class="form-control form-control-sm mb-2 mt-1" placeholder="">
        <table class="table table-bordered">
            <tbody>
                <?php foreach ($responData['data'] as $dataMsg) : ?>
                <tr>
                    <td>
                        <a href="" style="text-decoration: none;">
                            <?= $dataMsg['user_to']; ?>
                        </a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    <div class="col">
        <div class="row bg-light">
            <div class="col">

            </div>
        </div>
    </div>
</div>