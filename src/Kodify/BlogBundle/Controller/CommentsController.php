<?php

namespace Kodify\BlogBundle\Controller;

use Kodify\BlogBundle\Entity\Comment;
use Kodify\BlogBundle\Form\Type\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentsController extends Controller
{
    public function createAction(Request $request, $id)
    {
        $post = $this->getDoctrine()->getRepository('KodifyBlogBundle:Post')->find($id);

        $comment = new Comment();
        $comment->setPost($post);

        $form = $this->createForm(
            new CommentType(),
            $comment,
            [
                'action' => $this->generateUrl('create_comment', ['id' => $id]),
                'method' => 'POST',
            ]
        );
        $parameters = ['form' => $form->createView()];

        $form->handleRequest($request);
        if ($form->isValid()) {
            $comment = $form->getData();
            $this->getDoctrine()->getManager()->persist($comment);
            $this->getDoctrine()->getManager()->flush();

            $parameters['message'] = 'Comment Created!';
            $parameters['post'] = $post;

            return $this->render('KodifyBlogBundle:Post:view.html.twig', $parameters);
        }

        return $this->render('KodifyBlogBundle:Default:create.html.twig', $parameters);
    }
}
