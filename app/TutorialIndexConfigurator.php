<?php

namespace App;

use ScoutElastic\IndexConfigurator;

class TutorialIndexConfigurator extends IndexConfigurator
{
    //
    // It's not obligatory to determine name. By default it'll be a snaked class name without `IndexConfigurator` part.
    protected $name = 'laravel-elasticsearch';

    // You can specify any settings you want, for example, analyzers.
    protected $settings = [
        'analysis' => [
            'analyzer' => [
                'es_std' => [
                    'type' => 'standard',
                    'stopwords' => '_spanish_'
                ]
            ]
        ]
    ];

    // Common mapping for all types.
    protected $defaultMapping = [
        '_all' => [
            'enabled' => true
        ],
        'dynamic_templates' => [
            [
                'es' => [
                    'match' => '*_es',
                    'match_mapping_type' => 'string',
                    'mapping' => [
                        'type' => 'string',
                        'analyzer' => 'es_std'
                    ]
                ]
            ]
        ]
    ];
}