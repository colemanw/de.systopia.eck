<?php
/*-------------------------------------------------------+
| CiviCRM Entity Construction Kit                        |
| Copyright (C) 2021 SYSTOPIA                            |
| Author: J. Schuppe (schuppe@systopia.de)               |
+--------------------------------------------------------+
| This program is released as free software under the    |
| Affero GPL license. You can redistribute it and/or     |
| modify it under the terms of this license which you    |
| can read by viewing the included agpl.txt or online    |
| at www.gnu.org/licenses/agpl.html. Removal of this     |
| copyright header is strictly prohibited without        |
| written permission from the original author(s).        |
+--------------------------------------------------------*/

require_once 'eck.civix.php';
use CRM_Eck_ExtensionUtil as E;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function eck_civicrm_config(&$config) {
  _eck_civix_civicrm_config($config);
}

/**
 * Convert ECK EntityType name to sql table name.
 *
 * @param string $entityTypeName
 * @return string
 */
function _eck_get_table_name(string $entityTypeName): string {
  // SQL table names must be alphanumeric and no longer than 64 characters
  return CRM_Utils_String::munge('civicrm_eck_' . strtolower($entityTypeName), '_', 64);
}

/**
 * Implements hook_civicrm_entityTypes().
 *
 * Declare entity types provided by this module.
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_entityTypes
 */
function eck_civicrm_entityTypes(&$entityTypes) {

  $eck_entity_types = CRM_Core_DAO::executeQuery(
    'SELECT * FROM `civicrm_eck_entity_type`;'
  )->fetchAll('id');

  foreach ($eck_entity_types as $entity_type) {
    // "CRM_Eck_DAO_*" is a virtual class name, the corresponding class does not
    // exist. "CRM_Eck_DAO_Entity" is therefore defined as the controller
    // class.
    $entityTypes['CRM_Eck_DAO_' . $entity_type['name']] = [
      'name' => 'Eck_' . $entity_type['name'],
      'class' => 'CRM_Eck_DAO_Entity',
      'table' => _eck_get_table_name($entity_type['name']),
    ];
  }
}

/**
 * Implements hook_civicrm_container().
 */
function eck_civicrm_container(\Symfony\Component\DependencyInjection\ContainerBuilder $container) {
  // Register API Provider.
  $apiKernelDefinition = $container->getDefinition('civi_api_kernel');
  $apiProviderDefinition = new Definition('Civi\Eck\API\Entity');
  $apiKernelDefinition->addMethodCall('registerApiProvider', array($apiProviderDefinition));
}

/**
 * Implements hook_civicrm_pre().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_pre
 */
function eck_civicrm_pre($action, $entity, $id, &$params) {
  if ($entity === 'EckEntityType') {
    $eckTypeName = $id ? CRM_Core_DAO::getFieldValue('CRM_Eck_DAO_EckEntityType', $id) : NULL;

    switch ($action) {
      case 'edit':
        // Do not allow entity type to be renamed, as the table name depends on it
        if (isset($params['name']) && $params['name'] !== $eckTypeName) {
          throw new Exception('Renaming an EckEntityType is not allowed.');
        }
        break;

      // Perform cleanup before deleting an EckEntityType
      case 'delete':
        // Delete entities of this type.
        civicrm_api4('Eck_' . $eckTypeName, 'delete', [
          'checkPermissions' => FALSE,
          'where' => [['id', 'IS NOT NULL']],
        ]);

        // TODO: Delete custom fields in custom groups extending this entity type?

        // Delete custom groups. This has to be done before removing the table due
        // to FK constraints.
        civicrm_api4('CustomGroup', 'delete', [
          'checkPermissions' => FALSE,
          'where' => [['extends', '=', 'Eck_' . $eckTypeName]],
        ]);

        // Drop table.
        $table_name = _eck_get_table_name($eckTypeName);
        CRM_Core_DAO::executeQuery("DROP TABLE IF EXISTS `{$table_name}`");

        // Delete subtypes.
        civicrm_api4('OptionValue', 'delete', [
          'checkPermissions' => FALSE,
          'where' => [
            ['option_group_id:name', '=', 'eck_sub_types'],
            ['grouping', '=', $eckTypeName],
          ],
        ]);
        break;
    }
  }
}

/**
 * Implements hook_civicrm_post().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_post
 */
function eck_civicrm_post($action, $entity, $id, $object) {
  if ($entity === 'EckEntityType') {
    // Create tables, etc.
    if ($action === 'create') {
      CRM_Eck_BAO_EckEntityType::ensureEntityType($object->toArray());
    }

    // Flush schema caches to make the new entity available.
    CRM_Core_DAO_AllCoreTables::flush();
    Civi::cache('metadata')->clear();

    // Refresh managed entities which are autogenerated based on EckEntities
    \Civi\Api4\Managed::reconcile(FALSE)->addModule(E::LONG_NAME)->execute();

    // Flush menu and navigation cache so the new Afform listing page appears.
    CRM_Core_Menu::store();
    CRM_Core_BAO_Navigation::resetNavigation();
  }
  elseif (
    strpos($entity, 'Eck_') === 0 &&
    in_array($action, ['create', 'edit'], TRUE) &&
    (CRM_Eck_BAO_EckEntityType::getEntityType(substr($entity, 4))['in_recent'] ?? FALSE)
  ) {
    // add the recently created Entity
    \Civi\Api4\RecentItem::create()
      ->addValue('entity_type', $entity)
      ->addValue('entity_id', $id)
      ->execute();
  }
}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
function eck_civicrm_navigationMenu(&$menu) {
  _eck_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('Custom Entities'),
    'name' => 'eck_entities',
    'operator' => 'OR',
    'separator' => 0,
    'icon' => 'crm-i fa-cubes',
  ));
  foreach (CRM_Eck_BAO_EckEntityType::getEntityTypes() as $entity_type) {
    _eck_civix_insert_navigation_menu($menu, 'eck_entities', array(
      'label' => $entity_type['label'],
      'name' => 'eck_' . $entity_type['name'],
      'url' => 'civicrm/eck/entity/list/' . $entity_type['name'],
      'permission' => 'access CiviCRM',
      'operator' => 'OR',
      'separator' => 0,
      'icon' => $entity_type['icon'] ? 'crm-i ' . $entity_type['icon'] : NULL,
    ));
  }
  _eck_civix_navigationMenu($menu);
}
