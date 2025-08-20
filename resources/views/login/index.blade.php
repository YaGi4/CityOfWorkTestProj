@extends('layouts.app')

@section('title', 'Вход')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Вход в систему
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="inputEmail">Email</label>
                                <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Введите email">
                            </div>
                            <div class="form-group mb-4">
                                <label for="inputPassword">Пароль</label>
                                <input type="password" class="form-control" name="password" placeholder="Пароль">
                            </div>
                            <div class="form-group form-check mb-4">
                                <input type="checkbox" class="form-check-input" id="rememberCheck">
                                <label class="form-check-label" for="rememberCheck">Запомнить меня</label>
                            </div>
                            <button type="submit" class="btn btn-primary">Войти</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (session('error'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="loginToast" class="toast text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        </div>

        <script>
            const toastEl = document.getElementById('loginToast');
            const toast = new bootstrap.Toast(toastEl, { delay: 2000 });
            toast.show();
        </script>
    @endif

@endsection
