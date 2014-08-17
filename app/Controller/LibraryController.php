<?php
/**
 * @file LibraryController.php
 *
 * Controller to handle board game check ins/outs and display library
 *
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

class LibraryController extends AppController {

    public $uses = array('Boardgame', 'User', 'Checkout');
    
    /**
     * Display index (nothing really there
     *
     * @see View/Library/index.ctp
     */
    public function index() {   }
    
    /**
     * Display a list of users that have checked out games
     *
     * @see View/Library/users.ctp
     */
    public function users() {
        $this->set('users', $this->User->find('all'));
    }
    
    /**
     * Display the board game library
     *
     * @see View/Library/browse.ctp
     */
    public function browse() {
        $this->set('filter', 'All');
        /* Check if a filter is being used */
        if (isset($this->params['named']['filter'])) {
            switch ($this->params['named']['filter']) {
                case 'checkout':
                    $this->set('filter', 'Checked Out');
                    $g = $this->Boardgame->findCheckedOut();
                    break;
                case 'checkin':
                    $this->set('filter', 'Checked In');
                    $g = $this->Boardgame->findCheckedIn();
                    break;
                default:
                    $g = $this->Boardgame->find('all', array('order' => 'title ASC'));  
            }
        }
        else {
            $g = $this->Boardgame->find('all', array('order' => 'title ASC'));
        }        
        $this->set('games', $g);
    }
    
    /**
     * Check out process
     *
     * @see View/Library/checkout.ctp
     * @see View/Library/checkout_2.ctp
     * @see View/Library/checkout_3.ctp
     */
    public function checkout() {
        if ($this->request->is('post')) {
            $this->view = 'checkout_' . $this->request->data['Boardgame']['nextstep'];
            
            switch ($this->request->data['Boardgame']['nextstep']) {
                case 2:
                    /* Step 2 checks for user, or asks for new user information */
                    $rs =  $this->User->findByIdentifierWithCheckout($this->request->data['User']['identifier']);
                    if (!$rs) $this->Session->setFlash('User could not be found', 'danger_flash');
                    $this->set('user', $rs);
                    break;
                case 3:
                    /* Step 3 creats a new user and/or looks up the given board game */
                    if (isset($this->request->data['User']['name']) && isset($this->request->data['User']['identifier'])) {
                        if (!$this->User->save($this->request->data['User'])) {
                            $this->view = 'checkout_' . 2;
                            break;
                        }
                        else {
                            $this->request->data['User']['id'] = $this->User->id;
                        }
                    }
                    $rs = $this->Boardgame->findByUpc($this->request->data['Boardgame']['upc']);
                    $user = $this->User->findByIdWithCheckout($this->request->data['User']['id']);
                    if (!$rs) {
                        $this->Session->setFlash('Board game could not be found. Please add it to the Library first.', 'danger_flash');
                        $this->redirect(array('controller' => 'library', 'action' => 'checkout'));
                    }
                    $this->set('user', $user);
                    $this->set('boardgame', $rs);
                    break;
                case 4:
                    /* Step 4 checks out the game */
                    if ($this->Checkout->save(array(
                        'boardgame_id' => $this->request->data['Boardgame']['id'],
                        'user_id' => $this->request->data['User']['id'],
                        'checkout' => date('Y-m-d H:i:s')
                    ))) {
                        $title = $this->Boardgame->field('title', array('id' => $this->request->data['Boardgame']['id']));
                        $name = $this->User->field('name', array('id' => $this->request->data['User']['id']));
                        $this->Session->setFlash('Successfully checked out ' . $title . ' to ' . $name, 'success_flash');
                    }
                    else {
                        $this->Session->setFlash('Failed to check out item', 'danger_flash');
                    }
                    $this->redirect(array('controller' => 'library', 'action' => 'checkout'));
                    break;
            }
        }
    }
    
    /**
     * Check In process
     *
     * @see View/Library/checkin.ctp
     */
    public function checkin() {
        if ($this->request->is('post')) {
            if (($id = $this->Boardgame->field('id', array('upc' => $this->request->data['Boardgame']['upc'])))) {
                if ($this->Checkout->updateAll(array('checkin' => "'" . date('Y-m-d H:i:s') . "'"), array('boardgame_id' => $id))) {
                    $this->Session->setFlash('Check In successfull', 'success_flash');
                }
                else {
                    $this->Session->setFlash('Error occured when updating the check in');
                }
            }
            else {
                $this->Session->setFlash('Unable to locate game to check in.', 'danger_flash');
            }
        }
        unset($this->request->data['Boardgame']);
    }

}