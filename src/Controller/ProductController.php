<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use OpenApi\Annotations as OA;

/**
 * Контроллер для работы с продуктами
 */
class ProductController extends AbstractController
{
    /**
     * Получение списка продуктов с учетом указанной страницы
     *
     * @OA\Get (
     *     path="/api/product",
     *     parameters={
     *       @OA\Parameter(
     *         in="query",
     *         name="page",
     *         description="Номер страницы",
     *         @OA\Schema(type="integer")
     *       ),
     *     },
     *     @OA\Response(
     *       response="200",
     *       description="Продукты",
     *       @OA\JsonContent(
     *         @OA\Property(property="success", type="boolean", description="Флаг успешности"),
     *         @OA\Property(property="data", type="array", description="Продукты",
     *           @OA\Items(type="object", description="Продукт",
     *             @OA\Property(property="id", type="integer", description="Идентификатор"),
     *             @OA\Property(property="product_id", type="integer", description="Идентификатор продукта"),
     *             @OA\Property(property="title", type="string", description="Заголовок"),
     *             @OA\Property(property="description", type="string", description="Описание"),
     *             @OA\Property(property="rating", type="string", description="Рейтинг"),
     *             @OA\Property(property="price", type="string", description="Цена"),
     *             @OA\Property(property="inet_price", type="string", description="До. цена"),
     *             @OA\Property(property="image", type="string", description="Изображение")
     *           )
     *         ),
     *       ),
     *     )
     * )
     * @OA\Tag(name="Main")
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return JsonResponse
     */
    public function index(Request $request, ManagerRegistry $doctrine): JsonResponse
    {
        $page = $request->query->getInt('page', 1);
        $limit = 10;
        $objectRepository = $doctrine->getRepository(Product::class);
        $result = $objectRepository->findBy([], ['id' => 'asc'], $limit, $page * $limit);
        $products = array_map(function($item) {
            return $item->toArray();
        }, $result);

        return $this->json([
            'success' => true,
            'data' => $products
        ]);
    }
}
