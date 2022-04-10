/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     1/17/2022 12:55:21 PM                        */
/*==============================================================*/


drop table if exists BARANG;

drop table if exists BARANG_KELUAR;

drop table if exists BARANG_MASUK;

drop table if exists DETAIL_BARANG_KELUAR;

drop table if exists KATEGORI_BARANG;

drop table if exists LOG_AKTIFITAS;

drop table if exists SEMESTER;

drop table if exists UNIT_KERJA;

drop table if exists USERS;

/*==============================================================*/
/* Table: KATEGORI_BARANG                                       */
/*==============================================================*/
create table KATEGORI_BARANG
(
   ID_KATEGORI_BARANG   int not null,
   NAMA_KATEGORI_BARANG varchar(50),
   primary key (ID_KATEGORI_BARANG)
);

/*==============================================================*/
/* Table: BARANG                                                */
/*==============================================================*/
create table BARANG
(
   ID_BARANG            int not null,
   ID_KATEGORI_BARANG   int,
   NAMA_BARANG          varchar(50),
   KUANTITAS            int,
   SATUAN               varchar(50),
   primary key (ID_BARANG),
   constraint FK_RELATIONSHIP_1 foreign key (ID_KATEGORI_BARANG)
      references KATEGORI_BARANG (ID_KATEGORI_BARANG) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: UNIT_KERJA                                            */
/*==============================================================*/
create table UNIT_KERJA
(
   ID_UNIT_KERJA        int not null,
   NAMA_UNIT_KERJA      varchar(50),
   primary key (ID_UNIT_KERJA)
);

/*==============================================================*/
/* Table: USERS                                                 */
/*==============================================================*/
create table USERS
(
   ID_USER              int not null,
   NAMA_USER            varchar(50),
   USERNAME             varchar(50),
   PASSWORD             varchar(50),
   ROLE                 int,
   primary key (ID_USER)
);

/*==============================================================*/
/* Table: BARANG_KELUAR                                         */
/*==============================================================*/
create table BARANG_KELUAR
(
   ID_BARANG_KELUAR     int not null,
   ID_UNIT_KERJA        int,
   ID_USER              int,
   TANGGAL_KELUAR       datetime,
   STATUS               varchar(50),
   primary key (ID_BARANG_KELUAR),
   constraint FK_RELATIONSHIP_4 foreign key (ID_UNIT_KERJA)
      references UNIT_KERJA (ID_UNIT_KERJA) on delete restrict on update restrict,
   constraint FK_RELATIONSHIP_6 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: SEMESTER                                              */
/*==============================================================*/
create table SEMESTER
(
   ID_SEMESTER          int not null,
   SEMESTER_KE          int,
   TAHUN                varchar(4),
   primary key (ID_SEMESTER)
);

/*==============================================================*/
/* Table: BARANG_MASUK                                          */
/*==============================================================*/
create table BARANG_MASUK
(
   ID_BARANG_MASUK      int not null,
   ID_USER              int,
   ID_BARANG            int,
   ID_SEMESTER          int,
   TANGGAL_MASUK        datetime,
   KUANTITAS            int,
   primary key (ID_BARANG_MASUK),
   constraint FK_RELATIONSHIP_5 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict,
   constraint FK_RELATIONSHIP_7 foreign key (ID_BARANG)
      references BARANG (ID_BARANG) on delete restrict on update restrict,
   constraint FK_RELATIONSHIP_8 foreign key (ID_SEMESTER)
      references SEMESTER (ID_SEMESTER) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: DETAIL_BARANG_KELUAR                                  */
/*==============================================================*/
create table DETAIL_BARANG_KELUAR
(
   ID_BARANG_KELUAR     int not null,
   ID_BARANG            int not null,
   KUANTITAS            int,
   primary key (ID_BARANG_KELUAR, ID_BARANG),
   constraint FK_RELATIONSHIP_10 foreign key (ID_BARANG)
      references BARANG (ID_BARANG) on delete restrict on update restrict,
   constraint FK_RELATIONSHIP_11 foreign key (ID_BARANG_KELUAR)
      references BARANG_KELUAR (ID_BARANG_KELUAR) on delete restrict on update restrict
);

/*==============================================================*/
/* Table: LOG_AKTIFITAS                                         */
/*==============================================================*/
create table LOG_AKTIFITAS
(
   ID_LOG_AKTIFITAS     int not null,
   ID_USER              int,
   KETERANGAN_AKTIFITAS text,
   primary key (ID_LOG_AKTIFITAS),
   constraint FK_RELATIONSHIP_2 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict
);

