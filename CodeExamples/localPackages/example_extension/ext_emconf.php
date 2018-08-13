<?php

$EM_CONF['example_extension'] = [
    'title' => 'Example extension',
    'description' => 'Example for TYPO3 Extension Workshop.',
    'category' => 'example',
    'version' => '1.0.0',
    'state' => 'stable',
    'author' => 'Daniel Siepmann',
    'author_email' => 'coding@daniel-siepmann.de',
    'author_company' => 'Codappix',
    'constraints' => [
        'depends' => [
            'typo3' => '8.7.0-8.7.999',
            'php' => '7.0.0-7.2.999',
        ],
    ],
];
