<?php
/**
 * @file Checkout.php
 *
 * Checkout Model
 *
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Checkout extends AppModel {

    public $belongsTo = array('User', 'Boardgame');

}