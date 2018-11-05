.. _add-first-plugin:

Add first Plugin
================

Let's get dirty and start with some functionality.

Most extensions provide a *Plugin*, this is a functionality provided as content
element for TYPO3 CMS Frontend. Also *Modules* are available, that is functionality
in TYPO3 CMS Backend.

Also many more parts like *Signals and Slots* or *Hooks* are available. You can also
provide *HashAlgorithms* some *Logger* or *CacheBackends*, etc. TYPO3 CMS can be
extended in many areas.

Still Plugins are a very typical thing to bring in features to your website.

The Plugin
----------

As mentioned, we will start with a simple example plugin to display "Hello World".

Register Plugin in Backend
--------------------------

.. admonition:: Task

   Register a plugin in TYPO3 backend.

We first need to register the Plugin in the backend. This way it will become
available as a new option for the content element *Insert Plugin*.
This is done with the following code in file
:file:`Configuration/TCA/Overrides/tt_content.php`:

.. code-block:: php

   (function () {
       \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
           'Workshop.ExampleExtension',
           'pluginkey',
           'Example Plugin'
       );
   })();

Configure Plugin for Frontend
-----------------------------

.. admonition:: Task

   Configure a plugin for TYPO3 frontend.

To actually call some PHP Code when the content element is rendered, we need to
configure the plugin in :file:`ext_localconf.php`:

.. code-block:: php

   (function () {
      \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
         'Workshop.ExampleExtension',
         'pluginkey',
         [
               'Example' => 'example'
         ]
      );
   })();


Write necessary Code
--------------------

.. admonition:: Task

   Remove all PHP Errors, step by step.

If we insert the plugin as content element and open the site, we should see an error
message. This message is not helpful, so we will switch to development context within
the installation / maintenance tool. Also we will add the following TypoScript setup
for our local development instance:

.. code-block:: typoscript

   config.contentObjectExceptionHandler = 0

Afterwards we should see the following error message:

   Could not analyse class: "Workshop\\ExampleExtension\\Controller\\ExampleController" maybe not loaded or no autoloader? Class Workshop\\ExampleExtension\\Controller\\ExampleController does not exist 

This tells us that everything so far has worked as expected. TYPO3 tries to call our
*ExampleController*, which just does not exist yet.

So let's create the controller with the following code in
:file:`Classes/Controller/ExampleController.php`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Controller/ExampleController.php
   :language: php
   :lines: 1-27,36

The error message should change to:

    An action "exampleAction" does not exist in controller "Workshop\\ExampleExtension\\Controller\\ExampleController".

Yeah, we fixed the error to get the next one. Even if our class exists, the
configured default action does not exist yet, so let's create it.

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Controller/ExampleController.php
   :language: php
   :lines: 26-29,34-

We now should see "Hello world!" in our frontend.

We just created our first plugin.
