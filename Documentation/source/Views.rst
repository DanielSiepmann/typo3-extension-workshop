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

Configuration
-------------

Awesome, we now do no longer need to touch PHP code to change the output, we can use
Fluid and an Integrator or Frontendler is able to change something.

But they should be able to change templates in their own extension, e.g. a
"sitepackage". We will see how to do this in next chapter "Configuration".

Sections
--------

If templates grow in size, we need to add some structure. One way is to use sections
inside a single Template. A section is like a PHP method or function and can be
called with arguments:

.. code-block:: html
   :linenos:

   Normal output

   {f:render(
      section: 'FirstSection',
      arguments: {
         arg1: var1,
         arg2: var2,
         arg3: 'string'
      }
   )}

   <f:section name="FirstSection">
      Some output + {arg1}.
   </f:section>

We have our default output "Normal output" and call a ViewHelper ``f:render`` with
some arguments to render a specific section with some arguments. The ViewHelper will
be replaced with the rendered result of the section.

This way it's possible to structure templates like Controllers. They control the
output flow and call different sections with arguments where more specific logic
happens.

Variables
---------

Variables are assigned via PHP:

.. code-block:: php
   :linenos:

   // Inside a controller action do:
   $this->view->assign('var1', $variable1);
   $this->view->assign('var2', $variable2);

   // Or to assign multiple variables at once:
   $this->view->assignMultiple([
       'var1' => $variable1
       'var2' => $variable2
   ]);

Assigned variables can be accessed inside Fluid with curly braces:

.. code-block:: html
   :linenos:

   Hello {userInput}!

ViewHelper
----------

To make Templates more flexible, ViewHelpers are available. They are custom HTML-Tags
available inside via template engine.
TYPO3 and Fluid already ship some ViewHelpers, but you can provide own ViewHelpers.

ViewHelpers always live in a Namespace, e.g. ``TYPO3\CMS\Fluid\ViewHelpers`` or
``Workshop\\ExampleExtension\\ViewHelpers``.

You can either register these namespaces globally, or inside the templates via
``{namespace wee=Workshop\ExampleExtension\ViewHelpers}``.
The ``f`` namespace for ``Fluid`` is always registered globally.

Once ViewHelpers are available available, you can use them:

.. code-block:: html

   <f:format.crop maxCharacters="5">Hello World!</f:format.crop>

The above should output "Hello ...", as the string is cropped to 5 characters, the
"..." can be configured via another argument of the ViewHelper:

.. code-block:: html

   <f:format.crop maxCharacters="5" append="">Hello World!</f:format.crop>

Beside the tag based kind of inserting ViewHelpers, you can also use the "inline
notation":

.. code-block:: html
   :linenos:

   {f:format.date(date: 'now')}

It's also possible to chain ViewHelpers in both ways:

.. code-block:: html
   :linenos:

   {f:format.date(date: 'now') -> f:format.raw()}

   <f:format.raw>
      {f:format.date(date: 'now')}
   </f:format.raw>

   <f:format.raw>
      <f:format.date date="midnight" />
   </f:format.raw>

   <f:format.raw>
      <f:format.date>midnight</f:format.date>
   </f:format.raw>

Partials and Layouts
--------------------

We already saw sections to make a single template easier to manage.
For re-using parts between multiple templates there are Partials.

Partials are like Templates and can be rendered via:

.. code-block:: html
   :linenos:

   Normal output

   {f:render(
      partial: 'Path/To/Partial',
      arguments: {
         arg1: var1,
         arg2: var2,
         arg3: 'string'
      }
   )}


Also each template can be embedded into a Layout via:

.. code-block:: html
   :linenos:

   <f:layout name="Layout/Path/AndName" />

This way wrapping code, e.g. for HTML E-Mails or content elements can be moved to a
layout and all templates can inherit this layout.

Further resources
-----------------

.. hint::

   Use ViewHelpers for output logic, not to get data into your View.

   Use Controller and DataProcessing to prepare data.

* Available ViewHelpers can be found at:

  * :file:`typo3/sysext/fluid/Classes/ViewHelpers/`

  * :file:`vendor/typo3fluid/src/ViewHelpers/`

* https://github.com/TYPO3/Fluid

* https://docs.typo3.org/typo3cms/TyposcriptReference/ContentObjects/Fluidtemplate/Index.html

* https://docs.typo3.org/typo3cms/ExtbaseFluidBook/Index.html
