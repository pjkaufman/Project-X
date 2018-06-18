<?php

defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Compare_model class.
 * @extends CI_Model
 */
class Compare_model extends CI_Model
{
    /**
     * __construct function.
     */
    public function __construct()
    {
        parent::__construct();
        $this->set_dir();
    }

    /**
     * gets each index and then decides which index which ones to add or drop it also adds all PRIMARY KEYs 
     * from the dev database.
     * @author Peter Kaufman
     * @since 8-25-17
     * @version 5-31-18
     * @example manage_indices();
     * @return sql_commands_to_run is a an array that is the mysql type and a little string to add and or drop the index
     */
    public function manage_indices()
    {
        $indices_present = array();
        $indices_missing = array();
        $sql_commands_to_run = array();

        //check all indexes from the dev database, any PRIMARY KEY's should automatically be added
        foreach ($_SESSION['dev']['indices'] as $index) {
            if (!in_array($index['table'], $_SESSION['exclude'])) {
                if ($index['name'] == 'PRIMARY') {
                    $primary[] = $index;
                } elseif (array_key_exists($index['table'] . '-' . $index['name'], $_SESSION['live']['indices'])) {
                    $indices_present[] = $index;
                } else {
                    $indices_missing[] = $index;
                }
            }
        }
        // check for unneeded indices
        foreach ($_SESSION['live']['indices'] as $index) {
            // if the index exists on a table that is not to be excluded, exists
            // on a column in the dev environment,does not exist in the dev database,
            //  and is not a PRIMARY KEY, then drop it
            if (!in_array($index['table'], $_SESSION['exclude'])) {
                if (!(array_key_exists($index['table'] . '-' . $index['name'], $_SESSION['dev']['indices']))
                && $index['name'] != 'PRIMARY') {
                    $columnCheck = false;
                    //if at least one column for the index exists in the new table,
                    //then the index can be dropped
                    foreach ($index['columns'] as $column) {
                        if (array_key_exists($column, $_SESSION['dev']['tables'][$index['table']]['columns'])) {
                            $columnCheck = true;

                            break;
                        }
                    }

                    if ($columnCheck) {
                        $sql_commands_to_run[] = 'ALTER TABLE `' . $index['table'] . '`' . $index['drop'] . ';';
                    }
                }
            }
        }

        for ($i = 0; $i < count($indices_missing); ++$i) {
            if (array_key_exists($indices_missing[$i]['table'] . '-' . $indices_missing[$i]['name'], $_SESSION['live']['indices'])) {
                $sql_commands_to_run[] = 'ALTER TABLE `' . $indices_missing[$i]['table'] . '`' . $indices_missing[$i]['drop'] . ",\n" . $indices_missing[$i]['create'] . ';';
            } else {
                $sql_commands_to_run[] = 'ALTER TABLE `' . $indices_missing[$i]['table'] . '` ' . $indices_missing[$i]['create'] . ';';
            }
        }
        //add back all PRIMARY KEYs
        foreach ($primary as $index) {
            $sql_commands_to_run[] = 'ALTER TABLE `' . $index['table'] . '` ' . $index['create'] . ';';
        }

        return $sql_commands_to_run;
    }

    /**
     * creates or drops the tables passed in.
     * @author Peter Kaufman
     * @example manage_tables($tables, $action);
     * @since 8-25-17
     * @version 5-31-18
     * @param  tables is an array of tables in a db
     * @param  action is as string which determines whether or not the table will be created or dropped
     * @return sql_commands_to_run is an array that is the mysql code to execute to create or drop tables
     */
    public function manage_tables($tables, $action)
    {
        $sql_commands_to_run = array();

        if ($action == 'create') {
            foreach ($tables as $table) {
                $sql_commands_to_run[] = $_SESSION['dev']['tables']["$table"]['create'];
            }
        }

        if ($action == 'drop') {
            foreach ($tables as $table) {
                $sql_commands_to_run[] = $_SESSION['live']['tables']["$table"]['drop'];
            }
        }

        return $sql_commands_to_run;
    }

