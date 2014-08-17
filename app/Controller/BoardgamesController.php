<?php
/**
 * @file BoardgamesController.php
 *
 * Controller to handle board game information
 *
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class BoardgamesController extends AppController {

    public $uses = array('Boardgame', 'Bgg');

    /**
     * Adds a new board game to the library
     *
     * @param int $id BoardGameGeek Thing ID
     * @see View/Boardgames/add.ctp
     */
    public function add($id = null) {
        if ($this->request->is('post')) {
            $this->autoRender = false;
            $this->response->type('json');
            
            $rs = array();
            if (!empty($this->request->data['Bgg']['title'])) {
                $rs = $this->Bgg->findByTitle($this->request->data['Bgg']['title']);
            }
            
            $this->response->body(json_encode($rs));
        }
        elseif($id) {
            $rs = $this->Bgg->findById($id);
            $rs = $this->Boardgame->insertBgg($rs);
            $this->redirect(array('controller' => 'boardgames', 'action' => 'edit', $rs['Boardgame']['id']));            
        }
    }
    
    /**
     * View a selected board game
     *
     * @param int $id Boardgame Model ID
     * @see View/Boardgames/edit.ctp
     */
    public function view($id = null) {
        $this->view = 'edit';
        $this->_displayLibrary($id);
    }
    
    /**
     * Edit board game information
     *
     * @param int $id Boardgame Model ID
     * @see View/Boardgames/edit.ctp
     */
    public function edit($id = null) {
        if ($this->request->is('put')) {
            if (($rs = $this->Boardgame->save($this->request->data))) {
                $title = $this->Boardgame->field('title', array('id' => $rs['Boardgame']['id']));
                $this->Session->setFlash( htmlspecialchars_decode($title) . ' has been saved', 'success_flash');
            }
            else {
                $this->Session->setFlash('There was a error saving your changes.', 'danger_flash');
            }
            $this->redirect(array('controller' => 'library', 'action' => 'browse'));
        }
        $this->_displayLibrary($id);
    }
    
    /**
     * Loads Boardgame information into the request data used in the views
     *
     * @param int $id Boardgame Model ID
     */
    public function _displayLibrary($id) {
        $this->request->data = $this->Boardgame->findByIdWithCheckoutUsers($id);
        $this->set('user', $this->Boardgame->Checkout->find('all', array(
            'conditions' => array(
                'boardgame_id' => $id,
                'checkin' => null
            )
        )));
    }
}