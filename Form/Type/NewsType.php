<?php

namespace Positibe\Bundle\NewsBundle\Form\Type;

use Positibe\Bundle\ClassificationBundle\Form\Type\TagFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class NewsType
 * @package Positibe\Bundle\NewsBundle\Form
 *
 * @author Pedro Carlos Abreu <pcabreus@gmail.com>
 */
class NewsType extends AbstractType
{
    protected $class;

    public function __construct($class = 'Positibe\Bundle\NewsBundle\Model\News')
    {
        $this->class = $class;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add(
                'abstract',
                'ckeditor',
                array(
                    'config_name' => 'basic',
                    'required' => false
                )
            )
            ->add(
                'content',
                'ckeditor',
                array(
                    'config_name' => 'standard',
                    'attr' => array(
                        'rows' => 5,
                    ),
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'required' => false
                )
            )
            ->add(
                'commentsEnabled',
                null,
                array(
                    'required' => false
                )
            )
            ->add(
                'tags',
                'positibe_tag'
            )
            ->add(
                'image',
                'sonata_media_type',
                array(
                    'provider' => 'sonata.media.provider.image',
                    'context' => 'news',
                    'attr' => array(
                        'class' => 'fileupload-preview thumbnail'
                    ),
                    'required' => false
                )
            )
        ;
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
        return 'positibe_news_news';
    }
}
