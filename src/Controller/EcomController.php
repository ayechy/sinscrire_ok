<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class EcomController extends AbstractController
{
    /**
     * @Route("", name="home")
     */
    public function home()
    {   
        $prod = $this->GetDoctrine()->getRepository(product::class)->FindAll();

        return $this->render('pages/home.html', [
            'prod' => $prod
        ]);
    }

    /**
     * @Route("/create", name="create")
     */
    public function create(request $request, ObjectManager  $Manager){
        $prod = new product();
        $form = $this->createForm(ProductType:: class, $prod);

        $form->handleRequest($request);

        if($form->issubmitted()){
            $Manager = $this->getDoctrine()->getManager();
            $Manager -> persist($prod);
            $Manager -> flush();
            return $this->redirectToRoute('home');
        }
        $formView = $form->createView();

        return $this->render('pages/create.html',[
            'form' => $formView
        ]);

        }


        /**
        * @Route("/more/{id}", name = "more")
        */
    public function more($id){
        $prod = $this->getdoctrine()->getrepository(Product::class)->find($id);
        return $this->render('pages/more.html',[
            'load' => $prod
        ]) ;
    }
    

}