    /**
     * compares table structures and returns an array of tables to update.
     * @author Gordon Murray
     * @example compare_table_structures();
     * @since 8-25-17
     * @version 5-31-18
     */
    public function compare_table_structures()
    {
        /*
         * compare the development sql to the live sql
         */
        foreach ($_SESSION['dev']['tables'] as $table) {
            $development_table = $table['create'];
            $live_table = (isset($_SESSION['live']['tables'][$table['name']]['create'])) ? $_SESSION['live']['tables'][$table['name']]['create'] : '';
            // if the strings are not the same add them to the list to be updated later
            if (strcmp($development_table, $live_table) != 0) {
                $_SESSION['update'][$table['name']] = $table['name'];
            }
        }
    }

    /**
     * updates the existing records by modifying, adding, and removing columns.
     * @author Gordon Murray && Peter Kaufman
     * @example update_existing_tables(); returns the sql needed to update the desired db's tables
     * @since 8-25-17
     * @version 5-31-18
     */
    public function update_existing_tables()
    {
        return $this->determine_field_changes();
    }

    /**
     * returns the desired db's table names.
     * @author Peter Kaufman
     * @example table_list($db);
     * @since 8-25-17
     * @version 8-25-17
     * @param  db is a databse connection that is to be used
     * @return result is an array of table names which exist in the provided database
     */
    public function table_list($db)
    {
        $temp = null;
        $result = array();
        $temp = $db->query("SELECT `table_name` FROM `information_schema`.`tables` where `table_schema`='" . $db->database . "' AND `table_type` = 'BASE TABLE';")->result();

        foreach ($temp as $ind) {
            array_push($result, $ind->table_name);
        }

        return $result;
    }

    /**
     * gets a list of view.
     * @author Peter Kaufman
     * @example get_views($db, $views);
     * @since 8-25-17
     * @version 5-31-18
     * @param db    is a database connection that is to be used to get the views from
     * @param views is the array where the view names will be stored
     */
    public function get_views($db, &$views)
    {
        $result = array();
        $sql = "SELECT `TABLE_NAME` AS `table_name`
                FROM `information_schema`.`tables`
                WHERE `TABLE_TYPE` LIKE 'VIEW' && `TABLE_SCHEMA` = '" . $db->database . "';";
        $tempR = $db->query($sql)->result();

        foreach ($tempR as $ind) {
            $create = $db->query('SHOW CREATE VIEW `' . $ind->table_name . '`;')->result()[0]->{'Create View'};
            $views[$ind->table_name] = array(
              'name' => $ind->table_name,
              'create' => $create,
              'drop' => 'DROP VIEW `' . $ind->table_name . '`;',
            );
        }
    }

    /**
     * returns an array of SQL statements which either drop or add views.
     * @author Peter Kaufman
     * @example view_results();
     * @since 8-25-17
     * @version 5-31-18
     * @return sql_commands_to_run is an array of SQL statements which either drop or add views
     */
    public function view_results()
    {
        $sql_commands_to_run = array();
        //live views must be dropped no questions asked
        foreach ($_SESSION['live']['views'] as $view) {
            $sql_commands_to_run[] = $view['drop'];
        }
        //dev views must be created with no questions asked
        foreach ($_SESSION['dev']['views'] as $view) {
            $sql_commands_to_run[] = $view['create'] . ';';
        }

        return $sql_commands_to_run;
    }

    /**
     * returns an array of SQL statements which add all AUTO_INCREMENT's back to the the database.
     * @author Peter Kaufman
     * @example fix_AI();
     * @since 5-19-18
     * @version 5-19-18
     */
    public function fix_AI()
    {
        $sql_commands_to_run = array();
        //check each table in the dev database
        foreach ($_SESSION['dev']['tables'] as $table) {
            //check to see if the table is to be excluded
            //and that the table has an auto_increment column
            if (!array_key_exists($table['name'], $_SESSION['exclude']) && $table['auto_increment'] != '') {
                $sql_commands_to_run[] = 'ALTER TABLE `' . $table['name'] . "` \n" . $table['columns'][$table['auto_increment']]['modify'] . ';';
            }
        }

        return $sql_commands_to_run;
    }

