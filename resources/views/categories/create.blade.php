<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Create Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">


</head>

<body>

    <div class="row">
        <div class="col-md-6 offset-3" style="margin-top: 100px">
            <a class="btn btn-info mb-4" data-bs-toggle="modal" data-bs-target="#exampleModal">Add Category</a>
            <table class="table mt-4" id="category-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>





    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <form id="ajaxForm">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modal-title"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <span id="nameError" class="text-danger"></span>
                        </div>
                        <div class="form-group mb-1">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option disabled selected>Choose Option</option>
                                <option value="electronic">Electronic</option>
                            </select>
                            <span id="typeError" class="text-danger"></span>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="closeModal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveBtn"></button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>

    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#category-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: "{{ route('categories.index') }}",
                columns: [{
                        data: "id"
                    },
                    {
                        data: "name"
                    },
                    {
                        data: "type"
                    },
                    {
                        data: "action",
                        name: "action",
                        orderable: false,
                        searchable: false
                    },
                ]
            })

            $('#modal-title').html('Create Category')
            $('#saveBtn').html('Save Category')
            var form = $('#ajaxForm')[0]

            $('#saveBtn').click(function() {

                $('#nameError').html(" ")
                $('#typeError').html(" ")

                var formData = new FormData(form)

                $.ajax({
                    url: '{{ route('categories.store') }}',
                    method: 'POST',
                    processData: false,
                    contentType: false,
                    data: formData,

                    success: function(response) {

                        if (response.success) {
                            swal("Success", response.success, "success");
                        }

                        $('#closeModal').click()

                        $(".modal-body").each(function() {
                            var input = $(this).find('input');
                            var select = $(this).find('select');
                            input.val("");
                            select.prop("selectedIndex", 0);
                        })

                    },

                    error: function(error) {
                        if (error) {
                            $('#nameError').html(error.responseJSON.errors.name)
                            $('#typeError').html(error.responseJSON.errors.type)
                        }
                        console.log(error);
                    }
                })
            })
        })
    </script>

</body>

</html>
