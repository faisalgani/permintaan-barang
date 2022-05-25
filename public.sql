/*
 Navicat Premium Data Transfer

 Source Server         : postgre sql local
 Source Server Type    : PostgreSQL
 Source Server Version : 90300
 Source Host           : localhost:5432
 Source Catalog        : db_tickets
 Source Schema         : public

 Target Server Type    : PostgreSQL
 Target Server Version : 90300
 File Encoding         : 65001

 Date: 27/10/2021 09:22:23
*/


-- ----------------------------
-- Sequence structure for failed_jobs_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."failed_jobs_id_seq";
CREATE SEQUENCE "public"."failed_jobs_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Sequence structure for migrations_id_seq
-- ----------------------------
DROP SEQUENCE IF EXISTS "public"."migrations_id_seq";
CREATE SEQUENCE "public"."migrations_id_seq" 
INCREMENT 1
MINVALUE  1
MAXVALUE 9223372036854775807
START 1
CACHE 1;

-- ----------------------------
-- Table structure for auth
-- ----------------------------
DROP TABLE IF EXISTS "public"."auth";
CREATE TABLE "public"."auth" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "username" varchar(30) COLLATE "pg_catalog"."default" NOT NULL,
  "password" varchar(255) COLLATE "pg_catalog"."default",
  "active" bool NOT NULL DEFAULT false,
  "last_login" timestamp(0),
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "deleted_at" timestamp(0)
)
;

-- ----------------------------
-- Records of auth
-- ----------------------------
INSERT INTO "public"."auth" VALUES ('0', 'admin@mail.com', '$2y$10$47UgTWu0C8P2FhNI/ZgMqODonU8AAI9r9YUrIruoa67ef8xGZqc7K', 'f', NULL, '2021-10-19 08:46:07', '2021-10-19 08:46:07', NULL);

-- ----------------------------
-- Table structure for failed_jobs
-- ----------------------------
DROP TABLE IF EXISTS "public"."failed_jobs";
CREATE TABLE "public"."failed_jobs" (
  "id" int8 NOT NULL DEFAULT nextval('failed_jobs_id_seq'::regclass),
  "uuid" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "connection" text COLLATE "pg_catalog"."default" NOT NULL,
  "queue" text COLLATE "pg_catalog"."default" NOT NULL,
  "payload" text COLLATE "pg_catalog"."default" NOT NULL,
  "exception" text COLLATE "pg_catalog"."default" NOT NULL,
  "failed_at" timestamp(0) NOT NULL DEFAULT now()
)
;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS "public"."migrations";
CREATE TABLE "public"."migrations" (
  "id" int4 NOT NULL DEFAULT nextval('migrations_id_seq'::regclass),
  "migration" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "batch" int4 NOT NULL
)
;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO "public"."migrations" VALUES (1, '2014_10_12_100000_create_password_resets_table', 1);
INSERT INTO "public"."migrations" VALUES (2, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO "public"."migrations" VALUES (3, '2021_04_17_160417_create_m_users_table', 1);
INSERT INTO "public"."migrations" VALUES (4, '2021_04_17_161608_create_m_auths_table', 1);
INSERT INTO "public"."migrations" VALUES (5, '2021_04_17_163123_create_m_system_groups_table', 1);
INSERT INTO "public"."migrations" VALUES (6, '2021_04_17_163141_create_m_system_members_table', 1);
INSERT INTO "public"."migrations" VALUES (7, '2021_04_20_132851_func_stats_member_users', 1);
INSERT INTO "public"."migrations" VALUES (8, '2021_04_20_133118_func_trigger_auto_auth', 1);
INSERT INTO "public"."migrations" VALUES (9, '2021_04_20_133311_trigger_create_auth', 1);
INSERT INTO "public"."migrations" VALUES (10, '2021_04_20_143405_create_m_system_menus_table', 1);
INSERT INTO "public"."migrations" VALUES (11, '2021_04_20_143732_create_m_system_roles_table', 1);
INSERT INTO "public"."migrations" VALUES (12, '2021_04_21_163849_func_stats_role', 1);
INSERT INTO "public"."migrations" VALUES (13, '2021_04_21_165851_default_data', 1);
INSERT INTO "public"."migrations" VALUES (19, '2021_10_19_034916_add_coloum_tickes', 3);
INSERT INTO "public"."migrations" VALUES (21, '2021_10_19_015843_alter_table_menu', 5);
INSERT INTO "public"."migrations" VALUES (23, '2021_10_18_070744_create_table_tickets', 6);
INSERT INTO "public"."migrations" VALUES (24, '2021_10_20_112437_create_table_ticket_sell', 7);
INSERT INTO "public"."migrations" VALUES (25, '2021_10_25_073019_create_table_ticket_sell', 8);

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS "public"."password_resets";
CREATE TABLE "public"."password_resets" (
  "email" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "token" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "created_at" timestamp(0)
)
;

-- ----------------------------
-- Table structure for system_group
-- ----------------------------
DROP TABLE IF EXISTS "public"."system_group";
CREATE TABLE "public"."system_group" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "group" varchar(25) COLLATE "pg_catalog"."default" NOT NULL,
  "active" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone
)
;

