<footer class="footer">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-9">
                &copy; {{ date('Y') }} <a href="{{ config('app.url') }}" target="_blank">{{ __(config('app.name')) }}</a> &mdash; {{ __(config('rb.SITE_DESCRIPTION')) }}
            </div>
        </div>
    </div>
</footer>