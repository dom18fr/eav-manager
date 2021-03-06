<?php

namespace CleverAge\EAVManager\AdminBundle\Form\Type;

use Sidus\EAVVariantBundle\Form\Type\VariantFamilySelectorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VariantFamilySelector extends AbstractType
{
    /**
     * {@inheritDoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('family', VariantFamilySelectorType::class, [
            'label' => 'admin.variant.select.family.label',
            'attribute' => $options['attribute'],
            'parent_data' => $options['parent_data'],
        ]);
    }

    /**
     * {@inheritDoc}
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setRequired([
            'attribute',
            'parent_data',
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function getBlockPrefix()
    {
        return 'eavmanager_variant_family_selector';
    }
}
