<?php
return [
    'users' => [
        [
            'name' => 'Vasya',
            'email' => 'superadmin@gmail.com',
            'password' => '11111111',
        ],
        [
            'name' => 'Petya',
            'email' => 'admin@gmail.com',
            'password' => '22222222',
        ],
        [
            'name' => 'Grisha',
            'email' => 'redactor@gmail.com',
            'password' => '33333333',
        ],
    ],

    'roles_permissions' => [
        'super_admin' => [
            'give_comment',
            'delete_comment',
            'publish_article',
            'redaction_article',
            'delete_article',
            'redaction_article_users',
            'approve_article_users',
            'delete_article_users',
            'subscribe_new_users',
            'assign_redactor',
            'delete_redactor',
            'assign_admin',
            'delete_admin',
        ],
        'admin' => [
            'give_comment',
            'delete_comment',
            'publish_article',
            'redaction_article',
            'delete_article',
            'redaction_article_users',
            'approve_article_users',
            'delete_article_users',
            'subscribe_new_users',
            'assign_redactor',
            'delete_redactor'

        ],
        'redactor' => [
            'give_comment',
            'publish_article',
            'redaction_own_article',
            'delete_own_article',
            'redaction_article_subscribed_users',
            'approve_article_subscribed_users',
            'delete_article_subscribed_users',
        ],
        'user' => [
            'give_comment',
            'publish_article',
            'redaction_own_article',
            'delete_own_article'
        ]
    ],

    'assignments' => [
        'super_admin' => [
            'superadmin@gmail.com'
        ],
        'admin' => [
            'admin@gmail.com'
        ],
        'redactor' => [
            'redactor@gmail.com'
        ]
    ]
];
