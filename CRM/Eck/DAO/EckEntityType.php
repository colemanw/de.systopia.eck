<?php

/**
 * @package CRM
 * @copyright CiviCRM LLC https://civicrm.org/licensing
 *
 * Generated from de.systopia.eck/xml/schema/CRM/Eck/EckEntityType.xml
 * DO NOT EDIT.  Generated by CRM_Core_CodeGen
 * (GenCodeChecksum:a85a3be4f68f333ea0a9a669ecc4f34d)
 */
use CRM_Eck_ExtensionUtil as E;

/**
 * Database access object for the EckEntityType entity.
 */
class CRM_Eck_DAO_EckEntityType extends CRM_Core_DAO {
  const EXT = E::LONG_NAME;
  const TABLE_ADDED = '';

  /**
   * Static instance to hold the table name.
   *
   * @var string
   */
  public static $_tableName = 'civicrm_eck_entity_type';

  /**
   * Field to show when displaying a record.
   *
   * @var string
   */
  public static $_labelField = 'label';

  /**
   * Should CiviCRM log any modifications to this table in the civicrm_log table.
   *
   * @var bool
   */
  public static $_log = TRUE;

  /**
   * Paths for accessing this entity in the UI.
   *
   * @var string[]
   */
  protected static $_paths = [
    'add' => 'civicrm/admin/eck/entity-type?reset=1&action=add',
    'update' => 'civicrm/admin/eck/entity-type?reset=1&action=update&type=[name]',
    'delete' => 'civicrm/admin/eck/entity-type?reset=1&action=delete&type=[name]',
  ];

  /**
   * Unique EckEntityType ID
   *
   * @var int|string|null
   *   (SQL type: int unsigned)
   *   Note that values will be retrieved from the database as a string.
   */
  public $id;

  /**
   * The entity type name, also used in the sql table name
   *
   * @var string
   *   (SQL type: varchar(58))
   *   Note that values will be retrieved from the database as a string.
   */
  public $name;

  /**
   * The entity type's human-readable name
   *
   * @var string
   *   (SQL type: text)
   *   Note that values will be retrieved from the database as a string.
   */
  public $label;

  /**
   * crm-i icon class
   *
   * @var string|null
   *   (SQL type: varchar(255))
   *   Note that values will be retrieved from the database as a string.
   */
  public $icon;

  /**
   * Does this entity type get added to the recent items list
   *
   * @var bool|string
   *   (SQL type: tinyint)
   *   Note that values will be retrieved from the database as a string.
   */
  public $in_recent;

  /**
   * Class constructor.
   */
  public function __construct() {
    $this->__table = 'civicrm_eck_entity_type';
    parent::__construct();
  }

  /**
   * Returns localized title of this entity.
   *
   * @param bool $plural
   *   Whether to return the plural version of the title.
   */
  public static function getEntityTitle($plural = FALSE) {
    return $plural ? E::ts('ECK Entity Types') : E::ts('ECK Entity Type');
  }

