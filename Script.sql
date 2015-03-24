--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.1
-- Dumped by pg_dump version 9.4.1
-- Started on 2015-03-24 09:17:00

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 180 (class 3079 OID 11855)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2033 (class 0 OID 0)
-- Dependencies: 180
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

--
-- TOC entry 193 (class 1255 OID 16460)
-- Name: FUNC_NUMERO_ACTIVIDAD(); Type: FUNCTION; Schema: public; Owner: postgres
--

CREATE FUNCTION "FUNC_NUMERO_ACTIVIDAD"() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
SELECT COALESCE(MAX("numero") + 1, 1)
INTO NEW."numero"
FROM "Actividad" WHERE "Actividad"."idProyecto" = NEW."idProyecto";
RETURN NEW;
END;
$$;


ALTER FUNCTION public."FUNC_NUMERO_ACTIVIDAD"() OWNER TO postgres;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 179 (class 1259 OID 16436)
-- Name: Actividad; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Actividad" (
    "idActividad" integer NOT NULL,
    "idProyecto" integer NOT NULL,
    numero integer NOT NULL,
    tipo character(128) NOT NULL,
    "fechaInicio" date NOT NULL,
    "fechaFin" date NOT NULL,
    "idUsuario" integer NOT NULL,
    descripcion character(256) NOT NULL
);


ALTER TABLE "Actividad" OWNER TO postgres;

--
-- TOC entry 178 (class 1259 OID 16434)
-- Name: Actividad_idActividad_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Actividad_idActividad_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Actividad_idActividad_seq" OWNER TO postgres;

--
-- TOC entry 2034 (class 0 OID 0)
-- Dependencies: 178
-- Name: Actividad_idActividad_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Actividad_idActividad_seq" OWNED BY "Actividad"."idActividad";


--
-- TOC entry 177 (class 1259 OID 16418)
-- Name: Proyecto; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Proyecto" (
    "idProyecto" integer NOT NULL,
    nombre character(128) NOT NULL,
    "fechaInicio" date NOT NULL,
    "fechaFin" date NOT NULL,
    detalle character(256),
    "idUsuario" integer NOT NULL
);


ALTER TABLE "Proyecto" OWNER TO postgres;

--
-- TOC entry 176 (class 1259 OID 16416)
-- Name: Proyecto_idProyecto_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Proyecto_idProyecto_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Proyecto_idProyecto_seq" OWNER TO postgres;

--
-- TOC entry 2035 (class 0 OID 0)
-- Dependencies: 176
-- Name: Proyecto_idProyecto_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Proyecto_idProyecto_seq" OWNED BY "Proyecto"."idProyecto";


--
-- TOC entry 173 (class 1259 OID 16397)
-- Name: Rol; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Rol" (
    "idRol" integer NOT NULL,
    nombre character(128) NOT NULL
);


ALTER TABLE "Rol" OWNER TO postgres;

--
-- TOC entry 172 (class 1259 OID 16395)
-- Name: Rol_idRol_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Rol_idRol_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Rol_idRol_seq" OWNER TO postgres;

--
-- TOC entry 2037 (class 0 OID 0)
-- Dependencies: 172
-- Name: Rol_idRol_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Rol_idRol_seq" OWNED BY "Rol"."idRol";


--
-- TOC entry 175 (class 1259 OID 16405)
-- Name: Usuario; Type: TABLE; Schema: public; Owner: postgres; Tablespace: 
--

CREATE TABLE "Usuario" (
    "idUsuario" integer NOT NULL,
    usuario character(128) NOT NULL,
    password character(128) NOT NULL,
    correo character(128),
    "idRol" integer NOT NULL
);


ALTER TABLE "Usuario" OWNER TO postgres;

--
-- TOC entry 174 (class 1259 OID 16403)
-- Name: Usuario_idUsuario_seq; Type: SEQUENCE; Schema: public; Owner: postgres
--

CREATE SEQUENCE "Usuario_idUsuario_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Usuario_idUsuario_seq" OWNER TO postgres;

--
-- TOC entry 2039 (class 0 OID 0)
-- Dependencies: 174
-- Name: Usuario_idUsuario_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: postgres
--

ALTER SEQUENCE "Usuario_idUsuario_seq" OWNED BY "Usuario"."idUsuario";


