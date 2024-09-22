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
    $sql = "SELECT * FROM `f_products` WHERE user_id=$user_id";
    $rec = $baza->query($sql);
    
    $products = [];
    while($r = $rec->fetch_assoc()){
        $products[] = $r;
    }
}

if (is_numeric($type)){
    $sql = "SELECT * FROM `f_products` WHERE id=$type";
    $rec = $baza->query($sql);
    $r = $rec->fetch_assoc();
}



if (isset($_POST['submit'])){
    $name = $baza->real_escape_string($_POST['name']);
    $info = $baza->real_escape_string($_POST['info']);
    $price = intval($_POST['price']);
    $measure = $_POST['measure'];
    $total = $_POST['total'];
    $region = $baza->real_escape_string($_POST['region']);
    $district = $baza->real_escape_string($_POST['district']);
    
    //image
    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

// Faylning haqiqatan ham rasm ekanligini tekshirish

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $uploadOk = 0;
        }
    


    if ($_FILES["image"]["size"] > 1000000){
        $uploadOk = 0;
    }

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        //error
    } else {
        $img_name = uniqid().'.'.$imageFileType;
        if (move_uploaded_file($_FILES["image"]["tmp_name"], '../img/'.$img_name)) {
            echo "Fayl " . htmlspecialchars(basename($_FILES["image"]["name"])) . " muvaffaqiyatli yuklandi.";
        }
    }

    
    $sql = "INSERT INTO f_products(user_id, name, info, price, birligi, region, district, image, status)
    VALUES
    ($user_id, '$name', '$info', $price, '$measure', '$region', '$district', '$img_name', 'active')";
    
    $baza->query($sql);
    header('Location: products');
}


