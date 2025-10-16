<?php

return [

    'column_manager' => [

        'heading' => 'სვეტები',

        'actions' => [

            'apply' => [
                'label' => 'სვეტების გამოყენება',
            ],

            'reset' => [
                'label' => 'გადატვირთვა',
            ],

        ],

    ],

    'columns' => [

        'actions' => [
            'label' => 'მოქმედება|მოქმედებები',
        ],

        'select' => [

            'loading_message' => 'იტვირთება...',

            'no_search_results_message' => 'თქვენს ძიებას არ შეესაბამება ვერცერთი ვარიანტი.',

            'placeholder' => 'აირჩიეთ ვარიანტი',

            'searching_message' => 'ძიება...',

            'search_prompt' => 'დაიწყეთ აკრეფა ძიებისთვის...',

        ],

        'text' => [

            'actions' => [
                'collapse_list' => 'ნაკლების ჩვენება :count',
                'expand_list' => 'მეტის ჩვენება :count',
            ],

            'more_list_items' => 'და კიდევ :count',

        ],

    ],

    'fields' => [

        'bulk_select_page' => [
            'label' => 'ყველა ელემენტის მონიშვნა/მოხსნა ჯგუფური მოქმედებებისთვის.',
        ],

        'bulk_select_record' => [
            'label' => 'ელემენტის :key მონიშვნა/მოხსნა ჯგუფური მოქმედებებისთვის.',
        ],

        'bulk_select_group' => [
            'label' => 'ჯგუფის :title მონიშვნა/მოხსნა ჯგუფური მოქმედებებისთვის.',
        ],

        'search' => [
            'label' => 'ძიება',
            'placeholder' => 'ძიება',
            'indicator' => 'ძიება',
        ],

    ],

    'summary' => [

        'heading' => 'შეჯამება',

        'subheadings' => [
            'all' => 'ყველა :label',
            'group' => ':group შეჯამება',
            'page' => 'ეს გვერდი',
        ],

        'summarizers' => [

            'average' => [
                'label' => 'საშუალო',
            ],

            'count' => [
                'label' => 'რაოდენობა',
            ],

            'sum' => [
                'label' => 'ჯამი',
            ],

        ],

    ],

    'actions' => [

        'disable_reordering' => [
            'label' => 'ხელახალი დალაგების დასრულება',
        ],

        'enable_reordering' => [
            'label' => 'ჩანაწერების ხელახალი დალაგება',
        ],

        'filter' => [
            'label' => 'ფილტრი',
        ],

        'group' => [
            'label' => 'დაჯგუფება',
        ],

        'open_bulk_actions' => [
            'label' => 'ჯგუფური მოქმედებები',
        ],

        'column_manager' => [
            'label' => 'სვეტების მენეჯერი',
        ],

    ],

    'empty' => [

        'heading' => 'არ არის :model',

        'description' => 'შექმენით :model დასაწყებად.',

    ],

    'filters' => [

        'actions' => [

            'apply' => [
                'label' => 'ფილტრების გამოყენება',
            ],

            'remove' => [
                'label' => 'ფილტრის წაშლა',
            ],

            'remove_all' => [
                'label' => 'ყველა ფილტრის წაშლა',
                'tooltip' => 'ყველა ფილტრის წაშლა',
            ],

            'reset' => [
                'label' => 'გადატვირთვა',
            ],

        ],

        'heading' => 'ფილტრები',

        'indicator' => 'აქტიური ფილტრები',

        'multi_select' => [
            'placeholder' => 'ყველა',
        ],

        'select' => [

            'placeholder' => 'ყველა',

            'relationship' => [
                'empty_option_label' => 'არცერთი',
            ],

        ],

        'trashed' => [

            'label' => 'წაშლილი ჩანაწერები',

            'only_trashed' => 'მხოლოდ წაშლილი ჩანაწერები',

            'with_trashed' => 'წაშლილი ჩანაწერებით',

            'without_trashed' => 'წაშლილი ჩანაწერების გარეშე',

        ],

    ],

    'grouping' => [

        'fields' => [

            'group' => [
                'label' => 'დაჯგუფება',
            ],

            'direction' => [

                'label' => 'დაჯგუფების მიმართულება',

                'options' => [
                    'asc' => 'ზრდადი',
                    'desc' => 'კლებადი',
                ],

            ],

        ],

    ],

    'reorder_indicator' => 'გადაათრიეთ ჩანაწერები სასურველი თანამიმდევრობით.',

    'selection_indicator' => [

        'selected_count' => '1 ჩანაწერი მონიშნულია|:count ჩანაწერი მონიშნულია',

        'actions' => [

            'select_all' => [
                'label' => 'ყველას არჩევა :count',
            ],

            'deselect_all' => [
                'label' => 'ყველას მოხსნა',
            ],

        ],

    ],

    'sorting' => [

        'fields' => [

            'column' => [
                'label' => 'დალაგება',
            ],

            'direction' => [

                'label' => 'დალაგების მიმართულება',

                'options' => [
                    'asc' => 'ზრდადი',
                    'desc' => 'კლებადი',
                ],

            ],

        ],

    ],

    'default_model_label' => 'ჩანაწერი',

];
