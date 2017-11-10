<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/libraries/REST_Controller.php';


class Forecast extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('forecast_model');
    }

    public function index_get()
    {
        $forecast = $this->forecast_model->get();

        if (!is_null($forecast)) {
            $this->response(array('response' => $forecast), 200);
        } else {
            $this->response(array('error' => 'No hay pronósticos en la base de datos...'), 404);
        }
    }

    public function find_get($id_city)
    {
        if (!$id_city) {
            $this->response(null, 400);
        }
        $forecast = $this->forecast_model->get($id_city);

        if (!is_null($forecast)) {
            $this->response(array('response' => $forecast), 200);
        } else {
            $this->response(array('error' => 'Pronóstico no encontrado...'), 404);
        }
    }

    public function index_post()
    {
        error_log(print_r($this->post('forecast'), true));
        if (!$this->post('forecast')) {
            $this->response(null, 400);
        }

        $id = $this->forecast_model->save($this->post('forecast'));

        if (!is_null($id)) {
            $this->response(array('response' => $id), 200);
        } else {
            $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
        }
    }

    public function index_put($id)
    {
        if (!$this->put('forecast') || !$id) {
            $this->response(null, 400);
        }

        $update = $this->forecast_model->update($id, $this->put('forecast'));

        if (!is_null($update)) {
            $this->response(array('response' => 'Pronóstico actualizado!'), 200);
        } else {
            $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
        }
    }

    public function index_delete($id)
    {
        if (!$id) {
            $this->response(null, 400);
        }

        $delete = $this->forecast_model->delete($id);

        if (!is_null($delete)) {
            $this->response(array('response' => 'Pronóstico eliminado!'), 200);
        } else {
            $this->response(array('error', 'Algo se ha roto en el servidor...'), 400);
        }
    }
}