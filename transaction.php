<?php
session_start();
include '../src/components.php';
include '../src/conf.php';

$user_id = $_SESSION['user_id'];
if ($_SESSION['role'] != 'farmer'){
    exit;
}

$sql = "SELECT * FROM f_transaction WHERE user_id=$user_id ORDER BY id DESC";
$rec = $baza->query($sql);

$tr = [];
while($r = $rec->fetch_assoc()){
    $tr[] = $r;
}
?>
<html>
<?=head('FarmLink - Cabinet', '../')?>
<body>
    <?=sellerheader()?>
    <div class="seller">
        <?=leftnavbar('transaction')?>
        <div class="main">
            <h2>Transactions</h2>
            <div class="transaction">
                <div class="tr-table">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amout</th>
                            <th>Order</th>
                        </tr>
                        
                        <?php
                        foreach ($tr as $v){
                            if ($v['order_id'] > 0){
                                $order = $v['order_id'];
                            } else {
                                $order = '-';
                            }
                            
                            echo '<tr>
                            <td>'.$v['date'].'</td>
                            <td>'.$v['type'].'</td>
                            <td>'.$v['amout'].'</td>
                            <td><a href="#">'.$order.'</a></td>
                        </tr>';
                        }
                        ?>
                        
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>