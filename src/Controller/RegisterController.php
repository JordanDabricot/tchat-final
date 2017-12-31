<?php
namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class RegisterController extends Controller {

    /**
     * @Route("/register")
     */
    public function indexAction(Request $request){
        if ($request -> request -> has("submit") && $request->get('password') == $request->get('password2')){
            $login = $request->get('login');
            $email = $request->get('email');
            $name = $request->get('name');
            $firstName = $request->get('firstName');
            $sexe = $request->get('sexe');
            $age = $request->get('age');
            $password = sha1($request->get('password'));


            $em = $this->getDoctrine()->getManager();
            $user = new user();
            $user->setLogin($login);
            $user->setEmail($email);
            $user->setName($name);
            $user->setFirstName($firstName);
            $user->setSexe($sexe);
            $user->setAge($age);
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();
            return $this->render('register.html.twig', array('message' => 'Compte enregistrer'));
        }
        return $this->render('register.html.twig', array('message' => ''));
    }
}