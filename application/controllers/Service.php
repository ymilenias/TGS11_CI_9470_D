<?php
use Restserver \Libraries\REST_Controller ;
Class service extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
        parent::__construct();
        $this->load->model('ServiceModel');
        //$this->load->library('form_validation');
        $this->load->helper('date');

    }
    public function index_get(){
        return $this->returnData($this->db->get('services')->result(), false);
    }
    public function index_post($id = null){
        // $validation = $this->form_validation;
        // $rule = $this->ServiceModel->rules();
        // if($id == null){
        //     array_push($rule,[
        //             'field' => 'name',
        //             'label' => 'name',
        //             'rules' => 'required'
        //         ],
        //         [
        //             'field' => 'price',
        //             'label' => 'price',
        //             'rules' => 'required|valid_price|is_unique[services.price]'
        //         ]
        //     );
        // }
        // else{
        //     array_push($rule,
        //         [
        //             'field' => 'price',
        //             'label' => 'price',
        //             'rules' => 'required|valid_price'
        //         ]
        //     );
        // }
        // $validation->set_rules($rule);
		// if (!$validation->run()) {
		// 	return $this->returnData($this->form_validation->error_array(), true);
        // }
        $service = new serviceData();
        $service->name = $this->post('name');
        $service->price = $this->post('price');
        $service->type = $this->post('type');
        $service->created_at = date(DATE_COOKIE,time());
        if($id == null){
            $response = $this->ServiceModel->store($service);
        }else{
            $response = $this->ServiceModel->update($service,$id);
        }
        return $this->returnData($response['msg'], $response['error']);
    }
    public function index_delete($id = null){
        if($id == null){
			return $this->returnData('Parameter Id Tidak Ditemukan', true);
        }
        $response = $this->ServiceModel->destroy($id);
        return $this->returnData($response['msg'], $response['error']);
    }
    public function returnData($msg,$error){
        $response['error']=$error;
        $response['message']=$msg;
        return $this->response($response);
    }
}
Class serviceData{
    public $name;
    public $price;
    public $type;
    public $created_at;

}