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

use Sensio\Bundle\GeneratorBundle\Tests\Generator\GeneratorTest;
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineFormGenerator;

class JordiLlonchFormGeneratorTest extends GeneratorTest
{
    public function testGenerate()
    {
        $generator = new DoctrineFormGenerator($this->filesystem);
        $generator->setSkeletonDirs(array(__DIR__.'/../../Resources/skeleton'));

        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle->expects($this->any())->method('getPath')->will($this->returnValue($this->tmpDir));
        $bundle->expects($this->any())->method('getNamespace')->will($this->returnValue('Foo\BarBundle'));

        $metadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')->disableOriginalConstructor()->getMock();
        $metadata->identifier = array('id');
        $metadata->associationMappings = array('title' => array('type' => 'string'));

        $generator->generate($bundle, 'Post', $metadata);

        $this->assertTrue(file_exists($this->tmpDir.'/Form/PostType.php'));

        $content = file_get_contents($this->tmpDir.'/Form/PostType.php');
        $this->assertContains('->add(\'title\')', $content);
        $this->assertContains('class PostType extends AbstractType', $content);
        $this->assertContains("'data_class' => 'Foo\BarBundle\Entity\Post'", $content);
        $this->assertContains("'foo_barbundle_post'", $content);
    }
}
