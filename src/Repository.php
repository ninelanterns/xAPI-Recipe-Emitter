<?php namespace XREmitter;
use \TinCan\RemoteLRS as TinCanRemoteLrs;
use \stdClass as PhpObj;

class Repository extends PhpObj {
    protected $store;
    
    /**
     * Constructs a new Repository.
     * @param TinCanRemoteLrs $store
     * @param PhpObj $cfg
     */
    public function __construct(TinCanRemoteLrs $store) {
        $this->store = $store;
    }

    /**
     * Creates an event in the store.
     * @param [string => mixed] $event
     * @return [string => mixed]
     */
    public function create_event(array $event) {
        $this->store->saveStatement(new tincan_statement($event));
        return $event;
    }
}
