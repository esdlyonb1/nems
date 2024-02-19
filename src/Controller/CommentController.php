<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Nem;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CommentController extends AbstractController
{
    #[Route('/comment/{id}', name: 'app_comment')]
    public function create(Nem $nem, EntityManagerInterface $manager, Request $request): Response
    {
        $comment = new Comment();
        $comment->setNem($nem);
        $comment->setCreatedAt(new \DateTime());
        $form = $this->createForm(CommentType::class,$comment);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setAuthor($this->getUser());
            $manager->persist($comment);
            $manager->flush();
        }

        return $this->redirectToRoute("show_nem", ["id"=>$nem->getId()]);
    }
}
