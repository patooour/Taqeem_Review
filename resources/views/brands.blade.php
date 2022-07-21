<html>
<head>
    <link rel="stylesheet" href="{{asset('assets/brand1/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/brand1/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/brand1/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/brand1/css/bootstrap.min.css')}}">
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
<div class="brand mt-5">
    <h1>{{$category->category_name}}</h1>
    <div class="brands">
        <div class="row">

            @foreach($brands as $brand)
            <div class="col-sm-6 col-md-4 col-lg-3">
                <div class="box mb-3 phone" data-work="Smart Phones">
                    <span><a href="/product/{{$brand->id}}">{{$brand->brand_name}}</a></span>
                </div>
            </div>
            @endforeach


        </div>
    </div>
</div>
<div class="related">
    <h1>Most Related</h1>
    <div class="most-related">
        <div class="row">

            @foreach($products as $k => $product)


                <div class="box col-lg-3">

                <a href="/product/review/{{$product->id}}"><img src="{{$imgPath[$k]}}"></a>
                <span>{{$product->product_name}}</span>


            </div>

            @endforeach

        </div>
    </div>
    <br><br><br><div class="footer"><p>scripted by amazon , noon , etc ...</p></div>
</div>

<script src="{{asset('assets/brand1/js/main.js')}}"></script>


</body>
</html>

