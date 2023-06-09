@extends('layout')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <a href="javascript:void(0)" class="btn btn-sm btn-outline-danger" id="createOrUpdate">Tambah Siswa</a>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>Rombel</th>
                                <th>Rayon</th>
                                <th width="200px">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                        </tbody>

                    </table>
                    @include('modal')
                </div>
            </div>
        </div>
    </div>
@endsection

@push('ajax_crud')
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

    <script>

        $(document).ready(function() {

            getData()

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            //ambil data
            function getData() {

                $.ajax({
                    url: window.location.origin + '/student/data',
                    type: 'GET',
                    data: {}
                }).done(function(data) {
                    table_data_row(data)
                });
            }

            //nampilin data tbody
            function table_data_row(data) {

                var rows = '';

                $.each(data, function(key, value) {

                    rows = rows + '<tr>';
                    rows = rows + '<td>' + value.nis + '</td>';
                    rows = rows + '<td>' + value.nama + '</td>';
                    rows = rows + '<td>' + value.rombel + '</td>';
                    rows = rows + '<td>' + value.rayon + '</td>';
                    rows = rows + '<td data-id="' + value.id + '">';
                    rows = rows +
                        '<a class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" id="editStudent" data-id="' +
                        value.id + '" data-toggle="modal" data-target="#modal-id">Edit</a> ';
                    rows = rows +
                        '<a class="btn btn-sm btn-outline-danger py-0" style="font-size: 0.8em;" id="deleteStudent" data-id="' +
                        value.id + '" >Delete</a> ';
                    rows = rows + '</td>';
                    rows = rows + '</tr>';
                });

                $("tbody").html(rows);
            }

            //tambah atau ubah data
            $("body").on("click", "#createOrUpdate", function(e) {

                e.preventDefault;
                $('#titleModal').html("Tambah Siswa");
                $('#submit').val("Simpan");
                $('#modal-id').modal('show');
                $('#student_id').val('');
                $('#studentForm').trigger("reset");

            });

            //Save data into database
            $('body').on('click', '#submit', function(event) {
                event.preventDefault()
                var id = $("#student_id").val();
                var nis = $("#nis").val();
                var nama = $("#nama").val();
                var rombel = $("#rombel").val();
                var rayon = $("#rayon").val();

                $.ajax({
                    url: window.location.origin + '/student/send',
                    type: "POST",
                    data: {
                        id: id,
                        nis: nis,
                        nama: nama,
                        rombel: rombel,
                        rayon: rayon
                    },
                    dataType: 'json',
                    success: function(data) {

                        $('#studentForm').trigger("reset");
                        $('#modal-id').modal('hide');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        getData();
                    },
                    error: function(data) {
                        console.log('Error......');
                    }
                });
            });

            //Edit modal
            $('body').on('click', '#editStudent', function(event) {

                event.preventDefault();
                var id = $(this).data('id');

                $.get(window.location.origin + '/student/' + id, function(data) {

                    $('#titleModal').html("Edit company");
                    $('#submit').val("Edit company");
                    $('#modal-id').modal('show');
                    $('#student_id').val(data.data.id);
                    $('#nis').val(data.data.nis);
                    $('#nama').val(data.data.nama);
                    $('#rombel').val(data.data.rombel);
                    $('#rayon').val(data.data.rayon);
                })
            });

            //delete
            $('body').on('click', '#deleteStudent', function(event) {
                if (!confirm("Do you really want to do this?")) {
                    return false;
                }

                event.preventDefault();
                var id = $(this).attr('data-id');

                $.ajax({
                    url: window.location.origin + '/student/delete/' + id,
                    type: 'DELETE',
                    data: {
                        id: id
                    },
                    success: function(response) {

                        Swal.fire(
                            'Remind!',
                            'Berhasil menghapus data!',
                            'success'
                        )
                        getData();
                    }
                });
                return false;
            });

        });
    </script>
@endpush
