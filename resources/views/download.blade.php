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
                        <p>Fujitsu Enhances Cloud Services Portfolio to Support the Digital Transformation of Customer Businesses. Fujitsu today announces enhancements to its existing portfolio of cloud services. Under these service enhancements, Fujitsu will offer cloud services with strengthened functionality to promote migration of mission critical systems to the multi-cloud, and will realize the hybrid IT environments needed by customer businesses. Moreover, Fujitsu will also expand its collaborations with top-tier cloud vendors, and will strengthen its multi-cloud services to provide integration and operation of multiple cloud services, offering rapid build out and high quality operations of diverse ICT environments. This will enable Fujitsu to provide cloud services tailor-made to the business of respective customers, and offer robust support for their digital transformation. 
                            Based on Fujitsu's proven track record in operating cloud platform-based systems for over 10 years, both its own and for customers, from June 29, 2018 it will steadily roll out and start to provide cloud services with strengthened functionality for the migration of mission critical systems to the cloud, so as to provide hybrid IT environments suited to customers' businesses. Being first made available in Japan, the newly offered bare metal server service, which simplifies the deployment of physical servers from a customer's portal site, enables customers to deploy OS and applications suited to their existing on-premises environments. 
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