--
-- TOC entry 1903 (class 2604 OID 16439)
-- Name: idActividad; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Actividad" ALTER COLUMN "idActividad" SET DEFAULT nextval('"Actividad_idActividad_seq"'::regclass);


--
-- TOC entry 1902 (class 2604 OID 16421)
-- Name: idProyecto; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Proyecto" ALTER COLUMN "idProyecto" SET DEFAULT nextval('"Proyecto_idProyecto_seq"'::regclass);


--
-- TOC entry 1900 (class 2604 OID 16400)
-- Name: idRol; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Rol" ALTER COLUMN "idRol" SET DEFAULT nextval('"Rol_idRol_seq"'::regclass);


--
-- TOC entry 1901 (class 2604 OID 16408)
-- Name: idUsuario; Type: DEFAULT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Usuario" ALTER COLUMN "idUsuario" SET DEFAULT nextval('"Usuario_idUsuario_seq"'::regclass);


--
-- TOC entry 1911 (class 2606 OID 16441)
-- Name: Actividad_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Actividad"
    ADD CONSTRAINT "Actividad_PK" PRIMARY KEY ("idActividad");


--
-- TOC entry 1909 (class 2606 OID 16423)
-- Name: Proyectos_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Proyecto"
    ADD CONSTRAINT "Proyectos_PK" PRIMARY KEY ("idProyecto");


--
-- TOC entry 1905 (class 2606 OID 16402)
-- Name: Rol_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Rol"
    ADD CONSTRAINT "Rol_PK" PRIMARY KEY ("idRol");


--
-- TOC entry 1907 (class 2606 OID 16410)
-- Name: Usuario_PK; Type: CONSTRAINT; Schema: public; Owner: postgres; Tablespace: 
--

ALTER TABLE ONLY "Usuario"
    ADD CONSTRAINT "Usuario_PK" PRIMARY KEY ("idUsuario");


--
-- TOC entry 1916 (class 2620 OID 16461)
-- Name: TRIGGER_NUMERO_ACTIVIDAD; Type: TRIGGER; Schema: public; Owner: postgres
--

CREATE TRIGGER "TRIGGER_NUMERO_ACTIVIDAD" BEFORE INSERT ON "Actividad" FOR EACH ROW EXECUTE PROCEDURE "FUNC_NUMERO_ACTIVIDAD"();


--
-- TOC entry 1915 (class 2606 OID 16447)
-- Name: Actividad_Proyecto_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Actividad"
    ADD CONSTRAINT "Actividad_Proyecto_FK" FOREIGN KEY ("idProyecto") REFERENCES "Proyecto"("idProyecto") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1914 (class 2606 OID 16442)
-- Name: Actividad_Usuario_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Actividad"
    ADD CONSTRAINT "Actividad_Usuario_FK" FOREIGN KEY ("idUsuario") REFERENCES "Usuario"("idUsuario") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1913 (class 2606 OID 16429)
-- Name: Proyecto_Usuario_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Proyecto"
    ADD CONSTRAINT "Proyecto_Usuario_FK" FOREIGN KEY ("idUsuario") REFERENCES "Usuario"("idUsuario") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 1912 (class 2606 OID 16411)
-- Name: Usuario_Rol_FK; Type: FK CONSTRAINT; Schema: public; Owner: postgres
--

ALTER TABLE ONLY "Usuario"
    ADD CONSTRAINT "Usuario_Rol_FK" FOREIGN KEY ("idRol") REFERENCES "Rol"("idRol") ON UPDATE CASCADE ON DELETE CASCADE;


--
-- TOC entry 2032 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- TOC entry 2036 (class 0 OID 0)
-- Dependencies: 173
-- Name: Rol; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Rol" FROM PUBLIC;
REVOKE ALL ON TABLE "Rol" FROM postgres;
GRANT ALL ON TABLE "Rol" TO postgres;
GRANT ALL ON TABLE "Rol" TO PUBLIC;


--
-- TOC entry 2038 (class 0 OID 0)
-- Dependencies: 175
-- Name: Usuario; Type: ACL; Schema: public; Owner: postgres
--

REVOKE ALL ON TABLE "Usuario" FROM PUBLIC;
REVOKE ALL ON TABLE "Usuario" FROM postgres;
GRANT ALL ON TABLE "Usuario" TO postgres;
GRANT ALL ON TABLE "Usuario" TO PUBLIC;


-- Completed on 2015-03-24 09:17:01

--
-- PostgreSQL database dump complete
--

