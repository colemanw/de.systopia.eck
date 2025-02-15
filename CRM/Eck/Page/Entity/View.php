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

use CRM_Eck_ExtensionUtil as E;
use Civi\Api4\EckEntityType;

class CRM_Eck_Page_Entity_View extends CRM_Core_Page {

  /**
   * The id of the entity we are processing.
   *
   * @var int
   */
  public $_id;

  /**
   * The entity type of the entity we are processing.
   *
   * @var int
   */
  public $_entityType;

  public function run() {

    // Retrieve ECK entity type.
    if (!$entity_type_name = CRM_Utils_Request::retrieve('type', 'String', $this)) {
      throw new CRM_Core_Exception('No ECK entity type given.');
    }
    try {
      $entity_type = EckEntityType::get(FALSE)->addWhere('name', '=', $entity_type_name)->execute()->single();
      $this->assign('entity_type', $entity_type);
      $this->_entityType = $entity_type;
    }
    catch (Exception $exception) {
      throw new Exception(E::ts('Invalid ECK entity type.'));
    }

    // Retrieve ECK entity using the API.
    if (!$entity_id = CRM_Utils_Request::retrieve('id', 'Integer', $this)) {
      throw new CRM_Core_Exception('No entity ID given.');
    }
    $this->_id = $entity_id;
    $entity = civicrm_api4('Eck_' . $entity_type_name, 'get', [
      'where' => [['id', '=', $entity_id]],
    ])->single();
    // Retrieve fields.
    $fields = civicrm_api4('Eck_' . $entity_type_name, 'getfields', [
      'where' => [['type', '=', 'Field']],
    ], 'name');
    $this->assign('fields', $fields);

    // Set page title.
    CRM_Utils_System::setTitle($entity['title']);

    // Retrieve and build custom data view.
    $custom_group_tree = CRM_Core_BAO_CustomGroup::getTree(
      'Eck_' . $entity_type_name,
      [],
      $entity_id,
      NULL,
      [$entity['subtype']],
      NULL,
      FALSE,
      NULL,
      FALSE,
      CRM_Core_Permission::VIEW
    );
    CRM_Core_BAO_CustomGroup::buildCustomDataView(
      $this,
      $custom_group_tree,
      FALSE,
      NULL,
      NULL,
      NULL,
      $entity_id
    );

    // Replace subtype value with its name.
    $subtypes = CRM_Eck_BAO_EckEntityType::getSubTypes($entity_type_name);
    $entity['subtype'] = $subtypes[$entity['subtype']];

    $this->assign('entity', $entity);

    // Add to recent items
    if (!empty($entity_type['in_recent'])) {
      \Civi\Api4\RecentItem::create()
        ->addValue('entity_type', 'Eck_' . $entity_type_name)
        ->addValue('entity_id', $entity_id)
        ->execute();
    }

    parent::run();
  }

}
