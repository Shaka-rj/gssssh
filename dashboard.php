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
?>
<html>
<?=head('FarmLink - Cabinet', '../')?>
<body>
    <div class="header">
        <div class="navbar">
            <div class="logo">FarmLink</div>
            <div class="links">
                <a href="cabinet.html">Logout</a>    
            </div>
        </div>
    </div>
    <div class="seller">
        <?=leftnavbar('dashboard')?>
        <div class="main">
            <h2>Balance</h2>
            
            <a href="#" class="add-product">Add product</a>
            
            <div class="dashboard">
                <div class="part">
                    <div class="name">
                        Oylik savdolar
                    </div>
                    <div class="value">
                        132
                    </div>
                </div>
                <div class="part">
                    <div class="name">
                        Maxsulotlar soni
                    </div>
                    <div class="value">
                        3
                    </div>
                </div>
                <div class="part">
                    <div class="name">
                        Tushumlar
                    </div>
                    <div class="tr-table">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amout</th>
                            <th>Order</th>
                        </tr>
                        <tr>
                            <td>21.09.2024 10:21</td>
                            <td>Buy</td>
                            <td>12 000</td>
                            <td><a href="#">123</a></td>
                        </tr>
                    </table>
                </div>
                </div>
            </div>
            
            <div class="products">
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
            </div>
            
            <hr>
            
            <div class="product">
                <div class="img">
                    <img src="img/watermelon.jpg">
                </div>
                <div class="info">
                vfibvfshbvfsbbfsbvfsibsfbbvfsibvisufbvsfiuv sfvfsbvfsibvsfvsufiv sufvfsv sfivsfvfsv fsuvbf fvbsfbv vbfsv sbv
                </div>
                <div class="address">
                <span class="material-symbols-outlined">location_on</span>Tashkent > Chilanzar
                </div>
            </div>
            
            <hr>
            
            add product
            
            <div class="add-form">
                <form>
                    
                    <input type="text" name="name" placeholder="Name">
                    <textarea name="info" placeholder="Info"></textarea>
                    <input type="number" name="amout" placeholder="Amout">
                    
                    Ulchov birligi
                    <select>
                        <option value="kg">Kg</option>
                        <option value="dona">Dona</option>
                    </select>
                    
                    <input type="number" name="total" placeholder="Jami">
                    <br>
                    <select id="region" name="region" onchange="updateDistricts()">
                        <option value="">--Viloyat tanlang--</option>
                        <option value="tashkent">Toshkent</option>
                        <option value="samarkand">Samarqand</option>
                        <option value="fergana">Farg'ona</option>
                      </select>
                    
                    <br><br>
                    <select id="district" name="district">
                        <option value="">--Tuman tanlang--</option>
                    </select>
                    
                    <br><br>
                    Image
                    <input type="file">
                    <input type="submit" name="submit" value="Save">
                </form>
            </div>
            
            
            <script>
  const districts = {
    tashkent: ["Chilonzor", "Mirzo Ulug'bek", "Yashnobod", "Bektemir"],
    samarkand: ["Payariq", "Urgut", "Jomboy", "Bulung'ur"],
    fergana: ["Qo'qon", "Marg'ilon", "Rishton", "Beshariq"]
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
            
            
            <div class="balance">
                <div class="balans">
                    Umumiy balans: <span>300 000 sum</span>
                    Erkin balans: <span>12 000 sum</span>
                    Garovdagi balans: <span>288 000 sum</span>
                </div>
                <a href="#" class="deposit">
                    Deposit
                </a>
                <a href="#" class="withdraw">
                    Withdraw
                </a>
            </div>
            
            <hr>
            
            <div class="transaction">
                <div class="tr-table">
                    <table>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Amout</th>
                            <th>Order</th>
                        </tr>
                        <tr>
                            <td>21.09.2024 10:21</td>
                            <td>Buy</td>
                            <td>12 000</td>
                            <td><a href="#">123</a></td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <hr>
            <div class="orders">
                
            </div>
            
            <div class="order">
                m soni
                narxi
                qiymati
            </div>
            
        </div>
    </div>
</body>