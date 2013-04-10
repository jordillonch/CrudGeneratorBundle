<?php
namespace JordiLlonch\Bundle\CrudGeneratorBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RolesType extends AbstractType
{
    private $rolesChoices;

    public function __construct(array $rolesChoices)
    {
        $this->rolesChoices = $rolesChoices;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->rolesChoices,
            'required' => true,
            'multiple' => true
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'roles';
    }
}