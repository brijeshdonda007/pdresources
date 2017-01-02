<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2006 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * Shopping Cart Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Shopping Cart
 * @author		ExpressionEngine Dev Team
 * @link		http://codeigniter.com/user_guide/libraries/cart.html
 */
class CI_Cart {

	// These are the regular expression rules that we use to validate the product ID and product name
	var $product_id_rules	= '\.a-z0-9_-'; // alpha-numeric, dashes, underscores, or periods
	var $product_name_rules	= '\.\:\-_ a-z0-9'; // alpha-numeric, dashes, underscores, colons or periods

	// Private variables.  Do not change!
	var $CI;
	var $_cart_contents	= array();


	/**
	 * Shopping Class Constructor
	 *
	 * The constructor loads the Session class, used to store the shopping cart contents.
	 */
	public function __construct($params = array())
	{
		// Set the super object to a local variable for use later
		$this->CI =& get_instance();

		// Are any config settings being passed manually?  If so, set them
		$config = array();
		if (count($params) > 0)
		{
			foreach ($params as $key => $val)
			{
				$config[$key] = $val;
			}
		}

		// Load the Sessions class
		$this->CI->load->library('session', $config);

		// Grab the shopping cart array from the session table, if it exists
		if ($this->CI->session->userdata('cart_contents') !== FALSE)
		{
			$this->_cart_contents = $this->CI->session->userdata('cart_contents');
		}
		else
		{
			// No cart exists so we'll set some base values
			$this->_cart_contents['cart_total'] = 0;
			$this->_cart_contents['cart_sub_total'] = 0;
			$this->_cart_contents['discount_total'] = 0;
			$this->_cart_contents['total_items'] = 0;
		}

		log_message('debug', "Cart Class Initialized");
	}

	// --------------------------------------------------------------------

