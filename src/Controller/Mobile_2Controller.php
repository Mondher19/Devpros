<?php



namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UpdateUserType;
use App\Security\EmailVerifier as EmailVerifierAlias;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;


class Mobile_2Controller extends AbstractController
{
    private EmailVerifierAlias $emailVerifier;

    public function __construct(EmailVerifierAlias $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }


    /**
     * @Route("/mobile", name="mobile")
     */
    public function index(): Response
    {
        return $this->render('mobile/index.html.twig', [
            'controller_name' => 'MobileController',
        ]);
    }


    /**
     * @Route("/loginmobile", name="loginmobile")
     */

    public function signinmobile(Request $request,NormalizerInterface $normalizer,UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $Un = $request->get('username');
        $pwd = $request->get('password');
        $repository=$this->getDoctrine()->getRepository(User::class);
        $user=$repository->findOneBy(['nom' => $Un]);
        if (!$user)
        {
            $user1=new User();
            $user1->setNom($Un);
            $user1->setPrenom("x");
            $user1->setPassword("x");
            $user1->setId(0);
            $user1->setmail("x");
            $jsonContent = $normalizer->normalize($user1,'json',['groups'=>'post:read']);
            return new Response(json_encode($jsonContent));
        }
        if($userPasswordEncoder->isPasswordValid($user,$pwd))
        {
            $jsonContent = $normalizer->normalize($user,'json',['groups'=>'post:read']);
            return new Response(json_encode($jsonContent));
        }
        else
        {
            $user1=new User();
            $user1->setNom($Un);
            $user1->setPrenom("x");
            $user1->setPassword("x");
            $user1->setId(0);
            $user1->setmail("x");
            $jsonContent = $normalizer->normalize($user1,'json',['groups'=>'post:read']);
            return new Response(json_encode($jsonContent));
        }

    }

    /**
     * @Route("/getusermobile/{id}", name="getusersmobile")
     */
    public function getsingleuser(Request $request, NormalizerInterface $normalizer, $id): Response
    {
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->find($id);
        $jsonContent = $normalizer->normalize($users, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/addusermobile", name="addusermobile")
     */
    public function adduser(Request $request, NormalizerInterface $normalizer, UserPasswordEncoderInterface $userPasswordEncoder)
    {

        $user = new User();

        $user->setNom($request->get("username"));
        $user->setPrenom($request->get("prenom"));
        $user->setMail($request->get("email"));
        $user->setPassword(
            $userPasswordEncoder->encodePassword(
                $user,
                $request->get("password")
            )
        );
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $jsonContent = $normalizer->normalize($user, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/getusersmobile", name="getusersmobile")
     */
    public function getusers(Request $request,NormalizerInterface $normalizer):Response
    {
        $repository=$this->getDoctrine()->getRepository(User::class);
        $Games=$repository->findAll();
        //$User=$repository->findAll();
        $jsonContent = $normalizer->normalize($Games,'json',['groups'=>'post:read']);
        //return $this->render('mobile/loginjson.html.twig',['data'=>$jsonContent]);
        return new Response(json_encode($jsonContent));
    }


   /* /**
     * @Route("/updateusermobile/", name="updateusermobile")
     */
  /*  public function update(Request $request, UserPasswordEncoderInterface $userPasswordEncoder, NormalizerInterface $normalizer)
    {
        $id = ($request->get("id"));
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $user->setPoints($request->get("points"));
        $user->setBio($request->get("bio"));
        $user->setEmail($request->get("email"));
        $user->setUsername($request->get("username"));
        $user->setPassword(
            $userPasswordEncoder->encodePassword(
                $user,
                $request->get("password")));
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $jsonContent = $normalizer->normalize($user, 'json', ['groups' => 'post:read']);

        return new Response(json_encode($jsonContent));

    }*/


    /**
     * @Route("/deusersmobile", name="delusersmobile")
     */
    public function deleteusermobile(Request $request, NormalizerInterface $normalizer): Response
    {
        $repository = $this->getDoctrine()->getManager();
        $id = $request->get("id");
        $user = $repository->getRepository(User::class)->find($id);
        $repository->remove($user);
        $repository->flush();
        $jsonContent = $normalizer->normalize($user, 'json', ['groups' => 'post:read']);
        return new Response(json_encode("User deleted Successfully "));
    }

}