<?php

return [
    'industryAryList' => [
        'healthcare'    => 'Healthcare',
        'finance'       => 'Finance',
        'education'     => 'Education',
        'retail'        => 'Retail',
        'manufacturing' => 'Manufacturing',
        'technology'    => 'Technology',
        'ecommerce'     => 'Ecommerce',
    ],

    'package_display_names' => [
        'admin/pages'   => 'Page Manager',
        'admin/emails'  => 'Email Manager',
        'admin/faqs'    => 'Faq Manager',
        'admin/settings'=> 'General Setting Manager',
        'admin/banners' => 'Banner Manager',
    ],

    'industry_packages' => [
        'healthcare' => [
            'admin/pages',
            'admin/emails',
            'admin/settings',
            'admin/banners',
        ],
        'finance' => [
            'admin/faqs',
            'admin/emails',
        ],
        'education' => [
            'admin/pages',
            'admin/faqs',
            'admin/settings'
        ],
        'retail' => [
            'admin/pages',
            'admin/faqs',
            'admin/banners',
        ],
        'manufacturing' => [
            'admin/emails',
            'admin/pages',
            'admin/faqs',
        ],
        'technology' => [
            'admin/pages',
            'admin/faqs',
            'admin/settings'
        ],
        'ecommerce' => [
            'admin/pages',
            'admin/faqs',
            'admin/settings',
            'admin/emails',
            'admin/banners',
        ],
    ],
    'package_info' => [
        'admin/emails' => [
            'description' => 'Manage and configure email templates used across the system for various notifications and communications.',
        ],
        'admin/faqs' => [
            'description' => 'Add, edit, or remove frequently asked questions to help users quickly find answers to common queries.',
        ],
        'admin/pages' => [
            'description' => 'Create and manage static content pages (e.g., About Us, Terms & Conditions) to keep the site content updated and organized.',
        ],
        'admin/settings' => [
            'description' => 'Configure general system settings, preferences, and options to customize the application’s behavior and appearance.',
        ],
        'admin/banners' => [
            'description' => 'Manage promotional banners and visual advertisements displayed throughout the site to enhance marketing and user engagement.',
        ],
    ],

];