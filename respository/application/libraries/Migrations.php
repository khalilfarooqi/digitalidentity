<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Developer Comments:
 *
 * Execute All query
 * Description:
 *     $surface[maxId]['UpdateStat']="your query";
 *     $surface[maxId]['CheckPrimary']="tablename"; //Check Primary key before Add primary key on table
 *
 * Check Foreign key before Add foreign key on table
 * $surface[maxId]['checkFK']="Tablename,RefernceTableName,ConstraintName";
 *
 * Check table before add or drop
 * $surface[maxId]['CheckStat']="tablename";
 *
 * Check Column before Alter
 * $surface[maxId]['CheckStat']="tablename,columnname";
 *
 */

/**
 * Technical Name
 * - up
 * - down
 * - blueprint
 * - schema
 * - Facades
 * - drop
 * - hasTable
 * - hasColumn
 * - dropIfExists
 * - increments
 * - autoIncrement
 * - dropColumn
 * - primary
 * - spatialIndex
 * - spatialIndex
 * - dropForeign
 */

/**
 *
 * Store Processcedure
 * - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * DELIMITER $$
 *
 * USE `databasename`$$
 *
 * DROP PROCEDURE IF EXISTS `QueryExecutor`$$
 *
 * CREATE DEFINER=`root`@`localhost` PROCEDURE `QueryExecutor`(IN `QueryString` TEXT)
 * BEGIN
 *        SET @query := CONCAT( QueryString);
 *        PREPARE stmt FROM @query;
 *        EXECUTE stmt;
 *        DEALLOCATE PREPARE stmt;
 * END$$
 * DELIMITER;
 *
 *
 *
 * Create Table Schema
 * - - - - - - - - - - - - - - - - - - - - - - - -
 * "create_table" => array(
 *     "table" => 'table',
 *     "schema" => "schema"
 * ),
 *
 *
 * D
 * 
 * ##syntax for drop table 100% woirking rop Table Schema
 * - - - - - - - - - - - - - - - - - - - - - - - -
 * "drop_table" => array(
 *     "table" => 'table',
 *     "schema" => "schema"
 * ),
 *
 *
 * Constraints Columns Schema
 * - - - - - - - - - - - - - - - - - - - - - - - -
 * ALERT:
 * "schema_primary" => "ALTER TABLE `table` ADD PRIMARY KEY(`column`);"
 * "schema_index"   => "ALTER TABLE `table` ADD INDEX(`column`)"
 *
 * "primary_keys" => array(
 *     "table" => 'table',
 *     "columns" => 'column1, column2, column3',
 *     "schema" => "schema"
 * ),
 *
 * "index_keys" => array(
 *     "table" => 'table',
 *     "columns" => 'column1, column2, column3',
 *     "schema" => "schema"
 * ),
 *
 *
 * Add Columns Schema
 * - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * Example 1:
 * "add_columns" => array(
 *     "table" => 'table',
 *     "columns" => 'column1, column2, column3',
 *     "schema" => "schema"
 * ),
 *
 *
 * Drop Columns Schema
 * - - - - - - - - - - - - - - - - - - - - - - - -
 * ALERT:
 * "schema" => "ALERT: ALTER TABLE `table` DROP `column`;"
 *
 * Example 1:
 * "drop_columns" => array(
 *     "table" => 'table',
 *     "columns" => 'column1, column2, column3',
 *     "schema" => "schema"
 * ),
 *
 * Example 2:
 * "drop_columns" => array(
 *     "table" => 'table',
 *     "columns" => array('column1', 'column2', 'column3'),
 *     "schema" => "schema"
 * ),
 *
 */

class Migrations
{
  private $ci;

  public function __construct()
  {
    $this->ci =& get_instance();
  }

  public function migrations()
  {
    $surface = array(
      
      array(
        "create_table" => array(
          "table" => 'projects',
          "schema" => "CREATE TABLE `projects` (
          `id` int(11) NOT NULL ,
          `title` varchar(100) NOT NULL,
          `title_ur` varchar(100) NOT NULL,
          `is_enable` tinyint(1) NOT NULL DEFAULT '1',
          `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
      ),
        "primary_keys" => array(
          "table" => 'projects',
          "columns" => 'id',
          "schema" => "ALTER TABLE `projects`  ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`) ;"
        ),
      ),

      array(
        "create_table" => array(
          "table" => 'tasks_master',
          "schema" => "CREATE TABLE `tasks_master` (
          `id` int(11) NOT NULL ,
          `description` text CHARACTER SET utf8 NOT NULL,
          `is_enable` tinyint(1) NOT NULL DEFAULT '1',
          `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
      ),
        "primary_keys" => array(
          "table" => 'tasks_master',
          "columns" => 'id',
          "schema" => "ALTER TABLE `tasks_master` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`) ;"
        ),
      ),

