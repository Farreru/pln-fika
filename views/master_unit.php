<div class="p-1">
    <h2>Unit</h2>

    <div class="mt-2">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    Form Unit
                </div>
            </div>
            <div class="card-body">
                <form method="POST" action="http://localhost/pln/function.php?action=insertUnit">
                    <div class="form-group">
                        <label>Nama Unit</label>
                        <input type="text" name="nama" placeholder="masukkan nama unit" class="form-control" id="" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" placeholder="pilih tanggal unit" name="tanggal" class="form-control" id="" required>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary float-right" value="Simpan" name="add_unit">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    Data Unit
                </div>
            </div>
            <div class="card-body">
                <table id="data-unit" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama Unit</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_unit = file_get_contents('http://localhost/pln/function.php?action=getUnitList');
                        $data_unit = json_decode($data_unit, true);

                        if (!empty($data_unit)) {
                            $no = 1;
                            foreach ($data_unit as $data) {
                        ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $data['nama'] ?></td>
                                    <td><?= $data['tanggal'] ?></td>
                                    <td>
                                        <a href="/pln/?unit=<?= $data['nama'] ?>" class="btn btn-sm btn-primary">Lihat Data</a>
                                        <a href="http://localhost/pln/function.php?action=hapusUnit&id=<?= $data['id'] ?>" class="btn btn-sm btn-danger">Hapus Unit</a>
                                    </td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo "<tr><td colspan='4'>No data found.</td></tr>";
                        }
                        ?>

                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <th>No.</th>
                            <th>Nama Unit</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot> -->
                </table>
            </div>
        </div>
    </div>


</div>


<script>
    $(function() {
        $('#data-unit').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    });
</script>