<?php
/**
 * Lithium: the most rad php framework
 *
 * @copyright     Copyright 2010, Union of RAD (http://union-of-rad.org)
 * @license       http://opensource.org/licenses/bsd-license.php The BSD License
 */

namespace lithium\template;

use \lithium\util\String;

abstract class Helper extends \lithium\core\Object {

	/**
	 * Maps helper method names to content types as defined by the `Media` class, where key are
	 * method names, and values are the content type that the method name outputs a link to.
	 *
	 * @var array
	 */
	public $contentMap = array();

	/**
	 * Holds string templates which will be merged into the rendering context.
	 *
	 * @var array
	 */
	protected $_strings = array();

	protected $_context = null;

	protected $_autoConfig = array('classes' => 'merge', 'context');

	/**
	 * List of minimized HTML attributes.
	 *
	 * @var array
	 */
	protected $_minimized = array(
		'compact', 'checked', 'declare', 'readonly', 'disabled', 'selected', 'defer', 'ismap',
		'nohref', 'noshade', 'nowrap', 'multiple', 'noresize'
	);

	public function __construct($config = array()) {
		$defaults = array('handlers' => array(), 'context' => null);
		parent::__construct($config + $defaults);
	}

	/**
	 * Imports local string definitions into rendering context.
	 *
	 * @return void
	 */
	protected function _init() {
		parent::_init();

		if (!$this->_context) {
			return;
		}
		$this->_context->strings($this->_strings);

		if ($this->_config['handlers']) {
			$this->_context->handlers($this->_config['handlers']);
		}
	}

	/**
	 * Escapes values according to the output type of the rendering context. Helpers that output to
	 * non-HTML/XML contexts should override this method accordingly.
	 *
	 * @param string $value
	 * @param mixed $method
	 * @param array $options
	 * @return mixed
	 */
	public function escape($value, $method = null, $options = array()) {
		$defaults = array('escape' => true);
		$options += $defaults;

		if ($options['escape'] === false) {
			return $value;
		}
		if (is_array($value)) {
			return array_map(array($this, __FUNCTION__), $value);
		}
		return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
	}

	protected function _render($method, $string, $params, $options = array()) {
		$defaults = array();
		$options += $defaults;

		foreach ($params as $key => $value) {
			$params[$key] = $this->_context->applyHandler($this, $method, $key, $value, $options);
		}
		$strings = $this->_context ? $this->_context->strings() : $this->_strings;
		return String::insert(isset($strings[$string]) ? $strings[$string] : $string, $params);
	}

	protected function _attributes($params, $method = null, $options = array()) {
		if (!is_array($params)) {
			return empty($params) ? '' : ' ' . $params;
		}

		$defaults = array('escape' => true, 'prepend' => ' ', 'append' => '');
		$options += $defaults;
		$result = array();

		foreach ($params as $key => $value) {
			$result[] = $this->_formatAttr($key, $value, $options);
		}
		return $result ? $options['prepend'] . implode(' ', $result) . $options['append'] : '';
	}

	protected function _formatAttr($key, $value, $options = array()) {
		$defaults = array('escape' => true);
		$options += $defaults;

		$format = '%s="%s"';
		$value = (string) $value;

		if (in_array($key, $this->_minimized)) {
			$isMini = ($value == 1 || $value === true || $value === 'true' || $value == $key);
			if (!($value = $isMini ? $key : $value)) {
				return null;
			}
		}

		if ($options['escape']) {
			return sprintf($format, $this->escape($key), $this->escape($value));
		}
		return sprintf($format, $key, $value);
	}
}

?>