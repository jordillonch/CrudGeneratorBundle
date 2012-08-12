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
use JordiLlonch\Bundle\CrudGeneratorBundle\Generator\DoctrineFormFilterGenerator;

class JordiLlonchFormFilterGeneratorTest extends GeneratorTest
{
    public function testGenerate()
    {
        $generator = new DoctrineFormFilterGenerator($this->filesystem, __DIR__.'/../../Resources/skeleton/form');

        $bundle = $this->getMock('Symfony\Component\HttpKernel\Bundle\BundleInterface');
        $bundle->expects($this->any())->method('getPath')->will($this->returnValue($this->tmpDir));
        $bundle->expects($this->any())->method('getNamespace')->will($this->returnValue('Foo\BarBundle'));

        $metadata = $this->getMockBuilder('Doctrine\ORM\Mapping\ClassMetadataInfo')->disableOriginalConstructor()->getMock();
        $metadata->identifier = array('id');
        $metadata->associationMappings = array('title' => array('type' => 'string'));
        $metadata->fieldMappings = array(
            'id' => array('fieldName' => 'id', 'type' => 'integer'),
            'title' => array('fieldName' => 'title', 'type' => 'string'),
        );

        $generator->generate($bundle, 'Post', $metadata);

        $this->assertTrue(file_exists($this->tmpDir.'/Form/PostFilterType.php'));

        $content = file_get_contents($this->tmpDir.'/Form/PostFilterType.php');
        $this->assertContains('->add(\'title\', \'filter_text\')', $content);
        $this->assertContains('class PostFilterType extends AbstractType', $content);
        $this->assertContains("'foo_barbundle_postfiltertype'", $content);
    }
}
