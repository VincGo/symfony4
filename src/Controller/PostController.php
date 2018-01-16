<?php
namespace App\Controller;
use App\Entity\Posts;
use App\Form\PostType;
use App\Repository\PostsRepository;
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

    public function index(PostsRepository $postsRepository)
    {
        $posts = $postsRepository->findBy(array(), array('id'=>'desc'));
        $infos = $postsRepository->findBy(array(), array('id'=>'desc'), $limit = 5);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'infos' => $infos,
        ]);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @Route("/post/add", name="add_post")
     */
    public function new(Request $request, EntityManagerInterface $em, PostsRepository $postsRepository)
    {

        $infos = $postsRepository->findBy(array(), array('id'=>'desc'), $limit = 5);
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
        return $this->render('post/new.html.twig', array(
            'form'=> $form->createView(),
            'infos' => $infos,
        ));
    }

    public function chat(Request $request, EntityManagerInterface $em)
    {
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
        return $this->render('post/new.html.twig', array(
            'form'=> $form->createView(),
        ));
    }

    /**
     * @Route("/{id}", name="show_post", requirements={"id": "\d+"})
     */
    public function show(EntityManagerInterface $em, int $id, PostsRepository $postsRepository)
    {



        $post = $em->getRepository(Posts::class)->find($id);
        if(null === $post){
            throw new NotFoundHttpException();
        }
        $infos = $postsRepository->findBy(array(), array('id'=>'desc'), $limit = 5);

        return $this->render('post/show.html.twig', [
           'post' => $post,
            'infos' => $infos,
        ]);
    }


}