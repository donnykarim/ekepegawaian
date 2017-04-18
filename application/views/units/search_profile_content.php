  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Profil PNS
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-search"></i> Search</a></li>
        <li class="active">Profil PNS</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-5">
          <?php 
            foreach($get_profile as $row):                       
          ?>
          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <?php echo '<img class="img-responsive img-thumbnail center-block" width="250" height="250"  src="'.base_url().'assets/uploads/photopns/'.$row->pic.'" alt="profile picture">' ;?>

              <h3 class="profile-username text-center"><?php echo $row->nmglr; ?></h3>

              <p class="text-muted text-center">
                <?php 
                if ($row->kd_jnsjab == 1){
                  echo $row->jab_unor.' ('.$row->nm_esel.') TMT. '.date("d-m-Y",strtotime($row->tmt_pltk));    
                }
                elseif ($row->kd_jnsjab == 2){
                  echo $row->nm_jabfung;
                }
                elseif ($row->kd_jnsjab == 3){
                  echo 'Staf';
                }
                elseif ($row->kd_jnsjab == 4){
                  echo 'Sekdes';
                }
                else {
                  echo "Error";
                }
                
                ;?>    
              </p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>NIP</b> <a class="pull-right"><?php echo $row->nip ;?></a>
                </li>
                <li class="list-group-item">
                  <b>Gol</b> <a class="pull-right"><?php echo $row->nm_gol ;?> (<?php echo date("d-m-Y",strtotime($row->tmtgol)) ;?>)</a>
                </li>
                <li class="list-group-item">
                  <b>Unit Kerja</b> <a class="pull-right"><?php echo $row->nm_skpd ;?></a>
                </li>
                <li class="list-group-item">
                  <b>Jabatan</b> <a class="pull-right"><?php echo $row->nm_jnsjab; ?></a>
                </li>
                <li class="list-group-item">
                  <b>Tingkat Pendidikan</b> <a class="pull-right"><?php echo $row->nm_tkpddk ;?></a>
                </li>
              </ul>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Pribadi</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-graduation-cap margin-r-5"></i> Pendidikan</strong>

              <p class="text-muted">
                <?php echo $row->nm_pddk ;?>, <?php echo $row->nm_sklh ;?>, <?php echo $row->thn_lls ;?>
              </p>

              <hr>

              <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat (kontak)</strong>

              <p class="text-muted"><?php echo $row->alamat ;?> (<?php echo $row->telp ;?>)</p>

              <hr>

              <strong><i class="fa fa-book margin-r-5"></i> Diklatpim</strong>

              <p class="text-muted">
                <?php 
                if ($row->kd_dikpim != 0 ){
                  echo $row->nm_dikpim.', '.$row->thn_dikpim;    
                }
                else {
                  echo '-';
                }
                ?>
              </p>

              <hr>

              <strong><i class="fa fa-calendar-o margin-r-5"></i> TTL</strong>

              <p class="text-muted"><?php echo $row->nm_kab ;?>, <?php echo date("d-m-Y",strtotime($row->tgllhr)) ;?></p>

              <hr>

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Lain-lain</strong>

              <p><?php echo $row->nm_sex ;?>, <?php echo $row->nm_agm ;?>, <?php echo $row->nm_statnkh ;?></p>
            </div>
            <!-- /.box-body -->
            <?php endforeach; ?>
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-7">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#rwyjab" data-toggle="tab">Jabatan</a></li>
              <li><a href="#rwypddk" data-toggle="tab">Pendidikan</a></li>
              <li><a href="#rwydiklat" data-toggle="tab">Diklat</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="rwyjab">
                <!-- Post -->
                <div class="post">
                <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Jab</th>
                  <th>Unor</th>
                  <th>Esel</th>
                  <th style="width: 40px">Tmt</th>
                </tr>
                <?php 
                  $no = 0;
                  foreach($get_rwyjab as $row):
                  $no++;                       
                ?>
                <tr>
                  <td><?php echo $no ;?></td>
                  <td><?php echo $row->jab ;?></td>
                  <td><?php echo $row->unor ;?></td>
                  <td><span class="badge bg-green"><?php echo $row->nm_esel ;?></span></td>
                  <td><?php echo $row->tmt_jab ;?></td>
                </tr>
                <?php endforeach; ?>
                </table>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="rwypddk">
                <!-- Post -->
                <div class="post">
                <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Tingkat</th>
                  <th>Jurusan</th>
                  <th>Lembaga</th>
                  <th style="width: 40px">Tahun</th>
                </tr>
                <?php 
                  $no = 0;
                  foreach($get_rwypddk as $row):
                  $no++;                       
                ?>
                <tr>
                  <td><?php echo $no ;?></td>
                  <td><span class="badge bg-blue"><?php echo $row->nm_tkpddk ;?></span></td>
                  <td><?php echo $row->jur ;?></td>
                  <td><?php echo $row->lembaga ;?></td>
                  <td><?php echo $row->thn_lls ;?></td>
                </tr>
                <?php endforeach; ?>
                </table>
                </div>
                <!-- /.post -->                
              </div>
              <!-- /.tab-pane -->

              <div class="tab-pane" id="rwydiklat">
                <!-- Post -->
                <div class="post">
                <table class="table table-striped">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Nama</th>
                  <th>Penyelenggara</th>
                  <th>Jam</th>
                  <th style="width: 40px">Tmt</th>
                </tr>
                <?php 
                  $no = 0;
                  foreach($get_rwydiklat as $row):
                  $no++;                       
                ?>
                <tr>
                  <td><?php echo $no ;?></td>
                  <td><?php echo $row->nm_diklat ;?></td>
                  <td><?php echo $row->penyel ;?></td>
                  <td><span class="badge bg-orange"><?php echo $row->jml_jam ;?></span></td>
                  <td><?php echo $row->tmt_diklat ;?></td>
                </tr>
                <?php endforeach; ?>
                </table>
                </div>
                <!-- /.post -->
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->