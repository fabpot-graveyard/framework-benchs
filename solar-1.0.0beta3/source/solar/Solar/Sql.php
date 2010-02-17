<?php
/**
 * 
 * Factory class for SQL connections.
 * 
 * @category Solar
 * 
 * @package Solar_Sql
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Sql.php 3850 2009-06-24 20:18:27Z pmjones $
 * 
 */
class Solar_Sql extends Solar_Factory
{
    /**
     * 
     * Default configuration values.
     * 
     * @config string adapter The class to factory, for example 'Solar_Sql_Adapter_Mysql'.
     * 
     * @var array
     * 
     */
    protected $_Solar_Sql = array(
        'adapter' => 'Solar_Sql_Adapter_Sqlite',
    );
}
