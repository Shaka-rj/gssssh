<?php
session_start();
include 'src/components.php';
include 'src/conf.php';

$error = '';
if (isset($_GET['t'])){
    $type = $_GET['t'];
} else {
    $type = '';
}

if (isset($_POST['submit'])){
    if ($type == 'signup'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        $lastname = $baza->real_escape_string($_POST['lastname']);
        $fullname = $baza->real_escape_string($_POST['fullname']);
        $address = $baza->real_escape_string($_POST['address']);
        $phone = $baza->real_escape_string($_POST['phone']);
        $role = $_POST['role'];
        
        $sql = "SELECT * FROM f_users WHERE email='$email'";
        $rec = $baza->query($sql);
        
        if ($rec->num_rows > 0){
            $error = "Such an email exists";
        } else {
            $sql = "INSERT INTO f_users(email, password, address, phone, role, last_name, full_name)
            VALUES
            ('$email', '$password', '$address', '$phone', '$role', '$lastname', '$fullname')";
            
            $baza->query($sql);
            
            $user_id = $baza->insert_id;
            
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
        }
    } elseif ($type == 'signin' or $type == ''){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM f_users WHERE email='$email'";
        $rec = $baza->query($sql);
        $data = $rec->fetch_assoc();
        
        if ($data['password'] == $password){
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $data['role'];
            
            if ($data['role'] == 'farmer'){
                header('Location: seller/dashboard');
            } elseif ($data['role'] == 'customer'){
                header('Location: customer/products');
            }
        } else {
            $error = "Email or password is incorrect";
        }
    } elseif ($type == 'recovery'){
        $email = $_POST['email'];
        $password = $_POST['password'];
        
        $sql = "SELECT * FROM f_users WHERE email='$email'";
        $rec = $baza->query($sql);
        if ($rec->num_rows > 0){
            $error = "Such an email exists";
        } else {
            $sql = "UPDATE f_users SET password='$password', WHERE email='$email'";
            $baza->query($sql);
        }
    }
}
?>
<html>
<?=head('FarmLink', './')?>
<body>
    
    <?php
    
    if ($type == 'signup'){
        
    ?>
    <div class="login">
        <h2>Sign Up</h2>
        <form autocomplete="off" method="post">
            <span class="error"><?=$error?></span>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="text" name="address" placeholder="Adress" required>
            <input type="text" name="phone" placeholder="Phone" required>
            Role
            <select name="role">
                <option value="farmer">Farmer</option>
                <option value="customer">Customer</option>
            </select>
            <input type="submit" name="submit" value="Sign Up">
        </form>
        <div class="links">
            <a href="?t=signin">Sign In</a>
            <a href="?t=recovery">Forgot password</a>
        </div>
    </div>
    <?php
        
    } elseif ($type == 'signin' or $type == ''){
    
    ?>
    
    <div class="login">
        <h2>Sign In</h2>
        <form autocomplete="off" method="post">
            <span class="error"><?=$error?></span>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <input type="submit" name="submit" value="Sign In">
        </form>
        <div class="links">
            <a href="?t=signup">Sign Up</a>
            <a href="?t=recovery">Forgot password</a>
        </div>
    </div>
    
    <?php
    
    } elseif ($type == 'recovery'){
    
    ?>
    
    <div class="login">
        <h2>Recovery password</h2>
        <form autocomplete="off" method="post">
            <span class="error"><?=$error?></span>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="New password" required>

            <input type="submit" name="submit" value="Recovery">
        </form>
        <div class="links">
            <a href="?t=signup">Sign Up</a>
            <a href="?t=signin">Sign In</a>
        </div>
    </div>
    
    <?php
    
    }
    
    ?>
</body>