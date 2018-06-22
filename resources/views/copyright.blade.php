@extends('layouts.master')

@section('main')
    <div class="l-copyright">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1>智慧財產權</h1>

                    <div class="mt-5">
                        <h2>涉嫌侵權通知 "須知"</h2>
                        <p>枝點 尊重他人的版權，並期望所有雲端服務使用者也是如此。我們會回應符合適用法律並適切呈報給我們的涉嫌侵權通知。如果您認為您的內容已被複製或構成侵犯版權的方式使用，請提供我們下列資訊：(i) 版權擁有人或已授權代表他們的物理或電子簽名; (ii) 聲稱受到侵權的版權品的鑑定; (iii) 聲稱被侵權或侵權活動主體的鑑定資料，以致將被刪除或將被禁用停用，並提供合理且充足的資訊讓我們可以找到資料包含例如連結URL; (iv) 您的聯繫資訊，包括您的地址，電話號碼與電子郵件信箱; (v) 一份您的聲明，聲明您有充分的理由相信，所投訴的物件使用未經版權擁有者，其代理人或法律的授權; 及(vi) 一份聲明，聲明該通知中的訊息是準確的，且在作偽證受處罰的前提下，您已被授權可代表版權擁有人。</p>
                        <div class="mt-5">
                            <a href="{{ route('feedback') }}" class="button button-secondary">您可由此提交通報給我們</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection