<?php

namespace App\Controller;

use App\Entity\Quote;
use App\Form\QuoteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuoteController extends AbstractController
{
    private $em;
    
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/', name: 'app_quote')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        $num =  $this->em->getRepository(Quote::class)->findAll();
        $randomQuote = array_rand($num,1);
        return $this->render('quote/home.html.twig', [
            'quote' => $num[$randomQuote],
        ]);
    }

    #[Route('/quote', name: 'app_quote_list')]
    public function quoteList(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        $quote = new Quote();
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($quote);
            $this->em->flush();
            return $this->redirectToRoute('app_quote_list');
        }

        $quotes = $this->em->getRepository(Quote::class)->findAll();
        return $this->render('quote/index.html.twig', [
            'form' => $form->createView(),
            'quotes' => $quotes
        ]);
    }

    #[Route('/quote/delete/{id}', name: 'app_quote_delete', requirements: ['id' => '\d+'])]
    public function quoteDelete(Quote $quote): Response
    {

        $this->em->remove($quote);
        $this->em->flush();
        return $this->redirectToRoute('app_quote_list');
    }

    #[Route('/quote/edit/{id}', name: 'app_quote_edit', requirements: ['id' => '\d+'])]
    public function quoteEdit(Quote $quote, Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        
        $form = $this->createForm(QuoteType::class, $quote);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($quote);
            $this->em->flush();
            return $this->redirectToRoute('app_quote_list');
        }
        
        return $this->render('quote/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
