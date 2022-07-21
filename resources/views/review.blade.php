<html>
<head>

    <link rel="stylesheet" href="{{asset('assets/reveiw1/css/main.css')}}">
    <link rel="stylesheet" href="{{asset('assets/reveiw1/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/reveiw1/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/reveiw1/css/bootstrap.min.css')}}">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: arial;
        }

        .star-rating form {
            display: none;
        }

        .star-rating .thanks-msg {
            display: none;
            font-size: 20px;
            margin: 40px auto;
            color: #4caf50;
            background-color: rgba(76, 175, 80, 0.1411764705882353);
            padding: 8px 20px;
            border-left: 3px solid #4caf50;
            border-radius: 20px;
        }

        .star-rating input {
            display: none;
        }

        .star-rating {
            margin: 50px auto;
            display: table;
            width: 350px;
        }

        .star-rating label {
            padding: 10px;
            float: right;
            font-size: 44px;
            color: #eee;
        }

        .star-rating input:not(:checked) ~ label:hover,
        .star-rating input:not(:checked) ~ label:hover ~ label {
            color: #ffc107;
        }

        .star-rating input:checked ~ label {
            color: #ffc107;
        }

        .star-rating form .rating-reaction:before {
            width: 100%;
            float: left;
            color: #ffc107;
        }

        .star-rating #rating-1:checked ~ form .rating-reaction:before {
            content: "I hate it";
        }

        .star-rating #rating-2:checked ~ form .rating-reaction:before {
            content: "I don't like it";
        }

        .star-rating #rating-3:checked ~ form .rating-reaction:before {
            content: "It is good";
        }

        .star-rating #rating-4:checked ~ form .rating-reaction:before {
            content: "I like it";
        }

        .star-rating #rating-5:checked ~ form .rating-reaction:before {
            content: "I love it";
        }

        .star-rating input:checked ~ form {
            border-top: 1px solid #ddd;
            width: 100%;
            padding-top: 15px;
            margin-top: 15px;
            display: inline-block;
        }

        .star-rating form .rating-reaction {
            font-size: 24px;
            float: left;
            text-transform: capitalize;
        }

        .star-rating form .submit-rating {
            border: none;
            outline: none;
            background: #795548;
            color: #ffc107;
            font-size: 18px;
            border-radius: 4px;
            padding: 5px 15px;
            cursor: pointer;
            float: right;
        }

        form .submit-rating:hover {
            background-color: #333;
        }
    </style>

</head>
<body>
<script src="{{asset('assets/reveiw1/js/jquery-3.5.1.min.js')}}"></script>
<div class="header" id="header">
    <div class="container">
        <img src="{{asset('assets/reveiw1/imgs/logooo.jpg')}}" class="logo">
        <div>
            @if(Auth::check())
                <a href="#" class="log">Welcome {{\Illuminate\Support\Facades\Auth::user()->firstname}}
                    {{\Illuminate\Support\Facades\Auth::user()->lastname}}</a>
                <a href="/logout" class="log">Log out</a>

            @else
                <a href="/login" class="log">Log in</a>
            @endif
            <a href="/">Category</a>
        </div>
    </div>
</div>
<div class="desc">

    <div class="image">
        <img src="{{$img->path}}">
    </div>

    <div class="description">
        <span class="">{{$product->product_name}} </span>
        <span> </span>
        <span> </span>
        <span class="des"> description : {{$product->description}}
                </span>

    </div>
</div>
<div class="reviews-container text-center">
    <h2>Reviews</h2>

    @foreach($present as $k=> $percent)
        <div class="review text-center align-items-center justify-content-center">
            <span class="icon-container">{{$k + 1}} <i class="filled fa fa-star"></i></span>
            <div class="progress">
                <div class="progress-done" data-done="{{$percent}}"></div>
            </div>
            <span class="percent">{{$percent}}%</span>
        </div>
    @endforeach

</div>


<div class="rev">
    <h1 class="review-word">Reviews</h1>
    @foreach($reviews as $k => $review)
        <div class=amazing-reviews>

            <blockquote class="block">
                <header>

            <span data-rating=5>

                @for ($i = 0; $i < $review->stars; $i++)
                    <i class="filled fa fa-star"></i>
                @endfor

            </span>

                    <span>{{$review->Date}}</span>


                </header>
                <p>{{$review->Review}}</p>
            </blockquote>


        </div>
    @endforeach
</div>
<div class="popup1">
    <div class="inner1">

        <form autocomplete="off" method="POST" action="/product/review/{{$product->id}}">
            @csrf
            <h2>{{$product->product_name}}</h2>

            <input type="hidden" name="id" placeholder="Full Name" value="{{$product->id}}" id="id">


            <div class="group">
                <input type="text" name="Review" placeholder="Review" id="Review">
                <label for="Review" name="Review"> Review </label>
            </div>


            <div class="rating rating2"><!--
		--><a href="#5" title="Give 5 stars"><input type="radio" id="star5" name="star" value="5">★</a><!--
		--><a href="#4" title="Give 4 stars"><input type="radio" id="star4" name="star" value="4">★</a><!--
		--><a href="#3" title="Give 3 stars"><input type="radio" id="star3" name="star" value="3">★</a><!--
		--><a href="#2" title="Give 2 stars"><input type="radio" id="star2" name="star" value="2">★</a><!--
		--><a href="#1" title="Give 1 star"><input type="radio"  id="star1"  name="star" value="1">★</a>
            </div>


            <div class="group">

                <br><br><br>
                <button class="add">add Review</button>
            </div>

            <button>X</button>
        </form>

    </div>
</div>


<div class="add-button">
    <button class="add">Add Review</button>
</div>
<br><br><br>

<script src="{{asset('assets/reveiw1/js/main.js')}}"></script>

<script>
    $(".add").click(function () {
        $(".popup1").fadeIn(400);
    })
    $(".popup1").click(function () {
        $(this).fadeOut(400);
    })
    $(".popup1 .inner1").click(function (e) {
        e.stopPropagation();
    })
    $(".popup1 button").click(function () {
        $(".popup1").fadeOut(400);
    })


    const btn = document.querySelector(".submit-rating");
    const thanksmsg = document.querySelector(".thanks-msg");
    const starRating = document.querySelector(".star-input");
    // Success msg show/hide
    btn.onclick = () => {
        starRating.style.display = "none";
        thanksmsg.style.display = "table";
        return false;
    };


</script>
</body>

</html>
