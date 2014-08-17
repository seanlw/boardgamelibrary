<?php
/**
 * @file User.php
 *
 * User Model
 *
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class User extends AppModel {

    public $hasMany = array('Checkout');

    public $validate = array(
        'identifier' => array(
            'isUnique' => array(
                'rule' => 'isUnique',
                'message' => 'Identification code is already in use'
            ),
            'notEmpty' => array(
                'rule' => 'notEmpty',
                'message' => 'Identification code must not be empty'
            )
        ),
        'name' => array(
            'rule' => 'notEmpty',
            'message' => 'Name can not be empty'
        )
    );
    
    /**
     * Find user by identifier and include check out information
     *
     * @param int $id The User Model ID
     * @return array
     */
    public function findByIdentifierWithCheckout($id) {
        $this->Behaviors->load('Containable');
        return $this->find('first', array(
            'conditions' => array(
                'identifier' => $id
            ),
            'contain' => array(
                'Checkout' => array(
                    'conditions' => array(
                        'checkin' => null
                    ),
                    'Boardgame' => array(
                        'fields' => array('id', 'title')
                    )
                )
            )
        ));
    }
    
    /**
     * Find user by Model ID and include check out information
     *
     * @param int $id User Model ID
     * @return array
     */
    public function findByIdWithCheckout($id) {
        $this->Behaviors->load('Containable');
        return $this->find('first', array(
            'conditions' => array(
                'id' => $id
            ),
            'contain' => array(
                'Checkout' => array(
                    'conditions' => array(
                        'checkin' => null
                    ),
                    'Boardgame' => array(
                        'fields' => array('id', 'title')
                    )
                )
            )
        ));
    }
}