<?php

namespace provider;

class DatabaseProvider {

    public static function getDataBase() {
        if (file_exists(__DIR__.'/../data/bd.sqlite3')) {
            $pdo = new \PDO('sqlite:'.__DIR__.'/../data/bd.sqlite3');
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            return $pdo;
        } else {
            $pdo = new \PDO('sqlite:'.__DIR__.'/../data/bd.sqlite3' );
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);
            $sql = file_get_contents(__DIR__.'/../data/creation_database.sql');
            $pdo->exec($sql);

            //Insertion des données depuis le fichier extrait.yml
            $lines = file(__DIR__.'/../data/extrait.yml');

            $data = [];
            $currentItem = [];
            $currentKey = '';
            // Extraction des données
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line[0] === '-') {
                    if ($currentItem) {
                        array_push($data, $currentItem);
                    }
                    $currentItem = [];
                    $currentKey = '';
                } else {
                    if (strpos($line, ':') !== false) {
                        list($key, $value) = explode(':', $line, 2);
                        $currentKey = trim($key);
                        $currentItem[$currentKey] = trim($value);
                    } else {
                        // Handle list items
                        if ($currentKey === 'genre') {
                            $currentItem[$currentKey] = array_map('trim', explode(',', $line));
                        }
                    }
                }
            }
            if ($currentItem) {
                array_push($data, $currentItem);
            }
        
            $i = 0;
            $dico_artiste = array();
            $dico_genre = array();
        
            foreach($data as $elem) {
                // Remplace la String de genre en liste 
                $string = $elem['genre'];
                $string = trim($string, "[]");
                $string = str_replace(" ", "", $string);
                $list = explode(",", $string);
                $data[$i]['genre'] = $list;
                $i++;
            }

            return $pdo;
        }
    }
}

$pdo = DatabaseProvider::getDataBase();

?>