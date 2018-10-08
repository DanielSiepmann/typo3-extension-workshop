Routing
=======

This section is related to TYPO3 v9.5.0 LTS, which introduces routing into the TYPO3
core.

See: https://docs.typo3.org/typo3cms/extensions/core/latest/Changelog/9.5/Feature-86365-RoutingEnhancersAndAspects.html

An example for the example extension looks like:

.. code-block:: yaml
   :linenos:

   routeEnhancers:
     ExamplePlugin:
       type: Extbase
       extension: ExampleExtension
       plugin: Address
       defaultController: 'Address::index'
       routes:
         -
           routePath: '/edit/{address}'
           _controller: 'Address::edit'
           _arguments:
             'address': 'address'
         -
           routePath: '/update'
           _controller: 'Address::update'
       aspects:
         address:
           type: PersistedPatternMapper
           tableName: 'tx_exampleextension_domain_model_address'
           routeFieldPattern: '^(?P<company_name>.+)-(?P<uid>\d+)$'
           routeFieldResult: '{company_name}-{uid}'

This defines two routed, one for edit and one for update. Also there is no cHash in
URls due to the configuration. The address is replaced by company name and uid within
the url.
