<?php
/**
 * @file Boardgame.php
 *
 * Boardgame Model
 *
 * @author Sean Watkins <seanlw@gmail.com>
 * @license   MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
class Boardgame extends AppModel {

    public $hasMany = array('Checkout');
    
    public $validate = array(
        'upc' => array(
            'rule' => 'isUnique',
            'message' => 'Identifying code is already in use'
        )
    );

    /**
     * Gets board game information from BGG and inserts it into the Database
     *
     * @param array $bgg An array from Bgg Model
     * @return array
     */
    public function insertBgg($bgg) {
        if (!isset($bgg['Bgg']['items']['item'])) return false;
        
        $item = $bgg['Bgg']['items']['item'];
        
        /* Setup the destenation for board game images */
        $baseimg = WWW_ROOT . 'img' . DS . 'boardgames' . DS;
        $image = $baseimg . 'images' . DS . basename($item['image']);
        $thumb = $baseimg . 'thumbnails' . DS . basename($item['thumbnail']);
        
        /* Get and store the images for local use */
        file_put_contents($image, file_get_contents($item['image']));
        file_put_contents($thumb, file_get_contents($item['thumbnail']));
        
        /* Need to seach for the primary game title, many titles will exist */
        $title = '';
        if (!isset($item['name'][0])) $item['name'] = array($item['name']);
        foreach ($item['name'] as $n) {
            if ($n['@type'] == 'primary') {
                $title = $n['@value'];
                break;
            }
        }
        
        /* Loop through the polls to find suggested number of players and find
           the one with the most votes
        */
        $bestwith = 0;
        foreach ($item['poll'] as $p) {
            if ($p['@name'] == 'suggested_numplayers') {
                $topvotes = 0;
                foreach ($p['results'] as $r) {
                    foreach ($r['result'] as $n) {
                        if ($n['@value'] == 'Best') {
                            if ($n['@numvotes'] > $topvotes) {
                                $bestwith = $r['@numplayers'];
                                $topvotes = $n['@numvotes'];
                            }
                            break;
                        }
                    }
                }
                break;
            }
        }
        
        return $this->save(array(
            'bgg_id' => $item['@id'],
            'title' => $title,
            'num_players' => $item['minplayers']['@value'] . ' - ' . $item['maxplayers']['@value'],
            'best_num_players' => $bestwith,
            'playing_time' => $item['playingtime']['@value'],
            'image' => basename($item['image']),
            'thumbnail' => basename($item['thumbnail']),
        ));
    }
    
    /**
     * Returs the board game and the user check out information
     *
     * @param int $id The Boardgame Model ID
     * @return array
     */
    public function findByIdWithCheckoutUsers($id) {
        $this->Behaviors->load('Containable');
        return $this->find('first', array(
            'conditions' => array( 'id' => $id ),
            'contain' => array(
                'Checkout' => array(
                    'User' => array(
                        'fields' => array('id', 'name')
                    )
                )
            )
        ));
    }
    
    /**
     * Returns all the games that are checked out
     *
     * @return array
     */
    public function findCheckedOut() {
        return $this->find('all', array(
            'joins' => array(
                array(
                    'table' => 'checkouts',
                    'alias' => 'Checkout',
                    'type' => 'inner',
                    'conditions' => array('Boardgame.id = Checkout.boardgame_id')
                )
            ),
            'conditions' => array(
                'Checkout.checkin' => null
            ),
            'group' => array('Boardgame.id'),
            'order' => 'Boardgame.title ASC'
        ));
    }
    
    /**
     * Returns all the games that are checked in
     *
     * @return array
     */
    public function findCheckedIn() {
        $rs = $this->find('all', array(
            'order' => 'title ASC'
        ));
        
        /* Go through all the checkouts and remove the games currently checked out.
           Can't see to figure out a good way to do this in a Model query
        */
        foreach ($rs as $key => $val) {
            foreach ($val['Checkout'] as $c) {
                if (!$c['checkin']) {
                    unset($rs[$key]);
                    break;
                }
            }
        }
        
        return $rs;
    }
    
    /**
     * afterFind overwride to include the board game checkout status IN/OUT
     */
    public function afterFind($results, $primary = false) {
        foreach ($results as $key => $val) {
            if (is_array($val) && isset($val['Checkout']) && $val['Checkout']) {
                if ($this->Checkout->find('first', array(
                    'conditions' => array(
                        'boardgame_id' => $val['Boardgame']['id'],
                        'checkin' => null
                    )
                )))
                {
                    $results[$key]['Boardgame']['status'] = 'out';    
                }
                else {
                    $results[$key]['Boardgame']['status'] = 'in';
                }
            }
            elseif (is_array($val) && isset($val['Boardgame'])) {
                $results[$key]['Boardgame']['status'] = 'in';
            }
        }
        
        return $results;
    }
}