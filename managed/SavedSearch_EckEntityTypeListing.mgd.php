<?php
use CRM_Eck_ExtensionUtil as E;

return [
  [
    'name' => 'SavedSearch_ECK_Entity_Types',
    'entity' => 'SavedSearch',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'ECK_Entity_Types',
        'label' => E::ts('ECK Entity Types'),
        'form_values' => NULL,
        'mapping_id' => NULL,
        'search_custom_id' => NULL,
        'api_entity' => 'EckEntityType',
        'api_params' => [
          'version' => 4,
          'select' => [
            'label',
            'name',
            'sub_types:label',
          ],
          'orderBy' => [],
          'where' => [],
          'groupBy' => [],
          'join' => [],
          'having' => [],
        ],
        'expires_date' => NULL,
        'description' => NULL,
      ],
      'match' => [
        'name',
      ],
    ],
  ],
  [
    'name' => 'SavedSearch_ECK_Entity_Types_SearchDisplay_ECK_Entity_Type_List',
    'entity' => 'SearchDisplay',
    'cleanup' => 'always',
    'update' => 'unmodified',
    'params' => [
      'version' => 4,
      'values' => [
        'name' => 'ECK_Entity_Type_List',
        'label' => E::ts('ECK Entity Type List'),
        'saved_search_id.name' => 'ECK_Entity_Types',
        'type' => 'table',
        'settings' => [
          'description' => E::ts('The Entity Construction Kit extension allows you to create and manage custom CiviCRM entities.'),
          'sort' => [
            [
              'label',
              'ASC',
            ],
          ],
          'limit' => 50,
          'pager' => [],
          'placeholder' => 5,
          'columns' => [
            [
              'type' => 'field',
              'key' => 'label',
              'dataType' => 'Text',
              'label' => E::ts('Entity Type'),
              'sortable' => TRUE,
              'icons' => [
                [
                  'field' => 'icon',
                  'side' => 'left',
                ],
              ],
              'editable' => TRUE,
            ],
            [
              'type' => 'field',
              'key' => 'name',
              'dataType' => 'String',
              'label' => E::ts('Internal Name'),
              'sortable' => TRUE,
            ],
            [
              'type' => 'field',
              'key' => 'sub_types:label',
              'dataType' => 'Array',
              'label' => E::ts('Sub Types'),
              'sortable' => TRUE,
            ],
            [
              'size' => 'btn-xs',
              'links' => [
                [
                  'path' => 'civicrm/eck/entity/list/[name]',
                  'icon' => 'fa-external-link',
                  'text' => E::ts('View Records'),
                  'style' => 'default',
                  'condition' => [],
                  'entity' => '',
                  'action' => '',
                  'join' => '',
                  'target' => '',
                ],
                [
                  'entity' => 'EckEntityType',
                  'action' => 'update',
                  'join' => '',
                  'target' => 'crm-popup',
                  'icon' => 'fa-pencil',
                  'text' => E::ts('Edit Type'),
                  'style' => 'default',
                  'path' => '',
                  'condition' => [],
                ],
                [
                  'entity' => 'EckEntityType',
                  'action' => 'delete',
                  'join' => '',
                  'target' => 'crm-popup',
                  'icon' => 'fa-trash',
                  'text' => E::ts('Delete Type'),
                  'style' => 'danger',
                  'path' => '',
                  'condition' => [],
                ],
              ],
              'type' => 'buttons',
              'alignment' => 'text-right',
            ],
          ],
          'actions' => FALSE,
          'classes' => [
            'table',
            'table-striped',
          ],
          'addButton' => [
            'path' => 'civicrm/admin/eck/entity-type?reset=1&action=add',
            'text' => E::ts('Add ECK Entity Type'),
            'icon' => 'fa-plus',
          ],
        ],
        'acl_bypass' => FALSE,
      ],
      'match' => [
        'name',
        'saved_search_id',
      ],
    ],
  ],
];
