<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\ImageType;
use App\Repository\ImageRepository;
use App\Repository\NemRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image/add/nem/{id}', name: 'add_nem_image')]
    #[Route('/image/add/comment/{id}', name: 'add_comment_image')]
    public function index($id, Request $request, EntityManagerInterface $manager, ImageRepository $imageRepository, NemRepository $nemRepository): Response
    {
        //determiner la route utilisée
        $route = $request->attributes->get("_route");

        switch ($route){

            case 'add_nem_image':
                $repo = $nemRepository;
                $setter = "setNem";
                $redirectRoute = "nem_image";
                $routeParam= ["id"=>$id];
        }


        $toBeAddedAnImage = $repo->find($id);


        //en fonction de la route, récuperer la bonne entité

        $image = new Image();
        $formImage = $this->createForm(ImageType::class, $image);
        $formImage->handleRequest($request);
        if($formImage->isSubmitted() && $formImage->isValid())
        {

            $image->$setter($toBeAddedAnImage);
            $manager->persist($image);
            $manager->flush();

        }



        return $this->redirectToRoute($redirectRoute, $routeParam);
    }
}
