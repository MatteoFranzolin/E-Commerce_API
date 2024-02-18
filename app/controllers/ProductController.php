<?php

require_once __DIR__ . "/../models/Product.php";

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

    public function view()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $products = Product::FetchAll();
            if ($products) {
                $data = [];
                foreach ($products as $product) {
                    $data[] = [
                        'type' => get_class($product),
                        'id' => $product->getId(),
                        'attributes' => [
                            'marca' => $product->getMarca(),
                            'nome' => $product->getNome(),
                            'prezzo' => $product->getPrezzo()
                        ]
                    ];
                }

                $response = [
                    'data' => $data
                ];
                header('Content-Type: application/vnd.api+json');
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Errore nel recupero dei prodotti']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo non consentito']);
        }
        exit();
    }

    public function viewProduct($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $product = Product::FindById($id);
            if ($product) {
                $data = [
                    'type' => get_class($product),
                    'id' => $id,
                    'attributes' => [
                        'marca' => $product->getMarca(),
                        'nome' => $product->getNome(),
                        'prezzo' => $product->getPrezzo()
                    ]
                ];

                $response = [
                    'data' => $data
                ];
                header('Content-Type: application/vnd.api+json');
                echo json_encode($response);
            } else {
                http_response_code(500);
                echo json_encode(['error' => 'Errore nel recupero dei prodotti']);
            }
        } else {
            http_response_code(405);
            echo json_encode(['error' => 'Metodo non consentito']);
        }
        exit();
    }
}