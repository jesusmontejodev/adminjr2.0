<x-guest-layout>

<div class="container" id="container">

 <!-- REGISTER PANEL -->
<div class="form-container sign-up">
<form method="POST" action="{{ route('register') }}" style="font-size:14px;">
@csrf

<!-- Logo -->
<img src="{{ asset('avaspace.svg') }}" style="height:32px;margin-bottom:6px;">

<h1 style="color:#ef4444;font-size:20px;margin-bottom:4px;">Admin Jr</h1>

<span style="font-size:13px;">
Controla tus ingresos, gastos
y finanzas fácilmente
</span>

<!-- Name -->
<x-input-label for="name" value="Nombre" class="login-label" style="font-size:12px;" />

<x-text-input
id="name"
class="login-input block w-full"
type="text"
name="name"
:value="old('name')"
required
autocomplete="name"
style="padding:8px;font-size:13px;" />

<x-input-error :messages="$errors->get('name')" />


<!-- Email -->
<x-input-label for="email" value="Correo Electrónico" class="login-label" style="font-size:12px;margin-top:6px;" />

<x-text-input
id="email"
class="login-input block w-full"
type="email"
name="email"
:value="old('email')"
required
autocomplete="username"
style="padding:8px;font-size:13px;" />

<x-input-error :messages="$errors->get('email')" />


<!-- Phone -->
<x-input-label for="phone" value="Teléfono (Opcional)" class="login-label" style="font-size:12px;margin-top:6px;" />

<div class="phone-group">

<select
id="country_code"
name="country_code"
class="login-input"
style="width:100px;padding:8px;font-size:13px;">

<option value="">Código</option>
<option value="+52">+52 México</option>
<option value="+1">+1 USA</option>
<option value="+34">+34 España</option>
<option value="other">Otro</option>

</select>

<x-text-input
id="phone_number"
class="login-input block w-full"
type="tel"
name="phone_number"
:value="old('phone_number')"
placeholder="5512345678"
style="padding:8px;font-size:13px;" />

</div>


<!-- Password -->
<x-input-label for="password" value="Contraseña" class="login-label" style="font-size:12px;margin-top:6px;" />

<x-text-input
id="password"
class="login-input block w-full"
type="password"
name="password"
required
autocomplete="new-password"
style="padding:8px;font-size:13px;" />

<x-input-error :messages="$errors->get('password')" />


<!-- Confirm Password -->
<x-input-label
for="password_confirmation"
value="Confirmar Contraseña"
class="login-label"
style="font-size:12px;margin-top:6px;" />

<x-text-input
id="password_confirmation"
class="login-input block w-full"
type="password"
name="password_confirmation"
required
autocomplete="new-password"
style="padding:8px;font-size:13px;" />

<x-input-error
:messages="$errors->get('password_confirmation')" />


<!-- Terms -->
<p style="font-size:11px;color:#9ca3af;text-align:center;margin-top:10px;">

Al registrarte aceptas nuestros

<a href="{{ route('aviso-de-privacidad') }}" style="color:#ef4444;">
Aviso de privacidad
</a>

y

<a href="{{ route('terminos') }}" style="color:#ef4444;">
Términos y condiciones
</a>

</p>


<!-- Actions -->
<div style="display:flex;justify-content:space-between;align-items:center;margin-top:10px;">

<a
href="{{ route('login') }}"
style="font-size:12px;color:#9ca3af;">
¿Ya tienes cuenta?
</a>

<x-primary-button class="login-btn" style="padding:8px 16px;font-size:13px;">
REGISTRARSE
</x-primary-button>

</div>

</form>
</div>


    <!-- LOGIN -->
    <div class="form-container sign-in">
        <form method="POST" action="{{ route('login') }}">
        @csrf

            <img src="{{ asset('avaspace.svg') }}" style="height:40px;margin-bottom:10px;">

            <h1>
                Bienvenida a
                <span style="color:#ef4444;">Admin Jr</span>
            </h1>

            <span>Inicia sesión para continuar</span>

            <!-- Email -->
            <input
                type="email"
                name="email"
                placeholder="Email"
                value="{{ old('email') }}"
                required
            >

            <!-- Password -->
            <input
                type="password"
                name="password"
                placeholder="Password"
                required
            >

            <!-- Remember -->
<div class="flex items-center gap-2 mt-2 text-sm text-gray-300">
    
    <input 
        type="checkbox" 
        name="remember"
        class="w-4 h-4 
               rounded 
               border-gray-500 
               bg-transparent
               text-red-600
               focus:ring-red-500">

    <label for="remember" class="cursor-pointer">
        Recordarme
    </label>

</div>

            <!-- Forgot -->
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">
                Forgot password?
            </a>
            @endif

            <button type="submit">
                LOG IN
            </button>

        </form>
    </div>


    <!-- PANEL ANIMACIÓN -->
    <div class="toggle-container">
        <div class="toggle">

            <div class="toggle-panel toggle-left">

                <h1>Bienvenida</h1>

                <p>
                    Inicia sesión para administrar
                    tus finanzas
                </p>

                <button class="toggle-btn" id="login">
                    Iniciar sesión
                </button>

            </div>

            <div class="toggle-panel toggle-right">

                <h1>Admin Jr</h1>

                <p>
                    La forma más fácil
                    de controlar tu dinero
                </p>

                <button class="toggle-btn" id="register">
                    Registrarse
                </button>

            </div>

        </div>
    </div>

</div>

<script>

const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});

</script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Montserrat',sans-serif;
}

body{
background:#000;
display:flex;
align-items:center;
justify-content:center;
height:100vh;
color:white;
}

