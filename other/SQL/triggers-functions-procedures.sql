-- Trigger quand on ajoute une section à une question

CREATE OR REPLACE FUNCTION incrementNbSections()
    RETURNS TRIGGER
AS
$body$
BEGIN
    UPDATE "Questions"
    SET "nbSections" = "nbSections" + 1
    WHERE "idQuestion" = NEW."idQuestion";
    RETURN NEW;
END;
$body$ LANGUAGE plpgsql;

CREATE TRIGGER tr_increment_nbSections_after_insert_on_Sections
    AFTER INSERT
    ON "Sections"
    FOR EACH ROW
EXECUTE PROCEDURE incrementNbSections();

-- Trigger quand on supprime une section à une question

CREATE OR REPLACE FUNCTION decrementNbSections()
    RETURNS TRIGGER
AS
$body$
BEGIN
    UPDATE "Questions"
    SET "nbSections" = "nbSections" - 1
    WHERE "idQuestion" = OLD."idQuestion";
    RETURN OLD;
END;
$body$ LANGUAGE plpgsql;

CREATE TRIGGER tr_decrement_nbSections_after_delete_on_Sections
    AFTER DELETE
    ON "Sections"
    FOR EACH ROW
EXECUTE PROCEDURE decrementNbSections();

-- Triggers pour nbVotes

create function incrementnbvotes() returns trigger
    language plpgsql
as
$$
BEGIN
    UPDATE "Proposition"
    SET "nbVotes" = "nbVotes" + 1
    WHERE "idProposition" = NEW."idProposition";
    RETURN NEW;
END;
$$;

CREATE TRIGGER tr_increment_nbVotes_after_insert_on_Votes
    AFTER INSERT
    ON "Votes"
    FOR EACH ROW
EXECUTE PROCEDURE incrementNbVotes();

create function incrementnbvotes() returns trigger
    language plpgsql
as
$$
BEGIN
    UPDATE "Proposition"
    SET "nbVotes" = "nbVotes" - 1
    WHERE "idProposition" = NEW."idProposition";
    RETURN NEW;
END;
$$;

CREATE TRIGGER tr_increment_nbVotes_after_insert_on_Votes
    AFTER INSERT
    ON "Votes"
    FOR EACH ROW
EXECUTE PROCEDURE incrementNbVotes();


-- Fonction si le participant appartient à la question

CREATE OR REPLACE FUNCTION isVotantInQuestion(p_login "Utilisateurs".login%TYPE,
                                        p_idQuestion "Questions"."idQuestion"%TYPE)
    RETURNS BOOL
    LANGUAGE plpgsql
AS
$$
DECLARE
    nbUtilisateur INT;

BEGIN

    SELECT COUNT(*)
    INTO nbUtilisateur
    FROM "estVotant"
    WHERE login = p_login
      AND "idQuestion" = p_idQuestion;

    RETURN nbUtilisateur > 0;

END;
$$

CREATE OR REPLACE FUNCTION isAuteurInQuestion(p_login "Utilisateurs".login%TYPE,
                                        p_idQuestion "Questions"."idQuestion"%TYPE)
    RETURNS BOOL
    LANGUAGE plpgsql
AS
$$
DECLARE
    nbUtilisateur INT;

BEGIN

    SELECT COUNT(*)
    INTO nbUtilisateur
    FROM "estAuteur"
    WHERE login = p_login
      AND "idQuestion" = p_idQuestion;

    RETURN nbUtilisateur > 0;

END;
$$

SELECT isVotantInQuestion('asdfasdf',88);