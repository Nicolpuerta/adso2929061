<?php 
    $title       = '25- Challenge Dates';
    $description = 'Calculate the age in years';

    include 'template/header.php';

    echo "<section style='padding: 20px; max-width: 600px; margin: 40px auto; background-color: #f7f7f7; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1);'>";

    echo "<style>";
    echo "
        h2 { 
            color: #000000ff; 
            border-bottom: 2px solid #ccc; 
            padding-bottom: 10px; 
            margin-top: 0;
            text-align: center;
        }
        h1 {
            color: #095faaff;
            text-align: center;
            font-size: 2.5em;
            margin-top: 15px;
        }
        form {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        select {
            padding: 10px;
            margin: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
            min-width: 100px;
        }
        button[type=\"submit\"] {
            background-color: #095faaff; 
            color: white;
            padding: 10px 20px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            transition: background-color 0.3s ease;
        }
        button[type=\"submit\"]:hover {
            background-color: #4ea8f7ff;
        }
        p {
            text-align: center;
            font-size: 1.1em;
            color: #360157d7 !important;
        }

        p[style*=\"color: red\"] {
            background-color: #ffebeb;
            border: 1px solid red;
            padding: 10px;
            border-radius: 5px;
            margin: 15px 0;
        }
    ";
    echo "</style>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['dia']) && isset($_POST['mes']) && isset($_POST['anio'])) {
        
        $dia = $_POST['dia'];
        $mes = $_POST['mes'];
        $anio = $_POST['anio'];
        
        $fechaNacimientoStr = "{$anio}-{$mes}-{$dia}"; 
        
        try {
            $fechaNacimiento = new DateTime($fechaNacimientoStr);
            $fechaActual     = new DateTime();
            
            $intervalo = $fechaNacimiento->diff($fechaActual);
            $edad = $intervalo->y;
            

            echo "<div style='background-color: #e9ecef; padding: 20px; border-radius: 8px; margin-bottom: 20px;'>";
            echo "<h2> Tu Edad Calculada</h2>";
            echo "<br>";
            echo "<p>Naciste el " . $fechaNacimiento->format('d/m/Y') . "</p>";
            echo "<h1>" . $edad . " años</h1>"; 
            echo "</div>";
        
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error: La fecha seleccionada no es válida.</p>";
        }
    }


    echo "<h2>Introduce tu Fecha de Nacimiento </h2>";
    echo '<form method="POST" action="">';

        echo '<select name="dia" required>';
        echo '<option value="">Día</option>';
        for ($i = 1; $i <= 31; $i++) {
            $dia_formato = str_pad($i, 2, '0', STR_PAD_LEFT);
            echo "<option value='{$dia_formato}'>" . $dia_formato . "</option>";
        }
        echo '</select>';


        echo '<select name="mes" required>';
        echo '<option value="">Mes</option>';
        $meses = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
            '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
            '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];
        foreach ($meses as $num => $nombre) {
            echo "<option value='{$num}'>{$nombre}</option>";
        }
        echo '</select>';


        echo '<select name="anio" required>';
        echo '<option value="">Año</option>';
        $anio_actual = date('Y');
        $anio_minimo = $anio_actual - 120;
        for ($i = $anio_actual; $i >= $anio_minimo; $i--) {
            echo "<option value='{$i}'>{$i}</option>";
        }
        echo '</select>';

        echo '    <br><br>';
        echo '    <button type="submit">Calcular Edad</button>';
    echo '</form>';
    

    echo "</section>";

    include 'template/footer.php';
?>