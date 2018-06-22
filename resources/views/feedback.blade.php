@extends('layouts.master')

@section('main')
    <div class="l-feedback">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5 mr-auto ml-auto">
                    {{-- <h1>網站反饋</h1>
                    <p>我們十分重視用戶體驗，如果你遇到網站系統問題，或者你對枝點有任何功能上的建議，請填寫下面的表格，我們將會一一審視。</p> --}}
                    <h1>聯系我們</h1>
                    <p>如果你有任何跟我們聯系的需要，無論是業務合作或者是投訴，請填寫下面的表格，我們會盡快跟你聯系，謝謝。</p>

                    <form-feedback></form-feedback>
                </div>
            </div>
        </div>
    </div>
@endsection