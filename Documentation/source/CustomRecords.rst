Custom records
==============

The basics are behind us, now let's get deeper into the system and create a new
record type, like ``tt_address`` which can be displayed through our plugin.

TCA
---

.. admonition:: Task

   Create necessary TCA for our new record.

Before we can do anything with Extbase, we need to configure TYPO3. The TCA (=Table
Configuration Array) contains configuration for each database table. TYPO3 will
generate the list view and edit forms from this configuration.

Extbase uses this configuration for mapping and database queries, together with
relation handling.

TYPO3 provides a rich documentation about the TCA at
https://docs.typo3.org/typo3cms/TCAReference/. That's why this section is empty, all
information are available there.

One thing to notice is that Extbase uses "Convention over Configuration". While we
can configure Extbase to map a Model to a specific database table, we can auto match
them. For a Model ``Workshop\ExampleExtension\Domain\Model\Address``, the database
table would be ``tx_exampleextension_domain_model_address``. So this will be
our database table name for our example.

Also each property within the model is written lowerCamelCase, while the database
columns are written snake_case.

Our new record will be an address record with the following fields:

* Company Name

* Street

* House number

* Zip

* City

* Country

.. note::

   By default new records are only allowed on pages of type "Folder".

ext_tables.sql
--------------

.. admonition:: Task

   Create necessary sql for our new record.

.. admonition:: Task

   Create some records, edit them, play around.

Once the TCA is provided, we need to create the table in our Database.
Each extension can provide a :file:`ext_tables.sql` in the root directory. Within the
install tool and TYPO3 Console, you can update the database schema to match the
current necessary structure of all extensions.

If multiple extensions adjust the same field, the last one in load order is used.

The example :file:`ext_tables.sql` is:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/ext_tables.sql
   :language: sql

Model
-----

.. admonition:: Task

   Create Model representing our records.

Once we are able to create and edit records in TYPO3 backend, we are ready to go with
Extbase. First we need a representation of our Data. This is done with a Model, in
our case this has to match the table name and is called
``Workshop\ExampleExtension\Domain\Model\Address`` and located at
:file:`Classes/Domain/Model/Address.php`.

Each model is a PHP class structure like:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Domain/Model/Address.php
   :language: php
   :linenos:
   :lines: 1-4,24-32,63-66,87

Repository
----------

.. admonition:: Task

   Create Repository to access records.

In order to get, update or delete our records, we need a repository. This will return
the models for us. The repository is another class which can be completely empty:

The file is located at :file:`Classes/Domain/Repository/AddressRepository.php`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Domain/Repository/AddressRepository.php
   :language: php
   :linenos:
   :lines: 1-4, 24-

The parent class already provides all necessary methods for daily use cases.

Controller
----------

.. admonition:: Task

   Provide available records to template.

In order to provide records in form of models to our template, we first need an
instance of our repository:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Controller/AddressController.php
   :language: php
   :linenos:
   :lines: 1-4, 24-38,66

With the above code we only can create instances of the controller if an instance of
the Repository is provided.

Extbase itself will analyse dependencies inside ``__construct`` and will provide
instances. This is called Dependency Injection and works in three different ways with
Extbase. The above one is the preferred as this is not Extbase specific but will also
work in other PHP Frameworks and without any Dependency Injection at all.

We then can call the accordingly method to fetch records, which then can be assigned
to the view:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Classes/Controller/AddressController.php
   :language: php
   :linenos:
   :lines: 28-29,40-43,66

The ``AddressRepository`` extends the base ``Repository`` class and inherits some
methods, e.g. ``findAll``.

Template
--------

With our records in our template, we can iterate over them to display them.

:file:`Resources/Private/Templates/Address/Index.html`:

.. literalinclude:: ../../CodeExamples/localPackages/example_extension/Resources/Private/Templates/Address/Index.html
   :language: html
   :linenos:
   :lines: 1-7,10

Configure storage pid
---------------------

We should not see any addresses yet, that’s due to the generated database query by
Extbase. If no storage pid is configured, Extbase will fetch records from pid 0.

Within the content element we can select arbitrary "Record Storage Page" entries to
use for records.

We could also configure the pid via TypoScript:

.. code-block:: typoscript
   :linenos:

   plugin {
       tx_exampleextension {
           persistence {
               storagePid = 2
           }
       }
   }

