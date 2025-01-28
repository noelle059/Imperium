<!-- resources/views/contact.blade.php -->

<form action="/submit" method="POST">
    @csrf
    <input type="text" name="name" placeholder="Enter your name" required>
    <button type="submit">Submit</button>
</form>
