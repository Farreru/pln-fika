<div class="p-1">
    <h2>Equipment</h2>

    <div class="mt-2">
        <div class="card card-primary">
            <div class="card-header">
                <div class="card-title">
                    Form Equipment
                </div>
            </div>
            <div class="card-body">
                <form action="">
                    <div class="form-group">
                        <label>Nama Equipment</label>
                        <input type="text" name="unit_name" placeholder="masukkan nama unit" class="form-control" id="" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" placeholder="pilih tanggal unit" name="unit_date" class="form-control" id="" required>
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
                    Data Equipment
                </div>
            </div>
            <div class="card-body">
                <table id="data-equipment" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 4.0
                            </td>
                            <td>Win 95+</td>
                            <td> 4</td>
                            <td>X</td>
                        </tr>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 5.0
                            </td>
                            <td>Win 95+</td>
                            <td>5</td>
                            <td>C</td>
                        </tr>
                        <tr>
                            <td>Trident</td>
                            <td>Internet
                                Explorer 5.5
                            </td>
                            <td>Win 95+</td>
                            <td>5.5</td>
                            <td>A</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Rendering engine</th>
                            <th>Browser</th>
                            <th>Platform(s)</th>
                            <th>Engine version</th>
                            <th>CSS grade</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>


</div>


<script>
    $(function() {
        $('#data-equipment').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#data-equipment_wrapper .col-md-6:eq(0)');
    });
</script>