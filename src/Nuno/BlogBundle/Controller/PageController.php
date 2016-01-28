<?php

namespace Nuno\BlogBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Nuno\BlogBundle\Entity\Enquiry;
use Nuno\BlogBundle\Form\EnquiryType;

class PageController extends Controller
{
	public function indexAction()
	{
		return $this->render('NunoBlogBundle:Page:index.html.twig');
	}

	public function aboutAction()
	{
		return $this->render('NunoBlogBundle:Page:about.html.twig');
	}

	public function contactAction(Request $request)
	{
		$enquiry = new Enquiry();
		$form = $this->createForm(EnquiryType::class, $enquiry);

		if ($request->isMethod('POST')) {
			$form->handleRequest($request);

			if ($form->isValid()) {
				// Send e-mail
				$message = \Swift_Message::newInstance()
					->setSubject('Contact enquiry from symblog')
					->setFrom('enquiries@symblog.co.uk')
					->setTo($this->container->getParameter('nuno_blog.emails.contact_email'))
					->setBody($this->renderView('NunoBlogBundle:Page:contactEmail.txt.twig', array('enquiry' => $enquiry)));
				$this->get('mailer')->send($message);

				// Set flash message
				$this->get('session')->getFlashBag()->add('blogger-notice', 'Your contact enquiry was successfully sent. Thank you!');

				// Redirect afterwards ;)
				return $this->redirectToRoute('NunoBlogBundle_contact');
			}
		}

		return $this->render('NunoBlogBundle:Page:contact.html.twig', array(
			'form' => $form->createView()
		));
	}
}