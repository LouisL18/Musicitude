
<?php
$content = <<<HTML
<div class="container">
  <div class="row">
    <div class="col-lg-8 offset-lg-2">
      <div class="card rounded-card bg-secondary">
        <div class="card-body">
          <div class="logo-div">
            <img src="images/logo.png" alt="Musicitude Logo" class="logo">
          </div>
          <h2 class="mt-2">Se connecter</h2>
          <form action="/login" method="post">
            <div class="form-group mt-2">
              <label for="email">Adresse email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group mt-2">
              <label for="password">Mot de passe</label>
              <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary mt-4">Se connecter</button>
              <a href="/register" class="btn btn-secondary mt-4">Créer un compte</a>
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