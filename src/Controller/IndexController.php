<?php
/**
 * Created by PhpStorm.
 * User: jordan
 * Date: 21/12/17
 * Time: 14:44
 */
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends Controller{
    /**
     * @Route("/")
     */
    public function indexAction(){
        return $this->render('base.html.twig');
    }
}