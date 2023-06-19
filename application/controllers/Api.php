<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Api extends RestController {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();
        $this->load->model('user_api_model','uam');
    }

    public function index_get()
    {
        $id = $this->get('id_user');
        if ($id === null) {
            $data =  $this->uam->get();
        }else {
            $data =  $this->uam->get($id);
        }
        if ($data) {
            $this->response( [
                'status' => true,
                'data' => $data
            ], RestController::HTTP_OK );

        }else {
            $this->response( [
                'status' => false,
                'message' => 'No users were found'
            ], RestController::HTTP_NOT_FOUND );
        }
    }


    public  function index_delete() {
        $id = $this->delete('id_user');
        
        if ($id === null) {
            $this->response( [
                'status' => false,
                'message' => 'request tidak di temukan'
            ], RestController::HTTP_BAD_REQUEST );
        }else {
            #id ada
            if ($this->uam->delete($id) > 0) {
                $this->response( [
                    'status' => true,
                    'id' => $id,
                    'message' => 'Delete' 
                ], RestController::HTTP_OK);
            }else {
            #id not found
            $this->response( [
                'status' => false,
                'message' => 'ID Tidak Ditemukan'
            ], RestController::HTTP_BAD_REQUEST );
            }
        }
    }

    public function index_post() {
       
        $data = [
            'username' => $this->post('username'),
            'password' => md5($this->post('password')) ,
            'name' => $this->post('name'),
            'address' => $this->post('address')
        ];

        if($this->uam->created($data) > 0){
            $this->response( [
                'status' => true,
                'data' => $data,
                'message' => 'created success'
            ], RestController::HTTP_OK);
        }else {
            $this->response([
                'status' => false,
                'message' => 'created gagal'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

   public function index_put() {
    $id = $this->put('id_user');
    $data = [
        'username' => $this->put('username'),
        'password' => md5($this->put('password')) ,
        'name' => $this->put('name'),
        'address' => $this->put('address')
    ];
    if($this->uam->updated($data, $id) > 0){
        $this->response( [
            'status' => true,
            'data' => $data,
            'message' => 'modifed success'
        ], RestController::HTTP_OK);
    }else {
        $this->response([
            'status' => false,
            'message' => 'modifed gagal'
        ], RestController::HTTP_BAD_REQUEST);
    }
    }
}