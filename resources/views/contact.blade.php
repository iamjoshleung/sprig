@extends('layouts.master')

@section('main')
    <div class="l-contact">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-5 mr-auto ml-auto">
                        <h1>聯系我們</h1>
                        <p>如果你有任何跟我們聯系的需要，無論是業務合作或者是投訴，請填寫下面的表格，我們會盡快跟你聯系，謝謝。</p>
    
                        <div class="form mt-5">
                            <div class="form-group">
                                <label class="form-label" for="name">名字</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>      
                            <div class="form-group">
                                <label class="form-label" for="email">電郵地址</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp">
                                <small id="emailHelp" class="form-text text-muted">留下你的電郵地址方便我們進一步跟你聯系。</small>
                            </div>     
                            <div class="form-group">
                                <label class="form-label" for="comment">留言</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>   
                            <div class="form-group">
                                <button type="submit" class="button button-primary">提交</button>    
                            </div>                
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection