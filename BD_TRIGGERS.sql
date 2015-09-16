-- --------------------------------------------------
-- Name: cpf_validation (VALIDATE BRAZILIAN NACIONAL ID (CPF) 
-- --------------------------------------------------

CREATE OR REPLACE FUNCTION cpf_validation() RETURNS trigger AS $cpf_validation$

DECLARE
	x real;
	y real; --Temporary Variable
	sum integer;
	dig1 integer; --Firt CPF digit
	dig2 integer; --Second CPF digit
	len integer; -- CPF length
	countloop integer; --loop counter
	par_cpf varchar(11); --parameter
	val_par_cpf varchar(11); --parameter value
	
BEGIN
	par_cpf := NEW.id;
	IF char_length(par_cpf) = 11 THEN
	ELSE
		RAISE EXCEPTION 'Invalid format: %',par_cpf;
		RETURN new;
	END IF;
	
	-- Initialization
	x := 0;
	sum := 0;
	dig1 := 0;
	dig2 := 0;
	countloop := 0;
	val_par_cpf := par_cpf; --Parameter assignment to parameter value
	len := char_length(val_par_cpf);
	x := len -1;

	--Multiplication loop - first digit
	countloop :=1;
	WHILE countloop <= (len -2) LOOP
		y := CAST(substring(val_par_cpf from countloop for 1) AS NUMERIC);
		sum := sum + ( y * x);
		x := x - 1;
		countloop := countloop +1;
	END LOOP;
	dig1 := 11 - CAST((sum % 11) AS INTEGER);
	if (dig1 = 10) THEN dig1 :=0 ; END IF;
	if (dig1 = 11) THEN dig1 :=0 ; END IF;

	-- Digit second digit
	x := 11; sum :=0;
	countloop :=1;
	WHILE countloop <= (len -1) LOOP
		sum := sum + CAST((substring(val_par_cpf FROM countloop FOR 1)) AS REAL) * x;
		x := x - 1;
		countloop := countloop +1;
	END LOOP;

	dig2 := 11 - CAST ((sum % 11) AS INTEGER);
	IF (dig2 = 10) THEN dig2 := 0; END IF;
	IF (dig2 = 11) THEN dig2 := 0; END IF;

	--CPF sanity check
	IF ((dig1 || '' || dig2) = substring(val_par_cpf FROM len-1 FOR 2)) THEN
		RETURN new;
	ELSE
		RAISE EXCEPTION 'Invalid CPF: %',par_cpf;
		RETURN new;
	END IF;
END;

$cpf_validation$
 LANGUAGE plpgsql VOLATILE
 COST 100;
ALTER FUNCTION cpf_validation()
 OWNER TO postgres;
 
create trigger cpf_validation before insert or update on author
FOR EACH ROW EXECUTE PROCEDURE cpf_validation();

-- --------------------------------------------------
-- Name: author_validation
-- --------------------------------------------------

CREATE FUNCTION author_validation() RETURNS TRIGGER AS $author_validation$

DECLARE
	counter int;
	message varchar(100);

BEGIN
	counter := 0;
	message := '';
	
	IF NEW.name !~ '^(([a-zA-Z ]|[éáãõ])*)$' THEN
		counter := counter + 1;
		message := 'Invalid Name';
	END IF;
	
	IF NEW.address !~ '^(([a-zA-Z ]|[ÉéÃãáÁÕõ]|[0-9]|,|-)*)$' THEN
		counter := counter + 1;
		message := message || 'Invalid Address';
	END IF;

	IF NEW.email !~ '^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$' THEN
		counter := counter + 1;
		message := message || 'Invalid Email';
	END IF;

	IF NEW.password !~ '^(?=.*\d)(?=.*[a-zA-Z]).{8,20}$' THEN
		counter := counter + 1;
		message := message || 'Invalid Password';
	ELSE NEW.password = md5(NEW.password); 
	END IF;

	IF NEW.permission !~ 'A|B' THEN
		counter := counter + 1;
		message := message || 'Invalid Permission';
	END IF;

	IF counter != 0 THEN
		RAISE EXCEPTION '%',message;
	ELSE RETURN NEW;
	END IF;
END;

 $author_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER author_validation BEFORE INSERT OR UPDATE ON author
 FOR EACH ROW EXECUTE PROCEDURE author_validation();

-- --------------------------------------------------
-- Name: article_validation
-- --------------------------------------------------

CREATE FUNCTION article_validation() RETURNS TRIGGER AS $article_validation$

	DECLARE
		counter int;
		current_year int;
		article_year int; 
		message varchar(100);

	BEGIN
		current_year := DATE_PART('YEAR', CURRENT_TIMESTAMP);
		counter := 0;
		message := '';

		IF NEW.title !~ '^(([a-zA-Z ]|[ÉéÃãÕõ]|[0-9]|,|-|:)*)$' THEN	
			counter := counter + 1;
			message := 'Invalid Title';
		END IF;
 
		IF NEW.year !~ '^[0-9]{4}$' THEN
			counter := counter + 1;
			message := message || 'Invalid Year';
		ELSE article_year := CAST(NEW.year AS int);	
		IF (current_year < article_year) THEN
			counter := counter + 1;
			message := message || 'Invalid Year';
		ELSE IF (article_year < 1900) THEN
			counter := counter + 1;
			message := message || 'Invalid Year';
		END IF;
		END IF;
		END IF;

		IF counter != 0 THEN
			RAISE EXCEPTION '%',message;
		ELSE RETURN NEW;
		END IF;
	END;

 $article_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER article_validation BEFORE INSERT OR UPDATE ON article
 FOR EACH ROW EXECUTE PROCEDURE article_validation();

-- --------------------------------------------------
-- Name: university_validation
-- --------------------------------------------------

CREATE FUNCTION university_validation() RETURNS TRIGGER AS $university_validation$

	DECLARE
		counter int;
		message varchar(100);
		
	BEGIN
		counter := 0;
		message := '';

		IF NEW.name !~ '^(([a-zA-Z ]|[ÉéÃãáÁÕõ])*)$' THEN
			counter := counter + 1;
			message := 'Invalid Name';
		END IF;

		IF NEW.address !~ '^(([a-zA-Z ]|[ÉéÃãáÁÕõ]|[0-9]|,|-)*)$' THEN
			counter := counter + 1;
			message := 'Invalid Address';
		END IF;

		IF NEW.zip_code !~ '^[0-9]{5}-[0-9]{3}$' THEN
			counter := counter + 1;
			message := 'Invalid Zip Code';
		END IF;

		IF NEW.initials !~ '^[aA-zZ]{0,10}$' THEN
			counter := counter + 1;
			message := 'Invalid Initials';
		END IF;

		IF counter != 0 THEN
			RAISE EXCEPTION '%',message;
		ELSE RETURN NEW;
		END IF;
	END;

 $university_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER university_validation BEFORE INSERT OR UPDATE ON university
 FOR EACH ROW EXECUTE PROCEDURE university_validation();

-- --------------------------------------------------
-- Name: department_validation
-- --------------------------------------------------

CREATE FUNCTION department_validation() RETURNS TRIGGER AS $department_validation$

	DECLARE
		counter int;
		message varchar(100);
	
	BEGIN
		counter := 0;
		message := '';

		IF NEW.name !~ '^(([a-zA-Z ]|[ÉéÃãáÁÕõ])*)$' THEN
			counter := counter + 1;
			message := 'Invalid Name';
		END IF;

		IF NEW.initials !~ '^[aA-zZ]{0,10}$' THEN
			counter := counter + 1;
			message := 'Invalid Initials';
		END IF;
		
		IF counter != 0 THEN
			RAISE EXCEPTION '%',message;
		ELSE RETURN NEW;
		END IF;
		END;

 $department_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER department_validation BEFORE INSERT OR UPDATE ON department
 FOR EACH ROW EXECUTE PROCEDURE department_validation();

-- --------------------------------------------------
-- Name: template_validation
-- --------------------------------------------------

CREATE FUNCTION template_validation() RETURNS TRIGGER AS $template_validation$
 
	DECLARE
		counter int;
		message varchar(100);
 
	BEGIN
		counter := 0;
		message := '';
		
		IF NEW.name !~ '^(([a-zA-Z ]|_])*)$' THEN
			counter := counter + 1;
			message := 'Invalid Name';
		END IF;
	
		IF NEW.source_code !~ '^[a-zA-Z0-9-_\.|\\| //]+\.(tex)$' THEN
			counter := counter + 1;
			message := 'Invalid Path';
		END IF;

		IF counter != 0 THEN
			RAISE EXCEPTION '%',message;
		ELSE RETURN NEW;
		END IF;
	END;

 $template_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER template_validation BEFORE INSERT OR UPDATE ON template
 FOR EACH ROW EXECUTE PROCEDURE template_validation();

-- --------------------------------------------------
-- Name: journal_validation
-- --------------------------------------------------

CREATE FUNCTION journal_validation() RETURNS TRIGGER AS $journal_validation$

	DECLARE
		counter int;
		message varchar(100);
		
	BEGIN
		counter := 0;
		message := '';

		IF NEW.name !~ '^(([a-zA-Z ]|[ÉéÃãáÁÕõ])*)$' THEN
			counter := counter + 1;
			message := 'Invalid Name';
		END IF;
		
		IF counter != 0 THEN
			RAISE EXCEPTION '%',message;
		ELSE RETURN NEW;
		END IF;
	END;

 $journal_validation$ LANGUAGE plpgsql;
 CREATE TRIGGER journal_validation BEFORE INSERT OR UPDATE ON journal
 FOR EACH ROW EXECUTE PROCEDURE journal_validation();
