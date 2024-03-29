@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    {{ $channel->name }}

                <a href="{{ route('channel.upload', $channel->id) }}">Upload Videos</a>
                </div>

                <div class="card-body">
                    @if ($channel->editable())
                        <form id="update-channel-form" action="{{ route('channels.update', $channel->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')
                    @endif
                        <div class="form-group row justify-content-center">
                            <div class="channel-avatar">
                                @if($channel->editable())
                                <div onclick="document.getElementById('image').click()" class="channel-avatar-overlay">
                                    <img src='https://cdn1.iconfinder.com/data/icons/facebook-ui/48/additional_icons-03-512.png' width="70%" title='Channel Uploda' />
                                </div>
                                @endif
                                <img src="{{ $channel->image() }}" alt="{{ $channel->name }}" title="{{ $channel->name }}">
                            </div>
                        </div>

                        <div class="form-group">
                                <h4 class="text-center">{{ $channel->name }}</h4>
                                <p class="text-center">
                                    {{ $channel->description }}
                                </p>
                                <div class="text-center">
                                    <subscribe-button :channel="{{ $channel }}" :initial-subscriptions="{{$channel->subscriptions}}" />
                                </div>

                        </div>

                        @if ($channel->editable())
                            <input onchange="document.getElementById('update-channel-form').submit()" style="display: none" type="file" name="image" id="image">

                            <div class="form-group">
                                <label for="name" class="form-control-label">Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ $channel->name }}">
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-control-label">Description</label>
                                <textarea name="description" id="description" class="form-control" rows="3" cols="3">{{ $channel->description }}</textarea>
                            </div>
                            @if ($errors->any())
                            <ul class="list-group mb-5">
                                @foreach ($errors->all() as $error)
                                <li class="text-danger list-group-item">
                                    {{ $error }}
                                </li>
                                @endforeach
                            </ul>
                            @endif

                            <button type="submit" class="btn btn-info">Update</button>

                        @endif
                    @if ($channel->editable())
                        </form>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    Videos
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($videos as $video)
                                <tr>
                                    <td>
                                        <img width="50px" height="50px" src="{{ $video->thumbnail }}" alt="{{ $video->title }}" title="{{ $video->title }}" />
                                    </td>
                                    <td>
                                        {{ $video->title }}
                                    </td>
                                    <td>
                                        {{ $video->views }}
                                    </td>
                                    <td>
                                        {{ $video->percentage ? 'Live' : 'Processing' }}
                                    </td>
                                    <td>
                                        @if ($video->percentage === 100)
                                            <a href="{{ route('videos.show', $video->id) }}" class="badge badge-primary">
                                                View
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row content-justify-center">
                        {{ $videos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
