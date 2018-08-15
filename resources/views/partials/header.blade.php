<div class="l-header">
    <div class="container">
        <div class="row">
            <div class="col-3 d-flex align-items-center">
                <h1 class="pr-4 mb-0">
                    <a href="{{ route('index') }}" class="logo">
                        <span class="logo__front">枝</span>
                        <span class="logo__back">點</span>
                    </a>
                </h1>
                <h2 class="h4 mb-0 d-none d-md-block">同志資源社區</h2>
            </div>
            <nav class="col-6 d-flex align-items-center l-header__desktop-nav">
                <a href="{{ route('photosets.index') }}" class="h3 btn btn-success btn-lg mb-0 mr-4"><i class="fas fa-camera"></i> 圖片</a>
                <a href="{{ route('videos.index') }}" class="h3 mb-0 btn btn-danger btn-lg"><i class="fas fa-fire"></i> 視頻</a>
            </nav>
            <div class="col-3 d-flex align-items-center">
                <div class="i-hamburger js-icon-burger">
                    <div class="i-hamburger__line line1"></div>
                    <div class="i-hamburger__line line2"></div>
                    <div class="i-hamburger__line line3"></div>
                </div>
            </div>
            <nav class="nav nav-mobile js-nav-mobile">
                <ul class="nav-list nav-list--mobile">
                    <li>
                        <a href="{{ route('index') }}">首頁</a>
                    </li>
                    <li>
                        <a href="#" data-toggle="modal" data-target="#exampleModalCenter">上傳資源</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">關於我們</a>
                    </li>
                    <li>
                        <a href="{{ route('feedback') }}">聯系我們</a>
                    </li>
                    {{--
                    <li>
                        <a href="{{ route('contact') }}">聯絡我們</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('service-policy') }}">服務政策</a>
                    </li>
                    <li>
                        <a href="{{ route('terms-of-service') }}">服務條款</a>
                    </li>
                    <li>
                        <a href="{{ route('copyright') }}">智慧財產權</a>
                    </li>
                    {{--
                    <li>
                        <a href="{{ route('') }}">侵權撤除守則</a>
                    </li> --}}
                </ul>
            </nav>
        </div>
    </div>
</div>

<file-upload-modal></file-upload-modal>