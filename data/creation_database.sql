CREATE TABLE GENRE (
    idGenre int,
    nomGenre varchar(255),
    descriptionGenre varchar(255),
    constraint pk_genre primary key (idGenre)
);

CREATE TABLE ARTISTE (
    idArtiste int,
    nomArtiste varchar(255),
    descriptionArtiste varchar(255),
    constraint pk_artiste primary key (idArtiste)
);

CREATE TABLE IMAGE_BD (
    idImage int,
    nomImage varchar(255),
    dataImage longblob,
    constraint pk_image primary key (idImage)
);

CREATE TABLE UTILISATEUR (
    idUtilisateur int,
    nomUtilisateur varchar(255),
    prenomUtilisateur varchar(255),
    emailUtilisateur varchar(255) UNIQUE,
    motDePasseUtilisateur varchar(255),
    idImage int,
    constraint pk_utilisateur primary key (idUtilisateur),
    constraint fk_utilisateur_image foreign key (idImage) references IMAGE_BD (idImage)
);

CREATE TABLE ROLE_UTILISATEUR (
    idRole int,
    nomRole varchar(255),
    constraint pk_role primary key (idRole)
);

CREATE TABLE A_ROLE (
    idUtilisateur int,
    idRole int,
    idArtiste int,
    constraint pk_a_role primary key (idUtilisateur, idRole, idArtiste),
    constraint fk_a_role_utilisateur foreign key (idUtilisateur) references UTILISATEUR (idUtilisateur),
    constraint fk_a_role_role foreign key (idRole) references ROLE_UTILISATEUR (idRole),
    constraint fk_a_role_artiste foreign key (idArtiste) references ARTISTE (idArtiste)
);

CREATE TABLE ALBUM (
    idAlbum int,
    nomAlbum varchar(255),
    descriptionAlbum varchar(255),
    anneeAlbum int,
    idArtiste int,
    idImage int,
    constraint pk_album primary key (idAlbum),
    constraint fk_album_artiste foreign key (idArtiste) references ARTISTE (idArtiste),
    constraint fk_album_image foreign key (idImage) references IMAGE_BD (idImage)
);

CREATE TABLE MUSIQUE (
    idMusique int,
    nomMusique varchar(255),
    descriptionMusique varchar(255),
    idImage int,
    constraint pk_musique primary key (idMusique),
    constraint fk_musique_image foreign key (idImage) references IMAGE_BD (idImage)
);

CREATE TABLE PLAYLIST (
    idPlaylist int,
    nomPlaylist varchar(255),
    descriptionPlaylist varchar(255),
    constraint pk_playlist primary key (idPlaylist)
);

CREATE TABLE A_PLAYLIST (
    idPlaylist int,
    idUtilisateur int,
    constraint pk_a_playlist primary key (idPlaylist, idUtilisateur),
    constraint fk_a_playlist_playlist foreign key (idPlaylist) references PLAYLIST (idPlaylist),
    constraint fk_a_playlist_utilisateur foreign key (idUtilisateur) references UTILISATEUR (idUtilisateur)
);

CREATE TABLE EST_DANS (
    idPlaylist int,
    idMusique int,
    constraint pk_est_dans primary key (idPlaylist, idMusique),
    constraint fk_est_dans_playlist foreign key (idPlaylist) references PLAYLIST (idPlaylist),
    constraint fk_est_dans_musique foreign key (idMusique) references MUSIQUE (idMusique)
);

CREATE TABLE EST_CONSTITUE(
    idAlbum int,
    idMusique int,
    constraint pk_est_constitue primary key (idAlbum, idMusique),
    constraint fk_est_constitue_album foreign key (idAlbum) references ALBUM (idAlbum),
    constraint fk_est_constitue_musique foreign key (idMusique) references MUSIQUE (idMusique)
);

CREATE TABLE EST_GENRE (
    idGenre int,
    idAlbum int,
    constraint pk_est_genre primary key (idGenre, idAlbum),
    constraint fk_est_genre_genre foreign key (idGenre) references GENRE (idGenre),
    constraint fk_est_genre_album foreign key (idAlbum) references ALBUM (idAlbum)
);

CREATE TABLE FAVORIS(
    idUtilisateur int,
    idAlbum int,
    constraint pk_favoris primary key (idUtilisateur, idAlbum),
    constraint fk_favoris_utilisateur foreign key (idUtilisateur) references UTILISATEUR (idUtilisateur),
    constraint fk_favoris_album foreign key (idAlbum) references ALBUM (idAlbum)
);

CREATE TABLE NOTE (
    idUtilisateur int,
    idAlbum int,
    note FLOAT,
    constraint pk_note primary key (idUtilisateur, idAlbum),
    constraint fk_note_utilisateur foreign key (idUtilisateur) references UTILISATEUR (idUtilisateur),
    constraint fk_note_album foreign key (idAlbum) references ALBUM (idAlbum)
);