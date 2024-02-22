<?php

require_once __DIR__ . "/../models/Product.php";

class ProductController
{
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nome'], $_POST['marca'], $_POST['prezzo'])) {
            $product = Product::Create($_POST);
            if ($product) {
                $data = [
                    'type' => get_class($product),
                    'id' => $product->getId(),
                    'attributes' => [
                        'marca' => $product->getMarca(),
                        'nome' => $product->getNome(),
                        'prezzo' => $product->getPrezzo()
                    ]
                ];

                $response = [
                    'data' => $data
                ];
                header('Location: /products/' . $product->getId());
                header('HTTP/1.1 200 OK');
                header('Content-Type: application/vnd.api+json');
                echo json_encode($response);
            } else {
                http_response_code(404);
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
                header('Location: /products');
                header('HTTP/1.1 201 CREATED');
                header('Content-Type: application/vnd.api+json');
                echo json_encode($response);
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(405);
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
                header('Location: /products/'.$id);
                header('HTTP/1.1 200 OK');
                header('Content-Type: application/vnd.api+json');
                echo json_encode($response);
            } else {
                http_response_code(404);
            }
        } else {
            http_response_code(405);
        }
        exit();
    }
}
