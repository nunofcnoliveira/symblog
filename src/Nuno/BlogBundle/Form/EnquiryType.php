<?php

namespace Nuno\BlogBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EnquiryType extends AbstractType
{
	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$builder->add('name');
		$builder->add('email', EmailType::class);
		$builder->add('subject');
		$builder->add('body', TextareaType::class);
		$builder->add('submit', SubmitType::class, array(
			'label' => 'Submit Details',
			'attr' => array('class' => 'formsubmit'),
		));
	}

	public function getName()
	{
		return 'contact';
	}
}