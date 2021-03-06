<?php
/**
 * This file was generated by PcabreusGeneratorBundle
 */

namespace Positibe\Bundle\NewsBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Positibe\Bundle\ClassificationBundle\Form\Type\TagFormType;
use Positibe\Bundle\CmsBundle\Form\Type\BaseContentType;
use Positibe\Bundle\MediaBundle\Form\Type\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

/**
 * Class PostFormType
 * @package Positibe\Bundle\NewsBundle\Form\Type
 */
class PostFormType extends AbstractType
{
    /** @var  AuthorizationChecker */
    protected $authorizationChecker;

    /**
     * @param AuthorizationChecker $authorizationChecker
     */
    public function __construct(AuthorizationChecker $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'featured',
                null,
                array(
                    'label' => 'post.form.featured_label',
                    'required' => false,
                )
            )
            ->add(
                'commentsEnabled',
                null,
                array(
                    'label' => 'post.form.commentsEnabled_label',
                    'required' => false,
                )
            )
            ->add(
                'tags',
                TagFormType::class,
                array(
                    'label' => 'post.form.tags_label',
                    'class_name' => 'Positibe\Bundle\NewsBundle\Entity\Tag',
                )
            )
            ->add(
                'image',
                ImageType::class,
                [
                    'label' => 'post.form.image_label',
                ]
            )
            ->add(
                'collections',
                null,
                array(
                    'label' => 'post.form.collection_label',
                    'multiple' => true,
                    'expanded' => true,
                )
            );
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            $builder->add(
                'author',
                null,
                [
                    'label' => 'post.form.author_label',
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.roles LIKE :role')
                            ->setParameter('role', "%ROLE_AUTHOR%");
                    },
                    'choice_label' => 'name'
                ]
            );
        }


    }

    public function getParent()
    {
        return BaseContentType::class;
    }


    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'Positibe\Bundle\NewsBundle\Entity\Post']);
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'positibe_post';
    }
}
