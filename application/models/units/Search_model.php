<?php
class Search_model extends CI_Model  {
    var $table = 'view_pns';
    var $column_order = array(null, 'pns_id','nip','nmglr','nm_skpd_p','nm_gol'); //set column field database for datatable orderable
    var $column_search = array('nip','nmglr','nm_skpd_p','nm_gol'); //set column field database for datatable searchable 
    var $order = array(''); // default order 

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    function cari()
    {
        $sql = "SELECT * FROM view_pns";
        return $this->db->query($sql);
    }
    function profile($pns_id)
    {
        $sql = "SELECT * FROM view_pns WHERE pns_id  =  $pns_id" ;
        return $this->db->query($sql);
    }
    function riwayat($pns_id,$tableriwayat,$joinriwayat,$orderriwayat)
    {
        $sql = "SELECT * FROM $tableriwayat $joinriwayat WHERE $tableriwayat.pns_id  =  $pns_id $orderriwayat" ;
        return $this->db->query($sql);
    }
    private function _get_datatables_query()
    {
        
        $this->db->from($this->table);

        $i = 0;
    
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                
                if($i===0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                }
                else
                {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
        $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }


}

?>