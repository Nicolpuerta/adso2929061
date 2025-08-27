<?php
    // Connection Data Base
    try {
        $conx = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (PDOException $e) {
       echo 'Error: ' . $e->getMessage();
    }
 
   // Login
    function login($email, $pass, $conx) {
        try {
            $sql = "SELECT *
                    FROM users
                    WHERE email = :email
                    LIMIT 1";
            $stmt = $conx->prepare($sql);
            $stmt->bindparam(':email', $email);
            $stmt->execute();
 
            if($stmt->rowCount() > 0) {
                $usr = $stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($pass, $usr['password'])) {
                    $_SESSION['uid'] = $usr['id'];
                    return true;
                } else {
                    $_SESSION['error'] = "El password es incorrecto!";
                    return false;
                }
            } else {
                $_SESSION['error'] = "El usuario no esta registrado!";
                return false;
            }
 
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
 
    }

    //list pets
    function listPets($conx) {
        try {
            $sql = "SELECT p.id AS id,
                            p.name AS name,
                            p.photo AS photo,
                            s.name AS specie,
                            b.name AS breed
                    FROM pets AS p,
                        species AS s,
                        breeds AS b
                    WHERE s.id = p.specie_id
                    AND b.id = p.breed_id";
            $stmt = $conx->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function listSpecies($conx){
        try{
            $sql = "SELECT * FROM species";
             $stmt = $conx->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Breeds

     function listBreeds($conx){
        try{
            $sql = "SELECT * FROM breeds";
             $stmt = $conx->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    // Sexes

    function listSexes($conx){
        try{
            $sql = "SELECT * FROM sexes";
             $stmt = $conx->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        }catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    function addPet($name, $specie_id, $breed_id, $sex_id, $photo, $conx) {
    try {
        $sql = "INSERT INTO pets (name, specie_id, breed_id, sex_id, photo) VALUES (:name, :specie_id, :breed_id, :sex_id, :photo)";
        $stmt = $conx->prepare($sql);
        $stmt->bindparam(':name', $name);
        $stmt->bindparam(':specie_id', $specie_id);
        $stmt->bindparam(':breed_id',$breed_id);
        $stmt->bindparam(':sex_id', $sex_id);
        $stmt->bindparam(':photo',$photo);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    } catch (PDOException $e) {
        echo 'Error: '. $e->getMessage();
    }
}

function showPet($id, $conx) {
    try {
        $sql = "SELECT  p.id AS id,
                        p.name AS name,
                        p.photo AS photo,
                        s.id AS specie_id, 
                        b.id AS breed_id,
                        x.id AS sex_id
                FROM pets AS p, 
                species AS s,
                breeds AS b, 
                sexes AS x
                WHERE s.id = p.specie_id
                AND b.id = p.breed_id 
                AND x.id = p.sex_id
                AND p.id = :id";
        $stmt = $conx->prepare($sql);
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

function updatePet($id, $name, $specie_id, $breed_id, $sex_id, $photo, $conx) {
    try {
        // 1. Get the current photo filename from the database
        $sql_old_photo = "SELECT photo FROM pets WHERE id = :id";
        $stmt_old_photo = $conx->prepare($sql_old_photo);
        $stmt_old_photo->bindparam(":id", $id);
        $stmt_old_photo->execute();
        $old_photo = $stmt_old_photo->fetchColumn();

        // 2. Update the pet's record in the database
        $sql_update = "UPDATE pets SET name = :name, specie_id = :specie_id, breed_id = :breed_id, sex_id = :sex_id";
        
        // Add photo to the query if a new one was provided
        if (!empty($photo)) {
            $sql_update .= ", photo = :photo";
        }
        
        $sql_update .= " WHERE id = :id";
        $stmt_update = $conx->prepare($sql_update);
        $stmt_update->bindparam(':id', $id);
        $stmt_update->bindparam(':name', $name);
        $stmt_update->bindparam(':specie_id', $specie_id);
        $stmt_update->bindparam(':breed_id', $breed_id);
        $stmt_update->bindparam(':sex_id', $sex_id);
        
        if (!empty($photo)) {
            $stmt_update->bindparam(':photo', $photo);
        }

        if ($stmt_update->execute()) {
            // 3. If the database update was successful and a new photo was uploaded, delete the old photo
            if (!empty($photo) && !empty($old_photo) && $old_photo !== $photo) {
                $old_photo_path = '../uploads/' . $old_photo;
                if (file_exists($old_photo_path)) {
                    unlink($old_photo_path);
                }
            }
            return true;
        } else {
            return false;
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}

function deletePet ($id, $conx) {
    try {
        // 1. Get the photo filename from the database before deleting the record
        $sql = "SELECT photo FROM pets WHERE id = :id";
        $stmt = $conx->prepare($sql);
        $stmt->bindparam(":id", $id);
        $stmt->execute();
        $pet = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($pet) {
            $photo_path = '../uploads/' . $pet['photo']; 
            
            // 2. Delete the physical file from the server
            if (file_exists($photo_path)) {
                unlink($photo_path);
            }
        }

        // 3. Delete the pet record from the database
        $sql_delete = "DELETE FROM pets WHERE id = :id";
        $stmt_delete = $conx->prepare($sql_delete);
        $stmt_delete->bindparam(":id", $id);
        
        return $stmt_delete->execute();

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
}