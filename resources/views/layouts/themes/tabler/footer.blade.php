<footer class="footer footer-transparent d-print-none py-3">
    <div class="container-xl">
        <div class="row text-center align-items-center flex-row-reverse">
            <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        <span class="text-secondary small">Theme: Tabler (Modern SaaS)</span>
                    </li>
                </ul>
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item">
                        &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="link-secondary">{{ config('app.name') }}</a>. All rights reserved.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
