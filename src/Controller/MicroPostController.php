<?php

namespace App\Controller;

use DateTime;
use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MicroPostController extends AbstractController
{
    #[Route('/micro-post', name: 'app_micro_post')]
    public function index(MicroPostRepository $posts): Response
    {
        // $microPost = new MicroPost();
        // $microPost->setTitle('It comes from controller');
        // $microPost->setText('Hi!');
        // $microPost->setDate(new DateTime());

        // $microPost = $posts->find();
        // $microPost->setTitle('Welcome in general');

        // $posts->add($microPost, true);

        //dd($posts -> findAll());

        return $this->render('micro_post/index.html.twig', [
            'posts' => $posts->findAll(),
        ]);
    }

    //Accessing repository way
    // #[Route('/micro-post/{id}', name: 'app_micro_post_show')]
    // public function showOne($id, MicroPostRepository $posts): Response
    // {
    //     dd($posts -> find($id));
    // }

    //New way with sensio-fw-extra-bundle lib. No need to access methods of the repository (For single data)
    //If you want to fetch moda data or filter data, use repostiory way(old way)
    //Bence bu yonteme gerek yok. Repository yontemi daha iyi.
    #[Route('/micro-post/{post}', name: 'app_micro_post_show')]
    public function showOne(MicroPost $post): Response
    {
        return $this->render('micro_post/show.html.twig', [
            'post' => $post,
        ]);
    }

    #[Route('/micro-post/add', name: 'app_micro_post_add', priority: 2)]
    public function add(Request $request, MicroPostRepository $posts): Response 
    {
        $microPost = new MicroPost();

        $form = $this->createFormBuilder($microPost)
            ->add('title')
            ->add('text')
            // ->add('submit', SubmitType::class, ['label' => 'Save'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $post = $form->getData();
            $post->setDate(new DateTime());
            $posts->add($post, true);

            // Add a flash
            $this->addFlash('success', 'Your micro post have been addded.');

            return $this->redirectToRoute('app_micro_post');
            // Redirect
        }

        return $this->renderForm(
            'micro_post/add.html.twig',
            [
                'form' => $form
            ]
        );
    }
}
