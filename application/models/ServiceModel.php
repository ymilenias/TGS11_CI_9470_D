<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ServiceModel extends CI_Model
{
    private $table = 'services';


    public $id;
    public $name;
    public $price;
    public $type;
    public $created_at;
    public $rule = [ 
        [
            'field' => 'name',
            'label' => 'name',
            'rules' => 'required'
        ],
    ];
    public function Rules() { return $this->rule; }
   

    public function getAll() { return 
        $this->db->get('data_service')->result(); 
    } 
    public function store($request) { 
        $this->name = $request->name; 
        $this->type = $request->type; 
        $this->price = $request->price;
        $this->created_at = $request->created_at;

        if($this->db->insert($this->table, $this)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function update($request,$id) { 
        $updateData = ['price' => $request->price, 
                        'name' =>$request->name,
                        'type' =>$request->type,
                        'created_at' =>$request->created_at,
                    ];
        if($this->db->where('id',$id)->update($this->table, $updateData)){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
    public function destroy($id){
        if (empty($this->db->select('*')->where(array('id' => $id))->get($this->table)->row())) return ['msg'=>'Id tidak ditemukan','error'=>true];
        
        if($this->db->delete($this->table, array('id' => $id))){
            return ['msg'=>'Berhasil','error'=>false];
        }
        return ['msg'=>'Gagal','error'=>true];
    }
}
?>