<?php
class Usuario {
    public $id;
    public $contrasenya;
    public $mac;
    public $correo;
    public $tipoUsuario;

    const TIPOS_USUARIO = [
        'ALUMNO' => 'alumno',
        'COCINA' => 'cocina',
        'ADMINISTRADOR' => 'admin'
    ];

    public function __construct($id,$contrasenya,$mac,$correo, $tipoUsuario) {
        $this->id = $id;
        $this->contrasenya = $contrasenya;
        $this->mac = $mac;
        $this->correo = $correo;
        if (in_array($tipoUsuario, self::TIPOS_USUARIO)) {
            $this->tipoUsuario = $tipoUsuario;
        } else {
            throw new Exception("Tipo de usuario inválido");
        }
    }


    public function getId() {
        return $this->id;
    }

    public function getTipoUsuario() {
        return $this->tipoUsuario;
    }

    public function getCorreo() {
        return $this->correo;
    }
    public function getMac() {
        return $this->mac;
    }
    public function getContrasenya() {
        return $this->contrasenya;
    }




    public function Accion_permitida() {
        $accionesPermitidas = [
            self::TIPOS_USUARIO['ALUMNO'],
            self::TIPOS_USUARIO['ADMIN'],
            self::TIPOS_USUARIO['Cocina']
        ];

        if (in_array($this->tipoUsuario, $accionesPermitidas)) {
            return "Acción permitida para {$this->tipoUsuario}.";
        } else {
            return "Acción no permitida para {$this->tipoUsuario}.";
        }
    }















}

?>