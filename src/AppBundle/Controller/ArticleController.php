<?php
namespace  AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;

class ArticleController extends Controller
{


    /**
     * @Route("/",name="articles.index")
     * @Method("GET")
     */

    public  function indexAction()
    {
       //On récupére l'url de base de l'API Rest (à changer selon votre installation de l'API sur serveur)
       $base_uri = $this->container->getParameter('base_uri');
       $url_articles = $base_uri."articles";
       try
       {
           $client = new Client();

           $response = $client->get($url_articles,null);
           $articles = \GuzzleHttp\json_decode($response->getBody()->getContents());

           return $this->render('home.twig', [

               'articles' => $articles

           ]);
       }
       catch (RequestException $e)
       {
          $response = $e->getMessage();

          return $response;

       }




    }












}