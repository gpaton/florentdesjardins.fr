<?php

namespace Florent\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
                'constraints' => array(new Assert\NotBlank()),
            ))
            ->add('email', 'email', array(
                'constraints' => array(new Assert\NotBlank(), new Assert\Email()),
            ))
            ->add('message', 'textarea', array(
                'constraints' => array(new Assert\NotBlank()),
            ));
    }

    public function getName()
    {
        return 'contact';
    }
}
