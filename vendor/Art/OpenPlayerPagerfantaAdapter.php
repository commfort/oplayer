<?php
namespace Art;

class OpenPlayerPagerfantaAdapter implements \Pagerfanta\Adapter\AdapterInterface {
	private $data = array();

	public function search() {
		if ( !count( $this->data) ) {
			$this->data = $this->openplayer->audioSearch( 
		        $this->q, $this->p, $this->ipp, 60*60*48
		    ); 
		}

		return $this->data;
	}

    public function __construct( $openplayer, $q, $p, $ipp ) {
    	$this->openplayer = $openplayer;
    	$this->q = $q;
    	$this->p = $p - 1;
    	$this->ipp = $ipp;
    }

    public function getNbResults() {
        $this->res = $this->search();

        $cnt = $this->res['count'] > 1000 ? 1000 : $this->res['count'];
        return $cnt;
    }

    public function getSlice($offset, $length) {
    	$this->res = $this->search();
        return $this->res['result'];
    }
}