    /**
     * takes an where a table list is stored and a database connection the result is that columns and indexes are 
     * added to the provided array.
     * @author Peter Kaufman
     * @example fill_out_tables($schemaStructure, $db);
     * @since 8-25-17
     * @version 5-31-18
     * @param schemaStructure is an array which contains a table list
     * @param db              is a database connection which will be used to get the necessary information
     */
    public function fill_out_tables(&$schemaStructure, $db)
    {
        $schemaStructure['tables'] = array();
        $schemaStructure['indices'] = array();
        //get all columns for each table
        foreach ($schemaStructure['tables_list'] as $tName) {
            $columns = $db->query("SHOW COLUMNS FROM `$tName`;")->result();
            $index = $db->query("SHOW INDEXES FROM `$tName`;")->result();
            $create = ($db->query("SHOW CREATE TABLE `$tName` -- create tables")->row_array())['Create Table'];
            $schemaStructure['tables'][$tName] = array(
              'name' => $tName,
              'columns' => array(),
              'create' => $create . ';',
              'drop' => "DROP TABLE `$tName`;",
              'auto_increment' => '',
            );
            //get all necessary column data
            foreach ($columns as $column) {
                $this->create_col($schemaStructure['tables'][$tName], $column);
            }
            //get all necessary index data
            $this->create_indexes($schemaStructure, $index, $tName);
        }
    }

    /**
     * returns an array of SQL statements which drop all AUTO_INCREMENT's and PRIMARY KEY's.
     * @author Peter Kaufman
     * @example get_first_steps();
     * @since 8-25-17
     * @version 5-31-18
     * @return array is  an array of SQL statements which drop all AUTO_INCREMENT's and PRIMARY KEY's
     */
    public function get_first_steps()
    {
        //find and drop all PRIMARY KEY's in the live databases
        $sql_commands_to_run = array();
        //go through all live tables that are not in exclude
        foreach ($_SESSION['live']['tables'] as $table) {
            if (!array_key_exists($table['name'], $_SESSION['exclude'])) {
                $statement = 'ALTER TABLE `' . $table['name'] . "` \n";
                $primary = $table['name'] . '-PRIMARY';
                $count = 0;
                //check each table for an AUTO_INCREMENT field, if it exists,
                //then modify the column
                if (strcmp($table['auto_increment'], '') != 0) {
                    $statement .= str_replace(' AUTO_INCREMENT', '', $table['columns'][$table['auto_increment']]['modify']);
                    $count++;
                }
                /*determine whether the index is a primary key
                 if it is then drop it and make sure the table being checked
                 is not in the exclude list*/

                if (array_key_exists($primary, $_SESSION['live']['indices'])) {
                    $index = $_SESSION['live']['indices'][$primary];

                    if ($count == 0) {
                        $statement .= $index['drop'];
                        $count++;
                    } else {
                        $statement .= ", \n" . $index['drop'];
                        $count++;
                    }
                }

                if ($count != 0) {
                    $sql_commands_to_run[] = $statement . ';';
                }
            }
        }

        return $sql_commands_to_run;
    }

    /**
     * creates a snapshot of the db which includes tables, create statements, column and column fields, and indices.
     * @author Peter Kaufman
     * @example create_db_snapshot();
     * @since 8-25-17
     * @version 5-19-18
     */
    public function create_db_snapshot()
    {
        $file = fopen(getcwd() . '\dbsnapshot.json', 'w');
        fwrite($file, json_encode($_SESSION['dev']));
        fclose($file);
    }

    /**
     * gets the snapshot of the db.
     * @author Peter Kaufmna
     * @example get_db_snapshot();
     * @since 8-25-17
     * @version 5-19-18
     */
    public function get_db_snapshot()
    {
        $_SESSION['dev'] = json_decode(file_get_contents(getcwd() . '\dbsnapshot.json'), true);
    }

