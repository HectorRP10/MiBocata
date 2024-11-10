<?php
require_once '../inc/conexionSingleton.php';
class Bocadillo{
    public $id;
    public $nombre;
    public $precio;
    public $ingredientes;
    public $tipo;
    public $dia_semana;
    public $fecha_baja;

    const TIPO_BOCADILLO = [
        'CALIENTE' => 'Caliente',
        'FRIO' => 'Frio'
    ];
    const DIA_SEMANA = [
        'LUNES' => 'L',
        'MARTES' => 'M',
        'MIERCOLES' => 'X',
        'JUEVES' => 'J',
        'VIERNES' => 'V'
    ];


    public function __construct($id=null, $nombre=null, $precio=null, $ingredientes=null, $tipo=null, $dia_semana=null, $fecha_baja=null){
        $this->id = $id;
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->ingredientes = $ingredientes;
        $this->fecha_baja = $fecha_baja;
        if (in_array($tipo, self::TIPO_BOCADILLO)) {
            $this->tipo = $tipo;
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
        return $this->ingredientes;
    }
    public function getTipoBocadillo() {
        return $this->tipo;
    }
    public function getDiaSemana() {
        return $this->dia_semana;
    }
    public function getFechaBaja() {
        return $this->fecha_baja;
    }

    public static function obtener_bocadillo_caliente(){
        $conexion = Database::getInstance()->getConnection();

        $numeroDia = date('N');
        $diasSemana = [
            1 => self::DIA_SEMANA['LUNES'],
            2 => self::DIA_SEMANA['MARTES'],
            3 => self::DIA_SEMANA['MIERCOLES'],
            4 => self::DIA_SEMANA['JUEVES'],
            5 => self::DIA_SEMANA['VIERNES'],
        ];

        //con esto se comprueba que hay dia y si es sabado o domingo se pone a null
        if (!isset($diasSemana[$numeroDia])) {
            return []; 
        }

        $diaActual = $diasSemana[$numeroDia];
        $sql ="SELECT * FROM bocadillos WHERE tipo=:tipo AND dia_semana=:dia";
        $stmt=$conexion->prepare($sql);
        $stmt->execute([
            ':tipo' => self::TIPO_BOCADILLO['CALIENTE'],
            ':dia' => $diaActual
        ]);

        $Bocadillos=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            $Bocadillos[]= new Bocadillo(
            $fila['id'],
            $fila['nombre'],
            $fila['precio'],
            $fila['ingredientes'],
            $fila['tipo'],
            $fila['dia_semana'],
            $fila['fecha_baja'],
            );
        }
        return $Bocadillos;
    }

    public static function obtener_bocadillo_frio(){
        $conexion = Database::getInstance()->getConnection();

        $numeroDia = date('N');
        $diasSemana = [
            1 => self::DIA_SEMANA['LUNES'],
            2 => self::DIA_SEMANA['MARTES'],
            3 => self::DIA_SEMANA['MIERCOLES'],
            4 => self::DIA_SEMANA['JUEVES'],
            5 => self::DIA_SEMANA['VIERNES'],
        ];

        //con esto se comprueba que hay dia y si es sabado o domingo se pone a null
        if (!isset($diasSemana[$numeroDia])) {
            return []; 
        }
        
        $diaActual = $diasSemana[$numeroDia];
        $sql ="SELECT * FROM bocadillos WHERE tipo=:tipo AND dia_semana=:dia";
        $stmt=$conexion->prepare($sql);
        $stmt->execute([
            ':tipo' => self::TIPO_BOCADILLO['FRIO'],
            ':dia' => $diaActual

        ]);

        $Bocadillos=[];
        while($fila = $stmt->fetch(PDO::FETCH_ASSOC)){
            $Bocadillos[]= new Bocadillo(
            $fila['id'],
            $fila['nombre'],
            $fila['precio'],
            $fila['ingredientes'],
            $fila['tipo'],
            $fila['dia_semana'],
            $fila['fecha_baja'],
            );
        }
        return $Bocadillos;
    }


}
?>