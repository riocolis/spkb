        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
            <a href="<?= base_url('user/kelas') ?>" class="btn btn-danger mb-3" >Kembali</a>
            <div class="row">
                <div class="col-lg-6">  
                    <table class="table table-hover" id="tampil_table_siswa">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Kode Kelas</th>
                                <th scope="col">Mapel</th>
                                <th scope="col">Kelas</th>
                                <th scope="col">Guru</th>

                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <?php
                        $i = 1;
                        foreach ($kelas as $ks) { ?>
                            <tbody>
                                <tr>
                                    <th scope="row" value=<?= $i;?>><?= $i; ?></th>
                                    <td><?= $ks['kode_kelas']; ?></td>
                                    <td><?= $ks['nama_mapel']; ?></td>
                                    <td><?= $ks['nama_kelas']; ?></td>
                                    <td><?= $ks['nama_guru']; ?></td>
                                    <td>
                                        <a href="" data-toggle="modal" data-target="#editSiswaModal<?=$i;?>">Gabung</a>
                                    </td>
                                </tr>
                            </tbody>
                            <?php $i++;
                        } ?>
                    </table>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->
<?php
$i =1 ;
?>
<!-- Modal -->
<?php foreach($siswa as $sw) {?>
<div class="modal fade" id="editSiswaModal<?=$i;?>" tabindex="-1" role="dialog" aria-labelledby="editSiswaModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSiswaModal">Tambah Kelas Menu</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('user/kelasmasuk')?>" method="post">
        <div class="modal-body">
        <div class="form-group">
            <input type="hidden" class="form-control" name="kode1" value="<?= $simple;?>">
         </div>
         <div class="form-group">
            <input type="hidden" class="form-control" name="tugas1" value="<?= $tugas;?>">
         </div>
         <label>Siswa</label>
         <div class="form-group">
            <input type="text" class="form-control" name="siswa" value="<?= $sw['nama_siswa'];?>" readonly="readonly">
         </div>
         <label>Nilai</label> 
         <div class="form-group">
            <input type="text" class="form-control" name="nilai" value="<?= $sw['nilai'];?>">
         </div>       
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary" >Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php 
$i++;
}?>