<div class="pv-panel pv-panel--danger">
    <h2 class="pv-panel-title">{{ __('Eliminar cuenta') }}</h2>
    <p class="pv-panel-desc">{{ __('Una vez que se elimine tu cuenta, todos sus recursos y datos se borrarán permanentemente. Antes de continuar, descarga cualquier información que quieras conservar.') }}</p>

    <button
        type="button"
        class="pv-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Eliminar cuenta') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="pv-modal-body">
            @csrf
            @method('delete')

            <h2>{{ __('¿Seguro que quieres eliminar tu cuenta?') }}</h2>
            <p>{{ __('Una vez eliminada, todos sus recursos y datos se borrarán permanentemente. Ingresa tu contraseña para confirmar que quieres eliminar tu cuenta.') }}</p>

            <div class="pv-field" style="margin-top: 18px;">
                <label for="password" class="sr-only">{{ __('Contraseña') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    class="pv-input"
                    placeholder="{{ __('Contraseña') }}"
                >
                @error('password', 'userDeletion') <p class="pv-input-error">{{ $message }}</p> @enderror
            </div>

            <div class="pv-modal-actions">
                <button type="button" class="pv-btn-secondary" x-on:click="$dispatch('close')">
                    {{ __('Cancelar') }}
                </button>
                <button type="submit" class="pv-btn-danger">
                    {{ __('Eliminar cuenta') }}
                </button>
            </div>
        </form>
    </x-modal>
</div>
