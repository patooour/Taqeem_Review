<html>
<head>
    <link rel="stylesheet" href="{{asset('assets/product1/css/main.css')}}">
    <title>Samsung</title>
</head>
<body>
<div class="header" id="header">
    <div class="container">
        <img src="{{asset('assets/product1/img/logooo.jpg')}}" class="logo">
        <div>
            @if(Auth::check())
                <a href="#" class="log">Welcome {{\Illuminate\Support\Facades\Auth::user()->firstname}}
                    {{\Illuminate\Support\Facades\Auth::user()->lastname}}   </a>
                <a href="/logout" class="log">Log out </a>

            @else
                <a href="/login" class="log">Log in</a>
            @endif
                <a href="/">Category</a>
        </div>
    </div>
</div>

<h1>{{$brand->brand_name}}</h1>

<div class="gallery">

    @foreach($products as $product)

        @php
            $id = $product->image_id;
         $img = \App\Models\Image::find($id);
        @endphp
        <div class="father">
        <div class="front"><img src="{{$img->path}}"></div>
        <div class="back">
            <span>{{$product->product_name}}</span>

            <br><a href="/product/review/{{$product->id}}">Read More</a>
        </div>
    </div>
    @endforeach

</div>
<div class="footer"><p>scripted by amazon , noon , etc ...</p></div>

</body>
</html>
