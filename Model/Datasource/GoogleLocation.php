<?php
/**
 * Created by PhpStorm.
 * User: elliotmoso
 * Date: 09/12/14
 * Time: 11:59
 */
App::uses('HttpSocket', 'Network/Http');
App::uses('Datasource','Model/Datasource');
/**
 * Class GoogleLocationSource
 * @property HttpSocket Http
 */
class GoogleLocation extends DataSource{

    public $config = array(
        'client' => null,
        'signature'=>null,
        'sensor'=>false,
        'database'=>null
    );

    public $description = 'Google Location API Datasource';

    public function __construct($config) {
        parent::__construct($config);
        $this->Http = new HttpSocket();
    }

    public function read(Model $model, $queryData = array(),
        $recursive = null) {
        /**
         * Here we do the actual count as instructed by our calculate()
         * method above. We could either check the remote source or some
         * other way to get the record count. Here we'll simply return 1 so
         * ``update()`` and ``delete()`` will assume the record exists.
         */
        if ($queryData['fields'] === 'COUNT') {
            return array(array(array('count' => 1)));
        }
        /**
         * Now we get, decode and return the remote data.
         */
        if(!is_null($this->config['client'])&&!is_null($this->config['signature'])){
            $queryData['conditions']['client'] = $this->config['client'];
            $queryData['conditions']['signature'] = $this->config['signature'];
        }
        if(!is_null($this->config['sensor'])&&empty($queryData['conditions']['sensor'])){
            $queryData['conditions']['sensor'] = $this->config['sensor'];
        }
        foreach($queryData['conditions'] as $key=>&$data){
            $data=str_replace(" ",'+',$data);
        }

        $json = $this->Http->get(
            'http://maps.googleapis.com/maps/api/geocode/json',
            $queryData['conditions']
        );
        $res = json_decode($json, true);
        if (is_null($res)) {
            $error = json_last_error();
            throw new CakeException($error);
        }
        return array($model->alias => $res);
    }
} 