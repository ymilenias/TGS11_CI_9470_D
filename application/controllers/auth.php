<?php
use Restserver \Libraries\REST_Controller ;
Class auth extends REST_Controller{
    public function __construct(){
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, OPTIONS, POST, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, ContentLength, Accept-Encoding");
        parent::__construct();
        $this->load->model('UserModel');
        $this->load->library('form_validation');
        $this->load->helper(['jwt','authorization']);
    }

    public $rule = [
        [ 'field' => 'password',
         'label' => 'password',
         'rules' => 'required'
        ],
        [ 'field' => 'email',
         'label' => 'email',
         'rules' => 'required'
        ]
    ];
    
    public function Rules() { return $this->rule; }

    public function index_post(){
        $validation = $this->form_validation;
        $rule = $this->Rules();
        $validation->set_rules($rule);
        if (!$validation->run()) {
            return $this->response($this->form_validation->error_array());
        }
        $user = new UserData();
        $user->password = $this->post('password');
        $user->email = $this->post('email');

        if($result =  $this ->UserModel->verify($user)){
            // Create a token
            $token = AUTHORIZATION::generateToken(['id'=>$result['id'],'name'=>$result['name']]);
            // Set HTTP status code
            $status = parent::HTTP_OK;
            // Prepare the response
            $response = ['status' => $status, 'token' => $token];
            // REST_Controller provide this method to send responses
            return $this->response($response, $status);
        }else{
            return $this->response('Gagal');
        }
    }
    
}
Class UserData{
    public $name;
    public $password;
    public $email;
}
