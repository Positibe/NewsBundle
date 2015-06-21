<?php

namespace Positibe\Bundle\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CommentFormType
 * @package Positibe\Bundle\NewsBundle\Form\Type
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class CommentFormType extends AbstractType
{
    private $class;

    public function __construct($class = 'Positibe\Bundle\NewsBundle\Model\Comment')
    {
        $this->class = $class;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('url')
            ->add('message');
    }


    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => $this->class
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'positibe_news_comment';
    }
}
