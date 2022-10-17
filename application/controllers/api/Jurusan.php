<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Jurusan extends RestController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jurusan_model', 'jrs');
        // $this->methods['index_get']['limit'] = 2;
    }

    public function index_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $jurusan = $this->jrs->getJurusan();
        } else {
            $jurusan =
                $this->jrs->getJurusan($id);
        }

        if ($jurusan) {
            $this->response([
                'status' => true,
                'data' => $jurusan
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
            if ($this->jrs->deleteJurusan($id) > 0) {
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

        $data = ['jurusan' => $this->post('jurusan')];

        if ($this->jrs->createJurusan($data) > 0) {

            $this->response([
                'status' => true,
                'message' => 'new jurusan has been created'
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
        $data = ['jurusan' => $this->put('jurusan')];

        if ($this->jrs->updateJurusan($data, $id) > 0) {

            $this->response([
                'status' => true,
                'message' => 'new jurusan has been updated'
            ], RestController::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'failed to update data!'
            ], RestController::HTTP_BAD_REQUEST);
        }
    }
}
