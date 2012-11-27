<?php

/*
 * This file is part of the CrudGeneratorBundle
 *
 * It is based/extended from SensioGeneratorBundle
 *
 * (c) Jordi Llonch <llonch.jordi@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace JordiLlonch\Bundle\CrudGeneratorBundle\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Sensio\Bundle\GeneratorBundle\Command\Validators;
use Sensio\Bundle\GeneratorBundle\Command\GenerateDoctrineCrudCommand;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;
use JordiLlonch\Bundle\CrudGeneratorBundle\Generator\DoctrineFormFilterGenerator;

class JordiLlonchCrudCommand extends GenerateDoctrineCrudCommand
{
    protected $generator;
    protected $formGenerator;
    protected $formFilterGenerator;

    protected function configure()
    {
        parent::configure();

        $this->setName('jordillonch:generate:crud');
        $this->setDescription('A CRUD generator with paginating and filters.');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);

        $entity = Validators::validateEntityName($input->getOption('entity'));
        list($bundle, $entity) = $this->parseShortcutNotation($entity);
        $entityClass = $this->getContainer()->get('doctrine')->getEntityNamespace($bundle).'\\'.$entity;
        $metadata    = $this->getEntityMetadata($entityClass);
        $bundle      = $this->getContainer()->get('kernel')->getBundle($bundle);

        try {
            $this->getFormFilterGenerator()->generate($bundle, $entity, $metadata[0]);
        } catch (\RuntimeException $e ) {
            // form already exists
        }
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        $dialog = $this->getDialogHelper();
        $dialog->writeSection($output, 'JordiLlonchCrudGeneratorBundle');

        parent::interact($input, $output);
    }

  protected function getGenerator()
    {

        $myResdir =$this->getContainer()->getParameter('kernel.root_dir');
        if (null === $this->generator) {
            if (file_exists($myResdir.'/Resources/JordiLlonchCrudGeneratorBundle/skeleton/crud')) {
                $this->generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), $myResdir.'/Resources/JordiLlonchCrudGeneratorBundle/skeleton/crud');
            }else{
                $this->generator = new DoctrineCrudGenerator($this->getContainer()->get('filesystem'), __DIR__.'/../Resources/skeleton/crud');
            }

        }

        return $this->generator;
    }
    protected function getFormGenerator()
    {
        if (null === $this->formGenerator) {
            $this->formGenerator = new DoctrineFormGenerator($this->getContainer()->get('filesystem'),  __DIR__.'/../Resources/skeleton/form');
        }

        return $this->formGenerator;
    }

    protected function getFormFilterGenerator()
    {
        if (null === $this->formFilterGenerator) {
            $this->formFilterGenerator = new DoctrineFormFilterGenerator($this->getContainer()->get('filesystem'),  __DIR__.'/../Resources/skeleton/form');
        }

        return $this->formFilterGenerator;
    }

    /**
     * It is copied here because $this->generator it is a private variable on parent
     * class and I created here as a protected varible.
     * Without this method here, tests are not working.
     */
    public function setGenerator(DoctrineCrudGenerator $generator)
    {
        $this->generator = $generator;
    }

    public function setFormFilterGenerator(DoctrineFormFilterGenerator $formFilterGenerator)
    {
        $this->formFilterGenerator = $formFilterGenerator;
    }
}
