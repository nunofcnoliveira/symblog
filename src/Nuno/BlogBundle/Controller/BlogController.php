<?php

namespace Nuno\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
	public function showAction($id, $slug)
	{
		$em = $this->getDoctrine()->getManager();

		$blog = $em->getRepository('NunoBlogBundle:Blog')->find($id);

		if (!$blog) {
			throw $this->createNotFoundException('Unable to find Blog post.');
		}

		$comments = $em->getRepository('NunoBlogBundle:Comment')
				   ->getCommentsForBlog($blog->getId());

		return $this->render('NunoBlogBundle:Blog:show.html.twig', array(
			'blog'      => $blog,
			'comments'  => $comments,
		));
	}
}