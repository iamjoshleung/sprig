<div class="l-header">
    <div class="container">
        <div class="row">
            <div class="col-3">
                <a href="{{ route('index') }}" class="logo">
                    <span class="logo__front">枝</span>
                    <span class="logo__back">點</span>
                </a>
            </div>
            <div class="col-6 d-flex align-items-center">
                <a href="{{ route('photosets.index') }}" class="h3 mb-0">男色圖集</a>
            </div>
            <div class="col-3">
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
                    {{-- <li>
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