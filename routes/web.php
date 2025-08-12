<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Volt::route('links', 'links.index')->name('links.index');
    Volt::route('links/criar', 'links.form')->name('links.create');
    Volt::route('links/editar/{id}', 'links.form')->name('links.edit');

    Volt::route('qr-code', 'links.index')->name('qr-code.index');
    Volt::route('qr-code/criar', 'links.form')->name('qr-code.create');
    Volt::route('qr-code/editar/{id}', 'links.form')->name('qr-code.edit');

    Volt::route('usuarios', 'links.index')->name('usuarios.index');
    Volt::route('usuarios/criar', 'links.form')->name('usuarios.create');
    Volt::route('usuarios/editar/{id}', 'links.form')->name('usuarios.edit');
    
    Volt::route('gerador', 'gerador-qr-code')->name('gerador');

    Route::redirect('configuracoes', 'settings/profile');

    Volt::route('configuracoes/profile', 'settings.profile')->name('settings.profile');
    Volt::route('configuracoes/password', 'settings.password')->name('settings.password');
    Volt::route('configuracoes/appearance', 'settings.appearance')->name('settings.appearance');
});

require __DIR__.'/auth.php';
