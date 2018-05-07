<?php
/**
 * Created by PhpStorm.
 * User: MASSENI
 * Date: 20/03/2018
 * Time: 16:31
 */

namespace CoreBundle\Controller;

use CoreBundle\CoreBundle;
use CoreBundle\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;


class LoginController extends Controller
{
    /**
     * @Rest\Post("/login")
     *
     * @param Request $request
     * @return JsonResponse
     */
   public function loginAction(Request $request)
   {
       $username = $request->get('username');
       $pwd = $request->get('password');

       $em = $this->getDoctrine()
           ->getManager();
       // recuperer l'utilisateur par son username
       $user = $em  ->getRepository('CoreBundle:User')
                    ->findByUsernameOrEmail($username);

       if(!$user){
           // si aucun utilisateur return user not found
           return new JsonResponse(['message'=> 'User not found !'], Response::HTTP_NOT_FOUND);
       }
        /*
         - Invoquer le service d'encodage du mot de passe de notre user
         - Verifier avec la method ispasswordValid si le mots de passes correspondent
         - return true ou false
        */
        $isvalid = $this->get('security.password_encoder')
            ->ispasswordValid($user,$pwd);

       if(!$isvalid){
           // si aucun utilisateur return probleme de mot de passe
           return new JsonResponse(['message'=> 'Values Error !'], Response::HTTP_NOT_FOUND);
       }

       // générer le token
       $token = $this->getToken($user);

       /*$data = $this->get("core_bundle.userprovider")
       ->loadUserByToken($token);
       if(!$data instanceof User) {
           return $data;
       }*/

       return new JsonResponse(['token' => $token]);

   }

    /**
     * @param User $user
     * @return mixed
     */
   public  function getToken(User $user){
       /**
        * Le service lexik_jwt_authentication.encoder
        *   * permet de generer un token par rapport à un encodage
        *   * ici: username et expiration.
        */
       return $this->container->get('lexik_jwt_authentication.encoder')
           ->encode([
               'username' => $user->getUsername(),
               'exp' => $this->getTokenExpiration(),
           ]);
   }

    /**
     * @return string Unixtimestamp
     *
     */
   public function getTokenExpiration(){
       /**
        * Le service lexik_jwt_authentication.token_ttl
        * permet de recuperer le tmps d'expiration du token.
        */

      $expiration = $this->container->getParameter('lexik_jwt_authentication.token_ttl');
      $now = new \DateTime();
      $now->add(new \DateInterval('PT'.$expiration.'S'));
      return $now->format('U');


   }


}