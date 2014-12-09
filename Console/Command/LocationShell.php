<?php
/**
 * Created by PhpStorm.
 * User: elliotmoso
 * Date: 09/12/14
 * Time: 12:17
 */

/**
 * Class LocationShell
 * @property GoogleLocationModel $GoogleLocation
 */
class LocationShell extends AppShell{

    public $uses=array('GoogleLocation.GoogleLocation');
    public function out($message = null, $newlines = 1, $level = Shell::NORMAL) {
        parent::out($message,$newlines,$level);
    }
    public function search(){
        $direction=$this->in('Insert Location: ');
        $out= $this->GoogleLocation->find('all',array('conditions'=>array('address'=>$direction)));
        print_r($out);
    }
} 