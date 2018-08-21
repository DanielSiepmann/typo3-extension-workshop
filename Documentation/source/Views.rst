Views
=====

So far we only have our "Hello world!" output hardcoded in our PHP Code.
That's not helpful, so let's introduce Views with Fluid.

Fluid
-----

Fluid is the TYPO3 Template engine. Nowadays it's standalone, but was developed for
and by TYPO3.

It follows XML / HTML which should make it easier to get started.

Fluid templates are valid HTML and custom tags, called ViewHelpers, are introduced to
bring in logic.

Convention over configuration
-----------------------------

Extbase follows the principle "Convention over configuration", which we already saw
with our Controller. We didn't configure the path or class name, it just follows a
convention.

Same is true for the output of plugins. If "something" is returned, this will be the
output. If nothing is returned, Extbase will call Fluid to render a Fluid template.

Paths
-----

The path to the template of an controller action is
:file:`example_extension/Resources/Private/Templates/ControllerName/ActionName.html`,
which in our example would be: :file:`example_extension/Resources/Private/Templates/Example/Example.html`,

.. admonition:: Task

   Move the output to a fluid template, following Extbase conventions.

So let's create the file and move the "Hello world!" to this file. We should make a
small change, otherwise we will not see whether our change has worked. E.g. make the
"w" uppercase "W".

Do not forget to remote the ``return 'Hello world!';`` from our controller.

We should now see our "Hello World!".

Sections
--------

ViewHelper
----------

Partials and Layouts
--------------------

Configuration
-------------

Awesome, we now do no longer need to touch PHP code to change the output, we can use
Fluid and an Integrator or Frontendler is able to change something.

But they should be able to change template ins their own extension, e.g. a
"sitepackage". Let's take a look how this works.

Further resources
-----------------

* https://github.com/TYPO3/Fluid

* https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Fluidtemplate/Index.html

* https://docs.typo3.org/typo3cms/ExtbaseFluidBook/Index.html
