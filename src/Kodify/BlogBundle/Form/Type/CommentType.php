<?php
namespace Kodify\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content')
            ->add('author')
            ->add('publish', 'submit', ['label' => 'publish', 'attr' => ['class' => 'btn btn-success', 'role' => 'link']]);
    }

    public function getName()
    {
        return 'Comment';
    }
}