<?php

namespace App\Tests\Feature;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Тестирование получение продуктов
 */
class ProductTest extends WebTestCase
{
    /**
     * Проверка запроса продуктов
     */
    public function testGetProducts(): void
    {
        $client = static::createClient([], [
            'HTTP_HOST'       => $_ENV['APP_HOST']
        ]);
        $client->request('GET', '/api/product');

        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);

        $element = current($data['data']);
        $this->assertArrayHasKey('id', $element);
        $this->assertArrayHasKey('product_id', $element);
        $this->assertArrayHasKey('title', $element);
        $this->assertArrayHasKey('description', $element);
        $this->assertArrayHasKey('rating', $element);
        $this->assertArrayHasKey('price', $element);
        $this->assertArrayHasKey('inet_price', $element);
        $this->assertArrayHasKey('image', $element);
    }

    /**
     * Проверка запроса продуктов с указаним страницы
     */
    public function testGetPageProducts(): void
    {
        $client = static::createClient([], [
            'HTTP_HOST'       => $_ENV['APP_HOST']
        ]);
        $client->request('GET', '/api/product?page=2');

        $this->assertResponseIsSuccessful();

        $response = $client->getResponse();
        $this->assertJson($response->getContent());
        $data = json_decode($response->getContent(), true);

        $element = current($data['data']);
        $this->assertArrayHasKey('id', $element);
        $this->assertArrayHasKey('product_id', $element);
        $this->assertArrayHasKey('title', $element);
        $this->assertArrayHasKey('description', $element);
        $this->assertArrayHasKey('rating', $element);
        $this->assertArrayHasKey('price', $element);
        $this->assertArrayHasKey('inet_price', $element);
        $this->assertArrayHasKey('image', $element);
    }
}
