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

    public function __construct($id=null ,$contrasenya=null,$mac=null,$correo=null, $tipoUsuario=null) {
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



    public function Obtener_usuario($correo, $contrasenya){
        $conexion = Database::getInstance()->getConnection();

        $sql = "SELECT * FROM usuarios WHERE correo = :correo AND contrasenya = :contrasenya";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':correo' => $correo,
            ':contrasenya' => $contrasenya
        ]);

        $datosUsuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($datosUsuario) {
            return new Usuario(
                $datosUsuario['id'],
                $datosUsuario['contrasenya'],
                $datosUsuario['mac'],
                $datosUsuario['correo'],
                $datosUsuario['tipoUsuario']
            );
        } else {
            return null;
        }

    }



    public function modificar_usuario($id,$correo, $contrasenya,$mac,$tipoUsuario){
        $conexion = Database::getInstance()->getConnection();

        $sql = "UPDATE usuarios SET correo = :correo, contrasenya = :contrasenya, mac = :mac, tipoUsuario = :tipoUsuario WHERE id = :id";
        $stmt = $conexion->prepare($sql);

        $stmt->execute([
            ':id' => $id,
            ':correo' => $correo,
            ':contrasenya' => $contrasenya,
            ':mac' => $mac,
            ':tipoUsuario' => $tipoUsuario
        ]);

        if ($stmt->rowCount() > 0) {
            
            return new Usuario($id, $contrasenya, $mac, $correo, $tipoUsuario);
        } else {
            return null; 
        }

    }







}

?>