?>
<html>
<?=head('Products', '../')?>
<body>
    <?=sellerheader()?>
    <div class="seller">
        <?=leftnavbar('products')?>
        <div class="main">
            <?php

            if ($type == ''){
            
            ?>
            <h2>Products</h2>
            <br>
            <a href="?t=add" class="add-product">Add product</a>
            
            <div class="products">
                <?php
                foreach ($products as $v){
                    echo '<div class="card">
                        <div class="img">
                            <img src="../img/'.$v['image'].'">
                        </div>
                        <div class="name">
                        '.$v['name'].'
                        </div>
                        <div class="status">
                        Price: '.$v['price'].'<br>
                        Status: '.$v['status'].'<br>
                        </div>
                        <div class="edit">
                            <a href="#"><span class="material-symbols-outlined">edit</span></a>
                            <a href="?t='.$v['id'].'"><span class="material-symbols-outlined">visibility</span></a>
                        </div>
                    </div>';
                }
                ?>
                
                <!--
                <div class="card">
                    <div class="img">
                        <img src="../img/watermelon.jpg">
                    </div>
                    <div class="name">
                    Tarvuz arzoni
                    </div>
                    <div class="status">
                    Status: active<br>
                    Qoldiq: 10
                    </div>
                    <div class="edit">
                        
                    <a href="#"><span class="material-symbols-outlined">edit</span></a>
                    <a href="#"><span class="material-symbols-outlined">visibility</span></a>
                    </div>
                </div>
                -->
            </div>
            
            <?php
            } elseif ($type == 'add'){
            ?>
            <h2>Add product</h2>
            <div class="add-form">
                <form method="post" enctype="multipart/form-data">
                    <input type="text" name="name" placeholder="Name" required>
                    <textarea name="info" placeholder="Info" required></textarea>
                    <input type="number" name="price" placeholder="Price" required>
                    
                    Unit of measure
                    <select name="measure">
                        <option value="kg">Kg</option>
                        <option value="piece">Piece</option>
                    </select>
                    
                    <input type="number" name="total" placeholder="Total" required>
                    <br>
                    <select id="region" name="region" onchange="updateDistricts()">
                        <option value="">--Select Region--</option>
                        <option value="tashkent">tashkent</option>
                        <option value="samarkand">samarkand</option>
                        <option value="fergana">fergana</option>
                        <option value="andijan">andijan</option>
                        <option value="bukhara">bukhara</option>
                        <option value="jizzakh">jizzakh</option>
                        <option value="kashkadarya">kashkadarya</option>
                        <option value="navoi">navoi</option>
                        <option value="namangan">namangan</option>
                        <option value="qashqadaryo">qashqadaryo</option>
                        <option value="surkhandarya">surkhandarya</option>
                        <option value="sirdarya">sirdarya</option>
                        <option value="tashkent_region">tashkent_region</option>
                        <option value="khorezm">khorezm</option>
                        <option value="karakalpakstan">karakalpakstan</option>
                    </select>
                    
                    <br><br>
                    <select id="district" name="district">
                        <option value="">--Select District--</option>
                    </select>
                    
                    <br><br>
                    Image
                    <input type="file" name="image" required accept="image/*">
                    <input type="submit" name="submit" value="Save">
                </form>
            </div>
            
            <script>
  const districts = {
  tashkent: ["Chilonzor", "Mirzo Ulug'bek", "Yashnobod", "Bektemir", "Sergeli", "Uchtepa", "Shayxontohur", "Yakkasaroy", "Yunusobod", "Olmazor", "Mirobod"],
  samarkand: ["Payariq", "Urgut", "Jomboy", "Bulung'ur", "Ishtixon", "Kattaqo'rg'on", "Narpay", "Nurobod", "Oqdaryo", "Paxtachi", "Pastdarg'om", "Samarqand", "Toyloq"],
  fergana: ["Qo'qon", "Marg'ilon", "Rishton", "Beshariq", "Oltiariq", "Bag'dod", "Buvayda", "Dang'ara", "Farg'ona", "Furqat", "Qo'shtepa", "Toshloq", "Uchko'prik", "Yozyovon"],
  andijan: ["Andijon", "Asaka", "Baliqchi", "Buloqboshi", "Izboskan", "Jalaquduq", "Marhamat", "Oltinko'l", "Paxtaobod", "Qo'rg'ontepa", "Shahrixon", "Ulug'nor", "Xo'jaobod"],
  bukhara: ["Buxoro", "G'ijduvon", "Kogon", "Jondor", "Olot", "Peshku", "Qorako'l", "Qorovulbozor", "Romitan", "Shofirkon", "Vobkent"],
  jizzakh: ["Jizzax", "Arnasoy", "Baxmal", "Do'stlik", "Forish", "G'allaorol", "Sharof Rashidov", "Mirzacho'l", "Paxtakor", "Yangiobod", "Zomin", "Zafarobod", "Zarbdor"],
  kashkadarya: ["Qarshi", "Dehqonobod", "G'uzor", "Kasbi", "Kitob", "Koson", "Mirishkor", "Muborak", "Nishon", "Chiroqchi", "Shahrisabz", "Yakkabog'"],
  navoi: ["Navoiy", "Konimex", "Karmana", "Qiziltepa", "Xatirchi", "Navbahor", "Nurota", "Tomdi", "Uchquduq"],
  namangan: ["Namangan", "Chortoq", "Chust", "Kosonsoy", "Mingbuloq", "Norin", "Pop", "To'raqo'rg'on", "Uchqo'rg'on", "Uychi", "Yangiqo'rg'on"],
  qashqadaryo: ["Qarshi", "Shahrisabz", "Dehqonobod", "G'uzor", "Koson", "Kasbi", "Kitob", "Muborak", "Mirishkor", "Nishon", "Chiroqchi", "Yakkabog'"],
  surkhandarya: ["Termiz", "Angor", "Bandixon", "Boysun", "Denov", "Jarqo'rg'on", "Muzrabot", "Oltinsoy", "Qiziriq", "Qumqo'rg'on", "Sariosiyo", "Sherobod", "Sho'rchi"],
  sirdarya: ["Guliston", "Baxt", "Boyovut", "Hovos", "Mirzaobod", "Sayxunobod", "Sardoba", "Shirin", "Sirdaryo", "Xovos", "Yangier"],
  tashkent_region: ["Toshkent", "Chirchiq", "Angren", "Bekobod", "Ohangaron", "Yangiyo'l", "Parkent", "Piskent", "Oqqo'rg'on", "Qibray", "Toshkent"],
  khorezm: ["Urganch", "Bog'ot", "Gurlan", "Xonqa", "Xiva", "Hazorasp", "Qo'shko'pir", "Shovot", "Yangiariq", "Yangibozor"],
  karakalpakstan: ["Nukus", "Amudaryo", "Beruniy", "Chimboy", "Ellikqal'a", "Kegeyli", "Mo'ynoq", "Qo'ng'irot", "Qorao'zak", "Shumanay", "Taxtako'pir", "To'rtko'l", "Xo'jayli"]
};

              function updateDistricts() {
                const regionSelect = document.getElementById("region");
                const districtSelect = document.getElementById("district");
                const selectedRegion = regionSelect.value;
            
                // Tumanni o'chirib tashlash
                districtSelect.innerHTML = '<option value="">--Tuman tanlang--</option>';
            
                if (selectedRegion && districts[selectedRegion]) {
                  // Tanlangan viloyatga mos tumanlarni qo'shish
                  districts[selectedRegion].forEach(function(district) {
                    const option = document.createElement("option");
                    option.value = district.toLowerCase();
                    option.textContent = district;
                    districtSelect.appendChild(option);
                  });
                }
              }
            </script>
            
            <?php
            
            } else {
                
            ?>
            
            <h2><?=$r['name']?></h2>
            <div class="product">
                <div class="img" style="display:block">
                    <img src="../img/<?=$r['image']?>">
                </div><hr>
                <div class="info">
                    <?=$r['info']?>
                </div>
                <div>
                    Price: <?=$r['price']?><br>
                    Measure: <?=$r['birligi']?><br>
                    Status: <?=$r['status']?><br>
                </div>
                <div class="address">
                <span class="material-symbols-outlined">location_on</span><?=$r['region'].' > '.$r['district']?>
                </div>
            </div>
            
            <?php
            
            }
            
            ?>
        </div>
    </div>
</body>