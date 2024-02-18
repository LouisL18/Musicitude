<?php
$imageId = $user[0]->getIdImage();


$content = 
'<div class="container">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card rounded-card bg-secondary">
        <div class="card-body">';
        $content .= '<h1 class="display-4 text-white">Profil de ' . $user[0]->getNomUtilisateur() . ' ' . $user[0]->getPrenomUtilisateur() . '</h1>';
     $content .= '<div class="row">
          <div class="col-md-6">
          </div>
        </div>
        <form action="/user/edit" method="post" enctype="multipart/form-data">
        <div class="form-group mt-2">
        <div class="col-md-6">
        <label for="image">Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">';
        
        if (isset($_SESSION['artist_id'])) {
          $content .= '<label for="nom-artiste">Nom artiste</label>
          <input type="text" class="form-control" id="nom-artiste" name="nom-artiste" value="'  . $artist[0]->getNomArtiste() . '" required>
          <label for="description-artiste">Description</label>
          <textarea class="form-control" id="description-artiste" name="description-artiste" rows="3" required>' . $artist[0]->getDescriptionArtiste() . '</textarea>';
        }
        $content .= '<label for="nom">Nom</label>
            
            <input type="text" class="form-control" id="nom" name="nom" value="' . $user[0]->getNomUtilisateur() . '" required>
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="' . $user[0]->getPrenomUtilisateur() . '" required>
            <label for="email">Adresse email</label>
            <input type="email" class="form-control" id="email" name="email" value="' . $user[0]->getEmailUtilisateur() . '" required>
            <label for="mot-de-passe">Mot de passe</label>
            <input type="password" class="form-control" id="mot-de-passe" name="mot-de-passe" value="' . $user[0]->getMotDePasseUtilisateur() . '" required>
      </div>
      </div>
      <input type="submit" class="btn btn-primary" value="Valider les modifications">
    </form>
    </div>
    <div class="card-body d-flex justify-content-center" style="padding-top: 1rem;">
    <button class="btn btn-danger rounded-pill" style="width: 100%;">Supprimer mon compte</button>
    </div>
  </div>
</div>';
$content .= <<<HTML
<script>
    var motDePasseElement = document.getElementById("mot-de-passe");
    motDePasseElement.textContent = "*".repeat(motDePasseElement.textContent.length);
    document.querySelector('button.btn-danger').addEventListener('click', function() {
        if (confirm('Voulez-vous vraiment supprimer votre compte ?')) {
            fetch('/user', {
                method: 'DELETE',
            })
            .then(response => {
                if(response.status === 200) {
                    window.location.href = '/login';
                }
            });
        }
    });
</script>
HTML;
return $content;
?>