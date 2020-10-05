<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;



class HomeController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(LivreRepository $livreRepository)
    {
        $livres = $livreRepository->findAll();

        return $this->render('home/index.html.twig', [
            'livres' => $livres
        ]);
    }

    /**
     * @Route("/login/indexlogin")
     */
    public function indexLogin(LivreRepository $livreRepository)
    {
        $livres = $livreRepository->findAll();

        return $this->render('login/indexlogin.html.twig', [
            'livres' => $livres
        ]);
    }


    /**
     * @Route("/home/{id<[0-9]+>}")
     */
    public function show(Livre $livre){
        return $this->render('home/show.html.twig', [
            'livre' => $livre
        ]);
    }

    /**
     * @Route("/home/creerlivre", methods={"GET", "POST"}) 
     */
    public function creerLivre(Request $request, EntityManagerInterface $em, UserRepository $userRepository){
        $livre = new Livre;

        // Création de formulaire automatique avec LivreType
        $form = $this->createForm(LivreType::class, $livre);

        // Création 'manuelle' de formulaire 

        // $form = $this->createFormBuilder($livre)
        //     ->add('titre', TextType::class)
        //     ->add('auteur', TextType::class)
        //     ->add('dateEdition', TextType::class, [
        //         'label' => 'Date d\'édition'
        //     ])
        //     ->getForm()
        // ;

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            // dd($data["dateEdition"]);
            $wins = $userRepository->findOneBy(['email' => 'brechairevincent@gmail.com']);
            $livre->setUser($wins);
            $livre->setDateAjout();
            // dd($livre->setDateAjout());

            $livre->setDateModif();

            $em->persist($data);
            $em->flush();

            $this->addFlash("success", "Livre créé avec succès !");

            return $this->redirectToRoute("app_home_indexlogin");
        }
        
        return $this->render("home/creerLivre.html.twig", [
            "formLivre" => $form->createView()
        ]);
    }

    /**
     * @Route("/home/{id<[0-9]+>}/edit", methods={"GET", "PUT"})
     */
    public function modifLivre(Request $request, EntityManagerInterface $em, Livre $livre){
        $form = $this->createForm(LivreType::class, $livre, [
            "method" => "PUT"
        ]);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em->flush();

            $this->addFlash("success", "Livre modifié avec succès !");

            return $this->redirectToRoute("app_home_indexlogin");
        }

        return $this->render("home/edit.html.twig", [
            "livre" => $livre,
            "formLivre" => $form->createView()
        ]);
    }

    /**
     * @Route("/home/{id<[0-9]+>}/delete", methods={"DELETE"})
     */
    public function suppLivre(EntityManagerInterface $em, Livre $livre){
        $em->remove($livre);
        $em->flush();

        $this->addFlash("danger", "Livre supprimé avec succès !");

        return $this->redirectToRoute("app_home_indexlogin");
    }
}
