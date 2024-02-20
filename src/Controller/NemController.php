<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Nem;
use App\Form\CommentType;
use App\Form\ImageType;
use App\Form\NemType;
use App\Repository\NemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class NemController extends AbstractController
{
    #[Route('/nems', name: 'app_nems')]
    public function index(NemRepository $nemRepository): Response
    {
        return $this->render('nem/index.html.twig', [
            'nems'=>$nemRepository->findAll(),
        ]);
    }

    #[Route('/nem/{id}', name:"show_nem", priority:-1)]
    public function show(Nem $nem):Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);

        return $this->render('nem/show.html.twig', [
            'nem'=>$nem,
            'commentForm'=>$commentForm
        ]);
    }
    #[Route('/nem/create', name:'create_nem')]
    public function create(Request $request, EntityManagerInterface $manager):Response
    {
        if(!$this->getUser()){return $this->redirectToRoute("app_home");}

        $nem = new Nem();
        $form = $this->createForm(NemType::class, $nem);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {

            $nem->setAuthor($this->getUser());
            $nem->setCreatedAt(new \DateTime());
            $manager->persist($nem);
            $manager->flush();
            return $this->redirectToRoute('show_nem', ["id"=>$nem->getId()]);
        }


        return $this->render('nem/create.html.twig', [
            'form'=>$form->createView(),
        ]);
    }
    #[Route("/new/delete/{id]", name:'delete_nem')]
    public function delete(Nem $nem, EntityManagerInterface $manager):Response
    {

        if($this->getUser() === $nem->getAuthor())
        {
            $manager->remove($nem);
            $manager->flush();
        }

        return $this->redirectToRoute("app_nems");

    }

    #[Route('/nem/image/add/{id}', name:"nem_add_image")]
    public function addImage(Nem $nem, Request $request, EntityManagerInterface $manager):Response
{
    $image = new Image();
    $form = $this->createForm(ImageType::class, $image);
    $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $image->setNem($nem);
            $manager->persist($image);
            $manager->flush();
        }

        return $this->render("nem/addimage.html.twig", ["form"=>$form->createView()]);
}

}