-- ----------------------------
-- Records of system_group
-- ----------------------------
INSERT INTO "public"."system_group" VALUES ('6a106a98-f83d-40d8-ac0b-f0e20ee7166f', 'User', 't', '2021-10-19 01:46:07', '2021-10-19 01:46:07');
INSERT INTO "public"."system_group" VALUES ('d298295b-947a-417b-ad6b-740476096db0', 'Admin', 't', '2021-10-19 01:46:07', '2021-10-19 01:46:07');
INSERT INTO "public"."system_group" VALUES ('e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 'Super admin', 't', '2021-10-19 01:46:07', '2021-10-19 01:46:07');

-- ----------------------------
-- Table structure for system_member
-- ----------------------------
DROP TABLE IF EXISTS "public"."system_member";
CREATE TABLE "public"."system_member" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id_user" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id_group" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "active" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone
)
;

-- ----------------------------
-- Records of system_member
-- ----------------------------
INSERT INTO "public"."system_member" VALUES ('ef47664f9-67b1-48d6-b9af-970dfa7ad0b1', '0', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 01:46:06', '2021-10-19 01:46:06');

-- ----------------------------
-- Table structure for system_menu
-- ----------------------------
DROP TABLE IF EXISTS "public"."system_menu";
CREATE TABLE "public"."system_menu" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "menu" varchar(30) COLLATE "pg_catalog"."default" NOT NULL,
  "link" text COLLATE "pg_catalog"."default" NOT NULL,
  "icon" varchar(25) COLLATE "pg_catalog"."default",
  "parent" varchar(255) COLLATE "pg_catalog"."default",
  "class" varchar(50) COLLATE "pg_catalog"."default",
  "state" varchar(25) COLLATE "pg_catalog"."default",
  "order" varchar(10) COLLATE "pg_catalog"."default",
  "active" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone
)
;

