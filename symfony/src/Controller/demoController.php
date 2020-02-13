<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Type\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;


/**
 * Class demoController
 * @package App\Controller
 */
class demoController
{


    private $twig;
    private $formFactory;
    private $entityManager;
    private $router;
    private $postRepository;
    private $flashBag;

    /**
     * demoController constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(PostRepository $postRepository,
                                \Twig_Environment $twig,
                                FormFactoryInterface $formFactory,
                                EntityManagerInterface $entityManager,
                                RouterInterface $router,
                                FlashBagInterface $flashBag)
    {
        $this->twig = $twig;
        $this->formFactory = $formFactory;
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->postRepository = $postRepository;
        $this->flashBag = $flashBag;
    }

   /**
    * @Route("/posts", name="posts_index")
   */
   public function index()
    {
        $html = $this->twig->render('blog/demo_index.html.twig', ['posts' => $this->postRepository->findBy([],['time' => 'DESC'])]);

        return new Response($html);
    }

    /**
     * @Route("/posts/edit/{id}", name="posts_edit")
     */
    public function edit(Post $post, Request $request)
    {
        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->flush();
            $this->flashBag->add('notice', 'Post modifié');

            return new RedirectResponse($this->router->generate('posts_index'));
        }


        $html = $this->twig->render('blog/demo_add.html.twig', ['form' => $form->createView()]);

        return new Response($html);

    }

    /**
     * @Route("/posts/add", name="posts_add")
     */
    public function add(Request $request)
    {
        $post = new Post();
        $post->setTime(new \DateTime('now'));

        $form = $this->formFactory->create(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($post);
            $this->entityManager->flush();
            $this->flashBag->add('notice', 'Post ajouté');

            return new RedirectResponse($this->router->generate('posts_index'));
        }

        $html = $this->twig->render('blog/demo_add.html.twig', ['form' => $form->createView()]);

        return new Response($html);
    }

    /**
     * @Route("/posts/{id}", name="posts_view")
     */
    public function view(Post $post)
    {
        $html = $this->twig->render('blog/demo_post.html.twig', ['post' => $post]);

        return new Response($html);

    }

    /**
     * @Route("/delete/{id}", name="posts_delete")
     */
    public function delete(Post $post)
    {
        $this->entityManager->remove($post);
        $this->entityManager->flush();
        $this->flashBag->add('notice', 'Post supprimé');

        return new RedirectResponse($this->router->generate('posts_index'));
    }
}