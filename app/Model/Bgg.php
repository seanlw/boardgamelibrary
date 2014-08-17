<?php
/**
 * @file Bgg.php
 *
 * Model used to get board game information from BoardgameGeek
 *
 * @link http://boardgamegeek.com
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Xml', 'Utility');
class Bgg extends AppModel {

    public $useTable = false;
    public $config = array(
        'endpoint' => 'http://www.boardgamegeek.com/xmlapi2/'
    );
    
    /**
     * Finds board game information
     *
     * @param int $id BoardGameGeek Thing ID
     * @return array
     */
    public function findById($id) {
        return array($this->alias => $this->_request('thing', array('id' => $id)));
    }
    
    /**
     * Finds board games by title
     *
     * @param string $title Board game title
     * @return array
     */
    public function findByTitle($title) {
        $title = str_replace(array(' ', '%20'), '+', $title);
        return array($this->alias => $this->_request('search', array('query' => $title, 'type' => 'boardgame,boardgameexpansion')));
    }
    
    /**
     * Makes a request to BoardGameGeek API
     *
     * @param string $action The action to request in the API
     * @param array $params The query params to pass to the API
     * @return array
     */
    private function _request($action, $params = array()) {
        $url = $this->config['endpoint'] . $action . ($params ? '?' . http_build_query($params) : '');
        return Xml::toArray(Xml::build($url));
    }
}