-- ----------------------------
-- Records of system_menu
-- ----------------------------
INSERT INTO "public"."system_menu" VALUES ('e0a64f34-f7d9-4430-8427-a856e74549b6', 'Menu', '/admin/system_menu', NULL, 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', NULL, NULL, '2.5', 't', '2021-10-19 01:46:06', '2021-10-19 07:01:26');
INSERT INTO "public"."system_menu" VALUES ('af9b9870-1648-4eb1-bde5-e1c51f428816', 'Ticket', '/admin/ticket', 'fas fa-ticket-alt', '', '', '', '1', 't', '2021-10-19 02:01:55', '2021-10-19 07:01:05');
INSERT INTO "public"."system_menu" VALUES ('c3555d6e-8680-4842-8b46-19e7ac8d7b5d', 'Setting', '#', 'fas fa-cogs', '', '', '', '2', 't', '2021-10-19 01:53:29', '2021-10-19 07:01:05');
INSERT INTO "public"."system_menu" VALUES ('c5d4c227-d981-4b7b-be00-14e16c835f4c', 'Users', '/admin/users', NULL, 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', NULL, NULL, '2.1', 't', '2021-10-19 01:46:06', '2021-10-19 07:01:25');
INSERT INTO "public"."system_menu" VALUES ('7e6b6f83-e199-4963-88a2-31b271b6d09b', 'Member role', '/admin/system_role', NULL, 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', NULL, NULL, '2.2', 't', '2021-10-19 01:46:06', '2021-10-19 07:01:26');
INSERT INTO "public"."system_menu" VALUES ('31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'Member group', '/admin/system_member', NULL, 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', NULL, NULL, '2.3', 't', '2021-10-19 01:46:06', '2021-10-19 07:01:26');
INSERT INTO "public"."system_menu" VALUES ('ab99c793-5fa8-41e1-8f80-23baf51e903b', 'Group', '/admin/system_group', NULL, 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', NULL, NULL, '2.4', 't', '2021-10-19 01:46:06', '2021-10-19 07:01:26');

-- ----------------------------
-- Table structure for system_role
-- ----------------------------
DROP TABLE IF EXISTS "public"."system_role";
CREATE TABLE "public"."system_role" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id_menu" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id_group" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "active" bool NOT NULL DEFAULT true,
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone
)
;

-- ----------------------------
-- Records of system_role
-- ----------------------------
INSERT INTO "public"."system_role" VALUES ('8c5a6caf-d575-4c89-8d9c-3780c1df6079', 'af9b9870-1648-4eb1-bde5-e1c51f428816', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:30', '2021-10-19 02:02:30');
INSERT INTO "public"."system_role" VALUES ('8aec6289-a5a2-4805-8891-ef1ab9e09165', 'c3555d6e-8680-4842-8b46-19e7ac8d7b5d', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:30', '2021-10-19 02:02:30');
INSERT INTO "public"."system_role" VALUES ('60d2d5ea-5c07-4607-aa91-1062d5635882', '7e6b6f83-e199-4963-88a2-31b271b6d09b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:30', '2021-10-19 02:02:30');
INSERT INTO "public"."system_role" VALUES ('f6536c3c-8d96-4c99-b1d0-331f42e04d7d', '31f2ed26-e3fb-4f6e-9e56-eecf095f9813', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:31', '2021-10-19 02:02:31');
INSERT INTO "public"."system_role" VALUES ('ce1496d1-790c-42df-b4dd-59c3cb3dadd6', 'ab99c793-5fa8-41e1-8f80-23baf51e903b', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:31', '2021-10-19 02:02:31');
INSERT INTO "public"."system_role" VALUES ('6251420f-d3b9-4525-8e47-8aebb424d3c5', 'e0a64f34-f7d9-4430-8427-a856e74549b6', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:31', '2021-10-19 02:02:31');
INSERT INTO "public"."system_role" VALUES ('804f241d-85fa-4bb2-9f23-11eb9b12513a', 'c5d4c227-d981-4b7b-be00-14e16c835f4c', 'e7dff575-b4ec-4c1c-8126-a6333dcabe6f', 't', '2021-10-19 02:02:31', '2021-10-19 02:02:31');

-- ----------------------------
-- Table structure for ticket_sell
-- ----------------------------
DROP TABLE IF EXISTS "public"."ticket_sell";
CREATE TABLE "public"."ticket_sell" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "id_ticket" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "sold" int4,
  "created_at" date NOT NULL DEFAULT '2021-10-25'::date,
  "updated_at" date NOT NULL DEFAULT '2021-10-25'::date
)
;

-- ----------------------------
-- Records of ticket_sell
-- ----------------------------
INSERT INTO "public"."ticket_sell" VALUES ('861aa0f3-b4d2-4525-9dfe-8b311a355f1c', 'f7fa8ff6-d6c6-4392-b911-ab4fb13dd110', 2, '2021-10-26', '2021-10-26');

-- ----------------------------
-- Table structure for tickets
-- ----------------------------
DROP TABLE IF EXISTS "public"."tickets";
CREATE TABLE "public"."tickets" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "event_name" varchar(255) COLLATE "pg_catalog"."default",
  "cover_ticket" varchar(255) COLLATE "pg_catalog"."default",
  "event_desc" text COLLATE "pg_catalog"."default",
  "event_location" varchar(255) COLLATE "pg_catalog"."default",
  "event_date" date NOT NULL DEFAULT '2021-10-19'::date,
  "event_time_start" time(0) NOT NULL DEFAULT '04:36:11'::time without time zone,
  "event_time_end" time(0) NOT NULL DEFAULT '04:36:11'::time without time zone,
  "price" varchar(10) COLLATE "pg_catalog"."default",
  "stock" varchar(10) COLLATE "pg_catalog"."default",
  "discount" varchar(10) COLLATE "pg_catalog"."default",
  "state" varchar(255) COLLATE "pg_catalog"."default" NOT NULL DEFAULT 'draft'::character varying,
  "created_at" date NOT NULL DEFAULT '2021-10-19'::date,
  "updated_at" date NOT NULL DEFAULT '2021-10-19'::date,
  "terjual" int2
)
;

-- ----------------------------
-- Records of tickets
-- ----------------------------
INSERT INTO "public"."tickets" VALUES ('f7fa8ff6-d6c6-4392-b911-ab4fb13dd110', 'SUM 41', '/assets/uploads/event/57e957e2-d5ff-40b3-b915-b6ead58f356b/1635002016-cover-crop.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam id libero cursus, ornare tortor id, sagittis metus. Donec eu posuere tellus. Integer vulputate purus non dui varius accumsan. Suspendisse eleifend sem ac ipsum interdum, a accumsan sapien efficitur. Mauris tincidunt justo est, et suscipit justo mattis at. Aenean convallis ultrices nunc, non feugiat sem rhoncus at. Mauris tempor fermentum nulla. Pellentesque molestie, sem vel molestie lobortis, elit tortor lobortis felis, interdum suscipit tellus nunc vitae ligula. Mauris consectetur tempus eros', 'Bandung', '2021-11-03', '22:13:00', '03:15:00', '240000', '10000', '', 'posted', '2021-10-23', '2021-10-26', 2);
INSERT INTO "public"."tickets" VALUES ('8b9944a2-0c5e-48ff-961e-70b3eb51b2b6', 'Fall Out Boys', '/assets/uploads/event/c87ce413-1cd8-4869-a8f0-1dee227966c3/1635002963-cover-crop.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin sed lacus commodo, maximus risus quis, sollicitudin dui. Morbi blandit mi et elit bibendum, eu gravida tellus faucibus. In auctor dui quis vestibulum ornare. Pellentesque in pretium nisi, a blandit ante. Phasellus ultrices tristique molestie. Proin convallis, felis commodo posuere commodo, tortor tellus egestas velit, vel viverra neque risus in nibh. Duis laoreet magna nec nisl viverra, vitae tempor mauris tincidunt.

Praesent et ex et sapien efficitur placerat et a turpis. Pellentesque suscipit dolor sed felis molestie porttitor. Nullam elementum urna sit amet quam laoreet laoreet. Sed aliquam sit amet neque vel bibendum. Quisque vitae tortor lectus. Sed cursus urna quis arcu vulputate, eu pellentesque est accumsan. Nullam eleifend odio quam, sed fermentum nulla vehicula eget. Cras id pharetra lectus. Suspendisse non accumsan orci. Praesent facilisis est vitae tincidunt efficitur. Praesent ut nunc et nisl dictum porttitor. Ut vestibulum semper pulvinar. Interdum et malesuada fames ac ante ipsum primis in faucibus. Etiam scelerisque molestie tempus. Lorem ipsum dolor sit amet, consectetur adipiscing elit.', 'Bandung', '2021-11-06', '22:30:00', '02:30:00', '180000', '600', '', 'posted', '2021-10-23', '2021-10-24', NULL);
INSERT INTO "public"."tickets" VALUES ('3021d6e0-e994-49d4-b569-0057957fcd78', 'Konser Muse', '/assets/uploads/event/7d2293e5-a339-4c97-88d1-cb0d4edeb529/1634732498-cover-crop.jpg', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam id libero cursus, ornare tortor id, sagittis metus. Donec eu posuere tellus. Integer vulputate purus non dui varius accumsan. Suspendisse eleifend sem ac ipsum interdum, a accumsan sapien efficitur. Mauris tincidunt justo est, et suscipit justo mattis at. Aenean convallis ultrices nunc, non feugiat sem rhoncus at. Mauris tempor fermentum nulla. Pellentesque molestie, sem vel molestie lobortis, elit tortor lobortis felis, interdum suscipit tellus nunc vitae ligula. Mauris consectetur tempus eros', 'Bandung', '2021-11-01', '21:21:00', '22:21:00', '200000', '10000', '10', 'posted', '2021-10-20', '2021-10-20', NULL);

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS "public"."users";
CREATE TABLE "public"."users" (
  "id" varchar(255) COLLATE "pg_catalog"."default" NOT NULL,
  "first_name" varchar(30) COLLATE "pg_catalog"."default" NOT NULL,
  "last_name" varchar(100) COLLATE "pg_catalog"."default",
  "address" text COLLATE "pg_catalog"."default",
  "phone" varchar(15) COLLATE "pg_catalog"."default",
  "email" varchar(30) COLLATE "pg_catalog"."default" NOT NULL,
  "birthdate" date NOT NULL DEFAULT '2021-10-19'::date,
  "gender" bool NOT NULL DEFAULT true,
  "photo" varchar(255) COLLATE "pg_catalog"."default",
  "created_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "updated_at" timestamp(0) NOT NULL DEFAULT '2021-10-19 01:46:06'::timestamp without time zone,
  "deleted_at" timestamp(0)
)
;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO "public"."users" VALUES ('0', 'Super admin', NULL, NULL, NULL, 'admin@mail.com', '2021-10-19', 't', NULL, '2021-10-19 01:46:06', '2021-10-19 01:46:06', NULL);

-- ----------------------------
-- Function structure for create_default_auth
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."create_default_auth"();
CREATE OR REPLACE FUNCTION "public"."create_default_auth"()
  RETURNS "pg_catalog"."trigger" AS $BODY$
            BEGIN
            INSERT into auth (id, username, created_at, updated_at)
                VALUES (new.id, new.email, NOW(), NOW());
            return NEW;
            END
            $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for getgrouprole
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."getgrouprole"("_id_menu" varchar, "_id_group" varchar);
CREATE OR REPLACE FUNCTION "public"."getgrouprole"("_id_menu" varchar, "_id_group" varchar)
  RETURNS "pg_catalog"."int4" AS $BODY$
        declare
        counter integer;
        begin
        select count(*) 
        into counter
        from system_role
        where id_menu = _id_menu and id_group = _id_group limit 1;
        return counter;
        end;
        $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Function structure for getusermember
-- ----------------------------
DROP FUNCTION IF EXISTS "public"."getusermember"("_id_user" varchar, "_id_group" varchar);
CREATE OR REPLACE FUNCTION "public"."getusermember"("_id_user" varchar, "_id_group" varchar)
  RETURNS "pg_catalog"."int4" AS $BODY$
            declare
            counter integer;
            begin
            select count(*) 
            into counter
            from system_member
            where id_user = _id_user and id_group = _id_group;
            
            return counter;
            end;
            $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."failed_jobs_id_seq"
OWNED BY "public"."failed_jobs"."id";
SELECT setval('"public"."failed_jobs_id_seq"', 2, false);

-- ----------------------------
-- Alter sequences owned by
-- ----------------------------
ALTER SEQUENCE "public"."migrations_id_seq"
OWNED BY "public"."migrations"."id";
SELECT setval('"public"."migrations_id_seq"', 27, true);

-- ----------------------------
-- Primary Key structure for table auth
-- ----------------------------
ALTER TABLE "public"."auth" ADD CONSTRAINT "auth_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table auth
-- ----------------------------
ALTER TABLE "public"."auth" ADD CONSTRAINT "auth_id_foreign" FOREIGN KEY ("id") REFERENCES "public"."users" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Uniques structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid");

-- ----------------------------
-- Primary Key structure for table failed_jobs
-- ----------------------------
ALTER TABLE "public"."failed_jobs" ADD CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table migrations
-- ----------------------------
ALTER TABLE "public"."migrations" ADD CONSTRAINT "migrations_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Indexes structure for table password_resets
-- ----------------------------
CREATE INDEX "password_resets_email_index" ON "public"."password_resets" USING btree (
  "email" COLLATE "pg_catalog"."default" "pg_catalog"."text_ops" ASC NULLS LAST
);

-- ----------------------------
-- Primary Key structure for table system_group
-- ----------------------------
ALTER TABLE "public"."system_group" ADD CONSTRAINT "system_group_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table system_member
-- ----------------------------
ALTER TABLE "public"."system_member" ADD CONSTRAINT "system_member_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table system_member
-- ----------------------------
ALTER TABLE "public"."system_member" ADD CONSTRAINT "system_member_id_group_foreign" FOREIGN KEY ("id_group") REFERENCES "public"."system_group" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."system_member" ADD CONSTRAINT "system_member_id_user_foreign" FOREIGN KEY ("id_user") REFERENCES "public"."users" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Primary Key structure for table system_menu
-- ----------------------------
ALTER TABLE "public"."system_menu" ADD CONSTRAINT "system_menu_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Primary Key structure for table system_role
-- ----------------------------
ALTER TABLE "public"."system_role" ADD CONSTRAINT "system_role_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table system_role
-- ----------------------------
ALTER TABLE "public"."system_role" ADD CONSTRAINT "system_role_id_group_foreign" FOREIGN KEY ("id_group") REFERENCES "public"."system_group" ("id") ON DELETE CASCADE ON UPDATE CASCADE;
ALTER TABLE "public"."system_role" ADD CONSTRAINT "system_role_id_menu_foreign" FOREIGN KEY ("id_menu") REFERENCES "public"."system_menu" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Primary Key structure for table ticket_sell
-- ----------------------------
ALTER TABLE "public"."ticket_sell" ADD CONSTRAINT "ticket_sell_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Foreign Keys structure for table ticket_sell
-- ----------------------------
ALTER TABLE "public"."ticket_sell" ADD CONSTRAINT "ticket_sell_id_ticket_foreign" FOREIGN KEY ("id_ticket") REFERENCES "public"."tickets" ("id") ON DELETE CASCADE ON UPDATE CASCADE;

-- ----------------------------
-- Primary Key structure for table tickets
-- ----------------------------
ALTER TABLE "public"."tickets" ADD CONSTRAINT "tickets_pkey" PRIMARY KEY ("id");

-- ----------------------------
-- Triggers structure for table users
-- ----------------------------
CREATE TRIGGER "create_auth" AFTER INSERT ON "public"."users"
FOR EACH ROW
EXECUTE PROCEDURE "public"."create_default_auth"();

-- ----------------------------
-- Primary Key structure for table users
-- ----------------------------
ALTER TABLE "public"."users" ADD CONSTRAINT "users_pkey" PRIMARY KEY ("id");
