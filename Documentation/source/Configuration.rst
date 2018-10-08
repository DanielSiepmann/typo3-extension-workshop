.. _configuration:

Configuration
=============

There are many different ways and places in TYPO3 for configuration. We will cover
the different places and types of configuration, including when to use a certain way.

By following the API you also make sure modern approaches like configuration loaders
will work with your extensions.

Places of configuration
-----------------------

The following places exist to configure a TYPO3 Extensions:

PHP
^^^

PHP via :file:`LocalConfiguration.php` and :file:`AdditionalConfiguration.php`.

Some extensions allow to place configuration in custom files, e.g. EXT:realurl. I
would call that a bad practice as you have arbitrary places to check for certain
configurations.

Instead use existing places like the two mentioned files above. This is done by
either using:

.. code-block:: php

   return [
       'EXTCONF' => [
           'extkey' => [
               // options
           ],
       ],
   ];

This way you can access the configuration via ``$GLOBALS['EXTCONF']['extkey']``.

Or by providing a :file:`ext_conf_template.txt` in the root of your Extension.
The content is TypoScript as documented at :ref:`t3coreapi:extension-options`.
Afterwards you can access the options through an API.

TypoScript
^^^^^^^^^^

TypoScript and Flexforms are merged by Extbase, so you do not have to do any
additional work and combine both. They are available as Variable ``{settings}`` in
all templates. Also inside the Controller they are available as array in
``$this->settings`` out of the box.

.. admonition:: Task

   Add some settings and print them in template and controller.

The configuration via TypoScript has to be located at a specific path:

.. code-block:: typoscript
   :linenos:

   // For all frontend plugins of the extension
   plugin {
       tx_exampleextension {
           settings {
               // The configuration goes here
           }
       }
   }

   // For a specific frontend plugin of the extension
   plugin {
       tx_exampleextension_pluginkey {
           settings {
               // The configuration goes here
           }
       }
   }

   // For Backend Modules
   module {
       tx_exampleextension {
           settings {
               // The configuration goes here
           }
       }
   }

Extbase itself already has some configuration options available via TypoScript, some
are mentioned at :ref:`t3extbasebook:typoscript_configuration` section of Extbase
book.

.. tip::

   The whole ``settings`` array is passed into all templates, layouts and partials.
   This way it's possible for integrators to provide arbitary information.

   E.g. introduce a new namespace::

      plugin {
          tx_exampleextension {
              settings {
                  codappix {
                      pageUids {
                          detail = {$pageUids.exampleextension.detail}
                      }
                  }
              }
          }
      }

Also it's possible to insert a plugin via TypoScript. In that case the settings can
be provided only for that instance:

.. code-block:: typoscript
   :linenos:

   lib.instance = USER
   lib.instance {
       userFunc = TYPO3\CMS\Extbase\Core\Bootstrap->run
       extensionName = ExampleExtension
       pluginName = pluginkey
       vendorName = Workshop
       settings {
           testKey = testValue
       }
   }

Flexforms
^^^^^^^^^

Flexforms are like TCA, which will be covered at :ref:`custom-records-tca` section of
:ref:`custom-records`. The format is XML instead of PHP and saved inside the database
field ``pi_flexform`` of the ``tt_content`` record.  This way editors are able to
adjust provided settings within a plugin record.

Custom
^^^^^^

Do whatever you want, e.g. use yaml or TypoScript by calling the parser for contents
from anywhere.

When to use which
-----------------

The Flexform approach provides the best UX as it uses the known UI of TYPO3 inside a
record. It should be used if the setting is plugin instance related.

The TypoScript provided the best UX when integrators have to deploy configuration or
configuration is necessary on multiple pages. Also if the plugin is inserted directly
via TypoScript.

The PHP approach is best suited for instance wide configuration, which nearly never
exists. Things like API Keys might depend on the current Domain or Website, and there
can be multiple in a single TYPO3 instance.

.. _configuration-content-wizard:

Adding Content Wizard for our Plugin
------------------------------------

So far we do not have any configuration. But we can use PageTSConfig to make live
easier for editors.

Right now an editor has to insert a new "Insert Plugin" content record and choose our
plugin. We can provide a Configuration to make our Plugin available via the "Create
new content element" wizard.

.. admonition:: Task

   Add the new Plugin to content element wizard.

Within :file:`ext_localconf.php` we add the following::

   \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
       mod {
           wizards {
               newContentElement {
                   wizardItems {
                       plugins {
                           elements {
                               exampleElement {
                                   iconIdentifier = content-coffee
                                   title = Example title
                                   description = Example Description
                                   tt_content_defValues {
                                       CType = list
                                       list_type = exampleextension_pluginkey
                                   }
                               }
                           }
                       }
                   }
               }
           }
       }
   ');

This will add the given PageTS as default to global configuration. Within the TS we
define a new element ``exampleElement`` with icon, title and description. The important
part is, that we can define default values (``defValues``) for the creation. This way
we can pre select the plugin.

See: https://docs.typo3.org/typo3cms/TSconfigReference/PageTsconfig/Mod.html#wizards

.. _configuration-view-paths:

Adjusting view paths
--------------------

In :ref:`views` we covered the conventions for paths. However sometimes you need to
change these paths. E.g. if you exchange a Partial or template.

This can be done via TypoScript, the same way as for ``FLUIDTEMPLATE`` cObject:

.. code-block:: typoscript
   :linenos:

   plugin {
       tx_exampleextension {
           view {
               templateRootPaths {
                   10 = EXT:sitepackage/Resources/Plugins/ExampleExtension/Templates/
               }
           }
       }
   }

See: https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Fluidtemplate/Index.html
