/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     2/22/2022 5:27:13 AM                         */
/*==============================================================*/


drop table if exists BARANG;

drop table if exists BARANG_KELUAR;

drop table if exists BARANG_MASUK;

drop table if exists DETAIL_BARANG;

drop table if exists DETAIL_BARANG_KELUAR;

drop table if exists DETAIL_BARANG_MASUK;

drop table if exists KATEGORI_BARANG;

drop table if exists LOG_AKTIFITAS;

drop table if exists SATUAN;

drop table if exists SEMESTER;

drop table if exists UNIT_KERJA;

drop table if exists USERS;

drop table if exists VENDOR;

/*==============================================================*/
/* Table: BARANG                                                */
/*==============================================================*/
create table BARANG
(
   ID_BARANG            int not null,
   ID_KATEGORI_BARANG   int,
   NAMA_BARANG          varchar(50),
   primary key (ID_BARANG)
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
   primary key (ID_BARANG_KELUAR)
);

/*==============================================================*/
/* Table: BARANG_MASUK                                          */
/*==============================================================*/
create table BARANG_MASUK
(
   ID_BARANG_MASUK      int not null,
   ID_USER              int,
   ID_SEMESTER          int,
   ID_VENDOR            int,
   TANGGAL_MASUK        datetime,
   KUANTITAS            int,
   primary key (ID_BARANG_MASUK)
);

/*==============================================================*/
/* Table: DETAIL_BARANG                                         */
/*==============================================================*/
create table DETAIL_BARANG
(
   ID_DETAIL_BARANG     int not null,
   ID_SATUAN            int not null,
   ID_BARANG            int not null,
   KUANTITAS            int,
   TURUNAN_ID_SATUAN    int,
   KONVERSI_TURUNAN     int,
   primary key (ID_DETAIL_BARANG)
);

/*==============================================================*/
/* Table: DETAIL_BARANG_KELUAR                                  */
/*==============================================================*/
create table DETAIL_BARANG_KELUAR
(
   ID_DETAIL_BARANG_KELUAR int not null,
   ID_BARANG_KELUAR     int not null,
   ID_BARANG            int not null,
   ID_SATUAN            int,
   KUANTITAS            int,
   primary key (ID_DETAIL_BARANG_KELUAR)
);

/*==============================================================*/
/* Table: DETAIL_BARANG_MASUK                                   */
/*==============================================================*/
create table DETAIL_BARANG_MASUK
(
   ID_DETAIL_BARANG_MASUK int not null,
   ID_BARANG            int not null,
   ID_BARANG_MASUK      int not null,
   ID_SATUAN            int,
   KUANTITAS            int,
   primary key (ID_DETAIL_BARANG_MASUK)
);

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
/* Table: LOG_AKTIFITAS                                         */
/*==============================================================*/
create table LOG_AKTIFITAS
(
   ID_LOG_AKTIFITAS     int not null,
   ID_USER              int,
   KETERANGAN_AKTIFITAS text,
   primary key (ID_LOG_AKTIFITAS)
);

/*==============================================================*/
/* Table: SATUAN                                                */
/*==============================================================*/
create table SATUAN
(
   ID_SATUAN            int not null,
   NAMA_SATUAN          varchar(50),
   SINGKATAN            varchar(5),
   primary key (ID_SATUAN)
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
/* Table: VENDOR                                                */
/*==============================================================*/
create table VENDOR
(
   ID_VENDOR            int not null,
   NAMA_VENDOR          varchar(50),
   primary key (ID_VENDOR)
);

alter table BARANG add constraint FK_RELATIONSHIP_1 foreign key (ID_KATEGORI_BARANG)
      references KATEGORI_BARANG (ID_KATEGORI_BARANG) on delete restrict on update restrict;

alter table BARANG_KELUAR add constraint FK_RELATIONSHIP_4 foreign key (ID_UNIT_KERJA)
      references UNIT_KERJA (ID_UNIT_KERJA) on delete restrict on update restrict;

alter table BARANG_KELUAR add constraint FK_RELATIONSHIP_6 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table BARANG_MASUK add constraint FK_RELATIONSHIP_12 foreign key (ID_VENDOR)
      references VENDOR (ID_VENDOR) on delete restrict on update restrict;

alter table BARANG_MASUK add constraint FK_RELATIONSHIP_5 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

alter table BARANG_MASUK add constraint FK_RELATIONSHIP_8 foreign key (ID_SEMESTER)
      references SEMESTER (ID_SEMESTER) on delete restrict on update restrict;

alter table DETAIL_BARANG add constraint FK_RELATIONSHIP_18 foreign key (ID_BARANG)
      references BARANG (ID_BARANG) on delete restrict on update restrict;

alter table DETAIL_BARANG add constraint FK_RELATIONSHIP_19 foreign key (ID_SATUAN)
      references SATUAN (ID_SATUAN) on delete restrict on update restrict;

alter table DETAIL_BARANG_KELUAR add constraint FK_RELATIONSHIP_10 foreign key (ID_BARANG)
      references BARANG (ID_BARANG) on delete restrict on update restrict;

alter table DETAIL_BARANG_KELUAR add constraint FK_RELATIONSHIP_11 foreign key (ID_BARANG_KELUAR)
      references BARANG_KELUAR (ID_BARANG_KELUAR) on delete restrict on update restrict;

alter table DETAIL_BARANG_KELUAR add constraint FK_RELATIONSHIP_16 foreign key (ID_SATUAN)
      references SATUAN (ID_SATUAN) on delete restrict on update restrict;

alter table DETAIL_BARANG_MASUK add constraint FK_RELATIONSHIP_13 foreign key (ID_SATUAN)
      references SATUAN (ID_SATUAN) on delete restrict on update restrict;

alter table DETAIL_BARANG_MASUK add constraint FK_RELATIONSHIP_14 foreign key (ID_BARANG_MASUK)
      references BARANG_MASUK (ID_BARANG_MASUK) on delete restrict on update restrict;

alter table DETAIL_BARANG_MASUK add constraint FK_RELATIONSHIP_15 foreign key (ID_BARANG)
      references BARANG (ID_BARANG) on delete restrict on update restrict;

alter table LOG_AKTIFITAS add constraint FK_RELATIONSHIP_2 foreign key (ID_USER)
      references USERS (ID_USER) on delete restrict on update restrict;

