@extends('front.front')

@section('main')
    <main class="px-3">
        <h1 id="header_title">Anulowanie subskrypcji.</h1>
        <div id="content">
            <p class="lead">Jesteś pewien, że chcesz anulować subskrypcję? Ominą Cię najnowsze promocje, wyprzedaże
                i
                wiele innych indywidualnych ofert dla naszych stałych klientów.</p>
            <p class="lead">
                <button class="btn btn-lg btn-secondary fw-bold border-white bg-white"
                    onclick="removeSubscription('{{ csrf_token() }}', '{{ $data['token'] }}')">Anuluj subskrypcje</button>
            </p>
        </div>
    </main>
@endsection

@push('css')
    <link href="{{ asset('templates/assets/dist/css/bootstrap.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('templates/cover/cover.css') }}" rel="stylesheet" />

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

    </style>
@endpush


@push('scripts')
    <script>
        function removeSubscription(csrf, token) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ url('anuluj') }}/' + token, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (this.readyState === XMLHttpRequest.DONE && this.status === 200) {
                    document.getElementById('header_title').innerHTML = xhr.responseText;
                    document.getElementById('content').innerHTML = '';
                }
            }
            xhr.send('_token=' + csrf + '&userToken=' + token);
        }
    </script>
@endpush
