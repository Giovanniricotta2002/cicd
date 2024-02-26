--------------------------------------------------------------------------------
-- Mise à jour des séquences avec le max + 1
--
-- @package openfoncier
-- @version SVN : $Id: update_sequences.sql 3252 2015-01-22 18:07:30Z vpihour $
--------------------------------------------------------------------------------

--
CREATE OR REPLACE FUNCTION fn_fixsequences(schema TEXT) RETURNS integer AS
$BODY$
DECLARE
themax BIGINT;
mytables RECORD;
num integer;
BEGIN
 num := 0;

 FOR mytables IN
    SELECT
        c.table_name as table_name, c.column_name as column_name, c.data_type as data_type
    FROM
        information_schema.table_constraints tc 
    JOIN information_schema.constraint_column_usage AS ccu USING (constraint_schema, constraint_name) 
    JOIN information_schema.columns AS c ON c.table_schema = tc.constraint_schema AND tc.table_name = c.table_name AND ccu.column_name = c.column_name
    where constraint_type = 'PRIMARY KEY' and tc.constraint_schema = schema
 LOOP
    IF (mytables.data_type = 'integer') THEN
        EXECUTE 'ALTER SEQUENCE '|| schema || '.' || mytables.column_name ||'_seq OWNED BY '||schema||'.'||mytables.table_name||'.'||mytables.column_name||';';
    END IF;
END LOOP;


 FOR mytables IN
    SELECT  S.relname as seq, C.attname as attname, T.relname as relname
    FROM pg_class AS S, pg_depend AS D, pg_class AS T, pg_attribute AS C, information_schema.tables
    WHERE S.relkind = 'S'
        AND S.oid = D.objid
        AND D.refobjid = T.oid
        AND D.refobjid = C.attrelid
        AND D.refobjsubid = C.attnum
        AND table_name=T.relname
        AND table_schema = schema
 LOOP
      EXECUTE 'SELECT MAX('||mytables.attname||') FROM '||schema||'.'||mytables.relname||';' INTO themax;
      IF (themax is null OR themax < 0) THEN
       themax := 0;
      END IF;
      themax := themax +1;
      EXECUTE 'ALTER SEQUENCE ' ||schema||'.'|| mytables.seq || ' RESTART WITH '||themax;
      num := num + 1;
  END LOOP;
  
  RETURN num;
  
END;
$BODY$
LANGUAGE 'plpgsql' VOLATILE;

--
select fn_fixsequences(:schema);

--
DROP FUNCTION IF EXISTS fn_fixsequences(text);
