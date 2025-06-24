--
-- PostgreSQL database dump
--

-- Dumped from database version 17.5 (Debian 17.5-1.pgdg110+1)
-- Dumped by pg_dump version 17.5 (Debian 17.5-1.pgdg110+1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Data for Name: auth_group; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: django_content_type; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.django_content_type VALUES (1, 'admin', 'logentry');
INSERT INTO public.django_content_type VALUES (2, 'auth', 'permission');
INSERT INTO public.django_content_type VALUES (3, 'auth', 'group');
INSERT INTO public.django_content_type VALUES (4, 'auth', 'user');
INSERT INTO public.django_content_type VALUES (5, 'contenttypes', 'contenttype');
INSERT INTO public.django_content_type VALUES (6, 'sessions', 'session');
INSERT INTO public.django_content_type VALUES (7, 'location', 'typeacces');
INSERT INTO public.django_content_type VALUES (8, 'location', 'typelogement');
INSERT INTO public.django_content_type VALUES (9, 'location', 'terrain');
INSERT INTO public.django_content_type VALUES (10, 'location', 'maison');
INSERT INTO public.django_content_type VALUES (11, 'location', 'typedouche');


--
-- Data for Name: auth_permission; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_permission VALUES (1, 'Can add log entry', 1, 'add_logentry');
INSERT INTO public.auth_permission VALUES (2, 'Can change log entry', 1, 'change_logentry');
INSERT INTO public.auth_permission VALUES (3, 'Can delete log entry', 1, 'delete_logentry');
INSERT INTO public.auth_permission VALUES (4, 'Can view log entry', 1, 'view_logentry');
INSERT INTO public.auth_permission VALUES (5, 'Can add permission', 2, 'add_permission');
INSERT INTO public.auth_permission VALUES (6, 'Can change permission', 2, 'change_permission');
INSERT INTO public.auth_permission VALUES (7, 'Can delete permission', 2, 'delete_permission');
INSERT INTO public.auth_permission VALUES (8, 'Can view permission', 2, 'view_permission');
INSERT INTO public.auth_permission VALUES (9, 'Can add group', 3, 'add_group');
INSERT INTO public.auth_permission VALUES (10, 'Can change group', 3, 'change_group');
INSERT INTO public.auth_permission VALUES (11, 'Can delete group', 3, 'delete_group');
INSERT INTO public.auth_permission VALUES (12, 'Can view group', 3, 'view_group');
INSERT INTO public.auth_permission VALUES (13, 'Can add user', 4, 'add_user');
INSERT INTO public.auth_permission VALUES (14, 'Can change user', 4, 'change_user');
INSERT INTO public.auth_permission VALUES (15, 'Can delete user', 4, 'delete_user');
INSERT INTO public.auth_permission VALUES (16, 'Can view user', 4, 'view_user');
INSERT INTO public.auth_permission VALUES (17, 'Can add content type', 5, 'add_contenttype');
INSERT INTO public.auth_permission VALUES (18, 'Can change content type', 5, 'change_contenttype');
INSERT INTO public.auth_permission VALUES (19, 'Can delete content type', 5, 'delete_contenttype');
INSERT INTO public.auth_permission VALUES (20, 'Can view content type', 5, 'view_contenttype');
INSERT INTO public.auth_permission VALUES (21, 'Can add session', 6, 'add_session');
INSERT INTO public.auth_permission VALUES (22, 'Can change session', 6, 'change_session');
INSERT INTO public.auth_permission VALUES (23, 'Can delete session', 6, 'delete_session');
INSERT INTO public.auth_permission VALUES (24, 'Can view session', 6, 'view_session');
INSERT INTO public.auth_permission VALUES (25, 'Can add type acces', 7, 'add_typeacces');
INSERT INTO public.auth_permission VALUES (26, 'Can change type acces', 7, 'change_typeacces');
INSERT INTO public.auth_permission VALUES (27, 'Can delete type acces', 7, 'delete_typeacces');
INSERT INTO public.auth_permission VALUES (28, 'Can view type acces', 7, 'view_typeacces');
INSERT INTO public.auth_permission VALUES (29, 'Can add type logement', 8, 'add_typelogement');
INSERT INTO public.auth_permission VALUES (30, 'Can change type logement', 8, 'change_typelogement');
INSERT INTO public.auth_permission VALUES (31, 'Can delete type logement', 8, 'delete_typelogement');
INSERT INTO public.auth_permission VALUES (32, 'Can view type logement', 8, 'view_typelogement');
INSERT INTO public.auth_permission VALUES (33, 'Can add terrain', 9, 'add_terrain');
INSERT INTO public.auth_permission VALUES (34, 'Can change terrain', 9, 'change_terrain');
INSERT INTO public.auth_permission VALUES (35, 'Can delete terrain', 9, 'delete_terrain');
INSERT INTO public.auth_permission VALUES (36, 'Can view terrain', 9, 'view_terrain');
INSERT INTO public.auth_permission VALUES (37, 'Can add maison', 10, 'add_maison');
INSERT INTO public.auth_permission VALUES (38, 'Can change maison', 10, 'change_maison');
INSERT INTO public.auth_permission VALUES (39, 'Can delete maison', 10, 'delete_maison');
INSERT INTO public.auth_permission VALUES (40, 'Can view maison', 10, 'view_maison');
INSERT INTO public.auth_permission VALUES (41, 'Can add type douche', 11, 'add_typedouche');
INSERT INTO public.auth_permission VALUES (42, 'Can change type douche', 11, 'change_typedouche');
INSERT INTO public.auth_permission VALUES (43, 'Can delete type douche', 11, 'delete_typedouche');
INSERT INTO public.auth_permission VALUES (44, 'Can view type douche', 11, 'view_typedouche');


--
-- Data for Name: auth_group_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: auth_user; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.auth_user VALUES (1, 'pbkdf2_sha256$1000000$UkBsElDRy9KtW7QpMgno3i$+Zo+05JISwQOV4ksiGoGzFvs1V+c5AFY1jaOpo4o4uc=', '2025-06-13 15:14:24.068164+00', true, 'kaloy', '', '', '', true, true, '2025-06-13 15:14:10.360046+00');


--
-- Data for Name: auth_user_groups; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: auth_user_user_permissions; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: django_admin_log; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.django_admin_log VALUES (1, '2025-06-13 15:14:31.420674+00', '1', 'moto', 1, '[{"added": {}}]', 7, 1);
INSERT INTO public.django_admin_log VALUES (2, '2025-06-13 15:14:33.771809+00', '2', 'tongotra', 1, '[{"added": {}}]', 7, 1);
INSERT INTO public.django_admin_log VALUES (3, '2025-06-13 15:14:35.628708+00', '3', 'voiture', 1, '[{"added": {}}]', 7, 1);
INSERT INTO public.django_admin_log VALUES (4, '2025-06-13 15:14:37.498219+00', '4', 'voiture avec parking', 1, '[{"added": {}}]', 7, 1);
INSERT INTO public.django_admin_log VALUES (5, '2025-06-13 15:14:45.267618+00', '1', 'villa', 1, '[{"added": {}}]', 8, 1);
INSERT INTO public.django_admin_log VALUES (6, '2025-06-13 15:14:54.922648+00', '2', 'Appartement', 1, '[{"added": {}}]', 8, 1);
INSERT INTO public.django_admin_log VALUES (7, '2025-06-14 05:02:12.137574+00', '1', 'aucun', 1, '[{"added": {}}]', 11, 1);
INSERT INTO public.django_admin_log VALUES (8, '2025-06-14 05:02:24.538288+00', '2', 'exterieur', 1, '[{"added": {}}]', 11, 1);
INSERT INTO public.django_admin_log VALUES (9, '2025-06-14 05:02:43.107228+00', '3', 'intérieur', 1, '[{"added": {}}]', 11, 1);
INSERT INTO public.django_admin_log VALUES (10, '2025-06-14 05:13:25.738951+00', '3', 'maison', 1, '[{"added": {}}]', 8, 1);


--
-- Data for Name: django_migrations; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.django_migrations VALUES (1, 'contenttypes', '0001_initial', '2025-06-13 15:13:03.880001+00');
INSERT INTO public.django_migrations VALUES (2, 'auth', '0001_initial', '2025-06-13 15:13:03.990086+00');
INSERT INTO public.django_migrations VALUES (3, 'admin', '0001_initial', '2025-06-13 15:13:04.057143+00');
INSERT INTO public.django_migrations VALUES (4, 'admin', '0002_logentry_remove_auto_add', '2025-06-13 15:13:04.087277+00');
INSERT INTO public.django_migrations VALUES (5, 'admin', '0003_logentry_add_action_flag_choices', '2025-06-13 15:13:04.116225+00');
INSERT INTO public.django_migrations VALUES (6, 'contenttypes', '0002_remove_content_type_name', '2025-06-13 15:13:04.163855+00');
INSERT INTO public.django_migrations VALUES (7, 'auth', '0002_alter_permission_name_max_length', '2025-06-13 15:13:04.196315+00');
INSERT INTO public.django_migrations VALUES (8, 'auth', '0003_alter_user_email_max_length', '2025-06-13 15:13:04.233686+00');
INSERT INTO public.django_migrations VALUES (9, 'auth', '0004_alter_user_username_opts', '2025-06-13 15:13:04.263161+00');
INSERT INTO public.django_migrations VALUES (10, 'auth', '0005_alter_user_last_login_null', '2025-06-13 15:13:04.290401+00');
INSERT INTO public.django_migrations VALUES (11, 'auth', '0006_require_contenttypes_0002', '2025-06-13 15:13:04.30602+00');
INSERT INTO public.django_migrations VALUES (12, 'auth', '0007_alter_validators_add_error_messages', '2025-06-13 15:13:04.332885+00');
INSERT INTO public.django_migrations VALUES (13, 'auth', '0008_alter_user_username_max_length', '2025-06-13 15:13:04.366645+00');
INSERT INTO public.django_migrations VALUES (14, 'auth', '0009_alter_user_last_name_max_length', '2025-06-13 15:13:04.401894+00');
INSERT INTO public.django_migrations VALUES (15, 'auth', '0010_alter_group_name_max_length', '2025-06-13 15:13:04.432057+00');
INSERT INTO public.django_migrations VALUES (16, 'auth', '0011_update_proxy_permissions', '2025-06-13 15:13:04.46012+00');
INSERT INTO public.django_migrations VALUES (17, 'auth', '0012_alter_user_first_name_max_length', '2025-06-13 15:13:04.488645+00');
INSERT INTO public.django_migrations VALUES (18, 'location', '0001_initial', '2025-06-13 15:13:04.56253+00');
INSERT INTO public.django_migrations VALUES (19, 'sessions', '0001_initial', '2025-06-13 15:13:04.608445+00');
INSERT INTO public.django_migrations VALUES (20, 'location', '0002_typedouche_remove_maison_douche_toilette', '2025-06-14 04:58:18.974105+00');
INSERT INTO public.django_migrations VALUES (21, 'location', '0003_maison_douche_toilette', '2025-06-14 05:01:14.947261+00');


--
-- Data for Name: django_session; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.django_session VALUES ('ig0bu4fy6vmqe3j4vnerdr8ih2x1wdap', '.eJxVjEEOwiAQRe_C2pAiA7Qu3fcMzTDMSNVAUtqV8e7apAvd_vfef6kJtzVPW-NlmpO6KKNOv1tEenDZQbpjuVVNtazLHPWu6IM2PdbEz-vh_h1kbPlbOwAZQiDiJM71qUMBciYEZgGwZxJviDzFgdGShWA67ElIohcbjFHvDwKLOMs:1uQ66q:ntExISWWJ2qcDJn2tjU7PrEzeOo3i7Z7qQbmeyS0rKQ', '2025-06-27 15:14:24.086411+00');


--
-- Data for Name: location_typeacces; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.location_typeacces VALUES (1, 'moto');
INSERT INTO public.location_typeacces VALUES (2, 'tongotra');
INSERT INTO public.location_typeacces VALUES (3, 'voiture');
INSERT INTO public.location_typeacces VALUES (4, 'voiture avec parking');


--
-- Data for Name: location_typedouche; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.location_typedouche VALUES (1, 'aucun');
INSERT INTO public.location_typedouche VALUES (2, 'exterieur');
INSERT INTO public.location_typedouche VALUES (3, 'intérieur');


--
-- Data for Name: location_typelogement; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.location_typelogement VALUES (1, 'villa');
INSERT INTO public.location_typelogement VALUES (2, 'Appartement');
INSERT INTO public.location_typelogement VALUES (3, 'maison');


--
-- Data for Name: location_maison; Type: TABLE DATA; Schema: public; Owner: postgres
--

INSERT INTO public.location_maison VALUES (1, 3, '0101000020E61000000AA2EE0390B24740AE2EA704C4D032C0', 'Anosiala', 0, 1, 1, 1, NULL, NULL);
INSERT INTO public.location_maison VALUES (2, 3, '0101000020E61000001EFCC401F4D74540F27A30293E5A37C0', 'Toliara', 0, 4, 1, 3, NULL, NULL);
INSERT INTO public.location_maison VALUES (3, 3, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 125000000, 3, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (4, 2, '0101000020E6100000B1BFEC9E3C844740E86A2BF697DD33C0', 'Antsirabe', 61000000, 1, 2, 3, -19.8656, 47.0331);
INSERT INTO public.location_maison VALUES (5, 4, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 102000000, 2, 3, 1, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (6, 1, '0101000020E61000009A99999999B94740713D0AD7A3F033C0', 'Manandriana', 37000000, 4, 2, 3, -19.94, 47.45);
INSERT INTO public.location_maison VALUES (7, 2, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 54000000, 1, 3, 1, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (8, 2, '0101000020E610000012143FC6DC1D4840575BB1BFECEE32C0', 'Moramanga', 46000000, 3, 2, 3, -18.9333, 48.2333);
INSERT INTO public.location_maison VALUES (9, 3, '0101000020E6100000295C8FC2F568484052B81E85EBD132C0', 'Vatomandry', 42000000, 2, 3, 1, -18.82, 48.82);
INSERT INTO public.location_maison VALUES (10, 1, '0101000020E61000003333333333B3484066666666662632C0', 'Fenoarivo Atsinanana', 31000000, 4, 2, 3, -18.15, 49.4);
INSERT INTO public.location_maison VALUES (11, 5, '0101000020E61000009A99999999394840AEB6627FD95D2BC0', 'Ambanja', 72000000, 3, 3, 1, -13.6833, 48.45);
INSERT INTO public.location_maison VALUES (12, 2, '0101000020E610000066666666664646403333333333B338C0', 'Betioky', 29000000, 1, 2, 3, -24.7, 44.55);
INSERT INTO public.location_maison VALUES (13, 3, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 48000000, 2, 3, 1, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (14, 2, '0101000020E6100000DFE00B93A9EA4740A9A44E4013D136C0', 'Farafangana', 37000000, 3, 2, 3, -22.8167, 47.8333);
INSERT INTO public.location_maison VALUES (15, 4, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 88000000, 4, 3, 1, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (16, 1, '0101000020E610000066666666662648407B832F4CA6AA2AC0', 'Nosy Be', 53000000, 1, 2, 3, -13.3333, 48.3);
INSERT INTO public.location_maison VALUES (17, 3, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 97000000, 2, 3, 1, -18.1495, 49.4021);
INSERT INTO public.location_maison VALUES (18, 2, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 43000000, 3, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (19, 5, '0101000020E6100000ABCFD556ECA74840E561A1D6348F28C0', 'Antsiranana', 110000000, 4, 3, 1, -12.2797, 49.3119);
INSERT INTO public.location_maison VALUES (20, 1, '0101000020E6100000545227A0892847401E166A4DF36E2FC0', 'Mahajanga', 42000000, 1, 2, 3, -15.7167, 46.3167);
INSERT INTO public.location_maison VALUES (21, 4, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 75000000, 2, 3, 1, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (22, 2, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 38000000, 3, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (23, 3, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 89000000, 4, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (24, 1, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 33000000, 1, 2, 3, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (25, 2, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 52000000, 2, 3, 1, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (26, 2, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 40000000, 3, 2, 3, -18.1495, 49.4021);
INSERT INTO public.location_maison VALUES (27, 4, '0101000020E6100000787AA52C43244640F1F44A59864834C0', 'Morondava', 70000000, 4, 3, 1, -20.2833, 44.2833);
INSERT INTO public.location_maison VALUES (28, 1, '0101000020E6100000DFE00B93A92A48400F0BB5A6793735C0', 'Mananjary', 31000000, 1, 2, 3, -21.2167, 48.3333);
INSERT INTO public.location_maison VALUES (29, 3, '0101000020E610000013F241CF669D47402EFF21FDF68534C0', 'Ambositra', 68000000, 2, 3, 1, -20.5233, 47.2297);
INSERT INTO public.location_maison VALUES (30, 2, '0101000020E61000003333333333B34840423EE8D9AC2A32C0', 'Tamatave', 45000000, 3, 2, 3, -18.1667, 49.4);
INSERT INTO public.location_maison VALUES (31, 5, '0101000020E6100000B1BFEC9E3C844740E86A2BF697DD33C0', 'Antsirabe', 120000000, 4, 3, 1, -19.8656, 47.0331);
INSERT INTO public.location_maison VALUES (32, 1, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 35000000, 1, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (33, 3, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 85000000, 2, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (34, 2, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 42000000, 3, 2, 3, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (35, 4, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 96000000, 4, 3, 1, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (36, 1, '0101000020E6100000787AA52C43244640F1F44A59864834C0', 'Morondava', 31000000, 1, 2, 3, -20.2833, 44.2833);
INSERT INTO public.location_maison VALUES (37, 3, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 78000000, 2, 3, 1, -18.1495, 49.4021);
INSERT INTO public.location_maison VALUES (38, 2, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 42000000, 3, 2, 3, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (39, 5, '0101000020E6100000ABCFD556ECA74840E561A1D6348F28C0', 'Antsiranana', 110000000, 4, 3, 1, -12.2797, 49.3119);
INSERT INTO public.location_maison VALUES (40, 1, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 30000000, 1, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (41, 4, '0101000020E61000009A99999999394840AEB6627FD95D2BC0', 'Ambanja', 65000000, 2, 3, 1, -13.6833, 48.45);
INSERT INTO public.location_maison VALUES (42, 2, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 44000000, 3, 2, 3, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (43, 3, '0101000020E6100000545227A0892847401E166A4DF36E2FC0', 'Mahajanga', 87000000, 4, 3, 1, -15.7167, 46.3167);
INSERT INTO public.location_maison VALUES (44, 1, '0101000020E6100000DFE00B93A92A48400F0BB5A6793735C0', 'Mananjary', 28000000, 1, 2, 3, -21.2167, 48.3333);
INSERT INTO public.location_maison VALUES (45, 3, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 79000000, 2, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (46, 2, '0101000020E61000003333333333B34840423EE8D9AC2A32C0', 'Tamatave', 43000000, 3, 2, 3, -18.1667, 49.4);
INSERT INTO public.location_maison VALUES (47, 4, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 92000000, 4, 3, 1, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (48, 1, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 31000000, 1, 2, 3, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (49, 3, '0101000020E6100000787AA52C43244640F1F44A59864834C0', 'Morondava', 67000000, 2, 3, 1, -20.2833, 44.2833);
INSERT INTO public.location_maison VALUES (50, 2, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 40000000, 3, 2, 3, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (51, 5, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 130000000, 4, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (52, 1, '0101000020E6100000545227A0892847401E166A4DF36E2FC0', 'Mahajanga', 29000000, 1, 2, 3, -15.7167, 46.3167);
INSERT INTO public.location_maison VALUES (53, 4, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 71000000, 2, 3, 1, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (54, 2, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 44000000, 3, 2, 3, -18.1495, 49.4021);
INSERT INTO public.location_maison VALUES (55, 3, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 88000000, 4, 3, 1, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (56, 1, '0101000020E6100000B1BFEC9E3C844740E86A2BF697DD33C0', 'Antsirabe', 32000000, 1, 2, 3, -19.8656, 47.0331);
INSERT INTO public.location_maison VALUES (57, 3, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 67000000, 2, 3, 1, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (58, 2, '0101000020E61000009A99999999394840AEB6627FD95D2BC0', 'Ambanja', 45000000, 3, 2, 3, -13.6833, 48.45);
INSERT INTO public.location_maison VALUES (59, 4, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 99000000, 4, 3, 1, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (60, 1, '0101000020E6100000DFE00B93A92A48400F0BB5A6793735C0', 'Mananjary', 31000000, 1, 2, 3, -21.2167, 48.3333);
INSERT INTO public.location_maison VALUES (61, 3, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 85000000, 2, 3, 1, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (62, 2, '0101000020E6100000787AA52C43244640F1F44A59864834C0', 'Morondava', 42000000, 3, 2, 3, -20.2833, 44.2833);
INSERT INTO public.location_maison VALUES (63, 5, '0101000020E61000003333333333B34840423EE8D9AC2A32C0', 'Tamatave', 120000000, 4, 3, 1, -18.1667, 49.4);
INSERT INTO public.location_maison VALUES (64, 1, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 29000000, 1, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (65, 4, '0101000020E6100000ABCFD556ECA74840E561A1D6348F28C0', 'Antsiranana', 70000000, 2, 3, 1, -12.2797, 49.3119);
INSERT INTO public.location_maison VALUES (66, 2, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 43000000, 3, 2, 3, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (67, 3, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 87000000, 4, 3, 1, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (68, 1, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 31000000, 1, 2, 3, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (69, 3, '0101000020E6100000545227A0892847401E166A4DF36E2FC0', 'Mahajanga', 74000000, 2, 3, 1, -15.7167, 46.3167);
INSERT INTO public.location_maison VALUES (70, 2, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 42000000, 3, 2, 3, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (71, 4, '0101000020E6100000DFE00B93A92A48400F0BB5A6793735C0', 'Mananjary', 93000000, 4, 3, 1, -21.2167, 48.3333);
INSERT INTO public.location_maison VALUES (72, 1, '0101000020E61000003333333333B3484066666666662632C0', 'Fenoarivo Atsinanana', 31000000, 1, 2, 3, -18.15, 49.4);
INSERT INTO public.location_maison VALUES (73, 3, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 81000000, 2, 3, 1, -18.1495, 49.4021);
INSERT INTO public.location_maison VALUES (74, 2, '0101000020E6100000787AA52C43244640F1F44A59864834C0', 'Morondava', 41000000, 3, 2, 3, -20.2833, 44.2833);
INSERT INTO public.location_maison VALUES (75, 5, '0101000020E6100000B1BFEC9E3C844740E86A2BF697DD33C0', 'Antsirabe', 115000000, 4, 3, 1, -19.8656, 47.0331);
INSERT INTO public.location_maison VALUES (76, 1, '0101000020E610000009F9A067B38A4740C1CAA145B67335C0', 'Fianarantsoa', 32000000, 1, 2, 3, -21.452, 47.0836);
INSERT INTO public.location_maison VALUES (77, 4, '0101000020E61000008195438B6C37484014AE47E17AD431C0', 'Ambatondrazaka', 69000000, 2, 3, 1, -17.83, 48.433);
INSERT INTO public.location_maison VALUES (78, 2, '0101000020E6100000B7D100DE02C14740A9A44E4013E132C0', 'Antananarivo', 43000000, 3, 2, 3, -18.8792, 47.5079);
INSERT INTO public.location_maison VALUES (79, 3, '0101000020E6100000211FF46C561549400AD7A3703D8A2CC0', 'Sambava', 88000000, 4, 3, 1, -14.27, 50.1667);
INSERT INTO public.location_maison VALUES (80, 1, '0101000020E6100000EEEBC039230248408A8EE4F21F2236C0', 'Manakara', 30000000, 1, 2, 3, -22.1333, 48.0167);
INSERT INTO public.location_maison VALUES (81, 3, '0101000020E61000005DDC460378B3484083C0CAA1452632C0', 'Toamasina', 75000000, 2, 3, 1, -18.1495, 49.4021);


--
-- Data for Name: location_terrain; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Data for Name: spatial_ref_sys; Type: TABLE DATA; Schema: public; Owner: postgres
--



--
-- Name: auth_group_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_group_id_seq', 1, false);


--
-- Name: auth_group_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_group_permissions_id_seq', 1, false);


--
-- Name: auth_permission_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_permission_id_seq', 44, true);


--
-- Name: auth_user_groups_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_user_groups_id_seq', 1, false);


--
-- Name: auth_user_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_user_id_seq', 1, true);


--
-- Name: auth_user_user_permissions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.auth_user_user_permissions_id_seq', 1, false);


--
-- Name: django_admin_log_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.django_admin_log_id_seq', 10, true);


--
-- Name: django_content_type_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.django_content_type_id_seq', 11, true);


--
-- Name: django_migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.django_migrations_id_seq', 21, true);


--
-- Name: location_maison_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.location_maison_id_seq', 81, true);


--
-- Name: location_terrain_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.location_terrain_id_seq', 1, false);


--
-- Name: location_typeacces_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.location_typeacces_id_seq', 4, true);


--
-- Name: location_typedouche_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.location_typedouche_id_seq', 3, true);


--
-- Name: location_typelogement_id_seq; Type: SEQUENCE SET; Schema: public; Owner: postgres
--

SELECT pg_catalog.setval('public.location_typelogement_id_seq', 3, true);


--
-- PostgreSQL database dump complete
--

