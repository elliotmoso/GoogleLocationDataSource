<?php
/**
 * Created by PhpStorm.
 * User: elliotmoso
 * Date: 09/12/14
 * Time: 12:13
 */
App::uses('GoogleLocationAppModel','GoogleLocation.Model');

class GoogleLocationModel extends GoogleLocationAppModel{
    public $useDbConfig = 'GoogleLocation';


    public function locationExists($direction){
        $result=$this->find('all',array('conditions'=>array('address'=>$direction)));
        if(is_array($result)){
            if($result[$this->alias]['status']=='ZERO_RESULTS'){
                return false;
            }
        }
        return true;
    }
}