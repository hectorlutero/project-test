<?php

return [
    'default' => 'flasher',
    'themes' => [
        'flasher' => [
            'options' => [
                'darkMode' => ['class', ['.theme-dark']],
            ],
        ],
    ],
    'presets' => [
        'entity_saved' => [
            'type' => 'success',
            'message' => 'Registro salvo com sucesso!',
            'title' => 'Feito!',
        ],
        'entity_error' => [
            'type' => 'error',
            'message' => 'Houve um erro ao tentar salvar o registro!',
            'title' => 'Ops!',
        ],
        'entity_deleted' => [
            'type' => 'success',
            'message' => 'Registro apagado com sucesso!',
            'title' => 'Feito!',
        ],
        'entity_removal_error' => [
            'type' => 'error',
            'message' => 'Houve um erro ao tentar apagar o registro!',
            'title' => 'Ops!',
        ],
        'notification_read' => [
            'type' => 'success',
            'message' => 'Notificação marcada como lida!',
            'title' => 'Feito!',
        ],
        'all_notifications_read' => [
            'type' => 'success',
            'message' => 'Todas as notificações foram marcadas como lidas!',
            'title' => 'Feito!',
        ],
        'entity_status_changed' => [
            'type' => 'success',
            'message' => 'Status modificado com sucesso!',
            'title' => 'Feito!',
        ],
        'entity_status_changed_error' => [
            'type' => 'error',
            'message' => 'Houve um erro ao tentar alterar o status!',
            'title' => 'Ops!',
        ],
    ],
];
