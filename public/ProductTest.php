<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../app/models/Product.php";

final class ProductTest extends TestCase
{
    /*public function testGetMethods()
    {
        $product = new Product(1, "nome", "marca", 1);

        $this->assertSame(1, $product->getId());
        $this->assertSame("nome", $product->getNome());
        $this->assertSame("marca", $product->getMarca());
        $this->assertSame(1, $product->getPrezzo());
    }

    public function testSetMethods()
    {
        $product = new Product(1, "nome", "marca", 1);

        $product->setId(2);
        $product->setNome("nome_modificato");
        $product->setMarca("marca_modificata");
        $product->setPrezzo(2);

        $this->assertSame(2, $product->getId());
        $this->assertSame("nome_modificato", $product->getNome());
        $this->assertSame("marca_modificata", $product->getMarca());
        $this->assertSame(2, $product->getPrezzo());
    }*/

    public function testCreateMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        $product = Product::Create($params);

        $this->assertSame($params["nome"], $product->getNome());
        $this->assertSame($params["marca"], $product->getMarca());
        $this->assertEquals($params["prezzo"], $product->getPrezzo());
    }

    public function testGetLastInsertMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        Product::Create($params);
        $product = Product::getLastInsert();

        $this->assertSame($params["nome"], $product->getNome());
        $this->assertSame($params["marca"], $product->getMarca());
        $this->assertEquals($params["prezzo"], $product->getPrezzo());
    }

    public function testFindByIdMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        $product = Product::Create($params);
        $product_found = Product::FindById($product->getId());

        $this->assertSame($params["nome"], $product_found->getNome());
        $this->assertSame($params["marca"], $product_found->getMarca());
        $this->assertEquals($params["prezzo"], $product_found->getPrezzo());
        $this->assertEquals($product->getId(), $product_found->getId());
    }

    public function testFetchAllMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        $product = Product::Create($params);
        $products_found = Product::FetchAll();

        $this->assertIsArray($products_found);
        $this->assertArrayHasKey(0, $products_found);
        $this->assertSame($params["nome"], end($products_found)->getNome());
        $this->assertSame($params["marca"], end($products_found)->getMarca());
        $this->assertEquals($params["prezzo"], end($products_found)->getPrezzo());
        $this->assertEquals($product->getId(), end($products_found)->getId());
    }

    public function testEditMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        $product = Product::Create($params);
        $params = ["nome" => "nome_modificato", "marca" => "marca_modificata", "prezzo" => 2];
        $edited_product = $product->edit($params);

        $this->assertSame($params["nome"], $edited_product->getNome());
        $this->assertSame($params["marca"], $edited_product->getMarca());
        $this->assertEquals($params["prezzo"], $edited_product->getPrezzo());
        $this->assertEquals($product->getId(), $edited_product->getId());
    }

    public function testDeleteMethod()
    {
        $params = ["nome" => "nome", "marca" => "marca", "prezzo" => 1];
        $product = Product::Create($params);
        $product->delete();
        $products_found = Product::FetchAll();

        $this->assertNotEquals($product->getId(), end($products_found)->getId());
    }
}