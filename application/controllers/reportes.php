<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reportes extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("ReportesModel");
    }

    public function index() {
        
    }

    /**
     * Metodo para obtener los datos del reporte mensual
     */
    public function mensual() {
        $data["mensual"] = $this->ReportesModel->mensual();
        $data["vista"] = "informes/mensual";
        $this->load->view("template", $data);
    }

    /**
     * Metodo para obtener los datos del reporte diario
     */
    public function diario() {
        $data["diario"] = $this->ReportesModel->diario();
        $data["vista"] = "informes/diario";
        $this->load->view("template", $data);
    }

    /**
     * Metodo para obtener los datos del reporte hoy
     */
    public function hoy() {
        $data["hoy"] = $this->ReportesModel->hoy();
        $data["vista"] = "informes/hoy";
        $this->load->view("template", $data);
    }

    /**
     * Metodo para obtener los datos del reporte por fechas
     */
    public function fecha() {
        $data["vista"] = "informes/fecha";
        $this->load->view("template", $data);
    }

    /**
     * metodo para reordenar la fecha
     */
    public function datosFecha() {

        $data = $this->input->post();

        $inicio = date("Y-m-d", strtotime($data["inicio"]));
        $final = date("Y-m-d", strtotime($data["final"]));
        $res = $this->ReportesModel->fecha($inicio, $final);
        echo json_encode($res);
    }

    public function bases() {
        $data["bases"] = $this->ReportesModel->bases();
        $data["vista"] = "informes/bases";
        $this->load->view("template", $data);
    }

    public function enviosCanales() {
        $data["empresas"] = $this->ReportesModel->Buscar("empresas ORDER BY nombre", 'id,nombre', NULL, NULL, 'produccion');
        $data["canales"] = $this->ReportesModel->Buscar("canales", 'id,nombre', NULL, NULL, 'produccion');
        $data["carrier"] = $this->ReportesModel->Buscar("carries", 'codigo,nombre', NULL, NULL, 'produccion');
        $data["vista"] = "informes/enviocanales";
        $this->load->view("template", $data);
    }

//    public function getEnvioCanales() {
//        $data = $this->input->post();
//
//        $where = "fechaenvio between '" . $data["inicio"] . " 00:00' and '" . $data["final"] . " 23:59' GROUP BY idcanal,canales.nombre";
//        $join = " JOIN canales ON canales.id = registros.idcanal";
//        
//        $datos = $this->ReportesModel->buscar('registros ' . $join, 'canales.nombre canal,count(*) envio', $where,'debug');
//        echo json_encode($datos);
//    }
    public function getEnvioCanales() {
        $data = $this->input->post();
        $datos = $this->ReportesModel->reporteBases($data);
        echo json_encode($datos);
    }

    public function informesEstados() {
        $data["vista"] = "informes/estados";
        $this->load->view("template", $data);
    }

    public function getEstados() {
        $data = $this->input->post();
        $where = $where = "fechaprogramado > '" . date("Y-m-d") . "'";

        $datos = $this->ReportesModel->buscar('registros ', 'numero,mensaje,fechaprogramado', $where);
        echo json_encode($datos);
    }

    public function disponibles() {

        $data["usuarios"] = $this->ReportesModel->Buscar("usuarios ORDER BY nombre", 'id,nombre', NULL, NULL, 'produccion');
        $data["vista"] = "informes/disponibles";
        $this->load->view("template", $data);
    }

    public function getDisponibles() {
        $data = $this->input->post();
        $datos = $this->ReportesModel->reporteDisponible($data);
        echo json_encode($datos);
    }

    public function errores() {
        $data["vista"] = "informes/errores";
        $this->load->view("template", $data);
    }

    public function getErrores() {
        $data = $this->input->post();
        $idbase = '';
        if ($data["idbase"] != '') {
            $idbase = ' AND idbase=' . $data["idbase"];
        }
        $where = "fecha between '" . $data["inicio"] . " 00:00' and '" . $data["final"] . " 23:59' " . $idbase;
        $datos = $this->ReportesModel->buscar('errores ', 'idbase,numero,mensaje,nota,error', $where);
        echo json_encode($datos);
    }

    public function gerencias() {
        $data["vista"] = "informes/gerencias";
        $this->load->view("template", $data);
    }

    public function getGerencias() {
        $this->datatables->set_database("natura");

        echo $this->datatables
                ->select("gerencia,codigo_gerencia,cupo_gerencia,sector,codigo_sector,cupo_sector")
                ->from("datagerencias")
                ->generate();
    }

    public function consumo() {
        $data["vista"] = "informes/consumo";
        $this->load->view("template", $data);
    }

    public function getConsumo() {
        $draw = 1;
        $sql = "
            select d.nit,a.usuario,count(b.id) as consumo
            from usuarios a, registros b, bases c,empresas d
            where b.fechaenvio >= '" . date("Y-m-01") . "' and b.fechaenvio <= now() and b.idbase = c.id and c.idusuario = a.id and a.idempresa = d.id 
            group by 1,2 order by 1";
        $datos = $this->AdministradorModel->ejecutar($sql);
        $respuesta = $this->dataTable($datos);
        $respuesta["draw"] = 1;
        echo json_encode($respuesta);
    }

}
