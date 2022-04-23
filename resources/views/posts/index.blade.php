@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <table class="table table-dark">
                    <thead>
                        <th class="table-active">id</th>
                        <th>title</th>
                        <th class="table-active">body</th>
                        <th>image</th>
                        <th class="table-active">action</th>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr class="row{{ $post->id }}">
                                <th scope="row"> {{ $post->id }} </th>
                                <td class=""> {{ $post->title }} </td>
                                <td> {{ $post->body }} </td>
                                <td class="">
                                    @if ($post->photo)
                                        <img style="width: 100px; height: 100px;"
                                            src="{{ asset('images/posts/' . $post->photo) }}" class="rounded">
                                        <input class="photo" type="hidden" name="photo"
                                            value="{{ $post->photo }}">
                                    @elseif($post->photo == null)
                                        <p>No photo</p>
                                        <input class="photo" type="hidden" name="photo" value="{{null}}">
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('post.edit', $post->id) }}" class="btn btn-success">update</a>
                                    <a post_id="{{ $post->id }}" class="delet-post btn btn-danger">delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- {{ $posts->links() }} --}}
@endsection

{{-- Delete Post in AJAX --}}
@section('script')
    <script>
        $(document).on('click', '.delet-post', function(e) {

            e.preventDefault();

            let post_id = $(this).attr('post_id');
            // let photo = $("input[name='photo']").val();

            $.ajax({
                type: "POST",
                url: "{{ Route('post.delete') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'id': post_id,
                    // 'photo': photo,
                },
                success: function(data) {
                    if (data.status === true) {
                        $('#success_msg').show();
                        $('.row' + data.id).remove();
                    }
                },
                error: function(reject) {

                }
            });
        });
    </script>
@endsection
