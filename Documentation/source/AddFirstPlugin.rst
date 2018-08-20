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

We will start with a very basic plugin that will only list some TYPO3 records, e.g.
`fe_users`.

Register Plugin in Backend
--------------------------

.. admonition:: Task

   Register a plugin in TYPO3 backend.

We first need to register the Plugin in the backend. This way it will become
available as a new option for the content element *Insert Plugin*.
This is done with the following code in file
:file:`Configuration/TCA/Overrides/tt_content.php`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Configuration/TCA/Overrides/tt_content.php
   :language: php

Configure Plugin for Frontend
-----------------------------

.. admonition:: Task

   Configure a plugin for TYPO3 frontend.

To actually call some PHP Code when the content element is rendered, we need to
configure the plugin in :file:`ext_localconf.php`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/ext_localconf.php
   :language: php

Write necessary Code
--------------------

.. admonition:: Task

   Remove all PHP Errors, step by step.

If we insert the plugin as content element and open the site, we should see the
following error message:

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
