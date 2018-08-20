<?php

(function () {
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Workshop.ExampleExtension',
        'pluginkey',
        [
            'Example' => 'example'
        ]
    );
})();
