Understand TYPO3 Plugins
========================

What happened until now?

We created an extension and a very basic plugin.

The plugin is created with two API calls and a Controller class with a single action
method.

What exactly are the API calls doing? And what does the PHP code in our Controller do
so far? Let's understand TYPO3!

TYPO3 Backend
-------------

The TYPO3 Backend needs to provide a new Plugin to the editor, this is done within
:file:`Configuration/TCA/Overrides/tt_content.php`.

The API configures the TCA (=Table Configuration Array) for ``tt_content``. And adds
the new plugin as ``list_type``.

We can go further on the content element during the Topic :ref:`configuration`,
especially :ref:`configuration-content-wizard`.

TYPO3 Frontend rendering
------------------------

Also we need to configure the handling of our plugin during the rendering of TYPO3
frontend. This is done within :file:`ext_localconf.php`.

The API configures TypoScript ``tt_content.list.20.<pluginSignature>`` to define
rendering of the new registered ``list_type``.

Extbase bootstrap will be started with extension and plugin name.
Also the configuration of callable controller actions and caching is stored in
``$GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['extbase']['extensions']``.

The controller
--------------

TypoScript will call Extbase, which will figure out to call the ``indexAction``
method of our ``AddressController``, thanks to our frontend rendering configuration.

The default action is always the first action of the first controller in the
configuration. Multiple actions will be shown later.

The Controller should extend the ``ActionController`` to work as expected out of the
box. Also all "actions" must have the suffix ``Action`` and need to be public.

As soon as an action returns a string, this will be the output. If nothing is
returned, which is ``null`` Extbase will try to find and render a template matching
our current controller and action. This is done at
``\TYPO3\CMS\Extbase\Mvc\Controller\ActionController::callActionMethod``.
