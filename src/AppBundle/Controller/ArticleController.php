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





    }












}