    /**
     * takes an array where a table list is stored and an array the result is that a column is added to the 
     * table structure.
     * @author Peter Kaufman
     * @example create_col($tableStructure, $column);
     * @since 8-25-17
     * @version 5-31-18
     * @param schemaStructure is an array which contains a table list
     * @param column          is an array which contains data about a column
     */
    private function create_col(&$tableStructure, $column)
    {
        //get data from queried array
        $name = $column->Field;
        $type = $column->Type;
        $extra = $column->Extra;
        $default = $column->Default;
        $null = $column->{'Null'};
        //setup desired variables
        $info = " $type";

        if ($default == null) {
            $default = 'NULL';
        } elseif (strpos($type, 'char') !== false) {
            $default = "\'" . $default . "\'";
        }

        if ($null == 'NO') {
            $info .= ' NOT NULL';
        } else {
            $info .= " DEFAULT $default";
        }

        if ($extra == 'auto_increment') {
            $info .= ' AUTO_INCREMENT';
            $tableStructure['auto_increment'] = $name;
        }
        $create = " ADD COLUMN `$name`$info";
        $modify = " MODIFY COLUMN `$name`$info";
        $drop = " DROP COLUMN `$name`";
        $tableStructure['columns'][$name] = array(
          'name' => $name,
          'details' => $info,
          'create' => $create,
          'drop' => $drop,
          'modify' => $modify,
        );
    }

    /**
     * takes an array where a table list is stored, an array, and a table name the result is that indexes are 
     * added to the table structure.
     * @author Peter Kaufman
     * @example create_indexes($tableStructure, $index, $tName);
     * @since 8-25-17
     * @version 5-31-18
     * @param schemaStructure is an array which contains a table list
     * @param index           is an array which contains data about a indexes
     * @param tName           is the name of the table where the indexes are from
     */
    private function create_indexes(&$tableStructure, $index, $tName)
    {
        //get data from queried array
        $lastName = '';
        $distinct = '';
        $name = '';
        $drop = '';
        $type = '';
        $unique = '';
        $columns = array();

        foreach ($index as $ind) {
            if (strcmp($lastName, '') != 0 && strcmp($lastName, $distinct) != 0) {
                if ($name == 'PRIMARY') {
                    $drop = ' DROP PRIMARY KEY';
                } else {
                    $drop = " DROP INDEX `$name`";
                }
                $create = $this->get_create_index($columns, $name, $unique, $type);
                $tableStructure['indices'][$tName . '-' . $name] = array(
                'name' => $name,
                'table' => $tName,
                'columns' => $columns,
                'create' => $create,
                'drop' => $drop,
              );
                $columns = array();
            }
            $distinct = $ind->Key_name . '  ' . $tName;
            $name = $ind->Key_name;
            $unique = $ind->Non_unique;
            $type = $ind->Index_type;
            array_push($columns, $ind->Column_name);
            $lastName = $ind->Key_name;
        }

        if (strcmp($lastName, '') != 0 && strcmp($lastName, $distinct) != 0) {
            if ($name == 'PRIMARY') {
                $drop = ' DROP PRIMARY KEY';
            } else {
                $drop = " DROP INDEX `$name`";
            }
            $create = $this->get_create_index($columns, $name, $unique, $type);
            $tableStructure['indices'][$tName . '-' . $name] = array(
            'name' => $name,
            'table' => $tName,
            'columns' => $columns,
            'create' => $create,
            'drop' => $drop,
          );
            $columns = array();
        }
    }

