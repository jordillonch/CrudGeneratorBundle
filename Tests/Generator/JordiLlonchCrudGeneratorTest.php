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

namespace JordiLlonch\Bundle\CrudGeneratorBundle\Tests\Generator;

use Sensio\Bundle\GeneratorBundle\Tests\Generator\DoctrineCrudGeneratorTest;
use JordiLlonch\Bundle\CrudGeneratorBundle\Generator\JordiLlonchCrudGenerator;

class JordiLlonchCrudGeneratorTest extends DoctrineCrudGeneratorTest
{
    protected function getGenerator()
    {
        $generator =  new JordiLlonchCrudGenerator($this->filesystem);
        $generator->setSkeletonDirs(array(__DIR__.'/../../Resources/skeleton'));

        return $generator;
    }

    public function testGenerateYamlFull()
    {
        parent::testGenerateYamlFull();

        $this->assertFilterAndPaginator();
    }

    public function testGenerateXml()
    {
        parent::testGenerateXml();

        $this->assertFilterAndPaginator();
    }

    public function testGenerateAnnotationWrite()
    {
        parent::testGenerateAnnotationWrite();

        $this->assertFilterAndPaginator();
    }

    public function testGenerateAnnotation()
    {
        parent::testGenerateAnnotation();

        $this->assertFilterAndPaginator();
    }

    protected function assertFilterAndPaginator()
    {
        $content = file_get_contents($this->tmpDir . '/Controller/PostController.php');
        $strings = array(
            'protected function filter',
            'protected function paginator',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }


        $this->assertTrue(file_exists($this->tmpDir.'/Form/PostFilterType.php'));

        $content = file_get_contents($this->tmpDir.'/Form/PostFilterType.php');
        $this->assertContains('->add(\'title\', \'filter_text\')', $content);
        $this->assertContains('class PostFilterType extends AbstractType', $content);
        $this->assertContains("'foo_barbundle_postfiltertype'", $content);

    }
}