        array(
            "create_table" => array(
                "table" => 'madani_tasks',
                "schema" => "CREATE TABLE `madani_tasks` (
                  `id` int(11) NOT NULL,
                  `description` text NOT NULL,
                  `madani_types` varchar(10) NOT NULL,
                  `is_enable` tinyint(1) NOT NULL DEFAULT '1',
                  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
            ),
            "primary_keys" => array(
                "table" => 'madani_tasks',
                "columns" => 'id',
                "schema" => "ALTER TABLE `madani_tasks` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`) ;"
            ),
        ),

      array(
        "create_table" => array(
          "table" => 'project_details',
          "schema" => "CREATE TABLE `project_details` (
            `id` int(11) NOT NULL,
            `user_id` int(11) NOT NULL COMMENT 'relation of karkardadi users',
            `project_id` int(11) NOT NULL DEFAULT '0' COMMENT 'relation of projects',
            `zimadari_id` int(11) NOT NULL COMMENT 'i.e: zimadari ids',
            `taqarruri_detail_id` int(11) NOT NULL,
            `template_id` int(11) NOT NULL,
            `task_month` varchar(20) NOT NULL,
            `task_year` varchar(20) NOT NULL,
            `is_enable` tinyint(1) NOT NULL,
            `created_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
        ),
        "primary_keys" => array(
          "table" => 'project_details',
          "columns" => 'id',
          "schema" => "ALTER TABLE `project_details`  ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`user_id`), ADD INDEX(`project_id`), ADD INDEX(`taqarruri_detail_id`);"
        )
      ),

      array(
        "create_table" => array(
          "table" => 'task_transactions',
          "schema" => "CREATE TABLE `task_transactions` (
            `id` int(11) NOT NULL,
            `project_detail_id` int(11) NOT NULL,
            `task_id` int(11) NOT NULL,
            `task_description` text CHARACTER SET utf8,
            `task_date` date NOT NULL,
            `task_location` text CHARACTER SET utf8,
            `is_madani` tinyint(1) NOT NULL DEFAULT '0',
            `status` TINYINT(1) NULL  DEFAULT NULL COMMENT '0=notcompleted',
            `comment` text NOT NULL
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
        ),
        "primary_keys" => array(
          "table" => 'task_transactions',
          "columns" => 'id',
          "schema" => "ALTER TABLE `task_transactions`  ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`project_detail_id`), ADD INDEX(`task_id`);"
        )
      ),

      array(
        "create_table" => array(
          "table" => 'template',
          "schema" => "CREATE TABLE `template` (
          `id` int(11) NOT NULL,
          `level_id` int(5) NOT NULL COMMENT 'i.e: kabina, kabinat, division etc name',
          `department_id` int(11) NOT NULL COMMENT 'i.e: kabina, kabinat, division etc ids',
          `zimadari_id` int(11) NOT NULL COMMENT 'i.e: zimadari ids',
          `description` text CHARACTER SET utf8,
          `is_enable` tinyint(1) NOT NULL DEFAULT '1',
          `is_madani` tinyint(1) NOT NULL DEFAULT '0',
          `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;"
      ),
        "primary_keys" => array(
          "table" => 'template',
          "columns" => 'id',
          "schema" => "ALTER TABLE `template` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`level_id`), ADD INDEX(`department_id`), ADD INDEX(`is_enable`), ADD INDEX(`is_madani`) ;"
        ),
      ),

