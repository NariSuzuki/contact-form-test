<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inika:wght@400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/admin">
                FashionablyLate
            </a>
            <div class="header__nav">
                <form class="form" form action="/logout" method="post">
                    @csrf
                    <button type="submit" class="header__link">logout</button>
                </form>
            </div>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <div class="admin-heading">
                <h2>Admin</h2>
            </div>

            <div class="search-section">
                <form class="search-form" method="GET" action="/admin">
                    <div class="search-form__inputs">
                        <input type="text" name="search" placeholder="名前やメールアドレスを入力してください" class="search-input" value="{{ request('search') }}">
                        
                        <div class="search-select-wrapper">
                            <select name="gender" class="search-select">
                                <option value="" {{ request('gender') === null ? 'selected' : '' }}>性別</option>
                                <option value="all" {{ request('gender') === 'all' ? 'selected' : '' }}>全て</option>
                                <option value="1" {{ request('gender') == '1' ? 'selected' : '' }}>男性</option>
                                <option value="2" {{ request('gender') == '2' ? 'selected' : '' }}>女性</option>
                                <option value="3" {{ request('gender') == '3' ? 'selected' : '' }}>その他</option>
                            </select>
                        </div>

                        <div class="search-select-wrapper">
                            <select name="category_id" class="search-select">
                                <option value="">お問い合わせの種類</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->content }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <input type="date" name="date" class="search-date" value="{{ request('date') }}">

                        <button type="submit" class="search-button">検索</button>
                        <a href="/admin" class="reset-button">リセット</a>
                    </div>
                </form>
            </div>

            <div class="export-pagination-container">
                <div class="export-section">
                    <form method="GET" action="{{ route('admin.export') }}">
                        <input type="hidden" name="search" value="{{ request('search') }}">
                        <input type="hidden" name="gender" value="{{ request('gender') }}">
                        <input type="hidden" name="category_id" value="{{ request('category_id') }}">
                        <input type="hidden" name="date" value="{{ request('date') }}">
                    
                        <button type="submit" class="export-button">エクスポート</button>
                    </form>
                </div>

                <div class="pagination-top">
                    @if ($contacts->onFirstPage())
                        <span class="page-button disabled">&lt;</span>
                    @else
                        <a href="{{ $contacts->appends(request()->query())->previousPageUrl() }}" class="page-button">&lt;</a>
                    @endif

                    @foreach ($contacts->appends(request()->query())->getUrlRange(1, $contacts->lastPage()) as $page => $url)
                        <a href="{{ $url }}" class="page-button {{ $page == $contacts->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                    @endforeach

                    @if ($contacts->hasMorePages())
                        <a href="{{ $contacts->appends(request()->query())->nextPageUrl() }}" class="page-button">&gt;</a>
                    @else
                        <span class="page-button disabled">&gt;</span>
                    @endif
                </div>
            </div>

<div class="contacts-table">
    <table>
        <thead>
            <tr>
                <th>お名前</th>
                <th>性別</th>
                <th>メールアドレス</th>
                <th>お問い合わせの種類</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
            <tr>
                <td>{{ $contact->last_name }}{{ $contact->first_name }}</td>
                <td>{{ $contact->gender_text }}</td>
                <td>{{ $contact->email }}</td>
                <td>{{ $contact->category->content }}</td>
                <td>
                    <a href="#modal-{{ $contact->id }}" class="detail-button">詳細</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; padding: 30px;">お問い合わせデータがありません</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@foreach($contacts as $contact)
<div id="modal-{{ $contact->id }}" class="modal">
    <a href="" class="modal-overlay"></a>
    <div class="modal-content">
        <a href="" class="modal-close">&times;</a>
        <div class="modal-body">
            <table class="modal-table">
                <tr>
                    <th>お名前</th>
                    <td>{{ $contact->last_name }} {{ $contact->first_name }}</td>
                </tr>
                <tr>
                    <th>性別</th>
                    <td>{{ $contact->gender_text }}</td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td>{{ $contact->email }}</td>
                </tr>
                <tr>
                    <th>電話番号</th>
                    <td>{{ $contact->tel }}</td>
                </tr>
                <tr>
                    <th>住所</th>
                    <td>{{ $contact->address }}</td>
                </tr>
                <tr>
                    <th>建物名</th>
                    <td>{{ $contact->building ?? '' }}</td>
                </tr>
                <tr>
                    <th>お問い合わせの種類</th>
                    <td>{{ $contact->category->content }}</td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td class="modal-detail">{{ $contact->detail }}</td>
                </tr>
            </table>
            <div class="modal-footer">
                <form method="POST" action="/admin/contacts/{{ $contact->id }}" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="modal-delete-button">削除</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
</body>

</html>