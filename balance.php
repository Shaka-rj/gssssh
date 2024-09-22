<?php
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
    
    $sql = "SELECT SUM(amout) AS jami FROM `f_transaction` WHERE user_id=$user_id";
    $rec = $baza->query($sql);
    $jami = $rec->fetch_assoc()['jami'];
    
    $sql = "SELECT SUM(amout) AS jami FROM `f_transaction` WHERE (type='frozen') AND user_id=$user_id";
    $rec = $baza->query($sql);
    $frozen = $rec->fetch_assoc()['jami'];
}

if (isset($_POST['deposit'])){
    //add transaction
    $amout = $_POST['amout'];
    
    if ($amout < 100000000){
        $sql = "INSERT INTO f_transaction(user_id, amout, type) VALUES ($user_id, $amout, 'deposit')";
        $baza->query($sql);
        
        header('Location: balance');
    }
} elseif (isset($_POST['withdraw'])){
    $amout = $_POST['amout'];
    
    $sql = "SELECT SUM(amout) AS jami FROM `f_transaction` WHERE user_id=$user_id";
    $rec = $baza->query($sql);
    $jami = $rec->fetch_assoc()['jami'];
    
    if ($jami >= $amout){
        $amout = -$amout;
        $sql = "INSERT INTO f_transaction(user_id, amout, type) VALUES ($user_id, $amout, 'withdraw')";
        $baza->query($sql);
    }
    
    header('Location: balance');
}

?>
<html>
<?=head('FarmLink - Cabinet', '../')?>
<body>
    <?=sellerheader()?>
    <div class="seller">
        <?=leftnavbar('balance')?>
        <div class="main">
            <?php
            if ($type == ''){
                
                ?>
                
                <h2>Balance</h2>
            
                <div class="balance">
                    <div class="balans">
                        Total balance: <span><?=$jami-$frozen?></span>
                        Free balance: <span><?=$jami?> sum</span>
                        Frozen balance: <span><?=$frozen?> sum</span>
                    </div>
                    <a href="?t=add" class="deposit">
                        Deposit
                    </a>
                    <a href="?t=up" class="withdraw">
                        Withdraw
                    </a>
                </div>
                
                <?php
                
            } elseif ($type == 'add'){
                
                ?>
                
                <div class="balance">
                    <h2>Deposit</h2>
                    <br><br>
                    <form method="post"> 
                        <input type="number" name="amout" placeholder="Amout">
                        <input type="submit" name="deposit" value="Deposit">
                    </form>
                </div>
                
                <?php
                
            } elseif ($type == 'up'){
                
                ?>
                
                <div class="balance">
                    <h2>Withdraw</h2>
                    <br>
                    <form method="post"> 
                        <input type="number" name="amout" placeholder="Amout">
                        <input type="submit" name="withdraw" value="Withdraw">
                    </form>
                </div>
                
                <?php
                
            }
            ?>
            
        </div>
    </div>
</body>