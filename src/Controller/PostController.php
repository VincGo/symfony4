<?php
namespace App\Controller;
use App\Entity\Contact;
use App\Entity\Posts;
use App\Form\ContactType;
use App\Form\PostType;
use App\Repository\PostsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;


class PostController extends AbstractController
{

    /**
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\Response
     * @Route("/", name="list_post")
     */

    public function index(PostsRepository $postsRepository)
    {
        $posts = $postsRepository->findBy(array(), array('id'=>'desc'));
        $infos = $postsRepository->infoSideBar();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'infos' => $infos,
        ]);
    }

    /**
     * @Route("/{id}", name="show_post", requirements={"id": "\d+"})
     */
    public function show(EntityManagerInterface $em, int $id, PostsRepository $postsRepository, Request $request)
    {
        $show = $em->getRepository(Posts::class)->find($id);
        if(null === $show){
            throw new NotFoundHttpException();
        }


        $post = new Posts();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('list_post');
        }


        $infos = $postsRepository->infoSideBar();

        return $this->render('post/show.html.twig', [
            'show' => $show,
            'post'=>$post,
            'infos' => $infos,
        ]);
    }

    public function commentForm(PostsRepository $postsRepository)
    {
        $infos = $postsRepository->infoSideBar();

        $form = $this->createForm(PostType::class);

        return $this->render('post/_comment_form.html.twig', [
            'form'=>$form->createView(),
            'infos' => $infos,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/contact", name="contact_post")
     */
    public function contact(Request $request, EntityManagerInterface $em, PostsRepository $postsRepository)
    {
        $infos = $postsRepository->infoSideBar();

        $contact = new Contact();
        $formCont = $this->createForm(ContactType::class, $contact);
        $formCont->handleRequest($request);
        if ($formCont->isSubmitted() &&  $formCont->isValid())
        {
            $contact = $formCont->getData();
            $em->persist($contact);
            $em->flush();

            return $this->redirectToRoute('list_post');
        }
        return $this->render('form_contact.html.twig', array(
            'formCont'=>$formCont->createView(),
            'infos'=>$infos,
        ));
    }

}