    /**
     * takes two strings, an integer, and an array the result is a create statement for the provided data.
     * @author Peter Kaufman
     * @example get_create_index($columns, $name, $unique, $type);
     * @since 8-25-17
     * @version 5-31-18
     * @param  columns is an array which contains a list of column names
     * @param  name    is a string which is the name of the index
     * @param  unique  is the unique value (0 or 1, unique or not unique)
     * @param  type    is a string which is the type of indexing used for the index
     * @return is a the create statement for the index based on the provided strings
     */
    private function get_create_index($columns, $name, $unique, $type)
    {
        $create = '';
        $column = '';
        // setup the appropriate for the columns
        for ($i = 0; $i < sizeof($columns); $i++) {
            if ($i == 0) {
                $column = "`$columns[$i]`";
            } else {
                $column = ",`$columns[$i]`";
            }
        }
        // initialize the add index statement
        if ($name == 'PRIMARY') {
            $create = " ADD PRIMARY KEY($column)";
        } elseif ($unique == 0) {
            $create = " ADD UNIQUE INDEX `$name` ($column)";
        } elseif ($type == 'FULLTEXT') {
            $create = " ADD FULLTEXT INDEX `$name` ($column)";
        } elseif ($type == 'SPATIAL') {
            $create = " ADD SPATIAL INDEX `$name` ($column)";
        } else {
            $create = " ADD INDEX `$name` ($column)";
        }

        return $create;
    }

    /**
     * sets the directory for where the db snapshot is.
     * @author Peter Kaufman
     * @example set_dir();
     * @since 8-25-17
     * @version 8-25-17
     */
    private function set_dir()
    {
        getcwd();
        chdir('application');
        chdir('modules');
        chdir('compare');
    }

    /**
     * edits table columns by adding, updating, and removing them.
     * @author Gordon Murray && Peter Kaufman
     * @example determine_field_changes($type) returns the sql needed to update the desired db's tables
     * @return sql_commands_to_run is an array that is the sql to run to add, edit, or remove a column
     * @since 8-25-17
     * @version 5-31-18
     */
    private function determine_field_changes()
    {
        $sql_commands_to_run = array();
        /**
         * loop through the source (usually development) database. if any differences
         * in column definitions are found then add the appropriate SQL
         * statement to make them the same.
         */
        foreach ($_SESSION['update'] as $table) {
            // if the table is not to be excluded then check to see
            // if it has any differences with the live db
            // check each column for any differences, if there are any then
            // add the appropriate SQL
            $count = 0;
            $tName = $table;
            $statement = "ALTER TABLE `$tName`";

            foreach ($_SESSION['dev']['tables'][$table]['columns'] as $column) {
                $info = '';
                $cName = $column['name'];

                if (array_key_exists($column['name'], $_SESSION['live']['tables'][$table]['columns'])) {
                    // the column exists, does it have an AUTO_INCREMENT?
                    // if not, is it the same?
                    if ((strpos($column['details'], 'AUTO_INCREMENT') !== false) ||
                    (strcmp($column['details'], $_SESSION['live']['tables'][$tName]['columns'][$cName]['details']) != 0)) {
                        // the columns are no the same so modify the existing one
                        // or the dev column has AUTO_INCREMENT
                        $info = str_replace('AUTO_INCREMENT', '', $column['modify']);
                    }
                } else {
                    //column does not exist, so add it
                    $info = str_replace('AUTO_INCREMENT', '', $column['create']);
                }
                //check to see if info has been changed, if so add the
                //relevant data to the SQL statement
                if (strcmp($info, '') != 0) {
                    if ($count == 0) {
                        //no previous statements have been added so no new
                        //line is needed
                        $statement .= $info;
                    } else {
                        $statement .= ", \n" . $info;
                    }
                    $count++;
                }
            }
            //check for columns to remove
            foreach ($_SESSION['live']['tables'][$table]['columns'] as $column) {
                //if the column only exists in live then drop it
                if (!array_key_exists($column['name'], $_SESSION['dev']['tables'][$table]['columns'])) {
                    if ($count == 0) {
                        //no previous statements have been added so no new
                        //line is needed
                        $statement .= $column['drop'];
                    } else {
                        $statement .= ", \n" . $column['drop'];
                    }
                }
            }

            if ($count != 0) {
                $sql_commands_to_run[] = $statement . ';';
            }
        }

        return $sql_commands_to_run;
    }
}
