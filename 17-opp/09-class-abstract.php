<?php
$title = '09 - Class Abstract';
$description = 'A class that cannot be instantiated, only extended from.';

include_once 'template/header.php';
echo '<section>';

abstract class basedatos
{
    private $HOST;
    private $NAME;
    private $USER;
    private $PASS;
    protected $conexion;

    // Función contructor
    public function __construct($HOST = 'localhost', $NAME = 'pokeadso', $USER = 'root', $PASS = '')
    {
        $this->HOST = $HOST;
        $this->NAME = $NAME;
        $this->USER = $USER;
        $this->PASS = $PASS;

        $this->conectar();
    }

    protected function conectar()
    {
        $dsn = 'mysql:host=' . $this->HOST . ';dbname=' . $this->NAME . ';charset=utf8mb4';
        try {
            $this->conexion = new PDO($dsn, $this->USER, $this->PASS);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die(" Error de conexión: " . $e->getMessage());
        }
    }

    protected function desconectar()
    {
        $this->conexion = null;
    }

    public function listar() {}
}

class Pokemon extends basedatos
{

    public function listarPo()
    {
        $this->conectar();

        try {
            $sql = "SELECT * FROM pokemons ";
            $stmt = $this->conexion->query($sql);
            $pokemones = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $tabla = "<table>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Tipo</th>
                        </tr>";

            foreach ($pokemones as $pk) {
                $tabla .= "<tr>
                            <td>{$pk['id']}</td>
                            <td>{$pk['name']}</td>
                            <td>{$pk['type']}</td>
                        </tr>";
            }

            $tabla .= '</table>';

            return $tabla;
        } catch (PDOException $e) {
            return '';
        } finally {
            $this->desconectar();
        }
    }
}

$pokemones = new Pokemon();
echo $pokemones->listarPo();



include_once 'template/footer.php';