  /**
   * Returns all the column names of this table
   *
   * @return array
   */
  public static function &fields() {
    if (!isset(Civi::$statics[__CLASS__]['fields'])) {
      Civi::$statics[__CLASS__]['fields'] = [
        'id' => [
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => E::ts('ID'),
          'description' => E::ts('Unique EckEntityType ID'),
          'required' => TRUE,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_eck_entity_type.id',
          'table_name' => 'civicrm_eck_entity_type',
          'entity' => 'EckEntityType',
          'bao' => 'CRM_Eck_DAO_EckEntityType',
          'localizable' => 0,
          'html' => [
            'type' => 'Number',
          ],
          'readonly' => TRUE,
          'add' => NULL,
        ],
        'name' => [
          'name' => 'name',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Name'),
          'description' => E::ts('The entity type name, also used in the sql table name'),
          'required' => TRUE,
          'maxlength' => 58,
          'size' => CRM_Utils_Type::BIG,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_eck_entity_type.name',
          'table_name' => 'civicrm_eck_entity_type',
          'entity' => 'EckEntityType',
          'bao' => 'CRM_Eck_DAO_EckEntityType',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'label' => [
          'name' => 'label',
          'type' => CRM_Utils_Type::T_TEXT,
          'title' => E::ts('Label'),
          'description' => E::ts('The entity type\'s human-readable name'),
          'required' => TRUE,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_eck_entity_type.label',
          'table_name' => 'civicrm_eck_entity_type',
          'entity' => 'EckEntityType',
          'bao' => 'CRM_Eck_DAO_EckEntityType',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'icon' => [
          'name' => 'icon',
          'type' => CRM_Utils_Type::T_STRING,
          'title' => E::ts('Icon'),
          'description' => E::ts('crm-i icon class'),
          'maxlength' => 255,
          'size' => CRM_Utils_Type::HUGE,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_eck_entity_type.icon',
          'default' => NULL,
          'table_name' => 'civicrm_eck_entity_type',
          'entity' => 'EckEntityType',
          'bao' => 'CRM_Eck_DAO_EckEntityType',
          'localizable' => 0,
          'html' => [
            'type' => 'Text',
          ],
          'add' => NULL,
        ],
        'in_recent' => [
          'name' => 'in_recent',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => E::ts('In Recent Items'),
          'description' => E::ts('Does this entity type get added to the recent items list'),
          'required' => TRUE,
          'usage' => [
            'import' => FALSE,
            'export' => FALSE,
            'duplicate_matching' => FALSE,
            'token' => FALSE,
          ],
          'where' => 'civicrm_eck_entity_type.in_recent',
          'default' => '1',
          'table_name' => 'civicrm_eck_entity_type',
          'entity' => 'EckEntityType',
          'bao' => 'CRM_Eck_DAO_EckEntityType',
          'localizable' => 0,
          'html' => [
            'type' => 'CheckBox',
          ],
          'add' => NULL,
        ],
      ];
      CRM_Core_DAO_AllCoreTables::invoke(__CLASS__, 'fields_callback', Civi::$statics[__CLASS__]['fields']);
    }
    return Civi::$statics[__CLASS__]['fields'];
  }

  /**
   * Return a mapping from field-name to the corresponding key (as used in fields()).
   *
   * @return array
   *   Array(string $name => string $uniqueName).
   */
  public static function &fieldKeys() {
    if (!isset(Civi::$statics[__CLASS__]['fieldKeys'])) {
      Civi::$statics[__CLASS__]['fieldKeys'] = array_flip(CRM_Utils_Array::collect('name', self::fields()));
    }
    return Civi::$statics[__CLASS__]['fieldKeys'];
  }

  /**
   * Returns the names of this table
   *
   * @return string
   */
  public static function getTableName() {
    return self::$_tableName;
  }

  /**
   * Returns if this table needs to be logged
   *
   * @return bool
   */
  public function getLog() {
    return self::$_log;
  }

  /**
   * Returns the list of fields that can be imported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &import($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getImports(__CLASS__, 'eck_entity_type', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of fields that can be exported
   *
   * @param bool $prefix
   *
   * @return array
   */
  public static function &export($prefix = FALSE) {
    $r = CRM_Core_DAO_AllCoreTables::getExports(__CLASS__, 'eck_entity_type', $prefix, []);
    return $r;
  }

  /**
   * Returns the list of indices
   *
   * @param bool $localize
   *
   * @return array
   */
  public static function indices($localize = TRUE) {
    $indices = [
      'UI_name' => [
        'name' => 'UI_name',
        'field' => [
          0 => 'name',
        ],
        'localizable' => FALSE,
        'unique' => TRUE,
        'sig' => 'civicrm_eck_entity_type::1::name',
      ],
    ];
    return ($localize && !empty($indices)) ? CRM_Core_DAO_AllCoreTables::multilingualize(__CLASS__, $indices) : $indices;
  }

}
