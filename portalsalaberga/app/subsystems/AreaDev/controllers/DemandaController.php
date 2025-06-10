<?php
require_once __DIR__ . '/../model/DemandaModel.php';

class DemandaController {
    private $model;

    public function __construct($db) {
        $this->model = new DemandaModel($db);
    }

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $prazo) {
        $dados = [
            'titulo' => $titulo,
            'descricao' => $descricao,
            'prioridade' => $prioridade,
            'admin_id' => $admin_id,
            'prazo' => $prazo
        ];
        return $this->model->criar($dados);
    }

    public function listarDemandas() {
        return $this->model->listarTodas();
    }

    public function getDemanda($id) {
        return $this->model->buscarPorId($id);
    }

    public function atualizarStatusDemanda($id, $status) {
        return $this->model->atualizarStatus($id, $status);
    }

    public function atribuirDemanda($demanda_id, $usuario_id) {
        return $this->model->atribuirUsuario($demanda_id, $usuario_id);
    }

    public function atualizarStatusUsuarioDemanda($demanda_id, $usuario_id, $status) {
        return $this->model->atualizarStatusUsuario($demanda_id, $usuario_id, $status);
    }

    public function getDemandasUsuario($usuario_id) {
        return $this->model->listarDemandasUsuario($usuario_id);
    }

    public function verificarPermissao($usuario_id, $demanda_id) {
        return $this->model->verificarPermissao($usuario_id, $demanda_id);
    }

    public function getEstatisticas() {
        return $this->model->getEstatisticas();
    }
}
