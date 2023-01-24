<?php

namespace App\Service;

use App\Entity\Product as ProductEntity;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

/**
 * Сервис по отработке полученных данных продуктов и записи их в базу
 */
class Product
{
    /**
     * @var ObjectManager
     */
    private ObjectManager $em;

    /**
     * Констуктор
     *
     * @param ManagerRegistry $doctrine
     */
    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    /**
     * Получение продуктов и сохранение их в базу
     *
     * @param string $uri
     * @return void
     */
    public function get(string $uri): void
    {
        $result = Xml::get($uri);
        $products = $result['mvideo_xml']['products']['product'];
        foreach ($products as $product) {
            $row = $this->em->getRepository(ProductEntity::class)->findOneBy(['product_id' => $product['product_id']]);
            if ($row === null) {
                $row = new ProductEntity();
            }
            $row->setProductId($product['product_id']);
            $row->setTitle($product['title']);
            // Фикс, т.к. есть описание пустое и приходит массивом
            $row->setDescription(empty($product['description']) ? 'Без описания': $product['description']);
            $row->setRating($product['rating']);
            $row->setPrice($product['price']);
            $row->setInetPrice($product['inet_price']);
            $row->setImage($product['image'][0]);
            $row->setCreatedAt(new DateTimeImmutable());
            $row->setUpdatedAt(new DateTimeImmutable());
            $this->em->persist($row);
        }
        $this->em->flush();
    }
}