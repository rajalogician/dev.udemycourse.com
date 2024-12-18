<?php


namespace App\Controller;

use App\Entity\BlogPost;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {}
    
    /**
     * @Route("/list/{page}", name="blog_list")
     */
    public function list(Request $request, $page = 1): Response
    {
        $limit = $request->get('limit', 10);

        /** @BlogPostReporisory $blogPostRep */
        $blogPostRep = $this->entityManager->getRepository(BlogPost::class);
        $posts = $blogPostRep->findAll();

        return $this->json([
            'page' => $page,
            'limit' => $limit,
            'data' => array_map(function (BlogPost $post) {
                return $this->generateUrl('blog_by_id', ['id' => $post->getId()]);
            }, $posts)
        ]);
    }

    /**
     * @Route("/post/{id}", name="blog_by_id")
     */
    public function post($id): Response
    {
        return $this->json(
            $this->entityManager->getRepository(BlogPost::class)->find($id)
        );
    }

    /**
     * @Route("/post/{slug}", name="blog_by_slug")
     */
    public function postBySlug($slug, EntityManagerInterface $entityManager): Response
    {
        return $this->json(
            $this->entityManager->getRepository(BlogPost::class)->findOneBy(['slug' => $slug])
        );
    }

    /**
     * @Route("/post/add", name="post_add")
     */
    public function add(Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $blogPost = new BlogPost();
        $blogPost->setTitle($data['title'])
            ->setAuthor($data['author'])
            ->setContent($data['content'])
            ->setPublished(new DateTime($data['published']))
            ->setSlug($data['slug']);

        // Persist the entity using the EntityManager
        $this->entityManager->persist($blogPost);
        $this->entityManager->flush();

        // Return a JSON response
        return $this->json($blogPost);
    }

    /**
     * @Route("/post/add/{id}", name="blog_delete")
     */
    public function delete($id): Response
    {
        $post = $this->entityManager->getRepository(BlogPost::class)->find($id);

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        // Return a JSON response
        return $this->json(null, response::HTTP_NO_CONTENT);
    }
}