      array(
        "create_table" => array(
          "table" => 'template_tasks',
          "schema" => "CREATE TABLE `template_tasks` (
          `id` int(11) NOT NULL,
          `template_id` int(11) NOT NULL,
          `task_master_id` int(11) NOT NULL,
          `monday` tinyint(1) NOT NULL DEFAULT '0',
          `tuesday` tinyint(1) NOT NULL DEFAULT '0',
          `wednesday` tinyint(1) NOT NULL DEFAULT '0',
          `thursday` tinyint(1) NOT NULL DEFAULT '0',
          `friday` tinyint(1) NOT NULL DEFAULT '0',
          `saturday` tinyint(1) NOT NULL DEFAULT '0',
          `sunday` tinyint(1) NOT NULL DEFAULT '0',
          `month_day` int(5) NOT NULL DEFAULT '0',
          `is_madani` tinyint(1) NOT NULL DEFAULT '0'
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
      ),
        "primary_keys" => array(
          "table" => 'template_tasks',
          "columns" => 'id',
          "schema" => "ALTER TABLE `template_tasks` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`template_id`), ADD INDEX(`task_master_id`), ADD INDEX(`is_madani`) ;"
        ),
      ),


    //   array(
    //     "create_table" => array(
    //         "table" => 'time_entry',
    //         "schema" => "CREATE TABLE `time_entry` (
    //   `id` int(11) NOT NULL ,
    //   `user_id` int(11) NOT NULL,
    //   `check_in` datetime  DEFAULT NULL,
    //   `check_out` datetime  DEFAULT NULL ,
    //   `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    //   `modify_date` datetime DEFAULT NULL ON UPDAT E CURRENT_TIMESTAMP          
    // ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
    //     ),
    //     "primary_keys" => array(
    //         "table" => 'time_entry',
    //         "columns" => 'id',
    //         "schema" => "ALTER TABLE `time_entry` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`user_id`);"
    //     ),
    // ),


     
      array(
        "create_table" => array(
          "table" => 'permissions',
          "schema" => "CREATE TABLE `permissions` (
          `id` int(11) NOT NULL,          
          `name` varchar(100) DEFAULT NULL,
          `prefix_or_url` varchar(100) NOT NULL,
          `ur_name` varchar(255) NOT NULL,
          `data_icon` varchar(255) NOT NULL,
          `icon_class` varchar(255) DEFAULT NULL,
          `parent_id` int(11) NOT NULL DEFAULT '0',
          `have_child` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0- No , 1- Yes',
          `allowed_permissions` text NOT NULL COMMENT 'Save JSON',
          `sorting` int(11) NOT NULL,
          `is_enable` tinyint(1) DEFAULT NULL,
          `is_default` tinyint(1) NOT NULL DEFAULT '0',
          `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
      ),
        "primary_keys" => array(
          "table" => 'permissions',
          "columns" => 'id',
          "schema" => "ALTER TABLE `permissions`  ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`) ;"
        ),
      ),

      array(
        "create_table" => array(
          "table" => 'role_permission',
          "schema" => "CREATE TABLE `role_permission` (
          `id` int(11) NOT NULL ,
          `role_id` int(11) NOT NULL,
          `permission_id` int(11) NOT NULL,
          `btn_option` varchar(100) CHARACTER SET utf8 NOT NULL,
          `value_btn` varchar(100) CHARACTER SET utf8 NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
      ),
        "primary_keys" => array(
          "table" => 'role_permission',
          "columns" => 'id',
          "schema" => "ALTER TABLE `role_permission` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`permission_id`), ADD INDEX(`role_id`);"
        ),
      ),
      // array(
      //   "create_table" => array(
      //     "table" => 'user_roles',
      //     "schema" => "CREATE TABLE `user_roles` (
      //       `id` int(11) NOT NULL,
      //       `user_id` int(11) NOT NULL,
      //       `role_id` int(11) NOT NULL          
      //     )ENGINE=InnoDB DEFAULT CHARSET=utf8;"
      // ),
      //   "primary_keys" => array(
      //     "table" => 'user_roles',
      //     "columns" => 'id',
      //     "schema" => "ALTER TABLE `user_roles` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`role_id`), ADD INDEX(`user_id`);"
      //   ),
      // ),

      
      array(
        "create_table" => array(
          "table" => 'time_entry',
          "schema" => "CREATE TABLE `time_entry` (
          `id` int(11) NOT NULL ,
      `user_id` int(11) NOT NULL,
      `check_in` datetime  DEFAULT NULL,
      `check_out` datetime  DEFAULT NULL ,
      `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
          `modify_date` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;"
      ),
        "primary_keys" => array(
          "table" => 'time_entry',
          "columns" => 'id',
          "schema" => "ALTER TABLE `time_entry` ADD PRIMARY KEY (`id`), CHANGE `id` `id` INT(11) NOT NULL AUTO_INCREMENT, ADD INDEX(`id`), ADD INDEX(`user_id`);"
        ),
      ),

    );
    
    return $surface;
  }

  ##syntax for drop table 100% woirking 
  // array(
  //   "drop_table" => array(
  //     "table" => 'f1',
  //     "schema" => "Drop table `f1`"
  // ),
    
  // ),
  
  public function compileQuries( $number )
  {
    $migrations = $this->migrations();

    if( !(count($migrations) >= $number) ) {
      return [];
    }

    return $migrations;
  }

  public function runMigrate( $collation )
  {
    $migrations     = $this->compileQuries($collation);
    $compile 		= 0;

    $this->ci->db->db_debug = FALSE;

    foreach($migrations as $migration)
    {
      foreach ($migration as $schema_type => $schema)
      {
        $compile += $this->_compileMigrations($schema_type, $schema);
      }
    }

    $this->ci->Mdl_auth->update(TABLE_SETTINGS, array(
      'values' => $compile
    ),
    array(
      'key' => 'migrations',
      'bg_code' => CONSTANT_BUSINESS_CODE['JADWAL_O_JAIZA'],
    ));
  }

  private function _compileMigrations( $schema_type, $schema )
  {
    // dd($schema, false, "$schema_type");

    switch ( $schema_type )
    {
      case 'create_table':

      $is_exists  = $this->_checkIfExistsTableSchema($schema['table']);

      if( TRUE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;

      ##syntax for drop table 100% woirking 

      case 'drop_table':

      $is_exists  = $this->_checkIfExistsTableSchema($schema['table']);

      if( FALSE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;

      case 'primary_keys':

      $is_exists  = $this->_checkIfExistsConstraintsSchema($schema['table'], $schema['columns'], 'primary');

      if( FALSE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;

      case 'index_keys':

      $is_exists  = $this->_checkIfExistsConstraintsSchema($schema['table'], $schema['columns'], 'index');

      if( TRUE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;

      case 'add_columns':

      $is_exists  = $this->_checkIfExistsColumnSchema($schema['table'], $schema['columns']);

      if( TRUE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;

      case 'drop_columns':

      $is_exists  = $this->_checkIfExistsColumnSchema($schema['table'], $schema['columns']);

      if( FALSE !== (bool) $is_exists ) {
        $transaction = (bool) $this->ci->db->query("call QueryExecutor(".$this->ci->db->escape($schema['schema']).")");

        return 1;
      }

      break;
    }

    return 0;
  }

  private function _checkIfExistsTableSchema( $table)
  {
    $total = $this->ci->Mdl_auth->FirstOrNull('information_schema.COLUMNS', array(
      'TABLE_SCHEMA' => $this->ci->db->database,
      'TABLE_NAME' => $table
    ), 'count(*) as count');

    return $total['count'] ?: 0;
  }

  private function _checkIfExistsColumnSchema($table, $columns)
  {
    $columns = (is_array($columns) ? implode($columns, ',') : $columns);
    $columns = preg_replace('/\s+/', '', $columns);

    $this->ci->db->group_start();
    $this->ci->db->where_in('COLUMN_NAME', explode(',', $columns));
    $this->ci->db->group_end();

    $total = $this->ci->Mdl_auth->FirstOrNull('information_schema.COLUMNS', array(
      'TABLE_SCHEMA' => $this->ci->db->database,
      'TABLE_NAME' => $table
    ), 'count(*) as count');

    return $total['count'] ?: 0;
  }

  private function _checkIfExistsConstraintsSchema($table, $columns, $relation)
  {
    $columns = (is_array($columns) ? implode($columns, ',') : $columns);
    $columns = preg_replace('/\s+/', '', $columns);

    $this->ci->db->group_start();

    $this->ci->db->where_in('COLUMN_NAME', explode(',', $columns));

    switch ($relation)
    {
      case 'primary':
      $this->ci->db->where('COLUMN_KEY', 'PRI');
      break;

      case 'index':
        // $this->ci->db->where('EXTRA', 'auto_increment');
      break;

      case 'autoIncrement':
      $this->ci->db->where('EXTRA', 'auto_increment');
      break;
    }

    $this->ci->db->group_end();

    $total = $this->ci->Mdl_auth->FirstOrNull('information_schema.COLUMNS', array(
      'TABLE_SCHEMA'  => $this->ci->db->database,
      'TABLE_NAME'    => $table
    ), 'count(*) as count');

    return $total['count'] ?: 0;
  }
}