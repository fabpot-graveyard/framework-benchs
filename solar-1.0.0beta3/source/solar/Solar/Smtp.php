<?php
/**
 * 
 * Factory class for SMTP connections.
 * 
 * @category Solar
 * 
 * @package Solar_Smtp
 * 
 * @author Paul M. Jones <pmjones@solarphp.com>
 * 
 * @license http://opensource.org/licenses/bsd-license.php BSD
 * 
 * @version $Id: Smtp.php 3850 2009-06-24 20:18:27Z pmjones $
 * 
 */
class Solar_Smtp extends Solar_Factory
{
    /**
     * 
     * Default configuration values.
     * 
     * @config string adapter The class to factory, for example 'Solar_Smtp_Adapter_NoAuth'.
     * 
     * @var array
     * 
     */
    protected $_Solar_Smtp = array(
        'adapter' => 'Solar_Smtp_Adapter_NoAuth',
    );
}