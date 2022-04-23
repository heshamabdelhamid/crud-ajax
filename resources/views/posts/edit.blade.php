@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header text-white bg-success"> update Post</div>
                    <div class="card-body">
                        <div class="mx-auto col col-md-8 center">
                            <div id="success_msg" class="alert alert-success alert-dismissible fade show"
                                style="display: none" role="alert">
                                <p>DONE </p>
                            </div>
                            <div class="input-group mb-3">
                                <form method="POST" id="updateFormData" action="" enctype="multipart/form-data">
                                    @csrf
                                    <div class="input-group mb-3">
                                        <input type="text" class=" mb-3 form-control" name="title" id="title"
                                            placeholder="Title" value=" {{ $post->title }} ">
                                            <input type="hidden" name="post_id" value="{{$post->id}}" >
                                            <small id="title_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- <input type="text" class=" mb-3 form-control" name="body" id="body"> --}}
                                    <div class="form-floating">
                                        <textarea class=" form-control" placeholder="Leave a comment here" name="body"
                                            id="floatingTextarea">{{ $post->body }}</textarea>
                                        <label for="floatingTextarea">body</label>
                                    </div>
                                    <small id="body_error" class="form-text text-danger"></small>
                                    <img style="width: 100px; height: 100px;"
                                        src="{{ asset('images/posts/' . $post->photo) }}" class="rounded" alt="">
                                    <br>
                                    <div class="input-group mb-3">
                                        <input type="file" class=" mb-3 form-control" name="photo" id="file" value="" multiple>
                                    </div>
                                    <small id="photo_error" class="form-text text-danger"></small>

                                    <div class="input-group mb-3">
                                        <button type="submit" class="btn btn-success mx-auto col col-sm-3"
                                            id="send">send</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
{{-- Create Post in AJAX --}}
@section('script')
    <script>
        $(document).on('click', '#send', function(e) {
            e.preventDefault();

                        $('#title_error').text('');
            $('#body_error').text('');
            $('#photo_error').text('');
            let formData = new FormData($('#updateFormData')[0]);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "{{ Route('post.update') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status === true) {
                        $('#success_msg').show();
                    }
                },
                error: function(reject) {
                    let response = $.parseJSON(reject.responseText);

                    $.each(response.errors, function(key, val) {
                        $("#" + key + "_error").text(val[0]);
                    });
                }
            });
        });
    </script>
@endsection
