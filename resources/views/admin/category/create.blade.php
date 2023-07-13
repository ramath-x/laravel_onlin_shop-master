@extends('admin.layout.app')

@section('content')
    <!-- Main content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid my-2">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Category</h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="categories.html" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <form action="" method="post" id="categoryForm" name="categoryForm">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        placeholder="Name">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="slug">Slug</label>
                                    <input type="text" name="slug" id="slug" class="form-control"
                                        placeholder="Slug">
                                    <p></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status">Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Block</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="pb-5 pt-3">
                    <button type="submit" class="btn btn-primary">Create</button>
                    <a href="#" class="btn btn-outline-dark ml-3">Cancel</a>
                </div>
                {{-- /.card-body --}}
            </form>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customJs')
    <script>
        $('#categoryForm').submit(function(event) {
            event.preventDefault();
            var element = $(this);
            $.ajax({
                type: 'POST',
                url: '{{ route('categories.store') }}',
                dataType: 'json',
                data: element.serializeArray(),
                success: function(response) {

                    if (response['status'] == true) {
                        $('#name').addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors['name']);

                        $('#slug').addClass('is-invalid').siblings('p')
                            .addClass('invalid-feedback')
                            .html(errors['slug']);
                    } else {
                        var errors = response['errors'];
                        if (errors['name']) {
                            $('#name').addClass('is-invalid').siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['name']);
                        } else {
                            $('#name').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }

                        if (errors['slug']) {
                            $('#slug').addClass('is-invalid').siblings('p')
                                .addClass('invalid-feedback')
                                .html(errors['slug']);
                        } else {
                            $('#slug').removeClass('is-invalid')
                                .siblings('p')
                                .removeClass('invalid-feedback').html('');
                        }
                        if (errors['status']) {
                            $('#status').addClass('is-invalid');

                        }
                    }

                },
                error: function(jqXHR, exeption) {
                    console.log("Something went wrong");
                    console.log("jqXHR: " + jqXHR);
                }
            });

        });




        // $('name').change(function() {
        //     var element = $(this);
        //     $.ajax({
        //         url: '{{ route('categories.getSlug') }}',
        //         type: 'get', // Change the request method to POST
        //         dataType: 'json',
        //         data: {
        //             name: element.val()
        //         }, // Pass the name as data
        //         success: function(response) {
        //             if (response['status'] == true) {
        //                 $('#slug').val(response['slug']);
        //             }
        //         },
        //         error: function(xhr, status, error) {
        //             // Handle any errors here
        //         }
        //     });
        // });
    </script>
@endsection
