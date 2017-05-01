<?php
class Datainduk_model extends CI_Model  {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    function get_pns_baru()
    {
        $sql = "SELECT pns_id,nip,nama,nmglr,nm_skpd,nm_gol,tmt_kgb,kd_gol,kd_esel,kd_jnsjab,kd_unor,jab_unor
                FROM view_pns WHERE kd_stathkm = 14
                ORDER BY kd_unor";
        return $this->db->query($sql);
    }

}

?>