<?php
declare(ENCODING = 'utf-8');
namespace F3\Hello\Controller;

/*                                                                        *
 * This script belongs to the FLOW3 package "Hello".                      *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License as published by the *
 * Free Software Foundation, either version 3 of the License, or (at your *
 * option) any later version.                                             *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * Standard controller for the Hello package 
 *
 * @version $Id: $
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License, version 3 or later
 */
class StandardController extends \F3\FLOW3\MVC\Controller\ActionController {

	/**
	 * 
	 *
	 * @param string $name The name
	 * @return string
	 */
	public function indexAction($name) {
    $this->view->assign('name', $name);
	}

	/**
	 * 
	 *
	 * @return string
	 */
	public function productsAction() {
    $products = array();
    for ($i = 1; $i <= 15; $i++)
    {
      $product = new Product();
      $product->id = $i;
      $product->title = 'foo'.$i;
      $products[] = $product;
    }
    $this->view->assign('products', $products);
	}
	
	/**
	 * 
	 *
	 * @param string $id The id
	 * @return string
	 */
	public function productAction($id) {
  }
}

class Product
{
  /* @var string */
  public $id;

  /* @var string */
  public $title;
}
