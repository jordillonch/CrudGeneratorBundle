# CrudGeneratorBundle

This Symfony2 bundle aims to be the bundle that you are looking for create a nice CRUD with pagination, filter, translation and Twitter bootstrap 2.2.2 features.

This bundle is inspired in an article wrote by Ricard Clau: [Extending SensioGeneratorBundle for our Admin Areas](http://www.ricardclau.com/2012/03/extending-sensiogeneratorbundle-for-our-admin-areas/)

[![Build Status](https://secure.travis-ci.org/jordillonch/CrudGeneratorBundle.png?branch=master)](http://travis-ci.org/jordillonch/CrudGeneratorBundle)


## Screenshot

![Screenshot](https://raw.github.com/jordillonch/CrudGeneratorBundle/master/screenshot.png "Screenshot")

## Why use a CRUD generator?

Well, because CRUD generator creates simple code, no magic, no configuration files, just simple and plain code that you can extend and modify easily.


## Installation

### Using composer

Add following lines to your `composer.json` file:

#### Symfony 2.5

    "require": {
      ...
      "jordillonch/crud-generator": "dev-master"
    },

#### Symfony 2.4

    "require": {
      ...
      "jordillonch/crud-generator": "2.4.*"
    },

#### Symfony 2.3

    "require": {
      ...
      "jordillonch/crud-generator": "2.3.*"
    },

#### Symfony 2.2

    "require": {
      ...
      "jordillonch/crud-generator": "2.2.*"
    },
    "minimum-stability": "dev",

#### Symfony 2.1

    "require": {
      ...
      "jordillonch/crud-generator": "2.1.*"
    },
    "minimum-stability": "dev",

Execute:

    php composer.phar update

Add it to the `AppKernel.php` class:

    new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
    new JordiLlonch\Bundle\CrudGeneratorBundle\JordiLlonchCrudGeneratorBundle(),

Add it to your `app/config/config.yml`

    framework:
        translator: { fallback: en }

    twig:
        form:
            resources:
                - LexikFormFilterBundle:Form:form_div_layout.html.twig

**This bundle works on Symfony 2.1, 2.2, 2.3, 2.4 and 2.5 version.**


## Dependencies

This bundle extends [SensioGeneratorBundle](https://github.com/sensio/SensioGeneratorBundle) and add a paginator using [PagerFanta](https://github.com/whiteoctober/Pagerfanta/) and filter
support using [LexikFormFilterBundle](https://github.com/lexik/LexikFormFilterBundle).

## Usage

Use following command from console:

    app/console jordillonch:generate:crud

As you will see there is no config file. You will generate a CRUD code with all fields from your entity. But after code generation you
are free to modify the code because there is no magic just a simple code that is very easy to understand.

You have to know that if you reuse the command to recreate same entity, first you must delete controller and form files
from previous generation.

## Author

Jordi Llonch - llonch.jordi at gmail dot com

### Translation support

Gonzalo Alonso - gonkpo at gmail dot com

## License

CrudGeneratorBundle is licensed under the MIT License. See the LICENSE file for full details.