<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as &$item) {
            if ($item['product_id'] == $product_id) {
                if ($action === 'increase') {
                    $item['quantity'] += 1; 
                } elseif ($action === 'decrease') {
                    $item['quantity'] -= 1; 
                    if ($item['quantity'] <= 0) {
                        
                        $item = null;
                    }
                }
                break;
            }
        }
        
        $_SESSION['cart'] = array_filter($_SESSION['cart']);
    }
}

header('Location: cart.php');
exit;
?>
