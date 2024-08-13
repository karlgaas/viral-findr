@extends('layouts.app')

@section('content')
  @if (isset($data) && !empty($data))
    <div class="w-full mb-4 bg-success border-solid border text-white rounded p-3 text-sm">
      <p>Due to high number of signups. We are limiting number of posts displayed in free searches to 40 most recent
        posts.
        If you need results to have more than 40 recent posts, please subscribe to a paid plan
      </p>
    </div>
  @endif
  <h1 class="text-2xl mb-8">Search by username</h1>
  <div id="search-form" class="bg-white shadow-lg rounded w-full p-3">
    <form action="{{ route('instagram-data') }}" method="POST">
      @csrf
      <div class="w-full mb-3">
        <div class="flex items-center border-b border-b-2 border-purple-800 py-2 mb-1"><input type="text"
            required="required" placeholder="@username" aria-label="Username" name="username"
            class="text-sm appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2
  leading-tight focus:outline-none">
          <button class="flex-shrink-0 bg-purple-800 hover:bg-purple-700 text-sm text-white py-2 px-3 rounded">
            Search
          </button>
        </div>
      </div>
    </form>
  </div>
  @if (isset($data) && !empty($data))
    <div class="row">
      @foreach ($data as $item)
        @if (isset($item['displayUrl']))
          <div class="col-4 mb-3">
            <div class="card shadow-lg">
              @if (isset($item['videoUrl']))
                <!-- Video Card -->
                <div class="ratio ratio-16x9">
                  <video class="w-100" controls>
                    <source src="{{ $item['videoUrl'] }}" type="video/mp4">
                    Your browser does not support the video tag.
                  </video>
                </div>
              @else
                <!-- Image Card -->
                @php
                  $image = file_get_contents(isset($item['displayUrl']) ? $item['displayUrl'] : '');
                  $imageData = base64_encode($image);
                @endphp
                <div class="position-relative">
                  <img class="w-100" height="auto" src="data:image/jpeg;base64,{{ $imageData }}" alt="Image">
                  <a href="{{ isset($item['videoUrl']) ? $item['videoUrl'] : '#' }}" class="position-absolute top-50 start-50 translate-middle btn btn-danger btn-lg rounded-circle">
                    <i class="fa fa-play text-white"></i>
                  </a>
                </div>
              @endif
              <div class="card-body bg-white">
                <p class="text-xs">
                  <span class="mr-3"><i class="fa fa-heart" style="color: rgb(242, 71, 88);"></i>
                    {{ isset($item['likesCount']) ? $item['likesCount'] : '' }}
                  </span>
                  <span class="mr-3"><i class="fa fa-comments"></i>
                    {{ isset($item['commentsCount']) ? $item['commentsCount'] : '' }}
                  </span>
                  <span class="mr-3"><i class="fa fa-eye"></i>
                    {{ isset($item['videoViewCount']) ? $item['videoViewCount'] : '' }}
                  </span>
                </p>
                <div class="py-2">
                  <a href="{{ isset($item['url']) ? $item['url'] : '#' }}" target="_blank" class="text-blue-500 underline text-xs">View on Instagram</a> &nbsp;
                  <a href="#" class="text-blue-500 text-xs mr-2"><i class="fa fa-clipboard"></i></a> 
                  <a href="{{ isset($item['videoUrl']) ? $item['videoUrl'] : '#' }}" target="_blank" class="text-blue-500 underline text-xs mr-2">Download</a>
                </div>
              </div>
            </div>
          </div>
        @endif
      @endforeach
    </div>
  @endif
@endsection
