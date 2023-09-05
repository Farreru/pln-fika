<div class="p-1">
    <h2>System</h2>

    <div class="mt-3">

        <div class="form-group col-sm-2">
            <label for="">Pilih Unit</label>
            <select onchange="console.log(this.value)" name="" class="form-control" id="">
                <option selected disabled value="">Pilih Unit</option>
                <?php
                $data_unit = file_get_contents('http://localhost/pln/function.php?action=getUnitList');
                $data_unit = json_decode($data_unit, true);

                if (!empty($data_unit)) {
                    $no = 1;
                    foreach ($data_unit as $data) {
                ?>
                        <option value="<?= $data['nama'] ?>"><?= $data['nama'] ?></option>
                <?php
                    }
                } else {
                    echo "<option>No Unit Found</option>";
                }
                ?>
            </select>
        </div>

        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    Form System
                </div>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label>Nama System</label>
                        <input type="text" name="nama" placeholder="masukkan nama system" class="form-control" id="" required>
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
                    Data System
                </div>
            </div>
            <div class="card-body">
                <table id="data-system" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Unit.</th>
                            <th>Nama System</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>

                </table>
            </div>
        </div>
    </div>


</div>


<script>
    $(function() {
        $('#data-system').DataTable({
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