	/**
	 * Insert items into the cart and save it to the session table
	 *
	 * @access	public
	 * @param	array
	 * @return	bool
	 */
	function insert($items = array())
	{

		// Was any cart data passed? No? Bah...
		if ( ! is_array($items) OR count($items) == 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// You can either insert a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one. The way we
		// determine the array type is by looking for a required array key named "id"
		// at the top level. If it's not found, we will assume it's a multi-dimensional array.

		$save_cart = FALSE;
		if (isset($items['id']))
		{
			if ($this->_insert($items) == TRUE)
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) AND isset($val['id']))
				{
					if ($this->_insert($val) == TRUE)
					{
						$save_cart = TRUE;
					}
				}
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart == TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Insert
	 *
	 * @access	private
	 * @param	array
	 * @return	bool
	 */
	function _insert($items = array())
	{
		// Was any cart data passed? No? Bah...
		if ( ! is_array($items) OR count($items) == 0)
		{
			log_message('error', 'The insert method must be passed an array containing data.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Does the $items array contain an id, quantity, price, and name?  These are required
		if ( ! isset($items['id']) OR ! isset($items['qty']) OR ! isset($items['price']) OR ! isset($items['name']))
		{
			log_message('error', 'The cart array must contain a product ID, quantity, price, and name.');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the quantity. It can only be a number.  Duh...
		$items['qty'] = trim(preg_replace('/([^0-9])/i', '', $items['qty']));
		// Trim any leading zeros
		$items['qty'] = trim(preg_replace('/(^[0]+)/i', '', $items['qty']));

		// If the quantity is zero or blank there's nothing for us to do
		if ( ! is_numeric($items['qty']) OR $items['qty'] == 0)
		{
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product ID. It can only be alpha-numeric, dashes, underscores or periods
		// Not totally sure we should impose this rule, but it seems prudent to standardize IDs.
		// Note: These can be user-specified by setting the $this->product_id_rules variable.
		if ( ! preg_match("/^[".$this->product_id_rules."]+$/i", $items['id']))
		{
			log_message('error', 'Invalid product ID.  The product ID can only contain alpha-numeric characters, dashes, and underscores');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Validate the product name. It can only be alpha-numeric, dashes, underscores, colons or periods.
		// Note: These can be user-specified by setting the $this->product_name_rules variable.
		if ( ! preg_match("/^[".$this->product_name_rules."]+$/i", $items['name']))
		{
			log_message('error', 'An invalid name was submitted as the product name: '.$items['name'].' The name can only contain alpha-numeric characters, dashes, underscores, colons, and spaces');
			return FALSE;
		}

		// --------------------------------------------------------------------

		// Prep the price.  Remove anything that isn't a number or decimal point.
		$items['price'] = trim(preg_replace('/([^0-9\.])/i', '', $items['price']));
		// Trim any leading zeros
//		$items['price'] = trim(preg_replace('/(^[0]+)/i', '', $items['price']));

		// Is the price a valid number?
		if ( ! is_numeric($items['price']))
		{
			log_message('error', 'An invalid price was submitted for product ID: '.$items['id']);
			return FALSE;
		}

		// --------------------------------------------------------------------

		// We now need to create a unique identifier for the item being inserted into the cart.
		// Every time something is added to the cart it is stored in the master cart array.
		// Each row in the cart array, however, must have a unique index that identifies not only
		// a particular product, but makes it possible to store identical products with different options.
		// For example, what if someone buys two identical t-shirts (same product ID), but in
		// different sizes?  The product ID (and other attributes, like the name) will be identical for
		// both sizes because it's the same shirt. The only difference will be the size.
		// Internally, we need to treat identical submissions, but with different options, as a unique product.
		// Our solution is to convert the options array to a string and MD5 it along with the product ID.
		// This becomes the unique "row ID"
		if (isset($items['options']) AND count($items['options']) > 0)
		{
			$rowid = md5($items['id'].implode('', $items['options']));
		}
		else
		{
			// No options were submitted so we simply MD5 the product ID.
			// Technically, we don't need to MD5 the ID in this case, but it makes
			// sense to standardize the format of array indexes for both conditions
			$rowid = md5($items['id']);
		}

		// --------------------------------------------------------------------

		// Now that we have our unique "row ID", we'll add our cart items to the master array

		// let's unset this first, just to make sure our index contains only the data from this submission
		unset($this->_cart_contents['Item'][$rowid]);

		// Create a new index with our new row ID
		$this->_cart_contents['Item'][$rowid]['rowid'] = $rowid;

		// And add the new items to the cart array
		foreach ($items as $key => $val)
		{
			$this->_cart_contents['Item'][$rowid][$key] = $val;
		}
		// Woot!
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits the quantity of a given item to be changed.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each item.
	 *
	 * @access	public
	 * @param	array
	 * @param	string
	 * @return	bool
	 */
	function update($items = array())
	{
		// Was any cart data passed?
		if ( ! is_array($items) OR count($items) == 0)
		{
			return FALSE;
		}

		// You can either update a single product using a one-dimensional array,
		// or multiple products using a multi-dimensional one.  The way we
		// determine the array type is by looking for a required array key named "id".
		// If it's not found we assume it's a multi-dimensional array
		$save_cart = FALSE;
		if (isset($items['rowid']) AND isset($items['qty']))
		{
			if ($this->_update($items) == TRUE)
			{
				$save_cart = TRUE;
			}
		}
		else
		{
			foreach ($items as $val)
			{
				if (is_array($val) AND isset($val['rowid']) AND isset($val['qty']))
				{
					if ($this->_update($val) == TRUE)
					{
						$save_cart = TRUE;
					}
				}
			}
		}

		// Save the cart data if the insert was successful
		if ($save_cart == TRUE)
		{
			$this->_save_cart();
			return TRUE;
		}

		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Update the cart
	 *
	 * This function permits the quantity of a given item to be changed.
	 * Typically it is called from the "view cart" page if a user makes
	 * changes to the quantity before checkout. That array must contain the
	 * product ID and quantity for each item.
	 *
	 * @access	private
	 * @param	array
	 * @return	bool
	 */
	function _update($items = array())
	{
		// Without these array indexes there is nothing we can do
		if ( ! isset($items['qty']) OR ! isset($items['rowid']) OR ! isset($this->_cart_contents['Item'][$items['rowid']]))
		{
			return FALSE;
		}

		// Prep the quantity
		$items['qty'] = preg_replace('/([^0-9])/i', '', $items['qty']);

		// Is the quantity a number?
		if ( ! is_numeric($items['qty']))
		{
			return FALSE;
		}

		// Is the new quantity different than what is already saved in the cart?
		// If it's the same there's nothing to do
		if ($this->_cart_contents['Item'][$items['rowid']]['qty'] == $items['qty'])
		{
			return FALSE;
		}

		// Is the quantity zero?  If so we will remove the item from the cart.
		// If the quantity is greater than zero we are updating
		if ($items['qty'] == 0)
		{
			unset($this->_cart_contents['Item'][$items['rowid']]);
		}
		else
		{
			$this->_cart_contents['Item'][$items['rowid']]['qty'] = $items['qty'];
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Save the cart array to the session DB
	 *
	 * @access	private
	 * @return	bool
	 */
	function _save_cart()
	{
		$this->_calculate_discount();
		$temp_discount=0;
		// Unset these so our total can be calculated correctly below
		unset($this->_cart_contents['total_items']);
		unset($this->_cart_contents['cart_sub_total']);
		unset($this->_cart_contents['discount_total']);
		unset($this->_cart_contents['cart_total']);
		$temp_discount=$this->_cart_contents['tmp_discount_total'];
		unset($this->_cart_contents['tmp_discount_total']);
				
		// Lets add up the individual prices and set the cart sub-total
		$total = 0;
		$discount_total=0;
		$item_counter=0;
		foreach ($this->_cart_contents['Item'] as $key => $val)
		{			
			$subtotal=0;
			$subtotal=($val['price'] * $val['qty']);
			$total += $subtotal;
			$discount_total +=$val['discount'];			
			
			// Set the subtotal
			$this->_cart_contents['Item'][$key]['subtotal'] = $subtotal;
			$this->_cart_contents['Item'][$key]['total'] = $subtotal-$val['discount'];
		}
				
		// Set the cart total and total items.
		$this->_cart_contents['total_items'] = count($this->_cart_contents['Item']);
		
		$this->_cart_contents['cart_sub_total'] = $total;
		
		if($discount_total > 0)
			$this->_cart_contents['discount_total'] = $discount_total;
		else
			$this->_cart_contents['discount_total'] = $temp_discount;		
			
		if($this->_cart_contents['cart_sub_total'] > $this->_cart_contents['discount_total'])
			$this->_cart_contents['cart_total'] = $this->_cart_contents['cart_sub_total']-$this->_cart_contents['discount_total'];		
		else
			$this->_cart_contents['cart_total'] = $this->_cart_contents['cart_sub_total'];
		
		$this->CI->session->set_userdata(array('cart_contents' => $this->_cart_contents));
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Total
	 *
	 * @access	public
	 * @return	integer
	 */
	function total()
	{
		return $this->_cart_contents['cart_total'];
	}

	// --------------------------------------------------------------------

	/**
	 * Total Items
	 *
	 * Returns the total item count
	 *
	 * @access	public
	 * @return	integer
	 */
	function total_items()
	{
		return $this->_cart_contents['total_items'];
	}

	// --------------------------------------------------------------------

	/**
	 * Cart Contents
	 *
	 * Returns the entire cart array
	 *
	 * @access	public
	 * @return	array
	 */
	function contents()
	{
		$cart = $this->_cart_contents['Item'];

		// Remove these so they don't create a problem when showing the cart table
		unset($cart['total_items']);
		unset($cart['cart_total']);
		unset($cart['cart_sub_total']);
		unset($cart['discount_total']);
		return $cart;
	}

	// --------------------------------------------------------------------

	/**
	 * Has options
	 *
	 * Returns TRUE if the rowid passed to this function correlates to an item
	 * that has options associated with it.
	 *
	 * @access	public
	 * @return	array
	 */
	function has_options($rowid = '')
	{
		if ( ! isset($this->_cart_contents[$rowid]['options']) OR count($this->_cart_contents[$rowid]['options']) === 0)
		{
			return FALSE;
		}

		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * Product options
	 *
	 * Returns the an array of options, for a particular product row ID
	 *
	 * @access	public
	 * @return	array
	 */
	function product_options($rowid = '')
	{
		if ( ! isset($this->_cart_contents[$rowid]['options']))
		{
			return array();
		}

		return $this->_cart_contents[$rowid]['options'];
	}

	// --------------------------------------------------------------------

	/**
	 * Format Number
	 *
	 * Returns the supplied number with commas and a decimal point.
	 *
	 * @access	public
	 * @return	integer
	 */
	function format_number($n = '')
	{
		if ($n == '')
		{
			return '';
		}

		// Remove anything that isn't a number or decimal point.
		$n = trim(preg_replace('/([^0-9\.])/i', '', $n));

		return number_format($n, 2, '.', ',');
	}

	// --------------------------------------------------------------------

	/**
	 * Destroy the cart
	 *
	 * Empties the cart and kills the session
	 *
	 * @access	public
	 * @return	null
	 */
	function destroy()
	{
		unset($this->_cart_contents);

		$this->_cart_contents['cart_total'] = 0;
		$this->_cart_contents['cart_sub_total'] = 0;
		$this->_cart_contents['total_items'] = 0;
		$this->_cart_contents['discount_total'] = 0;

		$this->CI->session->unset_userdata('cart_contents');
	}	
	
    function sub_total() {
		$total=0;
		foreach ($this->_cart_contents['Item'] as $key => $val)
		{		
			$total += ($val['price'] * $val['qty']);		
		}
        return $total;
    } 

	function coupon($coupon = array(), $cart = 'default') {

        $this->_cart_contents['coupon'] = $coupon;
//		$this->_calculate_discount();		

        if($this->_save_cart()) {
            return TRUE;
        }
        else return FALSE;
    }

    function has_coupon() {
        if(isset($this->_cart_contents['coupon'])) {
            return $this->_cart_contents['coupon'];
        }
        else return FALSE;
    }
	
	function delete_coupon() {

        unset($this->_cart_contents['coupon']);
        if($this->_save_cart()) {
            return TRUE;
        }
        else return FALSE;
    }
	
	function discount_total()
	{		
		return $this->_cart_contents['discount_total'];	 
	}
	
	function _calculate_discount()
	{
		$CouponInfo=$this->has_coupon();
		if($CouponInfo)
		{
			$this->_cart_contents['tmp_discount_total']=0;

			if(count($CouponInfo['Item_ids']) > 0)
			{
				// Lets add up the individual prices and set the cart sub-total
				$total = 0;
				$discount_total=0;
				foreach ($this->_cart_contents['Item'] as $key => $val)
				{
					$discount_amt=$total=0;
					$total = ($val['price'] * $val['qty']);
					if(in_array($val['id'],$CouponInfo['Item_ids']))
					{
						if($CouponInfo['Type'] == 'Fix')
							$discount_amt=$total-$CouponInfo['amount'];
						else
							$discount_amt=(float)($total*$CouponInfo['amount'])/100;
					}
					// Set the discountamount
					$this->_cart_contents['Item'][$key]['discount'] = $discount_amt;
				}
			}			
			else
			{
				if($CouponInfo['Type'] == 'Fix')
					$this->_cart_contents['tmp_discount_total']=$CouponInfo['amount'];
				else
				{
					$this->_cart_contents['tmp_discount_total']=(float)($this->sub_total()*$CouponInfo['amount'])/100;
				}
			}			
			// Woot!
			return TRUE;
		}
		else 
		{
			$this->_cart_contents['tmp_discount_total']=0;
			foreach ($this->_cart_contents['Item'] as $key => $val)
			{
				$this->_cart_contents['Item'][$key]['discount'] = 0;
			}			
			// Woot!
			return TRUE;			
		}			
	}
	
}
// END Cart Class

/* End of file Cart.php */
/* Location: ./system/libraries/Cart.php */