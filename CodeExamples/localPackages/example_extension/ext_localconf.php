<?php

(function () {
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

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('
        mod {
            wizards {
                newContentElement {
                    wizardItems {
                        plugins {
                            elements {
                                address {
                                    iconIdentifier = content-marker
                                    title = Addresses
                                    description = Allows to List and edit addresses
                                    tt_content_defValues {
                                        CType = list
                                        list_type = exampleextension_address
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    ');
})();
