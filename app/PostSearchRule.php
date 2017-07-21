<?php

namespace App;

use ScoutElastic\SearchRule;

class PostSearchRule extends SearchRule
{
    public function buildQueryPayload()
    {
        $query = $this->builder->query;
        return [
            'should' => [
                [
                    'match' => [
                        'title' => [
                            'query' => $query,
                            'boost' => 3
                        ]
                    ]
                ],
                [
                    'match' => [
                        'author_name' => [
                            'query' => $query,
                            'boost' => 2
                        ]
                    ]
                ],
                [
                    'match' => [
                        'description' => [
                            'query' => $query,
                            'boost' => 1
                        ]
                    ]
                ]
            ]
        ];
    }
}
