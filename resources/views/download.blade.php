@extends('layouts.master')

@section('main')
    <div class="l-download pageHeroBottom">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <download-steps :file="{{ json_encode($file) }}"></download-steps>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="l-download--ads-copy">
                        <h4 class="mb-2">Ads</h4>
                        <p>‘Radical’ cloud services transforming Philippines IT outsourcing market. The IT outsourcing market in the Philippines is in the midst of a fundamental shift caused by cloud services that are key to the growth of outsourcing, hosting, and managed services.
                            According to the International Data Corporation (IDC), total outsourcing services revenues in the Philippines surpassed US$300 million in 2017, increasing just 8.2 percent from the year before.
                            The local IT outsourcing market underwent a 3.5 percent decline from 2016 which IDC has put down to the ‘radical change and cannibalisation’ of cloud-based models of outsourcing involving infrastructure as a service (IaaS) and software as a service (SaaS), an evolving cost structure, and significant shifts in the competitor environment.
                            It is a tumultuous time for the market, as IDC believes the IT outsourcing market is adapting to the implementation of cloud services with players applying different strategies that range from cloud-centric to hybrid IT to push to the top of this market.
                             “Currently, the traditional outsourcing service providers have been pressured because of the increased shift to cloud providers. More traditional services providers are expected to include new delivery structures to accommodate end users that require services such as cloud, automation, and security solutions,” says IDC Philippines services senior market analyst Alon Anthony Rejano. 
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts-after')
    {!! NoCaptcha::renderJs() !!}
@endpush
