<?php
namespace  AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Symfony\Component\HttpFoundation\Request as re;

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
        $url_articles = $base_uri . "articles";
        try {
            $client = new Client();

            $response = $client->get($url_articles, null);
            $articles = \GuzzleHttp\json_decode($response->getBody()->getContents());

            return $this->render('home.twig', [

                'articles' => $articles

            ]);
        } catch (RequestException $e) {
            $response = $e->getMessage();

            return $response;

        }
    }

    /**
     * @Route("article/{slug}", name="article")
     * @Method("GET")
     */

    public function getArticleAction($slug)
    {
        //On récupére l'url de base de l'API Rest (à changer selon votre installation de l'API sur serveur)
        $base_uri = $this->container->getParameter('base_uri');
        $url_article = $base_uri . "articles/".$slug;

        try
        {
            $client = new Client();

            $response = $client->get($url_article, null);
            $article  = \GuzzleHttp\json_decode($response->getBody()->getContents());

            return $this->render('article/article.twig', [

                'article' => $article

            ]);
        }
        catch (RequestException $e)
        {
            $response = $e->getMessage();

            return $response;
        }

    }

    /**
     * @Route("creer/",name="article.show")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function showArticleAction()
    {

        return $this->render('article/add_article.twig');
    }

    /**
     * @Route("articles/", name="article.add")
     * @Method("POST")
     */
   public function addArticleAction(re $request)
   {

       //On récupére l'url de base de l'API Rest (à changer selon votre installation de l'API sur serveur)
       $base_uri = $this->container->getParameter('base_uri');
       $url_article_add = $base_uri."articles";
       $params = $request->request->all();

       $slug = str_replace(' ','-', $params['titre']);
       $slug = strtolower($slug);

       try
       {
           $client = new Client();

           $response = $client->request('POST',$url_article_add, [
               'headers' => ['Content-Type' => 'application/json'],
               'body'   => \GuzzleHttp\json_encode([
                   'titre' => $params['titre'],
                   'accroche' => $params['accroche'],
                   'corps' => $params['corps'],
                   'slug' => $slug,
                   'created_by' => $params['autheur'],

               ])

           ]);
        if($response->getStatusCode() == "201")
        {
            return $this->redirectToRoute('articles.index');
        }

       }
       catch (RequestException $e)
       {
           $response = $e->getMessage();

           return $response;
       }
   }

    /**
     * @Route("supprimer/{id}", name="article.delete")
     * @Method("POST")
     * @param $id
     */

public  function supprimerArticleAction($id)
{
    $base_uri           = $this->container->getParameter('base_uri');
    $url_article_delete = $base_uri."articles";

    try
    {
        $client = new Client();

       $url = $url_article_delete."/$id";

       $headers = array('Connection' => 'close', 'User-Agent' => 'PHPPlivo');
       $response = $client->delete($url,$headers);

       if($response->getStatusCode() == "204")
       {
           return $this->redirectToRoute('articles.index');

       }
    }
    catch (RequestException $e)
    {
        $response = $e->getMessage();

        return $response;
    }


}













}