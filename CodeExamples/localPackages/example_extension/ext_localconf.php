<?php

(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Workshop.ExampleExtension',
        'pluginkey',
        [
            'Example' => 'example'
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Workshop.ExampleExtension',
        'Address',
        [
            'Address' => 'index, edit, update'
        ],
        [
            'Address' => 'update'
        ]
    );
})();
