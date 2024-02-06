<?php
$content = <<<HTML
<script>
  $(document).ready(function() {
    $('#artistCheckbox').change(function() {
      if (this.checked) {
        $('#nom-artiste-group').show();
      } else {
        $('#nom-artiste-group').hide();
        $('#nom-artiste').val('');
      }
    });
  });
</script>
<div class="container">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card rounded-card bg-secondary">
        <div class="card-body">
          <h2 class="mt-2">Créer un compte</h2>
          <form action="/register" method="post" enctype="multipart/form-data">
            <div class="form-group">
              <label for="prenom">Nom</label>
              <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="form-group mt-2">
              <label for="nom">Prénom</label>
              <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="form-group mt-2">
              <label for="email">Adresse email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group mt-2">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group mt-2">
              <label for="image">Photo de profil</label>
              <input type="file" class="form-control" id="image" name="image">
            </div>
            <div class="form-check mt-2">
              <input class="form-check-input" type="checkbox" value="" id="artistCheckbox">
              <label class="form-check-label" for="artistCheckbox">Vous êtes un artiste ?</label>
            </div>
            <div class="form-group mt-2" id="nom-artiste-group" style="display: none;">
              <label for="nom-artiste">Nom d'artiste</label>
              <input type="text" class="form-control" id="nom-artiste" name="nom-artiste">
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary mt-4">Créer un compte</button>
              <a href="/login" class="btn btn-secondary mt-4">Se connecter</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
HTML;
return $content;
?>