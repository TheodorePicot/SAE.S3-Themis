create table "Questions"
(
    "idQuestion"           serial
        constraint questions_pk
            primary key,
    "titreQuestion"        varchar(256) not null,
    "dateDebutProposition" date         not null,
    "dateFinProposition"   date         not null,
    "dateDebutVote"        date         not null,
    "dateFinVote"          date         not null,
    "descriptionQuestion"  text,
    "nbSections"           integer default 0
);

create table "Sections"
(
    "idSection"          serial
        constraint sections_pk
            primary key,
    "idQuestion"         integer not null
        constraint sections_fk
            references "Questions"
            on update cascade on delete cascade,
    "titreSection"       varchar(128),
    "descriptionSection" text
);

create trigger tr_increment_nbsections_after_insert_on_sections
    after insert
    on "Sections"
    for each row
execute procedure incrementnbsections();

create trigger tr_decrement_nbsections_after_delete_on_sections
    after delete
    on "Sections"
    for each row
execute procedure decrementnbsections();

create table "Utilisateurs"
(
    login           varchar(64) not null
        constraint "Utilisateurs_pk"
            primary key,
    nom             varchar(128),
    prenom          varchar(128),
    "adresseMail"   varchar(64),
    "dateNaissance" date,
    mdp             varchar(128)
);

create table "Proposition"
(
    "idProposition" serial
        constraint "Proposition_pk"
            primary key,
    "idQuestion"    integer not null
        constraint "Proposition_Questions__fk"
            references "Questions"
);

create table "SectionProposition"
(
    "idSectionProposition" serial
        constraint "SectionProposition_pk"
            primary key,
    "texteProposition"     text,
    "idSection"            integer not null
        constraint "SectionProposition_Sections_null_fk"
            references "Sections",
    "idProposition"        integer not null
        constraint "SectionProposition_Proposition_null_fk"
            references Propositions
);

create table "estAuteur"
(
    login        varchar not null
        constraint "estAuteur_Utilisateurs_null_fk"
            references "Utilisateurs"
            on update cascade on delete cascade,
    "idQuestion" integer not null
        constraint "estAuteur_Questions_null_fk"
            references "Questions"
            on update cascade on delete cascade,
    constraint "estAuteur_pk"
        primary key (login, "idQuestion")
);

create table "estVotant"
(
    login        varchar not null
        constraint "estVotant_Utilisateurs_null_fk"
            references "Utilisateurs"
            on update cascade on delete cascade,
    "idQuestion" integer not null
        constraint "estVotant_Questions_null_fk"
            references "Questions"
            on update cascade on delete cascade,
    constraint "estVotant_pk"
        primary key ("idQuestion", login)
);

