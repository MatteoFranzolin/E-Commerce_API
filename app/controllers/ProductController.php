<?php

class ProductController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['descrizione'], $_POST['prezzo'])) {
            $product = Product::Create($_POST);
            if ($product) {
                header('Location: products.php?success=1');
            } else {
                header('Location: products.php?error=1');
            }
        } else {
            header('Location: add_product.php');
        }
        exit();
    }
}