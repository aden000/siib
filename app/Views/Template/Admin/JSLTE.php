<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj" crossorigin="anonymous"></script> -->
<!-- <script src="/assets/sbadmin/js/scripts.js"></script> -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.3.5/dist/sweetalert2.all.min.js"></script>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.0/r-2.2.9/datatables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>/assets/alte3/js/adminlte.min.js"></script>
<script>
    $(document).ready(function() {
        $('#userlist').DataTable();
        $('#katbarlist').DataTable();
        $('#unitkerjalist').DataTable();
        $('#semesterlist').DataTable();
        $('#baranglist').DataTable();
        $('#vendorlist').DataTable();
        $('#satuanlist').DataTable();
        $('#barangmasuklist').DataTable();
        $('#barangkeluarlist').DataTable();
        $('#detailbaranglist').DataTable();
        $('#loglist').DataTable();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>