-- Table: public.upi_negeri

-- DROP TABLE IF EXISTS public.upi_negeri;

CREATE TABLE IF NOT EXISTS public.upi_negeri
(
    id_negeri character varying(50) COLLATE pg_catalog."default" NOT NULL,
    nama_negeri character varying(150) COLLATE pg_catalog."default",
    kod_negeri character varying(150) COLLATE pg_catalog."default",
    CONSTRAINT upi_negeri_pkey PRIMARY KEY (id_negeri),
    CONSTRAINT upi_negeri_kod_negeri_key UNIQUE (kod_negeri)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.upi_negeri
    OWNER to postgres;

-- Table: public.upi_daerah

-- DROP TABLE IF EXISTS public.upi_daerah;

CREATE TABLE IF NOT EXISTS public.upi_daerah
(
    id_daerah character varying(50) COLLATE pg_catalog."default" NOT NULL,
    nama_daerah character varying(150) COLLATE pg_catalog."default",
    kod_daerah character varying(150) COLLATE pg_catalog."default",
    kod_negeri character varying(150) COLLATE pg_catalog."default",
    CONSTRAINT upi_daerah_pkey PRIMARY KEY (id_daerah)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.upi_daerah
    OWNER to postgres;

-- Table: public.upi_mukim

-- DROP TABLE IF EXISTS public.upi_mukim;

CREATE TABLE IF NOT EXISTS public.upi_mukim
(
    id_mukim character varying(50) COLLATE pg_catalog."default" NOT NULL,
    nama_mukim character varying(150) COLLATE pg_catalog."default",
    kod_mukim character varying(150) COLLATE pg_catalog."default",
    kod_daerah character varying(150) COLLATE pg_catalog."default",
    kod_negeri character varying(150) COLLATE pg_catalog."default",
    CONSTRAINT upi_mukim_pkey PRIMARY KEY (id_mukim)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.upi_mukim
    OWNER to postgres;

-- Table: public.upi_parlimen

-- DROP TABLE IF EXISTS public.upi_parlimen;

CREATE TABLE IF NOT EXISTS public.upi_parlimen
(
    id_parlimen character varying(50) COLLATE pg_catalog."default" NOT NULL,
	nama_parlimen character varying(255) COLLATE pg_catalog."default",
    kod_parlimen character varying(100) COLLATE pg_catalog."default",
    kod_negeri character varying(10) COLLATE pg_catalog."default",
    CONSTRAINT upi_parlimen_pkey PRIMARY KEY (id_parlimen)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.upi_parlimen
    OWNER to postgres;

-- Table: public.upi_dun

-- DROP TABLE IF EXISTS public.upi_dun;

CREATE TABLE IF NOT EXISTS public.upi_dun
(
    id_dun character varying(50) COLLATE pg_catalog."default" NOT NULL,
    nama_dun character varying(255) COLLATE pg_catalog."default",
    kod_dun character varying(100) COLLATE pg_catalog."default",
    kod_parlimen character varying(100) COLLATE pg_catalog."default",
    CONSTRAINT upi_dun_pkey PRIMARY KEY (id_dun)
)

TABLESPACE pg_default;

ALTER TABLE IF EXISTS public.upi_dun
    OWNER to postgres;

