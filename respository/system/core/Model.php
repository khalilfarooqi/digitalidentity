<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package CodeIgniter
 * @author  EllisLab Dev Team
 * @copyright   Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright   Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license http://opensource.org/licenses/MIT  MIT License
 * @link    https://codeigniter.com
 * @since   Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 * @author      EllisLab Dev Team
 * @link        https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model
{
  /**
   * The table associated with the model.
   *
   * @var string
   */
    protected $table;

    /**
     * The connection name for the model.
     *
     * @var string
     */

    protected $db;

    /**
     * Class constructor
     *
     * @return  void
     */
    public function __construct()
    {
        log_message('info', 'Model Class Initialized');

        $this->db = $this->load->database('default',TRUE);
    }

    public function __get($key)
    {
        return get_instance()->$key ?? '';
    }

    /*
     * Synchronization Method
     *
     * Relation: @table
     * @param 1: (array) Post IDs
     * @param 2: synchronization column name like "user_id"
     * @param 3: synchronization where clause column name like "task_id"
     * @param 4: synchronization where clause id like "transaction_id"
     *
     * **/
    public function synchronization( $table, $data, $sync_column, $column, $value )
    {
        $rows_sync = $this->get($table, array($column => $value), $sync_column);

        if( count($rows_sync) )
            $rows_sync = array_get($rows_sync, $sync_column);

        $new_sync   = array_diff($data, $rows_sync);
        $cross_sync = array_diff($rows_sync, $data);

        /*dd($rows_sync, false, 'DB Users');
        dd($data, false, 'Post Users');
        dd($new_sync, false, 'New Rows');
        dd($cross_sync, true, 'Delete Rows');*/

        if( count($new_sync) )
        {
            $synchro = array();

            foreach ($new_sync as $fetch){
                $synchro[] = array(
                    $sync_column => $fetch,
                    $column => $value
                );
            }

            $this->insert_batch( $table, $synchro );
        }

        if( count($cross_sync) ) {

            $this->db->where_in($sync_column, $cross_sync);
            $this->db->where($column, $value);

            $this->db->delete($table);
        }

        return true;
    }

    public function countSelect( $select, $table, $where = NULL )
    {
        $this->db->select($select);

        if( $where ) $this->db->where($where);

        $result = $this->db->get( $table )->row();

        return (int) ($result->$select ?? 0);
    }

    public function FirstOrNull($table, $where = array(), $columns = '*' )
    {
        $this->db->where($where);

        return $this->db->select($columns)->get($table)->row_array();
    }

    public function get( $table, $where = array(), $columns = '*' )
    {
        $this->db->where($where);
        $this->db->select($columns);

        return $this->db->get($table)->result_array();
    }

    public function insert_batch( $table, $data)
    {
        $this->db->insert_batch($table, $data);

        return TRUE;
    }

    public function insert( $table, $set )
    {
        return $this->db->insert($table, $set);
    }

    public function insertId( $table, $set )
    {
        $this->db->insert($table, $set);

        return $this->db->insert_id();
    }

    public function updateOrCreate( $table, $set, $id = null )
    {
        if( empty($id) ) {

            $transaction = $this->insert($table, $set);

            if( $transaction )
                return $this->db->insert_id();
        }

        $transaction = $this->update($table, $set, array(
            'id' => $id
        ));

        return (int) ($transaction ? $id : false);
    }

    public function findUpdateOrCreate( $table, $where, $set )
    {
        $findFirst = $this->FirstOrNull($table, $where, $columns = 'id');

        if( !$findFirst ) {

            $set = array_merge($set, $where);

            $transaction = $this->insert($table, $set);

            if( $transaction )
                return $this->db->insert_id();
        }


        $transaction = $this->update($table, $set, $where);

        return (int) $findFirst['id'] ?? 0;
    }

    public function update( $table, $set, $where )
    {
        $this->db->where($where);

        return $this->db->update($table, $set);
    }

    public function delete( $table, $where )
    {
        $this->db->set('is_enable', 2 );

        $this->db->where($where);

        return $this->db->update($table);
    }

    public function destroy( $table, $where )
    {
        $this->db->where($where);

        return (bool) $this->db->delete($table);
    }
}
