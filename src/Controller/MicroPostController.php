<?php

namespace App\Controller;

use App\Entity\MicroPost;
use App\Repository\MicroPostRepository;
use DateTime;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
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
}
