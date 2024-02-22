<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Nem;
use App\Form\ImageType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ImageController extends AbstractController
{
    #[Route('/image/add/nem/{id}', name: 'add_nem_image')]
    public function index($id, Request $request, EntityManagerInterface $manager): Response
    {

        //determiner la route utilisée
        $route = $request->attributes->get("_route");

        //en fonction de la route, récuperer la bonne entité

        switch ($route){

            case 'add_nem_image':
                $entity = Nem::class;
                $setter = "setNem";
                $redirectRoute = "nem_image";
                $routeParam= ["id"=>$id];
                break;


        }


        $toBeAddedAnImage = $manager->getRepository($entity)->find($id);



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
