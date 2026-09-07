<div class="pv-panel">
    <h2 class="pv-panel-title">{{ __('Cambiar contraseña') }}</h2>
    <p class="pv-panel-desc">{{ __('Usa una contraseña larga y aleatoria para mantener tu cuenta segura.') }}</p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="pv-field">
            <label for="update_password_current_password" class="pv-label">{{ __('Contraseña actual') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" class="pv-input" autocomplete="current-password">
            @error('current_password', 'updatePassword') <p class="pv-input-error">{{ $message }}</p> @enderror
        </div>

        <div class="pv-field">
            <label for="update_password_password" class="pv-label">{{ __('Nueva contraseña') }}</label>
            <input id="update_password_password" name="password" type="password" class="pv-input" autocomplete="new-password">
            @error('password', 'updatePassword') <p class="pv-input-error">{{ $message }}</p> @enderror
        </div>

        <div class="pv-field">
            <label for="update_password_password_confirmation" class="pv-label">{{ __('Confirmar contraseña') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="pv-input" autocomplete="new-password">
            @error('password_confirmation', 'updatePassword') <p class="pv-input-error">{{ $message }}</p> @enderror
        </div>

        <div class="pv-form-actions">
            <button type="submit" class="pv-btn-primary">{{ __('Guardar') }}</button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="pv-saved-msg">{{ __('Guardado.') }}</p>
            @endif
        </div>
    </form>
</div>
