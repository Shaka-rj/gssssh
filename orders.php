<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include '../src/components.php';
include '../src/conf.php';

$user_id = $_SESSION['user_id'];
if ($_SESSION['role'] != 'farmer'){
    exit;
}

if (isset($_GET['t'])){
    $type = $_GET['t'];
} else {
    $type = '';
}

$sql = "SELECT * FROM `f_orders` WHERE seller_id=$user_id ORDER BY id DESC";
$rec = $baza->query($sql);

$orders = [];
while($r = $rec->fetch_assoc()){
   $orders[] = $r; 
}

?>
<html>
<?=head('FarmLink - Cabinet', '../')?>
<body>
    <?=sellerheader()?>
    <div class="seller">
        <?=leftnavbar('orders')?>
        <div class="main">
            <h2>Balance</h2>

            <?php
            
            if ($type == 'acc'){
                $id = $_GET['id'];
                
                $sql = "SELECT SUM(amout) AS jami FROM `f_transaction` WHERE (type='deposit' OR type='withdraw') AND user_id=$user_id";
                $rec = $baza->query($sql);
                $seller_balance = $rec->fetch_assoc()['jami'];
                
                $sql = "SELECT * FROM `f_orders` WHERE id=$id";
                $order = $baza->query($sql)->fetch_assoc();
                $order_summ = $order['summ'];
                
                $customer_id = $order['customer_id'];
                
                $sql = "SELECT SUM(amout) AS jami FROM `f_transaction` WHERE (type='deposit' OR type='withdraw') AND user_id=$customer_id";
                $rec = $baza->query($sql);
                $customer_balance = $rec->fetch_assoc()['jami'];
                
                echo $seller_balance.', '.$order_summ.', '.$customer_balance;
                
                if ($customer_balance >= $order_summ and $seller_balance >= ($order_summ/100)*5){
                    $amout = -$order_summ;
                    $sql = "INSERT INTO f_transaction(user_id, amout, type, order_id) VALUES ($customer_id, $amout, 'buy', $id)";
                    $baza->query($sql);
                    
                    $amout = -intval(($order_summ/100)*5);
                    $sql = "INSERT INTO f_transaction(user_id, amout, type, order_id) VALUES ($user_id, $amout, 'frozen', $id)";
                    $baza->query($sql);
                    
                    $amout = -$amout;
                    $sql = "INSERT INTO `f_frozen`(order_id, amout) VALUES ($id, $amout)";
                    $baza->query($sql);
                    
                    $sql = "UPDATE `f_orders` SET status='inprogress' WHERE id=$id";
                    $baza->query($sql);
                    
                    header('Location: orders');
                } else {
                    echo 'Balanslar yetarli emas';
                }
            } elseif ($type == 'can'){
                $id = $_GET['id'];
                $sql = "UPDATE `f_orders` SET status='cancelled' WHERE id=$id";
                $baza->query($sql);
                
                header('Location: orders');
            }
            
            
            ?>
            <div class="orders">
                <div class="tr-table">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Amout</th>
                            <th>Order Id</th>
                            <td>Action</td>
                        </tr>
                        
                        <?php
                        
                        foreach ($orders as $v){
                            $id = $v['id'];
                            if ($v['status'] == 'progressing'){
                                $action = '<a href="?id='.$id.'&t=acc">Accept</a> | <a href="?id='.$id.'&t=can">Cancel</a>';
                            } else {
                                $action = '';
                            }
                            
                            echo '<tr>
                                <td>'.$v['date'].'</td>
                                <td>'.$v['status'].'</td>
                                <td>'.$v['summ'].'</td>
                                <td><a href="#">'.$id.'</a></td>
                                <td>'.$action.'</td>
                            </tr>';
                        }
                        
                        ?>
                    </table>
                </div>
            </div>
            
            <div class="order">
                m soni
                narxi
                qiymati
            </div>
            
        </div>
    </div>
</body>