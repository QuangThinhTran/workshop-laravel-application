<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPostRepository;
use App\Services\IWebhookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private IPostRepository $postRepository;
    private IWebhookService $webhookService;

    public function __construct(
        IPostRepository $postRepository,
        IWebhookService $webhookService
    )
    {
        $this->postRepository = $postRepository;
        $this->webhookService = $webhookService;
    }

    /**
     * Get posts
     * @return JsonResponse
     * */
    public function index(): JsonResponse
    {
        $fields = ['title', 'content'];

        $conditions = [
            'type' => 'post',
            'begin' => 'day',
            'start' => 'day',
            'end' => 'day',
        ];

        $posts = $this->postRepository->getPostsByCondition($fields, $conditions);

        return response()->json([
            'explain' => $this->explain($posts),
            'data' => $posts->get(),
        ]);
    }

    /**
     * Filter posts
     * @param Request $request
     * @return JsonResponse
     * */
    public function filter(Request $request): JsonResponse
    {
        $posts = $this->postRepository->filter($request);

        return response()->json([
            'data' => $posts,
        ]);
    }

    /**
     * Fetch products
     * @return JsonResponse
     * */
    public function fetchProducts(): JsonResponse
    {
        $products = $this->webhookService->getProducts();

        return response()->json($products);
    }

    /**
     * Store a product
     * @return JsonResponse
     * */
    public function storeProduct(): JsonResponse
    {
        $product = $this->webhookService->createProduct([
            'title' => 'Product 1',
            'price' => 100,
            'inventory' => 10,
        ]);

        return response()->json($product);
    }

    /**
     * Explain query
     * @param $query
     * @return array
     * */
    private function explain($query): array
    {
        $sql = $query->toSql();
        $bindings = $query->getBindings();
        $explain = DB::select("EXPLAIN ANALYZE $sql", $bindings);
        $explain1 = DB::select("EXPLAIN $sql", $bindings);
        return [
            'explain' => $explain[0]->EXPLAIN,
            'explain1' => $explain1[0],
        ];
    }
}
