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

DROP TRIGGER tr_increment_nbSections_after_insert_on_Sections ON "Sections";

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

DROP TRIGGER tr_decrement_nbSections_after_delete_on_Sections ON "Sections";

CREATE TRIGGER tr_decrement_nbSections_after_delete_on_Sections
    AFTER DELETE
    ON "Sections"
    FOR EACH ROW
EXECUTE PROCEDURE decrementNbSections();

-- Trigger de contrainte unique pour les propositions

CREATE OR REPLACE FUNCTION checkIfAlreadyInsertedProposition()
    RETURNS TRIGGER
AS
$body$
DECLARE
    v_count INT;
BEGIN
    SELECT COUNT(*) INTO v_count
    FROM "Propositions"
    WHERE "loginAuteur" = NEW."loginAuteur"
    AND "idQuestion" = NEW."idQuestion";

    IF v_count >= 1 THEN
        RAISE EXCEPTION using message = 'Vous avez déjà créer une proposition' , ERRCODE = '23000';
    END IF;
    RETURN NEW;

END;
$body$ LANGUAGE plpgsql;

CREATE TRIGGER tr_decrement_nbSections_after_delete_on_Sections
    BEFORE INSERT
    ON "Propositions"
    FOR EACH ROW
EXECUTE PROCEDURE checkIfAlreadyInsertedProposition();

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

-- Trigger si coAuteur Appartient a la proposition

CREATE OR REPLACE FUNCTION isCoAuteurInQuestion(p_login "Utilisateurs".login%TYPE,
                                        p_idProposition "Propositions"."idProposition"%TYPE)
    RETURNS BOOL
    LANGUAGE plpgsql
AS
$$
DECLARE
    nbUtilisateur INT;

BEGIN

    SELECT COUNT(*)
    INTO nbUtilisateur
    FROM "estCoAuteur"
    WHERE login = p_login
      AND "idProposition" = p_idProposition;

    RETURN nbUtilisateur > 0;

END;
$$