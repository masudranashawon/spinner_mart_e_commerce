@extends('frontend.layouts.app')

@section('title', $page->title)

@section('content')
<!-- start wpo-page-title -->
<section class="wpo-page-title">
    <h2 class="d-none">Hide</h2>
    <div class="container">
        <div class="row">
            <div class="col col-xs-12">
                <div class="wpo-breadcumb-wrap">
                    <ol class="wpo-breadcumb-wrap">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li>{{ $page->title }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page-title -->

<!-- start page content -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 rounded p-4 p-md-5">
                    <h2 class="mb-4">{{ $page->title }}</h2>
                    <div class="dynamic-content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- end page content -->
@endsection
