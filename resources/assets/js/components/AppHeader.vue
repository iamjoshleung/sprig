<template>
  <div class="l-header">
    <div class="container">
        <div class="row">
            <div class="col-9">
                <a href="#" class="logo">
                    <span class="logo__front">枝</span>
                    <span class="logo__back">點</span>
                </a>
            </div>
            <div class="col-3">
                <div class="i-hamburger js-icon-burger" :class="{ active: show }" @click="!!show">
                    <div class="i-hamburger__line line1"></div>
                    <div class="i-hamburger__line line2"></div>
                    <div class="i-hamburger__line line3"></div>
                </div>
            </div>
            <nav class="nav nav-mobile js-nav-mobile" :class="{ active: show }">
                <ul class="nav-list nav-list--mobile">
                    <!-- <li>
                        <a href="{{ route('index') }}">首頁</a>
                    </li>
                    <li>
                        <a href="#">上傳資源</a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}">關於我們</a>
                    </li>
                    <li>
                        <a href="{{ route('feedback') }}">網站反饋</a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}">聯絡我們</a>
                    </li>
                    <li>
                        <a href="{{ route('service-policy') }}">服務政策</a>
                    </li>
                    <li>
                        <a href="{{ route('terms-of-service') }}">服務條款</a>
                    </li>
                    <li>
                        <a href="{{ route('copyright') }}">智慧財產權</a>
                    </li>
                     -->
                    <!-- <li>
                        <a href="{{ route('') }}">侵權撤除守則</a>
                    </li>  -->
                </ul>
            </nav>
        </div>
    </div>
</div>
</template>

<script>
export default {
  data() {
    return {
      show: false
    };
  }
};
</script>
