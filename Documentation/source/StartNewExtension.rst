Start new extension
===================

Necessary files
---------------

The only necessary file is :file:`ext_emconf.php`. This configures the *Extension
Manager*. Without this file, the Extension Manager would not recognize the extension
and would prevent installation.

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/ext_emconf.php
   :language: php

See :ref:`t3coreapi:extension-declaration` in TYPO3 Core API Reference.

.. admonition:: Task

   So let's create a new folder and add the file.

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
