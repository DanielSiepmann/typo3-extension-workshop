Extension
=========

First of all we have to understand what an extension is, in the context of TYPO3 CMS.

What is an extension?
---------------------

See :ref:`t3coreapi:extension-architecture` in TYPO3 Core API Reference.

TYPO3 is built only with extensions, there is no framework below. All features are
assigned to a specific extension. This way it's possible to build the TYPO3 that fits
the project needs.

An extension is something like `frontend` or `backend`, which provides the TYPO3
frontend or backend. It can also be `extbase` or `fluid` which provides and Framework
to build further extensions or an template engine.

Nowadays most installations also have a `site_` or `sitepackage` extensions, which
encapsulates the systems configuration and resources like assets and templates. Thus
an TYPO3 extension is the same as an composer package.

In this workshop we will concentrate on a "typical" extension that will provide a
plugin and custom record types. This can be installed into any compatible TYPO3
installation. A new record type will be added, which can be edited in the TYPO3
backend. Also a new plugin will be added which can be added as a content element and
displayed in frontend.

Structure of an extension
-------------------------

.. code-block:: plain

   extension_key
   ├── Classes
   │   ├── Command
   │   │   └── ExampleCommandController.php
   │   ├── Controller
   │   │   └── ExampleController.php
   │   └── Domain
   │       └── Model
   │           └── Example.php
   ├── composer.json
   ├── Configuration
   │   ├── TCA
   │   │   └── Overrides
   │   │       └── tt_content.php
   │   └── TypoScript
   │       ├── constants.typoscript
   │       └── setup.typoscript
   ├── Documentation
   ├── ext_conf_template.txt
   ├── ext_emconf.php
   ├── ext_localconf.php
   ├── ext_tables.php
   ├── readme.rst
   └── Resources
       └── Private
           └── Templates
               └── Search
                   └── Search.html

See :ref:`t3coreapi:extension-files-locations` in TYPO3 Core API Reference.

Further resources
-----------------

* https://extensions.typo3.org/about-extension-repository/what-are-extensions/

* :ref:`t3coreapi:extension-architecture` in TYPO3 Core API Reference.

* :ref:`t3coreapi:extension-files-locations` in TYPO3 Core API Reference.

* https://docs.typo3.org/typo3cms/ExtbaseFluidBook/Index.html
