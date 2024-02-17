<?php
$content = 
'<div class="container">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card rounded-card bg-secondary">
        <div class="card-body">';
        $content .= '<h1 class="display-4 text-white">Profil de ' . $super_user['User']->getNomUtilisateur() . ' ' . $super_user['User']->getPrenomUtilisateur() . '</h1>';
     $content .= '<div class="row">
          <div class="col-md-3">
          <div class="card rounded-card mb-3">
          <img src="data:image/jpeg;base64,' . utf8_decode($super_user['Image'][0]->getDataImage()) . '" class="card-img-top img-fluid">
          </div>
          </div>
        </div>
        <div class="col-md-6">';
        if (isset($_SESSION['artist_id'])) {
          $content .= '<p class="lead text-white">Artiste : ' . $artist[0]->getNomArtiste() . '</p>';
        }
        $content .= '<p class="lead text-white">Nom : ' . $super_user['User']->getNomUtilisateur() . '</p>
        <p class="lead text-white">Prénom : ' . $super_user['User']->getPrenomUtilisateur() . '</p>
        <p class="lead text-white">Email : ' . $super_user['User']->getEmailUtilisateur() . '</p>
        <p class="lead text-white">Mot de Passe : <span id="mot-de-passe"> ' . $super_user['User']->getMotDePasseUtilisateur() . '</span></p>
      </div>
      </div>
      <a href="/user/edit" class="btn btn-primary rounded-pill">Modifier</a>
    </div>
  </div>
</div>
<script>
  var motDePasseElement = document.getElementById("mot-de-passe");
  motDePasseElement.textContent = "*".repeat(motDePasseElement.textContent.length);
</script>';
return $content;
?>