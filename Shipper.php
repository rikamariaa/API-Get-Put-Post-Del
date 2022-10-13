<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require APPPATH . '/libraries/REST_Controller.php';
use Restserver\Libraries\Rest_Controller;

class Shipper extends REST_Controller {
	function __construct ($config = 'rest') {
		parent::__construct($config);
	} 
	
	//Menampilkan data
	public function index_get() {
		$id = $this->get('id');
		if ($id == '') {
			$data = $this->db->get('shippers')->result();
		} else {
			$this->db->where('ShipperID', $id);
			$data = $this->db->get ('shippers')->result();
		}
		$this->response($data, 200);
	}
	public function index_post() {
		$data = array(
					'CompanyName' => $this->post ('C'),
					'Phone' 	  => $this->post('D'));
		$insert = $this->db->insert('shippers', $data);
		if ($insert) {
			$result = ["took"=>$_SERVER["REQUEST_TIME_FLOAT"],
					   "code"=>201,
					   "message"=>"Data has successfully added",
					   "data"=>$data];
			$this->response($result, 201);
		} else{
		$result = ["took" =>$_SERVER["REQUEST_TIME_FLOAT"],
						"code"=>502,
						"massage"=>"Failed adding data",
						"data"=>null];
		$this->response($result, 502);		}
	}


//Memperbarui data yang telah ada
	public function index_put(){
		$id = $this->put('ShipperID');
		$data = array(
					'ShipperID'	  => $this->put('ShipperID'),
					'CompanyName' => $this->put ('CompanyName'),
					'Phone' 	  => $this->put('Phone'));
		$this->db->where('ShipperID', $id);
		$update = $this->db->update('shippers', $data);
		if ($update) {
			$this->response($data, 200);
		} else{
			$this->response(array('status' => 'fail', 502));
		}
	}

	public function index_delete() {
			$id = $this->delete('id');
			$this->db->where('shipperID', $id);
			$delete = $this->db->delete('shippers');
			if ($delete) {
				$this->response(array('status' => 'success'), 201);
			} else{
			$this->response(array('status' => 'fail', 502));
			}
	}
}
?>