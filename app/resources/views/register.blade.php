<x-layout title="Register">
    <h1>Register</h1>

    <form action="{{ route('link.register') }}" method="POST">
        @csrf
        <label for="username">Enter your username:</label>
        <input type="text" id="username" name="username" value="{{ old('username') }}" required>
        @error('username') <p class="error">{{ $message }}</p> @enderror

        <label for="phone">Enter your best phone number:</label>
        <input type="tel" id="phone" name="phone" value="{{ old('phone', '+380') }}" autocomplete="tel" placeholder="+380121231212" required>
        @error('phone') <p class="error">{{ $message }}</p> @enderror

        <button type="submit">Register</button>
    </form>
</x-layout>
