
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
      Penjagaan Gaji Berkala Tahun <?php echo $this->uri->segment(4,0);?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dollar"></i> Penjagaan KGB</a></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
        </div>
        <div class="box-body">
              <table id="penjagaan" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>NIP</th>
                  <th>Nama</th>
                  <th>Jab</th>
                  <th>OPD</th>
                  <th>Gol</th>
                  <th>TMT</th>
                  <th>#</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                    $no = 0; 
                    foreach($get_penj as $row):                       
                      $no++;
                      echo '<tr>';
                      echo '<td>'.$no.'</td>';
                      echo '<td>'.$row->nip.'</td>';
                      echo '<td>'.$row->nmglr.'</td>';
                      echo '<td>'.$row->jab_unor.'</td>';
                      echo '<td>'.$row->nm_skpd.'</td>';
                      echo '<td>'.$row->nm_gol.'</td>';
                      echo '<td>'.$row->tmt_kgb.'</td>';
                      echo '<td><a href="#"><i class="fa fa-file-pdf-o"></i></a></td>';
                      echo '</tr>';
                    endforeach; 
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
