Start new extension
===================

We will start with the simplest example ``Hello World``. Once we understood the
basics, we will create an "address" extension to manage a custom record.

Necessary files
---------------

Extensions consists of a folder and the single necessary file, which is
:file:`ext_emconf.php`. This configures the *Extension Manager*. Without this file,
the Extension Manager would not recognize the extension and would prevent
installation.

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/ext_emconf.php
   :language: php

See :ref:`t3coreapi:extension-declaration` in TYPO3 Core API Reference.

.. admonition:: Task

   So let's create a new folder and add the file within the folder.

In this example I'll use :file:`example_extension` as folder name.

Install extension
-----------------

Once we have created the first extension, we need to install the extension. There are
two ways for a local extension. Either placing the extension inside the installation,
or via composer.

.. admonition:: Task

   Install the new extension.

Oldschool
^^^^^^^^^

Copy the extension to :file:`typo3conf/ext/`, and head over to *Extension Manager* to
activate the extension.

Via Composer
^^^^^^^^^^^^

The following project setup is suggested:

.. code-block:: text

   .
   ├── composer.json
   └── localPackages
       └── example_extension

:file:`composer.json`:

.. literalinclude:: ../../CodeExamples/composer.json
   :language: json

In this case, we also need a :file:`composer.json` inside our extension, to make the
extension an composer package and allow the installation:

:file:`composer.json`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/composer.json
   :language: json

Thanks due ``typo3-console/composer-auto-commands`` our extension is activated already.

Autoloading
-----------

Using composer, TYPO3 does not do any special. The autoloading is provided by
composer and can be configured as documented by composer.

If you are not using composer, you should provide autoloading information inside
:file:`ext_emconf.php`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/ext_emconf.php
   :language: php
   :lines: 1-3,18-

There you can follow the composer autoloading configuration.

You can find the composer documentation about autoloading at https://getcomposer.org/doc/04-schema.md#autoload .
