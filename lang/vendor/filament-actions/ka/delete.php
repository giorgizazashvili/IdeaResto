<?php

return [

    'single' => [

        'label' => 'წაშლა',

        'modal' => [

            'heading' => 'წაშლა :label',

            'actions' => [

                'delete' => [
                    'label' => 'წაშლა',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'წაშლილია',
            ],

        ],

    ],

    'multiple' => [

        'label' => 'მონიშნულის წაშლა',

        'modal' => [

            'heading' => 'მონიშნული :label-ის წაშლა',

            'actions' => [

                'delete' => [
                    'label' => 'წაშლა',
                ],

            ],

        ],

        'notifications' => [

            'deleted' => [
                'title' => 'წაშლილია',
            ],

            'deleted_partial' => [
                'title' => 'წაშლილია :count, :total-დან',
                'missing_authorization_failure_message' => 'თქვენ არ გაქვთ უფლება წაშალოთ :count.',
                'missing_processing_failure_message' => ':count ვერ წაიშალა.',
            ],

            'deleted_none' => [
                'title' => 'წაშლა ვერ მოხერხდა',
                'missing_authorization_failure_message' => 'თქვენ არ გაქვთ უფლება წაშალოთ :count.',
                'missing_processing_failure_message' => ':count ვერ წაიშალა.',
            ],

        ],

    ],

];
