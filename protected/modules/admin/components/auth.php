<?php
return array(
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Авторизованный',
        'bizRule' => null,
        'data' => null
    ),
    'role_assort' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к ассортименту',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_kadr' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к вакансиям',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_guestbook' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к гостевой книге',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_news' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к новостям',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_nabors' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к наборам Миадолла',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_manager2' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к ассортименту, гостевой книге',
        'children' => array(
            'role_assort',
    		'role_guestbook',
    		'role_nabors',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'role_manager3' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к ассортименту, гостевой книге, новостям',
        'children' => array(
            'role_manager2',
    		'role_news',
        ),
        'bizRule' => null,
        'data' => null
    ),    
    'role_users' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к управлениям пользователями',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    
    'role_page' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Доступ к управлениям страницам',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'role_manager3',
    		'role_page',
    		'role_kadr',
    		'role_users',
        ),
        'bizRule' => null,
        'data' => null
    ),
    
    
    /*
    
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'User',
        'children' => array(
            'guest',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Moderator',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'admin' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Administrator',
        'children' => array(
            'moderator',
        ),
        'bizRule' => null,
        'data' => null
    ),
    */
);