<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Like;
use App\Entity\Nem;
use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
use App\Repository\NemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LikeController extends AbstractController
{
    #[Route('/like/nem/{id}', name: 'nem_like')]
    #[Route('/like/comment/{id}', name: 'comment_like')]
    public function like(Request $request, NemRepository $nemRepository, CommentRepository $commentRepository, $id, EntityManagerInterface $manager, LikeRepository $likeRepository): Response
    {

        $user = $this->getUser();
        if(!$user){return $this->json("no user connected", 400);}

        $route = $request->attributes->get("_route");
        if($route == "nem_like"){
         $nem = $nemRepository->find($id);
            $mode = "nem";
        }
        if($route == "comment_like"){
            $comment =  $commentRepository->find($id);
            $mode= "comment";

        }


        $search = [
            "author"=>$user
        ];
        if($mode == "nem"){
            $search["nem"]=$nem;
        }
        if($mode == "comment"){
            $search["comment"]=$comment;
            }

        $like = $likeRepository->findOneBy($search);

        if(!$like){
            $like = new Like();
            $like->setAuthor($user);
            if($mode=="nem"){
                $like->setNem($nem);
            }
            if($mode=="comment"){
                $like->setComment($comment);
            }


            $manager->persist($like);
            $isLiked = true;

        }else{
            $manager->remove($like);
            $isLiked = false;
        }

        $manager->flush();

      //  return $this->redirectToRoute("show_nem", ["id"=>$nem->getId()]);
      //  return $this->redirectToRoute("app_nems");

        if($mode=="nem")
        {
           $countSearch= [
                "nem"=>$nem
            ];
        }

        if($mode=="comment")
        {
            $countSearch= [
                "comment"=>$comment
            ];
        }

        $count = $likeRepository->count($countSearch);
        $data = [
            "isLiked"=>$isLiked,
            "count"=>$count
        ];
        return $this->json($data, 200);
    }
}
