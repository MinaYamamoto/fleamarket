<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/sell.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <main>
        <div class="sell__title">
            <h2 class="sell__heading">商品の出品</h2>
        </div>
        <div class="sell">
            <form action="/sell" enctype="multipart/form-data" method="post">
                @csrf
                <div class="sell__img">
                    <div class="form-group__content-img" id="imagePreview" hidden>
                        <img id="sellImage" class="sell__img"></img>
                    </div>
                    <div class="sell__img-ttl">
                        <label class="sell__img-heading">商品画像</label>
                    </div>
                    <div class="sell__line">
                        <div class="sell__img-update">
                            <label for="file-input" class="sell__file-input">画像を選択する</label>
                                <input type="file" id ="file-input" class="sell__file" multiple onchange="previewImage(event)" value="{{ Session::get('image') }}" name="image"/>
                        </div>
                    </div>
                    <div class="form__error">
                        @error('image')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="item__detail">
                    <div class="item__detail-ttl">
                        <h2 class="item__detail-heading">商品の詳細</h2>
                    </div>
                    <hr>
                    <div class="item__detail-group">
                        <div class="item__detail-ttl">
                            <label class="item__detail-label">カテゴリー</label>
                        </div>
                        <div class="item__detail-input">
                            <select class="item__detail-select" name="category_content_id">
                                <option value="">カテゴリーを選択してください</option>
                                @foreach ($category_contents as $category_content)
                                    <option value="{{ $category_content->id }}" {{old('category_content_id') == $category_content['id']? "selected" : "";}}>{{ $category_content->category->name }} > {{$category_content->content->name}}</option>
                                @endforeach
                            </select>
                            <div class="form__error">
                                @error('category_content_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        <div class="item__detail-ttl">
                            <label class="item__detail-label">商品の状態</label>
                        </div>
                        <div class="item__detail-input">
                            <select class="item__detail-select" name="condition_id">
                                <option value="">商品の状態を選択してください</option>
                                @foreach($conditions as $condition)
                                <option value="{{$condition['id']}}" {{old('condition_id') == $condition['id']? "selected" : "";}}>{{$condition['name']}}</option>
                                @endforeach
                            </select>
                            <div class="form__error">
                                @error('condition_id')
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="item__explanation">
                    <div class="item__explanation-ttl">
                        <h2 class="item__explanation-heading">商品名と説明</h2>
                    </div>
                    <hr>
                    <div class="item__explanation-group">
                        <div class="item__explanation-ttl">
                            <label class="item__explanation-label">商品名</label>
                        </div>
                        <div class="item__explanation-input">
                            <input type="text" class="item__name-txt" name="name" value="{{old('name')}}">
                        </div>
                        <div class="form__error">
                            @error('name')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="item__explanation-ttl">
                            <label class="item__explanation-label">ブランド名</label>
                        </div>
                        <div class="item__explanation-input">
                            <input type="text" class="item__name-txt" name="brand_name" value="{{old('brand_name')}}">
                        </div>
                        <div class="form__error">
                            @error('brand_name')
                            {{ $message }}
                            @enderror
                        </div>
                        <div class="item__explanation-ttl">
                            <label class="item__explanation-label">商品の説明</label>
                        </div>
                        <div class="item__explanation-input">
                            <textarea class="item__explanation-txt" name="explanation" cols="50" rows="8">{{old('explanation')}}</textarea>
                        </div>
                        <div class="form__error">
                            @error('explanation')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="item__price">
                    <div class="item__price-ttl">
                        <h2 class="item__price-heading">販売価格</h2>
                    </div>
                    <hr>
                    <div class="item__price-group">
                        <div class="item__price-ttl">
                            <label class="item__price-label">販売価格</label>
                        </div>
                        <div class="item__price-input">
                            <input type="number" class="item__price-txt" name="price" value="{{old('price')}}">
                        </div>
                    </div>
                    <div class="form__error">
                        @error('price')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">出品する</button>
                    <input type="hidden" name="user_id" value="{{optional(auth()->user())->id}}"/>
                </div>
            </form>
        </div>
        <script src="{{ mix('js/sell.js')}}"></script>
    </main>
</body>

</html>