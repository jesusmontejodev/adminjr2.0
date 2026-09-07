<div class="pv-panel">
    <h2 class="pv-panel-title">{{ __('Información de perfil') }}</h2>
    <p class="pv-panel-desc">{{ __("Actualiza tu nombre, correo y foto de perfil.") }}</p>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div x-data="{ preview: null }" class="pv-field">
            <label class="pv-label">{{ __('Foto de perfil') }}</label>

            <div class="pv-photo-row">
                <template x-if="preview">
                    <img :src="preview" class="pv-photo">
                </template>
                <template x-if="!preview">
                    @if ($user->profile_photo_url)
                        <img src="{{ $user->profile_photo_url }}" class="pv-photo">
                    @else
                        <div class="pv-photo-placeholder">{{ $user->iniciales }}</div>
                    @endif
                </template>

                <div>
                    <label for="photo" class="pv-file-label">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14M14 8h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Cambiar foto
                    </label>
                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        accept="image/*"
                        class="hidden"
                        @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                    >
                    <p class="pv-file-hint">JPG, PNG o GIF. Máximo 2MB.</p>

                    @if ($user->profile_photo_url)
                        <button
                            type="submit"
                            form="remove-photo-form"
                            class="pv-file-remove"
                            onclick="return confirm('¿Eliminar tu foto de perfil actual?')"
                        >
                            {{ __('Eliminar foto actual') }}
                        </button>
                    @endif
                </div>
            </div>
            @error('photo') <p class="pv-input-error">{{ $message }}</p> @enderror
        </div>

        <div class="pv-field">
            <label for="name" class="pv-label">{{ __('Nombre') }}</label>
            <input id="name" name="name" type="text" class="pv-input" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            @error('name') <p class="pv-input-error">{{ $message }}</p> @enderror
        </div>

        <div class="pv-field">
            <label for="email" class="pv-label">{{ __('Correo electrónico') }}</label>
            <input id="email" name="email" type="email" class="pv-input" value="{{ old('email', $user->email) }}" required autocomplete="username">
            @error('email') <p class="pv-input-error">{{ $message }}</p> @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="pv-verify-notice">
                    {{ __('Tu correo electrónico no está verificado.') }}
                    <button form="send-verification">{{ __('Reenviar el correo de verificación.') }}</button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="pv-verify-sent">{{ __('Se envió un nuevo enlace de verificación a tu correo.') }}</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="pv-form-actions">
            <button type="submit" class="pv-btn-primary">{{ __('Guardar') }}</button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="pv-saved-msg">{{ __('Guardado.') }}</p>
            @elseif (session('status') === 'profile-photo-removed')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="pv-saved-msg">{{ __('Foto eliminada.') }}</p>
            @endif
        </div>
    </form>

    <form id="remove-photo-form" method="post" action="{{ route('profile.photo.destroy') }}" class="hidden">
        @csrf
        @method('delete')
    </form>
</div>
