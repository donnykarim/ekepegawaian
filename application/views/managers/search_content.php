
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Pencarian Pintar <small>kini pencarian kami lebih mengerti Anda</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-search"></i> Pencarian</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
            <input class="form-control input-lg" placeholder="apa yang ingin dicari...." type="text" id="InputCari">

              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>ID</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>OPD</th>
                  <th>Gol</th>
                </tr>
                </thead>
                <tbody>
                <?php 
/*                    $no = 0; 
                    foreach($get_cari as $row):                       
                      $no++;
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$row->nip.'</td>';
                      echo '<td><a href="'.site_url("managers/search/profile/$row->pns_id").'">'.$row->nmglr.'</a></td>';
                      echo '<td>'.$row->nm_skpd_p.'</td>';
                      echo '<td>'.$row->nm_gol.'</td>';
                      echo '</tr>';
                    endforeach;*/ 
                ?>  
                </tbody>
              </table>

         </div>
        <!-- /.box-body -->
        <div class="box-footer">
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
