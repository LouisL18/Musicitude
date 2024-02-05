<?php
return <<<HTML
<nav class="navbar navbar-expand-lg bg-secondary">
    <div class="container-fluid justify-content-between">
        <div class="dropdown">
            <a class="navbar-brand" href="albums" role="button" id="dropdownMenuLink" aria-expanded="false">
                <img src="images/album.png" alt="Album Logo" class="logo">
                <span class="text-dark h3">Albums</span>
            </a>
            <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="albums">Tous les albums</a></li>
                <li><a class="dropdown-item" href="albums/search">Rechercher des albums</a></li>
                <li><a class="dropdown-item" href="#">Ajouter un album</a></li>
            </ul>
        </div>
        <div class="dropdown">
            <a class="navbar-brand" href="artists" role="button" id="dropdownMenuLink" aria-expanded="false">
                <img src="images/artist.png" alt="Artiste Logo" class="logo">
                <span class="text-dark h3">Artistes</span>
            </a>
            <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="artists">Tous les artistes</a></li>
                <li><a class="dropdown-item" href="artists/search">Rechercher des artistes</a></li>
            </ul>
        </div>
        <a class="navbar-brand" href="/">
            <img src="images/logo.png" alt="Musicitude Logo" class="logo">
            <span class="text-dark h3">Musicitude</span>
        </a>
        <a class="navbar-brand" href="playlists">
            <img src="images/playlist.png" alt="Playlist Logo" class="logo">
            <span class="text-dark h3">Playlists</span>
        </a>
        <div class="dropdown">
            <a class="navbar-brand" href="user">
                <img src="images/profile.png" alt="Profile Logo" class="logo">
                <span class="text-dark h3">Profil</span>
            </a>
            <ul class="dropdown-menu bg-secondary" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item" href="user">Mon profil</a></li>
                <li><a class="dropdown-item" href="#">Modifier mon profil</a></li>
                <li><a class="dropdown-item" href="logout">Se déconnecter</a></li>
            </ul>
        </div>
    </div>
</nav>
HTML;
?>