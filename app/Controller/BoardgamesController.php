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
     * Displays the thumbnail image from BoardGameGeek
     *
     * @param int $id The Thing ID from BGG API
     */
    public function bggthumbnail($id) {
        $this->autoRender = false;
        $item = $this->Bgg->findById($id);
        $item = $item['Bgg']['items']['item'];
        
        if (!isset($item['thumbnail'])) {
            $item['thumbnail'] = WWW_ROOT . DS . 'img' . DS . 'missing-image.png';
        }
        
        $parts = pathinfo($item['thumbnail']);
		switch ($parts['extension']) {
			case 'jpg':
				header('Content-type: image/jpeg');
				break;
			case 'png':
				header('Content-type: image/png');
				break;
			case 'gif':
				header('Content-type: image/gif');
				break;
			default:
				header('Content-type: application/octet-stream');
		}

		ob_start();
		$context = stream_context_create(array('http' => array('header' => 'Connection: close')));
		if (($fp = fopen($item['thumbnail'], 'r', false, $context)) !== false) {
			while (!feof($fp)) {
				echo fgets($fp, 1024);
				ob_flush();
				flush();
			}
			fclose($fp);
		} else {
			header("HTTP/1.0 500 Internal Server Error");		
		}
		ob_end_flush();
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