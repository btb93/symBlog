<?php
namespace App;

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Form\CommentaireType;
use App\Entity\Commentaire;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Security;




class BlogController extends AbstractController
{

    private $manager;
    private $repository;

    public function __construct(ObjectManager $manager, ArticleRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }

    /**
     * @Route("/index", name="index")
     *
     * @param ArticleRepository $repository
     * @return void
     */
    public function index(ArticleRepository $repository)
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->render('blog/admin.html.twig');
        }

        return $this->render('blog/home.html.twig', [
            'controller_name' => 'BlogController',
        ]);
    }

    /**
     * @Route("/blog/{slug}-{id}", name="blog_show", requirements={"slug"= "[a-z0-9\-|@;]*"} )
     *
     * @param Article $article
     * @param Request $request
     * @param ObjectManager $manager
     * @param String $slug
     * @return void
     */
    public function show(Article $article, String $slug, Request $request, ObjectManager $manager)
    {
        if ($article->getSlug() !== $slug) {
            return $this->redirectToRoute('blog_show', [
                'id' => $article->getId(),
                'slug' => $article->getSlug()
            ], 301);
        }
        $commentaire = new Commentaire();
        $form = $this->createForm(CommentaireType::class, $commentaire);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $this->getUser();
            if ($username) {
                $commentaire->setCreatedAt(new \DateTime())
                    ->setArticle($article)
                    ->setAuteur($username);
                $manager->persist($commentaire);
                $manager->flush();
                return $this->redirectToRoute('blog_show', [
                    'id' => $article->getId(),
                    'slug' => $article->getSlug()
                ]);
            }
        }

        return $this->render('blog/show.html.twig', [
            'article' => $article,
            // 'slug' => $article->getSlug(),
            'current_menu' => 'blog',
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/blog", name="blog")
     *
     * @param ArticleRepository $repository
     * @param Request $request
     * @param PaginatorInterface $paginator
     * @return void
     */
    public function blog(ArticleRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $articles = $repository->findAll();
        $pagination = $paginator->paginate($articles, $request->query->getInt('page', 1), 5);
        return $this->render('blog/blog.html.twig', [
            'article' => $pagination,
            'current_menu' => 'blog'
        ]);

    }

    /**
     * @Route("/", name="home")
     *
     * @return void
     */
    public function home()
    {
        return $this->render('blog/home.html.twig', [
            'current_menu' => 'accueil',

        ]);
    }

    /**
     * @Route("/login", name="fos_user_security_login")
     *
     * @return void
     */
    public function Connect()
    {
        return $this->render('
        Bundles/FOSUserBundle/Security/login_content.html.twig', [
            'login' => 'connect',

        ]);
    }

}
