<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/nos-produis", name="product")
     * @param EntityManagerInterface $manager
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $manager, Request $request): Response
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class, $search)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $products = $manager->getRepository(Product::class)->findWithSearch($search);
        } else {
            $products = $manager->getRepository(Product::class)->findAll();
        }
        return $this->render('product/index.html.twig',[
            'products'=> $products,
            'form'=>$form->createView()
        ]);
    }

    /**
     * @Route("/produits/{slug}", name="produit")
     * @param $slug
     * @param EntityManagerInterface $manager
     * @return RedirectResponse|Response
     */
    public function show($slug, EntityManagerInterface $manager)
    {
        $product = $manager->getRepository(Product::class)->findOneBySlug($slug);
        if (!$product){
            return $this->redirectToRoute('product');
        }

        return $this->render('product/show.html.twig',[
            'product'=>$product
        ]);
    }
}