/* CONTENEDOR */

.container{
background:#0f0f0f;
border-radius:20px;
border:1px solid rgba(255,0,0,0.15);
box-shadow:0 20px 60px rgba(0,0,0,0.9);
position:relative;
overflow:hidden;
width:850px;
max-width:100%;
min-height:520px;
}

/* TEXTOS */

.container h1{
font-size:26px;
margin-bottom:10px;
}

.container p{
font-size:14px;
opacity:0.85;
}

.container span{
font-size:12px;
opacity:0.7;
}

.container a{
color:#ff3b3b;
font-size:13px;
text-decoration:none;
}

/* BOTONES */

.container button{
background:linear-gradient(135deg,#ff0000,#ff2a2a,#ff0000);
color:white;
font-size:12px;
padding:12px 45px;
border:none;
border-radius:30px;
font-weight:600;
letter-spacing:1px;
text-transform:uppercase;
margin-top:15px;
cursor:pointer;
transition:0.3s;
}

.container button:hover{
transform:scale(1.05);
box-shadow:0 10px 25px rgba(255,0,0,0.45);
}

.container button.hidden{
background:transparent;
border:1px solid white;
}

/* FORMULARIOS */

.container form{
background:#0f0f0f;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
padding:0 50px;
height:100%;
}

.container input{
background:#161616;
border:1px solid rgba(255,255,255,0.08);
margin:8px 0;
padding:12px 15px;
font-size:13px;
border-radius:10px;
width:100%;
outline:none;
color:white;
}

.container input:focus{
border:1px solid #ff0000;
box-shadow:0 0 8px rgba(255,0,0,0.4);
}

/* CONTENEDORES DE FORM */

.form-container{
position:absolute;
top:0;
height:100%;
transition:all 0.6s ease-in-out;
}

.sign-in{
left:0;
width:50%;
z-index:2;
}

.container.active .sign-in{
transform:translateX(100%);
}

.sign-up{
left:0;
width:50%;
opacity:0;
z-index:1;
}

.container.active .sign-up{
transform:translateX(100%);
opacity:1;
z-index:5;
animation:move 0.6s;
}

@keyframes move{
0%,49.99%{
opacity:0;
z-index:1;
}
50%,100%{
opacity:1;
z-index:5;
}
}

/* ICONOS */

.social-icons{
margin:20px 0;
}

.social-icons a{
border:1px solid rgba(255,255,255,0.1);
border-radius:50%;
display:inline-flex;
justify-content:center;
align-items:center;
margin:0 5px;
width:40px;
height:40px;
color:white;
transition:0.3s;
}

.social-icons a:hover{
background:#ff0000;
}

/* PANEL ROJO DESLIZANTE */

.toggle-container{
position:absolute;
top:0;
left:50%;
width:50%;
height:100%;
overflow:hidden;
transition:all 0.6s ease-in-out;
border-radius:150px 0 0 100px;
z-index:1000;
}

.container.active .toggle-container{
transform:translateX(-100%);
border-radius:0 150px 100px 0;
}

.toggle{
background:linear-gradient(135deg,#8b0000,#ff0000,#8b0000);
color:white;
position:relative;
left:-100%;
height:100%;
width:200%;
transform:translateX(0);
transition:all 0.6s ease-in-out;
}

.container.active .toggle{
transform:translateX(50%);
}

.toggle-panel{
position:absolute;
width:50%;
height:100%;
display:flex;
align-items:center;
justify-content:center;
flex-direction:column;
padding:0 40px;
text-align:center;
top:0;
transition:all 0.6s ease-in-out;
}

.toggle-left{
transform:translateX(-200%);
}

.container.active .toggle-left{
transform:translateX(0);
}

.toggle-right{
right:0;
transform:translateX(0);
}

.container.active .toggle-right{
transform:translateX(200%);
}

.sign-up form{
    max-height: 520px;
    overflow-y: auto;
    padding-right: 10px;
}

//* ===== REGISTER COMPACTO ===== */

.form-container.sign-up form{
    padding: 25px 40px;
    font-size: 13px;
}

/* Logo */
.form-container.sign-up img{
    height: 30px;
    margin-bottom: 6px;
}

/* Título */
.form-container.sign-up h1{
    font-size: 20px;
    margin-bottom: 4px;
}

/* Texto descriptivo */
.form-container.sign-up span{
    font-size: 12px;
    display:block;
}

.form-container.sign-up p{
    font-size: 11px;
    margin: 4px 0 10px;
    color:#9ca3af;
}

/* Labels */
.login-label{
    font-size: 11px;
    margin-top: 6px;
    margin-bottom: 2px;
}

/* Inputs */
.login-input{
    padding:6px 10px;
    font-size:12px;
    border-radius:6px;
}

/* Espacio entre campos */
.form-container.sign-up .block{
    margin-bottom:4px;
}

/* Grupo teléfono */
.phone-group{
    display:flex;
    gap:6px;
    margin-top:3px;
}

#country_code{
    width:90px;
}

/* Error */
.form-container.sign-up .text-red-500{
    font-size:10px;
    margin-top:2px;
}

/* Terms */
.form-container.sign-up .terms{
    font-size:10px;
    text-align:center;
    margin-top:8px;
    color:#9ca3af;
}

/* Botón */
.login-btn{
    padding:7px 14px;
    font-size:12px;
}

/* Acciones */
.form-container.sign-up .actions{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-top:8px;
}

.form-container.sign-up .actions a{
    font-size:11px;
    color:#9ca3af;
}
</style>
</x-guest-layout>