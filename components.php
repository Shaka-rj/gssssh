<?php


function head($title, $position){ //html head elements
    $html = '<head>
        <title>'.$title.'</title>
        <link rel="stylesheet" href="'.$position.'src/style.css">
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
        
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    </head>';

    return $html;
}

function leftnavbar($active){
    $dashboard = $products = $orders = $balance = $transaction = '';
    
    switch ($active) {
        case 'dashboard':
            $dashboard = 'class="active"';
            break;
        case 'products':
            $products = 'class="active"';
            break;
        case 'orders':
            $orders = 'class="active"';
            break;
        case 'balance':
            $balance = 'class="active"';
            break;
        case 'transaction':
            $transaction = 'class="active"';
            break;
    }
    
    $html = '<div class="left-navbar">
            <div class="links">
                <a href="dashboard" '.$dashboard.'><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                <a href="products" '.$products.'><span class="material-symbols-outlined">apps</span>Products</a>
                <a href="orders" '.$orders.'><span class="material-symbols-outlined">description</span>Orders</a>
                <a href="balance" '.$balance.'><span class="material-symbols-outlined">account_balance_wallet</span>Balance</a>
                <a href="transaction" '.$transaction.'><span class="material-symbols-outlined">assignment</span>Transaction</a>
            </div>
        </div>';
        
    return $html;
}

function leftnavbarc($active){
    $profile = $products = $orders = $balance = $transaction = '';
    
    switch ($active) {
        case 'profile':
            $profile = 'class="active"';
            break;
        case 'products':
            $products = 'class="active"';
            break;
        case 'orders':
            $orders = 'class="active"';
            break;
        case 'balance':
            $balance = 'class="active"';
            break;
        case 'transaction':
            $transaction = 'class="active"';
            break;
    }
    
    $html = '<div class="left-navbar">
            <div class="links">
                <a href="profile" '.$profile.'><span class="material-symbols-outlined">person</span>Profile</a>
                <a href="orders" '.$orders.'><span class="material-symbols-outlined">description</span>Orders</a>
                <a href="balance" '.$balance.'><span class="material-symbols-outlined">account_balance_wallet</span>Balance</a>
                <a href="transaction" '.$transaction.'><span class="material-symbols-outlined">assignment</span>Transaction</a>
                <a href="products"><span class="material-symbols-outlined">apps</span>Products</a>
            </div>
        </div>';
        
    return $html;
}


function sellerheader(){
    $html = '<div class="header">
        <div class="navbar">
            <div class="logo">FarmLink</div>
            <div class="links">
                <a href="logout">Logout</a>    
            </div>
        </div>
    </div>';
    
    return $html;
}