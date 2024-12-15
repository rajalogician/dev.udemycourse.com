<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    private const POSTS = [
        [
            'id' => 1,
            'slug' => 'hello-world',
            'title' => 'Hello World'
        ],
        [
            'id' => 2,
            'slug' => 'another-world',
            'title' => 'Another World'
        ],
        [
            'id' => 3,
            'slug' => 'last-example',
            'title' => 'Last Example'
        ]
    ];
    /**
     * @Route("/{page}", name="blog_list", defaults={"page": 5})
     */
    public function list($page = 1, Request $request): Response
    {
        $limit = $request->get('limit', 10);
        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function ($item) {
                return $this->generateUrl('blog_by_slug', ['slug' => $item['slug']]);
            }, self::POSTS)
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id", requirements={"id"="\d+"})
     */
    public function post($id): Response
    {
        return $this->json(
            self::POSTS[array_search($id, array_column(self::POSTS, 'id'))]
        );
    }
    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug): Response
    {
        return $this->json(
            self::POSTS[array_search($slug, array_column(self::POSTS, 'slug'))]
        );
    }
}