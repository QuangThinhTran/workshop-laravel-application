<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\IPostRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    private IPostRepository $postRepository;

    public function __construct(IPostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
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
     * @return JsonResponse
     * */
    public function filter(): JsonResponse
    {
        $posts = $this->postRepository->filter();

        return response()->json([
            'explain' => $this->explain($posts),
            'data' => $posts->get(),
        ]);
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
