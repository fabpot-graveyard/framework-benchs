<?php
/**
 * 
 * Class for reading user roles and groups.
 * 
 * @category Solar
 * 
 * @package Solar_Role
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Role.php 3850 2009-06-24 20:18:27Z pmjones $
 * 
 */
class Solar_Role extends Solar_Factory
{
    /**
     * 
     * Default configuration values.
     * 
     * @config string adapter The adapter class to use.
     * 
     * @var array
     * 
     */
    protected $_Solar_Role = array(
        'adapter' => 'Solar_Role_Adapter_None',
    );
}
