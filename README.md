DlcCategory
===================
A simple category module for Zend Framework 2 based applications.

This module is currently under heavy development.

## Introduction

Comming soon...

Requirements
------------
* [DlcBase](https://github.com/dlabas/DlcBase)
* [DlcDoctrine](https://github.com/dlabas/DlcDoctrine)
* [Doctrine2 NestedSet] (https://github.com/blt04/doctrine2-nestedset)

Installation
------------

## Main Setup

#### By cloning project

1. Install the [DlcBase](https://github.com/dlabas/DlcBase) and [DlcDoctrine](https://github.com/dlabas/DlcDoctrine) ZF2 modules
   by cloning it into `./vendor/`.
2. Clone this project into your `./vendor/` directory.
3. If not installed install [Doctrine2 NestedSet] (https://github.com/blt04/doctrine2-nestedset) module
   by cloning it into `./vendor/`. and adding autoloading for it. For more information see [Installing NestedSet for Doctrine2] (https://github.com/blt04/doctrine2-nestedset/blob/master/INSTALL.markdown).

#### With composer

Coming soon...

#### Post installation

1. Enabling it in your `application.config.php`file.

    ```php
    <?php
    return array(
        'modules' => array(
            // ...
            'DlcBase',
            'DlcDoctrine',
            'DlcCategory',
        ),
        // ...
    );

