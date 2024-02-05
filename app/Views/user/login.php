
<?php
$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=musicitude", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if(isset($_POST['ok'])){
    $nom = $_POST['nom'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE nom = '$nom' AND password = '$password'";
    $result = $conn->query($sql);
    if($result->rowCount() > 0){
        echo "Connexion réussie";
    }else{
        echo "Connexion échouée";
    }

}

?>
<html>
    <head>
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <div>
        <form method="post">
            <input type="text" name="nom" placeholder="Nom">
            <input type="password" name="password" placeholder="Mot de passe">
            <input type="submit" name="ok" value="Connexion">
        </form> 
        </div>
    </body>
</html>

<style>
    body{
        background-color: #000000;
        color: white;
    }
    div{
        margin: 0 auto;
        padding: 20px;
        border-radius: 10px;
        width: 400px;
        height: 300px;
        background-color: rgb(31, 31, 31);
        position: relative;
    }
    div::after,
    div::before{
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        background: linear-gradient(45deg, #ff0000, #00f0f0, #00ff00, #0000ff, #ff0000, #00f0f0, #00ff00, #0000ff, #f00f0f);
        width: 100%;
        height: 100%;
        transform: scale(1.02);
        z-index: -1;
        background-size: 500%;
        animation: animate 50s infinite;
        border-radius: 10px;

    }
    div::after {
        filter: blur(20px);
    }
    @keyframes animate {
    0% { background-position: 0 0; }
    50% { background-position: 300% 0; }
    100% { background-position: 0 0; }
}

    input{
        width: 100%;
        margin: 10px 0;
        padding: 10px;
        border: 1px solid #f2f2f2;
        border-radius: 5px;
    }
    input[type="submit"]{
        background-color: #ff6600;
        color: white;
        border: none;
        cursor: pointer;
    }
</style>