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
use Sensio\Bundle\GeneratorBundle\Generator\DoctrineCrudGenerator;

class JordiLlonchCrudGeneratorTest extends DoctrineCrudGeneratorTest
{
    protected function getGenerator()
    {
        return new DoctrineCrudGenerator($this->filesystem, __DIR__.'/../../Resources/skeleton/crud');
    }

    public function testGenerateYamlFull()
    {
        // BEGIN: parent::testGenerateYamlFull();
        $this->getGenerator()->generate($this->getBundle(), 'Post', $this->getMetadata(), 'yml', '/post', true, false);

        $files = array(
            'Controller/PostController.php',
            'Tests/Controller/PostControllerTest.php',
            'Resources/config/routing/post.yml',
            'Resources/views/Post/index.html.twig',
            'Resources/views/Post/show.html.twig',
            'Resources/views/Post/new.html.twig',
            'Resources/views/Post/edit.html.twig',
        );
        foreach ($files as $file) {
            $this->assertTrue(file_exists($this->tmpDir.'/'.$file), sprintf('%s has been generated', $file));
        }

        $files = array(
            'Resources/config/routing/post.xml',
        );
        foreach ($files as $file) {
            $this->assertFalse(file_exists($this->tmpDir.'/'.$file), sprintf('%s has not been generated', $file));
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'namespace Foo\BarBundle\Controller;',
            'public function indexAction',
            'public function showAction',
            'public function newAction',
            'public function editAction',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }
        // END


        $this->assertFilterAndPaginator();
    }

    public function testGenerateXml()
    {
        // BEGIN: parent::testGenerateXml();
        $this->getGenerator()->generate($this->getBundle(), 'Post', $this->getMetadata(), 'xml', '/post', false, false);

        $files = array(
            'Controller/PostController.php',
            'Tests/Controller/PostControllerTest.php',
            'Resources/config/routing/post.xml',
            'Resources/views/Post/index.html.twig',
            'Resources/views/Post/show.html.twig',
        );
        foreach ($files as $file) {
            $this->assertTrue(file_exists($this->tmpDir.'/'.$file), sprintf('%s has been generated', $file));
        }

        $files = array(
            'Resources/config/routing/post.yml',
            'Resources/views/Post/new.html.twig',
            'Resources/views/Post/edit.html.twig',
        );
        foreach ($files as $file) {
            $this->assertFalse(file_exists($this->tmpDir.'/'.$file), sprintf('%s has not been generated', $file));
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'namespace Foo\BarBundle\Controller;',
            'public function indexAction',
            'public function showAction',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'public function newAction',
            'public function editAction',
            '@Route',
        );
        foreach ($strings as $string) {
            $this->assertNotContains($string, $content);
        }
        // END

        $this->assertFilterAndPaginator();
    }

    public function testGenerateAnnotationWrite()
    {
        // BEGIN: parent::testGenerateAnnotationWrite();
        $this->getGenerator()->generate($this->getBundle(), 'Post', $this->getMetadata(), 'annotation', '/post', true, false);

        $files = array(
            'Controller/PostController.php',
            'Tests/Controller/PostControllerTest.php',
            'Resources/views/Post/index.html.twig',
            'Resources/views/Post/show.html.twig',
            'Resources/views/Post/new.html.twig',
            'Resources/views/Post/edit.html.twig',
        );
        foreach ($files as $file) {
            $this->assertTrue(file_exists($this->tmpDir.'/'.$file), sprintf('%s has been generated', $file));
        }

        $files = array(
            'Resources/config/routing/post.yml',
            'Resources/config/routing/post.xml',
        );
        foreach ($files as $file) {
            $this->assertFalse(file_exists($this->tmpDir.'/'.$file), sprintf('%s has not been generated', $file));
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'namespace Foo\BarBundle\Controller;',
            'public function indexAction',
            'public function showAction',
            'public function newAction',
            'public function editAction',
            '@Route',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }
        // END

        $this->assertFilterAndPaginator();
    }

    public function testGenerateAnnotation()
    {
        // BEGIN: parent::testGenerateAnnotation();
        $this->getGenerator()->generate($this->getBundle(), 'Post', $this->getMetadata(), 'annotation', '/post', false, false);

        $files = array(
            'Controller/PostController.php',
            'Tests/Controller/PostControllerTest.php',
            'Resources/views/Post/index.html.twig',
            'Resources/views/Post/show.html.twig',
        );
        foreach ($files as $file) {
            $this->assertTrue(file_exists($this->tmpDir.'/'.$file), sprintf('%s has been generated', $file));
        }

        $files = array(
            'Resources/config/routing/post.yml',
            'Resources/config/routing/post.xml',
            'Resources/views/Post/new.html.twig',
            'Resources/views/Post/edit.html.twig',
        );
        foreach ($files as $file) {
            $this->assertFalse(file_exists($this->tmpDir.'/'.$file), sprintf('%s has not been generated', $file));
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'namespace Foo\BarBundle\Controller;',
            'public function indexAction',
            'public function showAction',
            '@Route',
        );
        foreach ($strings as $string) {
            $this->assertContains($string, $content);
        }

        $content = file_get_contents($this->tmpDir.'/Controller/PostController.php');
        $strings = array(
            'public function newAction',
            'public function editAction',
        );
        foreach ($strings as $string) {
            $this->assertNotContains($string, $content);
        }
        // END

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
    }
}
