.. highlight:: php

Updating records
================

For everything we have done so far, you do not need a plugin at all. Custom records
only need :file:`ext_tables.sql` the TCA and TypoScript for rendering.

Extbase is needed if you provide interaction to the user, e.g. updating or adding
records.

Even that can nowadays be achieved using the system extension "Form". Still we will
cover how to update a record next.

We need a form where we can adjust the values of the record, e.g. change the
company name.

Therefore we will add a new ``editAction()``. This will receive a single ``Address``
for editing and provides the form. We also add an ``updateAction()`` which receives a
single ``Address``. This action is the target of the submit form and will update the
database record.

To start editing an address, we will add an link from :file:`index.html` to
``editAction()``.

Link to another action
----------------------

.. admonition:: Task

   Create a link to the ``editAction()`` providing the "current" Address record.

TYPO3 provides ViewHelpers to create links to different actions. To insert a Link to
edit a record, you could use the following:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Resources/Private/Templates/Address/Index.html
   :language: html
   :linenos:
   :dedent: 4
   :lines: 9

The ViewHelper generates a link, thanks to the current plugin context, all arguments
are prefixed with the plugin namespace.

Creating Forms
--------------

.. admonition:: Task

   Create a form which will show the current values of a single ``Address`` to the
   user.

TYPO3 also provides ViewHelpers to create forms. Of course you could create forms with
pure HTML, but TYPO3 / Fluid adds some security aspects and makes things easier.

E.g. a proper validation that forms were not manipulated are added out of the box.
Also you do not need to take care of proper names of the inputs to allow Extbase to
map incoming inputs.

A basic form looks like:

.. code-block:: html
   :linenos:

   <f:form action="update" object="{address}" name="address">
       <f:form.textfield property="companyName" />
       <f:form.submit value="Update" />
   </f:form>

Persistence
-----------

.. admonition:: Task

   Save changes to database.

Once the user submits the form, the ``updateAction()`` method within our controller is
called. We therefore have to implement this method and to persist the changes that
were submitted.

We already have an instance of the accordingly repository within our controller. We
also receive the modified object as an argument within our action. All we have to do
is to update the record within the repository::

   public function updateAction(Address $address)
   {
       $this->addressRepository->update($address);
   }

At the end of the "request", Extbase will cleanup everything and persist the updates
to the backend, which in our case is MySQL.

Redirect
--------

.. admonition:: Task

   Redirect back to index.

All our changes are already saved to database, but the user receives an error that no
template could be found. We actually do not need any template for our
``updateAction()``. Instead we will redirect the user back to the ``indexAction()``.
This way he can check whether the change has effected the output and works as
expected.

.. note::

   Following REST, an update returns the updated resource, which is the uri to the
   resource, in our case the redirect.

   As Browsers do not support ``PATCH``, which would be the request method, we use
   ``POST``, see: https://en.wikipedia.org/wiki/Representational_state_transfer#Relationship_between_URL_and_HTTP_methods

As we extend ``ActionController`` we can use the following line to redirect to
another action::

   $this->redirect('index');

Cache clearing
--------------

Even if the user is redirected, he does not see any difference. That's due to TYPO3
caching.

.. admonition:: Task

   Make changes visible in index action.

Extbase, by default, clears the cache for all updated records. Therefore the page
cache for the pages holding the records is cleared. As our plugin resists on a
different page, we have to configure TYPO3.

Same is true for plain TYPO3 Backend. As soon as a record is edited, the page cache
is cleared. If this record is displayed on another page, the caching has to be
configured, so this is not Extbase specific.

The caching can be configured using Page TS Config:

.. code-block:: typoscript

   TCEMAIN {
       clearCacheCmd = 1
   }

See: https://docs.typo3.org/typo3cms/TSconfigReference/PageTsconfig/TceMain.html#clearcachecmd

Flash message
-------------

.. admonition:: Task

   Inform user about what happened.

We now have a fully working process. Still in a long list of records, the user might
not notice a difference. Also if he leaves the computer and comes back, he will not
know what was done before.

Extbase has a feature called "Flashmessages" which are also used within TYPO3
Backend. They inform a user on next page about some thing that happened during
the last request. We could use that to add a message about which record was updated.
This is also just one line within a controller::

   $this->addFlashMessage(
       $address->getCompanyName() . ' was updated.',
       'Update successfully'
   );

Validation
----------

.. admonition:: Task

   Prevent invalid data.

Up till now, the user could provide any text into any property. There was no
validation whether a zip is actual valid.

Adding this is done within either the model, or the controller.

Within Controller
^^^^^^^^^^^^^^^^^

Sparely used, this makes sense if you do not use models at all or use the same model
with different validation rules.

The process is the same as within a model, just the annotations are added to the
PHPDoc of the corresponding action.

We will not cover this, instead we use validation within model.

Within Model
^^^^^^^^^^^^

Each property already has a type annotation::

   /**
    * @var string
    */

By adding one, or multiple, ``@validate`` annotations, these properties get
validated::

   /**
    * @var string
    * @validate NotEmpty
    */

Extbase provides some validators our of the box, all available within ``typo3/sysext/extbase/Classes/Validation/Validator``:

* AlphanumericValidator
* EmailAddressValidator
* NotEmptyValidator
* NumberRangeValidator
* RawValidator
* RegularExpressionValidator
* StringLengthValidator
* TextValidator

Also validators for PHP Type like ``String`` or ``DateTime`` are provided which are
auto added based on ``@var`` annotation.

Let's say a zip only consists of integers and is exactly 5 integers long, like in
Germany. One or more leading 0 are allowed, we therefore will not use the PHP type
``integer`` but ``string``. A possible validation might look like::

   /**
    * @var string
    * @validate RegularExpression(regularExpression = '/^[0-9]{5}$/')
    */
   protected $zip;

Also see: https://docs.typo3.org/typo3cms/extensions/core/Changelog/9.3/Feature-83167-ReplaceValidateWithTYPO3CMSExtbaseAnnotationValidate.html

Display validation errors
-------------------------

Nearly finished, we can no longer save invalid records. Still the user does not get
any information about what's wrong. Fluid by default will add the css class
``f3-form-error`` to all inputs with an error. So one could style this css class:

.. code-block:: css

   .f3-form-error {
       border: solid 5px #cd2323;
   }

This way at least it's clear which fields fail, but not why. We therefore use another
ViewHelper to add the validation errors to each field. As we have to add the same
markup for each field, we will put it into a section for re-use. On larger projects
this might be a Partial:

.. code-block:: html
   :linenos:

   <f:section name="FieldErrors">
       <f:form.validationResults for="{propertyPath}">
           <f:for each="{validationResults.flattenedErrors}" as="errors">
               <f:for each="{errors}" as="error">
                   <li>{error.code}: {error}</li>
               </f:for>
           </f:for>
       </f:form.validationResults>
   </f:section>

This section can be used like:

.. code-block:: html
   :linenos:

   <f:form.textfield property="companyName" />
   {f:render(section: 'FieldErrors', arguments: {
       propertyPath: 'address.companyName'
   })}

Handling existing invalid records
---------------------------------

In some circumstances your system might have an invalid record. Right now it's not
possible to edit this record with ``editAction()`` as Extbase will validate the
record.

Therefore the ``@ignorevalidation`` annotation can be added to the action::

    /**
     * @ignorevalidation $address
     */
    public function editAction(Address $address)
    {
        $this->view->assign('address', $address);
    }

This way Extbase will ignore raised validation issues and we are ready to go to edit
the record.
