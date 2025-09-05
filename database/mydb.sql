CREATE TABLE public.ap_luc_tac_dong (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    loai_ap_luc_id integer NOT NULL,
    tieu_khu character varying(50),
    khoanh character varying(50),
    phan_khu_chuc_nang character varying(100),
    dien_tich_anh_huong numeric(10,2),
    thoi_gian_xay_ra character varying(100)
);


CREATE TABLE public.bac_bo (
    id integer NOT NULL,
    bac_lop_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120)
);

CREATE TABLE public.spatial_ref_sys
(
    srid integer NOT NULL,
    auth_name character varying(256),
    auth_srid integer,
    srtext character varying(2048),
    proj4text character varying(2048),
    CONSTRAINT spatial_ref_sys_pkey PRIMARY KEY (srid),
    CONSTRAINT spatial_ref_sys_srid_check CHECK (srid > 0 AND srid <= 998999)
)


CREATE TABLE public.bac_chi (
    id integer NOT NULL,
    bac_ho_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120)
);


CREATE TABLE public.bac_ho (
    id integer NOT NULL,
    bac_bo_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120)
);


CREATE TABLE public.bac_lop (
    id integer NOT NULL,
    bac_nganh_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120)
);


CREATE TABLE public.bac_nganh (
    id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120),
    phan_loai character varying(10) DEFAULT 'plant'::character varying,
    CONSTRAINT bac_nganh_phan_loai_check CHECK (((phan_loai)::text = ANY (ARRAY[('plant'::character varying)::text, ('animal'::character varying)::text])))
);



CREATE TABLE public.cau_truc_rung (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);


CREATE TABLE public.dac_trung_kieu_he_sinh_thai (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);


CREATE TABLE public.dien_tich_kieu_he_sinh_thai (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    kieu_he_sinh_thai_id integer NOT NULL,
    dien_tich numeric(10,2)
);

CREATE TABLE public.dien_tich_rung_dat_lam_nghiep (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    bvnn_rung_tu_nhien numeric(10,2),
    bvnn_rung_trong numeric(10,2),
    bvnn_chua_co_rung numeric(10,2),
    phst_rung_tu_nhien numeric(10,2),
    phst_rung_trong numeric(10,2),
    phst_chua_co_rung numeric(10,2),
    dvhc_rung_tu_nhien numeric(10,2),
    dvhc_rung_trong numeric(10,2),
    dvhc_chua_co_rung numeric(10,2)
);


CREATE TABLE public.dong_vat (
    id integer NOT NULL,
    bac_chi_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120),
    ten_tac_gia character varying(120),
    hinh_thai text,
    sinh_thai text,
    dac_huu text,
    gia_tri text,
    sach_do text,
    iucn text,
    nd_84 text,
    nguon text
);


CREATE TABLE public.dong_vat_anh (
    id integer NOT NULL,
    dong_vat_id integer NOT NULL,
    duong_dan text NOT NULL,
    duong_dan_thumb text NOT NULL
);

CREATE TABLE public.kieu_he_sinh_thai (
    id integer NOT NULL,
    ten_kieu character varying(500) NOT NULL
);


CREATE TABLE public.loai_ap_luc (
    id integer NOT NULL,
    ten_ap_luc character varying(255) NOT NULL
);


CREATE TABLE public.loai_dong_vat_nguy_cap (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    dong_vat_id integer NOT NULL
);







CREATE TABLE public.loai_moi_phat_hien (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    so_luong_loai_moi integer
);

CREATE TABLE public.loai_thuc_vat_nguy_cap (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thuc_vat_id integer NOT NULL
);
CREATE TABLE public.loai_vuon_quoc_gia (
    id integer NOT NULL,
    ten_loai character(50)
);

CREATE TABLE public.muc_do_nghiem_trong_ap_luc (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);


CREATE TABLE public.nam_du_lieu (
    id integer NOT NULL,
    nam integer NOT NULL,
    trang_thai character varying(20) DEFAULT 'in_progress'::character varying,
    CONSTRAINT nam_du_lieu_trang_thai_check CHECK (((trang_thai)::text = ANY (ARRAY[('in_progress'::character varying)::text, ('completed'::character varying)::text])))
);

CREATE TABLE public.pham_vi_anh_huong_ap_luc (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);

CREATE TABLE public.phan_bo_loai_dong_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    dong_vat_id integer NOT NULL,
    tieu_khu character varying(50),
    khoanh character varying(50),
    phan_khu_chuc_nang character varying(100)
);

CREATE TABLE public.phan_bo_loai_thuc_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thuc_vat_id integer NOT NULL,
    tieu_khu character varying(50),
    khoanh character varying(50),
    phan_khu_chuc_nang character varying(100)
);


CREATE TABLE public.ran_san_ho_co_bien (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    dien_tich_ran_san_ho numeric(10,2),
    dien_tich_co_bien numeric(10,2)
);

CREATE TABLE public.so_luong_quan_the_dong_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    dong_vat_id integer NOT NULL,
    so_quan_the integer,
    so_ca_the integer
);

CREATE TABLE public.so_luong_quan_the_thuc_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thuc_vat_id integer NOT NULL,
    so_quan_the integer,
    so_ca_the integer
);


CREATE TABLE public.tai_sinh_rung (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);


CREATE TABLE public.tan_suat_bat_gap_dong_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    dong_vat_id integer NOT NULL,
    kha_nang_bat_gap integer
);

CREATE TABLE public.tang_truong_rung (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    thong_tin_mo_ta text,
    tep_dinh_kem character varying(255)
);

CREATE TABLE public.thanh_phan_loai_dong_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    so_nganh integer,
    so_lop integer,
    so_bo integer,
    so_ho integer,
    so_giong integer,
    so_loai integer
);

CREATE TABLE public.thanh_phan_loai_thuc_vat (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    so_nganh integer,
    so_lop integer,
    so_bo integer,
    so_ho integer,
    so_chi integer,
    so_loai integer
);

CREATE TABLE public.thuc_vat (
    id integer NOT NULL,
    bac_chi_id integer NOT NULL,
    ten_khoa_hoc character varying(120) NOT NULL,
    ten_tieng_viet character varying(120),
    ten_tac_gia character varying(120),
    than_canh text,
    la text,
    phan_bo_viet_nam text,
    phan_bo_the_gioi text,
    hoa_qua text,
    sinh_thai text,
    dac_huu text,
    gia_tri text,
    sach_do text,
    iucn text,
    nd_84 text,
    nguon text
);

CREATE TABLE public.thuc_vat_anh (
    id integer NOT NULL,
    thuc_vat_id integer NOT NULL,
    duong_dan text NOT NULL,
    duong_dan_thumb text NOT NULL
);

CREATE TABLE public.tru_luong_sinh_khoi_carbon (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    nam_du_lieu_id integer NOT NULL,
    kieu_he_sinh_thai_id integer NOT NULL,
    tru_luong numeric(10,2),
    sinh_khoi numeric(15,2),
    tru_luong_carbon numeric(15,2)
);

CREATE TABLE public.users (
    id integer NOT NULL,
    vuon_quoc_gia_id integer NOT NULL,
    name text NOT NULL,
    email text NOT NULL,
    password text NOT NULL,
    path text,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone
);

CREATE TABLE public.vuon_quoc_gia (
    id integer NOT NULL,
    ten_vuon character varying(255) NOT NULL,
    dia_chi text,
    ngay_thanh_lap date,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    loai_vuon_quoc_gia_id integer
);
