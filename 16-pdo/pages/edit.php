<?php
    include '../config/app.php';
    include '../config/database.php';
    include '../config/security.php';

    if (!isset($_GET['id'])) {
        header('Location: dashboard.php');
        die();
    }
    $id = $_GET['id'];
    $pet = showPet($id, $conx);
    if (!$pet) {
        header('Location: dashboard.php');
        die();
    }

    $species = listSpecies($conx);
    $breeds = listBreeds($conx);
    $sexes = listSexes($conx);
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = $_POST['name'];
        $specie_id = $_POST['specie'];
        $breed_id = $_POST['breed'];
        $sex_id = $_POST['sex'];
        $photo = $pet['photo']; 

        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $photo_name = uniqid() . '-' . $_FILES['photo']['name'];
            $target_path = '../uploads/' . $photo_name;
            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
                $photo = $photo_name;
            } else {
                $_SESSION['error'] = 'Error al subir la nueva foto';
                header("Location: edit.php?id=$id");
                exit();
            }
        }

    
 if (updatePet($id, $name, $specie_id, $breed_id, $sex_id, $photo_name, $conx)) {
            $_SESSION['message'] = "La mascota ha sido actualizada.";
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Error al actualizar la mascota.";
            header("Location: dashboard.php");
            exit();
        }
    }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu mejor amigo en casa - Edit</title>
    <link rel="stylesheet" href="css/master.css">
    <link rel="stylesheet" href="<?=$css?>stylee.css">
</head>
<body>
    <main class="edit">
        <header>
            <h2>Modificar Mascota</h2>
            <a href="dashboard.php" class="back"></a>
            <a href="../close.php" class="close"></a>
        </header>
        <figure class="photo-preview">
            <img id="preview" src="../uploads/<?=$pet['photo']?>" alt="<?=$pet['name']?>">
        </figure>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="text" name="name" placeholder="Nombre" value="<?=$pet['name']?>" required>
            
            <div class="select">
                <select name="specie" required>
                    <option value="">Seleccione Categoría...</option>
                    <?php foreach ($species as $specie): ?>
                        <option value="<?=$specie['id']?>" <?php if ($specie['id'] == $pet['specie_id']) echo 'selected'; ?>>
                            <?=$specie['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="select">
                <select name="breed" required>
                    <option value="">Seleccione Raza...</option>
                    <?php foreach ($breeds as $breed): ?>
                        <option value="<?=$breed['id']?>" <?php if ($breed['id'] == $pet['breed_id']) echo 'selected'; ?>>
                            <?=$breed['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="button" class="upload">Subir Foto</button>
            <input type="file" name="photo" id="photo" accept="image/*" style="display: none;" >
            
            <div class="select">
                <select name="sex" required>
                    <option value="">Seleccione Género...</option>
                    <?php foreach ($sexes as $sex): ?>
                        <option value="<?=$sex['id']?>" <?php if ($sex['id'] == $pet['sex_id']) echo 'selected'; ?>>
                            <?=$sex['name']?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button class="update">Actualizar</button>
        </form>
    </main>
    <script>
        const photoInput = document.getElementById('photo');
        const previewImage = document.getElementById('preview');
        const uploadButton = document.querySelector('.upload');

        uploadButton.addEventListener('click', () => {
            photoInput.click();
        });

        photoInput.addEventListener('change', (event) => {
            const [file] = event.target.files;
            if (file) {
                previewImage.src = URL.createObjectURL(file);
            }
        });
    </script>
</body>
</html>