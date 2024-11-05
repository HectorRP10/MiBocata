<?php
class Bocadillo{
    public $id;
    public $nombre;
    public $precio;
    public $ingredientes;
    public $tipo_bocadillo;
    public $dia_semana;
    public $fecha_baja;

    const TIPO_BOCADILLO = [
        'CALIENTE' => 'caliente',
        'FRIO' => 'frio'
    ];
    const DIA_SEMANA = [
        'LUNES' => 'L',
        'MARTES' => 'M',
        'MIERCOLES' => 'X',
        'JUEVES' => 'J',
        'VIERNES' => 'V'
    ];


    public function __construct($id=null, $nombre=null, $precio=null, $ingredientes=null, $tipo_bocadillo=null, $dia_semana=null, $fecha_baja=null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->ingredientes = $ingredientes;
        $this->fecha_baja = $fecha_baja;
        if (in_array($tipo_bocadillo, self::TIPO_BOCADILLO)) {
            $this->tipo_bocadillo = $tipo_bocadillo;
        } else {
            throw new Exception("Tipo de bocadillo inválido");
        }

        if (in_array($dia_semana, self::DIA_SEMANA)) {
            $this->dia_semana = $dia_semana;
        } else {
            throw new Exception("Dia de la semana inválido");
        }

    }


    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getIngredientes() {
        return $this->id;
    }
    public function getTipoBocadillo() {
        return $this->tipo_bocadillo;
    }
    public function getDiaSemana() {
        return $this->dia_semana;
    }
    public function getFechaBaja() {
        return $this->fecha_baja;
    }


}
?>