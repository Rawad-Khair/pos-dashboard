<?php

return [
    'role_structure' => [
        'boss' => [
            'categories' => 'c,r,u,d',
            'users' => 'c,r,u,d',
            'products' => 'c,r,u,d',
            'clients' => 'c,r,u,d',
        ],
        'admin' => [
            
        ],
        'normal' => [
        ],
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete'
    ]
];
