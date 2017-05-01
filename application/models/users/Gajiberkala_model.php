<?php
class Gajiberkala_model extends CI_Model  {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_penjagaan_kgb($th,$user_kd_unor)
    {
        $sql = "SELECT pns_id,nip,nmglr,nm_skpd,nm_gol,tmt_kgb,kd_gol,kd_esel,kd_jnsjab,kd_unor,jab_unor
                FROM view_pns WHERE YEAR(tmt_kgb)=($th-2)
                AND (
                (kd_unor LIKE '$user_kd_unor') AND
                (kd_usul_kgb = 0)
                )
                ORDER BY tmt_kgb,kd_unor";
        return $this->db->query($sql);
    }
    function get_penjagaan_usul($th,$user_kd_unor)
    {
        $sql = "SELECT pns_id,nip,nmglr as nama,nm_skpd as skpd,nm_gol,tmt_kgb as tmtkgbbr,kd_gol,kd_esel,kd_jnsjab,kd_usul_kgb
                FROM profil WHERE (YEAR(tmt_kgb)=($th-2) OR YEAR(tmt_kgb)=($th-1))
                AND (
                (kd_unor LIKE '$user_kd_unor') AND
                (kd_usul_kgb = 1 OR kd_usul_kgb = 2 OR kd_usul_kgb = 3 OR kd_usul_kgb = 4)
                )
                ORDER BY tmt_kgb,kd_unor";
        return $this->db->query($sql);
    }
    function get_report($user_kd_unor)
    {
        $sql = "SELECT a.kgb_id,a.nama,a.nip,a.tmtkgbbr,a.skpd,concat(a.nama,'-',a.nip) as NAMA_NIP,a.golbr as GOL,a.mkthnbr as MASA_KERJA_TAHUN,a.mkblnbr as MASA_KERJA_BULAN,b.gaji as GAJI 
                FROM kgb a LEFT JOIN refgaji b ON a.kdkgbbr=b.kd_gaji WHERE a.kd_unor LIKE '$user_kd_unor'
                ORDER BY tmtkgbbr,kd_unor";
        return $this->db->query($sql);
    }
    function get_export($user_kd_unor)
    {
        $sql = "SELECT a.skpd AS SKPD,a.nama AS NAMA,concat('`',a.nip) AS NIP,a.golbr AS GOL,a.mkthnbr AS MASA_KERJA_TAHUN,a.mkblnbr AS MASA_KERJA_BULAN,b.gaji AS GAJI,a.tmtkgbbr AS TMT_KGB 
                FROM kgb a LEFT JOIN refgaji b ON a.kdkgbbr=b.kd_gaji WHERE a.kd_unor LIKE '$user_kd_unor'
                ORDER BY tmtkgbbr,kd_unor";
        return $this->db->query($sql);
    }
    function get_update($kgb_id)
    {
        $sql = "UPDATE pns a, kgb b SET a.tmt_kgb=b.tmtkgblm WHERE a.pns_id=b.pns_id AND b.kgb_id = '$kgb_id'";
        return $this->db->query($sql);
    }
    function get_delete($kgb_id)
    {
        $sql = "DELETE FROM kgb where kgb_id = '$kgb_id'";
        return $this->db->query($sql);
    }
    function get_usul($pns_id)
    {
        $sql = "UPDATE pns SET kd_usul_kgb = 1 WHERE pns_id = '$pns_id'";
        return $this->db->query($sql);
    }
    function get_usul_kec_kel($pns_id)
    {
        $sql = "UPDATE pns SET kd_usul_kgb = 2 WHERE pns_id = '$pns_id'";
        return $this->db->query($sql);
    }
    function get_usul_sekda($pns_id)
    {
        $sql = "UPDATE pns SET kd_usul_kgb = 3 WHERE pns_id = '$pns_id'";
        return $this->db->query($sql);
    }
    function get_usul_dikpora($pns_id)
    {
        $sql = "UPDATE pns SET kd_usul_kgb = 4 WHERE pns_id = '$pns_id'";
        return $this->db->query($sql);
    }

}

?>