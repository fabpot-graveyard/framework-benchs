<?php
/**
 * 
 * Example for testing a model of content node "metas" (metadata).
 * 
 * @category Solar
 * 
 * @package Mock_Solar
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Metas.php 4263 2009-12-07 19:25:31Z pmjones $
 * 
 */
class Mock_Solar_Model_Metas extends Solar_Sql_Model
{
    /**
     * 
     * Model setup.
     * 
     * @return void
     * 
     */
    protected function _setup()
    {
        $dir = str_replace('_', DIRECTORY_SEPARATOR, __CLASS__)
             . DIRECTORY_SEPARATOR
             . 'Setup'
             . DIRECTORY_SEPARATOR;
        
        $this->_table_name = Solar_File::load($dir . 'table_name.php');
        $this->_table_cols = Solar_File::load($dir . 'table_cols.php');
        
        $this->_model_name = 'metas';
        
        $this->_belongsTo('node');
        
        $this->_index = array(
            'node_id',
        );
    }
}