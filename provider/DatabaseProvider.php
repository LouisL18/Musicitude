<?php
namespace provider;

class DatabaseProvider {

    public static function getDataBase() {
        // Si la base de données existe déjà, on l'ouvre
        if (file_exists(__DIR__.'/../data/bd.sqlite3')) {
            $pdo = new \PDO('sqlite:'.__DIR__.'/../data/bd.sqlite3');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            return $pdo;
        // Sinon on la crée et on l'initialise
        } else {
            $pdo = new \PDO('sqlite:'.__DIR__.'/../data/bd.sqlite3' );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            $sql = file_get_contents(__DIR__.'/../data/creation_database.sql');
            $pdo->exec($sql);

            //Insertion des roles
            $pdo->exec('INSERT INTO ROLE_UTILISATEUR (idRole, nomRole) VALUES (1, "Artiste");');
            $pdo->exec('INSERT INTO ROLE_UTILISATEUR (idRole, nomRole) VALUES (2, "Utilisateur");');

            //Insertion de l'image par défaut
            $imageData = file_get_contents(__DIR__.'/../data/images/default.jpg');
            $base64Image = base64_encode($imageData);
            $stmt = $pdo->prepare("INSERT INTO IMAGE_BD (idImage, dataImage) VALUES (0, :dataImage)");
            $stmt->bindValue(':dataImage', $base64Image);
            $stmt->execute();

            //Insertion des données depuis le fichier extrait.yml
            $lines = file(__DIR__.'/../data/extrait.yml');

            $data = [];
            $currentItem = [];
            $currentKey = '';
            // Extraction des données
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line[0] === '-') {
                    $line = substr($line,1);
                    if ($currentItem) {
                        array_push($data, $currentItem);
                    }
                    $currentItem = [];
                    $currentKey = '';
                } 
                if (strpos($line, ':') !== false) {
                    list($key, $value) = explode(':', $line, 2);
                    $currentKey = trim($key);
                    $currentItem[$currentKey] = trim($value);
                } else {
                    if ($currentKey === 'genre') {
                        $currentItem[$currentKey] = array_map('trim', explode(',', $line));
                    }
                } 
            }
            if ($currentItem) {
                array_push($data, $currentItem);
            }
        
            $i = 0;
            $dico_artiste = array();
            $dico_genre = array();
            $dico_image = array();
            $dico_image['default.jpg'] = 0;
        
            foreach($data as $elem) {
                // Remplace la String de genre en liste 
                $string = $elem['genre'];
                $string = trim($string, "[]");
                $string = str_replace(" ", "", $string);
                $list = explode(",", $string);
                $data[$i]['genre'] = $list;
                $i++;

                // Vérifi si l'artiste existe déjà
                $artiste = $elem['by'];
                $idArtiste;
                if (array_key_exists($artiste, $dico_artiste)) {
                    $idArtiste = $dico_artiste[$artiste];
                } else {
                    $idArtiste = count($dico_artiste) + 1;
                    $dico_artiste[$artiste] = $idArtiste;
                    //Insertion de l'artiste dans la bd
                    $stmt = $pdo->prepare("INSERT INTO artiste (idArtiste, nomArtiste) VALUES (:id, :nom)");
                    $stmt->bindValue(':id', $idArtiste);
                    $stmt->bindValue(':nom', $artiste);
                    $stmt->execute();
                    //Création de l'utilisateur associé à l'artiste 
                    $stmt = $pdo->prepare("INSERT INTO UTILISATEUR (idUtilisateur, nomUtilisateur, prenomUtilisateur, emailUtilisateur, motDePasseUtilisateur, idImage) VALUES (:id, :nom, :prenom, :email, :mdp, :idImage)");
                    $stmt->bindValue(':id', $idArtiste);
                    $stmt->bindValue(':nom', $artiste);
                    $stmt->bindValue(':prenom', $artiste);
                    $stmt->bindValue(':email', $artiste.'@gmail.com');
                    $stmt->bindValue(':mdp', $artiste);
                    $stmt->bindValue(':idImage', 0);
                    $stmt->execute();
                    //Ajout du role d'artiste à l'utilisateur
                    $stmt = $pdo->prepare("INSERT INTO A_ROLE (idUtilisateur, idRole, idArtiste) VALUES (:id, 1, :idArtiste)");
                    $stmt->bindValue(':id', $idArtiste);
                    $stmt->bindValue(':idArtiste', $idArtiste);
                    $stmt->execute();
                }

                // Insertion dans la table album
                $idAlbum = $elem['entryId'];
                $nomAlbum = $elem['title'];
                $anneeAlbum = $elem['releaseYear'];
                $cheminImage = $elem['img'];
                if ($cheminImage != 'null') {
                    $imageData = file_get_contents(__DIR__.'/../data/images/'.$cheminImage);
                    $base64Image = base64_encode($imageData);
                    $idImage;
                    if (array_key_exists($cheminImage, $dico_image)) {
                        $idImage = $dico_image[$cheminImage];
                    } else {
                        $idImage = count($dico_image) + 1;
                        $dico_image[$cheminImage] = $idImage;
                        //Insertion de l'image dans la bd
                        $stmt = $pdo->prepare("INSERT INTO IMAGE_BD (idImage, dataImage) VALUES (:id, :dataImage)");
                        $stmt->bindValue(':id', $idImage);
                        $stmt->bindValue(':dataImage', $base64Image);
                        $stmt->execute();
                    }
                }
                $stmt = $pdo->prepare("INSERT INTO album (idAlbum, nomAlbum, anneeAlbum, idArtiste, idImage) VALUES (:id, :nom, :annee, :idArtiste, :idImage)");
                $stmt->bindValue(':id', intval($idAlbum));
                $stmt->bindValue(':nom', $nomAlbum);
                $stmt->bindValue(':annee', intval($anneeAlbum));
                $stmt->bindValue(':idArtiste', $idArtiste);
                if ($cheminImage != 'null') {
                    $stmt->bindValue(':idImage', $idImage);
                } else {
                    $stmt->bindValue(':idImage', null);
                }
                $stmt->execute();

                // Insertion dans la table genre
                foreach($list as $genre) {
                    $idGenre;
                    if (array_key_exists($genre, $dico_genre)) {
                        $idGenre = $dico_genre[$genre];
                    } else {
                        $idGenre = count($dico_genre) + 1;
                        $dico_genre[$genre] = $idGenre;
                        //Insertion du genre dans la bd
                        $stmt = $pdo->prepare("INSERT INTO GENRE (idGenre, nomGenre) VALUES (:id, :nom)");
                        $stmt->bindValue(':id', $idGenre);
                        $stmt->bindValue(':nom', $genre);
                        $stmt->execute();
                    }
                    //Insertion dans la table est_genre
                    $stmt = $pdo->prepare("INSERT INTO EST_GENRE (idAlbum, idGenre) VALUES (:idAlbum, :idGenre)");
                    $stmt->bindValue(':idAlbum', intval($idAlbum));
                    $stmt->bindValue(':idGenre', $idGenre);
                    $stmt->execute();
                }
            }
            return $pdo;
        }
    }
}
?>
