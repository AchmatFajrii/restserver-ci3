<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Mahasiswa extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mahasiswa_model', 'mhs');
        // $this->methods['index_get']['limit'] = 2;
    }

    public function index_get()
    {
        $id = $this->get('id');
        $nim = $this->get('nim');
        $nama = $this->get('nama');
        $email = $this->get('email');
        $jurusan = $this->get('jurusan');

        if ($id === null) {
            $mahasiswa = $this->mhs->getMahasiswa();
        } else{
            $mahasiswa = $this->mhs->getMahasiswa($id);
        }


        if ($mahasiswa) {
            $this->response([
                'status' => true,
                'data' => $mahasiswa
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'id not found'
            ], RestController::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {

        $id = $this->delete('id');

        if ($id === null) {
            $this->response([
                'status' => false,
                'message' => 'provide an id!'
            ], RestController::HTTP_BAD_REQUEST);
        } else {
            if ($this->mhs->deleteMahasiswa($id) > 0) {
                $this->response([
                    'status' => true,
                    'id' => $id,
                    'message' => 'deleted'
                ], RestController::HTTP_OK);
            } else {
                $this->response([
                    'status' => false,
                    'message' => 'id not found!'
                ], RestController::HTTP_BAD_REQUEST);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'nim' => $this->post('nim'),
            'nama' => $this->post('nama'),
            'email' => $this->post('email'),
            'jurusan' => $this->post('jurusan')
        ];

        if ($this->mhs->createMahasiswa($data) > 0) {

            $this->response([
                'status' => true,
                'message' => 'new mahasiswa has been created'
            ], RestController::HTTP_CREATED);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to create new data!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {

        $id = $this->put('id');
        $data = [
            'nim' => $this->put('nim'),
            'nama' => $this->put('nama'),
            'email' => $this->put('email'),
            'jurusan' => $this->put('jurusan')
        ];

        if ($this->mhs->updateMahasiswa($data, $id) > 0) {

            $this->response([
                'status' => true,
                'message' => 'new mahasiswa has been updated'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
