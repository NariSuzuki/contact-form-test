@extends('layouts.app')

@section('title', 'Contact Form')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('content')
<div class="contact-form__content">
    <div class="contact-form__heading">
        <h2>Contact</h2>
    </div>
    <form class="form" action="/confirm" method="post">
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">お名前</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content form__group-content--name">
                <div class="form__input--name">
                    <input type="text" id="last_name" name="last_name" placeholder="例:山田" value="{{ old('last_name', $contact['last_name'] ?? '') }}" />
                    <div class="form__error">
                        @error('last_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__input--name">
                    <input type="text" name="first_name" placeholder="例:太郎" value="{{ old('first_name', $contact['first_name'] ?? '') }}" />
                    <div class="form__error">
                        @error('first_name')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <span class="form__label--item">性別</span>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--radio">
                    <input type="radio" id="gender_male" name="gender" value="男性" {{ old('gender', $contact['gender'] ?? '') == '男性' ? 'checked' : '' }} />
                    <label for="gender_male">男性</label>

                    <input type="radio" id="gender_female" name="gender" value="女性" {{ old('gender', $contact['gender'] ?? '') == '女性' ? 'checked' : '' }} />
                    <label for="gender_female">女性</label>

                    <input type="radio" id="gender_other" name="gender" value="その他" {{ old('gender', $contact['gender'] ?? '') == 'その他' ? 'checked' : '' }} />
                    <label for="gender_other">その他</label>
                </div>
                <div class="form__error">
                    @error('gender')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label--item" for="email">メールアドレス</label>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="email" id="email" name="email" placeholder="例:test@example.com" value="{{ old('email', $contact['email'] ?? '') }}" />
                </div>
                <div class="form__error">
                    @error('email')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label--item" for="tel1">電話番号</label>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__group-content--tel">
                    <div class="form__input--tel">
                        <input type="tel" id="tel1" name="tel1" placeholder="080" value="{{ old('tel1', $contact['tel1'] ?? '') }}" />
                    </div>
                    <span class="tel-separator">-</span>
                    <div class="form__input--tel">
                        <input type="tel" name="tel2" placeholder="1234" value="{{ old('tel2', $contact['tel2'] ?? '') }}" />
                    </div>
                    <span class="tel-separator">-</span>
                    <div class="form__input--tel">
                        <input type="tel" name="tel3" placeholder="5678" value="{{ old('tel3', $contact['tel3'] ?? '') }}" />
                    </div>
                </div>
                <div class="form__error">
                    @error('tel1')
                    <span>{{ $message }}</span>
                    @enderror
                    @error('tel2')
                    <span>{{ $message }}</span>
                    @enderror
                    @error('tel3')
                    <span>{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label--item" for="address">住所</label>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" id="address" name="address" placeholder="例:東京都渋谷区千駄ヶ谷1-2-3" value="{{ old('address', $contact['address'] ?? '') }}" />
                </div>
                <div class="form__error">
                    @error('address')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label--item" for="building">建物名</label>
            </div>
            <div class="form__group-content">
                <div class="form__input--text">
                    <input type="text" id="building" name="building" placeholder="例:千駄ヶ谷マンション101" value="{{ old('building', $contact['building'] ?? '') }}" />
                </div>
                <div class="form__error">
                    @error('building')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group">
            <div class="form__group-title">
                <label class="form__label--item" for="category_id">お問い合わせの種類</label>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--select">
                    <select id="category_id" name="category_id">
                        <option value="" {{ !old('category_id', $contact['category_id'] ?? '') ? 'selected' : '' }} disabled>選択してください</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $contact['category_id'] ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $loop->iteration }}.{{ $category->content }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form__error">
                    @error('category_id')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__group form__group--last">
            <div class="form__group-title">
                <label class="form__label--item" for="content">お問い合わせ内容</label>
                <span class="form__label--required">※</span>
            </div>
            <div class="form__group-content">
                <div class="form__input--textarea">
                    <textarea id="content" name="content" placeholder="お問い合わせ内容をご記載ください">{{ old('content', $contact['content'] ?? '') }}</textarea>
                </div>
                <div class="form__error">
                    @error('content')
                    {{ $message }}
                    @enderror
                </div>
            </div>
        </div>

        <div class="form__button">
            <button class="form__button-submit" type="submit">確認画面</button>
        </div>
    </form>
</div>
@endsection