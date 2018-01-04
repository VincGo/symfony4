<?php
namespace App\Controller;
use App\Entity\Posts;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    public function index(EntityManagerInterface $em)
    {
        $posts = $em->getRepository(Posts::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/post/add", name="add_post")
     */
    public function new(Request $request)
    {
        $post = new Posts();

        $form = $this->createFormBuilder($post)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('save', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $post = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('list_post');
        }
        return $this->render('post/new.html.twig', array(
            'form'=> $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="show_post", requirements={"id": "\d+"})
     */
    public function show(EntityManagerInterface $em, int $id)
    {
        $post = $em->getRepository(Posts::class)->find($id);
        if(null === $post){
            throw new NotFoundHttpException();
        }

        return $this->render('post/show.html.twig', [
           'post' => $post
        ]);
    }


}