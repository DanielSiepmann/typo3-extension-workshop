<?php

(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Workshop.ExampleExtension',
        'pluginkey',
        'Example Plugin'
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        'Workshop.ExampleExtension',
        'Address',
        'Address Plugin'
    );
})();
